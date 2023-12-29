@extends('layouts.base')
@section('title','Справочник - Тип посева')

@section('info')
    <div class="container">
        <form action="{{ route('type.update' , ['type' => $type]) }}" method="POST">
        <div class="row">
            <div class="col-3">
                    @csrf
                    @method('PUT')
                    <label for="txt">Наименование</label>
                    <input name="name" value="{{$type->name}}" id="txt" class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                     </span>
                    @enderror
            </div>
        </div>


            <div class="form-check">
                <input class="form-check-input @error('name') is-invalid @enderror"
                       name="no_machine"
                       type="checkbox"
                       id="check_machine"
                       @if(!$type->no_machine) checked @endif>
                <label class="form-check-label" for="check_machine">
                    Указывать технику в отчете?
                </label>
                @error('name')
                <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                     </span>
                @enderror
            </div>

            <div class="row p-3">
                <div class="col-2">
                    <input type="submit" class="btn btn-success" value="Обновить">
                </div>
                <div class="col-1">
                    <a class="btn btn-primary" href="/sowing/type/">Назад</a>
                </div>
            </div>

        </form>
<form action="{{ route('type.destroy' , ['type' => $type]) }}" method="POST">
    <div class="row p-3">
        <div class="col-3">
            @csrf
            @method('DELETE')
            <input type="submit" class="btn btn-danger" value="Удалить">
        </div>
    </div>
</form>
    </div>



@endsection('info')
