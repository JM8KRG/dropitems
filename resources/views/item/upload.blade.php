@extends('layouts.app')
@section('title', 'アップロード')
@section('css')
<link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
@endsection
@section('contents')
<div class="container">
    <div class="row">

        <div class="col-sm-12">
            <div id="my-awesome-dropzone" class="dropzone"></div>
        </div>

        <div class="col-sm-12">
            <form id="upload" action="{{ action('User\ItemUploader@store') }}" method="POST">

                {{ csrf_field() }}

                <div class="form-group">
                    <label for="item_name">アイテム名</label>
                    <input type="text" name="item_name" value="" class="form-control" id="" placeholder="">
                </div>
                <div class="form-group">
                    <label for="description">アイテム説明</label>
                    <textarea name="item_description" rows="5" class="form-control" id="" placeholder=""></textarea>
                </div>
                <div class="form-group">
                    <label for="condition_id">アイテムの状態</label>
                    <select name="condition_id" class="form-control">
                        <option value="">選択してください</option>
                        <option value="1">非常に良い</option>
                        <option value="2">良い</option>
                        <option value="3">可</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category_id">カテゴリー</label>
                    <select name="category_id" id="" class="form-control">
                        <option value="">選択してください</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button id="up-btn" type="submit" class="btn btn-block btn-warning btn-lg">
                        <i class="fa fa-lg fa-cloud-upload"></i>
                        出品する
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/dropzone.js') }}"></script>
<script>
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#my-awesome-dropzone", {
        url:"dropitems//upload/images",
        params: {
            _token: $('input[name="_token"]').val()
        },
        addRemoveLinks: false,
        dictDefaultMessage: '<i class="fa fa-picture-o fa-2x"></i><p>画像をここにドロップするか<br/>ここをクリックして下さい</p>',
        acceptedFiles: "image/jpeg,image/png",
        maxFiles: 3,
        parallelUploads: 2,

        success: function (file, response) {
            $('form#upload').append('<input type="hidden" name="images[]" value="' + response.name + '">');
        }
    });
</script>
@endsection