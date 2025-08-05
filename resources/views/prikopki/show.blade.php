@extends('layouts.base')
@section('title', 'Текущие данные о прикопках ')

@section('info')
    <div class="container gx-4">
        <div class="row">
            <div class="col-4 p-3"><a class="btn btn-outline-success" href="{{route('prikopki.create')}}">Внести
                    прикопки</a></div>
            <div class="col-4 p-3"></div>
        </div>
        <div class="row">
            @forelse($prikopkis as $type => $value)
                <table class="table table-bordered">
                    <caption class="caption-top text-center">Прикопки
                        @if($type == 1) товарного  @else семенного @endif картофеля на поле:
                        <b>{{$value[0]->sevooborot->pole->name}}</b></caption>
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Номенклатура</th>
                        @foreach($fractions[$type] as $fraction)
                            @if($value[0]->date > '2024-10-01')
                                <th>{{$fraction}}</th>
                            @else
                                @foreach($fractions[3] as $s)
                                    <th>{{$s}}</th>
                                @endforeach
                                @break;
                            @endif
                        @endforeach
                        <th>Площадь</th>
                        <th>Вес</th>
                        <th>Комментарий</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($value as $prikopki)
                        <tr>
                            <td>{{\Illuminate\Support\Carbon::parse($prikopki['date'])->format('d.m.Y')}}</td>
                            <td>{{$prikopki->sevooborot->nomenklature->name}}
                                - {{$prikopki->sevooborot->reproduktion->name}}</td>
                            <td>{{$prikopki['fraction_1']}}</td>
                            <td>{{$prikopki['fraction_2']}}</td>
                            <td>{{$prikopki['fraction_3']}}</td>
                            <td>{{$prikopki['fraction_4']}}</td>
                            <td>{{$prikopki['fraction_5']}}</td>
                            <td>{{$prikopki['fraction_6']}}</td>
                            <td>{{$prikopki->PrikopkiSquare->name}}&sup2;</td>
                            <td>{{$prikopki['fraction_1'] + $prikopki['fraction_2']+ $prikopki['fraction_3']+ $prikopki['fraction_4']+ $prikopki['fraction_5']+ $prikopki['fraction_6']}}</td>
                            <td>{{$prikopki['comment']}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                        Действия
                                    </button>
                                    <ul class="dropdown-menu">
                                        <form class="delete-message"
                                              data-route="{{ route('prikopki.destroy', ['prikopki' => $prikopki->id])}}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <li><input type="submit" class="dropdown-item text-danger" value="Удалить">
                                            </li>
                                        </form>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @empty
                    @endforelse
                    </tbody>
                </table>
        </div>
    </div>

    <div class="col">
        <a class="btn btn-info " role="button" href="/prikopki/year/{{$year}}">Назад</a>
    </div>
    </div>
@endsection('info')
@section('script')
    @include('scripts\destroy-modal')
@endsection
