@extends('layouts.base')
@section('title', 'Внесение информации для отчета: Итоги хранения по боксам')

@section('info')
    <form method="post" action="{{route('storagebox.store')}}">
        @csrf
        <div class="container px-4">
            <div class="row">
                <div class="col-4 p-2">
                    <label for="storage_name">Место хранения</label>
                    <select class="form-select @error('storage_name') is-invalid @enderror" id="storage_name" name="storage_name">
                        <option>Выбор склада</option>
                        @forelse($storage as $value)
                            <option {{old('storage_name') == $value->id ? "selected" : ""}} value="{{$value->id}}">{{$value->name}}</option>
                        @empty
                            <option>Заполните справочник</option>
                        @endforelse
                    </select>
                    @error('storage_name')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-4 p-2">
                    <label for="field">Введите название полей поступления</label>
                    <input placeholder="Введите название полей поступления"
                           class="form-control @error('field') is-invalid @enderror"
                           value="{{old('field')}}"
                           id="field"
                           name="field">
                    @error('field')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-2 p-2">
                    <label for="selectFirst">Культура</label>
                    <select class="form-select @error('selectFirst') is-invalid @enderror"
                            name="selectFirst"
                            id="selectFirst">
                        <option></option>
                        @forelse($kultura as $value)
                            <option {{old('selectFirst') == $value->id ? "selected" : ""}} value="{{$value->id}}" >{{$value->name}}</option>
                        @empty
                            <option>Заполните справочник</option>
                        @endforelse
                    </select>
                    @error('selectFirst')
                    <span class="invalid-feedback">
                        <span>{{$message}}</span>
                    </span>
                    @enderror
                </div>

                <div class="col-2 p-2">
                    <label for="selectSecond">Номенклатура</label>
                    <select class="form-select @error('selectSecond') is-invalid @enderror"
                            name="selectSecond"
                            id="selectSecond">
                    </select>
                    @error('selectSecond')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">

                <div class="col-2 p-2">
                    <label for="selectThird">Репродукция</label>
                    <select class="form-select @error('selectThird') is-invalid @enderror"
                            name="selectThird"
                            id="selectThird">
                    </select>
                    @error('selectThird')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
                    <div class="col-2 p-2">
                        <label for="type">Тип</label>
                        <select class="form-select" name="type" id="type">
                            <option value="0"></option>
                            <option value="1">Товарный</option>
                            <option value="2">Семенной</option>
                        </select>
                    </div>
                </div>
            <div class="row">

                <div class="col-2 p-2">
                    <label for="volume">Объем</label>
                    <input placeholder="Объем"
                           class="form-control @error('volume') is-invalid @enderror"
                           value="{{old('volume')}}"
                           name="volume"
                           id="volume">
                    @error('volume')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-2 p-2">
                    <input class="btn btn-primary" type="submit" value="Сохранить" name="save">
                </div>
                <div class="col-2 p-2 text-end">
                    <a class="btn btn-primary" href="\storagebox">Назад</a>
                </div>
            </div>
        </div>
    </form>
@endsection('info')
@section('script')
    @include('scripts.KulturaNomenklaturaReproduktion')
@endsection('script')
