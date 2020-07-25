<?php
$xml = new SimpleXMLElement('<xml/>');

$rawData = file($argv[1]);
$pos = 0;

$xml->addChild('xml');
$xml->xml->addChild('report');

$root = $xml->xml->report;

$title = $root->addChild('title', $rawData[0] ?? '');
$year = $root->addChild('year', $rawData[1] ?? '');
$publisher = $root->addChild('publisher', str_replace('Herausgegeben vom ', '', $rawData[3]) ?? '');
$editor = $root->addChild('editor', $rawData[5] ?? '');
$cover = $root->addChild('cover', 'BERICHT_' . $year . '.jpg' ?? '');

foreach($rawData as $key => $value) {
    if (preg_match("/(F\s\d+)\s/", $value)) {

        $entry = $root->addChild('entry');

        //matches up to end of title with capturing groups entryNo, Authors, Title
        $pattern = "/(F\s\d+)\s(.*):\s(.*)(?:.\s-|,\s-)/";
        preg_match($pattern, $value, $matches);

        //extract entryNo = Capturing Group #1
        if ($matches[1]) {
            $entryNo = $entry->addChild('entryNo', $matches[1]);
        }

        //extract authors = Capturing Group #2
        if ($matches[2]) {
            $authors = $entry->addChild('authors');
            $rawNames = preg_split('/(u.)/', $matches[2]);
            foreach ($rawNames as $rawName) {
                $author = $authors->addChild('author');
                $familyName = $author->addChild('familyName', preg_split('/,/', $rawName)[0]);
                $givenName = $author->addChild('givenName', preg_split('/,/', $rawName)[1]);
            }
        }

        //extract title = Capturing Group #3
        if ($matches[3]) {
            $title = $entry->addChild('title', $matches[3]);
        }

        //throw already captured string away
        $rest = preg_replace($pattern, '', $value);

        //look for a place
        preg_match("/Berlin|Greifswald|Halle|Jena|Leipzig|Rostock/", $rest, $matches);
        if ($matches[1]) {
            $place = $entry->addChild('place', $matches[1]);
        }
        $rest = preg_replace("/Berlin|Greifswald|Halle|Jena|Leipzig|Rostock/", '', $rest);

        //look for a startingYear
        preg_match("/Beginn:\s(\d+)/", $rest, $matches);
        if ($matches[1]) {
            $startingYear = $entry->addChild('startingYear', $matches[1]);
        }
        $rest = preg_replace("/Beginn:\s(\d+)/", '', $rest);

        //look for a finishingYear
        preg_match("/Abschluß:\s(\d+)/", $rest, $matches);
        if ($matches[1]) {
            $finishingYear = $entry->addChild('finishingYear', $matches[1]);
        }
        $rest = preg_replace("/Abschluß:\s(\d+)/", '', $rest);

        //look for a finishedYear
        preg_match("(\d+)\sabgeschlossen/", $rest, $matches);
        if ($matches[1]) {
            $finishedYear = $entry->addChild('finishingYear', $matches[1]);
        }
        $rest = preg_replace("/(\d+)\sabgeschlossen/", '', $rest);

        var_dump($entry);
        var_dump($rest);

        /*$seriesTitle = $entry->addChild('seriesTitle');
        $issue = $entry->addChild('issue');
        $publicationYear = $entry->addChild('publicationYear');

        $abstract = $entry->addChild('abstract');*/
    }
}
