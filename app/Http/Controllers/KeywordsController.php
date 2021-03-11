<?php

namespace App\Http\Controllers;

use App\Keyword;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\Builder;

class KeywordsController extends Controller
{
    public function store(Request $request) {

        $searchTerm = $request->input('search');

        $keywords = Keyword::has('entries')
            ->where('name', 'LIKE', "%{$searchTerm}%")
            ->orderBy('name')
            ->paginate('15')
            ->appends(['search' => $searchTerm]);

        return view('keywords.store', ['keywords' => $keywords]);
    }

    public function data() {

        $keywords = Keyword::withCount([
            'entries as total'
        ])->orderBy('total', 'desc')->get();

        $keywordsByCount = [];

        foreach ($keywords as $keyword) {
            $keywordsByCount[] = [
                'id' => $keyword->id,
                'name' => $keyword->name,
                'total' => $keyword->total/*,
                '1966' => $keyword->entries->where('report_id', '1')->count(),
                '1967' => $keyword->entries->where('report_id', '2')->count(),
                '1968' => $keyword->entries->where('report_id', '3')->count(),
                '1969' => $keyword->entries->where('report_id', '4')->count(),
                '1970' => $keyword->entries->where('report_id', '5')->count(),
                '1971' => $keyword->entries->where('report_id', '6')->count(),
                '1972' => $keyword->entries->where('report_id', '7')->count(),
                '1973' => $keyword->entries->where('report_id', '8')->count(),
                '1974' => $keyword->entries->where('report_id', '9')->count(),
                '1975' => $keyword->entries->where('report_id', '10')->count()*/
            ];
        }

        return view('keywords.data', ['keywords' => $keywordsByCount]);
    }

    public function download() {
        $reports = Report::all();
        $filename = "keywords.csv";
        $handle = fopen($filename, 'w+');

        fputcsv($handle, array('Bericht', 'Eintrag', 'Titel', 'Keyword'));

        foreach($reports as $report) {
            foreach ($report->entries as $entry) {
                foreach ($entry->keywords as $keyword) {
                    fputcsv($handle, array(
                        $report['year'],
                        $entry['entryNo'],
                        $entry['title'],
                        $keyword['name']));
                }
            }
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return Response::download($filename, 'keywords.csv', $headers);
    }
    public function show($id) {
        $keyword = Keyword::findOrFail($id);
        $entriesCollection = $keyword->entries->groupBy('report.year');
        return view('keywords.show', [
            'keyword' => $keyword,
            'entriesCollection' => $entriesCollection
            ]
        );
    }
}
