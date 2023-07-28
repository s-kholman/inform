@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
            <form action="{{ route('nomenklature.add') }}" method="POST">
                @csrf
                    <label for="txtNomenklature">Введите название номенклатуры</label>
                    <input name="nomenklature" id="txtNomenklature" class="form-control ">

                <label for="txtKultura">Выберите культру</label>

                <select name="kultura" id="txtKultura" class="form-select @error('kultura') is-invalid @enderror">
                    <option value="">Выберите культуру</option>
                        @foreach(\App\Models\Kultura::all() as $value)
                            <option value="{{ $value->id }}"> {{ $value->name }} </option>
                        @endforeach
                </select>
                @error('kultura')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>
            @foreach(\App\Models\Nomenklature::all() as $value)
                {{$value->Kultura->name}} - {{$value->name}} <br>
            @endforeach
@endsection('info')
