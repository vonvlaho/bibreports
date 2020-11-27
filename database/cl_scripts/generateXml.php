<?php

$rawData = file($argv[1]);

$xml = new SimpleXMLElement('<xml/>');
$xml->addAttribute('encoding', 'UTF-8');
$xml->addChild('report');

$root = $xml->report;

/*$title = $root->addChild('title', $rawData[0] ?? '');
$year = $root->addChild('year', $rawData[1] ?? '');
$publisher = $root->addChild('publisher', str_replace('Herausgegeben vom ', '', $rawData[3]) ?? '');
$editor = $root->addChild('editor', $rawData[5] ?? '');
$cover = $root->addChild('cover', 'BERICHT_' . $year . '.jpg' ?? '');*/

$entry = [];
$currentEntryNo = '';
$registerMode = false;

foreach($rawData as $key => $value) {
    if (preg_match("/(###Register###)/", $value) > 0) {
        $registerMode = true;
    } else if ($registerMode === true && preg_match("/(N\s\d*)/", $value) > 0) {
        $keyword = $root->addChild('keyword');
        $entryNos = $keyword->addChild('entryNos');

        //extract entryNos
        preg_match_all("/(N\s\d*)/", $value, $matches);
        foreach ($matches[1] as $entryNo) {
            $keyword->entryNos->addChild('entryNo', $entryNo);
        }

        //extract entry name
        preg_match("/(.*?)(\d+)|(.*?)(N\s\d+)/", $value, $matches);
        $keyword->entryNos->addChild('name', $matches[1]);
    } else if (preg_match("/(N\s\d+)\s/", $value) > 0) {

        $entry = $root->addChild('entry');

        //matches up to end of title with capturing groups entryNo, Authors, Title
        $pattern = "/(N\s\d+)\s(.*):\s(.*)(?:.\s-|,\s-)/";
        preg_match($pattern, $value, $matches);

        //extract entryNo = Capturing Group #1
        if ($matches) {
            $currentEntryNo = $matches[1];
            $entryNo = $entry->addChild('entryNo', $currentEntryNo);
        }

        //extract authors = Capturing Group #2
        if ($matches) {
            $authors = $entry->addChild('authors');
            $rawNames = preg_split('/(u\.)/', $matches[2]);
            foreach ($rawNames as $rawName) {
                $author = $authors->addChild('author');
                if (preg_match("/(,)/", $rawName) > 0) {
                    $familyName = $author->addChild('familyName', preg_split('/(,)/', $rawName)[0]);
                    $givenName = $author->addChild('givenName', preg_split('/(,)/', $rawName)[1]);
                } else {
                    $author->addChild('REST', $rawName);
                }
            }
        }

        //extract title = Capturing Group #3
        if ($matches) {
            $title = $entry->addChild('title', $matches[3]);
        }

        //throw already captured string away
        $rest = preg_replace($pattern, '', $value);

        //look for a place
        preg_match("/(Berlin)|(Greifswald)|(Halle)|(Jena)|(Leipzig)|(Rostock)/", $rest, $matches);
        if ($matches) {
            $place = $entry->addChild('place', $matches[0]);
            $rest = preg_replace("/(Berlin)|(Greifswald)|(Halle)|(Jena)|(Leipzig)|(Rostock)/", '', $rest);
        }

        //look for a startingYear
        preg_match("/(Beginn:\s)(\d+)/", $rest, $matches);
        if ($matches) {
            $startingYear = $entry->addChild('startingYear', $matches[2]);
            $rest = preg_replace("/(Beginn:\s)(\d+)/", '', $rest);
        }

        //look for a finishingYear
        preg_match("/(Abschluß:\s)(\d+)/", $rest, $matches);
        if ($matches) {
            $finishingYear = $entry->addChild('finishingYear', $matches[2]);
            $rest = preg_replace("/(Abschluß:\s)(\d+)/", '', $rest);
        }

        //look for a finishedYear
        preg_match("/(\d+\s)(abgeschlossen)/", $rest, $matches);
        if ($matches) {
            $finishedYear = $entry->addChild('finishingYear', $matches[1]);
            $rest = preg_replace("/(\d+\s)(abgeschlossen)/", '', $rest);
        }

        //look for type
        preg_match("/(Forschungsarbeit)|(Phil.\sDiss.)|(Diss.\sA)/", $rest, $matches);
        if ($matches) {
            $type = $entry->addChild('type', $matches[0]);
            $rest = preg_replace("/(Forschungsarbeit)|(Phil.\sDiss.)|(Diss.\sA)/", '', $rest);
        }

        if ($rest != '') {
            $entry->addChild('REST', $rest);
        }
    } else if ($currentEntryNo != '' && $value != '') {
        if (isset($entry->abstract)) {
            $entry->abstract .= $value;
        } else  {
            $entry->addChild('abstract', $value);
        }
    }

    /*
     * $seriesTitle = $entry->addChild('seriesTitle');
     * $issue = $entry->addChild('issue');
     * $publicationYear = $entry->addChild('publicationYear');
     *
     */
}
$xml = html_entity_decode($xml->asXML(), ENT_NOQUOTES, 'UTF-8');
var_dump($xml);die();
file_put_contents($argv[2] . '.xml', $xml);
