@spaceless
@if( $entry->authors )
@foreach( $entry->authors as $author) {{ $author->familyName }}, {{ $author->givenName }}@endforeach:
@endif
 {{ $entry->title }}
@if( $entry->place )
– {{ $entry->place }}
@endif
@if( $entry->type )
. {{ $entry->type }}
@endif
@if( $entry->startingYear )
, Beginn: {{ $entry->startingYear }}
@endif
@if( $entry->finishingYear )
, Abschluss: {{ $entry->finishingYear }}
@endif
@if( $entry->finishedYear )
, {{ $entry->finishedYear }} abgeschlossen
@endif
@if( $entry->publicationYear )
, {{ $entry->publicationYear }}
@endif
.
@endspaceless
