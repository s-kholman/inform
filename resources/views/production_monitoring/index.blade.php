@extends('layouts.base')
@section('title', 'Мониторинг температуры в боксах')
<style>
    .flex-container {
        display: flex;
        justify-content: flex-start;
        padding: 15px;
        gap: 5px;
    }

    .flex-container > div{
        padding: 8px;
    }
    .item1 {
        /* flex:0 1 auto; */
        align-self:flex-start;
    }



    /* Style the Image Used to Trigger the Modal */
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {opacity: 0.7;}

    /* Style the Image Used to Trigger the Modal */
    #myImg2 {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg2:hover {opacity: 0.7;}

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    /* Modal Content (Image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image (Image Text) - Same Width as the Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation - Zoom in the Modal */
    .modal-content, #caption {
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @keyframes zoom {
        from {transform:scale(0)}
        to {transform:scale(1)}
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px){
        .modal-content {
            width: 100%;
        }
    }
</style>
@section('info')
    <div class="container">
        <div class="row  text-center">
            <div class="col-12 p-">
                <p><h4>Отчет о температуре хранения продукции в боксах:</h4></p>
            </div>
        </div>
        <div class="row  text-center border border-1">
            <div class="col-12 ">
                <p><h4>Года хранения:</h4></p>
            </div>
            <div class="row text-center p-5">

                    @forelse($year as $name => $value)
                    <div class="col-3">
                      <a href="/monitoring/index/{{$value[0]->harvestYear->id}}">{{\Carbon\Carbon::parse('01-01-'.$name)->addYear(-1)->format('Y')}} - {{$name}}</a>
                    </div>
                    @empty
                    @endforelse

            </div>
        </div>
        <div class="flex-container">

            <div class="item1 text-center col-4">
                @forelse($filial as $filal_name => $value)

                    @if ($loop->first)
                            <h5>Филиалы:</h5>
                        <div class="row p-5">
                            @endif
                            <div class="col-12"><h4><p><a href="{{route('monitoring.show.filial', ['filial_id' => $value[0]->filial_id, 'harvest_year_id'=> $value[0]->harvest_year_id])}}">{{$filal_name}}</a></p></h4></div>
                            @if($loop->last)
                        </div>
                    @endif
                @empty
                    <div class="row">
                        <div class="col-12 p-5 text-center">
                            <p><h4>Нет данных для отображения. Воспользуйтесь кнопкой "Внести данные"</h4></p>
                        </div>
                    </div>
                @endforelse

                    <div class="row text-center">
                        <div class="col-12 ">
                            <a class="btn btn-success" href="/monitoring/reports/">Отчеты</a>
                        </div>
                    </div>

                    @canany(['ProductMonitoring.director.create', 'ProductMonitoring.completed.create'])
                        <div class="row p-5">
                            <div class="col-12 text-center">
                                <a class="btn btn-info" href="/monitoring/create">Внести данные</a>
                            </div>
                        </div>
                    @endcanany

                    @role('super-user')
                        <div class="row text-center p-4">
                            <div class="col-12 ">
                                <a class="btn btn-info" href="/phase/">Внести фазы хранения</a>
                            </div>
                        </div>
                    @endrole



            </div>
            <div class="item2 col-8" style="text-align: right">

<span>
<p style="font-weight: bold">Инструкция по хранению картофеля и овощей</p>
    <p style="font-size: 10px">Для увеличения изображения нажмите по миниатюре</p>
</span>
                <img id="myImg" src={{Storage::url('public/images/monitoring_production/1.jpg')}} alt="Страница1" style="border: solid black 1px; width:100%;max-width:200px">
                <img id="myImg2" src={{Storage::url('public/images/monitoring_production/2.jpg')}} alt="Страница2" style="border: solid black 1px; width:100%;max-width:200px">

                <!-- The Modal -->
                <div id="myModal" class="modal">

                    <!-- The Close Button
                    --><span class="close">&times;</span>

                    <!-- Modal Content (The Image) -->
                    <img class="modal-content" id="img01">

                    <!-- Modal Caption (Image Text) -->
                    <div id="caption"></div>
                </div>

            </div>
        </div>




    </div>



@endsection('info')
@section('script')
    <script>
        // Get the modal
        let modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        let img = document.getElementById("myImg");
        let modalImg = document.getElementById("img01");
        let captionText = document.getElementById("caption");
        img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }

        // Get the <span> element that closes the modal
        let span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        let img2 = document.getElementById("myImg2");
        img2.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }
    </script>
@endsection('script')
