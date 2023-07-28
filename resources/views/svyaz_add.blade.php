@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
            <form action="{{ route('svyaz.add') }}" method="POST">
                @csrf
                <label for="txtFIO">ФИО</label>
                <select name="fio" id="selectFio" class="form-select @error('fio') is-invalid @enderror">
                    <option value=""></option>
                    @if (count($fios) > 0)
                        @foreach($fios as $fio)
                            <option value="{{ $fio->id }}"> {{ $fio->name }} </option>
                        @endforeach
                    @endif
                </select>
                @error('fio')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtFilial">Филиал</label>
                <select name="filial" id="selectFilial" class="form-select @error('filial') is-invalid @enderror">
                    <option value=""></option>
                    @if (count($filials) > 0)
                        @foreach($filials as $filial)
                            <option value="{{ $filial->id }}"> {{ $filial->name }} </option>
                        @endforeach
                    @endif
                </select>
                @error('filial')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtAgregat">Агрегат</label>
                <select name="agregat" id="selectAgregat" class="form-select @error('agregat') is-invalid @enderror">
                    <option value=""></option>
                    @if (count($agregats) > 0)
                        @foreach($agregats as $agregat)
                            <option value="{{ $agregat->id }}"> {{ $agregat->name }} </option>
                        @endforeach
                    @endif
                </select>
                @error('agregat')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtVidposeva">Вид посева</label>
                <select name="vidposeva" id="selectVidposeva" class="form-select @error('vidposeva') is-invalid @enderror">
                    <option value=""></option>
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
            @if (count($svyazs) > 0)
    <table class="table">
<th>Филиал</th><th>Агрегат</th><th>ФИО</th><th>Вид</th><th>Дата</th><th>Статус</th><th>Деактивировать</th><th>Удалить</th>
            @foreach($svyazs as $svyaz)
                <tr>
                <td> {{ $svyaz->filial->name }} </td>
                    <td>{{ $svyaz->agregat->name }}</td>
                    <td>{{ $svyaz->fio->name }}</td>
                    <td>{{ $svyaz->vidposeva->name }}</td>
                    <td>{{ $svyaz->date }}</td>
                    <td>{{ $svyaz->active ? 'Активно' : 'Закрыта'}}</td>

                    @can('destroy', 'App\Models\svyaz')
                        <td><a class="btn" href="{{$svyaz->active ? route('svyaz.disable', ['svyaz' => $svyaz->id ]) : '#' }}">Деактивировать</a> </td>
                    @endcan
                    @cannot('destroy', 'App\Models\svyaz')
                        <td><a class="btn disabled" href="{{$svyaz->active ? route('svyaz.disable', ['svyaz' => $svyaz->id ]) : '#' }}">Деактивировать</a> </td>
                    @endcannot

                    @can('destroy', 'App\Models\svyaz')
                        <td><a class="btn" href=" {{ route('svyaz.delete', ['svyaz' => $svyaz->id ]) }}">Удалить</a> </td>
                    @endcan
                    @cannot('destroy', 'App\Models\svyaz')
                        <td><a class="btn disabled" href=" {{ route('svyaz.delete', ['svyaz' => $svyaz->id ]) }}">Удалить</a> </td>
                    @endcannot
                </tr>
            @endforeach


    </table>
            @endif
@endsection('info')

