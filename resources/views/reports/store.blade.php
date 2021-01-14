@extends('layouts.default')
@section('content')
<section class="section container">
    @foreach ($reports as $report)
        @if($loop->first || $loop->iteration % 4 === 1)
            <div class="tile is-ancestor">
        @endif
                <div class="tile is-parent is-3">
                    <article class="tile is-child box">
                        <figure class="image is-small">
                            <a href="{{ route('reports.show', $report) }}"><img src="/img/{{ $report->cover }}"></a>
                        </figure>
                        <a href="{{ route('reports.show', $report) }}">{{ $report->title }} {{$report->year}}</a>
                    </article>
                </div>
        @if($loop->iteration % 4 === 0 || $loop->last)
            </div>
        @endif
    @endforeach
</section>
@stop
