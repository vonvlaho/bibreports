import { defineConfig } from 'astro/config';
import sitemap from '@astrojs/sitemap';

export default defineConfig({
  site: 'https://musikwissenschaft-ddr.de',
  output: 'static',
  trailingSlash: 'never',
  integrations: [sitemap({ filter: (page) => !new URL(page).pathname.startsWith('/data/') })],
});
