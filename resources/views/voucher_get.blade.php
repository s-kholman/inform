@extends('layouts.base')
@section('title', 'Доступ к сети KRiMM_INTERNET')

@section('info')
    <br class="container">
        @auth
            <div class="col-3">
                <form action="{{ route('voucher.get') }}" method="post">
                    @csrf
                    <label>Телефон</label>
                    <input class="form-control" type="text" name="phone" readonly value="{{\App\Models\Registration::where('user_id', auth()->user()->id)->value('phone')}}">
                    <label>E-Mail</label>
                    <input class="form-control" type="text" name="email" readonly value="{{auth()->user()->email}}">
                    <div class="row">
                        <div class="col-6">
                            <label>Период (дней)</label>
                            <input class="form-control @error('voucherDay') is-invalid @enderror" type="text" name="voucherDay" value="2">
                            @error('voucherDay')
                            <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label>Кол-во паролей</label>
                            <select name="voucherCount" class="form-select">
                                <option value="1">1</option>

                            </select>
                        </div>
                    </div>
                    <label>Коментарий</label>
                    <input class="form-control @error('comment') is-invalid @enderror" type="text" name="comment" value="{{ old('comment') }}">
                    @error('comment')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                    <button class="form-control" type="submit" name="saveLimit">Получить</button>
                </form>
            </div>
            <p><b>Коды:</b></p></br>
            @forelse(\App\Models\Voucher::where('phone', \App\Models\Registration::where('user_id', auth()->user()->id)->value('phone'))->get() as $value)

               <p> {{Str::substrReplace($value->voucher_code, '-',5,0)}} --- {{$value->voucher_day}}</p></br>
            @empty
                <p>Неиспользованных кодов не обнаруженно</p>
            @endforelse
        @endauth

        @guest
                <div class=" bg-light border rounded-3 p-3">
                    <p>Доступно только после регистрации пользователя</p>
                </div>
        @endguest
    </div>




@endsection('info')
