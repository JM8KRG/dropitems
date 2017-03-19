<div class="container">
@if (session('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
</div>
