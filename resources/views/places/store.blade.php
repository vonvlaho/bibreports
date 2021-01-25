@extends('layouts.default')
@section('content')
    <section class="section container content">
        <h2 class="title is-4">
            Publikationsorte
        </h2>
        @isset( $places )
            <ul>
                @foreach( $places as $place)
                    <li><a href="{{ route('places.show', $place) }}">{{ $place->name }}</a></li>
                @endforeach
            </ul>
        @endisset
    </section>
@stop
