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
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">カテゴリー <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        @foreach($categories as $category)
                            <li><a href="#">{{ $category->category }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="{{ action('User\ItemUploader@index') }}">アップロード</a></li>
                <li><a href="{{ action('User\UserItemController@index') }}">アイテム管理</a></li>
                <li><a href="{{ action('User\UserTransactionController@index') }}">取引管理</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ \Sentinel::getUser()->screen_name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ action('Settings\ProfileController@index') }}"><i class="fa fa-cogs" aria-hidden="true"></i> 設定</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ action('Sentinel\LoginController@logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> ログアウト</a></li>
                        <li class="dropdown-header">ver: 1.00</li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

@include('layouts.success')
@include('layouts.errors')

@if (Session::has('danger'))
<div class="container">
    <div class="alert alert-danger">{{ Session::get('danger') }}</div>
</div>
@endif

@yield('contents')

<script src="{{ asset('/js/jquery-3.2.0.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
@yield('js')
</body>
</html>