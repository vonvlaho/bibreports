@extends('layouts.default')
@section('content')
    <section class="section container content">
        <div class="box">
            <ul>
                <li><a href="{{ route('data.keywords') }}">Schlagworte</a></li>
                <li><a href="{{ route('data.people') }}">Personen</a></li>
                <li><a href="{{ route('data.places') }}">Orte</a></li>
                <li><a href="{{ route('data.keywordsInPlace', 1) }}">Schlagworte/Ort</a></li>
                <li><a href="{{ route('data.peopleInPlace', 1) }}">Personen/Ort</a></li>
                <li><a href="{{ route('data.placesInKeyword', 1) }}">Orte/Schlagwort</a></li>
                <li><a href="{{ route('data.peopleInKeyword', 1) }}">Personen/Schlagwort</a></li>
                <li><a href="{{ route('data.placesInPerson', 1) }}">Orte/Person</a></li>
                <li><a href="{{ route('data.keywordsInPerson', 1) }}">Schlagworte/Person</a></li>
            </ul>
        </div>
    </section>
@stop
