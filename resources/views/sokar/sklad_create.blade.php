@extends('layouts.base')
@section('title', 'Склад лаборотории - СОКАР')

@section('info')
    <form action="{{ route('sokarsklad.store') }}" method="POST">
        @csrf


        <label for="selectCounterparty">Выберите контрагента</label>
        <select name="counterparty" id="selectCounterparty" class="form-select @error('сounterparty') is-invalid @enderror">
                <option selected ></option>
                @forelse(\App\Models\Counterparty::orderby('name')->get() as $value)
                    <option value="{{ $value->id }}"> {{ $value->name }} </option>
                @empty
                    <option >Добавте значение в справочник</option>
                @endforelse
        </select>
        @error('сounterparty')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="selectNomenklat">Выберите номенклатуру</label>
        <select name="nomenklat" id="selectNomenklat" class="form-select @error('nomenklat') is-invalid @enderror">
            <option selected ></option>
            @forelse(\App\Models\SokarNomenklat::orderby('name')->get() as $value)
                <option value="{{ $value->id }}"> {{ $value->name }} </option>
            @empty
                <option >Добавте значение в справочник</option>
            @endforelse
        </select>
        @error('nomenklat')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
        <label for="selectSize">Выберите размер</label>
        <select name="size" id="selectSize" class="form-select @error('size') is-invalid @enderror">
            <option selected ></option>
            @forelse(\App\Models\Size::where('size_type', 0)->orwhere('size_type', 2)->orderby('size_type')->orderby('name')->get() as $value)
                <option value="{{ $value->id }}"> {{ $value->name }} </option>
            @empty
                <option >Добавте значение в справочник</option>
            @endforelse
        </select>
        @error('size')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="selectColor">Выберите цвет</label>
        <select name="color" id="selectColor" class="form-select @error('color') is-invalid @enderror">
            <option selected ></option>
            @forelse(\App\Models\Color::orderby('name')->get() as $value)
                <option value="{{ $value->id }}"> {{ $value->name }} </option>
            @empty
                <option >Добавте значение в справочник</option>
            @endforelse
        </select>
        @error('color')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="selectHeight">Выберите ростовку</label>
        <select name="height" id="selectHeight" class="form-select @error('height') is-invalid @enderror">
            <option selected ></option>
            @forelse(\App\Models\Size::where('size_type', 1)->orderby('name')->get() as $value)
                <option value="{{ $value->id }}"> {{ $value->name }} </option>
            @empty
                <option >Добавте значение в справочник</option>
            @endforelse
        </select>
        @error('height')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="txtCount">Введите количество</label>
        <input name="count"  id="txtCount" class="form-control @error('count') is-invalid @enderror">
        @error('count')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="txtDate">Введите дату поступления</label>
        <input type="date" name="date"  id="txtDate" class="form-control @error('date') is-invalid @enderror">
        @error('date')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror


        <input type="submit" class="btn btn-primary" value="Сохранить">
        <a class="btn btn-info" href="/sokar">Назад</a>
    </form>

    @forelse(\App\Models\SokarSklad::whereDate('created_at', \Illuminate\Support\Carbon::today())->groupby('counterpartie_id')->groupby('sokar_sklads.id')->get() as $value )
        @if ($loop->first)
            <br><br><br>
            <table class="table table-bordered table-sm">
                <caption class="caption-top">Поступление разнесенное сегодня</caption>
                <thead>
                <th>Контрагент</th>
                <th>Наименование</th>
                <th>Размер</th>
                <th>Ростовка</th>
                <th>Цвет</th>
                <th>Кол-во</th>
                </thead>
                <tbody>
                @endif
                <tr>
                    <td>{{$value->Counterparty->name ?? '-'}}</td>
                    <td><a href="nomenklat/{{$value->id}}"> {{$value->SokarNomenklat->name}}</a></td>
                    <td>{{$value->Size->name ?? '-'}}</td>
                    <td>{{$value->Height->name ?? '-'}}</td>
                    <td>{{$value->Color->name ?? '-'}}</td>
                    <td>{{$value->count}}</td>
                </tr>


                @if($loop->last)
                </tbody>
            </table>
        @endif

    @empty
        <p>На складе ничего нет</p>
    @endforelse

@endsection('info')

