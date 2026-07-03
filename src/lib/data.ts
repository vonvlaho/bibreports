import { readFileSync, readdirSync } from 'node:fs';
import path from 'node:path';
import { XMLParser } from 'fast-xml-parser';

export type Report = {
  id: number;
  title: string;
  year: number;
  editor: string;
  publisher: string;
  cover: string;
  entryIds: number[];
};

export type EntryPerson = {
  personId: number;
  role: string;
};

export type Entry = {
  id: number;
  entryNo: string;
  reportId: number;
  reportYear: number;
  fullTitle: string;
  title: string;
  type: string;
  journal: string;
  publisher: string;
  extent: string;
  org: string;
  startingYear: string;
  finishingYear: string;
  publicationYear: string;
  abstract: string;
  people: EntryPerson[];
  placeIds: number[];
  keywordIds: number[];
};

export type Keyword = {
  id: number;
  name: string;
  entryIds: number[];
};

export type Person = {
  id: number;
  familyName: string;
  givenName: string;
  entries: EntryPersonReference[];
};

export type EntryPersonReference = {
  entryId: number;
  role: string;
};

export type Place = {
  id: number;
  name: string;
  entryIds: number[];
};

export type AnalyticsRow = {
  id: number;
  name: string;
  total: number;
  years: Record<number, number>;
};

const parser = new XMLParser({
  ignoreAttributes: false,
  parseTagValue: false,
  trimValues: true,
});

const dataDir = path.resolve('database/data');

const clean = (value: unknown): string => {
  if (value === null || value === undefined || typeof value === 'object') {
    return '';
  }

  return String(value).replace(/\s+/g, ' ').trim();
};

const asArray = <T>(value: T | T[] | undefined | null): T[] => {
  if (value === undefined || value === null) {
    return [];
  }

  return Array.isArray(value) ? value : [value];
};

const sortByName = <T extends { name: string }>(items: T[]): T[] =>
  [...items].sort((a, b) => a.name.localeCompare(b.name, 'de'));

const unique = <T>(items: T[]): T[] => [...new Set(items)];

const roleLabels: Record<string, string> = {
  author: 'Autor*in',
  editor: 'Herausgeber*in',
  contributor: 'Beitragende*r',
};

const reportsById = new Map<number, Report>();
const entriesById = new Map<number, Entry>();
const keywordsById = new Map<number, Keyword>();
const peopleById = new Map<number, Person>();
const placesById = new Map<number, Place>();

const keywordByName = new Map<string, Keyword>();
const personByKey = new Map<string, Person>();
const placeByName = new Map<string, Place>();

let nextReportId = 1;
let nextEntryId = 1;
let nextKeywordId = 1;
let nextPersonId = 1;
let nextPlaceId = 1;

const getPerson = (sourcePerson: Record<string, unknown>): Person | null => {
  const familyName = clean(sourcePerson.familyName);
  const givenName = clean(sourcePerson.givenName);

  if (!familyName && !givenName) {
    return null;
  }

  const key = `${familyName}\u0000${givenName}`;
  const existing = personByKey.get(key);
  if (existing) {
    return existing;
  }

  const person: Person = {
    id: nextPersonId++,
    familyName,
    givenName,
    entries: [],
  };

  personByKey.set(key, person);
  peopleById.set(person.id, person);
  return person;
};

const getPlace = (name: string): Place | null => {
  const placeName = clean(name);
  if (!placeName) {
    return null;
  }

  const existing = placeByName.get(placeName);
  if (existing) {
    return existing;
  }

  const place: Place = {
    id: nextPlaceId++,
    name: placeName,
    entryIds: [],
  };

  placeByName.set(placeName, place);
  placesById.set(place.id, place);
  return place;
};

const getKeyword = (name: string): Keyword | null => {
  const keywordName = clean(name);
  if (!keywordName) {
    return null;
  }

  const existing = keywordByName.get(keywordName);
  if (existing) {
    return existing;
  }

  const keyword: Keyword = {
    id: nextKeywordId++,
    name: keywordName,
    entryIds: [],
  };

  keywordByName.set(keywordName, keyword);
  keywordsById.set(keyword.id, keyword);
  return keyword;
};

const sourceFiles = readdirSync(dataDir)
  .filter((file) => file.endsWith('.xml'))
  .sort((a, b) => a.localeCompare(b, 'de'));

for (const file of sourceFiles) {
  const xml = readFileSync(path.join(dataDir, file), 'utf8').replace(/^\uFEFF/, '');
  const source = parser.parse(xml).report as Record<string, unknown>;
  const reportId = nextReportId++;
  const reportYear = Number(clean(source.year));
  const report: Report = {
    id: reportId,
    title: clean(source.title),
    year: reportYear,
    editor: clean(source.editor),
    publisher: clean(source.publisher),
    cover: clean(source.cover),
    entryIds: [],
  };

  reportsById.set(report.id, report);

  const entriesByNo = new Map<string, Entry>();
  for (const sourceEntry of asArray(source.entry as Record<string, unknown> | Record<string, unknown>[])) {
    const entry: Entry = {
      id: nextEntryId++,
      entryNo: clean(sourceEntry.entryNo),
      reportId: report.id,
      reportYear,
      fullTitle: clean(sourceEntry.fullTitle),
      title: clean(sourceEntry.title),
      // Tag-Tippfehler in den XML-Quellen (tyoe, publicationYaer, finshedYear,
      // inishedYear, finishedYear) werden hier abgefangen; siehe docs/research-qa.md.
      type: clean(sourceEntry.type ?? sourceEntry.tyoe),
      journal: clean(sourceEntry.journal),
      publisher: clean(sourceEntry.publisher),
      extent: clean(sourceEntry.extent),
      org: clean(sourceEntry.org),
      startingYear: clean(sourceEntry.startingYear),
      finishingYear: clean(
        sourceEntry.finishingYear ?? sourceEntry.finishedYear ?? sourceEntry.finshedYear ?? sourceEntry.inishedYear,
      ),
      publicationYear: clean(sourceEntry.publicationYear ?? sourceEntry.publicationYaer),
      abstract: clean(sourceEntry.abstract),
      people: [],
      placeIds: [],
      keywordIds: [],
    };

    const people = (sourceEntry.people ?? {}) as Record<string, unknown>;
    for (const [role, sourcePeople] of Object.entries(people)) {
      for (const sourcePerson of asArray(sourcePeople as Record<string, unknown> | Record<string, unknown>[])) {
        const person = getPerson(sourcePerson);
        if (!person) {
          continue;
        }

        entry.people.push({ personId: person.id, role });
        person.entries.push({ entryId: entry.id, role });
      }
    }

    const places = (sourceEntry.places ?? {}) as Record<string, unknown>;
    for (const sourcePlace of asArray(places.place as string | string[])) {
      const place = getPlace(sourcePlace);
      if (!place) {
        continue;
      }

      entry.placeIds.push(place.id);
      place.entryIds.push(entry.id);
    }

    entriesById.set(entry.id, entry);
    entriesByNo.set(entry.entryNo, entry);
    report.entryIds.push(entry.id);
  }

  const register = (source.register ?? {}) as Record<string, unknown>;
  for (const sourceKeyword of asArray(register.registerEntry as Record<string, unknown> | Record<string, unknown>[])) {
    const keyword = getKeyword(clean(sourceKeyword.item));
    if (!keyword) {
      continue;
    }

    for (const entryNo of asArray(sourceKeyword.ref as string | string[])) {
      const entry = entriesByNo.get(clean(entryNo));
      if (!entry || entry.keywordIds.includes(keyword.id)) {
        continue;
      }

      entry.keywordIds.push(keyword.id);
      keyword.entryIds.push(entry.id);
    }
  }
}

export const reports = [...reportsById.values()].sort((a, b) => a.year - b.year);
export const entries = [...entriesById.values()];
export const keywords = sortByName([...keywordsById.values()]);
export const people = [...peopleById.values()].sort((a, b) => {
  const family = a.familyName.localeCompare(b.familyName, 'de');
  return family === 0 ? a.givenName.localeCompare(b.givenName, 'de') : family;
});
export const places = sortByName([...placesById.values()]);
export const years = reports.map((report) => report.year);

export const findReport = (id: number): Report | undefined => reportsById.get(id);
export const findEntry = (id: number): Entry | undefined => entriesById.get(id);
export const findKeyword = (id: number): Keyword | undefined => keywordsById.get(id);
export const findPerson = (id: number): Person | undefined => peopleById.get(id);
export const findPlace = (id: number): Place | undefined => placesById.get(id);

export const getReportEntries = (report: Report): Entry[] =>
  report.entryIds.map((id) => entriesById.get(id)).filter((entry): entry is Entry => Boolean(entry));

export const getEntryPeople = (entry: Entry): Array<Person & { role: string; roleLabel: string }> =>
  entry.people
    .map(({ personId, role }) => {
      const person = peopleById.get(personId);
      return person ? { ...person, role, roleLabel: roleLabels[role] ?? role } : null;
    })
    .filter((person): person is Person & { role: string; roleLabel: string } => Boolean(person));

export const getEntryPlaces = (entry: Entry): Place[] =>
  entry.placeIds.map((id) => placesById.get(id)).filter((place): place is Place => Boolean(place));

export const getEntryKeywords = (entry: Entry): Keyword[] =>
  entry.keywordIds.map((id) => keywordsById.get(id)).filter((keyword): keyword is Keyword => Boolean(keyword));

export const getEntries = (entryIds: number[]): Entry[] =>
  unique(entryIds).map((id) => entriesById.get(id)).filter((entry): entry is Entry => Boolean(entry));

export const groupEntriesByYear = (entryIds: number[]): Array<{ year: number; entries: Entry[] }> =>
  years
    .map((year) => ({
      year,
      entries: getEntries(entryIds).filter((entry) => entry.reportYear === year),
    }))
    .filter((group) => group.entries.length > 0);

export const groupPersonEntriesByRole = (person: Person): Array<{ role: string; roleLabel: string; entries: Entry[] }> => {
  const grouped = new Map<string, number[]>();

  for (const reference of person.entries) {
    grouped.set(reference.role, [...(grouped.get(reference.role) ?? []), reference.entryId]);
  }

  return [...grouped.entries()].map(([role, entryIds]) => ({
    role,
    roleLabel: roleLabels[role] ?? role,
    entries: getEntries(entryIds),
  }));
};

const analyticsRow = (id: number, name: string, entryIds: number[]): AnalyticsRow => {
  const relatedEntries = getEntries(entryIds);
  const counts = Object.fromEntries(
    years.map((year) => [year, relatedEntries.filter((entry) => entry.reportYear === year).length]),
  ) as Record<number, number>;

  return {
    id,
    name,
    total: relatedEntries.length,
    years: counts,
  };
};

export const keywordRows = (): AnalyticsRow[] =>
  [...keywordsById.values()]
    .map((keyword) => analyticsRow(keyword.id, keyword.name, keyword.entryIds))
    .sort((a, b) => b.total - a.total || a.name.localeCompare(b.name, 'de'));

export const personRows = (): AnalyticsRow[] =>
  [...peopleById.values()]
    .map((person) =>
      analyticsRow(person.id, [person.givenName, person.familyName].filter(Boolean).join(' '), person.entries.map((entry) => entry.entryId)),
    )
    .sort((a, b) => b.total - a.total || a.name.localeCompare(b.name, 'de'));

export const placeRows = (): AnalyticsRow[] =>
  [...placesById.values()]
    .map((place) => analyticsRow(place.id, place.name, place.entryIds))
    .sort((a, b) => b.total - a.total || a.name.localeCompare(b.name, 'de'));

const scopedAnalyticsRow = (id: number, name: string, entryIds: number[], scope: Set<number>): AnalyticsRow | null => {
  const scopedEntryIds = unique(entryIds).filter((entryId) => scope.has(entryId));
  if (scopedEntryIds.length === 0) {
    return null;
  }

  return analyticsRow(id, name, scopedEntryIds);
};

export const relatedRowsForEntries = (entryIds: number[], kind: 'keywords' | 'people' | 'places'): AnalyticsRow[] => {
  const scope = new Set(getEntries(entryIds).map((entry) => entry.id));

  if (kind === 'keywords') {
    return [...keywordsById.values()]
      .map((keyword) => scopedAnalyticsRow(keyword.id, keyword.name, keyword.entryIds, scope))
      .filter((row): row is AnalyticsRow => Boolean(row))
      .sort((a, b) => b.total - a.total || a.name.localeCompare(b.name, 'de'));
  }

  if (kind === 'people') {
    return [...peopleById.values()]
      .map((person) =>
        scopedAnalyticsRow(
          person.id,
          [person.givenName, person.familyName].filter(Boolean).join(' '),
          person.entries.map((entry) => entry.entryId),
          scope,
        ),
      )
      .filter((row): row is AnalyticsRow => Boolean(row))
      .sort((a, b) => b.total - a.total || a.name.localeCompare(b.name, 'de'));
  }

  return [...placesById.values()]
    .map((place) => scopedAnalyticsRow(place.id, place.name, place.entryIds, scope))
    .filter((row): row is AnalyticsRow => Boolean(row))
    .sort((a, b) => b.total - a.total || a.name.localeCompare(b.name, 'de'));
};
