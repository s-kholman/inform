@extends('layouts.base')
@section('title', 'Печать ваучеров')

@section('info')
<div class="container">
    <form action="{{route('voucher.generate.pdf')}}" method="post">
        @csrf
        <label for="voucher_group">Выберите группу ваучеров</label>
        <select name="voucher_group" id="voucher_group" class="form-select @error('voucher_group') is-invalid @enderror">
            @forelse($voucher as $name => $r)
                <option value="{{$name}}">{{$name}}</option>
            @empty
                <option value="">Ваучеры не найдены</option>
            @endforelse
        </select>
        @error('voucher_group')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input style="margin: 10px" type="submit" class="btn btn-primary" value="Сгенерировать PDF">
    </form>
</div>

@endsection('info')

