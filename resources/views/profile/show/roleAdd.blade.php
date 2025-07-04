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
