<?php

namespace App\Http\Controllers;

use App\Person;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function store() {
        return view('people.store', ['people' => Person::orderBy('familyName')->get()]);
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
