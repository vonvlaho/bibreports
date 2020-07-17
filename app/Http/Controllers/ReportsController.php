<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mtownsend\XmlToArray\XmlToArray;

class ReportsController extends Controller
{
    public function index() {
        return view('pages.index');
    }
    public function create() {
        $xml = file_get_contents('../database/data/test.xml');
        $array = XmlToArray::convert($xml);
        dd($array);

        return view('pages.create');
    }
}
