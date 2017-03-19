@extends('layouts.app')
@section('title', 'プロフィール設定')
@section('contents')
<div class="container">

    <div class="row">
        <div class="col-sm-3">
            @include('sidebar.settings')
        </div>

        <div class="col-sm-9">
            <div class="page-header" style="margin-top:-5px;padding-bottom:0px;">
                <h3>プロフィール設定</h3>
            </div>

            <form action="{{ action('Settings\ProfileController@updateScreenName') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">
                        スクリーンネーム
                        <label class="label label-default">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            公開
                        </label>
                    </label>
                    <input type="text" name="screen_name" value="{{ $profile->screen_name }}" class="form-control" id="" placeholder="" spellcheck="false">
                    <p class="help-block">他の人と同じネームは使えません。</p>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning">更新</button>
                </div>
            </form>

            <hr/>

            <form action="{{ action('Settings\ProfileController@updateProfile') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="last_name">
                        姓
                        <label class="label label-success">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            自分のみ
                        </label>
                    </label>
                    <input type="text" name="last_name" value="{{ $profile->last_name }}" class="form-control" id="" placeholder="">
                </div>
                <div class="form-group">
                    <label for="first_name">
                        名
                        <label class="label label-success">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            自分のみ
                        </label>
                    </label>
                    <input type="text" name="first_name" value="{{ $profile->first_name }}" class="form-control" id="" placeholder="">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning">更新</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
