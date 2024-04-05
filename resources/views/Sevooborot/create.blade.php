@extends('layouts.base')
@section('title', 'Справочник')

@section('info')


    <form enctype="multipart/form-data" action="{{ route('pole.sevooborot.store', ['pole' => $pole->id])}}"
          method="POST">
        @csrf
        <div class="border-3 row pb-3 mb-3" id="test">
            <div class="col-xl-3 col-sm-7">
                <div class="form-floating mb-3">
                    <select name="cultivation" id="selectFirst"
                            class="form-select @error('cultivation') is-invalid @enderror">
                        <option value=""></option>
                        @foreach(\App\Models\cultivation::where('id', '1')->orwhere('id', '6')->get() as $value)
                            <option value="{{ $value->id }}"> {{ $value->name }} </option>
                        @endforeach
                    </select>
                    @error('cultivation')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                    <label for="selectFirst">Выбор культуры</label>
                </div>
            </div>
        </div>

        <div class="border-3 row pb-3 mb-3">
            <div class="col-xl-3 col-sm-7">
                <div class="form-floating mb-3">
                    <select name="nomenklature" id="selectSecond"
                            class="form-select @error('nomenklature') is-invalid @enderror">
                        <option value=""></option>
                    </select>
                    @error('nomenklature')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                    <label for="selectSecond">Выбор номенклатуры</label>
                </div>
            </div>
        </div>

        <div class="border-3 row pb-3 mb-3">
            <div class="col-xl-3 col-sm-7">
                <div class="form-floating mb-3">
                    <select name="reproduktion" id="selectThird"
                            class="form-select @error('reproduktion') is-invalid @enderror">
                        <option value=""></option>
                    </select>
                    @error('reproduktion')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                    <label for="selectThird">Выбер репродукции</label>
                </div>
            </div>
        </div>

            <div class="border-3 row pb-3 mb-3">
                <div class="col-xl-2 col-sm-4">
                    <div class="form-floating mb-3">
                        <input type="number" name="square" id="txtSquare" class="form-control @error('square') is-invalid @enderror">
                        @error('square')
                        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                        @enderror
                        <label for="txtSquare">Площадь поля в Га</label>
                    </div>
                </div>




                <div class="col-xl-1 col-sm-3">
                    <div class="form-floating mb-3">
                        <select name="year" id="year"
                                class="form-select @error('year') is-invalid @enderror">
                            <option value=""></option>
                            @forelse($harvest_year as $year)
                                <option {{$harvest_year_selected_id == $year->id ? 'selected' : ''}} value="{{ $year->id }}"> {{ $year->name }} </option>
                            @empty
                            @endforelse
                        </select>
                        @error('year')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <label for="year">Год урожая</label>
                    </div>
                </div>
            </div>

        <div class="border-3 row pb-3 mb-3">
                    <div class="col-xl-2 col-sm-2 ">
                        <input type="submit" class="btn btn-primary" value="Сохранить">
                    </div>
            <div class="class=col-xl-2 col-sm-2">
                <a class="btn btn-info" href="/pole/{{$pole->id}}/sevooborot">Назад</a>
            </div>
                </div>


    </form>


@endsection('info')
@section('script')
    <script>
        //Вывести отдельно в файл
        //Пресмотреть все названия элиментов
        //Формировать сначало в переменную затем присваивать ее в HTML форму

        var selectSecondObject = {!! $nomen_arr  !!};
        var selectThirdObject = {!! $reprod_arr !!};
        //Делаем не доступным для выбора зависимый select
        selectSecond.disabled = true;
        selectThird.disabled = true;
        //Выполняется при выборе в select пункта id должен быть selectFirst
        selectFirst.onchange = function () {
            //Делаем не доступным для выбора зависимый select
            selectSecond.disabled = true;
            selectThird.disabled = true;
            //очищаем значение ведомого селекта
            selectSecond.innerHTML = "<option value='0'>Выберите номенклатуру</option>";
            selectThird.innerHTML = "<option value='0'>Выберите репродукцию</option>";
            // console.log(selectSecondValue);
            if (this.value != 0) {
                //По текущему значению select забераем массив с данными
                selectSecondValue = Object.entries(selectSecondObject[this.value]);

                if (this.value in selectThirdObject) {
                    selectThirdValue = Object.entries(selectThirdObject[this.value]);
                    for (var i = 0; i < selectThirdValue.length; i++) {
                        //Формируем поля выбора по массиву данных
                        selectThird.innerHTML += '<option value="' + selectThirdValue[i][0] + '">' + selectThirdValue[i][1] + '</option>';
                    }
                } else {
                    selectThird.innerHTML = "<option value='0'>Н/Д</option>";
                }

                //Цикл по длинне массива с данными
                for (var i = 0; i < selectSecondValue.length; i++) {
                    //Формируем поля выбора по массиву данных
                    selectSecond.innerHTML += '<option value="' + selectSecondValue[i][1] + '">' + selectSecondValue[i][0] + '</option>';
                }

                selectThird.disabled = false;
                selectSecond.disabled = false;
            } else {
                selectSecond.disabled = true;
            }


        }


    </script>
@endsection('script')
