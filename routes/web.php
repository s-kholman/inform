<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\InfoController;
use \App\Http\Controllers\LimitsController;
use \App\Http\Controllers\RegistrationController;
use \App\Http\Controllers\ActivationController;
use \App\Http\Controllers\BoxController;
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
Route::resource('agregat', \App\Http\Controllers\AgregatController::class);
Route::get('/', [InfoController::class, 'index_g'])->name('/');
Route::get('/otchet/{key}', [InfoController::class, 'otchet'])->name('otchet');

Route::post('/post_add', [InfoController::class, 'storePost'])->name('post.add')->middleware('can:destroy, App\Models\svyaz');
Route::get('/post_add', [InfoController::class, 'showAddPostForm'])->middleware('can:destroy, App\Models\svyaz');

Route::post('/fio_add', [InfoController::class, 'storeFio'])->name('fio.add')->middleware('can:destroy, App\Models\svyaz');
Route::get('/fio_add', [InfoController::class, 'showAddFioForm'])->name('fio_add')->middleware('can:destroy, App\Models\svyaz');

Route::post('/sutki_add', [InfoController::class, 'storeSutki'])->name('sutki.add')->middleware('can:destroy, App\Models\svyaz');
Route::get('/sutki_add', [InfoController::class, 'showAddSutkiForm'])->middleware('can:destroy, App\Models\svyaz');

Route::post('/vidposeva_add', [InfoController::class, 'storeVidposeva'])->name('vidposeva.add')->middleware('can:destroy, App\Models\svyaz');
Route::get('/vidposeva_add', [InfoController::class, 'showAddVidposevaForm'])->middleware('can:destroy, App\Models\svyaz');

Route::post('/svyaz_add', [InfoController::class, 'storeSvyaz'])->name('svyaz.add')->middleware('auth');
Route::get('/svyaz_add', [InfoController::class, 'showAddSvyazForm'])->name('svyaz_add')->middleware('can:destroy, App\Models\svyaz');
Route::get('/svyaz_disable{svyaz}', [InfoController::class, 'disableSvyaz'])->name('svyaz.disable')->middleware('can:destroy, App\Models\svyaz');
Route::get('/svyaz_delete{svyaz}', [InfoController::class, 'deleteSvyaz'])->name('svyaz.delete')->middleware('can:destroy, App\Models\svyaz');

Route::post('/posev_add', [InfoController::class, 'storePosev'])->name('posev.add')->middleware('auth');
Route::get('/posev_add', [InfoController::class, 'showAddPosevForm'])->name('posev_add')->middleware('auth');

Route::get('/test', [InfoController::class, 'showTestForm'])->name('test');
Route::post('/test', [InfoController::class, 'showTest'])->name('test.show');

Route::get('/login', [InfoController::class, 'showLoginForm'])->name('login');
Route::get('/register', [InfoController::class, 'showRegisterForm'])->name('register');


Route::get('/limit_add',[LimitsController::class, 'showLimitForm'])->name('limit_add')->middleware('can:destroy, App\Models\svyaz');;
Route::post('/limit_add', [LimitsController::class, 'storeLimit'])->name('limit.save')->middleware('can:destroy, App\Models\svyaz');
Route::post('/parser_add', [LimitsController::class, 'parserLimit'])->name('parser.save')->middleware('can:destroy, App\Models\svyaz');;
Route::delete('/limit_delete/{limitID}', [LimitsController::class, 'limitdestroy'])->name('limit.destroy')->middleware('can:destroy, App\Models\svyaz');




Route::get('/limit_view/{phoneDetail?}',

    [LimitsController::class, 'showLimit'])
    ->name('limit_view')
    ->middleware('can:limitView, App\Models\svyaz')
    ->where('phoneDetail','[0-9]+');



Route::get('/edit_limit/{limitID}', [LimitsController::class, 'limitEdit'])->name('limit.edit')->middleware('can:destroy, App\Models\svyaz');;

Route::get('/profile', [RegistrationController::class, 'profileShow'])->name('profile.show')->middleware('auth');
Route::post('/profile', [RegistrationController::class, 'storeProfile'])->name('store.profile')->middleware('auth');

Route::get('/unifi', [RegistrationController::class, 'unifi'])->name('unifi_show');

Route::get('/activation', [ActivationController::class, 'activation'])->name('activation.show')->middleware('can:destroy, App\Models\svyaz');
Route::get('/user/{id}', [ActivationController::class, 'userView'])->name('user.view')->middleware('can:destroy, App\Models\svyaz');
Route::delete( '/user/edit/{id}', [ActivationController::class, 'userEdit'])->name('user.edit')->middleware('can:destroy, App\Models\svyaz');
Route::delete( '/user/activation/{id}', [ActivationController::class, 'userActivation'])->name('user.activation')->middleware('can:destroy, App\Models\svyaz');

Route::get('/home', [InfoController::class, 'index_g'])->name('home');

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

Route::get('/storage_add', [BoxController::class, 'storageShow']);
Route::post('/storage_add', [BoxController::class, 'storageAdd'])->name('storage.add');
Route::get('/box_filling', [BoxController::class, 'boxFillingShow'])->name('box_filling')->middleware('can:destroy, App\Models\svyaz');
Route::post('/box_filling', [BoxController::class, 'boxFillingAdd'])->name('box.filling')->middleware('can:destroy, App\Models\svyaz');;
Route::get('/box_disssembly_show/d/{id}', [BoxController::class, 'boxDisssemblyShow'])->middleware('can:destroy, App\Models\svyaz');;
Route::get('/box_sampling_show/s/{id}', [BoxController::class, 'boxSamplingShow'])->middleware('can:destroy, App\Models\svyaz');;
Route::post('/box_disssembly_show', [BoxController::class, 'boxDisssemblyAdd'])->name('box.disassembly')->middleware('can:destroy, App\Models\svyaz');;
Route::post('/box_sampling_show', [BoxController::class, 'boxSamplingAdd'])->name('box.sampling')->middleware('can:destroy, App\Models\svyaz');
Route::get('/box_itog', [BoxController::class, 'boxItog']);
Route::get('/storage/detail/{id}', [BoxController::class, 'storageDetail']);

Route::post('/sms_get', [SmsController::class, 'smsGet'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::post('/sms_in', [SmsController::class, 'smsIn'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->middleware('throttle:smsIn');

Route::get('/voucher_get', [SmsController::class, 'voucherGetShow'])->name('voucher');
Route::post('/voucher_get', [SmsController::class, 'voucherGet'])->name('voucher.get');


Route::resource('pole', PoleController::class);

Route::resource('pole.sevooborot', \App\Http\Controllers\SevooborotController::class)->middleware('auth');


Route::get('/poliv_add', [PolivController::class, 'polivAddShow'])->name('poliv_add')->middleware('auth');;
Route::get('/poliv_show/{filial_id?}/{pole_id?}', [PolivController::class, 'polivShow'])->name('poliv.view');
Route::post('/poliv_add', [PolivController::class, 'polivAdd'])->name('poliv.add')->middleware('auth');
Route::get('/poliv_edit/{polivId}', [PolivController::class, 'polivEdit'])->name('poliv_edit')->middleware('can:viewAny, App\Models\Poliv');;
Route::delete('/poliv_delete/{poliv}', [PolivController::class, 'polivdestroy'])->name('poliv.destroy')->middleware('can:delete,poliv');


Route::get('/sokar', [\App\Http\Controllers\SokarController::class, 'index'])->name('index.get');


Route::resource('size', \App\Http\Controllers\SizeController::class);
Route::resource('color', \App\Http\Controllers\ColorController::class);
Route::resource('counterparty', \App\Http\Controllers\CounterpartyController::class);
Route::resource('height', \App\Http\Controllers\HeightController::class);
Route::resource('sokarsklad', \App\Http\Controllers\SokarSkladController::class);
Route::resource('sokarnomenklat', \App\Http\Controllers\SokarNomenklatController::class);
Route::resource('sokarfio', \App\Http\Controllers\SokarFIOController::class);
Route::resource('spisanie', \App\Http\Controllers\SokarSpisanieController::class);
Route::post('/spisanieDate', [\App\Http\Controllers\SokarSpisanieController::class, 'spisanieDate'])->name('spisanie.spisanieDate');

Route::get('/spraying/report/{id?}', [\App\Http\Controllers\SprayingReportController::class, 'index'])->name('spraying.report.index');
Route::post('/spraying/report/{id}', [\App\Http\Controllers\SprayingReportController::class, 'report'])->name('spraying.report.show');
Route::resource('nomenklature', \App\Http\Controllers\NomenklatureController::class);
Route::resource('kultura', InfoController::class);//->only(['index', 'show']); /// Дописать

Route::resource('szrclass', \App\Http\Controllers\SzrClassesController::class);
Route::resource('filial', \App\Http\Controllers\FilialController::class);
Route::resource('szr', \App\Http\Controllers\SzrController::class);

Route::resource('spraying', \App\Http\Controllers\SprayingController::class);



Auth::routes();




