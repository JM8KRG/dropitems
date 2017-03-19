<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name')  }} - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

    @yield('css')
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ action('HomeController@index') }}">{{ config('app.name') }}</a>
        </div>
    </div>
</nav>
@include('layouts.errors')

@yield('contents')

<script src="{{ asset('/js/jquery-3.2.0.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
@yield('js')
</body>
</html>