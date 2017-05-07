@extends('layouts.app')
@section('title', 'アイテム管理')
@section('contents')
<div class="container">
    <div class="row">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    アップロード済みのアイテム
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>状態</th>
                        <th>アイテム名</th>
                        <th>カテゴリー</th>
                        <th>アイテムの状態</th>
                        <th>出品日時</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($items) > 0)
                        @foreach($items as $item)
                            <tr>
                                @if($item->status === 0)
                                    <td><span class="label label-success">公開中</span></td>
                                    <td><a href="{{ action('Items\ItemController@index', ['item_id' => $item->item_id]) }}" target="_blank">{{ $item->name }} <i class="fa fa-window-restore" aria-hidden="true"></i></a></td>
                                @else
                                    <td><span class="label label-default">非公開</span></td>
                                    <td>{{ $item->name }}</td>
                                @endif
                                <td>{{ $item->category }}</td>
                                <td>{{ $item->condition }}</td>
                                <td>{{ $item->create_at }}</td>
                                <td>
                                    @if($item->status === 0)
                                        <a href="{{ action('User\UserItemController@updateItemStatus', ['item_id' => $item->item_id]) }}"><i class="fa fa-eye-slash" aria-hidden="true"></i> 非表示</a>
                                    @else
                                        <a href="{{ action('User\UserItemController@updateItemStatus', ['item_id' => $item->item_id]) }}"><i class="fa fa-eye" aria-hidden="true"></i> 表示</a>
                                    @endif
                                    <b>|</b>
                                    <a href="{{ action('User\UserItemController@destroyItem', ['item_id' => $item->item_id]) }}"><i class="fa fa-times" aria-hidden="true"></i> 削除</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">アイテムが見つかりません。</td>
                        </tr>
                    @endif
                    </tbody>
                </table>

                <nav class="pull-right">
                    <ul class="pagination">
                        {!! $pager !!}
                    </ul>
                </nav>
            </div>
        </div>

    </div>
</div>
@endsection