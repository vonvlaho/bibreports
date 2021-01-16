<?php

namespace App\Http\Controllers;

use App\Entry;

class EntriesController extends Controller
{
    public function show($id) {

        $entry = Entry::findOrFail($id);

        return view('entries.show', [
            'entry' => $entry
        ]);
    }
}
