@extends('layouts.base')
@section('title', 'Добавить термометр')

@section('info')

    <div class="container gx-4">
        <form action="{{route('esp.thermometer.store')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-6">
                    <label for="serial_number">Серийный номер</label>
                    <input placeholder="Серийный номер"
                           class="form-control @error('serial_number') is-invalid @enderror"
                           value="{{old('serial_number')}}"
                           id="serial_number"
                           name="serial_number"
                    >
                    @error('serial_number')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <label id="convert_text"></label>
            </div>
            <div class="mt-2">
                <input type="submit" class="btn btn-primary" value="Сохранить">

                {{--<a class="btn btn-info" href="/pass/index">Назад</a>--}}
            </div>
        </form>
                    {{--<label for="deviceESP">Выберите устройство</label>
                    <select name="deviceESP" id="deviceESP" class="form-select @error('deviceESP') is-invalid @enderror">
                        <option value="">не обязательно</option>
                        @forelse($devices as $device)
                            <option value="{{$device->id}}"> {{$device->mac}} </option>
                        @empty
                            <option value="">Записи не найдены</option>
                        @endforelse
                    </select>
                    @error('deviceESP')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror

                    <label for="point">Выберите точку замера</label>
                    <select name="point" id="point" class="form-select @error('point') is-invalid @enderror">
                        <option value="">не обязательно</option>
                        @forelse($points as $point)
                            <option value="{{$point->id}}"> {{$point->name}} </option>
                        @empty
                            <option value="">Записи не найдены</option>
                        @endforelse
                    </select>
                    @error('point')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror--}}


    </div>
@endsection('info')
@section('script')
    <script>
        const serial_number = document.getElementById('serial_number')
        const convert_text = document.getElementById('convert_text')

        serial_number.addEventListener('input', (event) => {
            //convert_text.textContent = parseInt(event.target.value, 16);
        })

    </script>
@endsection('script')
