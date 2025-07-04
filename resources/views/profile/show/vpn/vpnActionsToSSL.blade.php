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
                Генерация сертификата и настройка под W10 (Новый за 30 дней до окончания)
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
                Генерация сертификата и настройка под W7 (Новый за 30 дней до окончания)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="exampleRadios" id="settingDelete" value="SettingsDestroy">
            <label class="form-check-label" for="settingDelete">
                Удалить настройки (сертификат не отзывается)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="exampleRadios" id="sslrevoke" value="SslRevoke">
            <label class="form-check-label" for="sslrevoke">
                Отозвать сертификат
            </label>
        </div>
        <div class="mt-2">
            <button id="btnCreate" class="btn btn-success" type="submit">Сгенерировать и отправить</button>
        </div>
    </div>
</div>
