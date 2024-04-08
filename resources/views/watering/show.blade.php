@extends('layouts.base')

@section('title', 'Данные о поливе ')

@section('info')
    <div class="container">
        <div class="row m-4">
            <div class="col-12">
                Филиал:  <b>{{$pole->Filial->name ?? ''}}</b>, поле: <b>{{$pole->name ?? ''}}</b>
            </div>
        </div>
        @if($pole->path ?? null)
        <div class="row m-4">
            <div class="col">
                <img class="img-fluid" src="{{Storage::url($pole->path)}}">
            </div>
        </div>
        @endif

        <div class="row m-4">
            <div class="col-3">
                <a class="btn btn-outline-success" href="/watering/index">Назад</a>
            </div>
            <div class="col-3">
                <a class="btn btn-outline-success" href="/watering/create">Внести полив</a>
            </div>
        </div>

        <div class="row m-4">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @forelse($waterings as $name => $watering)
                        @if($loop->first)
                        <button class="nav-link active" id="nav-{{$name}}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{$name}}" type="button" role="tab" aria-controls="nav-{{$name}}" aria-selected="true">{{$name}}</button>
                        @else
                            <button class="nav-link" id="nav-{{$name}}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{$name}}" type="button" role="tab" aria-controls="nav-{{$name}}" aria-selected="false">{{$name}}</button>
                        @endif
                    @empty
                    @endforelse
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                @forelse($waterings as $name => $watering)
                    @if($loop->first)
                         <div class="tab-pane fade show active"  id="nav-{{$name}}" role="tabpanel" aria-labelledby="nav-{{$name}}-tab">
                             <table class="table table-bordered table-striped">
                                 <thead>
                                 <th class="text-center">Дата</th>
                                 <th class="text-center">Гидрант</th>
                                 <th class="text-center">Сектор</th>
                                 <th class="text-center">Полив мм</th>
                                 <th class="text-center">Скорость</th>
                                 <th class="text-center">КАС</th>
                                 <th class="text-center">Коментарий</th>
                                 @if($harvest_show[$watering[0]->HarvestYear->id])
                                    <th class="text-center">Действия</th>
                                 @endif
                                 </thead>
                     @else
                         <div class="tab-pane fade "  id="nav-{{$name}}" role="tabpanel" aria-labelledby="nav-{{$name}}-tab">
                             <table class="table table-bordered table-striped">
                                 <thead>
                                 <th class="text-center">Дата</th>
                                 <th class="text-center">Гидрант</th>
                                 <th class="text-center">Сектор</th>
                                 <th class="text-center">Полив мм</th>
                                 <th class="text-center">Скорость</th>
                                 <th class="text-center">КАС</th>
                                 <th class="text-center">Коментарий</th>
                                 @if($harvest_show[$watering[0]->HarvestYear->id])
                                    <th class="text-center">Действия</th>
                                 @endif
                                 </thead>
                     @endif
                             <tbody>
                         @foreach($watering as $value)
                                 <tr>
                                     <td align="center">{{\Illuminate\Support\Carbon::parse($value->date)->format('d-m-Y')}}</td>
                                     <td align="center">{{$value->gidrant}}</a></td>
                                     <td align="center">{{$value->sector}}</td>
                                     <td align="center">{{$value->poliv}}</td>
                                     <td align="center">{{$value->speed}}</td>
                                     <td align="center">{{$value->KAC}}</td>
                                     <td align="center">{{$value->comment}}</td>
                                     @if($harvest_show[$watering[0]->HarvestYear->id])
                                     <td align="center">
                                         <div class="dropdown">
                                             <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle" data-bs-toggle="dropdown">
                                                 Действия
                                             </button>
                                             <ul class="dropdown-menu">
                                                 <form action="{{ route('watering.destroy', ['watering' => $value->id])}}" method="POST">
                                                     @csrf
                                                     @method('DELETE')
                                                     <li><input type="submit" class="dropdown-item text-danger" value="Удалить"></li>
                                                 </form>
                                             </ul>
                                         </div>
                                     </td>
                                     @endif
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
    </div>

@endsection('info')

