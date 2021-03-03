<?php

namespace App\Http\Controllers;

use App\Entry;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchEntries(Request $request){

        $searchTerm = $request->input('search');

        $entries = Entry::query()
            ->select('entries.*')
            ->join('entry_place', 'entry_place.entry_id', '=', 'entries.id')
            ->join('places', 'places.id', '=', 'entry_place.place_id')
            ->join('entry_person', 'entry_person.entry_id', '=', 'entries.id')
            ->join('people', 'people.id', '=', 'entry_person.person_id')
            ->join('entry_keyword', 'entry_keyword.entry_id', '=', 'entries.id')
            ->join('keywords', 'keywords.id', '=', 'entry_keyword.keyword_id')
            ->where('fullTitle', 'LIKE', "%{$searchTerm}%")
            ->orWhere('abstract', 'LIKE', "%{$searchTerm}%")
            ->orWhere('places.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('people.familyName', 'LIKE', "%{$searchTerm}%")
            ->orWhere('people.givenName', 'LIKE', "%{$searchTerm}%")
            ->groupBy('entries.id')
            ->paginate(15)
            ->appends(['search' => $searchTerm]);

        return view('search.search', [
            'entries' => $entries
        ]);
    }
}
