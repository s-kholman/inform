@extends('layouts.base')
@section('title', 'Контроль нормы высадки картофеля')

@section('info')

    <div class="col-6">
        <form action="{{ route('sowing_control_potato.store') }}" method="POST">
            @csrf
            <input hidden name="filial_id" value="{{$filial_id}}">
            <label for="date">Дата</label>
            <input name="date" id="date" type="date" value="{{old('date') == "" ? date('Y-m-d') : old('date') }}"
                   class="form-control @error('date') is-invalid @enderror">
            @error('date')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="pole">Выберите поле</label>
            <select name="pole" id="pole" class="form-select @error('pole') is-invalid @enderror">
                <option value=""></option>
                @forelse($poles as $pole)
                    <option {{old('pole') == $pole->id ? "selected" : ""}} value="{{$pole->id}}">{{$pole->name}}</option>
                @empty
                    <option value=""> Поля не найдены</option>
                @endforelse
            </select>
            @error('pole')
            <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
            </span>
            @enderror

            <label for="sowing_last_name">Выберите механизатора</label>
            <select name="sowing_last_name" id="sowing_last_name" class="form-select @error('sowing_last_name') is-invalid @enderror">
                <option value=""></option>
                @forelse($sowing_last_names as $sowing_last_name)
                    <option {{old('sowing_last_name') == $sowing_last_name->SowingLastName->id ? "selected" : ""}} value="{{$sowing_last_name->SowingLastName->id}}">{{$sowing_last_name->SowingLastName->name}}</option>
                @empty
                    <option value=""> Механизаторы не найдены</option>
                @endforelse
            </select>
            @error('sowing_last_name')
            <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
            </span>
            @enderror

            <label for="type_field_work">Выберите вид работ</label>
            <select name="type_field_work" id="sowing_last_name" class="form-select @error('type_field_work') is-invalid @enderror">
                <option value=""></option>
                @forelse($type_field_works as $type_field_work)
                    <option {{old('type_field_work') == $type_field_work->id ? "selected" : ""}} value="{{$type_field_work->id}}">{{$type_field_work->name}}</option>
                @empty
                    <option value="">Виды работ не найдены</option>
                @endforelse
            </select>
            @error('type_field_work')
            <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
            </span>
            @enderror

            <label for="point_control">Точка контроля</label>
            <input name="point_control" id="point_control" value="{{old('point_control')}}" class="form-control @error('point_control') is-invalid @enderror">
            @error('point_control')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="result_control_agronomist">Результат контроля агроном</label>
            <input type="number"
                   step="1"
                   min="0"
                   name="result_control_agronomist"
                   id="result_control_agronomist"
                   value="{{old('result_control_agronomist')}}"
                   class="form-control @error('result_control_agronomist') is-invalid @enderror"
            >
            @error('result_control_agronomist')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="result_control_director">Результат контроля директор</label>
            <input type="number"
                   step="1"
                   min="0"
                   name="result_control_director"
                   id="result_control_director"
                   value="{{old('result_control_director')}}"
                   class="form-control @error('result_control_director') is-invalid @enderror"

                  @cannot(['SowingControl.director.store'])
                    readonly
                  @endcannot
            >
            @error('result_control_director')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="result_control_deputy_director">Результат контроля зам.ген.дир.</label>
            <input type="number"
                   step="1"
                   min="0"
                   name="result_control_deputy_director"
                   id="result_control_deputy_director"
                   value="{{old('result_control_deputy_director')}}"
                   class="form-control @error('result_control_deputy_director') is-invalid @enderror"

               @cannot('SowingControl.deploy.store')
                   readonly
                @endcannot
            >
            @error('result_control_deputy_director')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="comment">Комментарий</label>
            <input name="comment" id="comment" value="{{old('comment')}}" class="form-control @error('comment') is-invalid @enderror">
            @error('comment')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div class="row m-4">
                <div class="p-4 col-5">
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                </div>
                <div class="p-4 col-5">
                    <a class="btn btn-outline-success"
                       href="/sowing_control_potato/index">К списку полей</a>
                </div>
            </div>

        </form>

    </div>
@endsection('info')
