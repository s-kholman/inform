@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
            <form action="{{ route('post.add') }}" method="POST">
                @csrf
                <div class="col-2">
                    <label for="txtPost">Введите должность</label>
                    <input name="post" id="txtPost" class="form-control @error('post') is-invalid @enderror">
                @error('post')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input type="submit" class="btn btn-primary" value="Сохранить">
                </div>
            </form>
@endsection('info')
