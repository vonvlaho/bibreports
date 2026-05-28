# Musikwissenschaft in der DDR

Static research application for bibliographic data from the reports on
musicological work in the GDR, 1966-1975.

The public site is available at https://musikwissenschaft-ddr.de.

## Data and Method

The site is generated from XML source files in `database/data`. These files
represent retrodigitized printed reports that were processed with OCR,
manually corrected, and transformed into a pragmatic bibliographic data model.
They are not diplomatic transcriptions of the printed originals.

The generated static site provides:

- report-year views and entry detail pages
- keyword, person, and publication-place registers
- Pagefind full-text search
- analytics tables
- CSV exports for entries, keywords, people, and places

Known OCR and taxonomy issues are documented in `docs/research-qa.md` and
should be reviewed against the source material before changing XML data.

## Development

```sh
npm install
npm run check
npm run build
npm run check:urls
npm run dev
```

The build writes static output to `dist` and creates the Pagefind search index
in `dist/pagefind`.

Legacy public URLs without trailing slashes are canonical and must remain
resolvable, for example `/entries/4178`. `npm run check:urls` verifies that the
generated static build backs those URLs and that legacy CSV download paths are
configured in `vercel.json`.

## Deployment

The production application is a static Astro build deployed on Vercel. The
Vercel production branch is `main`, the build command is `npm run build`, and
the output directory is `dist`.

The former Laravel application is preserved in the Git branch
`archive/laravel-final` and the Git tag `laravel-final`.

## Citation

Recommended citation:

Frederic von Vlahovits, "Musikwissenschaft in der DDR", version v1.0.0, 2026,
https://musikwissenschaft-ddr.de.

Machine-readable citation metadata is available in `CITATION.cff`.

## Licenses

The application source code is licensed under the MIT License. See `LICENSE`.

The bibliographic data, XML source files, CSV exports, and public website
content are licensed under Creative Commons Attribution 4.0 International
(CC BY 4.0), unless otherwise noted. See `LICENSE-CONTENT.md`.
