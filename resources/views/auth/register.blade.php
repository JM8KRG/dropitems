@extends('layouts.guest')
@section('title', 'アカウント作成')
@section('contents')
<div class="container">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
            @include('layouts.errors')

            <div class="panel panel-default">
                <div class="panel-heading">アカウント作成</div>
                <div class="panel-body">

                    <form class="form-horizontal" action="{{ action('Sentinel\RegisterController@store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="mail" class="col-sm-2 control-label">ユーザー名</label>
                            <div class="col-sm-10">
                                <input type="text" name="screen_name" class="form-control" id="" placeholder="ユーザー名">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mail" class="col-sm-2 control-label">メール</label>
                            <div class="col-sm-10">
                                <input type="text" name="email" class="form-control" id="" placeholder="メール">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pass" class="col-sm-2 control-label">パスワード</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" id="" placeholder="パスワード">
                                <p class="help-block">8文字以上</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pass" class="col-sm-2 control-label">パスワード</label>
                            <div class="col-sm-10">
                                <input type="password" name="password_confirmation" class="form-control" id="" placeholder="パスワード">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success">登録（無料）</button>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                                <a href="{{ action('Sentinel\LoginController@index') }}">すでにアカウントを持っています。</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
