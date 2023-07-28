@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <form action="{{ route('counterparty.update', ['counterparty' => $counterparty->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="txtCounterparty">Отредактируйте наименование контрагента</label>
        <input name="counterparty" value="{{$counterparty->name}}" id="txtCounterparty" class="form-control @error('counterparty') is-invalid @enderror">
        @error('counterparty')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
        <input type="submit" class="btn btn-primary" value="Сохранить изменения">
        <a class="btn btn-info" href="/counterparty">Назад</a>
    </form>


    <div>
        <form action="{{ route('counterparty.destroy', ['counterparty' => $counterparty->id])}}" method="POST">
            @csrf
            @method('DELETE')
            <div><p>При нажатии кнопки удалить данные будут удаленны без подтверждения</p>
            <br><br><input type="submit" class="btn btn-danger" value="Удалить">
            </div>
        </form>
    </div>
@endsection('info')

