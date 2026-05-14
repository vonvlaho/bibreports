import { defineConfig } from 'astro/config';
import sitemap from '@astrojs/sitemap';

export default defineConfig({
  site: 'https://bibreports.de',
  output: 'static',
  integrations: [sitemap()],
});
