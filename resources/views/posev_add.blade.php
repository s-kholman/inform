@extends('layouts.base')
@section('title', 'Внесение информации о посеве')

@section('info')
    <div>
        <p>
            Чтобы изменить ошибочно внесенный обьем, нужно заново ввнести теже данные с новым обьемом. Запись дублироваться не будет.
        </p>
        <p>
            Чтобы удалить запись, нужно заново внести данные с нулевым обьемом (0). Запись будет удалена
        </p>
    </div>
            <form action="{{ route('posev.add') }}" method="POST">
                @csrf
                <label for="selectFilial">Филиал</label>
                <select name="filial" id="selectFilial" class="form-select @error('filial') is-invalid @enderror">
                    <option value="0"></option>
                    @if (count($filials) > 0)
                        @foreach($filials as $filial)
                            @if($filial_id->filial_id == $filial->id)
                                <option selected value="{{ $filial->id }}"> {{ $filial->name }} </option>

                            @endif
                        @endforeach
                    @endif
                </select>
                @error('filial')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror


                <label for="selectVidposeva">Вид выполняемых работ</label>
                <select name="vidposeva" id="selectVidposeva" class="form-select @error('vidposeva') is-invalid @enderror">
                    <option value="0"></option>
                    @if (count($vidposevas) > 0)
                        @foreach($vidposevas as $vidposeva)
                            <option value="{{ $vidposeva->id }}"> {{ $vidposeva->name }} </option>
                        @endforeach
                    @endif
                </select>
                @error('vidposeva')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input type="submit" class="btn btn-primary" value="Сохранить">
                <div class="row" id="textFIO" style="width:100%; height:1px; clear:both;">
                </div>
            </form>

@endsection('info')
@section('script')
    <script>
        //Вывести отдельно в файл
        //Пресмотреть все названия элиментов
        //Формировать сначало в переменную затем присваивать ее в HTML форму
        var all_info = {!! $all_info  !!};
        var kultura = {!! $kultura  !!};
        var id_filial = {!! $filial_id->filial_id !!}

        selectFilial.onchange=function (){
            document.getElementById("textFIO").innerHTML = "";
            id_filial = this.value;
            if (id_filial != 0) {
                selectVidposeva.disabled = false;
                document.getElementById('selectVidposeva').value=0;
            } else {
                document.getElementById('selectVidposeva').value=0;
                selectVidposeva.disabled = true;
            }
        }
        selectVidposeva.onchange=function () {
            document.getElementById("textFIO").innerHTML = "";
            vidPosev = this.value;
            if (vidPosev != 0){
                toKultura = Object.entries(kultura[vidPosev]);
                toArray = Object.entries(all_info[id_filial] [vidPosev]);
                var flag = true;
                var toView = '';
                for (var i = 0; i < toArray.length; i++) {
                    flag = true;
                    toView += "<div>"
                    toView += "<div id='line_block'><label name=labelFio_" + toArray[i] [0] + "'>" + toArray[i] [1] + "</label></div>";
                    toView += "<input type='hidden' name='idFio_" + toArray[i] [0] + "' value='" + toArray[i] [0] + "'>";
                    toView += "<div id='date_block'><input class='form-control' type='date' name='dateId_" + toArray[i] [0] + "' value='{!! date('Y-m-d'); !!}'></div>";
                    for (var k = 0; k < toKultura.length; k++) {
                        if (flag) {
                            var key_id = toKultura[k] [0];
                            var Select = '';
                            Select += "<option value='default'></option>";
                            flag = false;
                        }
                        Select += "<option value='" + toKultura[k] [0] + "'>" + toKultura[k] [1] + "</option>";
                        if (k == toKultura.length - 1) {
                            toView += "<div id='kultura_block'><select class='form-control' name='kulturaId_" + toArray[i] [0] + "' id=id_kultura_" + toArray[i] [0] + ">" + Select + "</select></div>";
                        }
                    }
                    toView += "<div id='day_block'><select class='form-control' name='sutkiId_" + toArray[i] [0] + "' id=id_sutki_" + toArray[i] [0] + "><option value='default'></option><option value='1'>День</option><option value='2'>Ночь</option></select></div>";
                    toView += "<div id='ga_block'><input class='form-control' type='text' name='posevGa_" + toArray[i] [0] + "'></div></br>";
                    toView += "</div>"
                }
                textFIO.innerHTML = toView;
            } else {
                document.getElementById("forma").innerHTML = "";
            }
        }
    </script>
@endsection('script')


