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

        $keywords = Keyword::select('name')->withCount([
            'entries as total',
            'entries as Y-1966' => function (Builder $query){$query->where('report_id', '1');},
            'entries as Y-1967' => function (Builder $query){$query->where('report_id', '2');},
            'entries as Y-1968' => function (Builder $query){$query->where('report_id', '3');},
            'entries as Y-1969' => function (Builder $query){$query->where('report_id', '4');},
            'entries as Y-1970' => function (Builder $query){$query->where('report_id', '5');},
            'entries as Y-1971' => function (Builder $query){$query->where('report_id', '6');},
            'entries as Y-1972' => function (Builder $query){$query->where('report_id', '7');},
            'entries as Y-1973' => function (Builder $query){$query->where('report_id', '8');},
            'entries as Y-1974' => function (Builder $query){$query->where('report_id', '9');},
            'entries as Y-1975' => function (Builder $query){$query->where('report_id', '10');}
        ])->orderBy('total', 'desc')->get()->toArray();

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
