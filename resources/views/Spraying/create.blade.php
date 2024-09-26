@extends('layouts.base')
@section('title', 'Опрыскивание полей')

@section('info')
    <div class="container">
        <div class="col-xl-6 col-lg-12 col-sm-12">
            <p>Если поля не найдены, необходимо внести в справочник <a href="/pole">"Поле"</a> - севооборот</p>
            <form action="{{ route('spraying.store') }}" method="POST">
                @csrf

                <input name="today" type="date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" hidden>

                <label for="selectFirst">Выберите поле</label>
                <select name="pole" id="selectFirst" class="form-select @error('pole') is-invalid @enderror">
                    <option value=""></option>

                    @forelse($poles as $name => $pole)
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

                <label for="selectSecond">Выберите культуру</label>
                <select name="kultura" id="selectSecond" class="form-select @error('kultura') is-invalid @enderror">
                    <option value="0">Культура</option>
                </select>
                @error('kultura')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtDate">Дата</label>
                <input name="date" id="txtDate" type="date" value="{{old('date') ? old('date') : date('Y-m-d')}}"
                       class="form-control @error('date') is-invalid @enderror">
                @error('date')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror


                <div class="row">
                    <div class=" col-6">
                        <label for="txtSzrClasses">Выберите тип СЗР</label>
                        <select name="szrClasses" id="szrClasses"
                                class="form-select @error('szrClasses') is-invalid @enderror">
                            <option value=""></option>
                            @forelse(\App\Models\SzrClasses::orderby('name')->get() as $value)
                                <option value="{{ $value->id }}"> {{ $value->name }} </option>
                            @empty
                                <option value="0"> Справочник пуст</option>
                            @endforelse
                        </select>
                        @error('szrClasses')
                        <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class=" col-6">
                        <label for="selectSzr">Выберите СЗР</label>
                        <select name="szr" id="selectSzr" class="form-select @error('szr') is-invalid @enderror">

                        </select>
                        @error('szr')
                        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                        @enderror
                    </div>
                </div>
                <label for="dosage">Дозировка</label>
                <input type="number" step="0.001" disabled="true" name="dosage" id="dosage"
                       class="form-control @error('txtdosage') is-invalid @enderror">
                @error('txtdosage')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="volume">Объем</label>
                <input readonly name="volume" id="volume" class="form-control @error('volume') is-invalid @enderror">
                @error('volume')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtcomment">Комментарий</label>
                <input name="comment" id="txtComment" class="form-control @error('comment') is-invalid @enderror">
                @error('comment')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="submit" class="btn btn-primary" value="Сохранить">

                <a class="btn btn-info" href="/spraying">Назад</a>
            </form>
        </div>
    </div>
@endsection('info')
@section('script')
    <script>
        /*
        * Функция сортировки многомерного массива
        * Для отображения в зависимом select в алфавитном порядке
        */
        function compareSecondColumn(a, b) {
            if (a[1] === b[1]) {
                return 0;
            } else {
                return (a[1] < b[1]) ? -1 : 1;
            }
        }

        //Вывести отдельно в файл
        //Пересмотреть все названия элементов
        //Формировать сначала в переменную затем присваивать ее в HTML форму

        let selectSzrObject = {!! $szr_arr  !!};
        let selectSecondObject = {!! $sevooborot_arr  !!};
        let squareObject = {!! $squaret_arr  !!};
        let selectFirstCheck = 0;
        let squareValue;

        //Делаем не доступным для выбора зависимый select
        let selectSzr = document.getElementById('selectSzr');
        selectSzr.disabled = true;
        let selectSecond = document.getElementById('selectSecond');
        selectSecond.disabled = true;

        let szrClasses = document.getElementById('szrClasses');

        function selectNomenclatureSZR (evt) {
            selectSzr.disabled = true;
            if (evt.value != 0) {
                selectSzr.innerHTML = "<option value='0'>Выберите СЗР</option>";
                //По текущему значению select забираем массив с данными
                try {
                    let selectSZRValue = Object.entries(selectSzrObject[this.value]);

                    selectSZRValue.sort(compareSecondColumn);

                    selectSzr.disabled = false;

                    for (let i = 0; i < selectSZRValue.length; i++) {
                        //Формируем поля выбора по массиву данных
                        selectSzr.add(createElementOption(selectSZRValue[i][0], selectSZRValue[i][1]))
                    }
                } catch (e){
                    selectSzr.disabled = true;
                    selectSzr.innerHTML = "<option value='0'>СЗР не найдено</option>";
                }
            } else {
                selectSzr.disabled = true;
                selectSzr.innerHTML = "<option value='0'></option>";
            }
        }

        let selectFirst = document.getElementById('selectFirst');
        let dosage = document.getElementById('dosage')
        let volume = document.getElementById('volume')

        function selectReproductionName (){
            selectSecond.disabled = true;
            dosage.disabled = true;
            volume.value = '';
            dosage.value = '';
            selectSecond.innerHTML = "<option value='0'>Выберите культуру</option>";

            if (this.value != 0) {
                selectFirstCheck = this.value;
                //По текущему значению select забираем массив с данными
                let selectSecondValue = Object.entries(selectSecondObject[this.value]);

                for (let i = 0; i < selectSecondValue.length; i++) {
                    selectSecond.add(createElementOption(selectSecondValue[i][0], selectSecondValue[i][1]));
                }

                selectSecond.disabled = false;
            } else {
                selectSecond.disabled = true;
            }
        }

        function createElementOption(id, text) {
            let option = document.createElement('option');
            option.value = id;
            option.textContent = text;
            return option;
        }

        function dosageEnable() {
            volume.value = '';
            dosage.value = '';
            if (this.value != 0) {
                dosage.disabled = false;
                squareValue = squareObject[selectFirstCheck] [this.value];
            } else {
                dosage.disabled = true;
            }
        }

        function dosageSum() {
            if (dosage.value.length > 0) {
               volume.value = parseFloat((dosage.value * squareValue).toFixed(3));
            } else {
               volume.value = '';
            }
        }

        szrClasses.addEventListener('change', selectNomenclatureSZR);
        selectSecond.addEventListener('change', dosageEnable);
        selectFirst.addEventListener('change', selectReproductionName);
        dosage.addEventListener('input', dosageSum);
    </script>
@endsection('script')
