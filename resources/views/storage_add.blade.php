@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
            <form action="{{ route('storage.add') }}" method="POST">
                @csrf
                    <label for="txtstorage">Введите название склада</label>
                    <input name="storage" id="txtstorage" class="form-control ">

                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>

    @foreach(\App\Models\Storage::all() as $value)
    {{$value->name}}<br>
    @endforeach

@endsection('info')
