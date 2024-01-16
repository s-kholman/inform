@extends('layouts.base')
@section('title', 'Текущие используемые связки')

@section('info')
    <div class="container">
        <div class="row p-3">
            <div class="col-4 p-2">
                <a class="btn btn-primary " href="/">На главную</a>
            </div>
            <div class="col-4 p-2">
                <a class="btn btn-primary " href="/sowing/outfit/create">Добавить</a>
            </div>
        </div>
        <div class="row p-3">
            @forelse($harvest_year as $value)
                <div class="col">
                    <a href="/sowing/outfit/index?id={{$value->HarvestYear->id}}">{{$value->HarvestYear->name}}</a>
                </div>
            @empty
            @endforelse
        </div>
        <div class="row p-3">
            <div class="col-2">Филиал</div>
            <div class="col-2">Агрегат/Культура</div>
            <div class="col-2">ФИО</div>
            <div class="col-2">Вид</div>
            <div class="col-2">Действие</div>

        </div>
        @forelse(\App\Models\SowingOutfit::query()
                            ->where('harvest_year_id', $year_id ?: $harvest_year->last()->harvest_year_id)
                            ->orderBy('filial_id')
                            ->orderBy('sowing_type_id')
                            ->get() as $outfit)
            <div class="row">
                <div class="col-2">{{ $outfit->filial->name}}</div>
                <div class="col-2">{{ $outfit->machine->name ?? $outfit->Cultivation->name }}</div>
                <div class="col-2">{{ $outfit->SowingLastName->name }}</div>
                <div class="col-2">{{ $outfit->SowingType->name}}</div>
                <div class="col-2 p-1  dropdown">

                        <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-bs-toggle="dropdown">
                            Действия
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Изменить</a></li>
                            <li>
                                <form action="{{route('outfit.destroy', ['outfit' => $outfit->id])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input class="dropdown-item" type="submit" value="Удалить">
                                </form>

                            </li>
                        </ul>
                    </div>


            </div>
        @empty
        @endforelse
    </div>
@endsection('info')

