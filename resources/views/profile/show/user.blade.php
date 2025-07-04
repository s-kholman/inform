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
