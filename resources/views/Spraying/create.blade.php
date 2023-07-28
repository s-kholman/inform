@extends('layouts.base')
@section('title', 'Опрыскивание полей')

@section('info')

    <div class="col-3">
        <p>Если поля не найдены, необходимо внести в справочник <a href="/pole">"Поле"</a> - севооборот</p>
            <form action="{{ route('spraying.store') }}" method="POST">
                @csrf

                <label for="selectFirst">Выберите поле</label>
                <select name="pole" id="selectFirst" class="form-select @error('pole') is-invalid @enderror">
                    <option value=""></option>

                        @forelse(\App\Models\Sevooborot::Join('poles', 'poles.id', '=', 'sevooborots.pole_id')
                                                        ->select('poles.id','poles.name')
                                                        ->distinct('sevooborots.pole_id')
                                                        ->where('poles.filial_id', \App\Models\Registration::where('user_id', Auth::user()->id)
                                                        ->first()->filial_id)
                                                        ->get() as $pole)
                            <option value="{{ $pole->id }}"> {{ $pole->name }} </option>
                        @empty
                            <option value=""> Поля не найдены </option>
                        @endforelse
                </select>
                @error('pole')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <label for="selectSecond">Выберите культуру</label>
                <select name="kultura" id="selectSecond" class="form-select @error('kultura') is-invalid @enderror">
                    <option value="">Культура</option>
                </select>
                @error('kultura')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtDate">Дата</label>
                <input name="date" id="txtDate" type="date" value="{{date('Y-m-d')}}" class="form-control @error('date') is-invalid @enderror">
                @error('date')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtSZR">Выберите СЗР</label>
                <select name="szr" id="txtSZR" class="form-select @error('szr') is-invalid @enderror">
                    <option value=""></option>
                    @forelse (\App\Models\Szr::orderby('name')->get() as $value)
                        <option value="{{ $value->id }}"> {{ $value->name }} </option>
                    @empty
                        <option value="0"> Справочник пуст </option>
                    @endforelse
                </select>
                @error('szr')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror


                <label for="doza">Дозировка</label>
                <input type="number" step="0.001" disabled="true" name="doza" id="doza" class="form-control @error('txtdoza') is-invalid @enderror">
                @error('txtdoza')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="volume">Обьем</label>
                <input readonly name="volume" id="volume" class="form-control @error('volume') is-invalid @enderror">
                @error('volume')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtcomment">Коментарий</label>
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
@endsection('info')
@section('script')
<script>
    //Вывести отдельно в файл
    //Пресмотреть все названия элиментов
    //Формировать сначало в переменную затем присваивать ее в HTML форму

    var selectSecondObject = {!! $sevooborot_arr  !!};
    var squaretObject = {!! $squaret_arr  !!};
    var selectFirstCheck = 0;
    var squaretValue;

    //Делаем не доступным для выбора зависимый select
    selectSecond.disabled = true;
    //Выполняется при выборе в select пункта id должен быть selectFirst
    selectFirst.onchange=function(){
        //Делаем не доступным для выбора зависимый select
        selectSecond.disabled = true;
        doza.disabled = true;
        volume.value = '';
        doza.value = '';
        //очищаем значение ведомого селекта
        selectSecond.innerHTML="<option value='0'>Выберите культуру</option>";

        if (this.value != 0) {
            selectFirstCheck = this.value;
            //По текущему значению select забераем массив с данными
            selectSecondValue = Object.entries(selectSecondObject[this.value]);

            //Цикл по длинне массива с данными
            for(var i = 0; i < selectSecondValue.length; i++){
                //Формируем поля выбора по массиву данных
                selectSecond.innerHTML+='<option value="'+selectSecondValue[i][0]+'">'+selectSecondValue[i][1]+'</option>';
            }
            selectSecond.disabled = false;
        } else {
            selectSecond.disabled = true;
        }



    }

    selectSecond.onchange=function (){
        volume.value = '';
        doza.value = '';
        if (this.value != 0) {
            doza.disabled = false;
            squaretValue = squaretObject[selectFirstCheck] [this.value];
        } else {
            doza.disabled = true;
            volume.value = '';
            doza.value = '';
        }
    }

    doza.oninput = function (){
        if (doza.value.length > 0){
            volume.value=parseFloat((doza.value*squaretValue).toFixed(3));
        } else {
            volume.value = '';
        }

    }



</script>
@endsection('script')
