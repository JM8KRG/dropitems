@extends('layouts.app')
@section('title', 'アイテム管理')
@section('contents')
<div class="container">
    <div class="row">

        <div class="col-sm-12">
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
                @foreach($items as $item)
                    <tr>
                        @if($item->status === 0)
                            <td><span class="label label-success">公開中</span></td>
                        @else
                            <td><span class="label label-default">非公開</span></td>
                        @endif
                        <td>{{ $item->name }}</td>
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
                            <a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> 削除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection