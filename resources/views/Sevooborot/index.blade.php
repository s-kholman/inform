@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <div class="col-3">
        <a class="btn btn-info" href="/pole/{{$pole->id}}/sevooborot/create">Добавить севооборот</a>
    </div>
    Севооборот по полю {{$pole->name}}

    <div class="row m-4">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                @forelse($sevooborots as $name => $sevooborot)
                    @if($loop->first)
                        <button class="nav-link active" id="nav-{{$name}}-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-{{$name}}" type="button" role="tab" aria-controls="nav-{{$name}}"
                                aria-selected="true">{{$name}}</button>
                    @else
                        <button class="nav-link" id="nav-{{$name}}-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-{{$name}}" type="button" role="tab" aria-controls="nav-{{$name}}"
                                aria-selected="false">{{$name}}</button>
                    @endif
                @empty
                @endforelse
            </div>

            <div class="tab-content" id="nav-tabContent">
                @forelse($sevooborots as $name => $sevooborot)
                    @if($loop->first)
                        <div class="tab-pane fade show active" id="nav-{{$name}}" role="tabpanel"
                             aria-labelledby="nav-{{$name}}-tab">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <th class="text-center">Наименование</th>
                                <th class="text-center">Гектар</th>
                                <th class="text-center">Действия</th>
                                </thead>
                                @else
                                    <div class="tab-pane fade " id="nav-{{$name}}" role="tabpanel"
                                         aria-labelledby="nav-{{$name}}-tab">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <th class="text-center">Наименование</th>
                                            <th class="text-center">Гектар</th>
                                            <th class="text-center">Действия</th>
                                            </thead>
                                            @endif
                                            <tbody>
                                            @foreach($sevooborot as $value)
                                                <tr>
                                                    <td align="center">{{$value->Nomenklature->name}} - {{$value->Reproduktion->name}}</td>
                                                    <td align="center">{{$value->square}}</a></td>
                                                    <td align="center">
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                    class="btn btn-sm btn-outline-info dropdown-toggle"
                                                                    data-bs-toggle="dropdown">
                                                                Действия
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <form
                                                                    action="{{ route('pole.sevooborot.destroy', ['pole' => $value->pole_id,  'sevooborot' => $value->id])}}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <li><input type="submit"
                                                                               class="dropdown-item text-danger"
                                                                               value="Удалить"></li>
                                                                </form>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if($loop->last)
                                            </tbody>
                                        </table>
                                        @endif
                                        @endforeach
                                    </div>
                            @empty
                            @endforelse
                        </div>
            </div>

        </nav>


        <a class="btn btn-info" href="/pole">Назад</a>

@endsection('info')
