<?php

use App\Http\Controllers\ActivationController;
use App\Http\Controllers\BrendController;
use App\Http\Controllers\Cabinet\SSL\MikrotikController;
use App\Http\Controllers\cabinet\ssl\SslCreateController;
use App\Http\Controllers\Cabinet\VPN\Ikev2\IKEv2AccessRequestToCabinet;
use App\Http\Controllers\Cards\CardsController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\Commercial\CheckController;
use App\Http\Controllers\CorporateCommunicationController;
use App\Http\Controllers\CorporateCommunicationLoadDetailController;
use App\Http\Controllers\CorporateCommunicationReportController;
use App\Http\Controllers\CorporateСommunicationController;
use App\Http\Controllers\CounterpartyController;
use App\Http\Controllers\CultivationController;
use App\Http\Controllers\CurrentStatusController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceESPController;
use App\Http\Controllers\DeviceESPSettingsController;
use App\Http\Controllers\DeviceESPUpdateController;
use App\Http\Controllers\DeviceNameController;
use App\Http\Controllers\DeviceThermometerController;
use App\Http\Controllers\FactoryGuesController;
use App\Http\Controllers\FactoryMaterialController;
use App\Http\Controllers\FilialController;
use App\Http\Controllers\GuesController;
use App\Http\Controllers\HarvestYearController;
use App\Http\Controllers\HeightController;
use App\Http\Controllers\HoeingResultController;
use App\Http\Controllers\LimitsController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\MidOidController;
use App\Http\Controllers\NomenklatureController;
use App\Http\Controllers\PassFilialController;
use App\Http\Controllers\PeatController;
use App\Http\Controllers\PeatExtractionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PoleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrikopkiController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\ProductMonitoringControlController;
use App\Http\Controllers\ProductMonitoringController;
use App\Http\Controllers\ProductMonitoringDeviceController;
use App\Http\Controllers\ProductMonitoringReportController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleUpdateController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceNameController;
use App\Http\Controllers\SevooborotController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SMS\Get\SmsGet;
use App\Http\Controllers\SMS\SmsController;
use App\Http\Controllers\SokarController;
use App\Http\Controllers\SokarFIOController;
use App\Http\Controllers\SokarNomenklatController;
use App\Http\Controllers\SokarSkladController;
use App\Http\Controllers\SokarSpisanieController;
use App\Http\Controllers\SowingController;
use App\Http\Controllers\SowingControlPotatoController;
use App\Http\Controllers\SowingHoeingPotatoController;
use App\Http\Controllers\SowingLastNameController;
use App\Http\Controllers\SowingOutfitController;
use App\Http\Controllers\SowingTypeController;
use App\Http\Controllers\SprayingController;
use App\Http\Controllers\SprayingReportController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\Storage\StorageBoxController;
use App\Http\Controllers\Storage\StorageNameController;
use App\Http\Controllers\StorageModeController;
use App\Http\Controllers\StoragePhaseController;
use App\Http\Controllers\StoragePhaseTemperatureController;
use App\Http\Controllers\SzrController;
use App\Http\Controllers\TakeController;
use App\Http\Controllers\TypeFieldWorkController;
use App\Http\Controllers\Voucher\VoucherController;
use App\Http\Controllers\Voucher\VoucherPrintController;
use App\Http\Controllers\VpnInfoController;
use App\Http\Controllers\WarmingController;
use App\Http\Controllers\WateringController;
use App\Http\Controllers\Yandex\AliceController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'index')->name('/');
/**
 *ESP
 *
 *
 */
Route::get('esp/thermometer/show', [DeviceThermometerController::class, 'index'])->name('esp.thermometer.index')->middleware('can:DeviceESP.user.view');
Route::get('esp/thermometer/create', [DeviceThermometerController::class, 'create'])->name('esp.thermometer.create')->middleware('can:DeviceESP.user.view');
Route::post('esp/thermometer/store', [DeviceThermometerController::class, 'store'])->name('esp.thermometer.store')->middleware('can:DeviceESP.user.view');

Route::get('esp/upload/bin', [DeviceESPUpdateController::class, 'index'])->name('esp.upload.bin.index')->middleware('can:DeviceESP.user.view');
Route::post('esp/upload/bin', [DeviceESPUpdateController::class, 'store'])->name('esp.upload.bin.store')->middleware('can:DeviceESP.user.view');

Route::get('esp/settings', [DeviceESPSettingsController::class, 'show'])->name('esp.settings.show')->middleware('can:DeviceESP.user.view');
Route::post('esp/settings/store', [DeviceESPSettingsController::class, 'store'])->name('esp.settings.store')->middleware('can:DeviceESP.user.view');

Route::get('product/monitoring/devices', [ProductMonitoringDeviceController::class, 'show'])->name('product.monitoring.devices.show');
Route::get('product/monitoring/devices/show/storage/{id}/year/{year}', [ProductMonitoringDeviceController::class, 'showStorage'])->name('product.monitoring.devices.show.storage');
Route::get('product/monitoring/devices/show/storage/{id}/year/{year}/day/{day}', [ProductMonitoringDeviceController::class, 'showDay'])->name('product.monitoring.devices.show.storage.day');


/**
 * Посевная
 */
Route::resource('/sowing/type', SowingTypeController::class);
Route::resource('sowing', SowingController::class);
Route::resource('shift', ShiftController::class);
Route::resource('sowingLastName', SowingLastNameController::class);
Route::resource('machine', MachineController::class);
Route::get('/sowing/outfit/index{id?}', [SowingOutfitController::class, 'index'])->name('outfit.index');
Route::get('/sowing/outfit/create', [SowingOutfitController::class, 'create'])->name('outfit.create');
Route::post('/sowing/outfit/store', [SowingOutfitController::class, 'store'])->name('outfit.store');
Route::delete('/sowing/outfit/destroy/{outfit}', [SowingOutfitController::class, 'destroy'])->name('outfit.destroy');


/**
 * Комерческий отдел
 */
Route::get('/commercial/index', [CheckController::class, 'index']);
Route::post('/commercial/index', [CheckController::class, 'check'])->name('commercial.check');

/**
 * Запрос температуры для Алисы от Yandex
 */
Route::get('/temperature', [AliceController::class, 'temperature'])->withoutMiddleware([VerifyCsrfToken::class]);

Route::view('/login', 'login');
Route::view('/register', 'register');

/**
 * Отчет по расходу на сотовую связь
 */
Route::resource('communication', CorporateCommunicationController::class)
    ->middleware('can:CorporateCommunication.completed.create');
Route::get('/communication/report/show/{phoneDetail?}', CorporateCommunicationReportController::class)
    ->middleware('can:CorporateCommunication.user.view')->name('communication.report.show');
Route::get('/communication/load/index', [CorporateCommunicationLoadDetailController::class, 'index'])
    ->middleware('can:CorporateCommunication.completed.create');
Route::post('/communication/load/render', [CorporateCommunicationLoadDetailController::class, 'render'])
    ->middleware('can:CorporateCommunication.completed.create')->name('communication.load.render');


Route::get('/profile', [RegistrationController::class, 'index'])->name('profile.index')->middleware('auth');
Route::post('/profile', [RegistrationController::class, 'store'])->name('profile.store')->middleware('auth');
Route::get('/profile/show/{profile}', [RegistrationController::class, 'show'])->name('profile.show')->middleware('can:viewAny, App\Models\administrator');
Route::post('/registration/ip/store/{registration}', [RegistrationController::class, 'vpnAddInform'])->name('profile.ip.store');


Route::get('/activation', [ActivationController::class, 'index'])->name('activation.index')->middleware('can:viewAny, App\Models\administrator');
Route::post( '/user/edit/{registration}', [ActivationController::class, 'userEdit'])->name('user.edit')->middleware('can:viewAny, App\Models\administrator');
Route::post( '/user/activation/{registration}', [ActivationController::class, 'userActivation'])->name('user.activation')->middleware('can:viewAny, App\Models\administrator');
Route::delete('/user/activation/destroy/{registration}', [ActivationController::class, 'destroy'])->name('user.activation.destroy')->middleware('can:destroy, App\Models\administrator');
Route::delete('/user/activation/forceDelete/{user}', [ActivationController::class, 'forceDelete'])->name('user.activation.forceDelete')->middleware('can:destroy, App\Models\administrator');


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/sms_get', [SmsGet::class, 'smsGet'])->withoutMiddleware([VerifyCsrfToken::class]);

/**
 * throttle:smsIn в RouteServiceProvider
 */
Route::post('/sms_in', [SmsController::class, 'smsIn'])->withoutMiddleware([VerifyCsrfToken::class])->middleware('throttle:smsIn');

Route::resource('pole', PoleController::class)->middleware('auth');
Route::resource('pole.sevooborot', SevooborotController::class)->middleware('auth');

/**
 * Новые формы и маршруты для полива
 */
Route::post('watering/store',[WateringController::class, 'store'])->name('watering.store');
Route::get('watering/index',[WateringController::class, 'index'])->middleware('auth');
Route::get('watering/create',[WateringController::class, 'create'])->middleware('can:viewAny,App\Models\Watering');;
Route::get('/watering/show/{filial_id}/{pole_id}',[WateringController::class, 'show'])->name('watering.show');
Route::delete('/watering/destroy/{watering}', [WateringController::class, 'destroy'])->name('watering.destroy')->middleware('can:delete,watering');
Route::get('/watering/edit/{watering}', [WateringController::class, 'edit'])->middleware('can:viewAny,App\Models\Watering');

Route::get('/sokar', [SokarController::class, 'index'])->name('index.get');
Route::resource('size', SizeController::class);
Route::resource('color', ColorController::class);
Route::resource('counterparty', CounterpartyController::class);
Route::resource('height', HeightController::class);
Route::resource('sokarsklad', SokarSkladController::class);
Route::resource('sokarnomenklat', SokarNomenklatController::class);
Route::resource('sokarfio', SokarFIOController::class);
Route::resource('spisanie', SokarSpisanieController::class);
Route::post('/spisanieDate', [SokarSpisanieController::class, 'spisanieDate'])->name('spisanie.spisanieDate');

Route::get('/spraying/report', [SprayingReportController::class, 'oneDate'])->name('spraying.report.index');
Route::post('/spraying/report', [SprayingReportController::class, 'oneDate'])->name('spraying.report.show');
Route::get('/spraying/report/szr', [SprayingReportController::class, 'szr'])->name('spraying.report.index');
Route::resource('nomenklature', NomenklatureController::class);


/**
 * Ресурсы производственного отдела
 */
Route::resource('storagename', StorageNameController::class);
Route::resource('storagebox', StorageBoxController::class)->middleware('auth');
Route::resource('gues', GuesController::class);
Route::resource('take', TakeController::class);


Route::resource('cultivation', CultivationController::class);
Route::resource('filial', FilialController::class);
Route::resource('szr', SzrController::class);


Route::resource('spraying', SprayingController::class)->middleware('auth');
Route::resource('post', PostController::class);


Route::resource('brend', BrendController::class);
Route::resource('device_name', DeviceNameController::class);
Route::resource('device', DeviceController::class);
Route::resource('service_name', ServiceNameController::class);
Route::resource('service', ServiceController::class);
Route::get('/device/{currentStatus}/service', [ServiceController::class, 'device']);
Route::get('/cartridge/{device}', [ServiceController::class, 'cartridge']);
Route::resource('status', StatusController::class);
Route::resource('mibOid', MidOidController::class);
Route::resource('/factory/material', FactoryMaterialController::class);
Route::resource('factory.gues', FactoryGuesController::class);

/**
 * Торф
 */
Route::resource('year', HarvestYearController::class)->middleware('auth');
Route::resource('extraction', PeatExtractionController::class)->middleware('auth');
Route::resource('peat', PeatController::class)->middleware('auth');
/**
 * Отчеты по мониторингу температуры хранения продукции в боксах
 */
Route::get('monitoring/mode/show/{mode}', [StorageModeController::class, 'show'])->middleware('auth');
Route::delete('monitoring/mode/destroy/{mode}', [StorageModeController::class, 'destroy'])->name('monitoring.mode.destroy')->middleware('auth');
Route::get('monitoring/reports', [ProductMonitoringReportController::class, 'index'])->middleware('auth');
Route::post('monitoring/reports', [ProductMonitoringReportController::class, 'index'])->middleware('auth')->name('monitoring.report.day');

/**
 * Отчет по температурному мониторингу продукции в буртах
 */
Route::group(['middleware' => ['can:ProductMonitoring.user.view']], function () {
    Route::resource('phase', StoragePhaseController::class);
    Route::get('monitoring/index/{year?}', [ProductMonitoringController::class, 'index']);
    Route::resource('monitoring', ProductMonitoringController::class);
    Route::get('monitoring/show/filial/{filial_id}/year/{harvest_year_id}', [ProductMonitoringController::class, 'showFilial'])->name('monitoring.show.filial');
    Route::get('monitoring/filial/storage/{storage_name_id}/year/{harvest_year_id}', [ProductMonitoringController::class, 'showFilialMonitoring'])->name('monitoring.show.filial.all');
    Route::get('monitoring/control/storage/{storage_id}/year/{harvest_year_id}', [ProductMonitoringController::class, 'controlStorage'])->name('monitoring.control.storage');
    Route::resource('storage/phase/temperatures',StoragePhaseTemperatureController::class);
    Route::post('product/monitoring/control', [ProductMonitoringControlController::class, 'store'])->name('product.monitoring.control.store');
});


Route::get('/printer/{id}/current/show', [CurrentStatusController::class, 'show'])->name('printer.current.show')->middleware('can:viewAny, App\Models\administrator');
Route::get('/current/{currentStatus}/edit', [CurrentStatusController::class, 'edit'])->name('printer.current.edit')->middleware('can:viewAny, App\Models\administrator');
Route::get('/current/{device}/create', [CurrentStatusController::class, 'create'])->name('printer.current.create')->middleware('can:viewAny, App\Models\administrator');
Route::post('/current/store',[CurrentStatusController::class, 'store'])->name('printer.current.store')->middleware('can:viewAny, App\Models\administrator');
Route::get('/printers', [PrinterController::class, 'index'])->name('Printer.index')->middleware('can:viewAny, App\Models\administrator');
Route::get('/printer/{id}/show/{currentStatus}', [PrinterController::class, 'show'])->name('printer.show')->middleware('can:viewAny, App\Models\administrator');
Route::post('/printers', [PrinterController::class, 'index'])->name('printer.toDayGet')->middleware('can:viewAny, App\Models\administrator');

Route::get('/daily', [PrinterController::class, 'daily']);
Route::get('/dailyone', [PrinterController::class, 'dailyone']);
Route::get('/job', [PrinterController::class, 'job']);

Route::view('/reference', 'printer.reference');

Route::resource('type_field_work', TypeFieldWorkController::class)->middleware('can:viewAny, App\Models\administrator');


Route::group(['middleware' => ['can:SowingHoeingPotato.user.view']], function (){
    Route::resource('sowing_hoeing_potato', SowingHoeingPotatoController::class);

    Route::get('/sowing_hoeing_potato/show_to_pole/{id}', [SowingHoeingPotatoController::class, 'showToPole'])
        ->name('sowing_hoeing_potato.show_to_pole')
        ->middleware('auth');
});
Route::get('/pass/create', [PassFilialController::class, 'create'])->middleware('can:PassFilial.completed.create')->name('pass.filial.create');
Route::get('/pass/index', [PassFilialController::class, 'index'])->middleware('can:PassFilial.user.view')->name('pass.filial.index');
Route::get('/pass/check', [PassFilialController::class, 'check']);
Route::post('/pass/store', [PassFilialController::class, 'store'])->middleware('can:PassFilial.completed.create')->name('pass.filial.store');

Route::get('test', \App\Http\Controllers\TestController::class);

//Route::get('test', App\Http\Controllers\TermoPrinter\TermoPrinterController::class)->middleware('auth');

/*$text['body'] = 'Вы будите получать уведомления об этапах выполнения.';
$text['status'] = 'зарегистрирована';
$text['identification'] = 'identification';
Route::get('/test', function () use ($text) {
    return new App\Mail\RequestSSLMail('Имя Я.К.', $text);
});*/

Route::get('/card/{messages?}', [CardsController::class, 'index'])->name('card.index')->middleware('can:Card.user.view');
Route::post('/createDischarge', [CardsController::class, 'createDischarge'])->name('card.loadInformation')->middleware('can:Card.user.view');
Route::post('/card', [CardsController::class, 'loadStorageLocation'])->name('card.loadStorageLocation')->middleware('can:Card.user.view');

Route::group(['middleware' => ['can:SowingControl.user.view']], function () {

Route::get('/sowing_control_potato/index', [SowingControlPotatoController::class, 'index'])
    ->name('sowing_control_potato.index')
    ->middleware('can:viewAny,App\Models\sowingControlPotato');

Route::get('/sowing_control_potato/create', [SowingControlPotatoController::class, 'create'])
    ->name('sowing_control_potato.create')
    ->middleware('can:viewAny,App\Models\sowingControlPotato');

Route::get('/sowing_control_potato/{sowing_control_potato}/edit', [SowingControlPotatoController::class, 'edit'])
    ->name('sowing_control_potato.edit')
    ->middleware('can:edit,sowing_control_potato');

Route::get('/sowing_control_potato/{id}', [SowingControlPotatoController::class, 'showPole'])
    ->name('sowing_control_potato.show_pole')
    ->middleware('can:viewAny,App\Models\sowingControlPotato');

Route::post('/sowing_control_potato/store', [SowingControlPotatoController::class, 'store'])
    ->name('sowing_control_potato.store')
    ->middleware('can:viewAny,App\Models\sowingControlPotato');

Route::put('/sowing_control_potato/{sowing_control_potato}', [SowingControlPotatoController::class, 'update'])
    ->name('sowing_control_potato.update')
    ->middleware('can:update,sowing_control_potato');

Route::delete('/sowing_control_potato/{sowing_control_potato}', [SowingControlPotatoController::class, 'delete'])
    ->name('sowing_control_potato.destroy')
    ->middleware('can:delete,sowing_control_potato');
});


Route::resource('prikopki', PrikopkiController::class)->middleware('auth');
Route::get('prikopki/year/{year}', [PrikopkiController::class, 'ShowYear'])->name('prikopki.showyear');
Route::get('prikopki/year/{year}/pole/{pole}', [PrikopkiController::class, 'ShowYearPole'])->name('prikopki.year.pole');


Route::group(['middleware' => ['can:super-user']], function () {
    Route::resource('role', RoleController::class);
    Route::post('updateRoles',[RoleController::class, 'updateRoles'])->name('roles.update.admin');
    Route::get('showRoles',[RoleController::class, 'showRoles'])->name('roles.show.admin');
    Route::post('user/role/destroy/{registration}', [RoleUserController::class, 'userRoleDestroy'])->name('user.role.destroy');
    Route::post('user/role/add/{registration}', [RoleUserController::class, 'userRoleAdd'])->name('user.role.add');
    Route::get('role', [RoleController::class, 'index'])->name('role.index');
    Route::get('permissions/role', [RoleController::class, 'permissions'])->name('permissions.role.index');
    Route::post('permissions/role/add', [RoleController::class, 'permissionsAdd'])->name('permissions.role.add');
});



Route::group(['middleware' => ['can:Voucher.user.view']], function (){
   Route::get('voucher', [VoucherController::class, 'index']);
});

Route::group(['middleware' => ['can:Voucher.user.create']], function (){
    Route::get('voucher/print', [VoucherPrintController::class, 'index']);
    Route::post('voucher/pdf', [VoucherPrintController::class, 'generatePDF'])->name('voucher.generate.pdf');
});

Route::resource('warming', WarmingController::class);
Route::resource('vpn', VpnInfoController::class)->middleware('can:VpnInfo.user.view');
Route::post('vpn/access/request', IKEv2AccessRequestToCabinet::class)->middleware('can:VpnInfo.user.create')->name('vpn.access.request');



Auth::routes();




