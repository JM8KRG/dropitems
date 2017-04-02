@extends('layouts.app')
@section('title', 'アップロード')
@section('contents')
<div class="container">

        <form action="{{ action('User\ItemUploader@store') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="item_name">アイテム名</label>
                <input type="text" name="item_name" value="" class="form-control" id="" placeholder="">
            </div>
            <div class="form-group">
                <label for="description">アイテム説明</label>
                <textarea name="description" rows="5" class="form-control" id="" placeholder=""></textarea>
            </div>
            <div class="form-group">
                <label for="condition_id">アイテムの状態</label>
                <select name="condition_id" id="" class="form-control">
                    <option value="3">非常に良い</option>
                    <option value="2">良い</option>
                    <option value="1">可</option>
                </select>
            </div>
            <div class="form-group">
                <label for="category_id">カテゴリー</label>
                <select name="category_id" id="" class="form-control">

                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-warning btn-lg">
                    <i class="fa fa-lg fa-cloud-upload"></i>
                    アップロード
                </button>
            </div>
        </form>

</div>
@endsection
