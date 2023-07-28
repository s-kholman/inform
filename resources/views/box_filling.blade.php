@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
            <form action="{{ route('box.filling') }}" method="POST">
                @csrf

                <select name="storage" id="selectstorage" class="form-select ">
                    <option value="">Выберите Склад</option>

                        @foreach(\App\Models\Storage::all() as $value)
                            <option value="{{ $value->id }}"> {{ $value->name }} </option>
                        @endforeach

                </select>

                <select name="nomenklature" id="selectnomenklature" class="form-select ">
                    <option value="">Выберите номенклатуру</option>

                    @foreach(\App\Models\Nomenklature::all() as $value)
                        <option value="{{ $value->id }}"> {{ $value->name }} </option>
                    @endforeach

                </select>

                <label for="txtField">Поле</label>
                <input name="field" id="txtField" class="form-control ">

                <label for="txtQuantity">Объем</label>
                <input name="quantity" id="txtQuantity" class="form-control ">



                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>

            <table class="table">
                <th>Бокс</th><th>Поле</th><th>Номенклатура</th><th>На хранении</th><th colspan="2">Внести данные</th>
    @foreach(\App\Models\Box::all() as $value)
        <tr>
            <td>{{\App\Models\Storage::where('id', $value->storage_id)->value('name')}}</td>
            <td>{{$value->field}}</td>
            <td>{{\App\Models\Nomenklature::where('id', $value->nomenklature_id)->value('name')}}</td>
            <td>{{$value->quautity}}</td>
            <td><a href="/box_disssembly_show/d/{{$value->id}}">Разбр</a> </td>
            <td><a href="/box_sampling_show/s/{{$value->id}}">Изъяли</a> </td>
        </tr>

    @endforeach
            </table>
@endsection('info')
