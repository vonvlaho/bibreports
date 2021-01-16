<?php

namespace App\Console\Commands;

use App\Entry;
use App\Keyword;
use App\Person;
use App\Report;
use App\Place;
use Illuminate\Console\Command;
use Mtownsend\XmlToArray\XmlToArray;

class ImportXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:xml {file*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Xml content into database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        foreach ($this->argument('file') as $file) {
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
//                    'startingYear' => $this->extractXmlValue($sourceEntry, 'startingYear'),
//                    'finishingYear' => $this->extractXmlValue($sourceEntry, 'finishingYear'),
//                    'finishedYear' => $this->extractXmlValue($sourceEntry, 'finishedYear'),
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

            if (array_key_exists('places', $sourceEntry)) {
                foreach ($sourceEntry['places'] as $place) {
                    if (is_array($place)) {
                        foreach ($place as $placeName) {
                            $this->updatePlace ($entry, $placeName);
                        }
                    } else if (is_string($place)) {
                        $this->updatePlace ($entry, $place);
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
    private function updatePlace ($entry, $placeName) {
        $place = Place::updateOrCreate(
            [
                'name' => $placeName
            ]
        );
        if (!$place->entries->contains($entry)) {
            $place->entries()->attach($entry);
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
