@extends('layouts.default')
@section('content')
    <section class="section container content">
        <h2 class="title is-4">
            Gesamtregister
        </h2>
        <dl>
            @foreach( $places as $place )
                @isset( $place->entries )
                    <dt><strong>{{ $place->name }}</strong></dt>
                    <dd>
                    @foreach( $place->entries->groupBy('report.year') as $year => $entryCollection )
                        <dd>{{ $year }}:
                            @foreach( $entryCollection as $entry )
                                <a href="{{ route('entries.show', $entry) }}">{{ $entry->entryNo }}</a>{{ $loop->last ? '.' : ', ' }}
                            @endforeach
                        </dd>
                    @endforeach
                @endisset
            @endforeach
        </dl>
    </section>
@stop
