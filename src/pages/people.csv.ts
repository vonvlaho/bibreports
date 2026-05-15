import { csvResponse, peopleCsv } from '../lib/csv';

export const prerender = true;

export function GET() {
  return csvResponse(peopleCsv());
}
