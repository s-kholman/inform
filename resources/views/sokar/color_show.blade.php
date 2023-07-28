@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <form action="{{ route('color.update', ['color' => $color->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="txtColor">Отредактируйте цвет одежды</label>
        <input name="color" value="{{$color->name}}" id="txtSize" class="form-control @error('color') is-invalid @enderror">
        @error('color')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
        <input type="submit" class="btn btn-primary" value="Сохранить изменения">
        <a class="btn btn-info" href="/color">Назад</a>
    </form>


    <div>
        <form action="{{ route('color.destroy', ['color' => $color->id])}}" method="POST">
            @csrf
            @method('DELETE')
            <div><p>При нажатии кнопки удалить данные будут удаленны без подтверждения</p>
            <br><br><input type="submit" class="btn btn-danger" value="Удалить">
            </div>
        </form>
    </div>
@endsection('info')

