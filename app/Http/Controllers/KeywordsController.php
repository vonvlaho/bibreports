<?php

namespace App\Http\Controllers;

use App\Keyword;

class KeywordsController extends Controller
{
    public function store() {
        $keywords = Keyword::has('entries')->orderBy('name')->paginate('15');

        return view('keywords.store', ['keywords' => $keywords]);
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
