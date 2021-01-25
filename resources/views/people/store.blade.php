@extends('layouts.default')
@section('content')
<section class="section container content">
    <h1 class="title is-4">
        Personenverzeichnis
    </h1>
    @isset( $people )
        <ul>
            @foreach( $people as $person)
                <li><a href="{{ route('people.show', $person) }}">{{ $person->familyName }}@if($person->givenName), {{ $person->givenName }}@endif</a></li>
            @endforeach
        </ul>
    @endisset
</section>
@stop
