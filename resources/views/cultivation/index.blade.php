@extends('layouts.base')
@section('title', 'Справочник - культуры')

@section('info')
    <div class="container">
    <div class="col-6">
            <form action="{{ route('cultivation.store')}}" method="POST">
                @csrf
                    <label for="cultivation">Введите название культуры</label>
                    <input name="cultivation" id="cultivation" class="form-control @error('cultivation') is-invalid @enderror">
                @error('cultivation')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="sowing_type_id">Выберите тип посева</label>
                <select name="sowing_type" id="sowing_type_id" class="form-select @error('sowing_type') is-invalid @enderror">
                    <option value="">Выберите значение</option>
                    @forelse(\App\Models\SowingType::all() as $item)
                        <option value="{{ $item->id }}">  {{ $item->name }} </option>
                    @empty
                        <option value="">Заполните справочник</option>
                    @endforelse
                </select>
                @error('sowing_type')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="color">Выберите цвет заполнения ячейки в отчете</label>
                    <input type="color" value="#FFFFFF" name="color" id="color" class="form-control form-control-color @error('color') is-invalid @enderror">
                @error('color')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>
    </div>
    @forelse($cultivation as $item)
        <div class="row">
            <div class="col-3 border border-1">{{$item->sowingType->name}}</div>
            <div class="col-3 border border-1"><a href="\cultivation\{{$item->id}}\edit">{{$item->name}}</a></div>
            <div class="col-1 border border-1" style="background: {{$item->color}}"></div>
        </div>
    @empty
    @endforelse

    </div>
@endsection('info')
