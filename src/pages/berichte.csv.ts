import { bibliographyCsv, csvResponse } from '../lib/csv';

export const prerender = true;

export function GET() {
  return csvResponse(bibliographyCsv());
}
