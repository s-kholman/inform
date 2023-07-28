@extends('layouts.base')
@section('title', 'Детализация корпоративной связи')

@section('info')

    <div class="container">
        <div class="row">
        @forelse(\App\Models\PhoneDetail::select('id','DetailDate')->orderby('DetailDate', 'DESC')->Limit(6)->get() as $mount)
                <div class="list-inline-item col-3 col-md"> <p class="text-center"><a href="/limit_view/{{$mount->id}}">{{Str::ucfirst(\Carbon\Carbon::parse($mount->DetailDate)->translatedFormat('F Y'))}}</a></p> </div>
        @empty
        @endforelse
        </div>
        <table class="table table-bordered table-striped">
            <caption class="border rounded-3 p-3 caption-top"><p class="text-center"><b>{{Str::ucfirst(\Carbon\Carbon::parse($DetailDate)->translatedFormat('F Y'))}}</b></p></caption>
            <thead>
            <th class="text-center">№ п/п</th><th class="text-center">ФИО</th><th class="text-center">Телефон</th><th class="text-center">Лимит</th><th class="text-center">Расход</th><th class="text-center">Перерасход</th>
            </thead>
            <tbody>
            @foreach($itogTable as $limit)
                <tr>
                    <td align="center">{{$loop->iteration}}</td>
                    <td>{{json_decode($limit)->fio}}</td>
                    <td align="center" width="150">{{json_decode($limit)->phone}}</td>
                    <td align="center">{{json_decode($limit)->limit}}</td>
                    <td align="center">{{json_decode($limit)->rashod}}</td>
                    <td align="center">{{json_decode($limit)->pRashod}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <a href="javascript:void(0);" onclick="printPage();">Печать</a>
@endsection('info')
@section('script')
<script type="text/javascript">
    function printPage(){
        var tableData = '<table border="1" style="font-size: 12px" align="center">'+document.getElementsByTagName('table')[0].innerHTML+'</table>';
        var data = '<button onclick="window.print()"></button>'+tableData;
        myWindow=window.open('','','width=800,height=600');
        myWindow.innerWidth = screen.width;
        myWindow.innerHeight = screen.height;
        myWindow.screenX = 0;
        myWindow.screenY = 0;
        myWindow.document.write(data);
        myWindow.focus();

    };
</script>
@endsection('script')
