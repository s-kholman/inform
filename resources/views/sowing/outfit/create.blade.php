@extends('layouts.base')
@section('title', 'Создание связки для посева')

@section('info')
    <div class="container">
        <form action="{{ route('outfit.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-3">
                    <label for="select_sowing_last_name">ФИО</label>
                    <select name="sowing_last_name" id="select_sowing_last_name" class="col-3 form-select @error('sowing_last_name') is-invalid @enderror">
                        <option value=""></option>
                        @forelse(\App\Models\SowingLastName::all() as $sowing_last_name)
                            <option value="{{ $sowing_last_name->id }}"> {{ $sowing_last_name->name }} </option>
                        @empty
                            <option value="">Нет ФИО</option>
                        @endforelse
                    </select>
                    @error('sowing_last_name')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="txtFilial">Филиал</label>
                    <select name="filial" id="selectFilial"
                            class="col-3 form-select @error('filial') is-invalid @enderror">
                        <option value=""></option>
                        @forelse(\App\Models\filial::all() as $filial)
                            <option value="{{ $filial->id }}"> {{ $filial->name }} </option>
                        @empty
                        @endforelse
                    </select>
                    @error('filial')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <label for="sowing_type">Вид посева</label>
                    <select name="sowing_type" id="sowing_type"
                            class="col-3 form-select @error('sowing_type') is-invalid @enderror">
                        <option value=""></option>
                        @forelse(\App\Models\SowingType::all() as $sowing_type)
                            <option value="{{ $sowing_type->id }}"> {{ $sowing_type->name }} </option>
                        @empty
                        @endforelse
                    </select>
                    @error('sowing_type')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <label for="cultivation">Культура</label>
                    <select disabled name="cultivation" id="cultivation"
                            class="col-3 form-select @error('cultivation') is-invalid @enderror">
                        <option value=""></option>
                        @forelse(\App\Models\Cultivation::all() as $cultivation)
                            <option value="{{ $cultivation->id }}"> {{ $cultivation->name }} </option>
                        @empty
                        @endforelse
                    </select>
                    @error('cultivation')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <label for="select_machine">Агрегат</label>
                    <select disabled name="machine" id="select_machine"
                            class="col-3 form-select @error('machine') is-invalid @enderror">
                        <option value=""></option>
                        @forelse(\App\Models\Machine::all() as $machine)
                            <option value="{{ $machine->id }}"> {{ $machine->name }} </option>
                        @empty
                        @endforelse
                    </select>
                    @error('machine')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <input type="submit" class="btn btn-primary" value="Сохранить">
        </form>
    </div>
@endsection('info')
@section('script')
    <script>
    sowing_type.onchange = function ()
    {
        select_machine.disabled = false;
    }

    </script>
@endsection('script')

