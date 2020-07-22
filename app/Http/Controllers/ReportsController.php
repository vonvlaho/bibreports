<?php

namespace App\Http\Controllers;

use App\Keyword;
use Illuminate\Http\Request;
use Mtownsend\XmlToArray\XmlToArray;
use App\Report;
use App\Entry;
use App\Author;

class ReportsController extends Controller
{
    public function store() {
        return view('reports.store', ['reports' => Report::all()]);
    }
    public function show($id) {
        return view('reports.show', ['report' => Report::findOrFail($id)]);
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
            $entry = Entry::updateOrCreate(
                [
                    'entryNo' => $sourceEntry['entryNo'],
                    'report_id' => $report->id
                ],
                [
                    'type' => $sourceEntry['type'] ?? NULL,
                    'title' => $sourceEntry['title'],
                    'seriesTitle' => $sourceEntry['seriesTitle'] ?? NULL,
                    'issue' => $sourceEntry['issue'] ?? NULL,
                    'publicationYear' => $sourceEntry['publicationYear'] ?? NULL,
                    'place' => $sourceEntry['place'] ?? NULL,
                    'startingYear' => $sourceEntry['startingYear'] ?? NULL,
                    'finishingYear' => $sourceEntry['finishingYear'] ?? NULL,
                    'finishedYear' => $sourceEntry['finishedYear'] ?? NULL,
                    'abstract' => $sourceEntry['abstract'] ?? NULL
                ]
            );
            foreach ($sourceEntry['authors'] as $sourceAuthor) {
                $author = Author::updateOrCreate(
                    [
                        'familyName' => $sourceAuthor['familyName'],
                        'givenName' => $sourceAuthor['givenName']
                    ],
                    ['gender' => $sourceAuthor['gender'] ?? NULL]
                );
                if (!$author->entries->contains($entry)) {
                    $author->entries()->attach($entry);
                }
            }
        }

        foreach ($sourceData['keyword'] as $sourceKeyword) {
            $keyword = Keyword::updateOrCreate(
                ['name' => $sourceKeyword['name']]
            );
            foreach ($sourceKeyword['entryNos'] as $sourceEntryNo) {
                $relatedEntries = Entry::where('entryNo', $sourceEntryNo)->where('report_id', $report->id)->get();
                if (!$relatedEntries->contains($keyword)) {
                    $relatedEntries->first()->keywords()->attach($keyword);
                }
            };
        }
    }
}
