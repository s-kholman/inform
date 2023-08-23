@extends('layouts.base')
@section('title', 'Разбраковка')

@section('info')
    <div class="container">
        <form method="post" action="{{route('gues.store')}}">
            @csrf
            <div class="row">
                <div class="col">
                    <p>Укажите разбраковку в процентах, сумма по полям ввода должна быть 100</p>
                </div>
            </div>
        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                <label class="float-end" for="fifty">50+</label>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                <input autofocus type="number" step="0.01" value="{{old('fifty')}}" class="display form-control @error('fifty') is-invalid @enderror" id="fifty" name="fifty">
                @error('fifty')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                <label class="float-end" for="forty">45-50</label>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                <input type="number" step="0.01" value="{{old('forty')}}" class="display form-control @error('forty') is-invalid @enderror" id="forty" name="forty">
                @error('forty')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                <label class="float-end" for="thirty">35-45</label>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                <input type="number" step="0.01" value="{{old('thirty')}}" class="display form-control @error('thirty') is-invalid @enderror" id="thirty" name="thirty">
                @error('thirty')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
        </div>
            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                    <label class="float-end" for="standard">Не стадарт</label>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                    <input type="number" step="0.01" value="{{old('standard')}}" class="display form-control @error('standard') is-invalid @enderror" id="standard" name="standard">
                    @error('standard')
                    <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
                    @enderror
                </div>
            </div>
        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                <label class="float-end" for="waste">Отход</label>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                <input type="number" step="0.01" value="{{old('waste')}}" class="display form-control @error('waste') is-invalid @enderror" id="waste" name="waste">
                @error('waste')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                <label class="float-end" for="land">Земля</label>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                <input type="number" step="0.01" value="{{old('land')}}" class="display form-control @error('land') is-invalid @enderror" id="land" name="land">
                @error('land')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                <label class="float-end" for="date">Дата</label>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                <input type="date"
                       class="display form-control @error('date') is-invalid @enderror"
                       id="date"
                       name="date"
                       value="{{date('Y-m-d')}}"
                >
                @error('date')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="ccol-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                <label class="float-end" for="comment">Коментарий</label>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 p-2">
                <input class="display form-control @error('comment') is-invalid @enderror" id="comment" name="comment">
                @error('comment')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
        </div>
            <div class="row">
                <div class="col-4 p-2">
                    <input hidden class="display form-control @error('full') is-invalid @enderror" name="full">
                    @error('full')
                    <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
                    @enderror
                </div>
            </div>
        <div class="row ">
            <div class="col-xxl-2 p-2">
                <a class="btn btn-primary" href="/storagebox">Назад</a>
            </div>
            <div class="col-xxl-2 p-2">
                <input type="submit" class="btn btn-primary" value="Сохранить">
            </div>
        </div>
            <input hidden name="storage_box_id" value="{{$model['id']}}">

        </form>
    </div>


@endsection('info')
