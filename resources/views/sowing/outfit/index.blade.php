@extends('layouts.base')
@section('title', 'Текущие используемые связки')

@section('info')
    <div class="container">
        <div class="row">
            <div class="col-4 p-2">
                <a class="btn btn-primary " href="/">На главную</a>
            </div>
            <div class="col-4 p-2">
                <a class="btn btn-primary " href="/outfit/create">Добавить</a>
            </div>
        </div>
        <div class="row">
            <div class="col-2">Филиал</div>
            <div class="col-2">Агрегат/Культура</div>
            <div class="col-2">ФИО</div>
            <div class="col-2">Вид</div>
            <div class="col-2">Дата</div>
            <div class="col-2">Статус</div>
        </div>
        @forelse(\App\Models\SowingOutfit::query()
                            ->where('harvest_year_id', $harvest_year_id)
                            ->orderBy('filial_id')
                            ->orderBy('sowing_type_id')
                            ->get() as $outfit)
            <div class="row">
                <div class="col-2">{{ $outfit->filial->name}}</div>
                <div class="col-2">{{ $outfit->machine->name ?? $outfit->Cultivation->name }}</div>
                <div class="col-2">{{ $outfit->SowingLastName->name }}</div>
                <div class="col-2">{{ $outfit->SowingType->name}}</div>
                <div class="col-2">-</div>
                <div class="col-2">-</div>
            </div>
        @empty
        @endforelse
    </div>
@endsection('info')

