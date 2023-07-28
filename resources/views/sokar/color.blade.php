@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <form action="{{ route('color.store') }}" method="POST">
        @csrf
        <label for="txtColor">Введите цвет одежды</label>
        <input name="color" id="txtColor" class="form-control @error('color') is-invalid @enderror">
        @error('color')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
        <input type="submit" class="btn btn-primary" value="Сохранить">
        <a class="btn btn-info" href="/sokar">Назад</a>
    </form>

    @forelse(\App\Models\Color::orderby('name')->get() as $value)
        @if ($loop->first)
            <table class="table table-bordered table-sm">
                <thead>
                <th>Наименование</th>
                </thead>
                <tbody>
        @endif
        <tr><td><a href="color/{{$value->id}}"> {{$value->name}}</a></td></tr>


        @if($loop->last)
                </tbody>
            </table>
        @endif

    @empty
        <p>Пока не внесено ни одного цвета</p>
    @endforelse
@endsection('info')

