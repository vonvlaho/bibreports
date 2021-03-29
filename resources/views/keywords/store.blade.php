@extends('layouts.default')
@section('content')
    <section class="section container">
        <div class="content">
            <h2 class="title is-4">
                Gesamtregister
            </h2>
            <form action="{{ route('keywords.store') }}" method="GET">
                @csrf
                <div class="field has-addons">
                    <div class="control">
                        <input class="input" type="text" placeholder="Registereintrag" name="search"/>
                    </div>
                    <div class="control">
                        <button type="submit" class="button">Suche</button>
                    </div>
                </div>
            </form>
            <dl class="mt-4">
                @foreach( $keywords as $keyword )
                    @isset( $keyword->entries )
                        <dt><strong><a href="{{ route('keywords.show', $keyword) }}">{{ $keyword->name }}</strong></dt>
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
