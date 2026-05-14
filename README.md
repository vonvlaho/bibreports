## About Bibreports

Bibreports ist a web application for displaying and analyzing bibliographical data.

## Static migration

The `feature/static-astro-migration` branch contains the static-first migration target. The production app is generated with Astro from the XML files in `database/data` and can be hosted as static files on Cloudflare Pages.

```sh
npm install
npm run check
npm run build
npm run dev
```

The build writes static output to `dist` and creates the Pagefind search index in `dist/pagefind`.

## License

Bibreports is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
