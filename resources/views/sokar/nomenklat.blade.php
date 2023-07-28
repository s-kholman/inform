@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <form action="{{ route('sokarnomenklat.store') }}" method="POST">
        @csrf
        <label for="txtNomenklat">Введите наименование</label>
        <input name="nomenklat" id="txtNomenklat" class="form-control @error('nomenklat') is-invalid @enderror">
        @error('nomenklat')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror



        <input type="submit" class="btn btn-primary" value="Сохранить">
        <a class="btn btn-info" href="/sokar">Назад</a>
    </form>

    @forelse(\App\Models\SokarNomenklat::orderby('name')->get() as $value)
        @if ($loop->first)
            <table class="table table-bordered table-sm">
                <thead>
                <th>Наименование</th>
                </thead>
                <tbody>
                @endif
                <tr><td><a href="size/{{$value->id}}"> {{$value->name}}</a></td></tr>


                @if($loop->last)
                </tbody>
            </table>
        @endif

    @empty
        <p>Пока не внесено ни одного размера</p>
    @endforelse
@endsection('info')

