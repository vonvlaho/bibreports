@extends('layouts.default')
@section('content')
    <section class="section container content">
        <div class="box">
            <ul>
                <li><h2><a href="{{ route('data.keywords') }}">Schlagworte</a></h2></li>
                <li><h2><a href="{{ route('data.people') }}">Personen</a></h2></li>
                <li><h2><a href="{{ route('data.places') }}">Orte</a></h2></li>
            </ul>
        </div>
    </section>
@stop
