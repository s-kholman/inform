@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <form action="{{ route('height.update', ['height' => $height->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="txtHeight">Редактирование</label>
        <input name="height" value="{{$height->name}}" id="txtHeight" class="form-control @error('height') is-invalid @enderror">
        @error('height')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
        <input type="submit" class="btn btn-primary" value="Сохранить изменения">
        <a class="btn btn-info" href="/height">Назад</a>
    </form>


    <div>
        <form action="{{ route('height.destroy', ['height' => $height->id])}}" method="POST">
            @csrf
            @method('DELETE')
            <div><p>При нажатии кнопки удалить данные будут удаленны без подтверждения</p>
            <br><br><input type="submit" class="btn btn-danger" value="Удалить">
            </div>
        </form>
    </div>
@endsection('info')

