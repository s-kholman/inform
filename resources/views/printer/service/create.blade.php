@extends('layouts.base')
@section('title', 'Внести ремонт')

@section('info')
    <div class="col-3">
        <form action="{{ route('service.store') }}" method="POST">
            @csrf
            {{\App\Models\filial::where('id',$currentStatus->filial_id)->value('name')}}
            <select name="service_name" id="txtFilial" class="form-select @error('service_name') is-invalid @enderror">
                <option value="">Выберите значение</option>
                @foreach(\App\Models\ServiceName::all() as $value)
                    <option value="{{ $value->id }}">  {{ $value->name }} </option>
                @endforeach
            </select>
            @error('service_name')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
            </span>
            @enderror
            <input type="date" name="date" value="{{\Carbon\Carbon::today()->format('Y-m-d')}}" class="form-control">

            <input hidden name="device_id" value="{{$currentStatus->device_id}}">
            <input hidden name="filial_id" value="{{$currentStatus->filial_id}}">

            <input class="form-control" type="submit" name="save" value="Сохранить">
        </form>
    </div>
@endsection('info')
