@extends('layouts.base')
@section('title', 'Создание связки для посева')

@section('info')
    <div class="container">
        <form action="{{ route('outfit.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xl-3 col-lg-8 col-sm-8" >
                    <p style="text-align: justify">Данный справочник служит для внесение связок при посевной. Связка это: Филиал -> ФИО -> Агрегат -> Культура</p>
                    <p style="text-align: justify">На основании этого справочника вносим данные по посевной.</p>
                    <p style="text-align: justify">Год посевной вычисляется по алгоритму если месяц больше 9 это будущий год, остальное текущий</p>
                </div>


            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-8 col-sm-8">
                    <label for="select_sowing_last_name">ФИО</label>
                    <select name="sowing_last_name" id="select_sowing_last_name" class="col-3 form-select @error('sowing_last_name') is-invalid @enderror">
                        <option value=""></option>
                        @forelse($sowing_last_names as $sowing_last_name)
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
                <div class="col-xl-3 col-lg-8 col-sm-8"">
                    <label for="txtFilial">Филиал</label>
                    <select name="filial" id="selectFilial"
                            class="col-3 form-select @error('filial') is-invalid @enderror">
                        <option value=""></option>
                        @forelse(\App\Models\filial::query()->orderBy('name')->get() as $filial)
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
                <div class="col-xl-3 col-lg-8 col-sm-8">
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
                <div class="col-xl-3 col-lg-8 col-sm-8">
                    <label for="cultivation">Культура</label>
                    <select disabled name="cultivation" id="cultivation"
                            class="col-3 form-select @error('cultivation') is-invalid @enderror">
                        <option value=""></option>
                    </select>
                    @error('cultivation')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-lg-8 col-sm-8">
                    <label for="select_machine">Агрегат</label>
                    <select disabled name="machine" id="select_machine"
                            class="col-3 form-select @error('machine') is-invalid @enderror">
                        <option value=""></option>
                        @forelse(\App\Models\Machine::query()->orderBy('name')->get() as $machine)
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
            <div class="row p-3">
                <div class="col-xl-1 col-lg-3 col-sm-3">
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                </div>
                <div class="col-1 ">
                </div>
                <div class="col-xl-1 col-lg-3 col-sm-3">
                    <a href="/sowing/outfit/index" class="btn btn-primary">Назад</a>
                </div>
            </div>


        </form>
    </div>
@endsection('info')
@section('script')
    <script>
        var SowingType = {!! $SowingType  !!};
        var Cultivation = {!! $Cultivation !!};

    sowing_type.onchange = function ()
    {
        if (SowingType[this.value][0]['no_machine']){
            cultivation.disabled = false;
            select_machine.disabled = true;
            select_machine.value = '';
            for (var i = 0; i < Cultivation[this.value].length; i++) {
                cultivation.innerHTML += '<option value="' + Cultivation[this.value][i]['id'] + '">' + Cultivation[this.value][i]['name'] + '</option>';
            }

        } else {
            cultivation.disabled = true;
            cultivation.value = '';
            select_machine.disabled = false;
        }
    }
    </script>
@endsection('script')

