@extends('layouts.default')
@section('content')
<section class="section container">
    <div class="tile is-ancestor">
        @foreach ($reports as $report)
            <div class="tile is-parent is-4">
                <article class="tile is-child box">
                    <figure class="image is-small">
                        <a href="{{ route('reports.show', $report) }}"><img src="/img/{{ $report->cover }}"></a>
                    </figure>
                    <a href="{{ route('reports.show', $report) }}">{{ $report->title }} {{$report->year}}</a>
                </article>
            </div>
        @endforeach
    </div>
</section>
<section class="section container content">
    <h2 class="title is-5" id="Hintergrund">Hintergrund</h2>
    <p>
        Die Berichte über die Musikwissenschaftlichen Arbeiten der Deutschen Demokratischen Republik erschienen für die Jahre 1966 bis 1975 jährlich jeweils im Folgejahr.  Herausgegeben wurden sie vom Zentralinstitut für Musikforschung, einer im Verband der Komponisten und Musikwissenschaftler der DDR verankerten Koordinierungs- und Forschungsabteilung. Die Gründung dieses Instituts wurde vom Ministerium für Kultur am 30. November 1961 in den Verfügungen und Mitteilung des Ministeriums offiziell bekannt gegeben. Die Verankerung des Instituts in einem Verband war insofern eine Besonderheit, als solche Forschungsinstitute mehrheitlich an der Akademie der Wissenschaften der DDR angesiedelt waren. 1980 wurde das Zentralinstitut dementsprechend auch aus dem Verband herausgelöst und in die Akademie der Wissenschaften eingegliedert.
    </p>
</section>
@stop
