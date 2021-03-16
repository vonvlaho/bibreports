<?php

namespace App\Http\Controllers;

use App\Keyword;
use App\Place;
use App\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Response;

class PlacesController extends Controller
{
    public function store() {
        return view('places.store', ['places' => Place::orderBy('name')->get()]);
    }
    public function data() {

        $places = Place::select('name')->withCount([
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

        return view('places.data', ['places' => $places]);
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

    public function keywords($id) {

        $keywords = Keyword::select('name')
            ->whereHas('entries.places', function (Builder $query) use ($id) {
                $query->where('places.id', '=', $id);
            })
            ->withCount([
                'entries as total' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    });
                },
                'entries as Y-1966' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '1');
                },
                'entries as Y-1967' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '2');
                },
                'entries as Y-1968' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '3');
                },
                'entries as Y-1969' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '4');
                },
                'entries as Y-1970' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '5');
                },
                'entries as Y-1971' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '6');
                },
                'entries as Y-1972' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '7');
                },
                'entries as Y-1973' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '8');
                },
                'entries as Y-1974' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '9');
                },
                'entries as Y-1975' => function (Builder $query) use ($id) {
                    $query->whereHas('places', function (Builder $query) use ($id) {
                        $query->where('places.id', '=', $id);
                    })->where('report_id', '10');
                }
            ])->orderBy('total', 'desc')->get()->toArray();

        return view('keywords.data', ['keywords' => $keywords]);
    }
}
