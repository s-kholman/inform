@extends('layouts.base')
@section('title', 'Главная')

@section('info')
    <div class="container text-center">
        <div class="row">
            <div class="border border-1 col-1">Дата</div>
            <div class="border border-1 col-1">50+</div>
            <div class="border border-1 col-1">45-50</div>
            <div class="border border-1 col-1">35-40</div>
            <div class="border border-1 col-1">Не стандарт</div>
            <div class="border border-1 col-1">Отходы</div>
            <div class="border border-1 col-1">Земля</div>
            <div class="border border-1 col-1">Вид операции</div>
            <div class="border border-1 col-1">Объем</div>
        </div>

        @forelse($all as $value)
            <div class="row ">

                <div class="border border-1 col-1">
                    {{\Carbon\Carbon::parse($value->date)->format('d-m-Y')}}
                </div>
                <div class="border border-1 col-1">
                    {{$value->fifty}}
                </div>
                <div class="border border-1 col-1">
                    {{$value->forty}}
                </div>
                <div class="border border-1 col-1">
                    {{$value->thirty}}
                </div>
                <div class="border border-1 col-1">
                    {{$value->standard}}
                </div>
                <div class="border border-1 col-1">
                    {{$value->waste}}
                </div>
                <div class="border border-1 col-1">
                    {{$value->land}}
                </div>
                <div
                    class="border border-1 col-1">@if($value->fifty+$value->forty+$value->thirty+$value->standard+$value->waste+$value->land == 100 )
                        <a href="/gues/{{$value->id}}">Разбраковка</a> @else <a href="/take/{{$value->id}}">Изъяли</a> @endif </div>
                <div
                    class="border border-1 col-1">@if($value->fifty+$value->forty+$value->thirty+$value->standard+$value->waste+$value->land == 100 ) @else
                        {{$value->fifty+$value->forty+$value->thirty+$value->standard+$value->waste+$value->land}} @endif </div>
            </div>
        @empty
            <div class="row">
            <div class="col-6 p-2">
                <form action="{{ route('storagebox.destroy', ['storagebox' => $storagebox])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger" value="Удалить">
                </form>
            </div>
            </div>
        @endforelse
        <div class="row">
            <div class="col-9 p-2 text-end">
                <a class="btn btn-primary " href="/storagebox">Назад</a>
            </div>
        </div>
    </div>
@endsection('info')
