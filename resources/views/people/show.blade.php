@extends('layouts.default')
@section('content')
    <section class="section container content">
        <h2 class="title is-4">
            {{ $person->familyName }}, {{ $person->givenName }}
        </h2>
        @isset( $entriesCollection )
        <h3 class="subtitle is-6">Verknüpfte Einträge:</h3>
        @foreach( $entriesCollection as $role => $entries )
        <h4>{{ $role }}</h4>
        <ul>
            @foreach( $entries as $entry )
                <li>
                    <a href="{{ route('entries.show', $entry) }}">
                        {{ $entry->fullTitle }}
                    </a>
                </li>
            @endforeach
        </ul>
        @endforeach
        @endisset
    </section>
@stop
