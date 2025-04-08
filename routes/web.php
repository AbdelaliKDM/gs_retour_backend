<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Template\Analytics;
use App\Http\Controllers\Template\MiscError;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Template\LoginBasic;
use App\Http\Controllers\Template\LogoutBasic;
use App\Http\Controllers\Web\NoticeController;
use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\SettingController;
use App\Http\Controllers\Template\RegisterBasic;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\TruckTypeController;
use App\Http\Controllers\Web\SubcategoryController;
use App\Http\Controllers\Web\ShipmentTypeController;
use App\Http\Controllers\Template\ForgotPasswordBasic;
use App\Http\Controllers\Template\MiscUnderMaintenance;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$controller_path = 'App\Http\Controllers';

Route::group(['middleware' => ['auth']], function () {
  Route::get('/theme/{theme}', function ($theme) {
    Session::put('theme', $theme);
    return redirect()->back();
  });

  Route::get('/lang/{lang}', function ($lang) {
    Session::put('locale', $lang);
    App::setLocale($lang);
    return redirect()->back();
  });
});


Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics')->middleware('auth');

Route::group(['middleware' => ['auth']], function () {
  Route::get('/error', [MiscError::class, 'index'])->name('pages-misc-error');
  Route::get('/under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');
});

Route::prefix('auth')->group(function () {
  Route::get('/login-basic', [LoginBasic::class, 'index'])->name('login');
  Route::get('/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
  Route::post('/register-action', [RegisterBasic::class, 'register']);
  Route::post('/login-action', [LoginBasic::class, 'login']);
  Route::get('/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
  Route::get('/logout', [LogoutBasic::class, 'logout'])->name('auth-logout');
});

//admin routes

Route::middleware(['auth:sanctum', 'api.role:admin'])->group(function () {

  Route::name('user.')->group(function () {
    Route::get('user/index', [UserController::class, 'index'])->name('user');
    Route::get('renter/index', [UserController::class, 'index'])->name('renter');
    Route::get('driver/index', [UserController::class, 'index'])->name('driver');
  });

  Route::prefix('user')->name('user.')->group(function () {
    Route::post('/list', [UserController::class, 'list'])->name('list');
    Route::post('/create', [UserController::class, 'create']);
    Route::post('/update', [UserController::class, 'update']);
    Route::post('/delete', [UserController::class, 'delete']);
    Route::post('/get', [UserController::class, 'get']);
  });

  Route::prefix('category')->name('category.')->group(function () {
    Route::get('/index', [CategoryController::class, 'index'])->name('index');
    Route::post('/list', [CategoryController::class, 'list'])->name('list');
    Route::post('/create', [CategoryController::class, 'create']);
    Route::post('/update', [CategoryController::class, 'update']);
    Route::post('/delete', [CategoryController::class, 'delete']);
    Route::post('/restore', [CategoryController::class, 'restore']);
    Route::post('/get', [CategoryController::class, 'get']);
  });

  Route::prefix('subcategory')->name('subcategory.')->group(function () {
    Route::get('/index', [SubcategoryController::class, 'index'])->name('index');
    Route::post('/list', [SubcategoryController::class, 'list'])->name('list');
    Route::post('/create', [SubcategoryController::class, 'create']);
    Route::post('/update', [SubcategoryController::class, 'update']);
    Route::post('/delete', [SubcategoryController::class, 'delete']);
    Route::post('/restore', [SubcategoryController::class, 'restore']);
    Route::post('/get', [SubcategoryController::class, 'get']);
  });

  Route::prefix('truckType')->name('truck.type.')->group(function () {
    Route::get('/index', [TruckTypeController::class, 'index'])->name('index');
    Route::post('/list', [TruckTypeController::class, 'list'])->name('list');
    Route::post('/create', [TruckTypeController::class, 'create']);
    Route::post('/update', [TruckTypeController::class, 'update']);
    Route::post('/delete', [TruckTypeController::class, 'delete']);
    Route::post('/restore', [TruckTypeController::class, 'restore']);
    Route::post('/get', [TruckTypeController::class, 'get']);
  });

  Route::prefix('shipmentType')->name('shipment.type.')->group(function () {
    Route::get('/index', [ShipmentTypeController::class, 'index'])->name('index');
    Route::post('/list', [ShipmentTypeController::class, 'list'])->name('list');
    Route::post('/create', [ShipmentTypeController::class, 'create']);
    Route::post('/update', [ShipmentTypeController::class, 'update']);
    Route::post('/delete', [ShipmentTypeController::class, 'delete']);
    Route::post('/restore', [ShipmentTypeController::class, 'restore']);
    Route::post('/get', [ShipmentTypeController::class, 'get']);
  });

  Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/wallet', [PaymentController::class, 'index'])->name('wallet');
    Route::get('/invoice', [PaymentController::class, 'index'])->name('invoice');
    Route::post('/list', [PaymentController::class, 'list'])->name('list');
    Route::post('/update', [PaymentController::class, 'update']);
    Route::post('/delete', [PaymentController::class, 'delete']);
    Route::post('/get', [PaymentController::class, 'get']);
  });

  Route::prefix('settings')->group(function () {
    Route::get('/', [SettingController::class, 'index']);
    Route::post('/update', [SettingController::class, 'update']);
  });

  Route::prefix('account')->group(function () {
    Route::get('/', [AccountController::class, 'index']);
    Route::post('/update', [AccountController::class, 'update']);
    Route::post('/password/change', [AccountController::class, 'change_password']);
  });

   Route::prefix('notice')->group(function () {
       Route::get('/index', [NoticeController::class, 'index'])->name('index');
    Route::post('/list', [NoticeController::class, 'list'])->name('list');
    Route::post('/create', [NoticeController::class, 'create']);
    Route::post('/update', [NoticeController::class, 'update']);
    Route::post('/delete', [NoticeController::class, 'delete']);
    Route::post('/send', [NoticeController::class, 'send']);
  });

  /*

  Route::post('documentation/update', [DocumentationController::class, 'update']);
  Route::post('setting/update', [SettingController::class, 'update']);

  */

});
