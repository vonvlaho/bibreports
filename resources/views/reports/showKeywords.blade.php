@extends('layouts.default')
@section('content')
    <section class="section container content">
        <h2 class="title is-4">
            Register für {{ $report->title }} {{ $report->year }}
        </h2>
        <dl>
            @foreach( $keywords as $keyword )
                @isset( $keyword->entries )
                    <dt><strong>{{ $keyword->name }}</strong></dt>
                    @foreach( $keyword->entries  as $entry )
                        @if( $entry->report_id == $report->id)
                            <a href="{{ route('entries.show', $entry) }}">{{ $entry->entryNo }}</a>{{ $loop->last ? '.' : ', ' }}
                        @endif
                    @endforeach
                @endisset
            @endforeach
        </dl>
    </section>
@stop
