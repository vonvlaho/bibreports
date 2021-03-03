@extends('layouts.default')
@section('content')
    <section class="section container">
        <table id="dataTable" class="table display">
            <thead>
                <tr>
                    <td>Schlagwort</td>
                    <td>1966</td>
                    <td>1967</td>
                    <td>1968</td>
                    <td>1969</td>
                    <td>1970</td>
                    <td>1971</td>
                    <td>1972</td>
                    <td>1973</td>
                    <td>1974</td>
                    <td>1975</td>
                    <td>Summe</td>
                </tr>
            </thead>
            <tbody>
                @foreach($keywords as $keyword)
                    <tr>
                        <td>{{ $keyword['name'] }}</td>
                        <td>{{ $keyword['count']['1966'] }}</td>
                        <td>{{ $keyword['count']['1967'] }}</td>
                        <td>{{ $keyword['count']['1968'] }}</td>
                        <td>{{ $keyword['count']['1969'] }}</td>
                        <td>{{ $keyword['count']['1970'] }}</td>
                        <td>{{ $keyword['count']['1971'] }}</td>
                        <td>{{ $keyword['count']['1972'] }}</td>
                        <td>{{ $keyword['count']['1973'] }}</td>
                        <td>{{ $keyword['count']['1974'] }}</td>
                        <td>{{ $keyword['count']['1975'] }}</td>
                        <td>{{ $keyword['count']['total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@stop
