@extends('layouts.base')
@section('title', 'Удаление информации о поливе')

@section('info')
    @csrf
        <div>
            <form action="{{ route('watering.destroy', ['watering' => $watering->id])}}" method="POST">
             @csrf
                @method('DELETE')
                <p>При нажатии кнопки удалить данные будут удаленны без подтверждения</p>
                <br><br><input type="submit" class="btn btn-danger" value="Удалить">
                <a class="btn btn-info" href="/watering/show/{{$watering->filial_id}}/{{$watering->pole_id}}">Назад</a>
            </form>
        </div>

@endsection('info')
