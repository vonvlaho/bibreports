<?php

namespace App\Http\Controllers;

use App\Keyword;
use Illuminate\Http\Request;
use Mtownsend\XmlToArray\XmlToArray;
use App\Report;
use App\Entry;
use App\Person;

class ReportsController extends Controller
{
    public function store() {
        return view('reports.store', ['reports' => Report::all()]);
    }
    public function show($id) {
        return view('reports.show', ['report' => Report::findOrFail($id)]);
    }
    public function create() {
        $files = [
            '../database/data/1966.xml',
            '../database/data/1967.xml',
            '../database/data/1968.xml',
            '../database/data/1974.xml',
            //'../database/data/1971.xml',
            //'../database/data/1973.xml'
        ];
        foreach ($files as $file) {
            $this->importXml($file);
        }
    }
    private function importXml($file) {

        $xml = file_get_contents($file);
        $sourceData = XmlToArray::convert($xml);

        $report = Report::updateOrCreate(
            ['year' => $this->extractXmlValue($sourceData, 'year')],
            [
                'title' => $this->extractXmlValue($sourceData, 'title'),
                'editor' => $this->extractXmlValue($sourceData, 'editor'),
                'publisher' => $this->extractXmlValue($sourceData, 'publisher'),
                'cover' => $this->extractXmlValue($sourceData, 'cover')
            ]
        );

        foreach ($sourceData['entry'] as $sourceEntry) {
            $entry = Entry::updateOrCreate(
                [
                    'entryNo' => $this->extractXmlValue($sourceEntry, 'entryNo'),
                    'report_id' => $report->id
                ],
                [
                    'type' => $this->extractXmlValue($sourceEntry, 'type'),
                    'fullTitle' => $this->extractXmlValue($sourceEntry, 'fullTitle'),
                    'title' => $this->extractXmlValue($sourceEntry, 'title'),
                    'seriesTitle' => $this->extractXmlValue($sourceEntry, 'seriesTitle'),
                    'issue' => $this->extractXmlValue($sourceEntry, 'issue'),
                    'publicationYear' => $this->extractXmlValue($sourceEntry, 'publicationYear'),
                    'place' => $this->extractXmlValue($sourceEntry, 'place'),
                    'startingYear' => $this->extractXmlValue($sourceEntry, 'startingYear'),
                    'finishingYear' => $this->extractXmlValue($sourceEntry, 'finishingYear'),
                    'finishedYear' => $this->extractXmlValue($sourceEntry, 'finishedYear'),
                    'abstract' => $this->extractXmlValue($sourceEntry, 'abstract')
                ]
            );

            if (array_key_exists('people', $sourceEntry)) {
                foreach ($sourceEntry['people'] as $role => $sourcePerson) {
                    if (array_key_exists('familyName', $sourcePerson)) {
                        $this->updatePerson ($sourcePerson, $entry, $role);
                    } else if (is_array($sourcePerson)) {
                        foreach ($sourcePerson as $item) {
                         $this->updatePerson ($item, $entry, $role);
                        }
                    } else {
                        echo $sourcePerson . " is not an person";
                    }
                }
            }
        }

        foreach ($sourceData['register']['registerEntry'] as $sourceKeyword) {

            $keyword = Keyword::updateOrCreate(['name' => $this->extractXmlValue($sourceKeyword, 'item')]);

            if (!array_key_exists('ref', $sourceKeyword)) {
                dump($sourceKeyword);
            } else if (is_array($sourceKeyword['ref'])) {
                foreach ($sourceKeyword['ref'] as $sourceEntryNo) {
                    $this->updateKeyword ($sourceEntryNo, $report, $keyword);
                }
            } else if (is_string($sourceKeyword['ref'])) {
                $this->updateKeyword ($sourceKeyword['ref'], $report, $keyword);
            } else {
                break;
            }
        }
    }
    private function extractXmlValue ($array, $key)
    {
        $value = NULL;
        if (array_key_exists($key, $array)) {
            if (is_string($array[$key])) {
                $value = $array[$key];
            }
        }
        return $value;
    }
    private function updatePerson ($sourcePerson, $entry, $role) {
        $person = Person::updateOrCreate(
            [
                'familyName' => $sourcePerson['familyName'],
                'givenName' => $sourcePerson['givenName'] ?? NULL
            ],
            ['gender' => $sourcePerson['gender'] ?? NULL]
        );
        if (!$person->entries->contains($entry)) {
            $person->entries()->attach($entry, ['role' => $role]);
        }
    }
    private function updateKeyword ($sourceEntryNo, $report, $keyword) {

        $relatedEntries = Entry::where('entryNo', $sourceEntryNo)->where('report_id', $report->id)->get();
        if (!$relatedEntries->contains($keyword)) {
            if (is_null($relatedEntries->first())) {
                dump($sourceEntryNo);
            } else {
                $relatedEntries->first()->keywords()->attach($keyword);
            }
        }
    }
}
