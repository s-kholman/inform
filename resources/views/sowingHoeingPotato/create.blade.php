@extends('layouts.base')
@section('title', 'Контроль окучивания картофеля')

@section('info')

    <div class="col-6">
        <form action="{{ route('sowing_hoeing_potato.store') }}" method="POST">
            @csrf

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

            <label for="type_field_work">Выберите вид работ</label>
            <select name="type_field_work" id="sowing_last_name" class="form-select @error('type_field_work') is-invalid @enderror">
                <option value=""></option>
                @forelse($type_field_works as $type_field_work)
                    <option {{old('type_field_work') == $type_field_work->id ? "selected" : ""}} selected value="{{$type_field_work->id}}">{{$type_field_work->name}}</option>
                @empty
                    <option value="">Виды работ не найдены</option>
                @endforelse
            </select>
            @error('type_field_work')
            <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
            </span>
            @enderror

            <label for="sowing_last_name">Выберите механизатора</label>
            <select name="sowing_last_name" id="sowing_last_name" class="form-select @error('sowing_last_name') is-invalid @enderror">
                <option value=""></option>
                @forelse($sowing_last_names as $sowing_last_name)
                    <option {{old('sowing_last_name') == $sowing_last_name->id ? "selected" : ""}} value="{{$sowing_last_name->id}}">{{$sowing_last_name->name}}</option>
                @empty
                    <option value=""> Механизаторы не найдены</option>
                @endforelse
            </select>
            @error('sowing_last_name')
            <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
            </span>
            @enderror

            <label for="volume">Обработанно, Га</label>
            <input name="volume"
                   type="number"
                   step="0.1"
                   min="0"
                   id="volume"
                   value="{{old('volume')}}"
                   class="form-control @error('volume') is-invalid @enderror">
            @error('volume')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="shift">Выберите смену</label>
            <select name="shift" id="shift" class="form-select @error('shift') is-invalid @enderror">
                <option value=""></option>
                @forelse($shifts as $shift)
                    <option {{old('shift') == $shift->id ? "selected" : ""}} value="{{$shift->id}}">{{$shift->name}}</option>
                @empty
                    <option value="">Виды работ не найдены</option>
                @endforelse
            </select>
            @error('shift')
            <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
            </span>
            @enderror

            <label for="result_control_agronomist">Результат контроля агроном</label>

            <select
                name="result_control_agronomist"
                    id="result_control_agronomist"
                    class="form-select @error('result_control_agronomist') is-invalid @enderror"
            >
                <option value=""></option>
                @forelse($hoeing_results as $hoeing_result)
                    <option {{old('result_control_agronomist') == $hoeing_result->id ? "selected" : ""}} value="{{$hoeing_result->id}}">{{$hoeing_result->name}}</option>
                @empty
                    <option value="">Данные не найдены</option>
                @endforelse
            </select>
            @error('result_control_agronomist')
            <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
            </span>
            @enderror

            @error('result_control_agronomist')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="result_control_director">Результат контроля директор</label>
            <select name="result_control_director"
                    id="result_control_director"
                    class="form-select @error('result_control_director') is-invalid @enderror"
                    @if($post['DIRECTOR'] == $post_user || $post['DEPUTY'] == $post_user)

                    @else
                    style="pointer-events: none"
                @endif
            >
                <option value=""></option>
                @forelse($hoeing_results as $hoeing_result)
                    <option {{old('result_control_director') == $hoeing_result->id ? "selected" : ""}} value="{{$hoeing_result->id}}">{{$hoeing_result->name}}</option>
                @empty
                    <option value="">Данные не найдены</option>
                @endforelse
            </select>
            @error('result_control_director')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="result_control_deputy_director">Результат контроля зам.ген.дир.</label>
            <select name="result_control_deputy_director"
                    id="result_control_deputy_director"
                    class="form-select @error('result_control_deputy_director') is-invalid @enderror"
                    @if($post['DEPUTY'] == $post_user)

                    @else
                    style="pointer-events: none"
                @endif
            >
                <option value=""></option>
                @forelse($hoeing_results as $hoeing_result)
                    <option {{old('result_control_deputy_director') == $hoeing_result->id ? "selected" : ""}} value="{{$hoeing_result->id}}">{{$hoeing_result->name}}</option>
                @empty
                    <option value="">Данные не найдены</option>
                @endforelse
            </select>

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
                       href="/sowing_hoeing_potato">К списку полей</a>
                </div>
            </div>

        </form>

    </div>
@endsection('info')
