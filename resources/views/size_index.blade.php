@extends('layouts.base')
@section('title',$const['title'])

@section('info')
    <div class="col-3">
            <form action="{{ route($const['route'].'.store') }}" method="POST">
                @csrf
                    <label for="txt">{{$const['label']}}</label>
                    <input name="{{$const['error']}}" id="txt" class="form-control @error($const['error']) is-invalid @enderror">
                @error($const['error'])
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <select name="kultura" id="txtKultura" class="form-select @error('kultura') is-invalid @enderror">
                    <option value="">Выберите культуру</option>
                    @foreach(\App\Models\Kultura::where('id', 1)->orwhere('id', 6)->get() as $item)
                        <option value="{{ $item->id }}">  {{ $item->name }} </option>
                    @endforeach
                </select>
                @error('kultura')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>
    </div>
    @forelse($value as $value)
        {{ $value->kultura->name }} - {{$value->name}} <br>
    @empty
    @endforelse
@endsection('info')
