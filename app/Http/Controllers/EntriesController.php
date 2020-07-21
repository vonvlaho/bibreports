<?php

namespace App\Http\Controllers;

use App\Keyword;
use Illuminate\Http\Request;
use Mtownsend\XmlToArray\XmlToArray;
use App\Report;
use App\Entry;
use App\Author;

class EntriesController extends Controller
{
    public function show($id) {
        return view('entries.show', ['entry' => Entry::findOrFail($id)]);
    }
}
