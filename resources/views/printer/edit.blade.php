@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
<div class="container">
    <form action="{{ route($const['route'].'.update', [$const['route'] => $value->id]) }}" method="POST">
    <div class="row">

    <div class="col-3">

            @csrf
            @method('PATCH')
            <label for="txt">{{$const['label']}}</label>
            <input value="{{$value->name}}" name="name" id="txt" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="txtSelect">{{$const['parent']}}</label>
            <select name="select" id="txtSelect" class="form-select @error('select') is-invalid @enderror">
                <option value="">Выберите значение</option>
                @foreach($parent_value as $item)

                    @if ($item->id == $value->$name_id)
                        <option selected value="{{ $item->id }}">  {{ $item->name }} </option>

                    @else
                        <option value="{{ $item->id }}">  {{ $item->name }} </option>
                    @endif

                @endforeach
            </select>
            @error('select')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <input type="submit" class="btn btn-primary" value="Сохранить">

        <a class="btn btn-info" href="/{{$const['route']}}">Назад</a>
    </div>

        <div class="col-9">

            @forelse(\App\Models\MibOid::all() as $item)
                <div class="row">
                        <div class="col-2">
                            <input {{ in_array($item->id, old('genre', $value->miboid->pluck('id')->toArray())) ? 'checked' : '' }}
                            type="checkbox" name="midoid[]" value="{{$item->id}}">
                        </div>
                        <div class="col-4">{{$item->name}}</div>
                        <div class="col-6">{{$item->comment}}</div>

                </div>
            @empty

            @endforelse
        </div>

</div>

    </form>
</div>

    <form action="{{ route($const['route'].'.destroy', [$const['route'] => $value->id])}}" method="POST">
        @csrf
        @method('DELETE')
        <br><br><input type="submit" class="btn btn-danger" value="Удалить">
    </form>

@endsection('info')


