@extends('layouts.base')
@section('title', 'Данные о прогреве семян')

@section('info')

    <div class="container gx-4">
        @can('Warming.user.view')
            <div class="row">
                <div class="col-4 p-3">
                    <a class="btn btn-outline-success" href="{{route('warming.create')}}">Внести прогрев</a>
                </div>
            </div>
        @endcan
    </div>

    <div class="container gx-4">
        <div class="row text-center text-wrap text-break">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @foreach($warming as $filial_id => $name)
                        @if($loop->first)
                            <button class="nav-link active" id="nav-{{$name[0]->storageName->filial->id}}-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#nav-{{$name[0]->storageName->filial->id}}" type="button"
                                    role="tab"
                                    aria-controls="nav-{{$name[0]->storageName->filial->id}}"
                                    aria-selected="true">{{$name[0]->storageName->filial->name}}</button>
                        @else
                            <button class="nav-link" id="nav-{{$name[0]->storageName->filial->id}}-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#nav-{{$name[0]->storageName->filial->id}}" type="button"
                                    role="tab"
                                    aria-controls="nav-{{$name[0]->storageName->filial->id}}"
                                    aria-selected="false">{{$name[0]->storageName->filial->name}}</button>
                        @endif
                    @endforeach
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                @foreach($warming as $name)
                    @if($loop->first)
                        <div class="tab-pane fade show active" id="nav-{{$name[0]->storageName->filial->id}}"
                             role="tabpanel"
                             aria-labelledby="nav-{{$name[0]->storageName->filial->id}}-tab">
                            @else
                                <div class="tab-pane fade " id="nav-{{$name[0]->storageName->filial->id}}"
                                     role="tabpanel"
                                     aria-labelledby="nav-{{$name[0]->storageName->filial->id}}-tab">
                                    @endif
                                    @foreach($name as $f)
                                        @if($loop->first)
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Бокс</th>
                                                    <th>Объем</th>
                                                    <th>Дата посадки</th>
                                                    <th>Дата прогрева</th>
                                                    <th>Комментарий</th>
                                                    <th>Контроль агроном</th>
                                                    <th>Контроль зам. дир</th>
                                                    @can('Warming.completed.create')
                                                        <th>Действия</th>
                                                    @endcan
                                                </tr>
                                                </thead>
                                                @endif
                                                <tbody>
                                                <tr>
                                                    <td>{{$f->storageName->name}}</td>
                                                    <td>{{$f->volume}}</td>
                                                    <td>{{\Carbon\Carbon::parse($f->sowing_date)->translatedFormat('d.m.Y')}}</td>
                                                    <td>{{\Carbon\Carbon::parse($f->warming_date)->translatedFormat('d.m.Y')}}</td>
                                                    <td>{{$f->comment ?? ''}}</td>
                                                    <td>
                                                        @forelse($f->warmingControl as $control)
                                                            @if($control->level == 1)
                                                                {{$control->user->Registration->last_name}}:
                                                                ({{\Carbon\Carbon::parse($control->created_at)->translatedFormat('d.m.Y')}}
                                                                ) -
                                                                "{{$control->text}}"
                                                                <br>
                                                            @endif
                                                        @empty
                                                        @endforelse

                                                    </td>
                                                    <td>
                                                        @forelse($f->warmingControl as $control)
                                                            @if($control->level == 2)
                                                                {{$control->user->Registration->last_name}}:
                                                                ({{\Carbon\Carbon::parse($control->created_at)->translatedFormat('d.m.Y')}}
                                                                )
                                                                "{{$control->text}}"
                                                                <br>
                                                            @endif
                                                        @empty
                                                        @endforelse
                                                    </td>
                                                    @can('Warming.completed.create')
                                                        <td align="center">
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                        class="btn btn-sm btn-outline-info dropdown-toggle"
                                                                        data-bs-toggle="dropdown">
                                                                    Действия
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item text-info"
                                                                           href="/warming/{{$f->id}}/edit">Редактировать</a>
                                                                    </li>
                                                                    <form class="delete-message"
                                                                          data-route="{{ route('warming.destroy', ['warming' => $f->id])}}"
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
                                                    @endcan
                                                </tr>
                                                </tbody>
                                                @if($loop->last)
                                            </table>
                                        @endif

                                    @endforeach
                                </div>
                                @endforeach
                        </div>


            </div>
        </div>
    </div>
@endsection('info')
@section('script')
    @include('scripts\destroy-modal-edit')
@endsection
