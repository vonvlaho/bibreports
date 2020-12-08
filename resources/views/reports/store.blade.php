@extends('layouts.default')
@section('content')
<section class="section container">
    @foreach ($reports as $report)
        @if($loop->first || $loop->iteration % 3 === 1)
            <div class="tile is-ancestor">
        @endif
                <div class="tile is-parent is-4">
                    <article class="tile is-child box">
                        <figure class="image is-small">
                            <a href="{{ route('reports.show', $report) }}"><img src="/img/{{ $report->cover }}"></a>
                        </figure>
                        <a href="{{ route('reports.show', $report) }}">{{ $report->title }} {{$report->year}}</a>
                    </article>
                </div>
        @if($loop->iteration % 3 === 0 || $loop->last)
            </div>
        @endif
    @endforeach
</section>
<section class="section container content">
    <h2 class="title is-5" id="Hintergrund">Hintergrund</h2>
    <p>
        Eine offizielle Bibliographie der musikwissenschaftlichen Schriften der DDR erschien als selbständige Publikation erstmals öffentlich mit dem Bericht über die Musikwissenschaftlichen Arbeiten der Deutschen Demokratischen Republik 1966. „Das Ziel war, alle 1966 produzierten musikwissenschaftlichen Arbeiten zu erfassen“, schildert dessen Vorwort. Seit Anfang der 1960er Jahre arbeitete man am Zentralinstitut bereits an einer Lochkartei zur systematischen Erfassung dieser Bibliographie seit 1945, mit dem Bericht über die musikwissenschaftlichen Arbeiten erschien jedoch erstmals ein Verzeichnis der aktuellsten Publikationen. Es wurden Monographien, Artikel in Fachzeitschriften, Editionen, Dissertationen und weiteres musikwissenschaftliches Schrifttum erfasst. Musikwissenschaftler*innen aus der DDR waren dazu angehalten, bibliographische Notizen und Abstracts zu ihren Forschungsarbeiten ans Zentralinstitut für Musikforschung zu schicken, das als Redaktion der Berichte fungierte.
    </p>
</section>
@stop
