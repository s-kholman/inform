@extends('layouts.base')
@section('title', 'Справочник')

@section('info')

    <div class="container text-center border border-2">
        <form action="{{route('printer.current.store')}}" method="POST">
            @csrf
        <div class="row">
            <div class="col-12">
                <h2>{{\App\Models\DeviceName::where('id',$currentStatus->device_names_id)->value('name')}}</h2>
            </div>
            <div class="row">
                <div class="col-4">Текущие данные</div>
                <div class="col-4"></div>
                <div class="col-4">Введите новые данные</div>
            </div>
            <div class="col-sm-3 col-xxl-2">
                <div class="col-12 border border-2 form-control">Хост</div>
                <div class="col-12 border border-2 form-control">IP</div>
                <div class="col-12 border border-2 form-control">MAC</div>
                <div class="col-12 border border-2 form-control">Филиал</div>
                <div class="col-12 border border-2 form-control">Состояние</div>
                <div class="col-12 border border-2 form-control">Дата</div>
                <div class="col-12 border border-2 form-control">Комментарий</div>
            </div>
            <div class="col-sm-3 col-xxl-2">
                <div class="col-12 border border-2 form-control">{{$currentStatus->hostname}}</div>
                <div class="col-12 border border-2 form-control">{{$currentStatus->ip}}</div>
                <div class="col-12 border border-2 form-control">{{$currentStatus->device->mac ?? "00:00:00:00:00:00"}}</div>
                <div class="col-12 border border-2 form-control">{{$currentStatus->filial->name}}</div>
                <div class="col-12 border border-2 form-control">{{$currentStatus->status->name}}</div>
                <div class="col-12 border border-2 form-control">{{\Carbon\Carbon::parse($currentStatus->date)->format('d-m-Y')}}</div>
                <div class="col-12 border border-2 form-control">{{$currentStatus->comment ?? "\xC2\xA0" }}</div>
            </div>
            <div class="col-xxl-4 d-none d-lg-block">

            </div>
            <div class="col-sm-3 col-xxl-2">
                <div class="col-12 border border-2 form-control">Хост</div>
                <div class="col-12 border border-2 form-control">IP</div>
                <div class="col-12 border border-2 form-control">MAC</div>
                <div class="col-12 border border-2 form-control">Филиал</div>
                <div class="col-12 border border-2 form-control">Состояние</div>
                <div class="col-12 border border-2 form-control">Дата</div>
                <div class="col-12 border border-2 form-control">Комментарий</div>
            </div>
            <div class="col-sm-3 col-xxl-2">
                <div class="col-12">
                    <input type="text" name="hostname" value="{{$currentStatus->hostname}}" class="form-control @error('hostname') is-invalid @enderror">
                        @error('hostname')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror</div>
                <div class="col-12">
                    <input type="text" name="ip" value="{{$currentStatus->ip}}" class="form-control @error('ip') is-invalid @enderror">
                        @error('ip')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror</div>
                <div class="col-12">
                    <input readonly type="text" name="mac" value="{{str_replace(':','-',$currentStatus->device->mac) ?? "00:00:00:00:00:00"}}" class="form-control  @error('mac') is-invalid @enderror">
                        @error('mac')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-12">
                    <select name="filial" id="txtFilial" class="form-select @error('filial') is-invalid @enderror">
                        <option value="">Выберите значение</option>
                        @foreach(\App\Models\filial::all() as $value)
                            @if ($value->id == $currentStatus->filial->id)
                                <option selected value="{{ $value->id }}">  {{ $value->name }} </option>
                            @else
                                <option value="{{ $value->id }}">  {{ $value->name }} </option>
                            @endif
                        @endforeach
                    </select>
                    @error('filial')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-12">
                    <select name="status" id="txtStatus" class="form-select @error('status') is-invalid @enderror">
                        <option value="">Выберите значение</option>
                        @foreach(\App\Models\Status::all() as $value)
                            @if ($value->id == $currentStatus->status->id)
                                <option selected value="{{ $value->id }}">  {{ $value->name }} </option>
                            @else
                                <option value="{{ $value->id }}">  {{ $value->name }} </option>
                            @endif
                        @endforeach
                    </select>
                    @error('status')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-12">
                    <input type="date" name="date" value="{{\Carbon\Carbon::today()->format('Y-m-d')}}" class="form-control">
                </div>
                <div class="col-12">
                    <input type="text" name="comment" value="{{$currentStatus->comment}}" class="form-control  @error('comment') is-invalid @enderror">
                    @error('comment')
                    <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
            </div>
            <input hidden name="device_id" value="{{$currentStatus->device_id}}">
            <input hidden name="device_names_id" value="{{$currentStatus->device_names_id}}">
            <div class="row p-4">
                <div class="col-5">
                </div>
                <div class="col-sm-3 col-xxl-2">
                    <input class="form-control btn btn-success" type="submit" name="save" value="Сохранить">
                </div>
            </div>
        </div>
    </form>
        <div class="row p-sm-5 p-xxl-1">
            <div class="col-sm-3 col-xxl-4">

            </div>
            <div class="col-sm-6 col-xxl-4">
                <div class="row">
                    <a class="btn btn-info text-center" href="{{ url()->previous() }}">К списку отчетов</a>
                </div>

            </div>
        </div>
    </div>

@endsection('info')

