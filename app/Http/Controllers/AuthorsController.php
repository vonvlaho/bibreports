<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function store() {
        return view('authors.store', ['authors' => Author::all()]);
    }
}
