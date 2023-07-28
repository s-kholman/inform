@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <div class="col-3">
            <form enctype="multipart/form-data" action="{{ route('pole.add') }}" method="POST">

                @csrf
                    <label for="txtpole">Введите название поля</label>
                    <input name="pole" id="txtTitle" class="form-control @error('pole') is-invalid @enderror">
                @error('pole')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtcheckpoliv">Данное поле находится под поливом ---></label>
                <input type="checkbox" name="checkPoliv" id="checkPoliv" class="form-check-input">

                <label for="txtFilial">Выберите филиал</label>
                <select name="filial" id="selectFilial" class="form-select @error('filial') is-invalid @enderror">
                    <option value="">Выберите филиал</option>

                        @forelse(\App\Models\filial::all() as $filial)
                            <option value="{{ $filial->id }}"> {{ $filial->name }} </option>
                        @empty
                            <option value="0"> Филиал(ы) не найдены </option>
                        @endforelse
                </select>
                @error('filial')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtpole">Выберите изображение поля</label>
                <input class="form-control form-select @error('image') is-invalid @enderror" type="file" name="image" placeholder="Выбрать изображение" id="image">
                @error('image')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>
    </div>

            <table class="table table-bordered">

                @forelse(\App\Models\Pole::distinct('filial_id')->get() as $filial)
                    <th colspan="2" class="text-center">{{\App\Models\filial::where('id',$filial->filial_id)->value('name')}}</th>


                    @foreach(\App\Models\Pole::where('filial_id',$filial->filial_id)->orderby('name')->get() as $value)
                        <tr><td>{{$value->name}}</td><td><a href="/pole_edit/{{$value->id}}">Редактирование</a></td></tr>
                    @endforeach
                @empty
                @endforelse




            </table>
@endsection('info')
