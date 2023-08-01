@extends('layouts.base')
@section('title',$const['title'])

@section('info')
    <div class="container">
    <div class="col-6">
            <form action="{{ route($const['route'].'.store') }}" method="POST">
                @csrf
                    <label for="txt">{{$const['label']}}</label>
                    <input name="name" id="txt" class="form-control @error('name') is-invalid @enderror">
                @error('name')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtSelect">{{$const['parent']}}</label>
                <select name="select" id="txtSelect" class="form-select @error('select') is-invalid @enderror">
                    <option value="">Выберите значение</option>
                    @foreach($parrent_value as $item)

                        <option value="{{ $item->id }}">  {{ $item->name }} </option>
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
    @forelse($value as $value)
        <div class="row col-6 border border-1">
            <div class="col-6">{{$value->ParrentName->name}}</div> <div class="col-6"><a href="\{{$const['route']}}\{{$value->id}}\edit">{{$value->name}}</a></div>
        </div>
    @empty
    @endforelse

    </div>
@endsection('info')
