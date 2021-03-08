<?php

namespace App\Http\Controllers;

use App\Keyword;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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

        $keywords = [];

        foreach (Keyword::all() as $keyword) {
            $keywords[$keyword->id] = [
                'id' => $keyword->id,
                'name' => $keyword->name,
                'total' => 0,
                '1966' => 0,
                '1967' => 0,
                '1968' => 0,
                '1969' => 0,
                '1970' => 0,
                '1971' => 0,
                '1972' => 0,
                '1973' => 0,
                '1974' => 0,
                '1975' => 0
            ];
            foreach ($keyword->entries as $entry) {
                $keywords[$keyword->id]['total']++;
                $keywords[$keyword->id][$entry->report->year]++;
            }
        }
        usort($keywords, function ($item1, $item2) {
            return $item2['total'] <=> $item1['total'];
        });

        return view('keywords.data', ['keywords' => $keywords]);
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
