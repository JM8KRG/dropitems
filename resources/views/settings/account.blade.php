@extends('layouts.app')
@section('title', 'アカウント設定')
@section('contents')
<div class="container">

    <div class="row">
        <div class="col-sm-3">
            @include('sidebar.settings')
        </div>

        <div class="col-sm-9">
            <div class="page-header" style="margin-top:-5px;padding-bottom:0px;">
                <h3>アカウント設定</h3>
            </div>

            <form action="{{ action('Settings\AccountController@updateEmail') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="email">
                        メールアドレス
                        <label class="label label-success">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            自分のみ
                        </label>
                    </label>
                    <input type="text" name="email" value="{{ $email }}" class="form-control" id="" placeholder="" spellcheck="false">
                </div>
                <div class="form-group">
                    <label for="old_password">
                        現在のパスワード
                    </label>
                    <input type="password" name="password" value="" class="form-control" id="" placeholder="">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning">更新</button>
                </div>
            </form>

            <hr/>

            <form action="{{ action('Settings\AccountController@updatePassword') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="old_password">
                        現在のパスワード
                    </label>
                    <input type="password" name="old_password" value="" class="form-control" id="" placeholder="">
                </div>
                <div class="form-group">
                    <label for="new_password">
                        パスワード
                    </label>
                    <input type="password" name="password" value="" class="form-control" id="" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">
                        パスワード
                    </label>
                    <input type="password" name="password_confirmation" value="" class="form-control" id="" placeholder="">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning">更新</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
