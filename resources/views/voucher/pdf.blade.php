<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        * {
            font-family: "DejaVu Sans", sans-serif;
        }
        .voucher {
            display: inline-block;
            width: 43mm;
            height: 18mm;
            border: dotted;
            margin: 0px;
            #float: inside;
            font-size: 12px;
            text-align: center;
        }
        .code{
            font-size: 16px;
            font-weight: 700;

        }
        .wifi{
            font-size: 8px;
        }
        .caption{
            font-size: 10px;
        }
        span{
            display: block;
            margin: 6px;
        }

    </style>
</head>
<body>
    @foreach($vouchers as $voucher)
        <div class="voucher">
            <span class="caption">Доступ на {{$voucher->duration}}</span>
            <span class="wifi">WiFi сети: <b>KRiMM_INTERNET</b></span>
            <span class="code">{{$voucher->code}}</span>
        </div>
    @endforeach
</body>
</html>





