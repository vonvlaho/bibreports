<?php

namespace App\Http\Controllers;

use App\Person;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function store() {
        return view('people.store', ['people' => Person::all()]);
    }
}
