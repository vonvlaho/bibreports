@extends('layouts.default')
@section('content')
<section class="section container">
    <h1 class="title is-4">
        Personenregister
    </h1>
</section>
<section class="section container content">
    @isset( $people )
        <ul>
            @foreach( $people as $person)
                <li><a href="{{ route('people.show', $person) }}">{{ $person->familyName }}@if($person->givenName), {{ $person->givenName }}@endif</a></li>
            @endforeach
        </ul>
    @endisset
</section>
@stop
