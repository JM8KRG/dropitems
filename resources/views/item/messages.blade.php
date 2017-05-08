@extends('layouts.app')
@section('title', 'メッセンジャー')
@section('contents')
<div class="container">
    <div class="row">

        <div class="col-sm-12">
            <form action="{{ action('User\UserMessageController@store') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="item_id" value="{{ $item_id }}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        「{{ $item_name }}」の取引メッセージ作成
                    </div>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="message" value="">
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary pull-right">
                            <i class="fa fa-lg fa fa-paper-plane"></i>
                            送信する
                        </button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>

            @if($messages)
                @foreach($messages as $message)
                <div class="panel panel-{{ $message->you ? 'default' : 'primary' }}">
                    <div class="panel-heading">
                        {{ $message->you ? '自分' : $message->sender.'から' }}のメッセージ
                    </div>
                    <div class="panel-body">
                        {{ $message->body }}
                    </div>
                    <div class="panel-footer text-muted">
                        送信日：{{ date('Y年n月j日 H時i分', strtotime($message->create_at)) }}
                    </div>
                </div>
                @endforeach
            @endif
        </div>

    </div>
</div>
@endsection