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
                <div class="mt-2">
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                </div>

            </form>
    </div>
    @forelse($value as $device)
        <div class="row mt-2">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-4 border border-1">{{$device[$const['parent_name']]['name'] ?? '1'}}</div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-4 border border-1"><a href="\{{$const['route']}}\{{$device->id}}\edit">{{$device->name}}</a></div>
        </div>
    @empty
    @endforelse

    </div>
@endsection('info')
