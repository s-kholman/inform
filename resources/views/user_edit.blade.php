@extends('layouts.base')
@section('title', 'Пользователь')

@section('info')
    <div class="container">
        @if($user)
        <div class="col-3">
            <label class="col-form-label">{{$user->last_name}}</label>
        </div>
            <div class="col-3">
                <label class="col-form-label">{{$user->first_name}}</label>
            </div>
            <div class="col-3">
                <label class="col-form-label">{{$user->middle_name}}</label>
            </div>
            <div class="col-3">
                <label class="col-form-label">{{$user->phone}}</label>
            </div>
            <div class="col-3">
                <label class="col-form-label">{{\App\Models\post::where('id', $user->post_id)->value('name')}}</label>
            </div>
            <div class="col-3">
                <label class="col-form-label">{{\App\Models\filial::where('id', $user->filial_id)->value('name')}}</label>
            </div>
        @else
            <div class="col-3">
                <label class="col-form-label">Данные отсутствуют</label>
            </div>
        @endif
       <div class="row">
            <div class="col-2">
                <a class="btn btn-info" href="/activation">Назад</a>
            </div>
            <div class="col-3">
                <form action="{{ route('user.edit', ['id' => $user->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-success" value="Редактировать">
                </form>
            </div>
            <div class="col-3">
                <form action="{{ route('user.activation', ['id' => $user->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger" value="Активировать">
                </form>
            </div>
       </div>
    </div>
@endsection('info')
