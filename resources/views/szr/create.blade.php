@extends('layouts.base')
@section('title', 'Справочник')

@section('info')

    <div class="container">
        <div class="col-6">
            <form action="{{ route('szr.store')}}" method="POST">
                @csrf
                <label for="txt">Введите название СЗР</label>
                <input name="name" id="txt" class="form-control @error('name') is-invalid @enderror">
                @error('name')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtSelect">Выберите тип СЗР</label>
                <select name="select" id="txtSelect" class="form-select @error('select') is-invalid @enderror">
                    <option value="">Выберите значение</option>
                    @foreach($parent_value as $item)

                        <option value="{{ $item->id }}">  {{ $item->name }} </option>
                    @endforeach
                </select>
                @error('select')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div class="row">
                    <div class="col-6">
                        <label for="interval_day_start">От</label>
                        <input type="number" step="1" name="interval_day_start" id="interval_day_start" value="{{old('interval_day_start') ? old('interval_day_start') : null}}"
                               class="form-control @error('interval_day_start') is-invalid @enderror">
                        @error('interval_day_start')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="interval_day_end">До</label>
                        <input type="number" step="1" name="interval_day_end" id="interval_day_end" value="{{old('interval_day_end') ? old('interval_day_end') : null}}"
                               class="form-control @error('interval_day_end') is-invalid @enderror">
                        @error('interval_day_end')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <label for="dosage">Дозировка</label>
                <input type="number" step="0.001" name="dosage" id="dosage" class="form-control @error('dosage') is-invalid @enderror">
                @error('dosage')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <div class="row mt-2">
                    <div class="col-2">
                        <input type="submit" class="btn btn-primary" value="Сохранить">
                    </div>
                    <div class="col-3"></div>
                    <div class="col-2">
                        <a href="/szr"  class="btn btn-secondary">Назад</a>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection('info')


