<?php

namespace App\Http\Controllers;

use App\Place;
use App\Report;
use Illuminate\Support\Facades\Response;

class PlacesController extends Controller
{
    public function store() {
        return view('places.store', ['places' => Place::orderBy('name')->get()]);
    }
    public function download() {
        $reports = Report::all();
        $filename = "places.csv";
        $handle = fopen($filename, 'w+');

        fputcsv($handle, array('Bericht', 'Eintrag', 'Titel', 'Ort'));

        foreach($reports as $report) {
            foreach ($report->entries as $entry) {
                foreach ($entry->places as $place) {
                    fputcsv($handle, array(
                        $report['year'],
                        $entry['entryNo'],
                        $entry['title'],
                        $place['name']));
                }
            }
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return Response::download($filename, 'places.csv', $headers);
    }
    public function show($id) {
        $place = Place::findOrFail($id);
        $placesCollection = $place->entries->groupBy('report.year');
        return view('places.show', [
                'place' => $place,
                'placesCollection' => $placesCollection
            ]
        );
    }
}
