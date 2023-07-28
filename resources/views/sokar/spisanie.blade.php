@extends('layouts.base')
@section('title', 'Склад лаборотории - СОКАР')

@section('info')

<div class="row">
        <div class="col">
    <form action="{{ route('spisanie.store') }}" method="POST">
        @csrf


        <label for="selectFIO">Выберите сотрудника</label>
        <select name="FIO" id="selectFIO" class="form-select @error('FIO') is-invalid @enderror">
                <option selected ></option>
                @forelse($spisok as $id => $value)
                    <option value="{{ $id }}"{{ old("FIO") == $id ? "selected":"" }}> {{$value}}</option>
                @empty
                    <option >Добавте значение в справочник</option>
                @endforelse
        </select>
        @error('FIO')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="selectSklad">Выберите номенклатуру со склада</label>
        <select name="sklad" id="selectSklad" class="form-select @error('sklad') is-invalid @enderror">
            <option selected ></option>
            @forelse($sklad as $id => $value)
                <option value="{{ $id }}" {{ old("sklad") == $id ? "selected":"" }}>{{$value}}</option>
            @empty
                <option >Нет наличия на складе</option>
            @endforelse
        </select>
        @error('sklad')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror


        <label for="txtCount">Введите количество</label>
        <input value="{{old("count")}}" name="count"  id="txtCount" class="form-control @error('count') is-invalid @enderror">
        @error('count')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="txtDate">Введите дату передачи</label>
        <input value="{{old("date")}}" type="date" name="date"  id="txtDate" class="form-control @error('date') is-invalid @enderror">
        @error('date')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror


        <input hidden name="temp"  id="txttemp" class="form-control @error('temp') is-invalid @enderror">
        @error('temp')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <input type="submit" class="btn btn-primary" value="Сохранить">
        <a class="btn btn-info" href="/sokar">Назад</a>
    </form>
    </div>
    <div class="col-1">

    </div>


    <div class="col-5">
<form action="{{route('spisanie.spisanieDate')}}" method="post">
    @csrf

        <p>Выберите период для просмотра списания</p>

        <label for="txtDateTo">Начало периода</label>
        <input type="date" name="dateTo"  id="txtDateTo" class="form-control @error('dateTo') is-invalid @enderror">
        @error('dateTo')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="txtDateDo">Конец периода</label>
        <input type="date" name="dateDo"  id="txtDateDo" class="form-control @error('dateDo') is-invalid @enderror">
        @error('dateDo')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    <input type="submit" class="btn btn-primary" value="Показать">




</form>

    </div>

@endsection('info')

