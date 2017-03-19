@extends('layouts.guest')
@section('title', 'ログイン')
@section('contents')
<div class="container">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">{{ config('app.name') }}にログイン</div>
                <div class="panel-body">
                    <form class="form-horizontal" action="{{ action('Sentinel\LoginController@index') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="mail" class="col-sm-2 control-label">ID</label>
                            <div class="col-sm-10">
                                <input type="text" name="id" class="form-control" id="" placeholder="スクリーンネーム or メールアドレス">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pass" class="col-sm-2 control-label">パスワード</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" id="" placeholder="パスワード">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" value="true"> 次回から自動ログイン
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">ログイン</button>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                                <a href="{{ action('Sentinel\RegisterController@index') }}">アカウントを作る。</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
