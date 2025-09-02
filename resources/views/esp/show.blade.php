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
        <div class="col-xl-6 col-lg-6 col-sm-6 ">
    <form action="{{route('esp.settings.store')}}" method="post">
        @csrf

        <label for="deviceESP">Выберите устройство</label>
        <select name="deviceESP" id="deviceESP" class="form-select @error('deviceESP') is-invalid @enderror">
            <option value=""></option>
            @forelse($devices as $device)
                <option value="{{$device->id}}"> {{$device->mac}} @if(!empty($device->description)) - {{$device->description}}@endif</option>
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
                <select name="updateBin" id="updateBin" class="form-select @error('updateBin') is-invalid @enderror" disabled>
                    <option value=""></option>
                    @forelse($updateBin as $version)
                        <option value="{{ $version->id }}"> {{$version->version}}  -  {{\Illuminate\Support\Carbon::parse($version->date)->format('d.m.Y')}} </option>
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

        //const button2 = document.querySelector('.thermometer');

        function changeUpdateStatusToUpdateBin(event)
        {
            if(event == '1'){
                updateBinSelect.disabled = false
            } else {
                updateBinSelect.disabled = true
            }

        }

        updateStatus.addEventListener('change', (event) =>{
            changeUpdateStatusToUpdateBin(event.target.value)
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
            if(deviceESP.selectedIndex > 0){
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
                    const data = await response.json()
                   // console.log(data)
                    if (data['device_e_s_p_id'] == id) {
                        labelText.textContent = 'Ответ получен'
                        let device = data
                        for (let key in device) {
                           // console.log(device)
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

                        updateBinSelected(data['deviceUpdate'])
                        updateStatusElement(data['update_status'])
                        deviceActivateStatus(data['deviceActivation']['device_operating_code'])
                        descriptionElement(data['deviceActivation']['description'])
                        storageSelected(data['deviceActivation']['storage_name_id'])
                        correctionADS.value = data['correction_ads']
                        deviceESP.value = id;


                    } else if(data['deviceActivation']['device_operating_code'] == 0){
                        deviceActivateStatus(data['deviceActivation']['device_operating_code'])
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

        function updateBinSelected(deviceUpdate) {

            if(!deviceUpdate['message'] != ''){
                updateBinSelect.value = deviceUpdate['id']
                //console.log(deviceUpdate['id'])
            }
        }

            function clearForm() {
                updateBinSelect.value = ''
                description.value = '';

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
                console.log(status);
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
