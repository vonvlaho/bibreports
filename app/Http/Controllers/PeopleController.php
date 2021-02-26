<?php

namespace App\Http\Controllers;

use App\Person;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PeopleController extends Controller
{
    public function store() {
        return view('people.store', ['people' => Person::orderBy('familyName')->get()]);
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
