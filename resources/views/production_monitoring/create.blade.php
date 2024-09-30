@extends('layouts.base')

@section('title', 'Внести мониторинг хранения')

@section('info')
    <noscript>
        <style>
            .DIRECTOR{
                display: none;
            }
            .TEMPERATURE{
                display: none;
            }
            #save {
                display: none;
            }
        </style>
        <h3>У Вас отключен JS внесение данных не возможна</h3>
    </noscript>
    <div class="container" id="axios">
        <div class="col-xl-6 col-lg-12 col-sm-12">
            <form action="{{ route('monitoring.store') }}" method="POST">
                @csrf
                <label for="selectStorage">Выберите место хранения</label>
                <select name="storage" id="selectStorage" class="form-select @error('storage') is-invalid @enderror">
                    <option value=""></option>
                    @forelse(\App\Models\StorageName::where('filial_id', \App\Models\Registration::where('user_id', Auth::user()->id)->value('filial_id'))->get() as $storage)
                        <option
                        {{old('storage') == $storage->id ? "selected" : ""}} value="{{$storage->id}}">{{$storage->name}}</option>
                    @empty
                        <option value=""> Место хранения не найдены</option>
                    @endforelse
                </select>
                @error('storage')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                    <label for="txtDate">Дата</label>
                    <input name="date"
                           id="txtDate"
                           type="date"
                           value="{{old('date') == '' ? date('Y-m-d') : old('date')}}"
                           @if($post_name == 'TEMPERATURE')
                           max="{{date('Y-m-d')}}"
                           min="{{date('Y-m-d', strtotime(now() . '-1 day'))}}"
                           @endif
                           class="form-control @error('date') is-invalid @enderror">
                    @error('date')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror

                @if($access)
                <div class="form-switch form-check mb-3">
                    <label id="label-access-check" class="form-label" for="access">Переключить на температурщика</label>
                    <input class="form-check-input"
                           type="checkbox"
                           id="access"
                           name="access"
                           @if(old('access'))checked @endif>
                </div>
                @endif

                <fieldset style="border: 2px solid #4d1616; margin: 5px; padding: 10px" class="rounded-4 DIRECTOR">
                    <legend>Заполняет руководитель</legend>
                    <label for="storage_phase_id">Фаза хранения</label>
                    <select name="storage_phase_id" id="storage_phase_id" class="form-select @error('storage_phase_id') is-invalid @enderror">
                        <option value=""></option>
                        @forelse(\App\Models\StoragePhase::all() as $phase)
                            <option
                                {{old('storage_phase_id') == $phase->id ? "selected" : ""}} value="{{$phase->id}}">{{$phase->name}}</option>
                        @empty
                            <option value="">Фазы не найдены</option>
                        @endforelse
                    </select>
                    @error('storage_phase_id')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                    <div class="mb-3">
                        <label for="time">Режим работы вентиляции</label>
                        <div id="time" class="row">
                            <div class="col">
                                <input name="timeUp"
                                       type="time"
                                       value="{{old('timeUp')}}"
                                       class="form-control @error('time') is-invalid @enderror">
                            </div>
                            <div class="col">
                                <input name="timeDown"
                                       type="time"
                                       value="{{old('timeDown')}}"
                                       class="form-control @error('time') is-invalid @enderror">
                            </div>
                        </div>
                        @error('time')
                        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                        @enderror
                    </div>


                    <label for="temperature_keeping">Температура хранения</label>
                    <input type="number"
                           step="0.01"
                           name="temperature_keeping"
                           id="temperature_keeping"
                           value="{{old('temperature_keeping')}}"
                           class="form-control @error('temperature_keeping') is-invalid @enderror">
                    @error('temperature_keeping')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror

                    <label for="humidity_keeping">Влажность хранения</label>
                    <input type="number"
                           step="1"
                           name="humidity_keeping"
                           id="humidity_keeping"
                           value="{{old('humidity_keeping')}}"
                           class="form-control @error('humidity_keeping') is-invalid @enderror">
                    @error('humidity_keeping')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </fieldset>




                <fieldset id="temperature" style="border: 2px solid #82f568; margin: 5px; padding: 10px" class="rounded-4 TEMPERATURE">
                    <legend>Заполняет температурщик</legend>

                <label for="tuberTemperatureMorning">Температура клубня</label>
                <input type="number"
                       step="0.01"
                       name="tuberTemperatureMorning"
                       id="tuberTemperatureMorning"
                       value="{{old('tuberTemperatureMorning')}}"
                       class="form-control @error('tuberTemperatureMorning') is-invalid @enderror">
                @error('tuberTemperatureMorning')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="humidity">Влажность</label>
                <input type="number"
                       name="humidity"
                       id="humidity"
                       value="{{old('humidity')}}"
                       class="form-control @error('humidity') is-invalid @enderror">
                @error('humidity')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror



                <div class="form-switch form-check mb-3">
                    <label class="form-label" for="condensate">Наличие конденсата в боксе</label>
                    <input class="form-check-input" type="checkbox" id="condensate" name="condensate" @if(old('condensate'))checked @endif>>
                </div>


                <div class="mb-3">
                    <label for="comment">Комментарий</label>
                    <input name="comment"
                           id="comment"
                           value="{{old('comment')}}"
                           class="form-control @error('comment') is-invalid @enderror">
                    @error('comment')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
                </fieldset>



                <input id="save" type="submit" class="btn btn-primary" value="Сохранить">

                <a class="btn btn-info" href="/monitoring">Назад</a>
            </form>
        </div>
    </div>
@endsection('info')
@section('script')
<script>
    let post_arr = ['DIRECTOR', 'DEPUTY', 'TEMPERATURE'];
    let post_name = {!! json_encode($post_name) !!};
    let access = {!! $access !!};
    let url = {!! $url !!};

    for (let i = 0; i <= post_arr.length-1; i++) {
       if (post_name != post_arr[i]) {
           //document.querySelectorAll('.'+post_arr[i]).forEach(element => element.remove());
           document.querySelectorAll('.'+post_arr[i]).forEach(element => element.style.display = 'none');
           document.querySelectorAll('.'+post_arr[i]).forEach(element => element.disabled = true);
       }
   }
    if(post_name == 'Default') {
        document.getElementById('save').remove();
    }

    const check = document.getElementById('access');
    const label = document.getElementById('label-access-check')
    const tempDom = document.getElementsByClassName('TEMPERATURE')
    const directorDom = document.getElementsByClassName('DIRECTOR')

   if(access) {
       //tempDom[0].disabled = true
       checkedCheck()

       check.addEventListener('click', () => {
           checkedCheck()
           getProductMonitoring(selectStorageE.value, txtDate.value);
       })

   }

   function checkedCheck()
   {
       if(check.checked){
           tempDom[0].style.display = null
           tempDom[0].disabled = false
           label.textContent = 'Переключить на директора';
           directorDom[0].style.display = 'none'
           directorDom[0].disabled = true;
       } else {
           label.textContent = 'Переключить на температурщика';
           tempDom[0].disabled = true
           tempDom[0].style.display = 'none'
           directorDom[0].style.display = null
           directorDom[0].disabled = false
       }

   }

   const selectStorageE = document.getElementById('selectStorage');
   const txtDate = document.getElementById('txtDate');
   const tuberTemperatureMorning = document.getElementById('tuberTemperatureMorning');
   const humidity = document.getElementById('humidity');
   const condensate = document.getElementById('condensate');
   const comment = document.getElementById('comment');
   const temperature = document.getElementById('temperature');
   selectStorageE.addEventListener('change', () => {
       getProductMonitoring(selectStorageE.value, txtDate.value)
   })

   function getProductMonitoring(id, date) {


       //if(id !=0 && date != '' && tuberTemperatureMorning !== null) {
       if(id !=0 && date != '' && !temperature.disabled) {
           fetch(url+'/api/v1/'+id+'/'+date).then(response => {
               if(!response.ok) {
                   console.log('Error')
               }
               response.json().then((data) => {
                   if (data['data'].length !== 0){
                       tuberTemperatureMorning.value = data['data']['tuberTemperatureMorning'];
                       humidity.value = data['data']['humidity'];
                       condensate.checked = data['data']['condensate'];
                       comment.value = data['data']['comment'];
                   } else {
                       tuberTemperatureMorning.value = ''
                       humidity.value = ''
                       condensate.checked = false
                       comment.value = ''
                   }
               });
           })}
       }

    txtDate.addEventListener('change', () => {
        getProductMonitoring(selectStorageE.value, txtDate.value)
    })


</script>
@endsection('script')
