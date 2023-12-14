@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <div class="col-3">
            <form enctype="multipart/form-data" action="{{ route('pole.store') }}" method="POST">
                @csrf
                    <label for="txtpole">Введите название поля</label>
                    <input name="pole" id="txtTitle" class="form-control @error('pole') is-invalid @enderror">
                @error('pole')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtcheckpoliv">Данное поле находится под поливом ---></label>
                <input type="checkbox" name="checkPoliv" id="checkPoliv" class="form-check-input">

                <label for="txtFilial">Выберите филиал</label>
                <select name="filial" id="selectFilial" class="form-select @error('filial') is-invalid @enderror">
                    <option value="">Выберите филиал</option>
                    @if (\Illuminate\Support\Facades\Auth::user()->email == 'sergey@krimm.ru')
                        @forelse(\App\Models\filial::all() as $filial)
                            <option selected value="{{ $filial->id }}"> {{ $filial->name }} </option>
                        @empty
                            <option value=""> Филиал(ы) не найдены </option>
                        @endforelse
                    @else
                        @forelse(\App\Models\filial::where('id', \App\Models\Registration::where('user_id', Auth::user()->id)->first()->filial_id)->get() as $filial)
                            <option selected value="{{ $filial->id }}"> {{ $filial->name }} </option>
                        @empty
                            <option value=""> Филиал(ы) не найдены </option>
                        @endforelse
                    @endif


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
@endsection('info')
