# Research QA Notes

These notes collect content and taxonomy issues found during researcher-oriented QA of the static Astro migration. They are not automatic corrections; each item should be reviewed against the source scans or original bibliographic material before changing XML data.

## Place Register Anomalies

- `Volksmusik` appears as a publication place in `database/data/1969.xml`, entry `59`, but the title shows it as the journal: `In: Volksmusik. 14 (1969), H. 10/11`.
- `Reclam` appears as a publication place in `database/data/1966.xml`, entry `126`, but the title uses it as publisher: `Leipzig: Reclam 1966`.
- `Rozhled` appears as a publication place in `database/data/1972.xml`, entry `130`, but the title uses it as journal: `In: Rozhled, 22 (1972)`.
- `Stephan` appears as a publication place in `database/data/1975.xml`, entry `316`, but the title uses it as part of the text author name `Stephan Hermlin`.
- `Halloe` appears as a publication place in `database/data/1974.xml`, entry `F 26`, and likely means `Halle`.
- `Leuwen` appears as a publication place in `database/data/1970.xml`, entry `199`, and likely means `Leuven`.

## XML Tag Anomalies

The build-time parser (`src/lib/data.ts`) tolerates these variants, so fixing them in the XML is optional; if fixed, the parser fallbacks can be removed.

- Misspelled tags: `<finshedYear>` in `database/data/1971.xml`, entry `F 67`; `<inishedYear>` in `database/data/1972.xml`, entry `F 94`; `<publicationYaer>` in `database/data/1973.xml`, entry `55`; `<tyoe>` in `database/data/1975.xml`, entry `F 4`.
- `<finishedYear>` (73 occurrences) and `<finishingYear>` (577 occurrences) coexist across most volumes for the same concept; the parser merges both.
- Fields present in the XML but intentionally not modelled or displayed: `<sameAs>` (226, alternate titles/series notes), `<event>` (29), `<date>` (2).
- Since the static migration UI update, `<journal>`, `<extent>`, entry-level `<publisher>`, `<org>`, and project durations (`<startingYear>`/`<finishingYear>`) are parsed, shown on entry pages, and included in `berichte.csv`. They were previously discarded.

## Type Taxonomy Inconsistencies

`<type>` values are not normalized in the source data, e.g. `Diss.` / `Diss. A` / `Diss. B`, `Ms.` vs. `Ms. ` (trailing space), truncated `Forschungsauftrag u`, and combined forms like `Forschungsarbeit und Dissertation` vs. `Forschungsarbeit und Diss.`. Any normalization should be decided against the printed sources before touching the XML.

## OCR/Text Anomalies

- `musikinstrumentenkundllche` appears in `database/data/1966.xml`, entry `1`; likely `musikinstrumentenkundliche`.
- `Hundert Jähre` appears in `database/data/1967.xml`, entry `32`; likely `Hundert Jahre`.
- `Katholieke üniversiteit` appears in `database/data/1970.xml`, entry `199`; likely `Katholieke Universiteit`.
- `197O` appears in `database/data/1971.xml`, entry `244`; likely `1970`.
