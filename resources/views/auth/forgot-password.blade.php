@extends('layouts.base')
@section('content')
<h1>Сброс пароля</h1>
<form action="{{ route('password.email') }}" method="post">
@csrf
<!-- Email -->
    <div class="col-4">
    <label for="email">Email</label>
    <input class="form-control" type="email" name="email" id="email" />
    <br>
    <!-- Submit button -->
    <button class="btn btn-primary" type="submit">Сбросить</button>
    </div>
</form>
@endsection
