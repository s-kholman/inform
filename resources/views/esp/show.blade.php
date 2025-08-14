@extends('layouts.base')
@section('title', 'Настройка контроллера температуры')

@section('info')
    <div class="container gx-4">
        <div class="col-xl-6 col-lg-6 col-sm-6">
    <form action="{{route('esp.settings.store')}}" method="post">
        @csrf

        <label for="deviceESP">Выберите устройство</label>
        <select name="deviceESP" id="deviceESP" class="form-select @error('deviceESP') is-invalid @enderror">
            <option value=""></option>
            @forelse($devices as $device)
                <option value="{{$device->id}}"> {{$device->mac}} </option>
            @empty
                <option value="">Записи не найдены</option>
            @endforelse
        </select>
        @error('deviceESP')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="description">Описание устройства</label>
        <input placeholder="Описание устройства"
               class="form-control @error('description') is-invalid @enderror"
               value="{{old('description')}}"
               id="description"
               name="description"
        >
        @error('description')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="storageName">Выберите место установки</label>
        <select name="storageName" id="storageName" class="form-select @error('storageName') is-invalid @enderror">
            <option value=""></option>
            @forelse($storageNames as $storageName)
                <option value="{{ $storageName->id }}"> {{ $storageName->name}} </option>
            @empty
            @endforelse
        </select>
        @error('storageName')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="deviceActivate">Активировать устройство</label>
        <select name="deviceActivate" id="deviceActivate" class="form-select @error('deviceActivate') is-invalid @enderror" disabled>
        </select>
        @error('deviceActivate')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="update_status">Статус обновления</label>
        <select name="update_status" id="update_status" class="form-select @error('update_status') is-invalid @enderror" disabled>
           {{--<option value="0">Не обновлять</option>--}}
            {{-- <option value="0">Обновить</option>--}}
        </select>
        @error('update_status')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <label for="update_url">URL обновления</label>
        <input placeholder="URL обновления"
               class="form-control @error('update_url') is-invalid @enderror"
               value="https://develop.krimm.ru/storage/esp/update/temperature_v1.ino.bin"
               id="update_url"
               name="update_url"
        >
        @error('update_url')
        <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
        @enderror
        <div class="row">
            <div class="col-6">
                <label for="thermometers">Выберите термометр</label>
                <select name="thermometers" id="thermometers" class="form-select @error('thermometers') is-invalid @enderror" disabled="true">
                    <option value=""></option>
                    @forelse($thermometers as $thermometer)
                        <option value="{{ $thermometer->serial_number }}"> {{ $thermometer->serial_number}} </option>
                    @empty

                    @endforelse
                </select>
                @error('thermometers')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-6">
                <label for="pointSelect">Выберите точку измерения</label>
                <select name="pointSelect" id="pointSelect" class="form-select @error('pointSelect') is-invalid @enderror" disabled="true">
                    <option></option>
                </select>
                @error('pointSelect')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 col-xxl-2 p-2 ">
                <a class="btn btn-primary" href="/esp/settings">Назад</a>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 col-xxl-2 p-2 text-end">
                <input class="btn btn-primary" type="submit" value="Сохранить" name="save">
            </div>
        </div>
        <div class="row" id="thermometers_view">

        </div>
        <label id="labelText"></label>
    </form>

        </div>
    </div>
@endsection('info')
@section('script')
    <script>
        const deviceESP = document.getElementById('deviceESP')
        const labelText = document.getElementById('labelText')
        const updateStatus = document.getElementById('update_status')
        const thermometers_view = document.getElementById('thermometers_view')
        const pointSelect = document.getElementById('pointSelect')
        const thermometersSelect = document.getElementById('thermometers')
        const deviceActivateSelect = document.getElementById('deviceActivate')
        const description = document.getElementById('description')
        const storageNameSelect = document.getElementById('storageName')
        const button2 = document.querySelector('.thermometer');


        document.body.addEventListener('dblclick', function(event) {
            if (event.target.classList.contains('thermometer')) {
                //event.preventDefault()
                thermometerDeactivate(event.target.id)
                location.reload()
                //console.log('Нажатие на динамический элемент:', event.target.id);
            }
        });

        document.body.addEventListener('click', function(event) {
            if (event.target.classList.contains('thermometer')) {
                event.preventDefault()
                labelText.textContent = 'Двойной клик для отвязки от устройства'
                //thermometerDeactivate(event.target.id)
                //console.log('Нажатие на динамический элемент:', event.target.id);
            }
        });

        thermometersSelect.addEventListener('change', () =>{
           // console.log(thermometersSelect.selectedIndex)
            if(thermometersSelect.selectedIndex > 0){
                pointSelect.disabled = false
            } else {
                pointSelect.disabled = true
            }

        })

        deviceESP.addEventListener('change', () =>{
            if(deviceESP.selectedIndex > 0){
                thermometersSelect.disabled = false
            } else {
                thermometersSelect.disabled = true
            }
            getSetting(deviceESP.options[deviceESP.selectedIndex].value);
        });

        async function thermometerDeactivate(serial_number){
            let formData = new FormData
            formData.append('serial_number', serial_number)
            const response = await fetch('https://develop.krimm.ru' + '/api/v1/esp/thermometer/deactivate',
                {
                    method: 'POST',
                    headers:
                        {
                            "Accept": "application/json",
                        },
                    body: formData,
                })
            const data = await response.json()
/*            console.log(data['message'])
            if(data['message'] == 'Ok'){
                console.log('Деактивирован = ' + serial_number)
            } else {
                console.log('Не деактивирован ' + serial_number)
            }*/
        }

        async function getSetting(id){
            clearButtonThermometer()
            clearForm()
            if(+id > 0){
                try {
                    let formData = new FormData
                    formData.append('id', id)
                    const response = await fetch('https://develop.krimm.ru' + '/api/v1/esp/get/settings',
                        {
                            method: 'POST',
                            headers:
                                {
                                    "Accept": "application/json",
                                },
                            body: formData,
                        })
                    const data = await response.json()
                    if (data['device_e_s_p_id'] == id) {
                        labelText.textContent = 'Ответ получен'
                        let device = data
                        //console.log(data['deviceActivation']['status'])
                        for (let key in device) {
                            //console.log(key + ": " + device[key]);
                            if(key == "device_thermometer"){
                                for(let thermometer in device[key]){
                                    //console.log(device[key]);
                                    for (let serial in device[key][thermometer]){
                                        if (serial == 'serial_number'){
                                            viewThermometer(device[key][thermometer][serial])
                                        }
                                    }
                                }
                            }
                            if(key == "point"){
                                point(device, key)
                            }
                        }
                        updateStatusElement(data['update_status'])
                        deviceActivateStatus(data['deviceActivation']['status'])
                        descriptionElement(data['deviceActivation']['description'])
                        storageSelected(data['deviceActivation']['storage_name_id'])

                        // console.log(data.data[0])
                    } else if(data['deviceActivation']['status'] == false){
                        deviceActivateStatus(false)
                        updateStatusElement(false)
                        point(data, 'point')

                    }
                    else {
                        labelText.textContent = 'Ошибка в ответе с сервера'
                        clearForm()
                        clearButtonThermometer();
                    }

                } catch (error) {

                    labelText.textContent = 'Ошибка сервера'
                }
            }

        }
            function clearForm() {
                description.value = '';

                updateStatus.textContent = '';
                updateStatus.disabled = true

                deviceActivateSelect.textContent = '';
                deviceActivateSelect.disabled = true

                pointSelect.textContent = '';
                pointSelect.add(new Option('', ''));
                pointSelect.disabled = true

                thermometersSelect[0].selected = true
            }

            function deviceActivateStatus(status)
            {
                deviceActivateSelect.textContent = '';
                deviceActivateSelect.disabled = false
                deviceActivateSelect.add(new Option("Нет", "0"));
                deviceActivateSelect.add(new Option("Да", "1"));
                deviceActivateSelect[+status].selected = true;
            }

            function descriptionElement(text)
            {
                description.value = text;
            }

            function storageSelected(id)
            {
                storageNameSelect[+id].selected = true;
            }

            function updateStatusElement(update_status)
            {
                updateStatus.textContent = '';
                updateStatus.disabled = false
                updateStatus.add(new Option("Не обновлять", "0"));
                updateStatus.add(new Option("Обновить", "1"));
                updateStatus[+update_status].selected = true;
            }

            function clearButtonThermometer(){
                while (thermometers_view.firstChild) { thermometers_view.removeChild(thermometers_view.firstChild) }
            }

            function viewThermometer(name){
                btn = document.createElement("Button");
                btn.setAttribute( 'class', 'btn btn-danger mt-2 thermometer' );
                btn.innerText = "Отвязать - "+name;
                btn.id = name
                thermometers_view.appendChild(btn)
            }

            function point(device, key) {
                for (let pointK in device[key]) {
                    for (let pointName in device[key][pointK]) {
                        if (pointName == 'name') {
                            pointSelect.add(new Option(device[key][pointK][pointName], device[key][pointK]['id']));
                        }
                    }
                }
            }

    </script>
@endsection('script')
