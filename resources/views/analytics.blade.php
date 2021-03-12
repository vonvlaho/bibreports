@extends('layouts.default')
@section('content')
    <section class="section container content">
        <div class="box">
            <ul>
                <li><h2><a href="{{ route('keywords.data') }}">Schlagworte</a></h2></li>
                <li><h2><a href="{{ route('people.data') }}">Personen</a></h2></li>
                <li><h2><a href="{{ route('places.data') }}">Orte</a></h2></li>
            </ul>
        </div>
    </section>
@stop
