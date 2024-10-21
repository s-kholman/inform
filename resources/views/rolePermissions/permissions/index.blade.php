@extends('layouts.base')
@section('title', 'Права для ролей')

@section('info')
<div class="container">
    <form action="{{route('permissions.role.add')}}" method="post">
        @csrf
        <div class="col-sm-4 mt-4">
            <label class="form-check-label" for="role">
                Роли
            </label>
            <select name="role" class="form-select" aria-label="Все роли" id="role">
                <option value="0">Выберите роль</option>
                @forelse(\Spatie\Permission\Models\Role::all() as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                @empty
                @endforelse
            </select>
        </div>
        <div class="col-sm-4 mt-2">
            @forelse(\App\Models\PermissionName::all() as $permission)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{$permission->name}}" name="permissions[]" id="{{$permission->name}}">
                    <label class="form-check-label" for="{{$permission->name}}">
                        {{$permission->translate_ru}}
                    </label>
                </div>
            @empty
            @endforelse
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>

@endsection('info')
@section('script')
    <script>
        const role = document.getElementById('role')
        const url = window.location.origin
        const checkeds = document.querySelectorAll('.form-check-input')

        role.addEventListener('change', () => {

            checkeds.forEach((element) =>{
                element.checked = false
            })

            if(role.value !== '0'){
                getPermissions(role.value)
            }

        })

        async function getPermissions(id)
        {
            const responce = await fetch(url + '/api/v1/permission/' + id, {
                headers: {"Accept": "application/json",},
                method: 'GET',})
            const data = await responce.json()
            if(data['data'].length > 0){
                for (const permission in data['data']){
                    document.getElementById(data['data'][permission]['name'].slice(data['data'][permission]['name'].lastIndexOf('.')+1)).checked = true;
                    console.log()
                }
            }
        }

    </script>
@endsection()

