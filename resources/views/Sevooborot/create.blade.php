@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <form enctype="multipart/form-data" action="{{ route('pole.sevooborot.store', ['pole' => $pole->id])}}" method="POST">
        @csrf
        <div  class="border-3 row pb-3 mb-3" id="test">
            <div class="col-3">
                <select name="kultura" id="selectFirst" class="form-select @error('kultura') is-invalid @enderror">
                    <option value="">Выберите культуру</option>
                    @foreach(\App\Models\Kultura::where('id', '1')->orwhere('id', '6')->get() as $value)
                        <option value="{{ $value->id }}"> {{ $value->name }} </option>
                    @endforeach
                </select>
                @error('kultura')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-3">
                <select name="nomenklature" id="selectSecond" class="form-select @error('nomenklature') is-invalid @enderror">
                    <option value="">Выберите номенклатуру</option>
                </select>
                @error('nomenklature')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-3">
                <select name="reproduktion" id="selectThird" class="form-select @error('reproduktion') is-invalid @enderror">
                    <option value="">Выберите репродукцию</option>
                </select>
                @error('reproduktion')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="row">
                <div class="col-2">
                    <label for="txtSquare">Введите площадь</label>
                    <input name="square" id="txtSquare" class="form-control @error('square') is-invalid @enderror">
                    @error('square')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="col-2">
                    <label for="txtYear">Год</label>
                    {{ Form::selectYear('year',
                                        \Illuminate\Support\Carbon::now()->addYear(-2)->format('Y'),
                                        \Illuminate\Support\Carbon::now()->addYear(+2)->format('Y'),
                                        \Illuminate\Support\Carbon::now()->format('Y'),
                                        ['class'=>"form-control", 'id'=>'txtYear']) }}
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                </div>
            </div>

        </div>

    </form>
    <a class="btn btn-info" href="/pole/{{$pole->id}}/sevooborot">Назад</a>

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
        selectFirst.onchange=function(){
            //Делаем не доступным для выбора зависимый select
            selectSecond.disabled = true;
            selectThird.disabled = true;
            //очищаем значение ведомого селекта
            selectSecond.innerHTML="<option value='0'>Выберите номенклатуру</option>";
            selectThird.innerHTML="<option value='0'>Выберите репродукцию</option>";
            // console.log(selectSecondValue);
            if (this.value != 0) {
                //По текущему значению select забераем массив с данными
                selectSecondValue = Object.entries(selectSecondObject[this.value]);

                if (this.value in selectThirdObject){
                    selectThirdValue = Object.entries(selectThirdObject[this.value]);
                    for(var i = 0; i < selectThirdValue.length; i++){
                        //Формируем поля выбора по массиву данных
                        selectThird.innerHTML+='<option value="'+selectThirdValue[i][0]+'">'+selectThirdValue[i][1]+'</option>';
                    }
                } else {
                    selectThird.innerHTML="<option value='0'>Н/Д</option>";
                }

                //Цикл по длинне массива с данными
                for(var i = 0; i < selectSecondValue.length; i++){
                    //Формируем поля выбора по массиву данных
                    selectSecond.innerHTML+='<option value="'+selectSecondValue[i][1]+'">'+selectSecondValue[i][0]+'</option>';
                }

                selectThird.disabled = false;
                selectSecond.disabled = false;
            } else {
                selectSecond.disabled = true;
            }



        }



    </script>
@endsection('script')
