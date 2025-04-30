@extends('layouts.base')
@section('title', 'Права для ролей')
<style>
    .rotate {
        writing-mode: vertical-rl;
        -moz-transform: scale(-1, -1);
        -webkit-transform: scale(-1, -1);
        -o-transform: scale(-1, -1);
        -ms-transform: scale(-1, -1);
        transform: scale(-1, -1);
        height: 350px;
    }

    .vertical-align {
        vertical-align: middle;
    }
</style>
@section('info')
    <div class="container">
        <form action="{{route('roles.update.admin')}}" method="POST">
            @csrf
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>№</th>
                    <th>ФИО</th>
                    @forelse($roles as $role)
                        @if($role->name <> 'name' && $role->name <> 'user_id')
                            <th class="vertical-align"><label class="rotate">{{$role->name}}</label></th>
                        @endif
                    @empty
                    @endforelse
                </tr>
                </thead>
                <tbody>
                @forelse($roles_user as $user_id => $value )
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{$value['name']}}
                        </td>
                        @forelse($value as $role => $checked)
                            @if($role <> 'name' && $role <> 'user_id')
                                <td>
                                    <input
                                        type="checkbox"
                                        value="{{$user_id.'_'.$roles->where('name', $role)->value('id')}}"
                                        @if($role == 'super-user')
                                        onclick="return false;"
                                        @endif
                                        {{--name="{{$user_id.'_'.$roles->where('name', $role)->value('id')}}"--}}
                                        name="role[]"
                                        @if($checked) checked @endif>
                                </td>
                            @endif
                        @empty
                        @endforelse
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
            <input type="submit" value="Обновить">
        </form>

    </div>

@endsection('info')


