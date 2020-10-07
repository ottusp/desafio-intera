<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'INTERA | Conectando talentos a empresas inovadoras')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap">

    <link rel="stylesheet" href="{{ asset('styles/classes.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/pop-up.css') }}">


    <link rel="shortcut icon" href="{{ asset('assets/intera-logo-pequena.png') }}" type="image/png">


    <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>

    @yield('styles')

    @yield('scripts')

    @yield('imports')

    <link rel="stylesheet" href="{{ asset('styles/navbar.css') }}">

</head>
<body>

    @include('partials.navbar')

    @yield('content')
</body>
</html>
