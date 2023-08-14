@extends('layouts.base')
@section('title', 'Новое устройство')

@section('info')
    <div class="col-3">
        <form action="{{ route('device.store') }}" method="POST">
            @csrf

            <label for="mac">MAC</label>
            <input name="mac" value="{{ old('mac') }}" id="mac" class="form-control @error('mac') is-invalid @enderror">
            @error('mac')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="sn">SN</label>
            <input name="sn" value="{{ old('sn') }}" id="sn" class="form-control @error('sn') is-invalid @enderror">
            @error('sn')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="device_names_id">Выберите модель</label>
            <select name="device_names_id" id="device_names_id" class="form-select @error('device_names_id') is-invalid @enderror">
                <option value="">Выберите значение</option>
                @foreach(\App\Models\DeviceName::all() as $value)
                    <option {{ old('device_names_id') == $value->id ? "selected" : "" }} value="{{ $value->id }}">  {{ $value->name }} </option>
                @endforeach
            </select>
            @error('device_names_id')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
            </span>
            @enderror

            <input type="date" value="{{ old('date') ?: \Carbon\Carbon::today()->format('Y-m-d') }}" name="date" class="form-control">


            <input class="form-control" type="submit" name="save" value="Сохранить">

            <div class="row-cols-4 p-5"><a class="btn btn-info" href="{{ url()->previous() }}">Назад</a></div>
        </form>
    </div>
@endsection('info')
