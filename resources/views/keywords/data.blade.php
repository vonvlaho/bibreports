@extends('layouts.default')
@section('content')
    <section class="section" id="dataTable">
        <table class="table is-striped is-fullwidth">
            <tr>
                <th>Schlagwort</th>
                {{--<th>1966</th>
                <th>1967</th>
                <th>1968</th>
                <th>1969</th>
                <th>1970</th>
                <th>1971</th>
                <th>1972</th>
                <th>1973</th>
                <th>1974</th>
                <th>1975</th>--}}
                <th>Summe</th>
            </tr>
            @foreach($keywords as $keyword)
                <tr>
                    <td>{{ $keyword['name'] }}</td>
                    {{--<td>{{ $keyword['1966'] }}</td>
                    <td>{{ $keyword['1967'] }}</td>
                    <td>{{ $keyword['1968'] }}</td>
                    <td>{{ $keyword['1969'] }}</td>
                    <td>{{ $keyword['1970'] }}</td>
                    <td>{{ $keyword['1971'] }}</td>
                    <td>{{ $keyword['1972'] }}</td>
                    <td>{{ $keyword['1973'] }}</td>
                    <td>{{ $keyword['1974'] }}</td>
                    <td>{{ $keyword['1975'] }}</td>--}}
                    <td>{{ $keyword['total'] }}</td>
                </tr>
            @endforeach
        </table>
    </section>
    <section class="section container" id="dataChart">
        <script id="jsonData">var data={!! json_encode($keywords) !!}</script>
    </section>
@stop
