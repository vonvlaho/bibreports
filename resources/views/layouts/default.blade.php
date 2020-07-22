<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Musikwissenschaftliche Forschung in der DDR 1966–1975: Digitale Reproduktion der F-Teile aus den
        Jahresbibliographien Berichte über die musikwissenschaftlichen Arbeiten in der Deutschen Demokratischen
        Republik.</title>

    <link rel="stylesheet" type="text/css" href="/css/app.css">
</head>
<body>
@include('includes.header')
<main>
    @yield('content')
</main>
@include('includes.footer')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
        if ($navbarBurgers.length > 0) {
            $navbarBurgers.forEach( el => {
                el.addEventListener('click', () => {
                    const target = el.dataset.target;
                    const $target = document.getElementById(target);
                    el.classList.toggle('is-active');
                    $target.classList.toggle('is-active');
                });
            });
        }
    });
</script>
</body>
</html>
