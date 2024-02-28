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

                <label for="tempBurt">t бурта в трубах</label>
                <input type="number" step="0.01" name="tempBurt" id="tempBurt"
                       {{$monitoring->burtTemperature <> null ? 'disabled' : ''}}
                       value="{{$monitoring->burtTemperature}}"
                       class="form-control @error('tempBurt') is-invalid @enderror">
                @error('tempBurt')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="tempAboveBurt">t над буртом</label>
                <input type="number" step="0.01" name="tempAboveBurt" id="tempAboveBurt"
                       {{$monitoring->burtAboveTemperature <> null ? 'disabled' : ''}}
                       value="{{$monitoring->burtAboveTemperature}}"
                       class="form-control @error('tempAboveBurt') is-invalid @enderror">
                @error('tempAboveBurt')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="tempMorning">t клубня утром</label>
                <input type="number" step="0.01" name="tempMorning" id="tempMorning"
                       {{$monitoring->tuberTemperatureMorning <> null ? 'disabled' : ''}}
                       value="{{$monitoring->tuberTemperatureMorning}}"
                       class="form-control @error('tempMorning') is-invalid @enderror">
                @error('tempMorning')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="tempEvening">t клубня вечером</label>
                <input type="number" step="0.01" name="tempEvening" id="tempEvening"
                       {{$monitoring->tuberTemperatureEvening <> null ? 'disabled' : ''}}
                       value="{{$monitoring->tuberTemperatureEvening}}"
                       class="form-control @error('tempEvening') is-invalid @enderror">
                @error('tempEvening')
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

                <label for="phase">Выберите фазу хранения</label>
                    <input name="phase" id="phase" disabled value="{{$monitoring->phase->name}}"
                           class="form-control @error('date') is-invalid @enderror">
                @error('phase')
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


                <div class="form-switch form-check mb-3">
                    <label class="form-label" for="condensate">Наличие конденсата в боксе</label>
                    <input class="form-check-input" type="checkbox" id="condensate"
                           @if($monitoring->condensate ?? false) checked onclick="return false;" @endif
                           name="condensate">
                </div>

                <div class="mb-3">
                    <label for="comment">Коментарий</label>
                    <input name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror">
                    @error('comment')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>


                <input type="submit" class="btn btn-primary" value="Сохранить">

                <a class="btn btn-info" href="/monitoring/filial/all/{{$monitoring->storage_name_id}}">Назад</a>
            </form>
            <div class="row">
            <div class="col-6">
            </div>
            <div class="col-6">
                <form action="{{ route('monitoring.destroy', ['monitoring' => $monitoring->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger" value="Удалить">
                </form>
            </div>
            </div>
        </div>
    </div>
@endsection('info')
