@extends('layouts.default')
@section('content')
<section class="section container">
    <h1 class="title is-4">
        {{ $entry->report->title }} {{ $entry->report->year }}
    </h1>
    @if ($entry->report->editor)
        <h2 class="subtitle is-6">Herausgegeben vom {{ $entry->report->editor }}</h2>
    @endif
    @if ($entry->report->publisher)
        <h3 class="subtitle is-6">{{ $entry->report->publisher }}</h3>
    @endif
</section>
<section class="section container content">
    <h5>@include('includes.title', ['entry' => $entry])</h5>
    @if( $entry->abstract )
        <p>{{ $entry->abstract }}</p>
    @endif
</section>
@stop
