@extends('layouts.base')
@section('title', 'Прикопки')

@section('info')
    <div class="container">
        <div class="col-xl-6 col-lg-12 col-sm-12">
            <p>Если поля не найдены, необходимо внести в справочник <a href="/pole">"Поле"</a> - севооборот</p>
            <form action="{{ route('prikopki.store') }}" method="POST">
                @csrf
                <input name="filial_id" hidden value="{{$filial_id}}">
                <div class="row">
                    <div class="col-6">
                        <label for="selectFirst">Выберите поле</label>
                        <select name="pole" id="selectFirst" class="form-select @error('pole') is-invalid @enderror">
                            <option value=""></option>

                            @forelse($poles as $name => $pole)
                                {{--<option {{old('pole') == $pole[0]->pole_id ? "selected" : ""}} value="{{$pole[0]->pole_id}}">{{$name}}</option>--}}
                                <option value="{{ $pole[0]->pole_id }}"> {{ $name }} </option>
                            @empty
                                <option value=""> Поля не найдены</option>
                            @endforelse
                        </select>
                        @error('pole')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="selectSecond">Выберите культуру</label>
                        <select name="sevooborot" id="selectSecond" disabled
                                class="form-select @error('sevooborot') is-invalid @enderror">
                            <option value="">Культура</option>
                        </select>
                        @error('sevooborot')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <label for="txtDate">Дата</label>
                        <input name="date" id="txtDate" type="date" value="{{date('Y-m-d')}}"
                               class="form-control @error('date') is-invalid @enderror">
                        @error('date')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-6">

                        <label for="prikopki_squares">Площадь прикопки</label>
                        <select name="prikopki_squares" id="prikopki_squares" class="form-select @error('prikopki_squares') is-invalid @enderror">
                            <option value=""></option>

                            @forelse($prikopki_squares as $prikopki_square)
                                <option {{old('prikopki_squares') == $prikopki_square->id ? "selected" : ""}} value="{{$prikopki_square->id}}">{{$prikopki_square->name }}&sup2;</option>
                            @empty
                                <option value="">Заполните справочник</option>
                            @endforelse
                        </select>
                        @error('prikopki_squares')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <fieldset class="border p-2">
                    <legend class="float-none w-auto"><h6>Фракции</h6></legend>
                    <div class="row ms-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="production_type" id="check_product" value="1">
                            <label class="form-check-label" for="check_product">
                                Товарный
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="production_type" id="check_seeds" value="2">
                            <label class="form-check-label" for="check_seeds">
                                Семенной
                            </label>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-2 text-center">
                            <label for="fraction_1" id="label_fraction_1">-</label>
                            <input name="fraction_1"
                                   type="number"
                                   step="0.001"
                                   min="0"
                                   id="fraction_1"
                                   class="form-control @error('fraction_1') is-invalid @enderror js-p-input">
                            @error('fraction_1')
                            <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                            @enderror
                        </div>

                        <div class="col-2 text-center">
                            <label for="fraction_2" id="label_fraction_2">-</label>
                            <input name="fraction_2"
                                   type="number"
                                   step="0.001"
                                   min="0"
                                   id="fraction_2"
                                   class="form-control @error('fraction_2') is-invalid @enderror js-p-input">
                            @error('fraction_2')
                            <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                            @enderror
                        </div>

                        <div class="col-2 text-center">
                            <label for="fraction_3" id="label_fraction_3">-</label>
                            <input name="fraction_3"
                                   type="number"
                                   step="0.001"
                                   min="0"
                                   id="fraction_3"
                                   class="form-control @error('fraction_3') is-invalid @enderror js-p-input">
                            @error('fraction_3')
                            <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                            @enderror
                        </div>

                        <div class="col-2 text-center">
                            <label for="fraction_4" id="label_fraction_4">-</label>
                            <input name="fraction_4"
                                   type="number"
                                   step="0.001"
                                   min="0"
                                   id="fraction_4"
                                   class="form-control @error('fraction_4') is-invalid @enderror js-p-input">
                            @error('fraction_4')
                            <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                            @enderror
                        </div>

                        <div class="col-2 text-center">
                            <label for="fraction_5" id="label_fraction_5">-</label>
                            <input name="fraction_5"
                                   type="number"
                                   step="0.001"
                                   min="0"
                                   id="fraction_5"
                                   class="form-control @error('fraction_5') is-invalid @enderror js-p-input">
                            @error('fraction_5')
                            <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                            @enderror
                        </div>

                        <div class="col-2 text-center">
                            <label for="fraction_6" id="label_fraction_1">-</label>
                            <input name="fraction_6"
                                   type="number"
                                   step="0.001"
                                   min="0"
                                   id="fraction_6"
                                   class="form-control @error('fraction_6') is-invalid @enderror js-p-input"
                                   readonly
                            >
                            @error('fraction_6')
                            <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                            @enderror
                        </div>

                    </div>
                    <label for="volume">Общий вес</label>
                    <input readonly name="volume" id="volume"
                           value="{{old('volume')}}"
                           class="form-control @error('volume') is-invalid @enderror">
                    @error('volume')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </fieldset>


                <label for="txtcomment">Комментарий</label>
                <input name="comment" id="txtComment" class="form-control @error('comment') is-invalid @enderror">
                @error('comment')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="submit" class="btn btn-primary" value="Сохранить">

                <a class="btn btn-info" href="/prikopki">Назад</a>
            </form>
        </div>
    </div>
@endsection('info')
@section('script')
    <script>

        let selectSecondObject = {!! $sevooborot_arr  !!};
        let selectFirstCheck = 0;
        const label_fraction_1 = document.getElementById('label_fraction_1');
        const label_fraction_2 = document.getElementById('label_fraction_2');
        const label_fraction_3 = document.getElementById('label_fraction_3');
        const label_fraction_4 = document.getElementById('label_fraction_4');
        const label_fraction_5 = document.getElementById('label_fraction_5');
        const label_fraction_6 = document.getElementById('label_fraction_6');
        const check_product = document.getElementById('check_product');
        const check_seeds = document.getElementById('check_seeds');

        check_product.onchange = function (){
            label_fraction_1.textContent = "до 45";
            label_fraction_2.textContent = "45-50";
            label_fraction_3.textContent = "50-55";
            label_fraction_4.textContent = "55-80";
            label_fraction_5.textContent = "80+";
        }
        check_seeds.onchange = function (){
            label_fraction_1.textContent = "до 30";
            label_fraction_2.textContent = "30-40";
            label_fraction_3.textContent = "40-50";
            label_fraction_4.textContent = "50-60";
            label_fraction_5.textContent = "60+";
        }

        selectFirst.onchange = function () {
            //Делаем не доступным для выбора зависимый select
            selectSecond.disabled = true;
            //очищаем значение ведомого селекта
            selectSecond.innerHTML = "<option value='0'>Выберите культуру</option>";

            if (this.value != 0) {
                selectFirstCheck = this.value;
                //По текущему значению select забераем массив с данными
                selectSecondValue = Object.entries(selectSecondObject[this.value]);

                //Цикл по длинне массива с данными
                for (var i = 0; i < selectSecondValue.length; i++) {
                    //Формируем поля выбора по массиву данных
                    selectSecond.innerHTML += '<option value="' + selectSecondValue[i][0] + '">' + selectSecondValue[i][1] + '</option>';
                }
                selectSecond.disabled = false;
            } else {
                selectSecond.disabled = true;
            }
        }

        let priceInputs = document.querySelectorAll('.js-p-input');
        let arrNumbers = [];

        priceInputs.forEach((item, inx) => {

            //arrNumbers.push(item.value);//убрав, при вводе в 10й input получим [,,,,,,,,,1]
            item.addEventListener('input', function (e) {
                //this.value = this.value.replace(/\D/g, '');//лочим всё кроме цифр.
                arrNumbers[inx] = this.value;
                let sum1 = getSumInputs(arrNumbers);
                volume.value = parseFloat((sum1).toFixed(3));
                //console.log(sum1);
            });
        });


        function getSumInputs(arr) {//[,,,,,,,,,1] reduce совершит 1 итерацию
            return arr.reduce((prev, num) => {
                return (prev += +num)
            }, 0);
        }

        function sumArr(arr) {//[,,,,,,,,,1] совершит 10 итераций
            let x = 0;
            //for (let i = 0; i < arr.length; i++) {
            for (let i = 0; i < 6; i++) {
                x += +arr[i];
            }
            return x;
        }
    </script>
@endsection('script')


