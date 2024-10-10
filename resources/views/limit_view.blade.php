@extends('layouts.base')
<style>
    table tr td {
        text-align: center;
    }
    @media print {
        table{
            border: 1px solid black;
            font-size: 12px;
            width: 18cm;
        }
        #no-print-phone-header,
        #no-print-menu,
        button,
        header{
            display: none !important;
        }
    }
</style>
@section('title', 'Детализация корпоративной связи')

@section('info')

    <div class="text-center">
        <div class="row" id="no-print-phone-header">
        @forelse(\App\Models\PhoneDetail::select('id','DetailDate')->orderby('DetailDate', 'DESC')->Limit(6)->get() as $mount)
                <div class="list-inline-item col-3 col-md"> <p class="text-center"><a href="/limit_view/{{$mount->id}}">{{Str::ucfirst(\Carbon\Carbon::parse($mount->DetailDate)->translatedFormat('F Y'))}}</a></p> </div>
        @empty
        @endforelse
        </div>
        <table class="table table-bordered table-striped" id="print">
            <caption class="border rounded-3 p-3 caption-top">
                <p class="text-center"><b>{{Str::ucfirst(\Carbon\Carbon::parse($DetailDate)->translatedFormat('F Y'))}}</b></p>
            </caption>
            <thead>
            <th class="text-center">№ п/п</th><th class="text-center">ФИО</th><th class="text-center">Телефон</th><th class="text-center">Лимит</th><th class="text-center">Расход</th><th class="text-center">Перерасход</th>
            </thead>
            <tbody>
            @foreach($itogTable as $limit)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td style="text-align: left">{{json_decode($limit)->fio}}</td>
                    <td style="width: 150px">{{json_decode($limit)->phone}}</td>
                    <td>{{json_decode($limit)->limit}}</td>
                    <td>{{json_decode($limit)->rashod}}</td>
                    <td>{{json_decode($limit)->pRashod}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    <button class="btn btn-primary" id="btnPrint">Печать</button>
@endsection('info')
@section('script')
<script type="text/javascript">

    const print = document.getElementById('print')
    const btnPrint = document.getElementById('btnPrint')

    btnPrint.addEventListener('click', () =>{
        window.print();
    })

    window.addEventListener('beforeprint', () => {
        print.classList.remove('table')
        print.children[0].classList.remove('border')
    })
    window.addEventListener('afterprint', () => {
        print.classList.add('table')
        print.children[0].classList.add('border')
    })

</script>
@endsection('script')
