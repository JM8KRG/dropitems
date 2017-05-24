@extends('layouts.app')
@section('title', '「'.$category.'」に該当するアイテム')
@section('contents')
    <div class="container">
        <div class="row">

            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $category }}
                    </div>
                    <div class="panel-body">
                        @if(count($items) > 0)
                            @foreach($items as $key => $item)
                                <div class="media">
                                    <a class="media-left" href="{{ action('Items\ItemController@index', ['item_id' => $item->item_id])  }}">
                                        <img height="100px" width="100px" src="{{ asset('storage/images/'.$item->image1) }}">
                                    </a>
                                    <div class="media-body">
                                        <a href="{{ action('Items\ItemController@index', ['item_id' => $item->item_id])  }}"><h4 class="media-heading">{{ $item->name }}</h4></a>
                                        <p>{{ $item->description }}</p>
                                    </div>
                                </div>
                                @if (count($items) !== $key+1)
                                    <hr>
                                @endif
                            @endforeach
                        @else
                            アイテムがありません。
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection