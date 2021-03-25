@extends('layouts.default')
@section('content')
    <section class="hero">
        <div class="hero-body">
            <p class="title has-text-centered">
                {{ $title }}
            </p>
        </div>
    </section>
    <section class="section" id="dataTable">
        <table class="table is-striped is-fullwidth">
            <tr>
                <th>{{ $title }}</th>
                <th>1966</th>
                <th>1967</th>
                <th>1968</th>
                <th>1969</th>
                <th>1970</th>
                <th>1971</th>
                <th>1972</th>
                <th>1973</th>
                <th>1974</th>
                <th>1975</th>
                <th>Summe</th>
            </tr>
            @foreach($items as $item)
                <tr>
                    @if($title === 'Orte')
                        <td><a href="{{ route('data.places.show', $item['id']) }}">{{ $item['name'] }}</a></td>
                    @elseif($title === 'Schlagworte')
                        <td><a href="{{ route('data.keywords.show', $item['id']) }}">{{ $item['name'] }}</a></td>
                    @elseif($title === 'Personen')
                        <td><a href="{{ route('data.people.show', $item['id']) }}">{{ $item['name'] }}</a></td>
                    @endif
                    <td>{{ $item['Y-1966'] }}</td>
                    <td>{{ $item['Y-1967'] }}</td>
                    <td>{{ $item['Y-1968'] }}</td>
                    <td>{{ $item['Y-1969'] }}</td>
                    <td>{{ $item['Y-1970'] }}</td>
                    <td>{{ $item['Y-1971'] }}</td>
                    <td>{{ $item['Y-1972'] }}</td>
                    <td>{{ $item['Y-1973'] }}</td>
                    <td>{{ $item['Y-1974'] }}</td>
                    <td>{{ $item['Y-1975'] }}</td>
                    <td>{{ $item['total'] }}</td>
                </tr>
            @endforeach
        </table>
    </section>
    <section class="section container" id="dataChart">
        <script id="jsonData">var data={!! json_encode($items) !!}</script>
    </section>
@stop
