@extends('layouts.base')
@section('title', 'Учет спец одежды в лаборатории - "Сокар"')

@section('info')
    <div class="container">
        <div class="row">
            <div class="col">
                <div>
                    <a href="/color">Цвета</a>
                </div>
                <div>
                    <a href="/size">Размеры</a>
                </div>
                <div>
                    <a href="/counterparty">Контрагенты</a>
                </div>

                <div>
                    <a href="/sokarnomenklat">Номенклатура</a>
                </div>

                <div>
                    <a href="/sokarsklad">Склад (остатки)</a>
                </div>
                <div>
                    <a href="/sokarsklad/create">Поступление</a>
                </div>

                <div>
                    <a href="/sokarfio">Сотрудники</a>
                </div>

                <div>
                    <a href="/spisanie">Списание спец одежды</a>
                </div>

            </div>


        </div>
    </div>

@endsection('info')

