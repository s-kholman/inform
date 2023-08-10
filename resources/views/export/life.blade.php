<p>Заглушка</p>


@foreach(\App\Models\Life::all() as $value)
    {{$value->id}}
@endforeach
