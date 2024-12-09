@extends('layouts.base')
@section('title', 'Загрузить детализацию')

@section('info')
    <div class="container">
        <div class="row">
            <div class="col-5">
                <form action="{{ route('communication.load.render') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control" type="file" name="pdf" accept="application/pdf">
                    <button class="form-control" type="submit">Загрузить</button>
                </form>
            </div>
        </div>
@endsection('info')
