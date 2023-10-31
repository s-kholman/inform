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
                    @foreach($parent_value as $item)

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
    @forelse($value as $device)
        <div class="row">
            <div class="col-3 border border-1">{{collect($device)[$const['parent_name']]['name']}}</div>
            <div class="col-3 border border-1"><a href="\{{$const['route']}}\{{$device->id}}\edit">{{$device->name}}</a></div>
        </div>
    @empty
    @endforelse

    </div>
@endsection('info')
