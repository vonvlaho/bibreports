@extends('layouts.default')
@section('content')
    <section class="section" id="dataTable">
        <table class="table is-striped is-fullwidth">
            <tr>
                <th>Person</th>
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
            @foreach($people as $person)
                <tr>
                    <td>{{ $person['name'] }}</td>
                    <td>{{ $person['Y-1966'] }}</td>
                    <td>{{ $person['Y-1967'] }}</td>
                    <td>{{ $person['Y-1968'] }}</td>
                    <td>{{ $person['Y-1969'] }}</td>
                    <td>{{ $person['Y-1970'] }}</td>
                    <td>{{ $person['Y-1971'] }}</td>
                    <td>{{ $person['Y-1972'] }}</td>
                    <td>{{ $person['Y-1973'] }}</td>
                    <td>{{ $person['Y-1974'] }}</td>
                    <td>{{ $person['Y-1975'] }}</td>
                    <td>{{ $person['total'] }}</td>
                </tr>
            @endforeach
        </table>
    </section>
    <section class="section container" id="dataChart">
        <script id="jsonData">var data={!! json_encode($people) !!}</script>
    </section>
@stop
