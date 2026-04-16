@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <div class="container">
        <form action="{{ route($const['route'].'.update', [$const['route'] => $value->id]) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <label for="txt">{{$const['label']}}</label>
                    <input value="{{$value->name}}" name="name" id="txt"
                           class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <label for="txtSelect">{{$const['parent']}}</label>
                    <select name="select" id="txtSelect" class="form-select @error('select') is-invalid @enderror">
                        <option value="">Выберите значение</option>
                        @foreach($parent_value as $item)
                            @if ($item->id == $value->$name_id)
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
                </div>
            </div>

        <div class="mt-4 row">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-2 col-xxl-2">
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-2 col-xxl-2">
                    <a class="btn btn-info" href="/{{$const['route']}}">Назад</a>
                </div>
            </div>
        </form>
        <form action="{{ route($const['route'].'.destroy', [$const['route'] => $value->id])}}" method="POST">
            @csrf
            @method('DELETE')
            <div class="row mt-5">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <input type="submit" class="btn btn-danger" value="Удалить">
                </div>
            </div>
        </form>
    </div>
@endsection('info')


