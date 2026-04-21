@extends('layouts.base')
@section('title', 'Контроль объектов')
<style>
    .color-row-2 {
        background-color: #fcf3f3; /* Устанавливает фон для элементов с классом */
    }
    .color-row-3 {
        background-color: #e3ffd1; /* Устанавливает фон для элементов с классом */
    }
    .color-row-4 {
        background-color: #ffea93; /* Устанавливает фон для элементов с классом */
    }
    .color-row-5 {
        background-color: #faa1a1; /* Устанавливает фон для элементов с классом */
    }
</style>
@section('info')
    <div class="container">
        <form action="{{route('object.control.index')}}" method="POST">
            <div class="row justify-content-center text-center">
                @csrf
                <input hidden id="pole_id" name="pole_id" value="{{$pole_id}}">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-2 col-xxl-2">
                    <label for="dateSelect">Выберите филиал</label>
                    <select name="filial" id="selectFilial"
                            class="form-select @error('filial') is-invalid @enderror">
                        <option value="0"></option>
                        @forelse($filials as $filial)
                            @if($filial_id == $filial->filial->id)
                                <option selected value="{{$filial->filial->id}}"> {{ $filial->filial->name }} </option>
                            @else
                                <option value="{{$filial->filial->id}}"> {{ $filial->filial->name }} </option>
                            @endif
                        @empty
                            <option value=""> Заполните справочник</option>
                        @endforelse
                    </select>
                </div>

                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-2 col-xxl-2">
                    <label for="selectPole">Выберите поле</label>
                    <select disabled name="pole" id="selectPole" class="form-select">
                    </select>
                </div>

                <div class="col-xs-4 col-sm-4 col-md-5 col-lg-4 col-xl-3 col-xxl-3 form-group">
                    <label for="date_range">Диапазон дат:</label>
                    <input
                        type="text"
                        id="date_range"
                        name="date_range"
                        class="form-control"
                        placeholder="Выберите диапазон дат"
                        data-default-start="{{ $startDate }}"
                        data-default-end="{{ $endDate }}"
                        required
                    >
                </div>

                <div class=" justify-content-center row p-4">
                    <div class="col-xs-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-xxl-2">
                        <input class="btn btn-primary" type="submit" value="Сформировать отчет">
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-xxl-2">
                        <a class="btn btn-info" href="/object/control/create">Создать контроль</a>
                    </div>
                </div>
            </div>
        </form>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                @forelse($objectControl->groupBy('filial_id') as $item)
                    @if($loop->first)
                        <button class="nav-link active" id="nav-filial-id-{{$item[0]->Filial->id}}" data-bs-toggle="tab"
                                data-bs-target="#nav-target-{{$item[0]->Filial->id}}" type="button" role="tab"
                                aria-controls="nav-home" aria-selected="true">{{$item[0]->Filial->name}}</button>
                    @else
                        <button class="nav-link" id="nav-filial-id-{{$item[0]->Filial->id}}" data-bs-toggle="tab"
                                data-bs-target="#nav-target-{{$item[0]->Filial->id}}" type="button" role="tab"
                                aria-controls="nav-profile" aria-selected="false">{{$item[0]->Filial->name}}</button>
                    @endif
                @empty
                @endforelse
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            @forelse($objectControl->groupBy('filial_id') as $item)
                @if($loop->first)
                    <div class="tab-pane fade show active" id="nav-target-{{$item[0]->Filial->id}}" role="tabpanel"
                         aria-labelledby="nav-filial-id-{{$item[0]->Filial->id}}">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Объект контроля</th>
                                <th>Тип контроля</th>
                                <th>Действие</th>
                                <th>Комментарий</th>
                                <th>ФИО</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($item->groupBy('objectName.object_type_id') as $objectType)
                                @foreach($objectType as $value)
                                @if($loop->first)
                                    <tr>
                                        <td style="font-style: italic; font-weight: bold;" colspan="6">{{$objectType[0]->ObjectName->ObjectType->name}}</td>
                                    </tr>
                                @endif
                                <tr class="color-row-{{$value->objectControlImportance->level}}">
                                    <td>{{\Carbon\Carbon::parse($value->date)->format('d.m.Y')}}</td>
                                    <td>{{$value->objectName->name}} {{$value[0]->ObjectName->PoleName->name ?? ''}}</td>
                                    <td>{{$value->objectControlPoint->name}} </td>
                                    <td>{{$value->objectControlImportance->name}}</td>
                                    <td>{{$value->messages}}</td>
                                    <td>{{$value->User->Registration->last_name ?? ''}}{{mb_substr($value->User->Registration->first_name, 0, 1)}}{{mb_substr($value->User->Registration->middle_name, 0, 1)}} </td>
                                </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="tab-pane fade" id="nav-target-{{$item[0]->Filial->id}}" role="tabpanel"
                         aria-labelledby="nav-filial-id-{{$item[0]->Filial->id}}">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Объект контроля</th>
                                <th>Тип контроля</th>
                                <th>Действие</th>
                                <th>Комментарий</th>
                                <th>ФИО</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($item->groupBy('objectName.object_type_id') as $objectType)
                                @foreach($objectType as $value)
                                    @if($loop->first)
                                        <tr>
                                            <td style="font-style: italic; font-weight: bold;" colspan="6">{{$objectType[0]->ObjectName->ObjectType->name}}</td>
                                        </tr>
                                    @endif
                                    <tr class="color-row-{{$value->objectControlImportance->level}}">
                                        <td>{{\Carbon\Carbon::parse($value->date)->format('d.m.Y')}}</td>
                                        <td>{{$value->objectName->name}} {{$value[0]->ObjectName->PoleName->name ?? ''}}</td>
                                        <td>{{$value->objectControlPoint->name}} </td>
                                        <td>{{$value->objectControlImportance->name}}</td>
                                        <td>{{$value->messages}}</td>
                                        <td>{{$value->User->Registration->last_name ?? ''}}{{mb_substr($value->User->Registration->first_name, 0, 1)}}{{mb_substr($value->User->Registration->middle_name, 0, 1)}} </td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @empty
            @endforelse


        </div>
    </div>


@endsection('info')
@section('script')
    <script>
        const pole = {!! $poles !!};
        const pole_id = {!! $pole_id !!};
        const startDate = document.getElementById('date_range').dataset.defaultStart;
        const endDate = document.getElementById('date_range').dataset.defaultEnd;
        const selectFilial = document.getElementById('selectFilial');
        const selectPole = document.getElementById('selectPole');
        const poleId = document.getElementById('pole_id');



        if(selectFilial.value > 0 && poleId.value != null){
            selectPole.disabled = false
            selectPole.add(new Option('', ''))
            for (let key in pole[selectFilial.value]) {
                const newOption = document.createElement('option');
                newOption.value = pole[selectFilial.value][key]['object_name']['pole_name']['id']
                newOption.text = pole[selectFilial.value][key]['object_name']['pole_name']['name']
                selectPole.add(newOption)
                if (poleId.value !== null && poleId.value == pole[selectFilial.value][key]['object_name']['pole_name']['id']){
                    newOption.selected = true;
                }
            }
        }

        selectFilial.addEventListener('change', () => {
            if (selectFilial.value > 0) {
                selectPole.disabled = false
                selectPole.textContent = ''
                selectPole.add(new Option('', ''))
                poleId.value = null

                for (let key in pole[selectFilial.value]) {
                    if (poleId.value !== null && poleId.value == pole[selectFilial.value][key]['object_name']['pole_name']['id']){
                    }
                    selectPole.add(new Option(pole[selectFilial.value][key]['object_name']['pole_name']['name'], pole[selectFilial.value][key]['object_name']['pole_name']['id']))
                }
            } else {
                selectPole.disabled = true
                selectPole.textContent = ''
                poleId.value = null;
            }
        })

        selectPole.addEventListener('change', () => {
            poleId.value = selectPole.value
            console.log(poleId.value)
        });

        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#date_range", {
                mode: "range", // Режим выбора диапазона
                dateFormat: "d.m.Y", // Формат даты: 01.01.2024
                locale: "ru", // Русская локализация
                minDate: 0, // Минимальная дата
                maxDate: new Date(), // Максимальная дата
                inline: false, // Показывать как всплывающее окно
                altInput: true, // Использовать альтернативное поле ввода
                altFormat: "d.m.Y", // Формат альтернативного поля
                defaultDate: [startDate, endDate], //Значение дат по умолчанию
            });
        });
    </script>
@endsection('script')


