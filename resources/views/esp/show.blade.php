@extends('layouts.base')
@section('title', 'Настройка контроллера температуры')

@section('info')
    <div class="container gx-4">
        <div class="col-xl-6 col-lg-6 col-sm-6">
    <form action="{{route('esp.settings.store')}}" method="post">
        @csrf

        <label for="deviceESP">Выберите устройство</label>
        <select name="deviceESP" id="deviceESP" class="form-select @error('deviceESP') is-invalid @enderror">
            <option value="0"></option>
            @forelse($devices as $device)
                <option value="{{$device->id}}"> {{$device->mac}} </option>
            @empty
                <option value="">Записи не найдены</option>
            @endforelse
        </select>
        @error('deviceESP')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="update_status">Статус обновления</label>
        <select name="update_status" id="update_status" class="form-select @error('update_status') is-invalid @enderror">
            <option value="0">Не обновлять</option>
            <option value="0">Обновить</option>
        </select>
        @error('update_status')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="update_url">URL обновления</label>
        <input placeholder="URL обновления"
               class="form-control @error('update_url') is-invalid @enderror"
               {{--value="{{old('update_url')}}"--}}
               value="https://develop.krimm.ru/storage/esp/update/temperature_v1.ino.bin"
               id="update_url"
               name="update_url"
        >
        @error('volume')
        <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
        @enderror

        <label for="thermometers">Выберите устройство</label>
        <select name="thermometers[]" id="thermometers" class="form-select @error('thermometers') is-invalid @enderror" multiple>
            @forelse($thermometers as $thermometer)
                <option value="{{ $thermometer->serial_number }}"> {{ $thermometer->serial_number}} </option>
            @empty

            @endforelse
        </select>
        @error('thermometers')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 col-xxl-2 p-2 ">
                <a class="btn btn-primary" href="/esp/settings">Назад</a>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 col-xxl-2 p-2 text-end">
                <input class="btn btn-primary" type="submit" value="Сохранить" name="save">
            </div>
        </div>
    </form>

        </div>
    </div>




@endsection('info')
