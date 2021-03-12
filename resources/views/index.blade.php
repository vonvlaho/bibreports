@extends('layouts.default')
@section('content')
    <section class="section container has-background-light">
        <nav class="breadcrumb has-bullet-separator is-centered">
            <ul>
                <li>
                    <a href="{{ route('reports.store') }}" class="is-family-monospace">
                        Berichte
                    </a>
                </li>
                <li>
                    <a href="{{ route('keywords.store') }}" class="is-family-monospace">
                        Register
                    </a>
                </li>
                <li>
                    <a href="{{ route('places.store') }}" class="is-family-monospace">
                        Publikationsorte
                    </a>
                </li>
                <li>
                    <a href="{{ route('analytics') }}" class="is-family-monospace">
                        Analyse
                    </a>
                </li>
            </ul>
        </nav>
        <form action="{{ route('search.search') }}" method="GET">
            @csrf
            <div class="field has-addons mt-6">
                <div class="control is-expanded" style="max-width: 450px">
                    <input class="input" type="text" placeholder="Suchanfrage" name="search"/>
                </div>
                <div class="control">
                    <button type="submit" class="button is-link">Search</button>
                </div>
            </div>
        </form>
    </section>
    <section class="section container content">
        <h2 class="title is-5" id="Hintergrund">Hintergrund</h2>
        <p>
            Eine offizielle Bibliographie der musikwissenschaftlichen Schriften der DDR erschien als selbständige Publikation erstmals öffentlich mit dem Bericht über die Musikwissenschaftlichen Arbeiten der Deutschen Demokratischen Republik 1966. „Das Ziel war, alle 1966 produzierten musikwissenschaftlichen Arbeiten zu erfassen“, schildert dessen Vorwort. Seit Anfang der 1960er Jahre arbeitete man am Zentralinstitut bereits an einer Lochkartei zur systematischen Erfassung dieser Bibliographie seit 1945, mit dem Bericht über die musikwissenschaftlichen Arbeiten erschien jedoch erstmals ein Verzeichnis der aktuellsten Publikationen. Es wurden Monographien, Artikel in Fachzeitschriften, Editionen, Dissertationen und weiteres musikwissenschaftliches Schrifttum erfasst. Musikwissenschaftler*innen aus der DDR waren dazu angehalten, bibliographische Notizen und Abstracts zu ihren Forschungsarbeiten ans Zentralinstitut für Musikforschung zu schicken, das als Redaktion der Berichte fungierte.
        </p>
    </section>
@stop
