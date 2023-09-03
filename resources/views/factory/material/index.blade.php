@extends('layouts.base')
@section('title', 'Поступление сырья на завод')

@section('info')
    <div class="container gx-4">
        <div class="row">
            <div class="col-4 p-3"><a class="btn btn-outline-success" href="{{route('material.create')}}">Внести
                    поступление сырья</a></div>
        </div>
        @forelse($materials as $material)

                <div class="row">
                    <div class="col-2">Дата</div>
                    <div class="col-2">Филиал</div>
                    <div class="col-2">ФИО</div>
                    <div class="col-2">Объем</div>
                    <div class="col-2">Номенклатура</div>
                </div>

            <div class="row border border-1">
                <div class="col-2">{{$material->date}}</div>
                <div class="col-2">{{$material->filial->name}}</div>
                <div class="col-2">{{$material->fio}}</div>
                <div class="col-2">{{$material->volume}}</div>
                <div class="col-2">{{$material->nomenklature->name}}</div>
                <div class="row">
                    <div class="col-2">
                        Чистый вес
                        <div class="row">
                            <div class="col-6">
                                кг
                                <div class="row">
                                    <div class="col-12">
                                        {{rand(100,10000)}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                %
                                <div class="row">
                                    <div class="col-12">
                                        {{rand(1,100)}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-2">
                        Мех повреждения
                        <div class="row">
                            <div class="col-6">кг</div>
                            <div class="col-6">%</div>
                        </div>
                    </div>
                    <div class="col-2">
                        Камни земля
                        <div class="row">
                            <div class="col-6">кг</div>
                            <div class="col-6">%</div>
                        </div>
                    </div>
                    <div class="col-2">
                        Ботва
                        <div class="row">
                            <div class="col-6">кг</div>
                            <div class="col-6">%</div>
                        </div>
                    </div>
                    <div class="col-2">
                        Гниль
                        <div class="row">
                            <div class="col-6">кг</div>
                            <div class="col-6">%</div>
                        </div>
                    </div>
                    <div class="col-1">
                        Постороние
                        <div class="row">
                            <div class="col-12">Т</div>
                        </div>
                    </div>
                    <div class="col-1">
                        Пересорт
                        <div class="row">
                            <div class="col-12">Т</div>
                        </div>
                    </div>
                </div>

                <div class="row border border-1">

                <div class="col-2">
                    До 35
                    <div class="row">
                        <div class="col-6">кг</div>
                        <div class="col-6">%</div>
                    </div>
                </div>

                    <div class="col-2">
                        35 - 45
                        <div class="row">
                            <div class="col-6">кг</div>
                            <div class="col-6">%</div>
                        </div>
                    </div>

                    <div class="col-2">
                       45 - 55
                        <div class="row">
                            <div class="col-6">кг</div>
                            <div class="col-6">%</div>
                        </div>
                    </div>

                    <div class="col-2">
                        55 - 65
                        <div class="row">
                            <div class="col-6">кг</div>
                            <div class="col-6">%</div>
                        </div>
                    </div>

                    <div class="col-2">
                        65
                        <div class="row">
                            <div class="col-6">кг</div>
                            <div class="col-6">%</div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
    </div>
@endsection('info')
