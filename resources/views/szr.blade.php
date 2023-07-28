@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <form action="{{ route('szr.store') }}" method="POST">
        @csrf
        <label for="txtSZR">Введите наименование СЗР</label>
        <input name="szr" id="txtSZR" class="form-control @error('szr') is-invalid @enderror">
        @error('szr')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
        <input type="submit" class="btn btn-primary" value="Сохранить">
        <a class="btn btn-info" href="/szr">Назад</a>
    </form>

    @forelse(\App\Models\Szr::orderby('name')->get() as $value)
        @if ($loop->first)
            <table class="table table-bordered table-sm">
                <thead>
                <th>Наименование</th>
                </thead>
                <tbody>
        @endif
        <tr><td><a href="szr/{{$value->id}}"> {{$value->name}}</a></td></tr>


        @if($loop->last)
                </tbody>
            </table>
        @endif

    @empty
        <p>Пока не внесено ни одного препарата</p>
    @endforelse
@endsection('info')

