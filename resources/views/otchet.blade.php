@extends('layouts.base')
@section('title', 'Отчеты')

@section('info')

    @csrf
    <div class="container  ">
        @can('showAdd', 'App\Models\svyaz')
            <div class="col-3"><a class="btn btn-outline-success" href="{{route('posev_add')}}">Внести информацию </a></div>
        @endcan
        <table class="table  table-bordered a1 caption-top ">
            <caption class=" border rounded-3 p-3">
                    @if($key <> 4)
                        <p class="text-center">Информация о ходе посевной - <b>{{ Str::lower(\App\Models\vidposeva::where('id', $key)->value('name'))}}</b></p>
                    @endif
                    @if($key == 4)
                            <p class="text-center">Информация о добыче - <b>{{ Str::lower(\App\Models\vidposeva::where('id', $key)->value('name'))}}</b></p>
                    @endif
            </caption>
            <thead>
            {{--Формируем шапку таблицы - высчитываем сколько ячеек нужно объеденить
            считаем количество всех связей с указанием данного филиала--}}
            <th class="text-center" rowspan="3">Дата</th>
        @foreach($shablon_filial as $value)
            <th class="text-center" colspan={{ \App\Models\svyaz::where('vidposeva_id', $key)->where('filial_id', $value['filial_id'])->count() }}>
                {{ \App\Models\filial::where('id', $value['filial_id'])->value('name') }}</th>
        @endforeach
            <th valign="middle" class="text-center" name="fio" rowspan="3">Итого за сутки</th>
            <tr>
                @foreach($shablon_agregat as $value)
                        <th class="text-center"  colspan={{ \App\Models\svyaz::where('vidposeva_id', $key)->where('filial_id', $value['filial_id'])->where('agregat_id', $value['agregat_id'])->count() }}>
                            {{ \App\Models\agregat::where('id', $value['agregat_id'])->value('name') }}</th>
                @endforeach

            </tr>
            <tr>
                @foreach($shablon_fio as $value)
                    <th valign="middle" name="fio">{{ \App\Models\Fio::where('id', $value['fio_id'])->value('name') }}</th>
                @endforeach

            </tr>

            </thead>
            <tbody>
            @foreach($arrDate as $date)
                <tr ><td class="text-center">{{ \Carbon\Carbon::parse($date['posevDate'])->format('d.m.Y') }}</td>
                    @foreach($shablon as $valie)

                                @if (!empty($arr[$date['posevDate']][$valie[0]][$valie[1]][$valie[2]]))
                            {{--
             /**
             * Доработка от 11.05.2023
             * Для внесения в одну ячейку нескольких значений
             * переходной этап (сеял овес, стал пшеницу)
             * НАЧАЛО
             */
             оригинал кода
             <td class="text-center" name="{!!  json_decode($arr[$date['posevDate']][$valie[0]][$valie[1]][$valie[2]])->kultura_id !!}">
                {{ json_decode($arr[$date['posevDate']][$valie[0]][$valie[1]][$valie[2]])->posevGa }}</td>
                --}}
                                    @foreach(json_decode($arr[$date['posevDate']][$valie[0]][$valie[1]][$valie[2]]) as $kult)
                                        @if (count(json_decode($arr[$date['posevDate']][$valie[0]][$valie[1]][$valie[2]])) > 1)
                                            @if ($loop->first)
                                                <td>
                                                <table> <tbody><tr>
                                            @endif
                                            <td class="text-center" name="{!!  $kult->kultura_id !!}">{{ $kult->posevGa }}</td>
                                            @if ($loop->last)
                                                    </tr></tbody></table></td>
                                            @endif
                                        @else
                                    <td class="text-center" name="{!!  $kult->kultura_id !!}">
                                        {{ $kult->posevGa }}</td>
                                        @endif
                                    @endforeach
                                    {{--КОНЕЦ--}}
                                @else
                                    <td></td>
                                @endif
                            @endforeach
                            <td class="text-center">{{ round(\App\Models\posev::where('vidposeva_id', $key)->where('posevDate', $date['posevDate'])->sum('posevGa'),2) }}</td>
                        </tr><tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <td></td>
                    @foreach($shablon as $value)
                            <td class="text-center">{{ round(\App\Models\posev::where('filial_id',$value[0])->where('agregat_id',$value[1])->where('fio_id',$value[2])->sum('posevGa'), 2)}}</td>
                    @endforeach
                    <td></td></tr>
                    </tfoot>
                </table>
            </div>
            <div class="container"><div class="data"><table name='itogi' class="table table-bordered">
                <th colspan="2">По КРиММ</th>

                @foreach(\App\Models\posev::where('vidposeva_id', $key)->distinct('kultura_id')->get() as $value)
                    <tr><td name="{{$value->kultura_id}}">{{ \App\Models\Kultura::where('id', $value->kultura_id)->value('name') }}</td>
                        <td>{{ round(\App\Models\posev::where('kultura_id', $value->kultura_id)->sum('posevGa'), 2) }}</td></tr>
                @endforeach
                    </table></div>

            @foreach($shablon_filial as $value)
                    <div class="data">
            <table name='itogi' class="table table-bordered">
                <th colspan="2">{{ \App\Models\filial::where('id', $value['filial_id'])->value('name') }}</th>
                @foreach(\App\Models\posev::where('vidposeva_id', $key)->distinct('kultura_id')->get() as $item)
                    <tr><td name="{{$item->kultura_id}}">{{ \App\Models\Kultura::where('id', $item->kultura_id)->value('name') }}</td>
                        <td>{{ round(\App\Models\posev::where('filial_id', $value['filial_id'])->where('kultura_id', $item->kultura_id)->sum('posevGa'), 2) }}</td></tr>
                @endforeach
            </table>
                    </div>
            @endforeach

                @if (\App\Models\posev::where('posevDate', \Carbon\Carbon::yesterday())->exists())
                <div class="data"><table name='itogi' class="table table-bordered">
                        <th colspan="2">на {{\Carbon\Carbon::yesterday()->format('d.m.Y')}}</th>

                        @foreach(\App\Models\posev::where('vidposeva_id', $key)->distinct('kultura_id')->get() as $value)
                            <tr><td name="{{$value->kultura_id}}">{{ \App\Models\Kultura::where('id', $value->kultura_id)->value('name') }}</td>
                                <td >{{ round(\App\Models\posev::where('kultura_id', $value->kultura_id)->where('posevDate', \Carbon\Carbon::yesterday())->sum('posevGa'), 2) }}</td></tr>
                        @endforeach
                    </table></div>
                @endif

            </div>
        @endsection('info')
