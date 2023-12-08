@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <div class="col-3">
            <form action="{{ route('peat.store') }}" method="POST">
                @csrf

                <label for="txtPeatExtraction">Выберите место добычи</label>
                <select name="PeatExtraction" id="selectPeatExtraction" class="form-select @error('PeatExtraction') is-invalid @enderror">
                    <option value="">Выберите место добычи</option>

                    @forelse(\App\Models\PeatExtraction::where('filial_id', \Illuminate\Support\Facades\Auth::user()->Registration->filial_id)->get() as $PeatExtraction)
                            <option value="{{ $PeatExtraction->id }}"> {{ $PeatExtraction->name }} </option>
                        @empty
                            <option value=""> Заполните справочник </option>
                        @endforelse
                </select>
                @error('PeatExtraction')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtPole">Выберите поле</label>
                <select name="Pole" id="selectPole" class="form-select @error('Pole') is-invalid @enderror">
                    <option value="">Выберите поле</option>

                    @forelse(\App\Models\Pole::query()->where('filial_id', \Illuminate\Support\Facades\Auth::user()->Registration->filial_id)->orderBy('name')->get() as $pole)
                        <option value="{{ $pole->id }}"> {{ $pole->name }} </option>
                    @empty
                        <option value=""> Заполните справочник </option>
                    @endforelse
                </select>
                @error('Pole')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtDate">Дата</label>
                <input name="date" id="txtDate" type="date" value="{{old('date') == '' ? date('Y-m-d') : old('date')}}"
                       class="form-control @error('date') is-invalid @enderror">
                @error('date')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="volume">Объем торфа</label>
                <input type="number"
                       step="1"
                       name="volume"
                       id="volume"
                       value="{{old('volume')}}"
                       class="form-control @error('volume') is-invalid @enderror">
                @error('volume')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input type="submit" class="btn btn-primary" value="Сохранить">

                <a class="btn btn-info" href="/peat">Назад</a>
            </form>
    </div>
@endsection('info')
