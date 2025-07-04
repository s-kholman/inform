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
