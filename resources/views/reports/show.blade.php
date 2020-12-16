@extends('layouts.default')
@section('content')
<section class="section container">
    <nav>
        <a href="{{ route('reports.show.keywords', $report) }}" class="is-family-monospace">
            Register
        </a>
        <a href="{{ route('reports.show.people', $report) }}" class="is-family-monospace">
            Personen
        </a>
        <a href="{{ route('reports.show.places', $report) }}" class="is-family-monospace">
            Orte
        </a>
    </nav>
    <h1 class="title is-4">
        {{ $report->title }} {{ $report->year }}
    </h1>
    @if ($report->editor)
        <h2 class="subtitle is-6">Herausgegeben vom {{ $report->editor }}</h2>
    @endif
    @if ($report->publisher)
        <h3 class="subtitle is-6">{{ $report->publisher }}</h3>
    @endif
</section>
<section class="section container">
    @if ($report->entries)
        <ul>
        @foreach($report->entries as $entry)
                <li class="my-4">
                    <a href="{{ route('entries.show', $entry) }}">
                        <strong>{{ $entry->entryNo }}</strong> {{ $entry->fullTitle }}
                    </a>
                </li>
        @endforeach
        </ul>
    @endif
</section>
@stop
