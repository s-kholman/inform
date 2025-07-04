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
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="vpn-add-tab" data-bs-toggle="tab" data-bs-target="#vpn-add-tab-pane" type="button" role="tab" aria-controls="vpn-add-tab-pane" aria-selected="false">VPN Доступ</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">

            @include('profile.show.user')

            @include('profile.show.roleShow')

            @include('profile.show.roleAdd')

            @include('profile.show.vpn.vpn')

        </div>
    </div>
@endsection('info')
@section('script')

    @include('profile.show.vpn.script.vpnActionsToSSLScript')
    @include('profile.show.vpn.script.changeStateApplicationScript')

@endsection('script')
