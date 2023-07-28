@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <form action="{{ route('counterparty.store') }}" method="POST">
        @csrf
        <label for="txtCounterparty">Введите наименование контрагента</label>
        <input name="counterparty" id="txtCounterparty" class="form-control @error('counterparty') is-invalid @enderror">
        @error('counterparty')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
        <input type="submit" class="btn btn-primary" value="Сохранить">
        <a class="btn btn-info" href="/sokar">Назад</a>
    </form>

    @forelse(\App\Models\Counterparty::orderby('name')->get() as $value)
        @if ($loop->first)
            <table class="table table-bordered table-sm">
                <thead>
                <th>Наименование</th>
                </thead>
                <tbody>
        @endif
        <tr><td><a href="counterparty/{{$value->id}}"> {{$value->name}}</a></td></tr>


        @if($loop->last)
                </tbody>
            </table>
        @endif

    @empty
        <p>Пока не внесено ни одного контрагента</p>
    @endforelse
@endsection('info')

