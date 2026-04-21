@extends('layouts.base')
@section('title', 'Роли пользователя')

@section('info')
    <div class="container">
        <form action="{{route('roles.user.store')}}" method="post">
            @csrf
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 col-xxl-4 p-2">
                <label for="selectUser">Выберите пользователя</label>
                <select name="user" id="selectUser"
                        class="form-select @error('user') is-invalid @enderror">
                    <option value=""></option>
                    @forelse($users as $id => $user)
                        <option
                            value="{{$user->id}}"> {{$user->Registration->last_name ?? ''}}{{mb_substr($user->Registration->first_name, 0, 1)}}{{mb_substr($user->Registration->middle_name, 0, 1)}}
                            - ({{$user->id}})
                        </option>
                    @empty
                        <option value=""> Заполните справочник</option>
                    @endforelse
                </select>
                @error('user')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div class="mt-2" id="role_check">
                </div>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>

@endsection('info')
@section('script')
    <script>
        const roles = {!! $roles !!};
        const users = {!! $users !!};
        const selectUser = document.getElementById('selectUser');
        const role_check_div = document.getElementById('role_check');
        selectUser.addEventListener('change', () => {
            role_check_div.innerHTML = ''
            for (let key in users) {

                if (users[key]['id'] == selectUser.value && users[key]['roles'] !== null) {
                    let roles_id = [];

                    for (let roles_user in users[key]['roles']) {

                        roles_id.push(users[key]['roles'][roles_user]['id'])

                    }

                    if (roles_id.length !== 0) {

                        for (let role in roles) {

                            let name_role = '';
                            if (roles[role][0]['description'] !== null) {
                                name_role = roles[role][0]['description']
                            } else {
                                name_role = roles[role][0]['name']
                            }

                            if (roles_id.includes(roles[role][0]['id'])) {

                                role_check_div.innerHTML +=
                                    "<div class='form-switch form-check mb-3' id='div_role_" + roles[role][0]['id'] + "'>" +
                                    "<label id='label-access-check' class='form-label' for='role_" + roles[role][0]['id'] + "'>" + name_role + "</label>" +
                                    "<input class='form-check-input'" +
                                    "type='checkbox'" +
                                    "checked = 'true'" +
                                    "id='role_" + roles[role][0]['id'] + "'" +
                                    "value='"+ roles[role][0]['id'] + "'" +
                                    "name='role[]'>"+
                                    "</div>"
                            } else {
                                role_check_div.innerHTML +=
                                    "<div class='form-switch form-check mb-3' id='div_role_" + roles[role][0]['id'] + "'>" +
                                    "<label id='label-access-check' class='form-label' for='role_" + roles[role][0]['id'] + "'>" + name_role + "</label>" +
                                    "<input class='form-check-input'" +
                                    "type='checkbox'" +
                                    "id='role_" + roles[role][0]['id'] + "'" +
                                    "value='"+ roles[role][0]['id'] + "'" +
                                    "name='role[]'>" +
                                    "</div>"
                            }
                        }

                    }
                }
            }
        });

    </script>
@endsection('script')
