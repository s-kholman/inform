<div class="card mt-4">
    <h5 class="card-header">Информация по сертификату</h5>
    <div class="card-body">
        @if(!empty($ssl_info))
            Данные по текущему SSL:
            <div class="fw-bold">
                Дата окончания: {{ $ssl_info ['expire'] }} <br>
                Дней до окончания: {{ $ssl_info ['expires_after'] }}
            </div>
        @else
            Данные по действующему SSL-сертификату не найдены!<br />
            @if($application !== null)
                <br /><br />Текущая заявка:<br />
                @foreach($application as $value)
                    <label id="statusApplication">Статус: <b>{{$value->ApplicationStatus->name}}</b>, от {{\Illuminate\Support\Carbon::parse($value->created_at)->format('d.m.Y H:i')}} </label> <br />
                @endforeach
            <div class="row mt-2">
                <div class="col-6">
                    <select
                        name="applicationStatus"
                        id="applicationStatus"
                        class="form-select @error('applicationStatus') is-invalid @enderror">

                        @forelse($applicationStatuses as $applicationStatus)
                            <option value="{{ $applicationStatus->id }}"> {{ $applicationStatus->name }} </option>
                        @empty
                            <option value="">Ошибка получения данных</option>
                        @endforelse
                    </select>

                </div>
                <div class="col-6">
                    <button class="btn btn-outline-primary " id="change">Изменить статус</button>
                </div>

            </div>

            @endif
        @endif
    </div>
</div>
