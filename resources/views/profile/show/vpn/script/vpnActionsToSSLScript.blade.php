<script>
    const id = {!! $profile->user_id !!};
    const btnCreate = document.getElementById('btnCreate')
    const statusLabel = document.getElementById('status')
    const timerLabel = document.getElementById('timer')
    const scriptW10 = document.getElementById('scriptW10')
    const W10 = document.getElementById('W10')
    const W7 = document.getElementById('W7')
    const ssl_revoke = document.getElementById('sslrevoke')
    const settingDelete = document.getElementById('settingDelete')
    const url = window.location.origin
    const checkFactory = document.getElementsByClassName('form-check-input');

    let factory = 'CreateAccessVpnWindowsTen'

    function checked() {
        for (let x = 0; x <= checkFactory.length; x++){
            try {
                if(checkFactory[x].checked){
                    factory = checkFactory[x].value;
                }
            } catch (e){
            }
        }
    }

    settingDelete.addEventListener('click', () => {
        checked()
        btnCreate.className = ('btn btn-danger');
        btnCreate.textContent = 'Удалить'
    })

    ssl_revoke.addEventListener('click', () => {
        checked()
        btnCreate.className = ('btn btn-danger');
        btnCreate.textContent = 'Отозвать сертификат'
    })

    btnCreate.addEventListener('click', () => {
        sslGet()
    })

    W10.addEventListener('click', () =>{
        checked();
        btnCreate.className = ('btn btn-success');
        btnCreate.textContent = 'Сгенерировать и отправить'
    })

    scriptW10.addEventListener('click', () =>{
        checked();
        btnCreate.className = ('btn btn-success');
        btnCreate.textContent = 'Сгенерировать и отправить'
    })
    W7.addEventListener('click', () =>{
        checked();
        btnCreate.className = ('btn btn-success');
        btnCreate.textContent = 'Сгенерировать и отправить'
    })


    async function sslGet() {
        try {
            btnCreate.disabled = true;
            statusLabel.textContent = 'Запрос данных, ожидайте'
            let formData = new FormData
            formData.append('id', id)
            formData.append('factory', factory)
            const response = await fetch(url + '/api/v1/ike',
                {
                    method: 'POST',
                    headers:
                        {
                            "Accept": "application/json",
                        },
                    body: formData,
                })
            const data = await response.json()

            if (data['message'] == 'SSL sign') {
                statusLabel.textContent = 'Генерация и настройка пользователя. Ожидайте смены статуса'
                setTimeout(sslGet, 60000)
                timer();
            } else {
                statusLabel.textContent = data['message']
                btnCreate.disabled = false;
            }

        } catch (error) {
        }
    }
    let time = 59;

    function timer()
    {
        const timer = setInterval(() => {
            timerLabel.textContent = ' ..' + time--
        }, 1000)

        setTimeout(() => {
            timerLabel.textContent = ''
            time = 60
            clearInterval(timer)
        }, (60000))
    }

</script>
