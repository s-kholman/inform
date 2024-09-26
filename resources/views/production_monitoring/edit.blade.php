@extends('layouts.base')
@section('title', 'Внести мониторинг хранения')

@section('info')
    <div class="container">
        <div class="col-xl-6 col-lg-12 col-sm-12">
            <form action="{{ route('monitoring.update', ['monitoring' => $monitoring->id]) }}" method="POST">
                @csrf
                @method('PATCH')

                <label for="storage">Место хранения</label>
                    <input name="storage" id="storage" disabled value="{{$monitoring->storageName->name}}"
                           class="form-control @error('date') is-invalid @enderror">
                @error('storage')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtDate">Дата</label>
                <input disabled name="date" id="txtDate" type="date" value="{{$monitoring->date}}"
                       class="form-control @error('date') is-invalid @enderror">
                @error('date')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror


                <fieldset style="border: 2px solid #4d1616; margin: 5px; padding: 10px" class="rounded-4 DIRECTOR">
                    <legend>Заполняет руководитель</legend>
                    <label for="phase">Выберите фазу хранения</label>
                    <input name="phase" id="phase" disabled value="{{$monitoring->phase->name ?? ''}}"
                           class="form-control @error('date') is-invalid @enderror">
                    @error('phase')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror

                    <label for="temperature_keeping">Температура хранения</label>
                    <input type="number" step="0.01" name="temperature_keeping" id="temperature_keeping"
                           {{$monitoring->temperature_keeping <> null ? 'disabled' : ''}}
                           value="{{$monitoring->temperature_keeping}}"
                           class="form-control @error('temperature_keeping') is-invalid @enderror">
                    @error('temperature_keeping')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror

                    <label for="humidity_keeping">Влажность хранения</label>
                    <input type="number" name="humidity_keeping" id="humidity_keeping"
                           {{$monitoring->humidity_keeping <> null ? 'disabled' : ''}}
                           value="{{$monitoring->humidity_keeping}}"
                           class="form-control @error('humidity_keeping') is-invalid @enderror">
                    @error('humidity_keeping')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror


                    <div class="mb-3">
                        <label for="time">Период вентиляции</label>
                        <div id="time" class="row">
                            <div class="col">
                                <input name="timeUp" type="time" class="form-control @error('time') is-invalid @enderror">
                            </div>
                            <div class="col">
                                <input name="timeDown" type="time" class="form-control @error('time') is-invalid @enderror">
                            </div>
                        </div>
                        @error('time')
                        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                        @enderror
                    </div>
                </fieldset>


                <fieldset style="border: 2px solid #82f568; margin: 5px; padding: 10px" class="rounded-4 TEMPERATURE">
                    <legend>Заполняет температурщик</legend>
                    <label for="tuberTemperatureMorning">Температура клубня</label>
                    <input type="number" step="0.01" name="tuberTemperatureMorning" id="tuberTemperatureMorning"
                           {{$monitoring->tuberTemperatureMorning <> null ? 'disabled' : ''}}
                           value="{{$monitoring->tuberTemperatureMorning}}"
                           class="form-control @error('tuberTemperatureMorning') is-invalid @enderror">
                    @error('tuberTemperatureMorning')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror

                    <label for="humidity">Влажность</label>
                    <input type="number" name="humidity" id="humidity"
                           {{$monitoring->humidity <> null ? 'disabled' : ''}}
                           value="{{$monitoring->humidity}}"
                           class="form-control @error('humidity') is-invalid @enderror">
                    @error('humidity')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror

                    <div class="form-switch form-check mb-3">
                        <label class="form-label" for="condensate">Наличие конденсата в боксе</label>
                        <input class="form-check-input" type="checkbox" id="condensate"
                               @if($monitoring->condensate ?? false) checked onclick="return false;" @endif
                               name="condensate">
                    </div>
                </fieldset>

                <input type="submit" class="btn btn-primary" value="Сохранить">

                <a class="btn btn-info" href="{{url(route('monitoring.show.filial.all', ['storage_name_id' => $monitoring->storage_name_id, 'harvest_year_id' => $monitoring->harvest_year_id]))}}">Назад</a>
            </form>
            <div class="row">
            <div class="col-6">
            </div>
            {{--<div class="col-6">
                <form class="delete-message" data-route="{{ route('monitoring.destroy', ['monitoring' => $monitoring->id])}}" method="POST">
                    <input type="submit" class="btn btn-danger" value="Удалить">
                </form>
            </div>--}}
            </div>
        </div>
    </div>
@endsection('info')
@section('script')
    @include('scripts\destroy-modal')
    <script>
        let post_name = {!! json_encode($post_name) !!};
        let post_arr = ['DIRECTOR', 'DEPUTY', 'TEMPERATURE'];

        for (let i = 0; i <= post_arr.length-1; i++) {
            console.log(post_name + '   ' +  post_arr[i])
            if (post_name != '"'+post_arr[i]+'"') {
                document.querySelectorAll('.'+post_arr[i]).forEach(element => element.remove());
            }
        }
    </script>
@endsection
