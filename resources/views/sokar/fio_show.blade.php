@extends('layouts.base')
@section('title', 'Справочник')

@section('info')

    @forelse(\App\Models\SokarSpisanie::where('sokar_f_i_o_s_id', $fio->id)->get() as $value)
        @if ($loop->first)
            <table class="table table-bordered table-sm">
                <thead>
                <th>{{$fio->last}}</th>
                </thead>
                <tbody>
        @endif
        <tr><td>{{$value->date}} - {{$value->nomeklature->name}} ({{$value->colors->name}} {{$value->sizes->name}} {{$value->Rost->name}}) - {{$value->count}} ед. изм.</td></tr>


        @if($loop->last)
                </tbody>
            </table>
        @endif

    @empty
        <p>На данного сотрудника пока не было списаний спец одежды</p>
    @endforelse

    <a class="btn btn-info" href="/sokarfio">Назад</a>
@endsection('info')

