@extends('layouts.base')
@section('title', 'Поступление сырья на завод')

@section('info')

    <div class="container gx-4">


        <div class="row p-2">
            <div class="col-1 border align-text-top">
                Отходы
            </div>
            <div class="col-11">
                <div class="row text-center">
                    <div class="col-2 border">
                        Мех повреждения
                        <div class="row ">
                            <div class="col-6 border">кг</div>
                            <div
                                class="col-6 border @if($material[0]->gues->mechanical >= $specifically['mechanical']) bg-danger @else bg-success @endif">
                                %
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-6 border ">{{round($material[0]->gues->volume/100*$material[0]->gues->mechanical)}}</div>
                            <div class="col-6 border">{{$material[0]->gues->mechanical}}</div>
                        </div>
                    </div>
                    <div class="col-2 border">Земля, камни
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div
                                class="col-6 border @if($material[0]->gues->land >= $specifically['land']) bg-danger @else bg-success @endif">
                                %
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-6 border">{{round($material[0]->gues->volume/100*$material[0]->gues->land)}}</div>
                            <div class="col-6 border">{{$material[0]->gues->land}}</div>
                        </div>
                    </div>
                    <div class="col-2 border">Гниль
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div
                                class="col-6 border @if($material[0]->gues->rot >= $specifically['rot']) bg-danger @else bg-success @endif">
                                %
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-6 border">{{round($material[0]->gues->volume/100*$material[0]->gues->rot)}}</div>
                            <div class="col-6 border">{{$material[0]->gues->rot}}</div>
                        </div>
                    </div>
                    <div class="col-2 border">Ботва
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div
                                class="col-6 border @if($material[0]->gues->haulm >= $specifically['haulm']) bg-danger @else bg-success @endif">
                                %
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-6 border">{{round($material[0]->gues->volume/100*$material[0]->gues->haulm)}}</div>
                            <div class="col-6 border">{{$material[0]->gues->haulm}}</div>
                        </div>
                    </div>

                    <div class="col-2 border">Инородные предметы
                        <div class="col-12 align-middle border @if(!$material[0]->gues->foreign_object) bg-success">
                            отсутствуют @else bg-danger"> обнаруженно @endif</div>
                    </div>

                    <div class="col-2 border">Пересортица
                        <div class="col-12 align-middle border @if(!$material[0]->gues->another_variety) bg-success">
                            отсутствует @else bg-danger"> обнаруженно @endif</div>
                    </div>

                </div>
            </div>
        </div>


        <div class="row p-2">
            <div class="col-1 border align-text-top">
                Фракция
            </div>
            <div class="col-11">
                <div class="row text-center">
                    <div class="col-2 border ">
                        До 35
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div class="col-6 border">%</div>
                        </div>
                        <div class="row">
                            <div
                                class="col-6 border">{{round($material[0]->gues->volume/100*$material[0]->gues->less_thirty)}}</div>
                            <div class="col-6 border">{{$material[0]->gues->less_thirty}}</div>
                        </div>
                    </div>
                    <div class="col-2 border">35-45
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div class="col-6 border">%</div>
                        </div>
                        <div class="row">
                            <div
                                class="col-6 border">{{round($material[0]->gues->volume/100*$material[0]->gues->thirty)}}</div>
                            <div class="col-6 border">{{$material[0]->gues->thirty}}</div>
                        </div>
                    </div>
                    <div class="col-2 border">45-55
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div class="col-6 border">%</div>
                        </div>
                        <div class="row">
                            <div
                                class="col-6 border">{{round($material[0]->gues->volume/100*$material[0]->gues->forty)}}</div>
                            <div class="col-6 border">{{$material[0]->gues->forty}}</div>
                        </div>
                    </div>
                    <div class="col-2 border">55-65
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div class="col-6 border">%</div>
                        </div>
                        <div class="row">
                            <div
                                class="col-6 border">{{round($material[0]->gues->volume/100*$material[0]->gues->fifty)}}</div>
                            <div class="col-6 border">{{$material[0]->gues->fifty}}</div>
                        </div>
                    </div>

                    <div class="col-2 border">65
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div class="col-6 border">%</div>
                        </div>
                        <div class="row">
                            <div
                                class="col-6 border">{{round($material[0]->gues->volume/100*$material[0]->gues->sixty)}}</div>
                            <div class="col-6 border">{{$material[0]->gues->sixty}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-2">
            <div class="col-4"></div>
            <div class="col-4 text-center"><a class="btn btn-primary " href="/factory/material">Назад</a></div>
        </div>
        @if($material[0]->photo_path <> null)
            <div class="row p-2">
                <div class="col-12 text-center">
                    <img height="400" width="600" src="{{Storage::url($material[0]->photo_path)}}">
                </div>
            </div>
        @endif


    </div>
@endsection('info')
