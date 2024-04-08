@extends('layouts.base')
@section('title', 'Справочник')

@section('info')

    <div class="row pb-3 mb-3">
            <form id="pole" enctype="multipart/form-data" action="{{ route('pole.update', ['pole' => $pole->id])}}" method="POST">
                @csrf
                @method('PUT')
                <input hidden name="update" value="1">
                <div class="border-3 row pb-3">
                    <div class="col-xl-3 col-sm-7">
                        <div class="form-floating mb-3">
                            <input value="{{$pole->name}}" name="pole" id="txtTitle" class="form-control @error('pole') is-invalid @enderror">
                            <label for="selectFilial">Введите название поля или отредактируйте</label>
                            <span>
                        @error('pole')
                    <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="col-xl-5 col-sm-10 mb-3">
                    <div class="form-check form-switch form-check-inline">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Данное поле находится под поливом?</label>
                        <input class="form-check-input" {{$pole->poliv ? "checked" : ""}} name="checkPoliv" type="checkbox" role="switch" id="checkPoliv">
                    </div>
                </div>

                <div class="border-3 row pb-3 mb-3">
                    <div class="col-xl-3 col-sm-7">
                        <div class="form-floating mb-3">
                            <input id="image" class="form-control form-select @error('image') is-invalid @enderror" type="file" name="image" id="image">
                            @error('image')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <label for="image">Выберите изображение поля</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-2 col-sm-4">
                        <input type="submit" class="btn btn-primary" value="Сохранить" form="pole">
                    </div>
                    <div class="col-xl-2 col-sm-4">
                        <a class="btn btn-info" href="/pole">Назад</a>
                    </div>
                </div>
            </form>
            </div>



            <form action="{{ route('pole.destroy', ['pole' => $pole->id])}}" method="POST">
                @csrf
                @method('DELETE')
                <br><br><input type="submit" class="btn btn-danger" value="Удалить">
            </form>

@endsection('info')


