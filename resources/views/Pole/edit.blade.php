@extends('layouts.base')
@section('title', 'Справочник')

@section('info')

    <div class="row pb-3 mb-3">
            <form id="pole" enctype="multipart/form-data" action="{{ route('pole.update', ['pole' => $pole->id])}}" method="POST">
                @csrf
                @method('PUT')
                    <label for="txtpole">Введите название поля</label>
                    <input value="{{$pole->name}}" name="pole" id="txtTitle" class="form-control @error('pole') is-invalid @enderror">
                @error('pole')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtImage">Выберите изображение поля</label>
                <input class="form-control form-select @error('image') is-invalid @enderror" type="file" name="image" placeholder="Выбрать изображение" id="image">
                @error('image')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <div>
                <label for="txtcheckpoliv">Данное поле находится под поливом ---></label>
                <input type="checkbox" name="checkPoliv" id="checkPoliv" class="form-check-input" {{$pole->poliv ? "checked" : ""}}>
                </div>

                <input type="submit" class="btn btn-primary" value="Сохранить" form="pole">
                <a class="btn btn-info" href="/pole">Назад</a>

            </form>
            </div>



            <form action="{{ route('pole.destroy', ['pole' => $pole->id])}}" method="POST">
                @csrf
                @method('DELETE')
                <br><br><input type="submit" class="btn btn-danger" value="Удалить">
            </form>

@endsection('info')


