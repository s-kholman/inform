@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
            <form action="{{ route('box.sampling') }}" method="POST">
                @csrf
<div>
    <b>{{\App\Models\StorageName::where('id', $id)->value('name')}}</b>
</div>
                <input hidden name="id" value="{{$id}}">

                <label for="txt50">Фракция 50</label>
                <input name="f50" id="txt50" class="form-control @error('f50') is-invalid @enderror">
                @error('f50')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <label for="txt40">Фракция 40-50</label>
                <input name="f40" id="txt40" class="form-control ">

                <label for="txt30">Фракция 30-40</label>
                <input name="f30" id="txt30" class="form-control ">

                <label for="txtNotStandart">Не стандарт</label>
                <input name="notStandart" id="txtNotStandart" class="form-control ">

                <label for="txtWaste">Отход</label>
                <input name="waste" id="txtWaste" class="form-control ">

                <label for="txtland">Земля</label>
                <input name="land" id="txtland" class="form-control ">

                <label for="txtdecline">Естественная убыль</label>
                <input name="declaine" id="txtdecline" class="form-control ">

                <label for="txtcomment">Коментарий</label>
                <input name="comment" id="txtcomment" class="form-control ">



                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>


@endsection('info')
