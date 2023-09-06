@extends('layouts.base')
@section('title', 'Внести ремонт')

@section('info')
    <div class="container">
        <form action="{{ route('service.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-3">
                    {{\App\Models\filial::where('id',$currentStatus->filial_id)->value('name')}}
                    <select name="service_name" id="txtFilial"
                            class="form-select @error('service_name') is-invalid @enderror">
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
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <input type="date" name="date" value="{{\Carbon\Carbon::today()->format('Y-m-d')}}"
                           class="form-control">
                </div>
            </div>

            <input hidden name="device_id" value="{{$currentStatus->device_id}}">
            <input hidden name="filial_id" value="{{$currentStatus->filial_id}}">

            <div class="row">
                <div class="col-3">
                    <input class="form-control btn btn-success" type="submit" name="save" value="Сохранить">
                </div>
            </div>

            <div class="row p-5">
                <div class="col-4">
                    <a class="btn btn-info" href="{{ url()->previous() }}">Назад</a>
                </div>
            </div>
        </form>
    </div>


@endsection('info')
