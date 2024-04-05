@extends('layouts.base')
@section('title', 'Справочник')

@section('info')

            <form enctype="multipart/form-data" action="{{ route('pole.store') }}" method="POST">
                @csrf
                <div class="border-3 row pb-3">
                    <div class="col-xl-3 col-sm-7">
                        <div class="form-floating mb-3">
                        <input name="pole" id="txtTitle" class="form-control @error('pole') is-invalid @enderror">
                            <label for="selectFilial">Введите название поля</label>
                        <span>
                        @error('pole')
                    <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                </div>

                <div class="col-xl-5 col-sm-10 mb-3">
                    <div class="form-check form-switch form-check-inline">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Данное поле находится под поливом?</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="checkPoliv" name="checkPoliv">

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

                <input id="image" class="form-control form-select @error('image') is-invalid @enderror" type="file" name="image" placeholder="Выбрать изображение" id="image">
                @error('image')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                            <label for="image">Выберите изображение поля</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-2 col-sm-4">
                        <input type="submit" class="btn btn-primary" value="Сохранить">
                    </div>
                    <div class="col-xl-2 col-sm-4">
                        <a class="btn btn-info" href="/pole">Назад</a>
                    </div>
                </div>
            </form>

@endsection('info')
