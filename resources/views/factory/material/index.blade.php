@extends('layouts.base')
@section('title', 'Поступление сырья на завод')

@section('info')

    <div class="container gx-4">
        @auth
            @if(\Illuminate\Support\Facades\Auth::user()->email <> 'rga@krimm.ru')
        <div class="row">
            <div class="col-4 p-3"><a class="btn btn-outline-success" href="{{route('material.create')}}">Внести
                    поступление сырья</a></div>
        </div>
            @endif
        @endauth
        @forelse($materials as $material)

        <div class="row">
            <div class="col-1 border align-middle">
                {{\Illuminate\Support\Carbon::parse($material->date)->translatedFormat('d-m-Y')}}
            </div>
            <div class="col-11">
                <div class="row">
                    <div class="col-4 border">Номенклатура: {{$material->nomenklature->name}}</div>
                    <div class="col-4 border">Филиал: {{$material->filial->name}}</div>
                    <div class="col-4 border">ФИО: {{$material->fio}}</div>
                </div>
                @if ($material->gues->volume ?? false)
                <div class="row">
                    <div class="col-6 border">Вес: {{$material->gues->volume}} кг.</div>
                    <div class="col-6 border">Чистый вес: {{round($material->gues->volume /100*(100-($material->gues->mechanical+$material->gues->land+$material->gues->rot+$material->gues->haulm)))}} кг.,
                        {{100 - ($material->gues->mechanical+$material->gues->land+$material->gues->rot+$material->gues->haulm)}}%</div>
                </div>
                <div class="row">
                    <div class="col-2 border @if($material->gues->mechanical >= $specifically['mechanical']) bg-danger @else bg-success @endif">Мех повреждения</div>
                    <div class="col-2 border @if($material->gues->land >= $specifically['land']) bg-danger @else bg-success @endif">Камни земля</div>
                    <div class="col-2 border @if($material->gues->rot >= $specifically['rot']) bg-danger @else bg-success @endif">Гниль</div>
                    <div class="col-2 border @if($material->gues->haulm >= $specifically['haulm']) bg-danger @else bg-success @endif">Ботва</div>
                    <div class="col-2 border fs-6 @if($material->gues->foreign_object) bg-danger @else bg-success @endif">Инородные предметы</div>
                    <div class="col-2 border @if($material->gues->another_variety) bg-danger @else bg-success @endif">Пересортица</div>
                </div>
                @endif
                <div class="row">
                    @if ($material->gues->volume ?? false)
                        <div class="col-6 border text-center"><a href="{{route('material.show', ['material' => $material])}}">Подробнее</a></div>
                    @else
                        <div class="col-6 border text-center"><a href="">Нет данных о разбраковке</a></div>
                    @endif
                    @auth
                        @if(\Illuminate\Support\Facades\Auth::user()->email <> 'rga@krimm.ru')
                            <div class="col-6 border text-center"><a href="{{route('factory.gues.create', ['factory' =>$material->id])}}">Разбраковка</a></div>
                        @else
                            <div class="col-6 border text-center"></div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        @empty
        @endforelse
    </div>
@endsection('info')
