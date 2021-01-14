@extends('layouts.default')
@section('content')
    <section class="section container">
        <form action="{{ route('entries.search') }}" method="GET">
            <input type="text" name="search" required/>
            <button type="submit">Search</button>
        </form>
    </section>
    <section class="section container content">
        @if($entries->isNotEmpty())
            <ul>
                @foreach ($entries as $entry)
                    <a href="{{ route('entries.show', $entry) }}">
                        <strong>{{ $entry->entryNo }}</strong> {{ $entry->fullTitle }}
                    </a>
                @endforeach
            </ul>
        @else
            <div>
                <h2>No posts found</h2>
            </div>
    @endif
@stop
