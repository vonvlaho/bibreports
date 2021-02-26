<?php

namespace App\Http\Controllers;

use App\Report;
use App\Keyword;
use App\Person;

class ReportsController extends Controller
{
    public function store() {
        return view('reports.store', ['reports' => Report::all()->sortBy('year')]);
    }
    public function show($id) {
        return view('reports.show', ['report' => Report::findOrFail($id)]);
    }
    public function showPlaces($id) {
        $report = Report::findOrFail($id);
        $places = $report->entries->sortBy('place')->groupBy('place');
        return view('reports.showPlaces', [
            'report' => $report,
            'places' => $places
        ]);
    }
    public function showKeywords($id) {
        $report = Report::findOrFail($id);
        $keywords = Keyword::whereHas('entries', function($query) use($id) {
            $query->where('entries.report_id', $id);
        })->get();

        return view('reports.showKeywords', [
            'report' => $report,
            'keywords' => $keywords
        ]);
    }
    public function showPeople($id) {
        $report = Report::findOrFail($id);
        $people = Person::whereHas('entries', function($query) use($id) {
            $query->where('entries.report_id', $id);
        })->get()->sortBy('familyName');

        return view('reports.showPeople', [
            'report' => $report,
            'people' => $people
        ]);
    }
}
