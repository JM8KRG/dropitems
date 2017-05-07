@extends('layouts.app')
@section('title', 'アイテム管理')
@section('contents')
<div class="container">
    <div class="row">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    アイテム情報
                </div>
                <div class="panel-body">
                        <div class="media">
                            <a class="media-left" href="{{ action('Items\ItemController@index', ['item_id' => $item->item_id])  }}">
                                <img height="100px" width="100px" src="{{ asset('storage/images/'.$item->image1) }}">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">{{ $item->name }}</h4>
                                <p>{{ $item->description }}</p>
                                <p>出品日時：{{ date('Y年n月j日 H時i分', strtotime($item->create_at)) }}</p>
                            </div>
                        </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-warning pull-right">
                        <i class="fa fa-lg fa fa-paper-plane"></i>
                        受け取り申請する
                    </button>
                    <div class="clearfix">

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
