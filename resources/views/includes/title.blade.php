@spaceless
@isset( $entry->authors )
@foreach( $entry->authors as $author) {{ $author->familyName }}, {{ $author->givenName }}@endforeach:
@endisset
 {{ $entry->title }}
@isset( $entry->place )
– {{ $entry->place }}
@endisset
@isset( $entry->type )
. {{ $entry->type }}
@endisset
@isset( $entry->startingYear )
, Beginn: {{ $entry->startingYear }}
@endisset
@isset( $entry->finishingYear )
, Abschluss: {{ $entry->finishingYear }}
@endisset
@isset( $entry->finishedYear )
, {{ $entry->finishedYear }} abgeschlossen
@endisset
@isset( $entry->publicationYear )
, {{ $entry->publicationYear }}
@endisset
.
@endspaceless
