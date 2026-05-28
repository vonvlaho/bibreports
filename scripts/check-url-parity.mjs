import { existsSync, readdirSync, readFileSync } from 'node:fs';
import path from 'node:path';

const root = process.cwd();
const distDir = path.join(root, 'dist');
const vercelConfigPath = path.join(root, 'vercel.json');

const fail = (message, details = []) => {
  console.error(message);
  for (const detail of details.slice(0, 50)) {
    console.error(`- ${detail}`);
  }
  if (details.length > 50) {
    console.error(`...and ${details.length - 50} more`);
  }
  process.exit(1);
};

if (!existsSync(distDir)) {
  fail('Missing dist directory. Run npm run build before npm run check:urls.');
}

const forbiddenBuildArtifacts = [
  'index.php',
  '.htaccess',
  '_headers',
  '_redirects',
  'mix-manifest.json',
  'js/app.js',
  'css/app.css',
];
const presentForbiddenArtifacts = forbiddenBuildArtifacts.filter((artifact) => existsSync(path.join(distDir, artifact)));
if (presentForbiddenArtifacts.length > 0) {
  fail('Static build contains obsolete Laravel deployment artifacts.', presentForbiddenArtifacts);
}

const vercelConfig = JSON.parse(readFileSync(vercelConfigPath, 'utf8'));
const requiredRedirects = new Map([
  ['/keywords/download', '/keywords.csv'],
  ['/people/download', '/people.csv'],
  ['/places/download', '/places.csv'],
]);

const configErrors = [];
if (vercelConfig.outputDirectory !== 'dist') {
  configErrors.push('vercel.json outputDirectory must be "dist".');
}
if (vercelConfig.cleanUrls !== true) {
  configErrors.push('vercel.json cleanUrls must be true.');
}
if (vercelConfig.trailingSlash !== false) {
  configErrors.push('vercel.json trailingSlash must be false.');
}

const redirects = new Map((vercelConfig.redirects ?? []).map((redirect) => [redirect.source, redirect]));
for (const [source, destination] of requiredRedirects.entries()) {
  const redirect = redirects.get(source);
  if (!redirect || redirect.destination !== destination || redirect.permanent !== true) {
    configErrors.push(`${source} must permanently redirect to ${destination}.`);
  }
}

if (configErrors.length > 0) {
  fail('Vercel URL compatibility config is incomplete.', configErrors);
}

const numericDirs = (segment) => {
  const dir = path.join(distDir, segment);
  if (!existsSync(dir)) {
    return [];
  }

  return readdirSync(dir, { withFileTypes: true })
    .filter((entry) => entry.isDirectory() && /^\d+$/.test(entry.name))
    .map((entry) => entry.name)
    .sort((a, b) => Number(a) - Number(b));
};

const fileForLegacyUrl = (url) => {
  if (url === '/') {
    return path.join(distDir, 'index.html');
  }

  if (url.endsWith('.csv')) {
    return path.join(distDir, url.slice(1));
  }

  return path.join(distDir, url.slice(1), 'index.html');
};

const expectedUrls = new Set([
  '/',
  '/reports',
  '/analytics',
  '/about-data',
  '/keywords',
  '/people',
  '/places',
  '/search',
  '/data/keywords',
  '/data/people',
  '/data/places',
  '/berichte.csv',
  '/keywords.csv',
  '/people.csv',
  '/places.csv',
]);

for (const id of numericDirs('reports')) {
  expectedUrls.add(`/reports/${id}`);
  expectedUrls.add(`/reports/${id}/keywords`);
  expectedUrls.add(`/reports/${id}/people`);
  expectedUrls.add(`/reports/${id}/places`);
}

for (const id of numericDirs('entries')) {
  expectedUrls.add(`/entries/${id}`);
}

for (const id of numericDirs('keywords')) {
  expectedUrls.add(`/keywords/${id}`);
}

for (const id of numericDirs('people')) {
  expectedUrls.add(`/people/${id}`);
}

for (const id of numericDirs('places')) {
  expectedUrls.add(`/places/${id}`);
}

for (const id of numericDirs('data/keyword')) {
  expectedUrls.add(`/data/keyword/${id}`);
}

for (const id of numericDirs('data/person')) {
  expectedUrls.add(`/data/person/${id}`);
}

for (const id of numericDirs('data/place')) {
  expectedUrls.add(`/data/place/${id}`);
}

const missing = [...expectedUrls].filter((url) => !existsSync(fileForLegacyUrl(url)));
if (missing.length > 0) {
  fail('Legacy public URLs are missing generated static files.', missing);
}

const htmlFiles = [];
const collectHtmlFiles = (dir) => {
  for (const entry of readdirSync(dir, { withFileTypes: true })) {
    const entryPath = path.join(dir, entry.name);
    if (entry.isDirectory()) {
      collectHtmlFiles(entryPath);
    } else if (entry.name.endsWith('.html')) {
      htmlFiles.push(entryPath);
    }
  }
};
collectHtmlFiles(distDir);

const trailingSlashLinks = [];
const hrefPattern = /href="([^"]+)"/g;
for (const htmlFile of htmlFiles) {
  const html = readFileSync(htmlFile, 'utf8');
  for (const match of html.matchAll(hrefPattern)) {
    const href = match[1];
    if (!href.startsWith('/') || href.startsWith('//')) {
      continue;
    }

    const pathname = href.split(/[?#]/)[0];
    const lastSegment = pathname.split('/').at(-1) ?? '';
    const hasFileExtension = /\.[a-z0-9]+$/i.test(lastSegment);
    if (pathname !== '/' && pathname.endsWith('/') && !hasFileExtension) {
      trailingSlashLinks.push(`${path.relative(root, htmlFile)} -> ${href}`);
    }
  }
}

if (trailingSlashLinks.length > 0) {
  fail('Internal links must use canonical no-trailing-slash URLs.', trailingSlashLinks);
}

console.log(`URL parity OK: ${expectedUrls.size} legacy URLs backed by static output.`);
