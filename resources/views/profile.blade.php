@extends('layouts.base')
@section('title', 'Главная')

@section('info')

    @auth
        <form method="POST" action="{{route('profile.store')}}">
            @csrf
            <div class="container">
                @if ($user_reg && $user_reg->activation && $user_reg->infoFull)
                    <div class="row mb-3 bg-light border rounded-3 p-3 text-center ">

                        <p>Ваша учетная запись подтвержденна</p>

                    </div>
                @elseif($user_reg && $user_reg->infoFull && !$user_reg->activation)
                    <div class="bg-light border rounded-3 p-3 text-center">
                        <p>Данные находятся на подтверждении администратора</p>
                    </div>

                @elseif($user_reg && !$user_reg->infoFull && !$user_reg->activation)
                    <div class="bg-light border rounded-3 p-3 text-center">
                        <p>Администратор отправил данные на уточнение</p>
                    </div>
                @elseif(!$user_reg)
                    <div class="bg-light border rounded-3 p-3 text-center">
                        <p>Обязательно заполните и сохраните данные. Указывайте только достоверные данные</p>
                        <p>Это позволит администратору подвердить Вашу учетную запись как сотрудника ООО "Агрофирма
                            "КРиММ"</p>
                    </div>

                @endif
                <div class="row mb-3">
                    <label for="last_name" class="col-md-4 col-form-label text-md-end">Фамилия</label>
                    <div class="col-md-6">
                        <input id="last_name" type="text" name="last_name" autofocus
                               class="form-control @error('last_name') is-invalid @enderror"
                               @if(($user_reg && $user_reg->activation && $user_reg->infoFull) or ($user_reg && $user_reg->infoFull && !$user_reg->activation))
                               readonly value="{{$user_reg->last_name}}"
                               @elseif($user_reg && !$user_reg->infoFull && !$user_reg->activation)
                               value="{{$user_reg->last_name}}"
                               @else
                               value="{{ old('last_name') }}"
                            @endif>

                        @error('last_name')
                        <span class="invalid-feedback"><strong>{{$message}}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="first_name" class="col-md-4 col-form-label text-md-end">Имя</label>

                    <div class="col-md-6">
                        <input id="first_name" type="text"
                               class="form-control @error('last_name') is-invalid @enderror" name="first_name"
                               @if(($user_reg && $user_reg->activation && $user_reg->infoFull) or ($user_reg && $user_reg->infoFull && !$user_reg->activation))
                                   readonly value="{{$user_reg->first_name}}"
                               @elseif($user_reg && !$user_reg->infoFull && !$user_reg->activation)
                                   value="{{$user_reg->first_name}}"
                                @else
                                    value="{{ old('first_name') }}"

                            @endif>
                        @error('first_name')
                        <span class="invalid-feedback"><strong>{{$message}}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="middle_name" class="col-md-4 col-form-label text-md-end">Отчество</label>

                    <div class="col-md-6">
                        <input id="middle_name" type="text" class="form-control"
                               name="middle_name"
                               @if(($user_reg && $user_reg->activation && $user_reg->infoFull) or ($user_reg && $user_reg->infoFull && !$user_reg->activation))
                               readonly value="{{$user_reg->middle_name}}"
                               @elseif($user_reg && !$user_reg->infoFull && !$user_reg->activation)
                               value="{{$user_reg->middle_name}}"
                        @else
                               value="{{ old('middle_name') }}"
                            @endif>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="phone" class="col-md-4 col-form-label text-md-end">Телефон</label>

                    <div class="col-md-6">
                        <input id="phone"  type="text" placeholder="+7"
                               class="form-control @error('phone') is-invalid @enderror" name="phone"
                               @if(($user_reg && $user_reg->activation && $user_reg->infoFull) or ($user_reg && $user_reg->infoFull && !$user_reg->activation))
                               readonly value="{{$user_reg->phone}}"
                               @elseif($user_reg && !$user_reg->infoFull && !$user_reg->activation)
                               value="{{$user_reg->phone}}"
                               @else
                               value="{{ old('phone') }}"
                            @endif>
                        @error('phone')
                        <span class="invalid-feedback"><strong>{{$message}}</strong></span>

                        @enderror
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="filial_name" class="col-md-4 col-form-label text-md-end">Подразделение</label>

                    <div class="col-md-6">
                        @if((!$user_reg) or ($user_reg && !$user_reg->infoFull && !$user_reg->activation) )
                            <select for="filial_name" class="form-select @error('filial_name') is-invalid @enderror"
                                    name="filial_name">
                                <option value="0">-=Выберите подразделение=-</option>
                                @foreach(\App\Models\filial::all() as $value)
                                    @if($user_reg == true AND $user_reg->filial_id == $value->id)
                                        <option selected value="{{$value->id}}">{{$value->name}}</option>
                                    @else
                                        <option
                                            {{ old('filial_name') == $value->id ? "selected" : "" }} value="{{$value->id}}">{{$value->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('filial_name')
                            <span class="invalid-feedback"><strong>{{$message}}</strong></span>
                            @enderror
                        @else
                            <input id="filial_name" type="text" readonly class="form-control" name="filial_name"
                                   value="{{\App\Models\filial::where('id',$user_reg->filial_id)->value('name')}}">
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="post_name" class="col-md-4 col-form-label text-md-end">Должность</label>

                    <div class="col-md-6">
                        @if((!$user_reg) or ($user_reg && !$user_reg->infoFull && !$user_reg->activation))
                            <select for="post_name" class="form-select @error('post_name') is-invalid @enderror"
                                    name="post_name">
                                <option value="0">-=Выберите должность=-</option>
                                @foreach(\App\Models\Post::all() as $value)
                                    @if($user_reg == true AND $user_reg->post_id == $value->id)
                                        <option selected value="{{$value->id}}">{{$value->name}}</option>
                                    @else
                                        <option
                                            {{ old('post_name') == $value->id ? "selected" : "" }} value="{{$value->id}}">{{$value->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('post_name')
                            <span class="invalid-feedback"><strong>{{$message}}</strong></span>
                            @enderror
                        @else

                            <input id="post_name" type="text" readonly class="form-control" name="post_name"
                                   value="{{\App\Models\Post::where('id',$user_reg->post_id)->value('name')}}">

                        @endif
                    </div>
                </div>
                @if((!$user_reg) or ($user_reg && !$user_reg->infoFull && !$user_reg->activation))
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <input type="submit" class="btn btn-primary" value="Сохранить">
                        </div>
                    </div>
                @else
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a class="btn btn-primary" href="{{route('/')}}">Вернуться</a>
                        </div>
                    </div>
                @endif
            </div>
        </form>
    @endauth
    @guest
        <div class="bg-light border rounded-3 p-3">
            <h2>Выполните вход или пройдите регистрацию</h2>
        </div>
    @endguest
@endsection('info')
