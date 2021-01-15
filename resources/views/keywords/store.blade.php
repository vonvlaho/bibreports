@extends('layouts.default')
@section('content')
    <section class="section container">
        <div class="content">
            <h2 class="title is-4">
                Gesamtregister
            </h2>
            <dl>
                @foreach( $keywords as $keyword )
                    @isset( $keyword->entries )
                        <dt><strong>{{ $keyword->name }}</strong></dt>
                        <dd>
                        @foreach( $keyword->entries->groupBy('report.year') as $year => $entryCollection )
                            <dd>{{ $year }}:
                                @foreach( $entryCollection as $entry )
                                    <a href="{{ route('entries.show', $entry) }}">{{ $entry->entryNo }}</a>{{ $loop->last ? '.' : ', ' }}
                                @endforeach
                            </dd>
                        @endforeach
                    @endisset
                @endforeach
            </dl>
        </div>
        {{ $keywords->links() }}
    </section>
@stop
