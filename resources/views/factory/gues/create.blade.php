@extends('layouts.base')
@section('title', 'Поступление сырья на завод')

@section('info')
    <div class="container gx-4">
    <form action="{{route('factory.gues.store', ['factory' => $factory[0]->id])}}" method="post">
        @csrf



            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 p-2">
                    <label for="volume">Объем</label>
                    <input placeholder="Введите поступивший объем"
                           class="form-control @error('volume') is-invalid @enderror"
                           @if(empty(old('volume'))) value="{{$factory[0]->gues->volume ?? ''}}" @else value="{{old('volume')}}" @endif
                           id="volume"
                           name="volume"
                           type="number"
                           >
                    @error('volume')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-4 p-2">
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 p-2">
                    <label for="mechanical">Механические повреждение</label>
                    <input placeholder="Введите %, в допуске {{$specifically['mechanical']}}%"
                           class="form-control @error('mechanical') is-invalid @enderror"
                           @if(empty(old('mechanical'))) value="{{$factory[0]->gues->mechanical ?? ''}}" @else value="{{old('mechanical')}}" @endif
                           id="mechanical"
                           name="mechanical"
                           type="number"
                           step="0.01">
                    @error('mechanical')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 p-2">
                    <label for="land">Камни, земля</label>
                    <input placeholder="Введите %, в допуске {{$specifically['land']}}%"
                           class="form-control @error('land') is-invalid @enderror"
                           @if(empty(old('land'))) value="{{$factory[0]->gues->land ?? ''}}" @else value="{{old('land')}}" @endif
                           id="land"
                           name="land"
                           type="number"
                           step="0.01">
                    @error('land')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 p-2">
                    <label for="haulm">Ботва</label>
                    <input placeholder="Введите %, в допуске {{$specifically['haulm']}}%"
                           class="form-control @error('haulm') is-invalid @enderror"
                           @if(empty(old('haulm'))) value="{{$factory[0]->gues->haulm ?? ''}}" @else value="{{old('haulm')}}" @endif
                           id="haulm"
                           name="haulm"
                           type="number"
                           step="0.01">
                    @error('haulm')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 p-2">
                    <label for="rot">Гниль</label>
                    <input placeholder="Введите %, в допуске {{$specifically['rot']}}%"
                           class="form-control @error('rot') is-invalid @enderror"
                           @if(empty(old('rot'))) value="{{$factory[0]->gues->rot ?? ''}}" @else value="{{old('rot')}}" @endif
                           id="rot"
                           name="rot"
                           type="number"
                           step="0.01">
                    @error('rot')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 col-xxl-2 form-check form-switch">
                    <label for="foreign_object">Инородные предметы</label>
                    <input class="form-check-input" type="checkbox" @if($factory[0]->gues->foreign_object ?? false) checked @endif id="foreign_object" name="foreign_object">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 col-xxl-2 form-check form-switch">
                    <label for="another_variety">Пересортица</label>
                    <input class="form-check-input" type="checkbox" @if($factory[0]->gues->another_variety ?? false) checked @endif  id="another_variety" name="another_variety">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4p-2">
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 p-2">
                    <label for="less_thirty">Фракция до 35</label>
                    <input placeholder="Введите %"
                           class="form-control @error('less_thirty') is-invalid @enderror"
                           @if(empty(old('less_thirty'))) value="{{$factory[0]->gues->less_thirty ?? ''}}" @else value="{{old('less_thirty')}}" @endif
                           id="less_thirty"
                           name="less_thirty"
                           type="number"
                           step="0.01">
                    @error('less_thirty')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 p-2">
                    <label for="thirty">Фракция 35-45</label>
                    <input placeholder="Введите %"
                           class="form-control @error('thirty') is-invalid @enderror"
                           @if(empty(old('thirty'))) value="{{$factory[0]->gues->thirty ?? ''}}" @else value="{{old('thirty')}}" @endif
                           id="thirty"
                           name="thirty"
                           type="number"
                           step="0.01">
                    @error('thirty')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 p-2">
                    <label for="forty">Фракция 45-55</label>
                    <input placeholder="Введите %"
                           class="form-control @error('forty') is-invalid @enderror"
                           @if(empty(old('forty'))) value="{{$factory[0]->gues->forty ?? ''}}" @else value="{{old('forty')}}" @endif
                           id="forty"
                           name="forty"
                           type="number"
                           step="0.01">
                    @error('forty')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 p-2">
                    <label for="fifty">Фракция 55-65</label>
                    <input placeholder="Введите %"
                           class="form-control @error('fifty') is-invalid @enderror"
                           @if(empty(old('fifty'))) value="{{$factory[0]->gues->fifty ?? ''}}" @else value="{{old('fifty')}}" @endif
                           id="fifty"
                           name="fifty"
                           type="number"
                           step="0.01">
                    @error('fifty')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 p-2">
                    <label for="sixty">Фракция 65</label>
                    <input placeholder="Введите %"
                           class="form-control @error('sixty') is-invalid @enderror"
                           @if(empty(old('sixty'))) value="{{$factory[0]->gues->sixty ?? ''}}" @else value="{{old('sixty')}}" @endif
                           id="sixty"
                           name="sixty"
                           type="number"
                           step="0.01">
                    @error('sixty')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 p-2">
                    <hr>
                </div>
            </div>

            <input hidden name="factory_material_id" value="{{$factory[0]->id}}">

        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 p-2">
                <input hidden class="display form-control @error('full') is-invalid @enderror" name="full">
                @error('full')
                <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
                @enderror
            </div>
        </div>

            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 col-xxl-2 p-2 ">
                    <a class="btn btn-primary" href="/factory/material">Назад</a>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 col-xxl-2 p-2 text-end">
                    <input class="btn btn-primary" type="submit" value="Сохранить" name="save">
                </div>
            </div>
    </form>
        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4 text-center">
                <form action="{{route('material.destroy', ['material' => $factory[0]->id])}}" method="post">
                    @csrf
                    @method('DELETE')
                    <br><br><input type="submit" class="btn btn-danger" value="Удалить">
                </form>
            </div>
        </div>

    </div>




@endsection('info')
