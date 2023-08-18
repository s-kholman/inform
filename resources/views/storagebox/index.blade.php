@extends('layouts.base')
@section('title', 'Итоги хранения по боксам')

@section('info')

    <div class="container px-4">
        <div class="row-cols-3 gx-5">
            <div class="col-3 p-3"><a class="btn btn-info"
                                      href="{{action([\App\Http\Controllers\Storage\StorageBoxController::class, 'create'])}}">Внести
                    данные</a></div>
        </div>

        @forelse($storage as $value)
            @if ($loop->first)
                <div class="row border border-1">
                    <div class="col-xl-2 col-xxl-2">Склады</div>
                    <div class="col-xl-3 col-xxl-3">Номенклатура</div>
                    <div class="col-xl-1 col-xxl-1">Тип</div>
                    <div class="col-xl-1 col-xxl-1">Объем</div>
                    <div class="col-xl-5 col-xxl-5">Поля</div>
                </div>
            @endif
            <div class="row border-top border-end border-start border-3 @if ($loop->index % 2 == 0)border-info @endif">
                <div class="text-wrap col-xl-2 col-xxl-2"><b><a href="{{route('storagebox.show', ['storagebox' => $value])}}">{{$value->storageName->name}}</a></b></div>
                <div class="col-xl-3 col-xxl-3"><a
                        href="{{route('gues.index', ['id' => $value])}}">{{$value->nomenklature->name}} {{$value->reproduktion->name}}</a>
                </div>
                <div class="col-xl-1 col-xxl-1">@if($value->type == 1) Товарный @elseif($value->type == 2)
                        Семенной @else  @endif</div>
                <div class="col-xl-1 col-xxl-1"><a
                        href="{{route('take.index', ['id' => $value])}}">{{$value->volume}}</a></div>
                <div class="text-wrap col-xl-5 col-xxl-5">{{$value->field}}</div>
            </div>
            <div
                class="row text-center border-end border-bottom  border-start border-2 @if ($loop->index % 2 == 0)border-info @endif">


                @foreach($name as $key => $name_)

                    <div class="col-xl-2 col-xxl-2 border border-1">

                        <div class="row">
                            <div class="col-xl-12 col-xxl-12 border border-1">{{$name_}}</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-xxl-6 border border-1">План</div>
                            <div class="col-xl-6 col-xxl-6 border border-1">Факт</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-xxl-6 border border-1">{{$gues->first(function ($item, $key) use ($value) {return $item->storage_box_id == $value->id;})->$key ?? "0"}}%</div>

                            <div class="col-xl-6 col-xxl-6 border border-1">{{round(($take->first(function ($item, $key) use ($value) {return $item->storage_box_id == $value->id ?? 0;})->$key ?? 0)/$value->volume * 100, 2)}}%</div>
                        </div>
                        <div class="row">
                            {{-- Выражение в скобках логика:
                               - first возвращает первый элемент из коллекции который проходит проверку истености из замыкания
                               - в замыкании проверяется текущий storage_box_id с id первого цикла (здесь второй цикл)
                               - id из первого цикла передается через (use)
                               - если значение null через тернарный оператор присваиваем ему 0
                               - далее обращаемся к столбцу модели через переменную $key в которой в цикле передаются название столбцов
                               - также если значение null через тернарный оператор приводим к нулю
                               - после арифметика
                               - на последок округляем до сотых (round) и добавляем знак "%" в конце. Выводим в шаблон
                            --}}
                            <div class="col-xl-6 col-xxl-6 border border-1">{{round($value->volume / 100 * ($gues->first(function ($item, $key) use ($value) {return $item->storage_box_id == $value->id ?? 0;})->$key ?? 0))}}</div>
                            <div class="col-xl-6 col-xxl-6 border border-1">{{round($take->first(function ($item, $key) use ($value) {return $item->storage_box_id == $value->id;})->$key ?? "0")}}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <div class="row gx-5">
                <div class="col">Данные не найдены</div>
            </div>
        @endforelse
    </div>
@endsection('info')
