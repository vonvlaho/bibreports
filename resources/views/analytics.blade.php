@extends('layouts.default')
@section('content')
    <section class="section container content">
        <div class="box">
            <ul>
                <li><a href="{{ route('data.keywords') }}">Schlagworte</a></li>
                <li><a href="{{ route('data.people') }}">Personen</a></li>
                <li><a href="{{ route('data.places') }}">Orte</a></li>
            </ul>
        </div>
    </section>
@stop
