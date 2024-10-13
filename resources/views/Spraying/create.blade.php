@extends('layouts.base')
@section('title', 'Опрыскивание полей')

@section('info')
    <div class="container">
        <div class="col-xl-6 col-lg-12 col-sm-12">
            <p>Если поля не найдены, необходимо внести в справочник <a href="/pole">"Поле"</a> - севооборот</p>
            <form action="{{ route('spraying.store') }}" method="POST">
                @csrf

                <input name="today" type="date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" hidden>

                <label for="selectFirst">Выберите поле</label>
                <select name="pole" id="selectFirst" class="form-select @error('pole') is-invalid @enderror">
                    <option value="0"></option>

                    @forelse($poles as $name => $pole)
                        <option value="{{ $pole[0]->pole_id }}"> {{ $name }} </option>
                    @empty
                        <option value=""> Поля не найдены</option>
                    @endforelse
                </select>
                @error('pole')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="selectSecond">Выберите культуру</label>
                <select name="kultura" id="selectSecond" disabled class="form-select @error('kultura') is-invalid @enderror">
                    <option value="0">Выберите культуру</option>
                </select>
                @error('kultura')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtDate">Дата</label>
                <input name="date" id="txtDate" type="date" value="{{old('date') ? old('date') : date('Y-m-d')}}"
                       class="form-control @error('date') is-invalid @enderror">
                @error('date')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror


                <div class="row">
                    <div class=" col-6">
                        <label for="txtSzrClasses">Выберите тип СЗР</label>
                        <select name="szrClasses" id="szrClasses"
                                class="form-select @error('szrClasses') is-invalid @enderror">
                            <option value="0"></option>
                            @forelse($szrClasses as $value)
                                <option value="{{ $value->id }}"> {{ $value->name }} </option>
                            @empty
                                <option value="0"> Справочник пуст</option>
                            @endforelse
                        </select>
                        @error('szrClasses')
                        <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class=" col-6">
                        <label for="selectSzr">Выберите СЗР</label>
                        <select name="szr" id="selectSzr" disabled class="form-select @error('szr') is-invalid @enderror">

                        </select>
                        @error('szr')
                        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                        @enderror
                    </div>
                </div>
                <label for="dosage">Дозировка</label>
                <input type="number" step="0.001" disabled="true" name="dosage" id="dosage"
                       class="form-control @error('txtdosage') is-invalid @enderror">
                @error('txtdosage')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="volume">Объем</label>
                <input readonly name="volume" id="volume" class="form-control @error('volume') is-invalid @enderror">
                @error('volume')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="txtcomment">Комментарий</label>
                <input name="comment" id="txtComment" class="form-control @error('comment') is-invalid @enderror">
                @error('comment')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input type="submit" class="btn btn-primary" value="Сохранить">

                <a class="btn btn-info" href="/spraying">Назад</a>
            </form>
        </div>
    </div>
@endsection('info')
@section('script')
    <script>
        const url = window.location.origin;
        let nomenklature = ''
        let squareValue;
        let selectSzr = document.getElementById('selectSzr');
        let selectSecond = document.getElementById('selectSecond');
        let szrClasses = document.getElementById('szrClasses');
        let selectFirst = document.getElementById('selectFirst');
        let dosage = document.getElementById('dosage')
        let volume = document.getElementById('volume')

        function dosageEnable() {
            volume.value = '';
            dosage.value = '';
            if (this.value > 0) {
                dosage.disabled = false;
                for (let squareGet in nomenklature['data']) {
                    if(nomenklature['data'][squareGet]['id'] === Number(this.value)) {
                        squareValue = nomenklature['data'][squareGet]['square']
                        break
                    }
                }
            } else {
                dosage.disabled = true;
            }
        }

        function dosageSum() {
            if (dosage.value.length > 0) {
               volume.value = parseFloat((dosage.value * squareValue).toFixed(3));
            } else {
               volume.value = '';
            }
        }

        async function szrName() {
            const response = await fetch(url+'/api/v1/szr/'+szrClasses.value, {
                headers: {"Accept": "application/json",},
                method: 'GET',})
            const data = await response.json()
            selectSzr.innerHTML = ""
            if(data['data'].length > 0) {
                let option = '<option value="0">Выберите СЗР</option>';
                for (let szr in data['data']) {
                    option += `<option value="${data['data'][szr]['id']}">${data['data'][szr]['name']}</option>`
                }
                selectSzr.innerHTML = option;
                selectSzr.disabled = false
            } else {
                selectSzr.disabled = true
            }
        }

        async function selectReproduction() {
            selectSecond.innerHTML = ''
            dosage.disabled = true;
            volume.value = '';
            dosage.value = '';
            const response = await fetch(url+'/api/v1/sevooborot/'+selectFirst.value, {
                headers: {"Accept": "application/json",},
                method: 'GET',})
            nomenklature = await response.json()
            if(nomenklature['data'].length > 0) {
                let option = '<option value="0">Выберите культуру</option>';
                for (let id in nomenklature['data']) {
                    option += `<option value="${nomenklature['data'][id]['id']}">
                                        ${nomenklature['data'][id]['nomenklature']}
                                        (${nomenklature['data'][id]['square']} Га)
                                </option>`
                }
                selectSecond.innerHTML = option;
                selectSecond.disabled = false
            } else {
                selectSecond.disabled = true
            }
        }

        szrClasses.addEventListener('change', szrName);
        selectSecond.addEventListener('change', dosageEnable);
        selectFirst.addEventListener('change', selectReproduction);
        dosage.addEventListener('input', dosageSum);
    </script>
@endsection('script')
