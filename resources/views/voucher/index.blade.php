@extends('layouts.base')
@section('title', 'Ваучеры для доступа к WiFi')

@section('info')
<div class="container">

    <div class="card  col-sm-5 text-center">
        <div class="card-header">
            Доступ к WiFi-сети <b>KRiMM_INTERNET</b>
        </div>
        <div class="card-body">
            <h5 class="card-title">Текущие ключи:</h5>
            <div class="card-text" id="voucher-get-info"></div>
            <div>
                <button disabled id="voucher-get-btn" class="btn btn-primary mt-4" type="submit">Получить ключ</button>
            </div>
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
        const voucherDivInfo = document.getElementById('voucher-get-info')
        const voucherGetBtn = document.getElementById('voucher-get-btn')
        const url = window.location.origin
        const phone = {!! json_decode($phone) !!};
        let voucherChildInfo = document.createElement('label')
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
                const response = await fetch(url + '/api/v1/voucher/get',
                    {
                        method: 'post',
                        headers:
                            {
                                "Accept": "application/json",
                            },
                    })
                if(!response.ok){
                   throw response.statusText
                }
                const data = await response.json()
                let show = ''
                if (data['data'].length > 0) {
                    for (let voucher in data['data']) {
                        show +=
                            '<b>'+data['data'][voucher]['code'].substr(0, 5) + '-' + data['data'][voucher]['code'].substr(4, 5)+'</b>'
                            + ' - доступ на ' + dayToStr(data['data'][voucher]['duration'])
                            + '<br>'
                    }
                    voucherChildInfo.innerHTML = show
                    voucherDivInfo.appendChild(voucherChildInfo);
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
                // voucherChildInfo.innerHTML = 'Ошибка получение данных: ' + error
                // voucherDivInfo.appendChild(voucherChildInfo)
                voucherGetBtn.disabled = true;
            }
        }

        async function voucherCreate(){
            if(phone !== null){
                try{
                    let formData = new FormData
                    formData.append('phone', '+' + phone)

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
