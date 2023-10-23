@extends('layouts.base')
@section('title', 'Отчет - мониторинг температуры хранения продукции')

@section('info')

    <div class="container px-5">
        <div class="row row-cols-2 gy-5">


            <div class="col-6">
                <form action="{{route('monitoring.report.today')}}" method="POST">
                    @csrf
                    <label for="dateSelect">Выберите дату</label>
                    <input class="form-control"
                           type="date"
                           name="date"
                           value="{{\Illuminate\Support\Carbon::today()->format('Y-m-d')}}"
                           id="dateSelect">
                    <input class="btn btn-primary" type="submit" value="Показать">
                </form>
            </div>
            <div class="col-12">
                <a class="btn btn-info" href="/monitoring/">Назад</a>
            </div>
            <div class="col-12">
            </div>
        </div>
    </div>










@endsection('info')
