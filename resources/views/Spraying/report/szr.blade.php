@extends('layouts.base')
@section('title', "Отчет по расходу СЗР")

@section('info')
    <div class="container px-5">

        <div class="row row-cols-2 gy-5">

            <div class="col-6">
                <a class="btn btn-info" href="/spraying/">Назад</a>
            </div>

        </div>

        <div class="row row-cols-12 text-center gy-5">
            <p>Отчет по внесению СЗР за 2024 год</p>
        </div>

        <div class="row px-5 g-4">
            @forelse($szrs as $filal_name => $szr)
                <b>{{$filal_name}}</b> <br />
                @foreach($szr as $szr_name => $value)
                    {{$szr_name}} - {{collect($value)->sum('volume')}}<br />
                @endforeach
            @empty
            @endforelse
        </div>
    </div>

@endsection('info')
