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
        $xml = file_get_contents('../database/data/BERICHT_1973.xml');
        $sourceData = XmlToArray::convert($xml);

        function extractXmlValue ($array, $key)
        {
            $value = NULL;
            if (array_key_exists($key, $array)) {
                if (is_string($array[$key])) {
                    $value = $array[$key];
                }
            }
            return $value;
        }

        function updateAuthor ($sourceAuthor, $entry) {
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

        function updateKeyword ($sourceEntryNo, $report, $keyword) {
            $relatedEntries = Entry::where('entryNo', $sourceEntryNo)->where('report_id', $report->id)->get();
            if (!$relatedEntries->contains($keyword)) {
                $relatedEntries->first()->keywords()->attach($keyword);
            }
        }

        $report = Report::updateOrCreate(
            ['year' => extractXmlValue($sourceData, 'year')],
            [
                'title' => extractXmlValue($sourceData, 'title'),
                'editor' => extractXmlValue($sourceData, 'editor'),
                'publisher' => extractXmlValue($sourceData, 'publisher'),
                'cover' => extractXmlValue($sourceData, 'cover')
            ]
        );

        foreach ($sourceData['entry'] as $sourceEntry) {
            $entry = Entry::updateOrCreate(
                [
                    'entryNo' => extractXmlValue($sourceEntry, 'entryNo'),
                    'report_id' => $report->id
                ],
                [
                    'type' => extractXmlValue($sourceEntry, 'type'),
                    'title' => extractXmlValue($sourceEntry, 'title'),
                    'seriesTitle' => extractXmlValue($sourceEntry, 'seriesTitle'),
                    'issue' => extractXmlValue($sourceEntry, 'issue'),
                    'publicationYear' => extractXmlValue($sourceEntry, 'publicationYear'),
                    'place' => extractXmlValue($sourceEntry, 'place'),
                    'startingYear' => extractXmlValue($sourceEntry, 'startingYear'),
                    'finishingYear' => extractXmlValue($sourceEntry, 'finishingYear'),
                    'finishedYear' => extractXmlValue($sourceEntry, 'finishedYear'),
                    'abstract' => extractXmlValue($sourceEntry, 'abstract')
                ]
            );

            if (array_key_exists('authors', $sourceEntry)) {
                foreach ($sourceEntry['authors'] as $sourceAuthor) {

                    if (array_key_exists('familyName', $sourceAuthor)) {
                        updateAuthor ($sourceAuthor, $entry);
                    } else if (is_array($sourceAuthor)) {
                        foreach ($sourceAuthor as $item) {
                            updateAuthor ($item, $entry);
                        }
                    } else {
                        echo $sourceAuthor . " is not an author";
                    }
                }
            }
        }

        foreach ($sourceData['keyword'] as $sourceKeyword) {
            $keyword = Keyword::updateOrCreate(
                ['name' => extractXmlValue($sourceKeyword, 'name')]
            );
            foreach ($sourceKeyword['entryNos'] as $sourceEntryNo) {
                if (is_array($sourceEntryNo)) {
                    foreach ($sourceEntryNo as $item) {
                        updateKeyword ($item, $report, $keyword);
                    }
                } else if (is_string($sourceEntryNo)) {
                        updateKeyword ($sourceEntryNo, $report, $keyword);
                } else {
                    break;
                }
            }
        }
    }
}
