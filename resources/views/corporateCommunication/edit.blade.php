@extends('layouts.base')
@section('title', 'Редактирование данных')

@section('info')
    <div class="container">
        <form action="{{ route('communication.update', ['communication' => $detail->id]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <label for="fio" class="col-sm-2 col-form-label">ФИО</label>
                <div class="col-sm-6">
                    <input
                        type="text"
                        class="form-control @error('fio') is-invalid @enderror"
                        name="fio"
                        id="fio"
                        @if(empty(old('fio'))) value="{{$detail->fio}}" @else value="{{old('fio')}}" @endif
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
                        @if(empty(old('phone'))) value="{{$detail->phone}}" @else value="{{old('phone')}}" @endif
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
                        @if(empty(old('limit'))) value="{{$detail->limit}}" @else value="{{old('limit')}}" @endif
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
@endsection('info')
{{--value="{{$detail->fio}}"
value="{{$detail->phone}}"
value="{{$detail->limit}}"--}}
