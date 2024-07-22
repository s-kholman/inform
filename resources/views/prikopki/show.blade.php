@extends('layouts.base')
@section('title', 'Текущие данные о прикопках ')

@section('info')
    <div class="container gx-4">
        <div class="row">
            <table class="table table-bordered">
                <caption class="caption-top text-center">Прикопки на поле: <b>{{$pole_name}}</b></caption>
                <thead>
                <tr>
                    <th>Дата</th>
                    <th>Номенклатура</th>
                    <th>до 30</th>
                    <th>30-45</th>
                    <th>45-50</th>
                    <th>50-55</th>
                    <th>55-60</th>
                    <th>60+</th>
                    <th>Площадь</th>
                    <th>Вес</th>
                    <th>Коментарии</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($prikopkis as $prikopki)
                    <tr>
                        <td>{{$prikopki['date']}}</td>
                        <td>{{$prikopki->sevooborot->nomenklature->name}} - {{$prikopki->sevooborot->reproduktion->name}}</td>
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
                                <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle" data-bs-toggle="dropdown">
                                    Действия
                                </button>
                                <ul class="dropdown-menu">
                                    <form class="delete-message" data-route="{{ route('prikopki.destroy', ['prikopki' => $prikopki->id])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <li><input type="submit" class="dropdown-item text-danger" value="Удалить"></li>
                                    </form>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
        <a class="btn btn-info" href="/prikopki">Назад</a>
    </div>
@endsection('info')
@section('script')
    @include('scripts\destroy-modal')
@endsection
