<?php

namespace App\Http\Controllers;

use App\Person;
use App\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class PeopleController extends Controller
{
    public function store() {
        return view('people.store', ['people' => Person::orderBy('familyName')->get()]);
    }
    public function data() {

        $people = Person::select(DB::raw("CONCAT ('givenName', ' ', 'familyName') AS name"))->withCount([
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

        return view('people.data', ['people' => $people]);
    }
    public function download() {
        $reports = Report::all();
        $filename = "people.csv";
        $handle = fopen($filename, 'w+');

        fputcsv($handle, array('Bericht', 'Eintrag', 'Titel', 'Person', 'Rolle'));

        foreach($reports as $report) {
            foreach ($report->entries as $entry) {
                foreach ($entry->people as $person) {
                    fputcsv($handle, array(
                        $report['year'],
                        $entry['entryNo'],
                        $entry['title'],
                        $person['givenName'] . " " . $person['familyName'],
                        $person->pivot->role)
                    );
                }
            }
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return Response::download($filename, 'people.csv', $headers);
    }
    public function show($id) {
        $person = Person::findOrFail($id);
        $entriesCollection = $person->entries->groupBy('pivot.role');
        return view('people.show', [
                'person' => $person,
                'entriesCollection' => $entriesCollection
            ]
        );
    }
}
