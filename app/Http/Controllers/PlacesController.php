<?php

namespace App\Http\Controllers;

use App\Place;

class PlacesController extends Controller
{
    public function store() {
        return view('places.store', ['places' => Place::orderBy('name')->get()]);
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
