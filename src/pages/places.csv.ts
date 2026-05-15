import { csvResponse, placesCsv } from '../lib/csv';

export const prerender = true;

export function GET() {
  return csvResponse(placesCsv());
}
