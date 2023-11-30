@extends('layouts.base')
@section('title', 'Мониторинг температуры в боксах')

@section('info')
    <div class="container">
        <div class="row  text-center">
            <div class="col-12 p-5">
                <p><h4>График очередности в боксах:</h4></p>
            </div>
        </div>



        <div class="row text-center">
                <div class="col-12 ">
                    <form enctype="multipart/form-data" action="{{ route('pole.store') }}" method="POST">
                        @csrf
                    <label for="txtFilial">Выберите филиал</label>
                    <select name="filial" id="selectFilial" class="form-select @error('filial') is-invalid @enderror">
                        <option value="">Выберите филиал</option>

                        @forelse(\App\Models\filial::where('id', \App\Models\Registration::where('user_id', Auth::user()->id)->first()->filial_id)->get() as $filial)
                            <option selected value="{{ $filial->id }}"> {{ $filial->name }} </option>
                        @empty
                            <option value=""> Филиал(ы) не найдены </option>
                        @endforelse
                    </select>
                    @error('filial')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror

                    <label for="txtpole">Выберите изображение поля</label>
                    <input class="form-control form-select @error('image') is-invalid @enderror" type="file" name="image" placeholder="Выбрать изображение" id="image">
                    @error('image')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                    <a class="btn btn-info" href="/pole">Назад</a>
                    </form>
                </div>
        </div>

    </div>



@endsection('info')

