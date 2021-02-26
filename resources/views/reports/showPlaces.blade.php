@extends('layouts.default')
@section('content')
    <section class="section container content">
        <h2 class="title is-4">
            Orte für {{ $report->title }} {{ $report->year }}
        </h2>
        <dl>
            @foreach( $places as $place => $entries )
                @isset( $entries )
                    <dt><strong>{{ $place }}</strong></dt>
                    @foreach( $entries  as $entry )
                        @if( $entry->report_id == $report->id)
                            <a href="{{ route('entries.show', $entry) }}">{{ $entry->entryNo }}</a>{{ $loop->last ? '.' : ', ' }}
                        @endif
                    @endforeach
                @endisset
            @endforeach
        </dl>
    </section>
@stop
