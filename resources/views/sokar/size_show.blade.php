@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <form action="{{ route('size.update', ['size' => $size->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="txtSize">Отредактируйте размер одежды</label>
        <input name="size" value="{{$size->name}}" id="txtSize" class="form-control @error('size') is-invalid @enderror">
        @error('size')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <select name="size_type" id="size_type" class="form-select @error('size_type') is-invalid @enderror">
            <option id="size_type" value="">Выберите тип</option>
            <option value="{{ $size_type['shoe']['type'] }}">  {{ $size_type['shoe']['name'] }} </option>
            <option value="{{ $size_type['body']['type']}}">  {{ $size_type['body']['name']}} </option>
            <option value="{{ $size_type['head']['type'] }}">  {{ $size_type['head']['name'] }} </option>

        </select>
        @error('size_type')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <input type="submit" class="btn btn-primary" value="Сохранить изменения">
        <a class="btn btn-info" href="/size">Назад</a>
    </form>


    <div>
        <form action="{{ route('size.destroy', ['size' => $size->id])}}" method="POST">
            @csrf
            @method('DELETE')
            <div><p>При нажатии кнопки удалить данные будут удаленны без подтверждения</p>
            <br><br><input type="submit" class="btn btn-danger" value="Удалить">
            </div>
        </form>
    </div>
@endsection('info')

