@extends('layouts.base')
@section('title', 'Данные об опрыскивание ')

@section('info')


    <div class="container gx-4">

            <div class="row">
               {{-- @can('viewAny', 'App\Models\spraying')--}}
                <div class="col-4 p-3"><a class="btn btn-outline-success" href="{{route('warming.create')}}">Внести
                        прогрев</a></div>

{{--                    <div class="col-4 p-3 dropdown">
                        <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown">
                            Отчеты
                        </button>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item"><a href="spraying/report">По дням</a></li>
                            <li class="dropdown-item"><a href="/spraying/report/szr">По СЗР</a></li>
                        </ul>
                    </div>
                --}}{{--@endcan--}}{{--

                <div class="col-4 p-3">--}}


{{--                <div class="dropdown">
                    <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown">
                        Справочники
                    </button>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a href="/pole">Поля/севооборот</a></li>
                        --}}{{--@can('myView', 'App\Models\spraying')--}}{{--
                        <li class="dropdown-item"><a href="/nomenklature">Номенклатура</a></li>
                        <li class="dropdown-item"><a href="/szr">СЗР</a></li>
                       --}}{{-- @endcan--}}{{--
                    </ul>
                </div>--}}

                </div>

            </div>

        <div class="container gx-4">
            <div class="row">


               <div class="col-xl-10">
                        @foreach($warming as $filial_id => $name)
                            {{\App\Models\filial::query()->where('id', $filial_id)->value('name')}} <br>
                            @foreach($name as $f)
                                @if($loop->first)
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Бокс</th>
                                            <th>Объем</th>
                                            <th>Дата посадки</th>
                                            <th>Дата прогрева</th>
                                            <th>Комментарий</th>
                                            <th>Контроль агроном</th>
                                            <th>Контроль зам. дир</th>
                                        </tr>
                                        </thead>
                                        @endif
                                        <tbody>
                                        <tr>
                                            <td>{{$f->storageName->name}}</td>
                                            <td>{{$f->volume}}</td>
                                            <td>{{$f->warming_date}}</td>
                                            <td>{{$f->sowing_date}}</td>
                                            <td>{{$f->comment ?? ''}}</td>
                                            <td>{{$f->comment_agronomist?? ''}}</td>
                                            <td>{{$f->comment_deputy_director ?? ''}}</td>
                                        </tr>
                                        </tbody>
                                        @if($loop->last)
                                    </table>
                           @endif

                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection('info')
