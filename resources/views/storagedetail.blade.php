@extends('layouts.base')
@section('title', 'Детализация чего-то со складом')

@section('info')
    <div class="container">
        <table class="table table-bordered table-striped">
            <caption class="border rounded-3 p-3 caption-top"><p class="text-center"><b>{{\App\Models\StorageName::where('id',$storageid->storage_id)->value('name')}}</b></p></caption>
            <thead>
            <th class="text-center">Дата</th>
            <th class="text-center">50</th>
            <th class="text-center">40</th>
            <th class="text-center">30</th>
            <th class="text-center">Не стандарт</th>
            <th class="text-center">Отход</th>
            <th class="text-center">Земля</th>
            </thead>
            <tbody>
            @foreach($storageDetail as $value)
                <tr>
                    <td>{{$value->created_at}}</td>
                    <td>{{$value->f50}}</td>
                    <td>{{$value->f40}}</td>
                    <td>{{$value->f30}}</td>
                    <td>{{$value->notstandart}}</td>
                    <td>{{$value->waste}}</td>
                    <td>{{$value->land}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
        <a class="btn btn-info" href="/box_itog">Назад</a>
    </div>
@endsection('info')
