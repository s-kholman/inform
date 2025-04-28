@extends('layouts.base')
@section('title', 'Изменение данных о прогреве семян')

@section('info')

    <div class="col-6">
        <form action="{{ route('warming.update', ['warming' => $warming->id]) }}" method="POST">
            @csrf
            @method('PATCH')
            <label for="storage_name_id">Выберите места хранения</label>
            <select readonly name="storage_name_id" id="storage_name_id" class="form-select @error('storage_name_id') is-invalid @enderror">
                <option selected value="{{$warming->storage_name_id}}">{{\App\Models\StorageName::query()->where('id', $warming->storage_name_id)->value('name')}}</option>
            </select>
            @error('storage_name_id')
            <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
            </span>
            @enderror

            <label for="volume">Объем</label>
            <input type="number" name="volume" id="volume" value="{{$warming->volume}}" class="form-control @error('volume') is-invalid @enderror">
            @error('volume')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="sowing_date">Дата посадки</label>
            <input name="sowing_date" id="sowing_date" type="date" value="{{$warming->sowing_date}}"
                   class="form-control @error('sowing_date') is-invalid @enderror">
            @error('sowing_date')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="warming_date">Дата прогрева</label>
            <input name="warming_date" id="warming_date" type="date" value="{{$warming->warming_date}}"
                   class="form-control @error('warming_date') is-invalid @enderror">
            @error('warming_date')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="comment">Комментарий</label>
            <input name="comment" id="comment" value="{{$warming->comment}}" class="form-control @error('comment') is-invalid @enderror">
            @error('comment')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="comment_agronomist">Контроль агроном</label>
            <input name="comment_agronomist" id="comment_agronomist" class="form-control @error('comment_agronomist') is-invalid @enderror">
            @error('comment_agronomist')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="comment_deputy_director">Контроль зам.дир.</label>
            <input name="comment_deputy_director" id="comment_deputy_director" class="form-control @error('comment_deputy_director') is-invalid @enderror">
            @error('comment_deputy_director')
            <span class="invalid-feedback">
                    <strong>{{ $message->collection }}</strong>
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
