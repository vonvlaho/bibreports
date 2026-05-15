import { csvResponse, keywordCsv } from '../lib/csv';

export const prerender = true;

export function GET() {
  return csvResponse(keywordCsv());
}
