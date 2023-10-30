@extends('layouts.base')
@section('title', 'Отчет - мониторинг температуры хранения продукции')

@section('info')

    <div class="container">

                <form action="{{route('monitoring.report.today')}}" method="POST">
                    <div class="row justify-content-center text-center">
                        @csrf
                        <div class="col-1"></div>
                    <div class="col-2">
                    <label for="dateSelect">Выберите дату</label>
                    <input class="form-control"
                           type="date"
                           name="date"
                           value="{{\Illuminate\Support\Carbon::today()->format('Y-m-d')}}"
                           id="dateSelect">
                    </div>


                    </div>
                    <div class=" justify-content-center row p-4">
                        <div class="col-1"></div>
                        <div class="col-2">
                            <input class="btn btn-primary" type="submit" value="Сформировать">
                        </div>

                        <div class="col-1">
                            <a class="btn btn-info" href="/monitoring/">Назад</a>
                        </div>
                    </div>
                </form>


    </div>










@endsection('info')
