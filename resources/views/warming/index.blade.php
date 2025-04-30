@extends('layouts.base')
@section('title', 'Данные о прогреве семян')

@section('info')


    <div class="container gx-4">

            <div class="row">
                <div class="col-4 p-3"><a class="btn btn-outline-success" href="{{route('warming.create')}}">Внести
                        прогрев</a></div>
                </div>
            </div>

        <div class="container gx-4">
            <div class="row">


               <div class="col-xl-10">
                        @foreach($warming as $filial_id => $name)
                            {{\App\Models\filial::query()->where('id', $filial_id)->value('name')}} <br>
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
                                            <th>Действия</th>
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
                                                ({{\Carbon\Carbon::parse($control->created_at)->translatedFormat('d.m.Y')}}) -
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
                                                        ({{\Carbon\Carbon::parse($control->created_at)->translatedFormat('d.m.Y')}})
                                                        "{{$control->text}}"
                                                        <br>
                                                    @endif
                                                @empty
                                                @endforelse
                                            </td>
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
                                        </tr>
                                        </tbody>
                                        @if($loop->last)
                                    </table>
                           @endif

                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection('info')
@section('script')
    @include('scripts\destroy-modal-edit')
@endsection
