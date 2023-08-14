@extends('layouts.base')
@section('title', 'Справочник')
@section('info')

    <div class="container text-center border border-2">
        <div class="row"><h2>{{$device->modelName->name}}</h2></div>
        <div class="row text-dark">
            <div class="col-2 border border-2">Хост</div>
            <div class="col-2 border border-2">IP</div>
            <div class="col-2 border border-2">Филиал</div>
            <div class="col-2 border border-2">Состояние</div>
            <div class="col-2 border border-2">Дата</div>
        </div>
        <div class="row">Введите данные</div>
        <form action="{{route('printer.current.store')}}" method="POST">
            @csrf
            <div class="row text-dark">
                <div class="col-2 border border-2"><input type="text" name="hostname" class="form-control @error('hostname') is-invalid @enderror">
                    @error('hostname')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
                <div class="col-2 border border-2"><input type="text" name="ip" class="form-control @error('ip') is-invalid @enderror">
                    @error('ip')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="col-2 border border-2">
                    <select name="filial" id="txtFilial" class="form-select @error('filial') is-invalid @enderror">
                        <option value="">Выберите значение</option>
                        @foreach(\App\Models\filial::all() as $value)
                                <option value="{{ $value->id }}">  {{ $value->name }} </option>
                        @endforeach
                    </select>
                    @error('filial')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
                <div class="col-2 border border-2">
                    <select name="status" id="txtStatus" class="form-select @error('status') is-invalid @enderror">
                        <option value="">Выберите значение</option>
                        @foreach(\App\Models\Status::all() as $value)

                                <option value="{{ $value->id }}">  {{ $value->name }} </option>

                        @endforeach
                    </select>
                    @error('status')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror

                    <input hidden name="device_id" value="{{$device->id}}">
                    <input hidden name="device_names_id" value="{{$device->device_names_id}}">

                </div>
                <div class="col-2 border border-2"><input type="date" name="date" value="{{\Carbon\Carbon::today()->format('Y-m-d')}}" class="form-control"></div>
                <div class="row">
                    <div class="col-2">
                        <input class="form-control" type="submit" name="save" value="Сохранить">
                    </div>
                </div>

            </div>

        </form>
    </div>
    <div class="row-cols-4 p-5"><a class="btn btn-info" href="{{ url()->previous() }}">Назад</a></div>
@endsection('info')


