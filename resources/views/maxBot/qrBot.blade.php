@if(empty(\Illuminate\Support\Facades\Auth::user()->registration->MaxBotUser->status_bot) || !\Illuminate\Support\Facades\Auth::user()->registration->MaxBotUser->status_bot)
<div class="row mb-4">
    <div class="col inform-max-bot">
        Для получения оповещений о событиях данного раздела в мессенджере MAX. Необходимо быть зарегистрированным пользователем на сайте https://infotm.krimm.ru с подтвержденной учетной записью<br />
        Далее необходимо перейти по ссылке <a target="_blank" href="https://max.ru/id7226003278_bot">Оповещения в MAX</a>, либо нажать на кнопку <button id="showQrModalBtn" class="qr-pulse-button">Оповещение в MAX</button> для показа QR-кода,
        который необходимо отсканировать на вашем устройстве. <br />В чате бота, необходимо нажать кнопку "Начать" чтобы разрешить боту отправлять сообщения.
        Если это первый запуск бота необходимо дополнительно нажать кнопку "Отправить свой номер" для сопоставления вашей учетной записи на сайте с чатом в MAX.
        Если что-то не работает или вы не получаете сообщения обратитесь к администратору сайта.
    </div>
</div>
@endif
