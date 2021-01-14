@extends('layouts.default')
@section('content')
    <section class="section container">
        <form action="{{ route('entries.search') }}" method="GET">
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
            {{--<nav class="pagination is-centered" role="navigation" aria-label="pagination">
                <a class="pagination-previous">←</a>
                <a class="pagination-next">→</a>
                <ul class="pagination-list">
                    <li><a class="pagination-link" aria-label="Goto page 1">1</a></li>
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
                    <li><a class="pagination-link" aria-label="Goto page 45">45</a></li>
                    <li><a class="pagination-link is-current" aria-label="Page 46" aria-current="page">46</a></li>
                    <li><a class="pagination-link" aria-label="Goto page 47">47</a></li>
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
                    <li><a class="pagination-link" aria-label="Goto page 86">86</a></li>
                </ul>
            </nav>--}}
        @else
            <div>
                <h2>Ihre Suche lieferte keine Treffer.</h2>
            </div>
    @endif
@stop
