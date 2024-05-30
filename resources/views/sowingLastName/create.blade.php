@extends('layouts.base')
@section('title', 'Справочник')

@section('info')

            <form enctype="multipart/form-data" action="{{ route('sowingLastName.store') }}" method="POST">
                @csrf
                <div class="border-3 row pb-3">
                    <div class="col-xl-3 col-sm-7">
                        <div class="form-floating mb-3">
                        <input name="sowingLastName" id="txtTitle" class="form-control @error('sowingLastName') is-invalid @enderror">
                            <label for="selectFilial">Введите ФИО</label>
                        <span>
                        @error('sowingLastName')
                    <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                </div>

                <div class="border-3 row pb-3 mb-3">
                    <div class="col-xl-3 col-sm-7">
                        <div class="form-floating mb-3">

                <select name="filial" id="selectFilial" class="form-select @error('filial') is-invalid @enderror">
                    <option value="">Выберите филиал</option>
                    @forelse($filials as $filial)
                        <option value="{{ $filial->id }}"> {{ $filial->name }} </option>
                    @empty
                        <option value=""> Филиал(ы) не найдены </option>
                    @endforelse
                </select>
                @error('filial')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                            <label for="selectFilial">Выберите филиал</label>
                        </div>
                    </div>
                </div>

                <div class="border-3 row pb-3 mb-3">
                    <div class="col-xl-3 col-sm-7">
                        <div class="form-floating mb-3">

                <input id="image"
                       class="form-control form-select @error('image') is-invalid @enderror"
                       type="file"
                       name="image"
                >
                @error('image')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                            <label for="image">Выберите файл для загрузки</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-2 col-sm-4">
                        <input type="submit" class="btn btn-primary" value="Сохранить">
                    </div>
                    <div class="col-xl-2 col-sm-4">
                        <a class="btn btn-info" href="/sowingLastName">Назад</a>
                    </div>
                </div>
            </form>

@endsection('info')
