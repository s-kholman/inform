<script>
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
