@extends('layouts.base')
@section('title', 'Создание связки для посева')

@section('info')
    <div class="container">
        <form action="{{ route('svyaz.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-3">
                    <label for="txtFIO">ФИО</label>
                    <select name="fio" id="selectFio" class="col-3 form-select @error('fio') is-invalid @enderror">
                        <option value=""></option>
                        @forelse($fios as $fio)
                            <option value="{{ $fio->id }}"> {{ $fio->name }} </option>
                        @empty
                            <option value="">Нет ФИО</option>
                        @endforelse
                    </select>
                    @error('fio')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="txtFilial">Филиал</label>
                    <select name="filial" id="selectFilial"
                            class="col-3 form-select @error('filial') is-invalid @enderror">
                        <option value=""></option>
                        @forelse(\App\Models\filial::all() as $filial)
                            <option value="{{ $filial->id }}"> {{ $filial->name }} </option>
                        @empty
                        @endforelse
                    </select>
                    @error('filial')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="txtAgregat">Агрегат</label>
                    <select name="agregat" id="selectAgregat"
                            class="col-3 form-select @error('agregat') is-invalid @enderror">
                        <option value=""></option>
                        @forelse(\App\Models\Agregat::all() as $agregat)
                            <option value="{{ $agregat->id }}"> {{ $agregat->name }} </option>
                        @empty
                        @endforelse
                    </select>
                    @error('agregat')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="txtVidposeva">Вид посева</label>
                    <select name="vidposeva" id="selectVidposeva"
                            class="col-3 form-select @error('vidposeva') is-invalid @enderror">
                        <option value=""></option>
                        @forelse(\App\Models\Vidposeva::all() as $vidposeva)
                            <option value="{{ $vidposeva->id }}"> {{ $vidposeva->name }} </option>
                        @empty
                        @endforelse
                    </select>
                    @error('vidposeva')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>
            <input type="submit" class="btn btn-primary" value="Сохранить">
        </form>
    </div>
@endsection('info')

