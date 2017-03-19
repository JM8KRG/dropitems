@extends('layouts.app')
@section('title', 'プロフィール設定')
@section('contents')
<div class="container">

    <div class="row">
        <div class="col-sm-3">
            @include('sidebar.settings')
        </div>

        <div class="col-sm-9">

            <div class="page-header" style="margin-top:-15px;padding-bottom:0px;">
                <h3>プロフィール設定</h3>
            </div>

            <form action="{{ action('Settings\ProfileController@store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">スクリーンネーム</label>
                    <input type="text" name="screen_name" value="{{ $profile->screen_name }}" class="form-control" id="" placeholder="">
                </div>
                <div class="form-group">
                    <label for="last_name">姓</label>
                    <input type="text" name="last_name" value="{{ $profile->last_name }}" class="form-control" id="" placeholder="">
                </div>
                <div class="form-group">
                    <label for="first_name">名</label>
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
