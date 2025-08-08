@extends('layouts.base')
@section('title', 'Внести новые данные')

@section('info')
    <div class="container">
        <div class="row">
            <div class="container">
                <form action="{{ route('communication.store')}}" method="post">
                    @csrf
                    <div class="row mb-3">
                        <label for="fio" class="col-sm-2 col-form-label">ФИО</label>
                        <div class="col-sm-6">
                            <input
                                type="text"
                                class="form-control @error('fio') is-invalid @enderror"
                                name="fio"
                                id="fio"
                                value="{{old('fio')}}"
                            >
                            @error('fio')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Телефон</label>
                        <div class="col-sm-6">
                            <input
                                type="text"
                                class="form-control @error('phone') is-invalid @enderror"
                                name="phone"
                                id="phone"
                                value="{{old('phone')}}"
                            >
                            @error('phone')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="limit" class="col-sm-2 col-form-label">Лимит</label>
                        <div class="col-sm-6">
                            <input
                                type="text"
                                class="form-control @error('limit') is-invalid @enderror"
                                name="limit"
                                id="limit"
                                value="{{old('limit')}}"
                            >
                            @error('limit')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-info me-md-4" type="submit" name="saveLimit">Сохранить</button>
                        <a class="btn btn-info" href="/communication">Назад</a>
                    </div>
                </form>
            </div>
    </div>
</div>
@endsection('info')
