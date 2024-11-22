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

            <div class="tab-pane fade" id="vpn-add-tab-pane" role="tabpanel" aria-labelledby="vpn-add-tab" tabindex="0">
                <div>
                    <form action="{{route('vpn.store')}}" method="post">
                        @csrf
                        <input hidden name="id" value="{{$profile->id}}">
                        <div class="col-sm-6">
                            <label for="ip" class="col-sm-6 col-form-label">IP пользователя</label>
                            <input id="ip"
                                   class="form-control"
                                   type="text"
                                   name="ip_domain"
                                   placeholder="IP адрес"
                                   value="{{$profile->vpnInfo->ip_domain ?? ''}}">
                        </div>
                        <div class="col-sm-6">
                            <label for="login_domain" class="col-sm-12 col-form-label">Доменное имя пользователя</label>
                            <input class="form-control"
                                   id="login_domain"
                                   type="text"
                                   name="login_domain"
                                   placeholder="Доменное имя"
                                   value="{{$profile->vpnInfo->login_domain ?? ''}}">
                        </div>
                        <div class="col-sm-6">
                            <label for="mail_send" class="col-sm-12 col-form-label">Email получения данных</label>
                            <input class="form-control"
                                   id="mail_send"
                                   type="text"
                                   name="mail_send"
                                   placeholder="Email получения данных"
                                   value="{{$profile->vpnInfo->mail_send ?? $profile->user->email}}">
                        </div>

                        <div class="mt-2">
                            <button class="btn btn-secondary" type="submit">Сохранить</button>
                        </div>
                    </form>

                        <div class="card mt-4">
                            <input hidden name="userID" value="{{$profile->user_id}}">
                            <h5 class="card-header">Отправить пользователю данные VPN</h5>
                            <div class="card-body">
                                <h5 class="card-title">Текущие настройки</h5>
                                <p class="card-text">
                                    <label>IP - {{$profile->vpnInfo->ip_domain ?? 'отсутствует'}}</label><br/>
                                    <label id="status"></label> <label id="timer"></label>
                                </p>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="W10" value="CreateAccessVpnWindowsTen" checked>
                                    <label class="form-check-label" for="W10">
                                        Настройки под W10
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="scriptW10" value="ScriptWindowsTen">
                                    <label class="form-check-label" for="scriptW10">
                                        Генерация и отправка только скрипта W10
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="W7" value="CreateAccessVpnWindowsSeven">
                                    <label class="form-check-label" for="W7">
                                        Настройки под W7
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="settingDelete" value="SettingsDestroy">
                                    <label class="form-check-label" for="settingDelete">
                                        Удалить настройки (сертификат не отзывается)
                                    </label>
                                </div>
                                <div class="mt-2">
                                    <button id="btnCreate" class="btn btn-success" type="submit">Сгенерировать и отправить</button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection('info')
@section('script')
    <script>
        const id = {!! $profile->user_id !!};
        const btnCreate = document.getElementById('btnCreate')
        const statusLabel = document.getElementById('status')
        const timerLabel = document.getElementById('timer')
        const scriptW10 = document.getElementById('scriptW10')
        const W10 = document.getElementById('W10')
        const W7 = document.getElementById('W7')
        const settingDelete = document.getElementById('settingDelete')
        const url = window.location.origin
        const checkFactory = document.getElementsByClassName('form-check-input');

        let factory = 'CreateAccessVpnWindowsTen'

        function checked() {
            for (let x = 0; x <= checkFactory.length; x++){
                try {
                    if(checkFactory[x].checked){
                        factory = checkFactory[x].value;
                    }
                } catch (e){
                }
            }
        }

        settingDelete.addEventListener('click', () => {
            checked()
            btnCreate.className = ('btn btn-danger');
            btnCreate.textContent = 'Удалить'
        })

        btnCreate.addEventListener('click', () => {
            sslGet()
        })

        W10.addEventListener('click', () =>{
            checked();
            btnCreate.className = ('btn btn-success');
            btnCreate.textContent = 'Сгенерировать и отправить'
        })

        scriptW10.addEventListener('click', () =>{
            checked();
            btnCreate.className = ('btn btn-success');
            btnCreate.textContent = 'Сгенерировать и отправить'
        })
        W7.addEventListener('click', () =>{
            checked();
            btnCreate.className = ('btn btn-success');
            btnCreate.textContent = 'Сгенерировать и отправить'
        })


        async function sslGet() {
            try {
                btnCreate.disabled = true;
                statusLabel.textContent = 'Запрос данных, ожидайте'
                let formData = new FormData
                formData.append('id', id)
                formData.append('factory', factory)
                const response = await fetch(url + '/api/v1/ike',
                    {
                        method: 'POST',
                        headers:
                            {
                                "Accept": "application/json",
                            },
                        body: formData,
                    })
                const data = await response.json()

                if (data['message'] == 'SSL sign') {
                    statusLabel.textContent = 'Генерация и настройка пользователя. Ожидайте смены статуса'
                    setTimeout(sslGet, 60000)
                    timer();
                } else {
                    statusLabel.textContent = data['message']
                    btnCreate.disabled = false;
                }

            } catch (error) {
            }
        }
let time = 59;

        function timer()
        {
            const timer = setInterval(() => {
                timerLabel.textContent = ' ..' + time--
            }, 1000)

            setTimeout(() => {
                timerLabel.textContent = ''
                time = 60
                clearInterval(timer)
            }, (60000))
        }

    </script>
@endsection('script')
