@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
            <form action="{{ route('box.disassembly') }}" method="POST">
                @csrf
<div>
    <b>{{\App\Models\StorageName::where('id', $id)->value('name')}}</b>
</div>
                <input hidden name="id" value="{{$id}}">

                <label for="txt50">Фракция 50</label>
                <input name="f50" id="txt50" class="form-control  @error('f50') is-invalid @enderror" value="{{ old('f50') }}">
                @error('f50')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <label for="txt40">Фракция 40-50</label>
                <input name="f40" id="txt40" class="form-control @error('f40') is-invalid @enderror" value="{{ old('f40') }}">
                @error('f40')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <label for="txt30">Фракция 30-40</label>
                <input name="f30" id="txt30" class="form-control @error('f30') is-invalid @enderror" value="{{ old('f30') }}">
                @error('f30')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <label for="txtNotStandart">Не стандарт</label>
                <input name="notStandart" id="txtNotStandart" class="form-control @error('notStandart') is-invalid @enderror" value="{{ old('notStandart') }}">
                @error('notStandart')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <label for="txtWaste">Отход</label>
                <input name="waste" id="txtWaste" class="form-control @error('waste') is-invalid @enderror" value="{{ old('waste') }}">
                @error('waste')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <label for="txtland">Земля</label>
                <input name="land" id="txtland" class="form-control @error('land') is-invalid @enderror" value="{{ old('land') }}">
                @error('land')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input name="sum" class="form-control " hidden>
                @error('sum')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>


@endsection('info')
