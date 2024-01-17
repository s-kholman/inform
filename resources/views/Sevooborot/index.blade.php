@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <div class="col-3">
        <a class="btn btn-info" href="/pole/{{$pole->id}}/sevooborot/create">Добавить севооборот</a>
    </div>
    Севооборот по полю {{$pole->name}}
    <table class="table table-bordered">
        <th>Наименование</th>
        <th>Гектар</th>
        <th>Удалить</th>
        @forelse(\App\Models\Sevooborot::where('pole_id', $pole->id)->get() as $value)




                    <tr>

                        <td>{{$value->Cultivation->name}} "{{$value->Nomenklature->name}}" - {{$value->Reproduktion->name ?? null}}               </td>
                        <td>{{$value->square}}</td>
                        <td>

                            <form action="{{ route('pole.sevooborot.destroy', ['pole' => $pole->id,  'sevooborot' => $value->id])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-danger" value="Удалить">
                            </form>
                        </td>
                    </tr>

        @empty
        @endforelse




    </table>
    @if(isset($flag) && $flag == 1)
        <div class="alert alert-success">add record successful</div>
    @endif
    <a class="btn btn-info" href="/pole">Назад</a>

@endsection('info')
