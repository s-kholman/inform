@extends('layouts.base')
@section('title', 'Конвертирование данных для 1С по топливным картам')

@section('info')

    <div class="container gx-4">
            <div class="row">
                <div class="col-6">
                    <form action="{{ route('card.loadInformation') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <label for="counterpartyDate">Дата входящего документа</label>
                        <input name="counterpartyDate" id="counterpartyDate" type="date" value="{{old('counterpartyDate') ? old('counterpartyDate') : date('Y-m-d')}}"
                               class="form-control @error('counterpartyDate') is-invalid @enderror">
                        @error('counterpartyDate')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label for="counterpartyNumber">Номер входящего документа</label>
                        <input name="counterpartyNumber" id="counterpartyNumber" type="text" value="{{old('counterpartyNumber')}}"
                               class="form-control @error('counterpartyNumber') is-invalid @enderror">
                        @error('counterpartyNumber')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label for="documentDate">Дата документа</label>
                        <input name="documentDate" id="documentDate" type="date" value="{{old('documentDate') ? old('documentDate') : date('Y-m-d')}}"
                               class="form-control @error('documentDate') is-invalid @enderror">
                        @error('documentDate')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label for="loadInformation">Загрузите файл от контрагента</label>
                        <input class="form-control @error('loadInformation') is-invalid @enderror" type="file" id="loadInformation" name="loadInformation" accept='text/csv'>
                        @error('loadInformation')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <button class="form-control" type="submit">Загрузить</button>
                    </form>

                    <div class="mt-4" style="font-size: 14px">
                        @if($download)
                            <a download href="{{\Illuminate\Support\Facades\Storage::url('card/export.xml') }}">Ссылка на файл от {{\Illuminate\Support\Carbon::parse($exportDateCrete)->setTimezone('Asia/Yekaterinburg')->format('H:i d-m-Y')}}</a>
                        @endif
                    </div>

                    <div class="mt-2" style="color: red ">
                        @if(!empty(json_decode($messages)))
                            @forelse(json_decode($messages) as $type => $message)
                                @if($type == 'skladIDEmpty')
                                    @foreach($message as $key => $value)
                                        <div class="row" style="font-size: 12px">Найдена новая карточка № {{$key}}</div>
                                    @endforeach
                                @endif
                                @if($type == 'NDSError')
                                    @foreach($message as $key => $value)
                                        <div class="row" style="font-size: 12px"> Ошибка НДС карта № {{$key}} транзакция от {{$value}}</div>
                                    @endforeach
                                @endif

                                    @if($type == 'Reverse')
                                        @foreach($message as $key => $value)
                                            <div class="row" style="font-size: 12px"> Сторнировано по карте № {{$key}} транзакция от {{$value}}</div>
                                        @endforeach
                                    @endif

                                    @if($type == 'ReverseFailed')
                                        @foreach($message as $key => $value)
                                            <div class="row" style="font-size: 12px"> Ошибка сторнирования по карте № {{$key}} {{$value}}</div>
                                        @endforeach
                                    @endif
                            @empty
                            @endforelse
                        @endif
                    </div>

                    <div class="row mt-4" style="font-size: 12px; text-align: justify">
                        <ol>
                            <li>Получаем файл выгрузки от контрагента "ОНЛАЙН КАРДС ООО" в формате CSV</li>
                            <li>Заполняем информацию "Дата входящего документа", "Номер входящего документа" и "Дата документа"</li>
                            <li>Выбираем полученный файл и нажимаем кнопку "Загрузить"</li>
                            <li>Появится или обновиться ссылка на скачивание файла при нажатии на которую произойдет закачка в директорию по умолчанию</li>
                            <li>
                                Загружаем файл обработкой - "Выгрузка и загрузка данных XML"
                                <ul type="disc">
                                    <li>Обработка находится: "Сервис" -> "Дополнительные внешние отчеты и обработки" -> "Обработки"</li>
                                    <li>Перейти во вкладку "Загрузка"</li>
                                    <li>Выбрыть сгенерированный файл</li>
                                    <li>Нажать на кнопку "Загрузить данные"</li>
                                </ul>
                            </li>
                        </ol>
                        <p>Возможные ошибки:</p>
                        <ol>
                            <li>
                                <b>Найдена новая карточка ...</b>
                                <ul>
                                    <li><b>Причина:</b> <p>обработка не смогла сопоставить номер карты со складом из программы 1С</p></li>
                                    <li>
                                        <b>Решение:</b>
                                        <p>Обновить файл складов</p>
                                        <p>Исправьте название склада, сопоставление происходит по 4 цифрам карты начиная с 14 символа.</p>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <b>Ошибка НДС ...</b>
                                <ul>
                                    <li><b>Причина:</b> <p>В файле от контрагента НДС отлична от 20</p></li>
                                    <li>
                                        <b>Решение:</b>
                                        <p>Исправить вручную в документе 1С</p>
                                    </li>
                                </ul>
                            </li>
                        </ol>
                    </div>
                    <div class="row mt-2">



                    </div>
                </div>
                <div class="col-6">
                    <form action="{{ route('card.loadStorageLocation') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="loadStorageLocation">Загрузите файл складов 1С</label>
                        <input class="form-control @error('loadStorageLocation') is-invalid @enderror" type="file" id="loadStorageLocation" name="loadStorageLocation" accept='application/xml'>
                        @error('loadStorageLocation')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <button class="form-control" type="submit">Загрузить</button>
                    </form>
                    @if($storageLocationDateCrete !== '')
                        <div class="mt-4" style="font-size: 14px; color: #0b2e13" >
                                Файл данных о складах загружен: {{\Illuminate\Support\Carbon::parse($storageLocationDateCrete)->setTimezone('Asia/Yekaterinburg')->format('H:i d-m-Y')}}
                        </div>
                    @else
                        <div class="mt-4" style="font-size: 14px; color: #2e0b0b" >
                            Файл данных о складах отсутствует.
                        </div>
                    @endif


                    <div class="row mt-2" style="font-size: 12px; text-align: justify">
                        <p>
                            Данная обработка предназначена для конвертации данных по заправкам на АЗС от "ОНЛАЙН КАРДС ООО"
                            С последующей загрузкой в 1С - документ "Поступление товаров и услуг"
                        </p>
                        <ol type="1">
                            <li>
                                Необходимо сделать выгрузку складов из 1С обработкой - "Выгрузка и загрузка данных XML".
                                <ul type="disc">
                                    <li>Обработка находится: "Сервис" -> "Дополнительные внешние отчеты и обработки" -> "Обработки"</li>
                                    <li>Указать путь и имя выгружаемого файла</li>
                                    <li>Установить период сегодня</li>
                                    <li>Снять галочку при необходимости</li>
                                    <li>Выбрать справочник "Склады места хранения"</li>
                                    <li>Нажать на кнопку "Выгрузить данные"</li>
                                </ul>
                                Это необходимо для сопоставления номера карт со складом в программе.
                            </li>
                            <li>
                                Полученный файл загружаем на сайт через "Загрузите файл складов 1С"
                            </li>
                            <li>
                                Операцию необходимо повторять при добавлении в программу 1С новых складов для топливных карт
                            </li>
                            <li>
                                Файл сохраняется на сервере
                            </li>

                        </ol>
                    </div>
                </div>
            </div>

    </div>
@endsection('info')
