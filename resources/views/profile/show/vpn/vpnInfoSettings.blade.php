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
