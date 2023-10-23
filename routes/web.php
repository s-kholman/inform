<?php

use App\Http\Controllers\AgregatController;
use App\Http\Controllers\BrendController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CounterpartyController;
use App\Http\Controllers\CurrentStatusController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceNameController;
use App\Http\Controllers\FactoryGuesController;
use App\Http\Controllers\FactoryMaterialController;
use App\Http\Controllers\FilialController;
use App\Http\Controllers\FioController;
use App\Http\Controllers\GuesController;
use App\Http\Controllers\HeightController;
use App\Http\Controllers\KulturaController;
use App\Http\Controllers\MidOidController;
use App\Http\Controllers\NomenklatureController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\ProductMonitoringController;
use App\Http\Controllers\ProductMonitoringReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceNameController;
use App\Http\Controllers\SevooborotController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SokarController;
use App\Http\Controllers\SokarFIOController;
use App\Http\Controllers\SokarNomenklatController;
use App\Http\Controllers\SokarSkladController;
use App\Http\Controllers\SokarSpisanieController;
use App\Http\Controllers\SprayingController;
use App\Http\Controllers\SprayingReportController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\Storage\StorageBoxController;
use App\Http\Controllers\Storage\StorageNameController;
use App\Http\Controllers\StorageModeController;
use App\Http\Controllers\StoragePhaseController;
use App\Http\Controllers\SutkiController;
use App\Http\Controllers\SzrController;
use App\Http\Controllers\TakeController;
use App\Http\Controllers\VidposevaController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\InfoController;
use \App\Http\Controllers\LimitsController;
use \App\Http\Controllers\RegistrationController;
use \App\Http\Controllers\ActivationController;
use \App\Http\Controllers\SmsController;
use \App\Http\Controllers\PolivController;
use \App\Http\Controllers\PoleController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
 * Посевная + торф (последнее переписать как новый отчет)
 */
Route::resource('svyaz', \App\Http\Controllers\SvyazController::class)->middleware('can:destroy, App\Models\svyaz');
Route::get('/otchet/{key}', [InfoController::class, 'otchet'])->name('otchet');
Route::post('/posev_add', [InfoController::class, 'storePosev'])->name('posev.add')->middleware('auth');
Route::get('/posev_add', [InfoController::class, 'showAddPosevForm'])->name('posev_add')->middleware('auth');

Route::view('/login', 'login');
Route::view('/register', 'register');

/**
 * Отчет по расходу на сотовую связь
 */
Route::get('/limit_add',[LimitsController::class, 'showLimitForm'])->name('limit_add')->middleware('can:destroy, App\Models\svyaz');;
Route::post('/limit_add', [LimitsController::class, 'storeLimit'])->name('limit.save')->middleware('can:destroy, App\Models\svyaz');
Route::post('/parser_add', [LimitsController::class, 'parserLimit'])->name('parser.save')->middleware('can:destroy, App\Models\svyaz');;
Route::delete('/limit_delete/{limitID}', [LimitsController::class, 'limitdestroy'])->name('limit.destroy')->middleware('can:destroy, App\Models\svyaz');
Route::get('/limit_view/{phoneDetail?}',[LimitsController::class, 'showLimit'])
    ->name('limit_view')
    ->middleware('can:limitView, App\Models\svyaz')
    ->where('phoneDetail','[0-9]+');
Route::get('/edit_limit/{limitID}', [LimitsController::class, 'limitEdit'])->name('limit.edit')->middleware('can:destroy, App\Models\svyaz');;


Route::get('/profile', [RegistrationController::class, 'index'])->name('profile.index')->middleware('auth');
Route::post('/profile', [RegistrationController::class, 'store'])->name('profile.store')->middleware('auth');

Route::get('/activation', [ActivationController::class, 'activation'])->name('activation.show')->middleware('can:destroy, App\Models\svyaz');
Route::get('/user/{id}', [ActivationController::class, 'userView'])->name('user.view')->middleware('can:destroy, App\Models\svyaz');
Route::delete( '/user/edit/{id}', [ActivationController::class, 'userEdit'])->name('user.edit')->middleware('can:destroy, App\Models\svyaz');
Route::delete( '/user/activation/{id}', [ActivationController::class, 'userActivation'])->name('user.activation')->middleware('can:destroy, App\Models\svyaz');

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

Route::post('/sms_get', [SmsController::class, 'smsGet'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/sms_in', [SmsController::class, 'smsIn'])->withoutMiddleware([VerifyCsrfToken::class])->middleware('throttle:smsIn');

Route::get('/voucher_get', [SmsController::class, 'voucherGetShow'])->name('voucher');
Route::post('/voucher_get', [SmsController::class, 'voucherGet'])->name('voucher.get');


Route::resource('pole', PoleController::class);
Route::resource('pole.sevooborot', SevooborotController::class)->middleware('auth');


Route::get('/poliv_add', [PolivController::class, 'polivAddShow'])->name('poliv_add')->middleware('auth');;
Route::get('/poliv_show/{filial_id?}/{pole_id?}', [PolivController::class, 'polivShow'])->name('poliv.view')->middleware('auth');;
Route::post('/poliv_add', [PolivController::class, 'polivAdd'])->name('poliv.add')->middleware('auth');
Route::get('/poliv_edit/{polivId}', [PolivController::class, 'polivEdit'])->name('poliv_edit')->middleware('can:viewAny, App\Models\Poliv');;
Route::delete('/poliv_delete/{poliv}', [PolivController::class, 'polivdestroy'])->name('poliv.destroy')->middleware('can:delete,poliv');


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

Route::get('/spraying/report/{id?}', [SprayingReportController::class, 'index'])->name('spraying.report.index');
Route::post('/spraying/report/{id}', [SprayingReportController::class, 'report'])->name('spraying.report.show');
Route::resource('nomenklature', NomenklatureController::class);
Route::resource('kultura', KulturaController::class);

/**
 * Ресурсы производственного отдела
 */
Route::resource('storagename', StorageNameController::class);
Route::resource('storagebox', StorageBoxController::class)->middleware('auth');
Route::resource('gues', GuesController::class);
Route::resource('take', TakeController::class);


Route::resource('filial', FilialController::class);
Route::resource('szr', SzrController::class);
Route::resource('sutki', SutkiController::class);
Route::resource('agregat', AgregatController::class);
Route::resource('vidposeva', VidposevaController::class);
Route::resource('fio', FioController::class);

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
 * Отчеты по мониторигу температуры хранения продукции в боксах
 */
Route::get('monitoring/reports', [ProductMonitoringReportController::class, 'index'])->middleware('auth');
Route::post('monitoring/reports/today', [ProductMonitoringReportController::class, 'today'])->name('monitoring.report.today')->middleware('auth');

/**
 * Отчет по температурному мониторингу продукции в буртах
 */
Route::resource('phase', StoragePhaseController::class)->middleware('auth');
Route::resource('monitoring', ProductMonitoringController::class)->middleware('auth');
Route::get('monitoring/show/filial/{id}', [ProductMonitoringController::class, 'showFilial'])->name('monitoring.show.filial')->middleware('auth');
Route::get('monitoring/filial/all/{id}', [ProductMonitoringController::class, 'showFilialMonitoring'])->name('monitoring.show.filial.all')->middleware('auth');

Route::get('/printer/{id}/current/show', [CurrentStatusController::class, 'show'])->name('printer.current.show');
Route::get('/current/{currentStatus}/edit', [CurrentStatusController::class, 'edit'])->name('printer.current.edit');
Route::get('/current/{device}/create', [CurrentStatusController::class, 'create'])->name('printer.current.create');
Route::post('/current/store',[CurrentStatusController::class, 'store'])->name('printer.current.store');
Route::get('/printers', [PrinterController::class, 'index'])->name('Printer.index');
Route::get('/printer/{id}/show/{currentStatus}', [PrinterController::class, 'show'])->name('printer.show');
Route::post('/printer', [PrinterController::class, 'index'])->name('printer.toDayGet');

Route::get('/daily', [PrinterController::class, 'daily']);
Route::get('/dailyone', [PrinterController::class, 'dailyone']);
Route::get('/job', [PrinterController::class, 'job']);


Route::view('/reference', 'printer.reference');


Auth::routes();




