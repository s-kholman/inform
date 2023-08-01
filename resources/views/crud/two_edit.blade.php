@extends('layouts.base')
@section('title', 'Справочник')

@section('info')

    <div class="col-3">
        <form action="{{ route($const['route'].'.update', [$const['route'] => $value->id]) }}" method="POST">
            @csrf
            @method('PATCH')
            <label for="txt">{{$const['label']}}</label>
            <input value="{{$value->name}}" name="name" id="txt" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="txtSelect">{{$const['parent']}}</label>
            <select name="select" id="txtSelect" class="form-select @error('select') is-invalid @enderror">
                <option value="">Выберите значение</option>
                @foreach($parent_value as $item)

                    @if ($item->id == $value->szr_classes_id)
                        <option selected value="{{ $item->id }}">  {{ $item->name }} </option>

                    @else
                        <option value="{{ $item->id }}">  {{ $item->name }} </option>
                    @endif

                @endforeach
            </select>
            @error('select')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <input type="submit" class="btn btn-primary" value="Сохранить">
        </form>
    </div>

    <a class="btn btn-info" href="/{{$const['route']}}">Назад</a>


    <form action="{{ route($const['route'].'.destroy', [$const['route'] => $value->id])}}" method="POST">
        @csrf
        @method('DELETE')
        <br><br><input type="submit" class="btn btn-danger" value="Удалить">
    </form>

@endsection('info')


