<?php

namespace App\Http\Controllers;

use App\Keyword;
use Illuminate\Http\Request;
use Mtownsend\XmlToArray\XmlToArray;
use App\Report;
use App\Entry;
use App\Person;

class EntriesController extends Controller
{
    public function show($id) {

        $entry = Entry::findOrFail($id);
        $previous = Entry::where('id', '<', $entry->id)->max('id');
        $next = Entry::where('id', '>', $entry->id)->min('id');

        return view('entries.show', [
            'entry' => $entry,
            'previous' => $previous,
            'next' => $next
        ]);
    }
}
