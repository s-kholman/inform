@extends('layouts.base')
@section('title', 'Справочник - СЗР')

@section('info')
    <div class="container">
        <div class="row">
            <div class="col">
                <a class="btn btn-info btn-md "  href="/szr/create">Создать</a>
            </div>

        </div>
        <div class="row mt-2">
            <table class="table table-bordered">
                <tbody>
            @forelse($value as $device)
                <tr>
                    <td width="25%">{{$device->SzrClasses->name}}</td>
                    <td width="75%"><a href="\szr\{{$device->id}}\edit">{{$device->name}}</a></td>
                </tr>
            @empty
            @endforelse
                </tbody>
            </table>
        </div>


    </div>
@endsection('info')
