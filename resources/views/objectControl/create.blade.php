@extends('layouts.base')
@section('title', 'Контроль объектов')
{{--<style>
    select[name^="selectImportances_"] option[value="1"] {
        background-color: #4a9600;
    }

    select[name^="selectImportances_"] option[value="2"] {
        background-color: #ffe125;
    }

    select[name^="selectImportances_"] option[value="3"] {
        background-color: #ff6605;
    }

    select[name^="selectImportances_"] option[value="4"] {
        background-color: red;
    }
</style>--}}
@section('info')
    <form action="{{route('object.control.index')}}" method="GET">
        <div class="row justify-content-center text-center">
            @csrf
            <div class=" justify-content-end row p-4">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-2 col-xxl-2">
                    <input class="btn btn-outline-primary" type="submit" value="Перейти в отчет">
                </div>
            </div>
        </div>
    </form>
    <form action="{{ route('object.control.store')}}" method="POST">
        @csrf
        <div class="row text-center">

            <div>
                <input hidden id="pole_id" name="pole_id">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 col-xxl-4 p-2">
                    <label for="date">Дата</label>
                    <input name="date" id="date" type="date"
                           value="{{old('sowing_date') == "" ? date('Y-m-d') : old('sowing_date') }}"
                           class="form-control @error('date') is-invalid @enderror">
                    @error('date')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 col-xxl-4 p-2">
                    <label for="selectFilial">Выберите филиал контроля</label>
                    <select name="filial" id="selectFilial"
                            class="form-select @error('filial') is-invalid @enderror">

                        <option value="0"></option>

                        @forelse($filialObjectControl as $id => $filials)
                            @forelse($filials as $type_id => $type )
                                <option value="{{ $id}}"> {{ $type[0]->FilialName->name }} </option>
                                @break
                            @empty
                            @endforelse
                        @empty
                            <option value=""> Заполните справочник</option>
                        @endforelse
                    </select>
                    @error('filial')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 col-xxl-4 p-2">
                    <label for="selectObjectType">Выберите тип контроля</label>
                    <select name="objectType" id="selectObjectType" disabled
                            class="form-select @error('objectType') is-invalid @enderror">
                        <option value="0"></option>
                    </select>
                    @error('objectType')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 col-xxl-4 p-2">
                    <label for="selectObject">Выберите объект контроля</label>
                    <select name="objectName" id="selectObject" disabled
                            class="form-select @error('objectName') is-invalid @enderror">
                        <option value="0"></option>
                    </select>
                    @error('objectName')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>
        </div>

        <div id="controlPoint">

        </div>

        <div class="col-2">
            <input type="submit" class="btn btn-primary" value="Сохранить">
        </div>
    </form>

@endsection('info')

@section('script')
    <script>

        let filialObjectControl = {!! $filialObjectControl  !!};
        let objectControlPoint = {!! $objectControlPoint  !!};
        let objectControlImportances = {!! $objectControlImportances  !!};
        const selectFilial = document.getElementById('selectFilial')
        const selectObjectType = document.getElementById('selectObjectType')
        const selectObject = document.getElementById('selectObject')
        const controlPoint = document.getElementById('controlPoint')
        let pole_id = document.getElementById('pole_id')
        let select
        controlPoint.innerHTML = '';
        selectFilial.addEventListener('change', () => {
            controlPoint.innerHTML = '';
            if (selectFilial.value > 0) {
                selectObject.disabled = true
                selectObject.textContent = ''
                selectObjectType.disabled = false
                selectObjectType.textContent = ''
                selectObjectType.add(new Option('', ''))

                for (let key in filialObjectControl[selectFilial.value]) {
                    selectObjectType.add(new Option(filialObjectControl[selectFilial.value][key][0]['object_type']['name'], filialObjectControl[selectFilial.value][key][0]['object_type']['id']));
                }
            } else {
                controlPoint.innerHTML = '';
                selectObjectType.disabled = true
                selectObject.disabled = true
            }
        })

        selectObjectType.addEventListener('change', () => {
            controlPoint.innerHTML = '';
            if (selectObjectType.value > 0) {
                selectObject.disabled = false
                selectObject.textContent = '';
                selectObject.add(new Option('', ''))
                let poleName = '';
                for (let key in filialObjectControl[selectFilial.value]) {
                    for (let keyFirst in filialObjectControl[selectFilial.value][key]) {

                        if (filialObjectControl[selectFilial.value][key][keyFirst]['object_type_id'] == selectObjectType.value && filialObjectControl[selectFilial.value][key][keyFirst]['filial_id'] == selectFilial.value) {

                            if (filialObjectControl[selectFilial.value][key][keyFirst]['pole_name'] != null) {
                                poleName = " - (" + filialObjectControl[selectFilial.value][key][keyFirst]['pole_name']['name'] + ")"
                            } else {
                                poleName = ''
                            }

                            selectObject.add(new Option(filialObjectControl[selectFilial.value][key][keyFirst]['name'] + poleName, filialObjectControl[selectFilial.value][key][keyFirst]['id']));
                        }
                    }
                }
            } else {
                selectObject.disabled = true
            }
        })

        selectObject.addEventListener('change', () => {

            controlPoint.innerHTML = '';

            if (selectObject.value > 0) {

                for (let key in filialObjectControl[selectFilial.value]) {

                    for (let keyFirst in filialObjectControl[selectFilial.value][key]) {

                        if (filialObjectControl[selectFilial.value][key][keyFirst]['object_type_id'] == selectObjectType.value && filialObjectControl[selectFilial.value][key][keyFirst]['id'] == selectObject.value) {
                            pole_id.value = filialObjectControl[selectFilial.value][key][keyFirst]['pole_id']
                            for (let point in objectControlPoint[filialObjectControl[selectFilial.value][key][keyFirst]['object_type_id']]) {

                                let checkPoint = objectControlPoint[filialObjectControl[selectFilial.value][key][keyFirst]['object_type_id']][point]['id']

                                controlPoint.innerHTML += "<div class='col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 col-xxl-4 mt-2 border border-1' id='div_" + checkPoint + "'></div>"

                                let divPoint = document.getElementById('div_' + checkPoint)

                                divPoint.innerHTML +=
                                    "<input hidden type='text' name='objectControlPoint_" + checkPoint + "' value='" + objectControlPoint[filialObjectControl[selectFilial.value][key][keyFirst]['object_type_id']][point]['id'] + "'>" +
                                    "<label class='mb-2 fw-bold' for='textPoint_" + checkPoint + "'>" + objectControlPoint[filialObjectControl[selectFilial.value][key][keyFirst]['object_type_id']][point]['name'] + "</label>" +
                                    "<div class='form-switch form-check mb-3' id='textPoint_" + checkPoint + "'>" +
                                    "<label id='label-access-check' class='form-label' for='verified_" + checkPoint + "'>Проверенно</label>" +
                                    "<input class='form-check-input'" +
                                    "type='checkbox'" +
                                    "id='verified_" + checkPoint + "'" +
                                    "name='verified_" + checkPoint + "'" +
                                    "</div>"

                                divPoint.innerHTML +=
                                    "<div class='p-2'>" +
                                    "<label for='selectImportances_" + checkPoint + "'>Результат проверки</label>" +
                                    "<select class='form-select' name='selectImportances_" + checkPoint + "' id='selectImportances_" + checkPoint + "'>"


                                divPoint.innerHTML += "<div class='p-2'>" +
                                    "<label for='message_" + checkPoint + "'>Замечания</label>" +
                                    "<input disabled name='message_" + checkPoint + "' id='message_" + checkPoint + "' type='text' class='form-control' >" +
                                    "</div>"

                                checkPoint++

                            }
                        }
                    }
                }

            } else {
                controlPoint.innerHTML = '';
            }
        })

        document.body.addEventListener('click', function (event) {

            if (event.target.type === 'checkbox') {

                select = document.getElementById('selectImportances_' + parseInt(event.target.name.replace(/\D/g, '')))
                if (event.target.checked) {

                    eventSelect(event)

                    for (let i in objectControlImportances) {
                        select.add(new Option(objectControlImportances[i]['name'], objectControlImportances[i]['id']));
                    }
                } else {
                    select.textContent = ''
                    let message = document.getElementById('message_' + event.target.name.replace(/\D/g, ''))
                    message.value = ''
                    message.disabled = true
                }


            }
        });

        function eventSelect(check) {
            select.addEventListener('change', (event) => {

                let message = document.getElementById('message_' + check.target.name.replace(/\D/g, ''))

                if (event.target.value == 1) {
                    message.disabled = true
                } else {
                    message.disabled = false
                }

                if (message.disabled) {
                    message.value = ''
                }
            })
        }

    </script>
@endsection('script')
