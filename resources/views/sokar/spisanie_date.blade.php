@extends('layouts.base')
@section('title', 'Справочник')

@section('info')



    @forelse($spisanie as $value)
        @if ($loop->first)
            <table class="table table-bordered table-sm">
                <thead>
                <th colspan="4">Отчет о списании за период c {{$dateTo}} по {{$dateDo}}</th>
                <tr>
                    <th>ФИО</th>
                    <th>Наименование</th>
                    <th>Дата</th>
                    <th>Количество</th>
                </tr>

                </thead>
                <tbody>
                @endif
                <tr>
                    <td>{{$value->SokarFIO->last}} {{$value->SokarFIO->first}} {{$value->SokarFIO->middle ?? null}}</td>
                    <td>{{$value->nomeklature->name}} (ц. {{$value->colors->name}} р. {{$value->sizes->name}})</td>
                    <td>{{$value->date}}</td>
                    <td>{{$value->count}}</td>
                </tr>


                @if($loop->last)
                </tbody>
            </table>
        @endif

    @empty
        <p>Отчет пуст</p>
    @endforelse
    <a class="btn btn-info" href="/spisanie">Назад</a>
@endsection('info')

