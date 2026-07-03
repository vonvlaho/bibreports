import { entries, getEntryKeywords, getEntryPeople, getEntryPlaces } from './data';

type CsvValue = string | number | undefined | null;

const escapeCsvValue = (value: CsvValue): string => {
  const text = value === undefined || value === null ? '' : String(value);
  return /[",\n\r]/.test(text) ? `"${text.replace(/"/g, '""')}"` : text;
};

export const rowsToCsv = (rows: CsvValue[][]): string => `${rows.map((row) => row.map(escapeCsvValue).join(',')).join('\n')}\n`;

export const csvResponse = (body: string): Response =>
  new Response(body, {
    headers: {
      'Content-Type': 'text/csv; charset=utf-8',
    },
  });

export const bibliographyCsv = (): string =>
  rowsToCsv([
    ['Bericht', 'Eintrag', 'Titel', 'Typ', 'Publikationsjahr', 'Zeitschrift', 'Verlag', 'Umfang', 'Institution', 'Beginn', 'Ende'],
    ...entries.map((entry) => [
      entry.reportYear,
      entry.entryNo,
      entry.fullTitle,
      entry.type,
      entry.publicationYear,
      entry.journal,
      entry.publisher,
      entry.extent,
      entry.org,
      entry.startingYear,
      entry.finishingYear,
    ]),
  ]);

export const keywordCsv = (): string =>
  rowsToCsv([
    ['Bericht', 'Eintrag', 'Titel', 'Registerbegriff'],
    ...entries.flatMap((entry) => getEntryKeywords(entry).map((keyword) => [entry.reportYear, entry.entryNo, entry.fullTitle, keyword.name])),
  ]);

export const peopleCsv = (): string =>
  rowsToCsv([
    ['Bericht', 'Eintrag', 'Titel', 'Person', 'Rolle'],
    ...entries.flatMap((entry) =>
      getEntryPeople(entry).map((person) => [
        entry.reportYear,
        entry.entryNo,
        entry.fullTitle,
        [person.givenName, person.familyName].filter(Boolean).join(' '),
        person.role,
      ]),
    ),
  ]);

export const placesCsv = (): string =>
  rowsToCsv([
    ['Bericht', 'Eintrag', 'Titel', 'Ort'],
    ...entries.flatMap((entry) => getEntryPlaces(entry).map((place) => [entry.reportYear, entry.entryNo, entry.fullTitle, place.name])),
  ]);
