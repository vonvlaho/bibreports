<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mtownsend\XmlToArray\XmlToArray;
use App\Report;
use App\Entry;
use App\Author;

class ReportsController extends Controller
{
    public function index() {
        return view('pages.index');
    }
    public function create() {
        $xml = file_get_contents('../database/data/test.xml');
        $sourceData = XmlToArray::convert($xml);

        $report = new Report();
        $report->title = $sourceData['title'];
        $report->editor = $sourceData['editor'];
        $report->publisher = $sourceData['publisher'];
        $report->year = $sourceData['year'];
        $report->save();

        foreach ($sourceData['entry'] as $sourceEntry) {
            $author = new Author();
            $author->familyName = $sourceEntry['author']['familyName'];
            $author->givenName = $sourceEntry['author']['givenName'];
            $author->gender = $sourceEntry['author']['gender'];
            $author->save();

            $entry = new Entry();
            $entry->entryNo = $sourceEntry['entryNo'];
            $entry->type = $sourceEntry['type'];
            $entry->title = $sourceEntry['title'];
            $entry->seriesTitle = $sourceEntry['seriesTitle'];
            $entry->issue = $sourceEntry['issue'];
            $entry->publicationYear = $sourceEntry['publicationYear'];
            $entry->place = $sourceEntry['place'];
            $entry->startingYear = $sourceEntry['startingYear'];
            $entry->finishingYear = $sourceEntry['finishingYear'];
            $entry->abstract = $sourceEntry['abstract'];
            $entry->report_id->associate($report);
            $entry->save();
        }
    }
}
