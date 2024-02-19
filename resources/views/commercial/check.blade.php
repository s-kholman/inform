@extends('layouts.base')
@section('title', 'Сверка взаиморасчетов')

@section('info')
    <div class="container">
        <form action="{{route('commercial.check')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-6" >
                    <label for="textOne">Первый контрагент</label>
                    <textarea style="height: 300px" id="textOne" class="form-control" name="PartnerOne">@if(!empty($defaultOne)){{$defaultOne}}@endif</textarea>
                </div>
                <div class="col-6">
                    <label for="textTwo">Второй контрагент</label>
                    <textarea style="height: 300px" id="textTwo" class="form-control" name="PartnerTwo">@if(!empty($defaultTwo)){{$defaultTwo}}@endif</textarea>
                </div>
            </div>
            <div class="row">
                <div class="g-4 col-12 text-center">
                    <button class="btn btn-info" type="submit">Проверить</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-6">
                @if(!empty($arrPartnerOne))
                    @foreach($arrPartnerOne as $key => $value)
                        @if($loop->first)
                            <br />По данным первого контрагента:<br />
                        @endif
                        № - {{$key}}, сумма: {{number_format($value, 2, ',', ' ')}} <br />
                    @endforeach
                @endif
            </div>
            <div class="col-6">
                @if(!empty($arrPartnerTwo))
                    @foreach($arrPartnerTwo as $key => $value)
                        @if($loop->first)
                            <br />По данным второго контрагента:<br />
                        @endif
                        № - {{$key}}, сумма: {{number_format($value, 2, ',', ' ')}} <br />
                    @endforeach
                @endif
            </div>
        </div>
    </div>

@endsection('info')
