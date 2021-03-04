<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Musikwissenschaftliche Forschung in der DDR 1966–1975: Digitale Reproduktion der F-Teile aus den
        Jahresbibliographien Berichte über die musikwissenschaftlichen Arbeiten in der Deutschen Demokratischen
        Republik.</title>

    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <link rel="stylesheet" type="text/css" href="/fontawesome/css/all.min.css">
</head>
<body>
@include('includes.header')
<main>
    @yield('content')
</main>
@include('includes.footer')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="/js/app.js"></script>
</body>
</html>
