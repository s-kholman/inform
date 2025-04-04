@extends('layouts.base')
@section('title', 'Внесите данные о поливе')

@section('info')

    <div class="col-6">
        <form action="{{ route('watering.store') }}" method="POST">
            @csrf

            <label for="pole">Выберите поле</label>
            <select name="pole" id="pole" class="form-select @error('pole') is-invalid @enderror">
                <option value=""></option>
                @forelse($poles as $pole)
                    <option {{old('pole') == $pole->id ? "selected" : ""}} value="{{$pole->id}}">{{$pole->name}}</option>
                @empty
                    <option value=""> Поля не найдены</option>
                @endforelse
            </select>
            @error('pole')
            <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
            </span>

            @enderror
            <label for="gidrant">Выберите гидрант</label>
            <select name="gidrant" id="gidrant" class="form-select @error('gidrant') is-invalid @enderror">
                <option {{old('gidrant') == "" ? "selected" : ""}} value=""></option>
                <option {{old('gidrant') == "I" ? "selected" : ""}} value="I">I</option>
                <option {{old('gidrant') == "II" ? "selected" : ""}} value="II">II</option>
                <option {{old('gidrant') == "III" ? "selected" : ""}} value="III">III</option>
            </select>
            @error('gidrant')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="sector">Выберите сектор</label>
            <select name="sector" id="sector" class="form-select @error('sector') is-invalid @enderror">
                <option value=""></option>
                @for ($i = 0; $i < 36; $i++)
                    <option {{old('sector') == $i+1 ? "selected" : ""}} value="{{$i+1}}">{{$i+1}}</option>
                @endfor
            </select>
            @error('sector')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="date">Дата</label>
            <input name="date" id="date" type="date" value="{{old('date') == "" ? date('Y-m-d') : old('date') }}"
                   class="form-control @error('date') is-invalid @enderror">
            @error('date')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="MM">Полив - мм</label>
            <input type="number" name="MM" id="MM" value="{{old('MM')}}" class="form-control @error('MM') is-invalid @enderror">
            @error('MM')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="speed">Скорость поливальной машины</label>
            <input type="number" name="speed" id="speed" value="{{old('speed')}}" class="form-control @error('speed') is-invalid @enderror">
            @error('speed')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="KAC">КАС</label>
            <input type="number" name="KAC" id="KAC" value="{{old('KAC')}}" class="form-control @error('KAC') is-invalid @enderror">
            @error('KAC')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="comment">Комментарий</label>
            <input name="comment" id="comment" value="{{old('comment')}}" class="form-control @error('comment') is-invalid @enderror">
            @error('comment')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div class="row m-4">
                <div class="col-4">
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                </div>
                <div class="col-8">
                    <a class="btn btn-outline-success"
                       href="/watering/index">К списку полей</a>
                </div>
            </div>

        </form>

    </div>
@endsection('info')
