@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <table class="table table-bordered table-sm table-hover caption-top">
        <caption class=" border rounded-3 p-3"><p class="text-center">Пример отчета, данные не актуальны</p></caption>
        <thead>
        <th class="text-center" rowspan="2">Склад</th>
        <th class="text-center" rowspan="2">Поле</th>
        <th class="text-center" rowspan="2">Номенклатура</th>
        <th class="text-center" rowspan="2">На хранении</th>
        <th class="text-center" colspan="2">50</th>
        <th class="text-center" colspan="2"> 40</th>
        <th class="text-center" colspan="2">30</th>
        <th class="text-center" colspan="2">Нестандарт</th>
        <th class="text-center" colspan="2">Отход</th>
        <th class="text-center" colspan="2">Земля</th>
        <th class="text-center" colspan="2" >Ест. убыль</th>
        <th class="text-center" rowspan="2" >Коментарий</th>

<tr>
    <th>План</th><th>Факт</th>
    <th>План</th><th>Факт</th>
    <th>План</th><th>Факт</th>
    <th>План</th><th>Факт</th>
    <th>План</th><th>Факт</th>
    <th>План</th><th>Факт</th>
    <th colspan="2">Факт</th>
</tr>
        </thead>
        <tbody class="table-hover">
        @foreach($itogs as $value)

            <tr>
                <td rowspan="2"><a href="/storage/detail/{{$value['id']}}">{{$value['storage']}}</a></td>
                <td rowspan="2">{{$value['field']}}</td>
                <td rowspan="2">{{$value['nomenklature']}}</td>
                <td class="text-center" rowspan="2">{{$value['quautity']}}</td>
                <td class="text-center">{{$value['DP50']}}</td>
                <td class="text-center">{{$value['SP50']}}</td>
                <td class="text-center">{{$value['DP40']}}</td>
                <td class="text-center">{{$value['SP40']}}</td>
                <td class="text-center">{{$value['DP30']}}</td>
                <td class="text-center">{{$value['SP30']}}</td>
                <td class="text-center">{{$value['DPnotStandart']}}</td>
                <td class="text-center">{{$value['SPnotStandart']}}</td>
                <td class="text-center">{{$value['DPwaste']}}</td>
                <td class="text-center">{{$value['SPwaste']}}</td>
                <td class="text-center">{{$value['DPland']}}</td>
                <td class="text-center">{{$value['SPland']}}</td>
                <td class="text-center" colspan="2">{{$value['SPdeclaine']}}</td>
                <td rowspan="2">{{$value['comment']}}</td>
            </tr>
        <tr>
            <td>{{$value['DV50']}}</td>
            <td>{{$value['SV50']}}</td>
            <td>{{$value['DV40']}}</td>
            <td>{{$value['SV40']}}</td>
            <td>{{$value['DV30']}}</td>
            <td>{{$value['SV30']}}</td>
            <td>{{$value['DVnotStandart']}}</td>
            <td>{{$value['SVnotStandart']}}</td>
            <td>{{$value['DVwaste']}}</td>
            <td>{{$value['SVwaste']}}</td>
            <td>{{$value['DVland']}}</td>
            <td>{{$value['SVland']}}</td>
            <td colspan="2">{{$value['SVdeclaine']}}</td>
            </tr>
        @endforeach
    </tbody>
    </table>





@endsection('info')
