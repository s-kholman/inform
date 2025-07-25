<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') </title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/bootstrap/css/Posev_1.css">
    <link rel="stylesheet" href="/scripts/datepicker/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

<div class="container-fluid">
    <header class="blog-header py-3 ">
        <div class="row flex-nowrap justify-content-between align-items-center ">
            <div class="col-4 pt-1"></div>

            <div class="col-4 text-center">
                <label class="blog-header-logo text-dark">Информационный портал ООО "Агрофирма "КРиММ"</label>
                <a hidden class="blog-header-logo text-dark" href="#">Large</a>
            </div>
            @guest
            <div class="col-4 d-flex justify-content-end align-items-center">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}">Вход/Регистрация</a>
            </div>
            @endguest
            @auth
                <div class="col-3 d-flex justify-content-end align-items-center" >
                    <a class="btn btn-outline-info" href="{{route('profile.index')}}">Профиль</a>
                </div>
                <div class="col-1 d-flex justify-content-end align-items-center">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                    {{ __('Выйти') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                </div>
            @endauth

        </div>
    </header>
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark" id="no-print-menu">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">

                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="/" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Главная</span>
                        </a>
                    </li>
                    @can('Voucher.user.view')
                        <li class="nav-item">
                            <a class="nav-link align-middle px-0" href="/voucher" class="nav-link px-0">
                                <i class="fs-4 bi-wifi"></i> <span class="ms-1 d-none d-sm-inline">Доступ к WiFi</span></a>
                        </li>
                    @endcan

                    @can('Card.user.view')
                        <li class="nav-item">
                            <a class="nav-link align-middle px-0" href="/card" class="nav-link px-0">
                                <i class="bi bi-credit-card-2-back-fill"></i> <span class="ms-1 d-none d-sm-inline">Топливные карты</span></a>
                        </li>
                    @endcan

                    @can('PassFilial.user.view')
                        <li class="nav-item">
                            <a class="nav-link align-middle px-0" href="/pass/index" class="nav-link px-0">
                                <i class="fs-4 bi bi-truck-flatbed"></i> <span class="ms-1 d-none d-sm-inline">Пропуска</span></a>
                        </li>
                    @endcan

                    @can('VpnInfo.user.view')
                        <li class="nav-item">
                            <a class="nav-link align-middle px-0" href="{{route('vpn.index')}}" class="nav-link px-0">
                                <i class="fs-4 bi-house-lock-fill"></i> <span class="ms-1 d-none d-sm-inline">VPN из дома</span></a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/warming" class="nav-link px-0">
                            <i class="fs-4 bi-speedometer"></i> <span class="ms-1 d-none d-sm-inline">Прогрев семян</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/sowing?id=1" class="nav-link px-0">
                            <i class="fs-4 bi-speedometer"></i> <span class="ms-1 d-none d-sm-inline">Посевная</span></a>
                    </li>

                    @can('SowingControl.user.view')
                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/sowing_control_potato/index" class="nav-link px-0">
                            <i class="fs-4 bi-eye"></i> <span class="ms-1 d-none d-sm-inline">Контроль нормы высадки картофеля</span></a>
                    </li>
                    @endcan
                    @can('SowingHoeingPotato.user.view')
                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/sowing_hoeing_potato" class="nav-link px-0">
                            <i class="fs-4 bi-alt"></i> <span class="ms-1 d-none d-sm-inline">Окучивание</span></a>
                    </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/watering/index" class="nav-link px-0">
                            <i class="fs-4 bi-umbrella"></i> <span class="ms-1 d-none d-sm-inline">Полив</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/spraying" class="nav-link px-0">
                            <i class="fs-4 bi-cloud-drizzle"></i> <span class="ms-1 d-none d-sm-inline">Опрыскивание</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/prikopki" class="nav-link px-0">
                            <i class="fs-4 bi-diamond"></i> <span class="ms-1 d-none d-sm-inline">Прикопки</span></a>
                    </li>
                    @can('ProductMonitoring.user.view')
                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/monitoring" class="nav-link px-0">
                            <i class="fs-4 bi-thermometer"></i> <span class="ms-1 d-none d-sm-inline">Мониторинг температуры</span></a>
                    </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/peat" class="nav-link px-0">
                            <i class="fs-4 bi-square-fill"></i> <span class="ms-1 d-none d-sm-inline">Торф</span></a>
                    </li>

                    @can('viewAny', 'App\Models\DailyUse')
                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/printers" class="nav-link px-0">
                            <i class="fs-4 bi-printer"></i> <span class="ms-1 d-none d-sm-inline">Принтера</span></a>
                    </li>
                    @endcan



                    @can('showMenu', 'App\Models\administrator')
                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/storagebox" class="nav-link px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">По боксам</span></a>
                    </li>

                        <li class="nav-item">
                            <a class="nav-link align-middle px-0" href="/factory/material" class="nav-link px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Завод - сырье</span></a>
                        </li>
                    @endcan
                    @can('CorporateCommunication.user.view')
                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/communication/report/show/" class="nav-link px-0">
                            <i class="fs-4 bi-telephone"></i> <span class="ms-1 d-none d-sm-inline">Детализация сотовой связи</span></a>
                    </li>
                    @endcan
                    @can('viewMenu', 'App\Models\administrator')
                    <li>
                        <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-book"></i> <span class="ms-1 d-none d-sm-inline">Справочники</span> </a>
                        <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">

                            <li class="w-100">
                                <a href="/filial" class="nav-link px-0"> <span class="d-none d-sm-inline">Филиалы</span></a>
                            </li>

                                <li>
                                    <a href="/communication" class="nav-link px-0"> <span class="d-none d-sm-inline">Корп связь</span></a>
                                </li>



                            <li>
                                <a href="/post" class="nav-link px-0"> <span class="d-none d-sm-inline">Должность</span></a>
                            </li>
                            <li>
                                <a href="/activation" class="nav-link px-0"> <span class="d-none d-sm-inline">Активация пользователей</span></a>
                            </li>

                            <li>
                                <a href="/storagename" class="nav-link px-0"> <span class="d-none d-sm-inline">Склад</span></a>
                            </li>
                            <li>
                                <a href="/nomenklature" class="nav-link px-0"> <span class="d-none d-sm-inline">Номенклатура</span></a>
                            </li>
                            <li>
                                <a href="/szr" class="nav-link px-0"> <span class="d-none d-sm-inline">СЗР</span></a>
                            </li>
                            <li>
                                <a href="/storagebox" class="nav-link px-0"> <span class="d-none d-sm-inline">Продукция по боксам</span></a>
                            </li>
                            <li>
                                <a href="/pole" class="nav-link px-0"> <span class="d-none d-sm-inline">Поля</span></a>
                            </li>
                            <li>
                                <a href="/storage/phase/temperatures/create" class="nav-link px-0"> <span class="d-none d-sm-inline">Температура по фазам хранения</span></a>
                            </li>
                            <li>
                                <a href="/sowing/type" class="nav-link px-0"> <span class="d-none d-sm-inline">Тип посева</span></a>
                            </li>
                            <li>
                                <a href="/type_field_work" class="nav-link px-0"> <span class="d-none d-sm-inline">Тип посевных работ</span></a>
                            </li>
                            <li>
                                <a href="/role" class="nav-link px-0"> <span class="d-none d-sm-inline">Создать роли</span></a>
                            </li>
                            <li>
                                <a href="/permissions/role" class="nav-link px-0"> <span class="d-none d-sm-inline">Права для ролей</span></a>
                            </li>

                            <li>
                                <a href="{{route('roles.show.admin')}}" class="nav-link px-0"> <span class="d-none d-sm-inline">Назначить права пользователям</span></a>
                            </li>

                            @endcan
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col py-3">
            @yield('info')
            @yield('content')
        </div>
    </div>
</div>

@yield('script')
<script src="/bootstrap/js/bootstrap.js"></script>
<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
