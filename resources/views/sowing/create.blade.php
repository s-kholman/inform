@extends('layouts.base')
@section('title', 'Внесение информации о посеве')

@section('info')

    <div>
        <div class="row">
            <div class="col-12">
                <p>
                    <b>Для исправления ошибки в Га</b>, необходимо заново внести данные с новым значением Га. Записи не дублируются.
                </p>
            </div>
            <div class="col-12">
                <p>
                    <b>Удаление записи</b> производится внесением данных с нулевым объемом (0).
                </p>
            </div>
            <div class="col-12">
                <p>
                    <b>Для внесения данных с переходом</b>, сеяли пшеницу стали рапс. Вносим новый посев в тот-же день.
                </p>
            </div>
        </div>
    </div>

    <form action="{{ route('sowing.store') }}" method="POST">
        @csrf
    <div class="row text-center">
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 p-2">
            <label for="selectFilial">Филиал</label>
            <select name="filial" id="selectFilial" class="form-select @error('filial') is-invalid @enderror">
                <option value=""></option>
                @forelse($filials as $filial)
                    <option selected value="{{ $filial->id }}"> {{ $filial->name }} </option>
                @empty
                    <option value=""> Поля не найдены</option>
                @endforelse
                {{--<option selected value="{{ $filial_id->filial_id }}"> {{ $filial_id->filial->name }} </option>--}}
            </select>
            @error('filial')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
        <div class="row text-center">
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 p-2">
            <label for="sowing_type">Вид выполняемых работ</label>
            <select name="sowing_type" id="sowing_type" class="form-select @error('sowing_type') is-invalid @enderror">
                <option value=""></option>
                @forelse(\App\Models\SowingType::all() as $sowing_type)
                    <option value="{{ $sowing_type->id }}"> {{ $sowing_type->name }} </option>
                @empty
                    <option value="0">Заполните справочник</option>
                @endforelse
            </select>
            @error('sowing_type')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

        <div class="row pb-3 mb-3">
            <div class="col-xl-2 col-sm-4">
                <input type="submit" class="btn btn-primary" value="Сохранить">
            </div>
            <div class="col-xl-2 col-sm-4">
                <a class="btn btn-info" href="/sowing?id=1">Назад</a>
            </div>
        </div>

        <div class="row pb-3 mb-3" id="textFIO" style="width:100%; height:1px; clear:both;">
        </div>
    </form>

@endsection('info')
@section('script')
    <script>
        //Вывести отдельно в файл
        //Пресмотреть все названия элиментов
        //Формировать сначало в переменную затем присваивать ее в HTML форму
        var all_info = {!! $outfit  !!};
        var kultura = {!! $cultivation  !!};
        var id_filial = {!! $filial->id !!};

        selectFilial.onchange=function (){

            document.getElementById("textFIO").innerHTML = "";
            id_filial = this.value;
            if (id_filial != 0) {
                sowing_type.disabled = false;
                document.getElementById('sowing_type').value=0;
            } else {
                document.getElementById('sowing_type').value=0;
                sowing_type.disabled = true;
            }
        }
        sowing_type.onchange=function () {
            document.getElementById("textFIO").innerHTML = "";
            vidPosev = this.value;
            if (vidPosev != 0){
                toKultura = Object.entries(kultura[vidPosev]);
                toArray = Object.entries(all_info[id_filial] [vidPosev]);
                var flag = true;
                var toView = "<div class='container'> " +
                    "<div class='row text-center'>" +
                    "<div class='col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4' id='line_block'>ФИО</div>" +
                    "<div id='date_block'>Дата</div>" +
                    "<div id='kultura_block'>Культура</div>" +
                    "<div id='day_block'>Смена</div>"+
                    "<div id='ga_block'>Га</div>"+
                    "</div>";
                for (var i = 0; i < toArray.length; i++) {
                    flag = true;
                    toView += "<div>"
                    toView += "<div id='line_block'><label name=label_sowing_last_name_id_" + toArray[i] [0] + "'>" + toArray[i] [1] + "</label></div>";
                    toView += "<input type='hidden' name='sowing_last_name_id_" + toArray[i] [0] + "' value='" + toArray[i] [0] + "'>";
                    toView += "<div id='date_block'><input class='form-control' type='date' name='date_" + toArray[i] [0] + "' value='{!! date('Y-m-d'); !!}'></div>";
                    for (var k = 0; k < toKultura.length; k++) {
                        if (flag) {
                            var key_id = toKultura[k] [0];
                            var Select = '';
                            Select += "<option value=''></option>";
                            flag = false;
                        }
                        Select += "<option value='" + toKultura[k] [0] + "'>" + toKultura[k] [1] + "</option>";
                        if (k == toKultura.length - 1) {
                            toView += "<div id='kultura_block'><select class='form-control' name='cultivation_id_" + toArray[i] [0] + "' id=cultivation_id_" + toArray[i] [0] + ">" + Select + "</select></div>";
                        }
                    }
                    toView += "<div id='day_block'><select class='form-control' name='shoft_id_" + toArray[i] [0] + "' id=id_sutki_" + toArray[i] [0] + "><option value=''></option><option value='1'>День</option><option value='2'>Ночь</option></select></div>";
                    toView += "<div id='ga_block'><input class='form-control' type='number' step='0.01' name='volume_" + toArray[i] [0] + "'></div></br>";
                    toView += "</div>"
                    toView += "</div>"
                }
                textFIO.innerHTML = toView;
            } else {
                document.getElementById("forma").innerHTML = "";
            }
        }
    </script>
@endsection('script')


