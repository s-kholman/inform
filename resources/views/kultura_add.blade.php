@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
            <form action="{{ route('kultura.store') }}" method="POST">
                @csrf
                    <label for="txtkultura">Введите название культуры</label>
                    <input name="kultura" id="txtTitle" class="form-control @error('kultura') is-invalid @enderror">
                @error('kultura')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <select name="vidposeva" id="selectVidposeva" class="form-select @error('vidposeva') is-invalid @enderror">
                    <option value="">Выберите вид посева</option>
                    @if (count($vidposevas) > 0)
                        @foreach($vidposevas as $vidposeva)
                            <option value="{{ $vidposeva->id }}"> {{ $vidposeva->name }} </option>
                        @endforeach
                    @endif
                </select>
                @error('vidposeva')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror


                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>
@endsection('info')
