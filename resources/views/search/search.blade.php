@extends('layouts.default')
@section('content')
    <section class="section container">
        <form action="{{ route('search.search') }}" method="GET">
            @csrf
            <div class="field has-addons">
                <div class="control is-expanded" style="max-width: 450px">
                    <input class="input" type="text" placeholder="Neue Suchanfrage" name="search"/>
                </div>
                <div class="control">
                    <button type="submit" class="button is-link">Search</button>
                </div>
            </div>
        </form>
    </section>
    <section class="section container">
        @if($entries->isNotEmpty())
            <p class="has-text-right"><strong>{{ $entries->total() }}</strong> Treffer</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Bericht</th>
                        <th>Nummer</th>
                        <th>Eintrag</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entries as $entry)
                        <tr>
                            <td>
                                <a href="{{ route('reports.show', $entry->report->id) }}">
                                    {{ $entry->report->year }}
                                </a>
                            </td>
                            <td>
                                <strong>
                                    {{ $entry->entryNo }}
                                </strong>
                            </td>
                            <td>
                                <a href="{{ route('entries.show', $entry->id) }}">
                                    {{ $entry->fullTitle }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $entries->links() }}
        @else
            <div>
                <h2>Ihre Suche lieferte keine Treffer.</h2>
            </div>
        @endif
    </section>
@stop
