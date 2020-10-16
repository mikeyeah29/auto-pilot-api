<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/docs.css') }}" rel="stylesheet">
</head>

<body>

    @yield('side_bar')

    <div class="main container-fluid">

        <nav class="main_nav">
            <ul class="no_bullet">
                <li>
                    <a href="{{ route('docs.index') }}">Overview</a>
                </li>
                <li>
                    <a href="schema.text">Database Schema</a>
                </li>
                <li>
                    <a href="{{ route('docs.api.ref') }}">API Reference</a>
                </li>
            </ul>
        </nav>

        @yield('content')

    </div>

</body>