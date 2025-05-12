@extends('layouts.base')
@section('title', 'Ваучеры для доступа к WiFi')

@section('info')
<div class="container">

    <div class="card  col-sm-12 text-center">
        <div class="card-header">
            Доступ к WiFi-сети <b>KRiMM_INTERNET</b>
        </div>
        <div class="card-body">
            <h5 class="card-title">Текущие ключи:</h5>
            <div class="card-text" id="voucher-get-info"></div>
            <div class="row col-sm mt-2">
                <div class="col-sm-5 mt-auto ">
                    <button disabled id="voucher-get-btn" class="btn btn-primary" type="submit">Получить ключ</button>
                 </div>
                <div class="col-sm-3 col-xl-3 text-center">
                    <label for="day">Кол-во дней</label>
                    <input class="form-control" type="number" id="day" placeholder="дней" min="1" max="365" step="1" value="365">
                </div>

            </div>
            @can('Voucher.user.create')
                <div class="row col-sm mt-2">
                    <div class="col-sm-5 mt-auto">
                        <button id="sms-send-btn" class="btn btn-primary" type="submit">отправить по SMS</button>
                    </div>
                    <div class="col-sm-4 col-xl-4 text-center">
                        <label for="phone-send">Телефон</label>
                        <input class="form-control" id="phone-send" placeholder="+7">
                    </div>
                    <div class="col-sm-2 col-xl-2 text-center mt-auto " id="send-status">

                    </div>
                </div>
                <div class="row col-sm mt-2">
                        <div class="col-sm-5 mt-auto">
                            <form method="get" action="voucher/print">
                                <button id="sms-send-btn" class="btn btn-primary" type="submit">Распечатать ваучеры</button>
                            </form>
                        </div>
                </div>
            @endcan
        </div>
        <div class="card-footer text-muted">
            <p>Получить ключ можно в обратном SMS:<p><br/>
                Отправив SMS с текстом <br /><b>WiFi <i>365</i></b><br />
                на номер +79956919830,
                где число можно заменить от 1 до 365 <br />дней доступа <br />

        </div>
    </div>
    <div>

        <div id="voucher-get-info"></div>
    </div>

    <div>

    </div>
</div>

@endsection('info')
@section('script')
    <script>
        const intlDayToStr = new Intl.PluralRules('ru-RU')
        const dayInput = document.getElementById('day')
        const voucherDivInfo = document.getElementById('voucher-get-info')
        const voucherGetBtn = document.getElementById('voucher-get-btn')
        const smsSendBtn = document.getElementById('sms-send-btn')
        const sendStatus = document.getElementById('send-status')
        const url = window.location.origin
        const phone = {!! json_decode($phone) !!};
        let checkSmsSend = ''
        let voucherChildInfo = document.createElement('div')
        let checkInfo = '';
        voucherChildInfo.textContent = 'Запрос к серверу...';
        voucherDivInfo.appendChild(voucherChildInfo);

        voucherGetBtn.addEventListener('click', () => {
            voucherGetBtn.disabled = true;
            voucherGetInfo()
        })

        setTimeout(voucherGetInfo,100)

        const update = setInterval(voucherGetInfo, 15000)

        setTimeout(() => {
            clearInterval(update)
        }, (60 * 1000 * 5))

        async function voucherGetInfo() {
            try {
                let formData = new FormData
                formData.append('phone', phone)
                const response = await fetch(url + '/api/v1/voucher/get',
                    {
                        method: 'post',
                        headers:
                            {
                                "Accept": "application/json",
                            },
                        body: formData,
                    })
                if(!response.ok){
                   throw response.statusText
                }
                const data = await response.json()
                let show = ''
                if (data['data'].length > 0) {
                    for (let voucher in data['data']) {
                        show +=
                            '<div class="row">' +
                            '<div class="col-10">' +
                            '<b>'+data['data'][voucher]['code'].substr(0, 5) + '-' + data['data'][voucher]['code'].substr(5, 10)+'</b>'
                            + ' - доступ на ' + dayToStr(data['data'][voucher]['duration'])
                            + '</div>'
                            + '<div class="col-2 form-switch form-check mb-3">'
                            + '<input class="form-check-input sms-send-check" type="checkbox" value="'+dayToStr(data['data'][voucher]['duration'])+'" id="'+ data['data'][voucher]['code']+'">'
                            + '</div>'
                            + '</div>'

                    }
                    if(checkInfo !== show){
                        checkInfo = show
                        voucherChildInfo.innerHTML = show
                        voucherDivInfo.appendChild(voucherChildInfo);
                    }


                } else {
                    voucherChildInfo.innerHTML = 'Ключи не найдены'
                    voucherDivInfo.appendChild(voucherChildInfo)
                    voucherGetBtn.disabled = false;
                }
                if (data['data'].length <= 2) {
                    voucherGetBtn.disabled = false;
                } else {
                    voucherGetBtn.disabled = true;
                }
        } catch (error)  {
                voucherGetBtn.disabled = true;
            }
        }

       /*async function smsSend() {
           checkSmsSend = document.querySelectorAll('.sms-send-check')

           let phone = document.getElementById('phone-send').value

           phone = phone.replace(/[^0-9+]/g, '');

           const formatPhone = /^\+7\d{10}/

           if(formatPhone.test(phone) && checkSmsSend != null){
               for (let x=0;  x <= checkSmsSend.length; x++) {
                   try {
                       if(checkSmsSend[x].checked){
                           try{
                               let formData = new FormData
                               formData.append('phone', phone)
                               formData.append('code', checkSmsSend[x].id.substr(0, 5)+ '-' +checkSmsSend[x].id.substr(5))
                               formData.append('day', checkSmsSend[x].value)

                               const response = await  fetch(url + '/api/v1/cabinetVoucherSmsSend',
                                   {
                                       method: 'POST',
                                       headers:
                                           {
                                               "Accept": "application/json",
                                           },
                                       body: formData,
                                   })
                               const data = await response.json()
                               sendStatus.innerText = data.message
                           } catch (error) {

                           }
                       }
                   } catch (e){
                   }
               }
           } else {
               sendStatus.innerText = 'Проверьте телефон и выбранный пароль'
           }

        }*/

        async function smsSend() {

           let phone = document.getElementById('phone-send').value
           let isDay = (x, a, b) => a <= x && x <= b;

           //phone = phone.replace(/[^0-9+]/g, '');
           phone = '+' + phone.replace(/\D/g, '');

           const formatPhone = /^\+7\d{10}$/

           if(formatPhone.test(phone) && isDay(dayInput.value, 1, 365)){

                           try{
                               let formData = new FormData
                               formData.append('phone', phone)
                               formData.append('day', dayInput.value)

                               const response = await  fetch(url + '/api/v1/cabinetVoucherGetToSend',
                                   {
                                       method: 'POST',
                                       headers:
                                           {
                                               "Accept": "application/json",
                                           },
                                       body: formData,
                                   })
                               const data = await response.json()
                               sendStatus.innerText = data.message
                           } catch (error) {

                           }
           } else {
               sendStatus.innerText = 'Проверьте телефон и количество дней'
           }

        }

        async function voucherCreate(){
            const day = Math.ceil(dayInput.value)
            if(phone !== null && +day >= 1 && +day <= 365){
                try{
                    let formData = new FormData
                    formData.append('phone', '+' + phone)
                    formData.append('day', '+' + day)

                    await fetch(url + '/api/v1/voucher/create',
                        {
                            method: 'POST',
                            headers:
                                {
                                    "Accept": "application/json",
                                },
                            body: formData,
                        })

                } catch (error) {
                    voucherChildInfo.innerHTML = 'Ошибка запроса: ' + error
                    voucherDivInfo.appendChild(voucherChildInfo)
                    voucherGetBtn.disabled = true;
                }
                setTimeout(voucherGetInfo,100)
            }
        }

        voucherGetBtn.addEventListener('click', voucherCreate)
        smsSendBtn.addEventListener('click', smsSend)

        function dayToStr(day)
        {
            let convert = day / 24 / 60
            switch (intlDayToStr.select(convert)){
                case 'many':
                    return convert + ' дней'
                case 'one':
                    return convert + ' день'
                case 'few':
                    return convert + ' дня'
            }
        }
    </script>
@endsection('script')
