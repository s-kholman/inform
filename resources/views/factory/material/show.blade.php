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
                    <div class="col-2 border ">
                        Мех повреждения
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div class="col-6 border">%</div>
                        </div>
                        <div class="row">
                            <div class="col-6 border">{{$gues[0]->gues->volume/100*$gues[0]->gues->mechanical}}</div>
                            <div class="col-6 border">{{$gues[0]->gues->mechanical}}</div>
                        </div>
                    </div>
                    <div class="col-2 border">Земля, камни
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div class="col-6 border">%</div>
                        </div>
                        <div class="row">
                            <div class="col-6 border">{{$gues[0]->gues->volume/100*$gues[0]->gues->land}}</div>
                            <div class="col-6 border">{{$gues[0]->gues->land}}</div>
                        </div>
                    </div>
                    <div class="col-2 border">Гниль
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div class="col-6 border">%</div>
                        </div>
                        <div class="row">
                            <div class="col-6 border">{{$gues[0]->gues->volume/100*$gues[0]->gues->rot}}</div>
                            <div class="col-6 border">{{$gues[0]->gues->rot}}</div>
                        </div>
                    </div>
                    <div class="col-2 border">Ботва
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div class="col-6 border">%</div>
                        </div>
                        <div class="row">
                            <div class="col-6 border">{{$gues[0]->gues->volume/100*$gues[0]->gues->haulm}}</div>
                            <div class="col-6 border">{{$gues[0]->gues->haulm}}</div>
                        </div>
                    </div>

                    <div class="col-2 border">Посторонние предметы
                        <div class="col-12 align-middle border @if(!$gues[0]->gues->foreign_object) bg-success"> отсутствуют @else bg-danger"> обнаруженно @endif</div>
                    </div>

                    <div class="col-2 border">Пересортица
                        <div class="col-12 align-middle border @if(!$gues[0]->gues->another_variety) bg-success"> отсутствует @else bg-danger"> обнаруженно @endif</div>
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
                            <div class="col-6 border">{{$gues[0]->gues->volume/100*$gues[0]->gues->less_thirty}}</div>
                            <div class="col-6 border">{{$gues[0]->gues->less_thirty ?? '0'}}</div>
                        </div>
                    </div>
                    <div class="col-2 border">35-45
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div class="col-6 border">%</div>
                        </div>
                        <div class="row">
                            <div class="col-6 border">{{$gues[0]->gues->volume/100*$gues[0]->gues->thirty}}</div>
                            <div class="col-6 border">{{$gues[0]->gues->thirty}}</div>
                        </div>
                    </div>
                    <div class="col-2 border">45-55
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div class="col-6 border">%</div>
                        </div>
                        <div class="row">
                            <div class="col-6 border">{{$gues[0]->gues->volume/100*$gues[0]->gues->forty}}</div>
                            <div class="col-6 border">{{$gues[0]->gues->forty}}</div>
                        </div>
                    </div>
                    <div class="col-2 border">55-65
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div class="col-6 border">%</div>
                        </div>
                        <div class="row">
                            <div class="col-6 border">{{$gues[0]->gues->volume/100*$gues[0]->gues->fifty}}</div>
                            <div class="col-6 border">{{$gues[0]->gues->fifty}}</div>
                        </div>
                    </div>

                    <div class="col-2 border">65
                        <div class="row">
                            <div class="col-6 border">кг</div>
                            <div class="col-6 border">%</div>
                        </div>
                        <div class="row">
                            <div class="col-6 border">{{$gues[0]->gues->volume/100*$gues[0]->gues->sixty}}</div>
                            <div class="col-6 border">{{$gues[0]->gues->sixty}}</div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
        <div class="row p-2">
            <div class="col-12 border text-center"><a href="/factory/material">Назад</a></div>
        </div>
        @if($gues[0]->photo_path <> null)
        <div class="row p-2">
            <div class="col-12 text-center">
                <img height="400" width="600" src="{{Storage::url($gues[0]->photo_path)}}">
            </div>
        </div>
        @endif


    </div>
@endsection('info')
