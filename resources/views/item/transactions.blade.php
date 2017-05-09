@extends('layouts.app')
@section('title', '取引管理')
@section('contents')
<div class="container">
    <div class="row">

        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#trading" data-toggle="tab">取引中</a></li>
                <li><a href="#history" data-toggle="tab">取引履歴</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="trading">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>アイテム名</th>
                                <th>メッセージ</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($transactions->trading))
                            @foreach($transactions->trading as $transaction)
                            <tr>
                                <td>{{ $transaction->name }}</td>
                                <td><a href="{{ action('User\UserMessageController@index', ['item_id' => $transaction->item_id]) }}">詳細</a></td>
                                <td><a href="{{ action('User\UserTransactionController@closeTrade', ['item_id' => $transaction->item_id]) }}">取引を完了する</a></td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">現在、取引中のアイテムはありません。</td>
                            </tr>
                        </tbody>
                        @endif
                    </table>
                </div>
                <div class="tab-pane" id="history">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>アイテム名</th>
                            <th>完了日時</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($transactions->history))
                            @foreach($transactions->history as $transaction)
                                <tr>
                                    <td>{{ $transaction->name }}</td>
                                    <td>{{ $transaction->completed_at }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">過去に取引したアイテムはありません。</td>
                            </tr>
                        </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection