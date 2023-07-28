@extends('layouts.base')
@section('title', 'Справочник')

@section('info')


                @csrf
                <div class="bg-light border rounded-3 p-3">
                <h2>У вас нет прав!!!</h2>
                </div>

@endsection('info')
