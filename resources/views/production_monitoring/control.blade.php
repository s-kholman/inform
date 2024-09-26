@extends('layouts.base')

@section('title', 'Внести мониторинг хранения')

@section('info')
    <div class="container">
        <div class="col-xl-6 col-lg-12 col-sm-12">
            <form action="{{ route('monitoring.store') }}" method="POST">
                @csrf
                <label name="storage_name" for="storage">Бокс</label>
                <input name="storage" hidden value="{{$storage_model->id}}">
                <input class="form-control"
                       name="storage_name"
                       id="storage_name"
                       value="{{$storage_model->name}}">


                    <label for="txtDate">Дата контроля</label>
                    <input name="date" id="txtDate" type="date" value="{{old('date') == '' ? date('Y-m-d') : old('date')}}"
                           class="form-control @error('date') is-invalid @enderror">
                    @error('date')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror


                <fieldset style="border: 2px solid #ffcaca; margin: 5px; padding: 10px" class="rounded-4">
                    <legend>Контроль за исполнением</legend>
                    <fieldset style="border: 2px solid #ffe2e2; margin: 5px; padding: 10px" class="rounded-4 DIRECTOR">
                        <legend>Руководитель</legend>

                        <div class="mb-3">
                            <label for="control_manager">Комментарий</label>
                            <input name="control_manager"
                                   id="control_manager"
                                   value="{{old('controlManager')}}"
                                   class="form-control @error('control_manager') is-invalid @enderror">
                            @error('control_manager')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </fieldset >
                    <fieldset style="border: 2px solid #ffe2e2; margin: 5px; padding: 10px;" class="rounded-4 DEPUTY">
                        <legend>Заместитель генерального</legend>
                        <div class="mb-3">
                            <label for="control_director">Комментарий</label>
                            <input name="control_director"
                                   id="control_director"
                                   value="{{old('control_director')}}"
                                   class="form-control @error('control_director') is-invalid @enderror">
                            @error('control_director')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </fieldset>
                </fieldset>



                <input type="submit" class="btn btn-primary" value="Сохранить">

                <a class="btn btn-info" href="/monitoring">Назад</a>
            </form>
        </div>
    </div>
@endsection('info')
@section('script')
<script>
    let post_name = {!! json_encode($post_name) !!};
    let post_arr = ['DIRECTOR', 'DEPUTY', 'TEMPERATURE'];

   for (let i = 0; i <= post_arr.length-1; i++) {
       console.log(post_name + '   ' +  post_arr[i])
       if (post_name != '"'+post_arr[i]+'"') {
           document.querySelectorAll('.'+post_arr[i]).forEach(element => element.remove());
       }
   }
</script>
@endsection('script')
