@extends('layouts.base')
@section('title', 'Создание пропуска')

@section('info')
    <div class="container">
        <div class="col-xl-6 col-lg-12 col-sm-12">

            <form action="{{ route('pass.filial.store') }}" method="POST">
                @csrf

                <label for="selectFilial">Выберите филиал</label>

                <select name="filial" id="selectFilial" class="form-select @error('filial') is-invalid @enderror">
                    <option value="0"></option>

                    @forelse($filials as $filial)
                        <option value="{{ $filial->filial_id }}"> {{ $filial->description}} </option>
                    @empty
                        <option value="">Записи не найдены</option>
                    @endforelse
                </select>
                @error('filial')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtDate">Дата</label>
                <input name="date" id="txtDate" type="date" value="{{old('date') ? old('date') : date('Y-m-d')}}"
                       class="form-control @error('date') is-invalid @enderror">
                @error('date')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="numberCar">Номер автомобиля</label>
                <input name="numberCar" id="numberCar" class="form-control @error('numberCar') is-invalid @enderror">
                @error('numberCar')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="lastName">ФИО</label>
                <input name="lastName" id="lastName" class="form-control @error('lastName') is-invalid @enderror">
                @error('lastName')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtcomment">Комментарий</label>
                <input name="comment" id="txtComment" class="form-control @error('comment') is-invalid @enderror">
                @error('comment')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <div class="mt-2">
                    <input type="submit" class="btn btn-primary" value="Сохранить">

                    <a class="btn btn-info" href="/pass/index">Назад</a>
                </div>

            </form>
        </div>
    </div>
@endsection('info')

