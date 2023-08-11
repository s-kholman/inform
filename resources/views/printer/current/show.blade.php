@extends('layouts.base')
@section('title', 'Справочник')

@section('info')

    <div class="container text-center border border-2">
        <div class="row"><h2>История ремонта/перемещения</h2></div>
        <div class="row text-dark">
            <div class="col border border-2">Филиал</div>
            <div class="col border border-2">Наименование</div>
            <div class="col border border-2">Дата</div>
            <div class="col border border-2">Расход</div>
        </div>
        @forelse($service as $value)

            <div class="row">
                <div class="col border border-2">{{$value['filial']}}</div>
                <div class="col border border-2">{{$value['Name']}}</div>
                <div class="col border border-2">{{$value['date']}}</div>
                <div class="col border border-2">{{$value['count']}}</div>
            </div>
        @empty
            <div class="row">Данные не найденны</div>
        @endforelse
    </div>

@endsection('info')

