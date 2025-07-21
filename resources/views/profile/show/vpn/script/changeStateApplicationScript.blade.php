<script>

    const applicationIdentification = {!! !empty($application[0]->identification) ?? json_encode($application[0]->identification) !!};
    const applicationNameId = {!! !empty($application[0]->identification) ?? json_encode($application[0]->application_name_id) !!};
    const authorId = {!! \Illuminate\Support\Facades\Auth::user()->id !!};
    const change = document.getElementById('change')
    const applicationStatusId = document.getElementById('applicationStatus')
    const statusApplication = document.getElementById('statusApplication')

    change.addEventListener('click', () => {
        //console.log(applicationNameId);

        changeStatus()
    })


    async function changeStatus() {
        try {
            change.disabled = true;
            //statusLabel.textContent = 'Запрос данных, ожидайте'
            let formData = new FormData
            formData.append('id', authorId)
            formData.append('applicationStatusId', applicationStatusId.value)
            formData.append('identification', applicationIdentification)
            formData.append('applicationNameId', applicationNameId)
            const response = await fetch(url + '/api/v1/change/state/application',
                {
                    method: 'POST',
                    headers:
                        {
                            "Accept": "application/json",
                        },
                    body: formData,
                })
            const data = await response.json()

            if (data['message'] == 'Ok') {
                statusApplication.textContent = 'Ответ получен'
                change.disabled = false;
                //setTimeout(sslGet, 60000)
                //timer();
            } else {
                statusApplication.textContent = data['message']
                change.disabled = false;
            }

        } catch (error) {
        }
    }
</script>
