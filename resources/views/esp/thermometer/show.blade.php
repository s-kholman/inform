@extends('layouts.base')
@section('title', 'Термометры')

@section('info')

    <div class="container gx-4">
            <div class="row">
                <div>
                    <a class="btn btn-info" href="{{url()->route('esp.settings.show')}}">Назад</a>
                </div>
                <div class="col-6 mt-4">
                    @foreach($thermometers as $thermometer)
                        <a href="/esp/thermometer/edit/{{{$thermometer->id}}}">{{$thermometer->serial_number}}</a> => {{$thermometer->calibration}} <br>
                    @endforeach
                </div>
            </div>
    </div>
@endsection('info')
