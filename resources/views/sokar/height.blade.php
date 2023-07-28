@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <form action="{{ route('height.store') }}" method="POST">
        @csrf
        <label for="txtHeight">Введите размеры</label>
        <input name="height" id="txtHeight" class="form-control @error('height') is-invalid @enderror">
        @error('height')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
        <input type="submit" class="btn btn-primary" value="Сохранить">
        <a class="btn btn-info" href="/sokar">Назад</a>
    </form>

    @forelse(\App\Models\Height::orderby('name')->get() as $value)
        @if ($loop->first)
            <table class="table table-bordered table-sm">
                <thead>
                <th>Наименование</th>
                </thead>
                <tbody>
        @endif
        <tr><td><a href="height/{{$value->id}}"> {{$value->name}}</a></td></tr>


        @if($loop->last)
                </tbody>
            </table>
        @endif

    @empty
        <p>Пока не внесено ни одного размера</p>
    @endforelse
@endsection('info')

