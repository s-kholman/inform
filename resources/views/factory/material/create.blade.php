@extends('layouts.base')
@section('title', 'Поступление сырья на завод')

@section('info')
    <form  enctype="multipart/form-data" method="post" action="{{route('material.store')}}">
        @csrf
        <div class="container gx-4">
            <div class="row">
                    <label class="float-end" for="date">Дата</label>
                <div class="col-4 p-2">
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
                <div class="col-4 p-2">
                    <label for="filial_name">Филиал поступления</label>
                    <select class="form-select @error('filial_name') is-invalid @enderror" id="filial_name"
                            name="filial_name">
                        <option>Выберите филиал</option>
                        @forelse($filials as $filial)
                            <option
                                {{old('filial_name') == $filial->id ? "selected" : ""}} value="{{$filial->id}}">{{$filial->name}}</option>
                        @empty
                            <option>Заполните справочник</option>
                        @endforelse
                    </select>
                    @error('filial_name')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-4 p-2">
                    <label for="fio">Введите ФИО</label>
                    <input placeholder="Введите ФИО"
                           class="form-control @error('fio') is-invalid @enderror"
                           value="{{old('fio')}}"
                           id="fio"
                           name="fio">
                    @error('fio')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-4 p-2">
                    <label for="nomenklature">Номенклатура</label>
                    <select class="form-select @error('nomenklature') is-invalid @enderror" id="nomenklature"
                            name="nomenklature">
                        <option>Выберите номенклатуру</option>
                        @forelse($nomenklatures as $nomenklature)
                            <option
                                {{old('nomenklature') == $nomenklature->id ? "selected" : ""}} value="{{$nomenklature->id}}">{{$nomenklature->name}}</option>
                        @empty
                            <option>Заполните справочник</option>
                        @endforelse
                    </select>
                    @error('nomenklature')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-4 p-2">
                    <label for="image">Выберите изображение</label>
                    <input class="form-control form-select @error('image') is-invalid @enderror"
                           type="file"
                           name="image"
                           placeholder="Выбрать изображение"
                           id="image">
                    @error('image')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="row">

            </div>
            <div class="row">
                <div class="col-2 p-2">
                    <input class="btn btn-primary" type="submit" value="Сохранить" name="save">
                </div>
                <div class="col-2 p-2 text-end">
                    <a class="btn btn-primary" href="/factory/material">Назад</a>
                </div>
            </div>
        </div>
        </div>
    </form>
@endsection('info')
