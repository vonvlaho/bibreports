@extends('layouts.default')
@section('content')
<section class="section container">
    <h1 class="title is-4">
        {{ $entry->report->title }} {{ $entry->report->year }}
    </h1>
    @isset($entry->report->editor)
        <h2 class="subtitle is-6">Herausgegeben vom {{ $entry->report->editor }}</h2>
    @endisset
    @isset($entry->report->publisher)
        <h3 class="subtitle is-6">{{ $entry->report->publisher }}</h3>
    @endisset
</section>
<section class="section container content">
    @isset( $entry->keywords )
        <p>
            @foreach( $entry->keywords as $keyword)
                <a href="{{ route('keywords.show', ['keyword' => $keyword]) }}"><span class="tag is-link is-normal">{{ $keyword->name }}</span></a>
            @endforeach
        </p>
    @endisset
    <h5><strong>{{ $entry->entryNo }}</strong> {{ $entry->fullTitle }}</h5>
    @isset( $entry->abstract )
        <p>{{ $entry->abstract }}</p>
    @endisset
</section>
@stop
