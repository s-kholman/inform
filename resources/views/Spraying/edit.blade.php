@extends('layouts.base')
@section('title', 'Справочник')
@section('info')

<div class="row">

    <div class="col-6">
        <a class="btn btn-info" href="/spraying/{{$spraying->pole_id}}">Назад</a>
    </div>

    <div class="col-6">
        <form action="{{ route('spraying.destroy', ['spraying' => $spraying->id])}}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" class="btn btn-danger" value="Удалить">
        </form>
    </div>

</div>

@endsection('info')


