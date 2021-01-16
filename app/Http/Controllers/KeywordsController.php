<?php

namespace App\Http\Controllers;

use App\Keyword;
use Illuminate\Http\Request;

class KeywordsController extends Controller
{
    public function store(Request $request) {

        $searchTerm = $request->input('search');

        $keywords = Keyword::has('entries')
            ->where('name', 'LIKE', "%{$searchTerm}%")
            ->orderBy('name')
            ->paginate('15')
            ->appends(['search' => $searchTerm]);

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
