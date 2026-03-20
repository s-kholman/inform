@extends('layouts.base')
@section('title', 'Установка и просмотр уровней критической температуры для бокса')

@section('info')
<div class="container">
    <div class="card col-sm-8 mt-3">
        <div class="card-body">
            <h5 class="card-title">Добавление ролей</h5>
            <ol class="list-group list-group-numbered">
                <li class="list-group-item card-text">
                    Роли добавляем в справочнике <a href="/role"> Создать роли</a>. Роль должна начинаться "DeviceWarningTemperatureStorage" + название филиала (HRAN, LIPIHA). Тип роли "User"
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        В дальнейшем роли назначаем пользователям и на места хранения. На одного пользователя можно назначить несколько ролей. На место хранения только одна роль.
                    </div>
                </li>
            </ol>
        </div>
    </div>

    <form action="{{route('device.warning.temperature.storage.store')}}" method="post">
        <div class="col-sm-8 mt-4">
            @csrf
            <label for="storageName">Выберите место хранения</label>
            <select name="storageName" id="storageName" class="form-select @error('storageName') is-invalid @enderror">
                <option value=""></option>
                @forelse($storageName as $item)
                    <option value="{{$item->id}}"> {{$item->name}}</option>
                @empty
                    <option value="">Записи не найдены</option>
                @endforelse
            </select>
            @error('storageName')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="role">Выберите роль оповещения</label>
            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                <option value=""></option>
                @forelse($role as $item)
                    <option value="{{$item->id}}"> {{$item->name}}</option>
                @empty
                    <option value="">Записи не найдены</option>
                @endforelse
            </select>
            @error('role')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror


            <div class="row mt-2">
                <div class="col-6">
                    <label for="temperatureMax">MAX</label>
                    <input placeholder="Макс. температура"
                           class="form-control @error('temperatureMax') is-invalid @enderror"
                           value="{{old('temperatureMax')}}"
                           id="temperatureMax"
                           name="temperatureMax"
                    >
                </div>
                <div class="col-6">
                    <label for="temperatureMin">MIN</label>
                    <input placeholder="Мин. температура"
                           class="form-control @error('temperatureMin') is-invalid @enderror"
                           value="{{old('temperatureMin') ?? 0}}"
                           id="temperatureMin"
                           name="temperatureMin"
                    >
                </div>

            </div>
            <div class="form-switch form-check mt-4">
                <label id="label-active-check" class="form-label" for="active">Оповещение</label>
                <input class="form-check-input"
                       type="checkbox"
                       id="active"
                       name="active"
                       checked
                       @if(old('active'))checked @endif>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>



    <div class="col-sm-8">
    @forelse($deviceWarningTemperatureStorage as $item)
        @if($loop->first)
            <table class="table table-bordered text-center caption-top">
                <tr>
                    <th>№</th>
                    <th>Бокс</th>
                    <th>MAX</th>
                    <th>MIN</th>
                    <th>Оповещение</th>
                    <th>Роль</th>
                    <th>Действие</th>
                </tr>
        @endif
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->storageName->name}}</td>
                    <td>{{$item->temperature_max}}</td>
                    <td>{{$item->temperature_min}}</td>
                    <td>{{$item->active ? 'Включено' : 'Выключено'}}</td>
                    <td>{{$item->role->name}}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                Действия
                            </button>
                            <ul class="dropdown-menu">
                                <form class="delete-message"
                                      data-route="{{ route('device.warning.temperature.storage.destroy', ['storage' => $item->id])}}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <li><input type="submit" class="dropdown-item text-danger" value="Удалить">
                                    </li>
                                </form>
                            </ul>
                        </div>
                    </td>
                </tr>
            <br>
        @if($loop->last)
            </table>
            @endif
    @empty
        Данных нет
    @endforelse
    </div>

    <div class="col-sm-8">
        @forelse($role as $item)
            @if($loop->first)
                <table class="table table-bordered text-center caption-top">
                    <tr>
                        <th>№</th>
                        <th>Модель</th>
                        <th>ФИО</th>
                    </tr>
                    @endif
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->name}}</td>
                        <td>
                            @forelse($item->Users as $fio )
                                {{$fio->registration->last_name}}<br>
                            @empty
                            @endforelse
                        </td>
                    </tr>
                    <br>
                    @if($loop->last)
                </table>
            @endif
        @empty
        @endforelse
    </div>
</div>

@endsection('info')

@section('script')

    @include('scripts\destroy-modal')

@endsection
