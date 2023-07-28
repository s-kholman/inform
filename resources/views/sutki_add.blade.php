@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
            <form action="{{ route('sutki.add') }}" method="POST">
                @csrf
                    <label for="txtsutki">Введите название време суток</label>
                    <input name="sutki" id="txtTitle" class="form-control @error('sutki') is-invalid @enderror">
                @error('sutki')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>
@endsection('info')
