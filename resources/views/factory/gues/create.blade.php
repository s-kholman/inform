@extends('layouts.base')
@section('title', 'Поступление сырья на завод')

@section('info')
    <div class="container gx-4">
    <form action="{{route('factory.gues.store', ['factory' => $factory[0]->id])}}" method="post">
        @csrf



            <div class="row">
                <div class="col-4 p-2">
                    <label for="volume">Объем</label>
                    <input placeholder="Введите поступивший объем"
                           class="form-control @error('volume') is-invalid @enderror"
                           value="{{$factory[0]->gues->volume ?? ''}}{{old('volume')}}"
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
                <div class="col-4 p-2">
                    <label for="mechanical">Механические повреждение</label>
                    <input placeholder="Введите %"
                           class="form-control @error('mechanical') is-invalid @enderror"
                           value="{{$factory[0]->gues->mechanical ?? ''}}{{old('mechanical')}}"
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
                <div class="col-4 p-2">
                    <label for="land">Камни, земля</label>
                    <input placeholder="Введите %"
                           class="form-control @error('land') is-invalid @enderror"
                           value="{{$factory[0]->gues->land ?? ''}}{{old('land')}}"
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
                <div class="col-4 p-2">
                    <label for="haulm">Ботва</label>
                    <input placeholder="Введите %"
                           class="form-control @error('haulm') is-invalid @enderror"
                           value="{{$factory[0]->gues->haulm ?? ''}}{{old('haulm')}}"
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
                <div class="col-4 p-2">
                    <label for="rot">Гниль</label>
                    <input placeholder="Введите %"
                           class="form-control @error('rot') is-invalid @enderror"
                           value="{{$factory[0]->gues->rot ?? ''}}{{old('rot')}}"
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
                <div class="col-2 form-check form-switch">
                    <label for="foreign_object">Инородные предметы</label>
                    <input class="form-check-input" type="checkbox" @if($factory[0]->gues->foreign_object ?? false) checked @endif id="foreign_object" name="foreign_object">
                </div>
                <div class="col-2 form-check form-switch">
                    <label for="another_variety">Пересортица</label>
                    <input class="form-check-input" type="checkbox" @if($factory[0]->gues->another_variety ?? false) checked @endif  id="another_variety" name="another_variety">
                </div>
            </div>

            <div class="row">
                <div class="col-4 p-2">
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-4 p-2">
                    <label for="less_thirty">до 35</label>
                    <input placeholder="Введите %"
                           class="form-control @error('less_thirty') is-invalid @enderror"
                           value="{{$factory[0]->gues->less_thirty ?? ''}}{{old('less_thirty')}}"
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
                <div class="col-4 p-2">
                    <label for="thirty">35-45</label>
                    <input placeholder="Введите %"
                           class="form-control @error('thirty') is-invalid @enderror"
                           value="{{$factory[0]->gues->thirty ?? ''}}{{old('thirty')}}"
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
                <div class="col-4 p-2">
                    <label for="forty">45-55</label>
                    <input placeholder="Введите %"
                           class="form-control @error('forty') is-invalid @enderror"
                           value="{{$factory[0]->gues->forty ?? ''}}{{old('forty')}}"
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
                <div class="col-4 p-2">
                    <label for="fifty">55-65</label>
                    <input placeholder="Введите %"
                           class="form-control @error('fifty') is-invalid @enderror"
                           value="{{$factory[0]->gues->fifty ?? ''}}{{old('fifty')}}"
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
                <div class="col-4 p-2">
                    <label for="sixty">65</label>
                    <input placeholder="Введите %"
                           class="form-control @error('sixty') is-invalid @enderror"
                           value="{{$factory[0]->gues->sixty ?? ''}}{{old('sixty')}}"
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
                <div class="col-4 p-2">
                    <hr>
                </div>
            </div>

            <input hidden name="factory_material_id" value="{{$factory[0]->id}}">

            <div class="row">
                <div class="col-2 p-2 ">
                    <a class="btn btn-primary" href="/factory/material">Назад</a>
                </div>
                <div class="col-2 p-2 text-end">
                    <input class="btn btn-primary" type="submit" value="Сохранить" name="save">
                </div>
            </div>
    </form>
        <div class="row">
            <div class="col-4 text-center">
                <form action="{{route('material.destroy', ['material' => $factory[0]->id])}}" method="post">
                    @csrf
                    @method('DELETE')
                    <br><br><input type="submit" class="btn btn-danger" value="Удалить">
                </form>
            </div>
        </div>

    </div>




@endsection('info')
