@extends('layouts.base')
@section('title', 'Внести мониторинг хранения')

@section('info')
    <div class="container">
        <div class="col-xl-6 col-lg-12 col-sm-12">
            <form action="{{ route('monitoring.store') }}" method="POST">
                @csrf
                <label for="selectStorage">Выберите место хранения</label>
                <select name="storage" id="selectStorage" class="form-select @error('storage') is-invalid @enderror">
                    <option value=""></option>
                    @forelse(\App\Models\StorageName::where('filial_id', \App\Models\Registration::where('user_id', Auth::user()->id)->value('filial_id'))->get() as $storage)
                        <option
                        {{old('storage') == $storage->id ? "selected" : ""}} value="{{$storage->id}}">{{$storage->name}}</option>
                    @empty
                        <option value=""> Место хранения не найдены</option>
                    @endforelse
                </select>
                @error('storage')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtDate">Дата</label>
                <input name="date" id="txtDate" type="date" value="{{old('date') == '' ? date('Y-m-d') : old('date')}}"
                       class="form-control @error('date') is-invalid @enderror">
                @error('date')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="tempBurt">t бурта в трубах</label>
                <input type="number"
                       step="0.01"
                       name="tempBurt"
                       id="tempBurt"
                       value="{{old('tempBurt')}}"
                       class="form-control @error('tempBurt') is-invalid @enderror">
                @error('tempBurt')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="tempAboveBurt">t над буртом</label>
                <input type="number"
                       step="0.01"
                       name="tempAboveBurt"
                       id="tempAboveBurt"
                       value="{{old('tempAboveBurt')}}"
                       class="form-control @error('tempAboveBurt') is-invalid @enderror">
                @error('tempAboveBurt')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="tempMorning">t клубня утром</label>
                <input type="number"
                       step="0.01"
                       name="tempMorning"
                       id="tempMorning"
                       value="{{old('tempMorning')}}"
                       class="form-control @error('tempMorning') is-invalid @enderror">
                @error('tempMorning')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="tempEvening">t клубня вечером</label>
                <input type="number"
                       step="0.01"
                       name="tempEvening"
                       id="tempEvening"
                       value="{{old('tempEvening')}}"
                       class="form-control @error('tempEvening') is-invalid @enderror">
                @error('tempEvening')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="humidity">Влажность</label>
                <input type="number"
                       name="humidity"
                       id="humidity"
                       value="{{old('humidity')}}"
                       class="form-control @error('humidity') is-invalid @enderror">
                @error('humidity')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="selectPhase">Выберите фазу хранения</label>
                <select name="phase" id="selectPhase" class="form-select @error('phase') is-invalid @enderror">
                    <option value=""></option>
                    @forelse(\App\Models\StoragePhase::all() as $phase)
                        <option
                            {{old('phase') == $phase->id ? "selected" : ""}} value="{{$phase->id}}">{{$phase->name}}</option>
                    @empty
                        <option value="">Фазы не найдены</option>
                    @endforelse
                </select>
                @error('phase')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="time">Период вентиляции</label>
                <div id="time" class="row">
                    <div class="col">
                        <input name="timeUp"
                               type="time"
                               value="{{old('timeUp')}}"
                               class="form-control @error('time') is-invalid @enderror">
                    </div>
                    <div class="col">
                        <input name="timeDown"
                               type="time"
                               value="{{old('timeDown')}}"
                               class="form-control @error('time') is-invalid @enderror">
                    </div>
                </div>
                @error('time')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="comment">Коментарий</label>
                <input name="comment"
                       id="comment"
                       value="{{old('comment')}}"
                       class="form-control @error('comment') is-invalid @enderror">
                @error('comment')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="submit" class="btn btn-primary" value="Сохранить">

                <a class="btn btn-info" href="/monitoring">Назад</a>
            </form>
        </div>
    </div>
@endsection('info')
