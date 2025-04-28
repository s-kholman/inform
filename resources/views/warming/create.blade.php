@extends('layouts.base')
@section('title', 'Внесите данные о прогреве семян')

@section('info')

    <div class="col-6">
        <form action="{{ route('warming.store') }}" method="POST">
            @csrf

            <label for="storage_name_id">Выберите места хранения</label>
            <select name="storage_name_id" id="storage_name_id" class="form-select @error('storage_name_id') is-invalid @enderror">
                <option value=""></option>
                @forelse($storage_name as $storage)
                    <option {{old('storage_name_id') == $storage->id ? "selected" : ""}} value="{{$storage->id}}">{{$storage->name}}</option>
                @empty
                    <option value=""> Места хранения не найдены</option>
                @endforelse
            </select>
            @error('storage_name_id')
            <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
            </span>
            @enderror

            <label for="volume">Объем</label>
            <input type="number" name="volume" id="volume" value="{{old('volume')}}" class="form-control @error('volume') is-invalid @enderror">
            @error('volume')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="sowing_date">Дата посадки</label>
            <input name="sowing_date" id="sowing_date" type="date" value="{{old('sowing_date') == "" ? date('Y-m-d') : old('sowing_date') }}"
                   class="form-control @error('sowing_date') is-invalid @enderror">
            @error('sowing_date')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="warming_date">Дата прогрева</label>
            <input name="warming_date" id="warming_date" type="date" value="{{old('warming_date') == "" ? date('Y-m-d') : old('warming_date') }}"
                   class="form-control @error('warming_date') is-invalid @enderror">
            @error('warming_date')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="comment">Комментарий</label>
            <input name="comment" id="comment" value="{{old('comment')}}" class="form-control @error('comment') is-invalid @enderror">
            @error('comment')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="comment_agronomist">Контроль агроном</label>
            <input name="comment_agronomist" id="comment_agronomist" value="{{old('comment_agronomist')}}" class="form-control @error('comment_agronomist') is-invalid @enderror">
            @error('comment_agronomist')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="comment_deputy_director">Контроль зам.дир.</label>
            <input name="comment_deputy_director" id="comment_deputy_director" value="{{old('comment_deputy_director')}}" class="form-control @error('comment_deputy_director') is-invalid @enderror">
            @error('comment_deputy_director')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div class="row m-4">
                <div class="col-4">
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                </div>
                <div class="col-8">
                    <a class="btn btn-outline-success"
                       href="/warming">К списку прогрева</a>
                </div>
            </div>

        </form>

    </div>
@endsection('info')
