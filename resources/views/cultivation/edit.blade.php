@extends('layouts.base')
@section('title', 'Справочник')

@section('info')

    <div class="col-3">
        <form action="/cultivation/{{$cultivation->id}}" method="POST">
            @csrf
            @method('PATCH')
            <label for="cultivation">Введите название культуры</label>
            <input value="{{$cultivation->name}}" name="cultivation" id="cultivation" class="form-control @error('cultivation') is-invalid @enderror">
            @error('cultivation')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="sowing_type_id">Выберите тип посева</label>
            <select name="sowing_type" id="sowing_type_id" class="form-select @error('sowing_type') is-invalid @enderror">
                <option value="">Выберите значение</option>
                @foreach(\App\Models\SowingType::all() as $item)
                    @if ($item->id == $cultivation->sowing_type_id)
                        <option selected value="{{ $item->id }}">  {{ $item->name }} </option>
                    @else
                        <option value="{{ $item->id }}">  {{ $item->name }} </option>
                    @endif

                @endforeach
            </select>
            @error('sowing_type')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="color">Выберите цвет заполнения ячейки в отчете</label>
            <input type="color" value="{{$cultivation->color}}" name="color" id="color" class="form-control form-control-color @error('color') is-invalid @enderror">
            @error('color')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <input type="submit" class="btn btn-primary" value="Сохранить">
        </form>
    </div>

    <a class="btn btn-info" href="/cultivation/">Назад</a>


    <form action="{{ route('cultivation.destroy', ['cultivation' => $cultivation])}}" method="POST">
        @csrf
        @method('DELETE')
        <br><br><input type="submit" class="btn btn-danger" value="Удалить">
    </form>

@endsection('info')


