@extends('layouts.default')
@section('content')
    <section class="section container content">
        <h2 class="title is-4">
            {{ $keyword->name }}
        </h2>
        @isset( $entriesCollection )
        <h3 class="subtitle is-6">Verknüpfte Einträge:</h3>
        @foreach( $entriesCollection as $year => $entries )
        <h4>{{ $year }}</h4>
        <ul>
            @foreach( $entries as $entry )
                <li>
                    <a href="{{ route('entries.show', $entry) }}">
                        @include('includes.title', ['entry' => $entry])
                    </a>
                </li>
            @endforeach
        </ul>
        @endforeach
        @endisset
    </section>
@stop
