@extends('layouts.base')
@section('title', 'Ввод наименования контроля объектов')

@section('info')
    <div class="container">
        <form action="{{route('object.control.name.store')}}" method="POST">
            @csrf

            <div class="d-flex align-items-center justify-content-center">
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-6 col-xxl-6 text-center">
                    <label for="txtName">Наименование контроля</label>
                    <input name="name" id="txtName" class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="row mt-2 d-flex align-items-center justify-content-center">
                <div class="row justify-content-center text-center">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-2 col-xxl-2">
                        <label for="dateSelect">Выберите филиал</label>
                        <select name="filial" id="selectFilial"
                                class="form-select @error('filial') is-invalid @enderror">
                            <option value=""></option>
                            @forelse($filials as $filial)
                                <option value="{{$filial->id}}"> {{ $filial->name }} </option>
                            @empty
                                <option value=""> Заполните справочник</option>
                            @endforelse
                        </select>
                        @error('filial')
                        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                        @enderror
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-2 col-xxl-2">
                        <label for="selectPole">Выберите поле</label>
                        <select disabled name="pole" id="selectPole" class="form-select">
                        </select>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-2 col-xxl-2">
                        <label for="selectType">Тип контроля</label>
                        <select name="selectObjectControlType" id="selectType"
                                class="form-select @error('selectObjectControlType') is-invalid @enderror">
                            <option value=""></option>
                            @forelse($objectType as $type)
                                <option value="{{$type->id}}"> {{ $type->name }} </option>
                            @empty
                                <option value=""> Заполните справочник</option>
                            @endforelse
                        </select>
                        @error('selectObjectControlType')
                        <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                        @enderror
                    </div>
                    <div class=" justify-content-center row p-4">
                        <div class="col-xs-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-xxl-2">
                            <input type="submit" class="btn btn-primary" value="Сохранить">
                        </div>
                    </div>
                </div>
        </form>
    </div>



    </div>


@endsection('info')
@section('script')
    <script>

        const filial = {!! $filials !!};
        const selectFilial = document.getElementById('selectFilial')
        const selectPole = document.getElementById('selectPole');
        const selectType = document.getElementById('selectType');

        selectFilial.addEventListener('change', () => {
            if (selectFilial.value > 0) {
                selectType.selectedIndex = 0
                for (let key in filial) {

                    if (selectFilial.value == filial[key]['id'] && filial[key]['pole'].length !== 0) {
                        selectPole.disabled = false
                        selectPole.textContent = ''

                        selectPole.add(new Option('', ''))

                        for (let pole_id in filial[key]['pole']) {
                            selectPole.add(new Option(filial[key]['pole'][pole_id]['name'], filial[key]['pole'][pole_id]['id']))
                        }
                    }
                }

            } else {
                selectPole.disabled = true
                selectPole.textContent = ''
            }
        })
    </script>
@endsection('script')



