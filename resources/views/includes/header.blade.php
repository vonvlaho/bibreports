@if( Route::current()->uri === 'reports')
    <header class="section container">
        <h1 class="title is-4">
            Musikwissenschaftliche Forschung in der DDR 1966–1975
        </h1>
        <h2 class="subtitle is-6">Digitale Reproduktion der F-Teile aus den Jahresbibliographien <a href="#Hintergrund"><em>Berichte über die musikwissenschaftlichen Arbeiten in der Deutschen Demokratischen Republik</em></a>.</h2>
    </header>
@else
<nav class="navbar is-light" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ route('reports.store') }}">
            <h1 class="title is-6">Musikwissenschaftliche Forschung in der DDR 1966–1975</h1>
        </a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbar">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <div id="navbar" class="navbar-menu">
        <div class="navbar-end">
            <div class="navbar-item">
                <a href="{{ route('reports.store') }}" class="is-family-monospace">
                    Übersicht
                </a>
            </div>
            <div class="navbar-item">
                <a href="{{ route('keywords.store') }}" class="is-family-monospace">
                    Gesamtregister
                </a>
            </div>
            <div class="navbar-item">
                <a href="{{ route('reports.store') . '#Hintergrund' }}" class="is-family-monospace">
                    Hintergrund
                </a>
            </div>
        </div>
    </div>
</nav>
@endif
