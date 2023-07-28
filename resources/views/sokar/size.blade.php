@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <form action="{{ route('size.store') }}" method="POST">
        @csrf
        <label for="txtSize">Введите размер одежды</label>
        <input name="size" id="txtSize" class="form-control @error('size') is-invalid @enderror">
        @error('size')
        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
        <select name="size_type" class="form-control">
            @foreach($size_type as $item)
            <option value="{{$item['type']}}">{{$item['name']}}</option>
            @endforeach
        </select>
        <input type="submit" class="btn btn-primary" value="Сохранить">
        <a class="btn btn-info" href="/sokar">Назад</a>
    </form>
    <table class="table table-bordered table-sm">
        <thead>
        <th></th>
        </thead>
        <tbody>
    @foreach($size_type as $item)
        <tr><td> {{$item['name']}}</td></tr>

        @forelse(\App\Models\Size::where('size_type', $item['type'])->orderby('name')->get() as $value)
        @if ($loop->first)

                @endif
        <tr><td><a href="size/{{$value->id}}"> {{$value->name}}</a></td></tr>


        @if($loop->last)

        @endif

    @empty
            <tr><td> Пока не внесено ни одного размера</td></tr>
    @endforelse
    @endforeach
        </tbody>
    </table>
@endsection('info')

