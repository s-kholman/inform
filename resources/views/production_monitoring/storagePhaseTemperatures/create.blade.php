@extends('layouts.base')
@section('title','Контроль температуры по фазам хранения')

@section('info')
    <div class="container">
    <div class="col-6">
            <form action="{{ route('temperatures.store') }}" method="POST">
                @csrf
                    <label for="temperature_min">Минимальная температура</label>
                    <input name="temperature_min" id="txt" class="form-control @error('temperature_min') is-invalid @enderror">
                @error('temperature_min')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="temperature_max">Максимальная температура</label>
                <input name="temperature_max" id="txt" class="form-control @error('temperature_max') is-invalid @enderror">
                @error('temperature_max')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="storage_phase_id">Фазы хранения</label>
                <select name="storage_phase_id" id="storage_phase_id" class="form-select @error('storage_phase_id') is-invalid @enderror">
                    <option value="">Выберите значение</option>
                    @foreach(\App\Models\StoragePhase::all() as $item)

                        <option value="{{ $item->id }}">  {{ $item->name }} </option>
                    @endforeach
                </select>
                @error('storage_phase_id')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>
    </div>

        @forelse(\App\Models\StoragePhaseTemperature::all() as $value)
            <div class="row">
                <div class="col-3 border border-1">{{$value->storagePhase->name}}</div>
                <div class="col-3 border border-1">min: {{$value->temperature_min}}; max: {{$value->temperature_max}} </div>
            </div>
        @empty
        @endforelse
    </div>
@endsection('info')
