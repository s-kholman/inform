@extends('layouts.base')
@section('title', 'Текущие данные об опрыскивание ')

@section('info')

    @can('viewAny', 'App\Models\spraying')
        <div class="container">
            <div class="row">
                <div class="col-3"><a class="btn btn-outline-success" href="{{route('spraying.create')}}">Внести опрыскивание</a></div>
                <div class="col-3"><a class="btn btn-outline-success" href="/spraying/report">Отчеты</a> </div>
            </div>
        </div>

    @endcan




                @forelse($arr as $value)

                        @if($loop->first)
                            <table class="table table-bordered table-sm">
                                <thead>
                                <tr>
                                    @foreach($arr as $filial => $name)
                                        <th class="text-center">{{$filial}}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tr>
                        @endif

                                    <td>
                                        @foreach($value as $item)
                                            <a href="spraying/{{$item['pole']['id']}}">{{$item['pole']['name']}}</a><br>
                                        @endforeach
                                    </td>



                        @if($loop->last)
                                </tr>
                        @endif

                @empty

                @endforelse

    </table>

@endsection('info')
