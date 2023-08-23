@extends('layouts.base')
@section('title', 'Удалить изъятие')

@section('info')
    <div class="container">
        <div class="row">
            <div class="col-6 ">
                <a class="btn btn-primary " href="/storagebox">Назад</a>
            </div>

            <div class="col-6 ">
                <form action="{{ route('take.destroy', ['take' => $take])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger" value="Удалить">
                </form>
            </div>
        </div>
    </div>
@endsection('info')


