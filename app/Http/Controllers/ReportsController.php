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

        $report = Report::updateOrCreate(
            ['year' => $sourceData['year']],
            [
                'title' => $sourceData['title'],
                'editor' => $sourceData['editor'] ?? NULL,
                'publisher' => $sourceData['publisher'] ?? NULL
            ]
        );

        foreach ($sourceData['entry'] as $sourceEntry) {
            $author = Author::updateOrCreate(
                [
                    'familyName' => $sourceEntry['author']['familyName'],
                    'givenName' => $sourceEntry['author']['givenName']
                ],
                ['gender' => $sourceEntry['author']['gender'] ?? NULL]
            );
            $entry = Entry::updateOrCreate(
                ['entryNo' => $sourceEntry['entryNo']],
                [
                    'type' => $sourceEntry['type'] ?? NULL,
                    'title' => $sourceEntry['title'],
                    'seriesTitle' => $sourceEntry['seriesTitle'] ?? NULL,
                    'issue' => $sourceEntry['issue'] ?? NULL,
                    'publicationYear' => $sourceEntry['publicationYear'] ?? NULL,
                    'place' => $sourceEntry['place'] ?? NULL,
                    'startingYear' => $sourceEntry['startingYear'] ?? NULL,
                    'finishingYear' => $sourceEntry['finishingYear'] ?? NULL,
                    'abstract' => $sourceEntry['abstract'] ?? NULL,
                    'report_id' => $report->id
                ]
            );
        }
    }
}
