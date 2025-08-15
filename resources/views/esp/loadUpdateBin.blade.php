@extends('layouts.base')
@section('title', 'Загрузка обновлений для ESP на сервер')

@section('info')

    <div class="container gx-4">
            <div class="row">
                <div class="col-6">
                    <form action="{{ route('esp.upload.bin.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <label for="compileDateBin">Дата компиляции прошивки</label>
                        <input name="compileDateBin" id="compileDateBin" type="date" value="{{now()->format('Y-m-d')}}"
                               class="form-control @error('compileDateBin') is-invalid @enderror">
                        @error('compileDateBin')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label for="versionBin">Версия прошивки</label>
                        <input name="versionBin" id="versionBin" type="text" value="0.0.1"
                               class="form-control @error('versionBin') is-invalid @enderror">
                        @error('versionBin')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label for="descriptionBin">Описание прошивки</label>
                        <textarea name="descriptionBin" id="descriptionBin"
                                  class="form-control @error('descriptionBin') is-invalid @enderror">Прошивка версии 0.0.1</textarea>
                        @error('descriptionBin')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label for="fileBin">Загрузите файл прошивки</label>
                        <input class="form-control @error('fileBin') is-invalid @enderror" type="file" id="fileBin" name="fileBin" accept=".bin">
                        @error('fileBin')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <button class="form-control" type="submit">Загрузить</button>
                    </form>
    </div>
@endsection('info')
