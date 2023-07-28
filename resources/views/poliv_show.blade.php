@extends('layouts.base')
@section('title', 'Текущие данные о поливе ')

@section('info')

    @can('showAdd', 'App\Models\svyaz')
        <div class="col-3"><a class="btn btn-outline-success" href="{{route('poliv_add')}}">Внести полив</a></div>
    @endcan

    <table class="table table-bordered table-sm">

        <caption class="border rounded-3 p-3 caption-top">
            <p>Поля под орошением</p>
        </caption>

        <thead>
        <tr>
            @forelse($arr as $filial_id => $filial)
                <th>
                    {{\App\Models\filial::where('id',$filial_id)->value('name')}}
                </th>
            @empty

            @endforelse
        </tr>
        </thead>
        <tbody>
        <tr>
            @forelse($arr as $filial_id => $filial)
                <td>
                    @foreach($filial as $id => $name)
                        <a href="/poliv_show/{{$filial_id}}/{{$id}}">{{$name}}</a></br>
                    @endforeach
                </td>
            @empty

            @endforelse
        </tr>
        </tbody>
        </table>
    @if ($f_id <> 0)
        <br><br><br>
        <table class="table table-bordered table-sm">
            @if (\App\Models\pole::where('id', $p_id)->value('path') <> null)
                <caption class="border rounded-3 p-3 caption-top"><center><img height="400" width="600" src="{{Storage::url(\App\Models\pole::where('id', $p_id)->value('path'))}}"></center></caption>
            @endif
            <thead>
            <td colspan="7">Поле <b>{{\App\Models\pole::where('id', $p_id)->value('name')}}</b>, филиала - {{\App\Models\filial::where('id', $f_id)->value('name')}} </td>
            <tr>
                <th class="text-center">Дата</th>
                <th class="text-center">Гидрант</th>
                <th class="text-center">Сектор</th>
                <th class="text-center">Полив мм</th>
                <th class="text-center">Скорость</th>
                <th class="text-center">КАС</th>
                <th class="text-center">Коментарий</th>
            </tr>
            </thead>
                @forelse(\App\Models\Poliv::where('filial_id', $f_id)->where('pole_id', $p_id)->orderby('date', 'DESC')->orderby('gidrant', 'ASC')->orderby('sector', 'ASC')->get()->groupby('date') as $value)
                    @foreach($value as $item)
                        @if($loop->first)
                            <tr>
                                <td style="text-align: center; vertical-align: middle;" rowspan="{{count($value)+1}}">{{\Carbon\Carbon::parse($item->date)->translatedFormat('d-m-Y')}}</td>
                        @endif
                                <tr>
                                <td class="text-center"><a class="btn btn-outline-info" href="/poliv_edit/{{$item->id}}">{{$item->gidrant}}</a></td>
                                <td class="text-center">{{$item->sector}}</td>
                                <td class="text-center">{{$item->poliv}}</td>
                                <td class="text-center">{{$item->speed}}</td>
                                <td class="text-center">{{$item->KAC}}</td>
                                <td class="text-center ">{{$item->comment}}</td>
                                </tr>

                        @if($loop->last)
                            </tr>
                        @endif
                    @endforeach
                @empty

                @endforelse

    </table>
    @endif
@endsection('info')
