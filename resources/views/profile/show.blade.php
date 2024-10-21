@extends('layouts.base')
@section('title', 'Профиль пользователя')

@section('info')
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="user-tab" data-bs-toggle="tab" data-bs-target="#user-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Пользователь</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="roles-user-tab" data-bs-toggle="tab" data-bs-target="#roles-user-tab-pane" type="button" role="tab" aria-controls="roles-user-tab-pane" aria-selected="false">Роли пользователя</button>
            </li>
           <li class="nav-item" role="presentation">
                <button class="nav-link" id="roles-add-tab" data-bs-toggle="tab" data-bs-target="#roles-add-tab-pane" type="button" role="tab" aria-controls="roles-add-tab-pane" aria-selected="false">Добавить роль</button>
            </li>
            {{-- <li class="nav-item" role="presentation">
                <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false" disabled>Disabled</button>
            </li>--}}
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="user-tab-pane" role="tabpanel" aria-labelledby="user-tab" tabindex="0">
                @if($profile)
                    <div class="mb-3 row">
                        <label for="lastName" class="col-sm-2 col-form-label">Фамилия</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="lastName" value="{{$profile->last_name}}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="firstName" class="col-sm-2 col-form-label">Имя</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="firstName" value="{{$profile->first_name}}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="middleName" class="col-sm-2 col-form-label">Отчество</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="middleName" value="{{$profile->middle_name}}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="phone" class="col-sm-2 col-form-label">Телефон</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="phone" value="{{$profile->phone}}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="filial" class="col-sm-2 col-form-label">Филиал</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="filial" value="{{$profile->filial->name}}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="filial" class="col-sm-2 col-form-label">Должность</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="filial" value="{{$profile->Post->name}}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="post" class="col-sm-2 col-form-label">Эл. адрес</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="post" value="{{$profile->User->email}}">
                        </div>
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

                </div>
            </div>
            <div class="tab-pane fade" id="roles-user-tab-pane" role="tabpanel" aria-labelledby="roles-user-tab" tabindex="0">
                <form action="{{route('user.role.destroy', ['registration' => $profile])}}" method="post">
                @csrf
                <div class="mb-3 row">
                    <label for="role" class="col-sm-2 col-form-label">Роли</label>
                    <div class="col-sm-6">
                        <select name="role" class="form-select" aria-label="Роли пользователя" id="role">
                            @forelse($profile->user->getRolenames() as $key => $role)
                            <option id="{{$key}}">{{$role}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="mb-3 row col-sm-2">
                        <input class="form-control btn btn-danger" type="submit" value="Удалить">
                </div>
                </form>
            </div>
            <div class="tab-pane fade" id="roles-add-tab-pane" role="tabpanel" aria-labelledby="roles-add-tab" tabindex="0">
                <form action="{{route('user.role.add', ['registration' => $profile])}}" method="post">
                    @csrf
                <div class="mb-3 row">
                    <label for="role" class="col-sm-3 col-form-label">Добавить роль</label>
                    <div class="col-sm-6">
                        <select name="role" class="form-select" aria-label="Все роли" id="role">
                            @forelse($rolesUser as $role)
                                <option id="{{$role->id}}">{{$role->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="mb-3 row col-sm-3">
                    <input class="form-control btn btn-secondary" type="submit" value="Добавить роль">
                </div>
                </form>
            </div>
            {{--<div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div>--}}
        </div>

    </div>
@endsection('info')
