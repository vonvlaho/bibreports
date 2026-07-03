export const normalizeInitial = (value: string): string => {
  const initial = value.trim().charAt(0).toLocaleUpperCase('de');
  const replacements: Record<string, string> = { Ä: 'A', Ö: 'O', Ü: 'U' };
  return replacements[initial] ?? initial;
};

export const createAnchorFactory = (prefix: string): ((value: string) => string | undefined) => {
  const seenInitials = new Set<string>();

  return (value: string) => {
    const initial = normalizeInitial(value);
    if (!/^[A-Z]$/.test(initial) || seenInitials.has(initial)) {
      return undefined;
    }
    seenInitials.add(initial);
    return `${prefix}-${initial}`;
  };
};

export const personDisplayName = (person: { familyName: string; givenName: string }): string =>
  `${person.familyName} ${person.givenName}`.trim();
