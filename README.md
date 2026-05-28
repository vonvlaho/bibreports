## About Musikwissenschaft in der DDR

Musikwissenschaft in der DDR is a static research application for displaying and analyzing bibliographical data from the reports on musicological work in the GDR, 1966-1975.

## Static migration

The `feature/static-astro-migration` branch contains the static-first migration target. The production app is generated with Astro from the XML files in `database/data` and can be hosted as static files on Vercel.

```sh
npm install
npm run check
npm run build
npm run check:urls
npm run dev
```

The build writes static output to `dist` and creates the Pagefind search index in `dist/pagefind`.

Legacy Laravel-style public URLs without trailing slashes are treated as canonical and must remain resolvable, for example `/entries/4178`. `npm run check:urls` verifies that the generated static build backs those URLs and that legacy CSV download paths are configured in `vercel.json`.

## License

Bibreports is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
