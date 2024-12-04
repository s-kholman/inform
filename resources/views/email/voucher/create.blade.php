
На сайте {{ config('app.name') }}<br>

Получен ваучер на номер: {{$phone}}<br>

@if(!empty($registration))
    {{$registration['last_name']}}
@endif

