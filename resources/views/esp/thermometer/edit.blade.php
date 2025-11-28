@extends('layouts.base')
@section('title', 'Термометры - поправочный коэффициент')

@section('info')

    <div class="container gx-4">
            <div class="row">
                <div class="col-6">
                    <form action="{{route('esp.thermometer.storeCalibration', ['thermometer' => $thermometer->id])}}" method="post">
                        @csrf
                    <label for="serial_number">Серийный номер градусника</label>
                    <input class="form-control" readonly name="serial_number" value="{{$thermometer->serial_number}}">
                    <label for="calibration">Введите поправочный коэффициент</label>
                     <input
                         class="form-control"
                         name="calibration"
                         value="{{$thermometer->calibration}}"
                         type="number"
                         step="0.1"
                     >
                        <div class="mt-2">
                            <input class="btn btn-primary" type="submit" value="Сохранить" name="save">
                            <a class="btn btn-info" href="{{url()->route('esp.thermometer.show')}}">Назад</a>
                        </div>

                    </form>

                </div>
            </div>
    </div>
@endsection('info')
