@extends('layouts.default')
@section('content')
<section class="section container">
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
    @foreach($report->entries as $entry)

    @endforeach
</section>
@stop
