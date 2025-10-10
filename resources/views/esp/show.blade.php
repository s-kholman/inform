@extends('layouts.base')
@section('title', 'Настройка контроллера температуры')

@section('info')
    <div class="container gx-4">

        <div class="row mb-5">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Справочники
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="/esp/thermometer/create">Термометр</a></li>
                    <li><a class="dropdown-item" href="/esp/upload/bin">Прошивка</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
        <div class="col-xl-6 col-lg-6 col-sm-6 ">
    <form action="{{route('esp.settings.store')}}" method="post">
        @csrf

        <label for="deviceESP">Выберите устройство</label>
        <select name="deviceESP" id="deviceESP" class="form-select @error('deviceESP') is-invalid @enderror">
            <option value=""></option>
            @forelse($devices as $device)
                <option value="{{$device->id}}"> {{$device->storageName->name ?? ''}} {{$device->mac}}</option>
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

        <label for="activate_code">Код активации</label>
        <input placeholder="код активации"
               class="form-control @error('description') is-invalid @enderror"
               value="{{old('activate_code')}}"
               id="activate_code"
               name="activate_code"
               readonly
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

        <label for="device_operating_code">Режим работы устройства</label>
        <select name="device_operating_code" id="device_operating_code" class="form-select @error('device_operating_code') is-invalid @enderror" disabled>
            @forelse($device_operating_code as $device_operating)
                <option value="{{$device_operating->code}}"> {{$device_operating->name}} </option>
            @empty
                <option value="">Записи не найдены</option>
            @endforelse
        </select>
        @error('device_operating_code')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
        <div class="row">
            <div class="col-6">
                <label for="update_status">Статус обновления</label>
                <select name="update_status" id="update_status" class="form-select @error('update_status') is-invalid @enderror" disabled>
                </select>
                @error('update_status')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-6">
                <label for="updateBin">Версия</label>
                <select name="updateBin" id="updateBin" class="form-select @error('updateBin') is-invalid @enderror">
                    <option value=""></option>
                    @forelse($updateBin as $version)
                        <option disabled value="{{ $version->id }}"> {{$version->version}}  -  {{\Illuminate\Support\Carbon::parse($version->date)->format('d.m.Y')}} </option>
                    @empty
                    @endforelse
                </select>
                @error('updateBin')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>



        <div class="row">
            <div class="col-6">
                <label for="thermometers">Термометр</label>
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
                <label for="pointSelect">Точка измерения</label>
                <select name="pointSelect" id="pointSelect" class="form-select @error('pointSelect') is-invalid @enderror" disabled="true">
                    <option></option>
                </select>
                @error('pointSelect')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <label for="correction_ads">Корректировка ADS</label>
            <input placeholder="Поправочный коэффициент"
                   class="form-control @error('correction_ads') is-invalid @enderror"
                   value="{{old('correction_ads')}}"
                   id="correction_ads"
                   name="correction_ads"
            >

            @error('correction_ads')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        <div class="row">
            <div class="col-3 p-2 ">
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
        <div class="col-6">
            <div><b>Описание устройства</b></div>
            <div id="DeviceDescription" class="mb-4"></div>
            <div><b>Описание Прошивки</b></div>
            <pre><div id="updateDescription"></div></pre>
        </div>
        </div>
    </div>

@endsection('info')
@section('script')
    <script>
        const deviceInfo = {!! $devices !!};
        const updateBin = {!! $updateBin !!};
        const url = window.location.origin;
        const deviceESP = document.getElementById('deviceESP')
        const labelText = document.getElementById('labelText')
        const updateStatus = document.getElementById('update_status')
        const thermometers_view = document.getElementById('thermometers_view')
        const pointSelect = document.getElementById('pointSelect')
        const thermometersSelect = document.getElementById('thermometers')
        const deviceActivateSelect = document.getElementById('device_operating_code')
        const description = document.getElementById('description')
        const storageNameSelect = document.getElementById('storageName')
        const updateBinSelect = document.getElementById('updateBin')
        const correctionADS = document.getElementById('correction_ads')
        const deviceDescription = document.getElementById('DeviceDescription')
        const updateDescription = document.getElementById('updateDescription')
        const activate_code = document.getElementById('activate_code')
        let dataSettings = '';

        deviceInfoArray = Object.entries(deviceInfo);

        function changeUpdateStatusToUpdateBin(event)
        {
            if(event == '1'){
                for (let i = 0; i < updateBinSelect.length; i++) {
                    updateBinSelect.options[i].disabled = false;
                }
            } else {
                for (let i = 0; i < updateBinSelect.length; i++) {
                    updateBinSelect.options[i].disabled = true;
                }
                updateBinSelected(dataSettings['deviceUpdate'])
            }

        }

        updateStatus.addEventListener('change', (event) =>{
            changeUpdateStatusToUpdateBin(event.target.value)
        })

        updateBinSelect.addEventListener('change', (event) =>{
            let updateInfoArray = Object.entries(updateBin);
            for (let key in updateInfoArray) {
                if (updateInfoArray[key][1]['id'] == event.target.value){
                    updateDescription.innerHTML = updateInfoArray[key][1]['description']
                }
            }
        })

        storageNameSelect.addEventListener('change', (event) => {

            if (deviceESP.options[deviceESP.selectedIndex].value == ''){
                storageToDevice(event.target.value);
            }
        })

        document.body.addEventListener('dblclick', function(event) {
            if (event.target.classList.contains('thermometer')) {
                thermometerDeactivate(event.target.id)
                location.reload()
            }
        });

        activate_code.addEventListener('dblclick', function(event) {
            activate_code.readOnly = !activate_code.readOnly;
        });

        document.body.addEventListener('click', function(event) {
            if (event.target.classList.contains('thermometer')) {
                event.preventDefault()
                labelText.textContent = 'Двойной клик для отвязки от устройства'
            }
        });

        thermometersSelect.addEventListener('change', () =>{
            if(thermometersSelect.selectedIndex > 0){
                pointSelect.disabled = false
            } else {
                pointSelect.disabled = true
            }

        })

        deviceESP.addEventListener('change', () =>{
            deviceDescription.textContent = ''
            description.value = ''
            if(deviceESP.selectedIndex > 0){
                for (let key in deviceInfoArray) {
                    if (deviceInfoArray[key][1]['id'] == deviceESP.value){
                        let description = deviceInfoArray[key][1]['description'];
                        descriptionElement(description)
                        activate_code.value = deviceInfoArray[key][1]['activate_code']
                        deviceDescription.textContent = deviceInfoArray[key][1]['description']
                    }
                }
                thermometersSelect.disabled = false
            } else {
                storageNameSelect.value = 0;
                thermometersSelect.disabled = true
            }
            getSetting(deviceESP.options[deviceESP.selectedIndex].value);
        });

        async function storageToDevice(storage_id){
            let formData = new FormData
            formData.append('storage_id', storage_id)
            const response = await fetch(url + '/api/v1/esp/storage/device/get',
                {
                    method: 'POST',
                    headers:
                        {
                            "Accept": "application/json",
                        },
                    body: formData,
                })
            const data = await response.json()

            if (data['message'] != 'empty'){

                await getSetting(data['message']);
                thermometersSelect.disabled = false
            }
        }

        async function thermometerDeactivate(serial_number){
            let formData = new FormData
            formData.append('serial_number', serial_number)
            const response = await fetch(url + '/api/v1/esp/thermometer/deactivate',
                {
                    method: 'POST',
                    headers:
                        {
                            "Accept": "application/json",
                        },
                    body: formData,
                })
            const data = await response.json()
        }

        async function getSetting(id){
            clearButtonThermometer()
            clearForm()

            if(+id > 0){
                try {
                    let formData = new FormData
                    formData.append('id', id)
                    const response = await fetch(url + '/api/v1/esp/get/settings',
                        {
                            method: 'POST',
                            headers:
                                {
                                    "Accept": "application/json",
                                },
                            body: formData,
                        })
                    //const data = await response.json()
                    dataSettings = await response.json()
                    if (dataSettings['device_e_s_p_id'] == id) {
                        labelText.textContent = 'Ответ получен'
                        let device = dataSettings
                        for (let key in device) {
                            if(key == "device_thermometer"){
                                for(let thermometer in device[key]){
                                    for (let serial in device[key][thermometer]){

                                        if (serial == 'serial_number'){
                                            viewThermometer(device[key][thermometer][serial], device[key][thermometer][serial] + ' - (' + device[key][thermometer]['temperature_point']['name'] + ')')
                                        }
                                    }
                                }
                            }
                            if(key == "point"){
                                point(device, key)
                            }
                        }

                        updateStatusElement(dataSettings['update_status'])
                        //updateBinSelected(dataSettings['deviceUpdate'])
                        deviceActivateStatus(dataSettings['deviceActivation']['device_operating_code'])
                       // descriptionElement(dataSettings['deviceActivation']['description'])
                        storageSelected(dataSettings['deviceActivation']['storage_name_id'])
                        correctionADS.value = dataSettings['correction_ads']
                       // activate_code.value = dataSettings['activate_code']
                        deviceESP.value = id;


                    } else if(dataSettings['deviceActivation']['device_operating_code'] == 0){
                        deviceActivateStatus(dataSettings['deviceActivation']['device_operating_code'])
                        updateStatusElement(false)
                        point(dataSettings, 'point')

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

        function updateBinSelected(deviceUpdate) {

            //dataSettings['deviceUpdate']
            if(!deviceUpdate['message'] != ''){
                updateBinSelect.value = deviceUpdate['id']
                updateBinSelect.options[updateBinSelect.selectedIndex].disabled = false;

                updateDescription.innerHTML = deviceUpdate['description']
            } else{
                updateBinSelect.value = ''
            }
        }

            function clearForm() {

                updateDescription.textContent = ''
                updateBinSelect.value = ''
               // description.value = '';
                correctionADS.value = '';

                updateStatus.textContent = '';
                updateStatus.disabled = true

               // deviceActivateSelect.textContent = '';
               // deviceActivateSelect.disabled = true

                pointSelect.textContent = '';
                pointSelect.add(new Option('', ''));
                pointSelect.disabled = true

                thermometersSelect[0].selected = true
            }

            function deviceActivateStatus(status)
            {
                //deviceActivateSelect.textContent = '';
                deviceActivateSelect.disabled = false
                ///deviceActivateSelect.add(new Option("Нет", "0"));
                //deviceActivateSelect.add(new Option("Да", "1"));
                //deviceActivateSelect[+status].selected = true;
                deviceActivateSelect.value = status
            }

            function descriptionElement(text)
            {
                description.value = text;
            }

            function storageSelected(id)
            {
                storageNameSelect.value = id
            }

            function updateStatusElement(update_status)
            {
                updateStatus.textContent = '';
                updateStatus.disabled = false
                updateStatus.add(new Option("Не обновлять", "0"));
                updateStatus.add(new Option("Обновить", "1"));
                updateStatus[+update_status].selected = true;
                changeUpdateStatusToUpdateBin(updateStatus.value)
            }

            function clearButtonThermometer(){
                while (thermometers_view.firstChild) { thermometers_view.removeChild(thermometers_view.firstChild) }
            }

            function viewThermometer(serial, name){
                btn = document.createElement("Button");
                btn.setAttribute( 'class', 'btn btn-danger mt-2 thermometer' );
                btn.innerText = "Отвязать - "+name;
                btn.id = serial
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
