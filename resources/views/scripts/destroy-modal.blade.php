{{--
Библиотека взята https://github.com/lofcz/sweetalert2-neutral
Оригинальная версия из страны 404, поёт свой гимн и выбрасывает банеры,
было принято решение использовать статический js

Использование:
1. В используем в <form class="delete-message">
2. В параметр "data-route" тега <form> передаем роутер на удаление
3. В методе Destroy контроллера, возвращаем true или respons как пример ниже
//return response()->json(['status'=>true,"redirect_url"=>url('watering/show', ['filial_id' => $watering->filial_id, 'pole_id' => $watering->pole_id])]);
4. В blade подключаем скрипт
@section('script')
    @include('scripts\destroy-modal')
@endsection
--}}
<script
    src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous">
</script>
<script src="/scripts/sweetalert2/js/sweetalert2.all.js"></script>
<script type="text/javascript">

    $(".delete-message").on("submit", function (e) {
        e.preventDefault();
        let button = $(this)
        Swal.fire({
            icon: "warning",
            title: "Вы уверены?",
            text: "Удаление не возможно отменить.",
            showCancelButton: true,
            cancelButtonText: "Отменить",
            confirmButtonText: "Удалить!",
            confirmButtonColor: '#d33',
            cancelButtonColor: '#168060',

        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: button.data("route"),
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": "DELETE"
                    },
                    success: function (response, textStatus, xhr) {
                        //window.location.reload();
                        window.location = response.redirect_url;
                    },

                   /* error: function (){

                        window.location.reload();
                    }*/

                })
            }
        })
    })
</script>
