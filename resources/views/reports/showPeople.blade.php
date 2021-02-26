@extends('layouts.default')
@section('content')
<section class="section container content">
    <h2 class="title is-4">
        Register für {{ $report->title }} {{ $report->year }}
    </h2>
    @isset( $people )
        <ul>
            @foreach( $people as $person)
                <li><a href="{{ route('people.show', $person) }}">{{ $person->familyName }}@if($person->givenName), {{ $person->givenName }}@endif</a></li>
            @endforeach
        </ul>
    @endisset
</section>
@stop
