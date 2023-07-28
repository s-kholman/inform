@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <form action="{{ route('sokarfio.store') }}" method="POST">
        @csrf
        <label for="txtLast">Введите Фамилию</label>
        <input name="last" id="txtLast" class="form-control @error('last') is-invalid @enderror">
        @error('last')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror


    <label for="txtFirst">Введите Имя</label>
    <input name="first" id="txtFirst" class="form-control @error('first') is-invalid @enderror">
    @error('first')
    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror


    <label for="txtMiddle">Введите Отчество (при наличии)</label>
    <input name="middle" id="txtMiddle" class="form-control @error('middle') is-invalid @enderror">
    @error('middle')
    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror

        <label for="selectGender">Укажите пол</label>
        <select name="gender" id="selectGender" class="form-select @error('gender') is-invalid @enderror">
            <option selected value="">Выберите пол</option>
            <option value="0">Женский</option>
            <option value="1">Мужской</option>
        </select>
        @error('gender')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="selectSizeShoes">Выберите размер обуви</label>
        <select name="sizeShoes" id="selectSizeShoes" class="form-select @error('shoes') is-invalid @enderror">
            <option selected ></option>
            @forelse(\App\Models\Size::where('size_type', 0)->orderby('name')->get() as $value)
                <option value="{{ $value->name }}"> {{ $value->name }} </option>
            @empty
                <option >Добавте значение в справочник</option>
            @endforelse
        </select>
        @error('shoes')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="selectSizeClothes">Выберите размер одежды</label>
        <select name="sizeClothes" id="selectSizeClothes" class="form-select @error('clothes') is-invalid @enderror">
            <option selected ></option>
            @forelse(\App\Models\Size::where('size_type', 2)->orderby('name')->get() as $value)
                <option value="{{ $value->name }}"> {{ $value->name }} </option>
            @empty
                <option >Добавте значение в справочник</option>
            @endforelse
        </select>
        @error('clothes')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="selectHeight">Выберите ростовку</label>
        <select name="sizeHeight" id="selectHeight" class="form-select @error('height') is-invalid @enderror">
            <option selected ></option>
            @forelse(\App\Models\Size::where('size_type', 1)->orderby('name')->get() as $value)
                <option value="{{ $value->name }}"> {{ $value->name }} </option>
            @empty
                <option >Добавте значение в справочник</option>
            @endforelse
        </select>
        @error('height')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="txtcheckActive">Исключить сотрудника</label>
        <input type="checkbox" name="active" id="checkActive" class="form-check-input"}}>
        <br> <br> <br>


    <input type="submit" class="btn btn-primary" value="Сохранить">
    <a class="btn btn-info" href="/sokar">Назад</a>
    </form>

    @forelse(\App\Models\SokarFIO::orderby('last')->get() as $value)
        @if ($loop->first)
            <table class="table table-bordered table-sm">
                <thead>
                <th>Фамилия</th>
                </thead>
                <tbody>
        @endif
        <tr><td><a href="/sokarfio/{{$value->id}}"> {{$value->last}} {{$value->first}} {{$value->middle}}</a></td></tr>


        @if($loop->last)
                </tbody>
            </table>
        @endif

    @empty
        <p>Нет сотрудников для отображения</p>
    @endforelse
@endsection('info')

