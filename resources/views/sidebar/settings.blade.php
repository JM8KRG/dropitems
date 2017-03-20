<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">個人設定</h3>
    </div>
    <div class="list-group">
        <a href="{{ action('Settings\ProfileController@index') }}" class="list-group-item">プロフィール</a>
        <a href="{{ action('Settings\AccountController@index') }}" class="list-group-item">アカウント</a>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">その他</h3>
    </div>
    <div class="list-group">
        <a href="{{ url('license') }}" class="list-group-item">ライセンス情報</a>
    </div>
</div>