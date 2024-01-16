@extends('layouts.base')
@section('title','Справочник - Тип посева')

@section('info')
    <div class="container">
        <form action="{{ route('type.store')}}" method="POST">
        <div class="row">
            <div class="col-3">
                    @csrf
                    <label for="txt">Наименование</label>
                    <input name="name" id="txt" class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                     </span>
                    @enderror
            </div>
        </div>


            <div class="form-check">
                <input class="form-check-input @error('name') is-invalid @enderror" name="no_machine" type="checkbox" id="check_machine">
                <label class="form-check-label" for="check_machine">
                    Указывать технику в отчете?
                </label>
                @error('name')
                <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                     </span>
                @enderror
            </div>

            <div class="row p-3">
                <div class="col-2">
                    <input type="submit" class="btn btn-success" value="Сохранить">
                </div>
                <div class="col-1">
                    <a class="btn btn-primary" href="/">Назад</a>
                </div>
            </div>
        </form>



                @forelse(\App\Models\SowingType::all() as $value)
            <div class="row">
                    <div class="col-3"><a href="/sowing/type/{{$value->id}}">{{$value->name}}</a></div>
                    <div class="col-3">
                        <input disabled class="form-check-input" type="checkbox" {{$value->no_machine ? '' : 'checked'}}>
                    </div>
            </div>
                @empty
                @endforelse



    </div>



@endsection('info')
