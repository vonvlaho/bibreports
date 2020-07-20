@extends('layouts.default')
@section('content')
<section class="hero container">
    <div class="hero-body">
        <h1 class="title is-4">
            Musikwissenschaftliche Forschung in der DDR 1966–1975
        </h1>
        <h2 class="subtitle is-6">Digitale Reproduktion der F-Teile aus den Jahresbibliographien <a href="#Hintergrund"><em>Berichte über die musikwissenschaftlichen Arbeiten in der Deutschen Demokratischen Republik</em></a>.</h2>
        <nav>
            <ul>
                @foreach ($reports as $report)
                    <li><a href="{{ route('reports.show', $report) }}">{{ $report->title }} {{$report->year}}</a></li>
                @endforeach
            </ul>
        </nav>
    </div>
</section>
<section class="section container">
    <h2 class="title is-5" id="Hintergrund">Hintergrund</h2>
    <p>
        Die Berichte über die Musikwissenschaftlichen Arbeiten der Deutschen Demokratischen Republik erschienen für die Jahre 1966 bis 1975 jährlich jeweils im Folgejahr.  Herausgegeben wurden sie vom Zentralinstitut für Musikforschung, einer im Verband der Komponisten und Musikwissenschaftler der DDR verankerten Koordinierungs- und Forschungsabteilung. Die Gründung dieses Instituts wurde vom Ministerium für Kultur am 30. November 1961 in den Verfügungen und Mitteilung des Ministeriums offiziell bekannt gegeben. Die Verankerung des Instituts in einem Verband war insofern eine Besonderheit, als solche Forschungsinstitute mehrheitlich an der Akademie der Wissenschaften der DDR angesiedelt waren. 1980 wurde das Zentralinstitut dementsprechend auch aus dem Verband herausgelöst und in die Akademie der Wissenschaften eingegliedert.
    </p>
</section>
@stop
