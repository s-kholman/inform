@extends('layouts.base')
@section('title', 'Места хранения')

@section('info')
    <div class="container">

            <div class="row p-5">
                <div class="col-2">
                    <a class="btn btn-info" href="/monitoring/">Назад</a>
                </div>
                @can('viewButton', 'App\Models\ProductMonitoring')
                <div class="col-3 ">
                    <a class="btn btn-info" href="/monitoring/create">Внести данные</a>
                </div>
                @endcan
            </div>

        <div class="row">
            <div class="col-8">
                @foreach($monitoring as $value)
                    @if($loop->first)
                        <h5><p>Филиал: {{$value->filial->name}}</p></h5><br>
                    @endif

                    <h5><p>
                            <a href="/monitoring/filial/storage/{{$value->storage_name_id}}/year/{{$value->harvest_year_id}}">{{$value->storageName->name}}</a>
                        </p></h5><br>
                    @if($loop->last)
                        @if($value->storageName->filial_id == 11)
            </div>
            <div class="col-4">
                <div class="row text-center">
                    <h5><p>График</p></h5>
                </div>
                <div class="row">
                    <table class="table table-bordered text-center">
                        <thead>
                        <td>Боксы</td>
                        <td>C02</td>
                        <td>Основная вентиляция</td>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>8:00-8:30</td>
                            <td>23:00-01:00</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>8:00-8:30</td>
                            <td>23:00-01:00</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>8:00-8:30</td>
                            <td>23:00-01:00</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>8:00-8:30</td>
                            <td>23:00-01:00</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>8:00-8:30</td>
                            <td>23:00-01:00</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>8:00-8:30</td>
                            <td>23:00-01:00</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>8:00-8:30</td>
                            <td>23:00-01:00</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>8:00-8:30</td>
                            <td>23:00-01:00</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>8:00-8:30</td>
                            <td>23:00-01:00</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>8:00-8:30</td>
                            <td>23:00-01:00</td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>8:00-8:30</td>
                            <td>23:00-01:00</td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>8:30-9:00</td>
                            <td>01:00-03:00</td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>8:30-9:00</td>
                            <td>01:00-03:00</td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>-</td>
                            <td>23:00-01:00</td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>-</td>
                            <td>23:00-01:00</td>
                        </tr>
                        <tr>
                            <td>16</td>
                            <td>8:00-8:30</td>
                            <td>23:00-01:00</td>
                        </tr>
                        <tr>
                            <td>16A</td>
                            <td>8:30-9:00</td>
                            <td>01:00-03:00</td>
                        </tr>
                        <tr>
                            <td>17</td>
                            <td>-</td>
                            <td>01:00-03:00</td>
                        </tr>
                        <tr>
                            <td>18</td>
                            <td>-</td>
                            <td>01:00-03:00</td>
                        </tr>
                        <tr>
                            <td>19</td>
                            <td>-</td>
                            <td>01:00-03:00</td>
                        </tr>
                        <tr>
                            <td>20</td>
                            <td>-</td>
                            <td>01:00-03:00</td>
                        </tr>
                        <tr>
                            <td>21</td>
                            <td>-</td>
                            <td>01:00-03:00</td>
                        </tr>
                        <tr>
                            <td>22</td>
                            <td>-</td>
                            <td>01:00-03:00</td>
                        </tr>
                        <tr>
                            <td>23</td>
                            <td>-</td>
                            <td>01:00-03:00</td>
                        </tr>
                        <tr>
                            <td>24</td>
                            <td>-</td>
                            <td>01:00-03:00</td>
                        </tr>
                        <tr>
                            <td>25</td>
                            <td>-</td>
                            <td>01:00-03:00</td>
                        </tr>
                        <tr>
                            <td>26</td>
                            <td>-</td>
                            <td>01:00-03:00</td>
                        </tr>
                        <tr>
                            <td>28</td>
                            <td>-</td>
                            <td>01:00-03:00</td>
                        </tr>
                        <tr>
                            <td>37</td>
                            <td>-</td>
                            <td>03:00-05:00</td>
                        </tr>
                        <tr>
                            <td>38</td>
                            <td>-</td>
                            <td>03:00-05:00</td>
                        </tr>
                        <tr>
                            <td>39</td>
                            <td>-</td>
                            <td>03:00-05:00</td>
                        </tr>
                        <tr>
                            <td>40</td>
                            <td>-</td>
                            <td>05:00-07:00</td>
                        </tr>
                        <tr>
                            <td>41</td>
                            <td>8:30-9:00</td>
                            <td>05:00-07:00</td>
                        </tr>
                        <tr>
                            <td>42</td>
                            <td>-</td>
                            <td>05:00-07:00</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @endif
            @endforeach

        </div>

    </div>
@endsection('info')

