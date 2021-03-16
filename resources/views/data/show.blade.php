@extends('layouts.default')
@section('content')
    <h2 class="title">{{ $title }}</h2>
    <section class="section" id="dataTable">
        <table class="table is-striped is-fullwidth">
            <tr>
                <th>{{ $dataTitle }}</th>
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
                    <td>{{ $item['name'] }}</td>
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
