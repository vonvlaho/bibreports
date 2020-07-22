<?php

namespace App\Http\Controllers;

use App\Keyword;
use App\Report;
use Illuminate\Http\Request;

class KeywordsController extends Controller
{
    public function store() {
        return view('keywords.store', ['keywords' => Keyword::all()->sortBy('name')]);
    }
    public function show($id) {
        $keyword = Keyword::findOrFail($id);
        $entriesCollection = $keyword->entries->groupBy('report.year');
        return view('keywords.show', [
            'keyword' => $keyword,
            'entriesCollection' => $entriesCollection
            ]
        );
    }
}
