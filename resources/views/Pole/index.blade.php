@extends('layouts.base')
@section('title', 'Справочник')

@section('info')

    <div class="col-3">
        <a class="btn btn-info" href="/pole/create">Добавить поле</a>
    </div>
    @can('destroy', 'App\Models\svyaz')
            <table class="table table-bordered">

                    @forelse(\App\Models\Pole::distinct('filial_id')->get() as $filial)
                        <th colspan="3" class="text-center">{{\App\Models\filial::where('id',$filial->filial_id)->value('name')}}
                            <tr>
                                <th>Наименование</th><th>Полив</th><th>Севооборот</th>
                            </tr>
                            @foreach(\App\Models\Pole::where('filial_id',$filial->filial_id)->orderby('name')->get() as $value)
                                <tr>
                                    <td><a href="/pole/{{$value->id}}/edit">{{$value->name}}</a></td>
                                    <td><input type="checkbox" @if ($value->poliv <> null) checked @endif></td>
                                    <td><a href="/pole/{{$value->id}}/sevooborot">Севооборот</a></td>
                                </tr>
                        @endforeach
                    @empty
                    @endforelse

                @elsecan('viewAny', 'App\Models\Watering')
                                <table class="table table-bordered">
                        <th colspan="3" class="text-center">{{\Illuminate\Support\Facades\Auth::user()->filialname->name}}
                            <tr>
                                <th>Наименование</th><th>Полив</th><th>Севооборот</th>
                            </tr>
                            @foreach(\App\Models\Pole::where('filial_id',\Illuminate\Support\Facades\Auth::user()->filialname->id)->orderby('name')->get() as $value)
                                <tr>
                                    <td><a href="/pole/{{$value->id}}/edit">{{$value->name}}</a></td>
                                    <td><input type="checkbox" @if ($value->poliv <> null) checked @endif></td>
                                    <td><a href="/pole/{{$value->id}}/sevooborot">Севооборот</a></td>
                                </tr>
                        @endforeach
            </table>

    @endcan





@endsection('info')
