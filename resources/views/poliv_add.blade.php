@extends('layouts.base')
@section('title', 'Внесите данные о поливе')

@section('info')

    <div class="col-3">
            <form action="{{ route('poliv.add') }}" method="POST">
                @csrf

                <label for="txtPole">Выберите поле</label>
                <select name="pole" id="selectPole" class="form-select @error('pole') is-invalid @enderror">
                    <option value=""></option>

                        @forelse(\App\Models\Pole::where('filial_id', \App\Models\Registration::where('user_id', Auth::user()->id)->first()->filial_id)->where('poliv', true)->orderby('name')->get() as $pole)
                            <option value="{{ $pole->id }}"> {{ $pole->name }} </option>
                        @empty
                            <option value="0"> Поля не найдены </option>
                        @endforelse
                </select>
                @error('pole')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <label for="txtGidrant">Выберите гидрант</label>
                <select name="gidrant" id="selectGidrant" class="form-select @error('gidrant') is-invalid @enderror">
                    <option value=""></option>
                        <option value="I">I</option>
                        <option value="II">II</option>
                    <option value="III">III</option>
                </select>
                @error('gidrant')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <label for="txtSector">Выберите сектор</label>
                <select name="sector" id="selectSector" class="form-select @error('sector') is-invalid @enderror">
                    <option value=""></option>
                    @for ($i = 0; $i < 36; $i++)
                        <option value="{{$i+1}}">{{$i+1}}</option>
                    @endfor


                </select>
                @error('sector')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <label for="txtDate">Дата</label>
                <input name="date" id="txtDate" type="date" value="{{date('Y-m-d')}}" class="form-control @error('date') is-invalid @enderror">
                @error('date')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtMM">Полив - мм</label>
                <input name="MM" id="txtMM" class="form-control @error('MM') is-invalid @enderror">
                @error('MM')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtspeed">Скорость поливальной машины</label>
                <input name="speed" id="txtTitle" class="form-control @error('speed') is-invalid @enderror">
                @error('speed')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtKAC">КАС</label>
                <input name="KAC" id="txtKAC" class="form-control @error('KAC') is-invalid @enderror">
                @error('KAC')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtcomment">Коментарий</label>
                <input name="comment" id="txtComment" class="form-control @error('comment') is-invalid @enderror">
                @error('comment')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="submit" class="btn btn-primary" value="Сохранить">


            </form>
    </div>
@endsection('info')
