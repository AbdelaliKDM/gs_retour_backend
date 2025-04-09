<?php

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TripController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\TruckController;
use App\Http\Controllers\API\NoticeController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\WalletController;
use App\Http\Controllers\API\WilayaController;
use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\SettingController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\FavoriteController;
use App\Http\Controllers\API\ShipmentController;
use App\Http\Controllers\API\TruckTypeController;
use App\Http\Controllers\API\TruckImageController;
use App\Http\Controllers\API\SubcategoryController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\ShipmentTypeController;
use App\Http\Controllers\API\DocumentationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1')->group(function () {
  //auth routes
  Route::post('auth/login', [AuthController::class, 'login']);
  Route::get('auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

  #account routes
  Route::prefix('account')->middleware('auth:sanctum')->group(function () {
    Route::get('/get', [AccountController::class, 'get']);
    Route::post('/update', [AccountController::class, 'update']);
    Route::get('/delete', [AccountController::class, 'delete']);
  });

  Route::prefix('driver')->middleware(['auth:sanctum', 'api.role:driver'])->group(function () {
    Route::post('/nearby', [UserController::class, 'nearby']);
  });

  #truck routes
  Route::prefix('truck')->middleware(['auth:sanctum', 'api.role:driver'])->group(function () {
    Route::get('/get', [TruckController::class, 'get']);
    Route::post('/create', [TruckController::class, 'create']);
    Route::post('/update', [TruckController::class, 'update']);
  });

  Route::prefix('truck/image')->middleware(['auth:sanctum', 'api.role:driver'])->group(function () {
    Route::post('/get', [TruckImageController::class, 'get']);
    Route::post('/create', [TruckImageController::class, 'create']);
    Route::post('/delete', [TruckImageController::class, 'delete']);

  });

  #trip routes
  Route::prefix('trip')->middleware('auth:sanctum')->group(function () {
    Route::post('/get', [TripController::class, 'get']);
    Route::middleware('api.role:driver')->group(function () {
      Route::post('/create', [TripController::class, 'create']);
      Route::post('/update', [TripController::class, 'update']);
      Route::post('/delete', [TripController::class, 'delete']);
      Route::post('/restore', [TripController::class, 'restore']);
    });
  });

  #shipment routes
  Route::prefix('shipment')->middleware('auth:sanctum')->group(function () {
    Route::post('/get', [ShipmentController::class, 'get']);
    Route::post('/update', [ShipmentController::class, 'update']);
    Route::middleware('api.role:renter')->group(function () {
      Route::post('/create', [ShipmentController::class, 'create']);
      Route::post('/delete', [ShipmentController::class, 'delete']);
      Route::post('/restore', [ShipmentController::class, 'restore']);
    });
  });

  #order routes
  Route::prefix('order')->middleware('auth:sanctum')->group(function () {
    Route::post('/create', [OrderController::class, 'create']);
    Route::post('/update', [OrderController::class, 'update']);
    Route::post('/delete', [OrderController::class, 'delete']);
    Route::post('/get', [OrderController::class, 'get']);
  });

  #favorite routes
  Route::prefix('favorite')->middleware('auth:sanctum')->group(function () {
    Route::post('/toggle', [FavoriteController::class, 'toggle']);
    Route::get('/get', [FavoriteController::class, 'get']);
  });

  #review routes
  Route::prefix('review')->middleware('auth:sanctum')->group(function () {
    Route::post('/get', [ReviewController::class, 'get']);
    Route::middleware('api.role:renter')->group(function () {
      Route::post('/create', [ReviewController::class, 'create']);
      Route::post('/update', [ReviewController::class, 'update']);
      Route::post('/delete', [ReviewController::class, 'delete']);
      Route::post('/restore', [ReviewController::class, 'restore']);
    });
  });

  #wallet routes
  Route::prefix('wallet')->middleware(['auth:sanctum', 'api.role:driver'])->group(function () {
    Route::get('/get', [WalletController::class, 'get']);
    Route::post('/charge', [WalletController::class, 'charge']);
  });

  #invoice routes
  Route::prefix('invoice')->middleware(['auth:sanctum', 'api.role:driver'])->group(function () {
    Route::post('/get', [InvoiceController::class, 'get']);
    Route::post('/pay', [InvoiceController::class, 'pay']);
  });

  #transaction routes
  Route::prefix('transaction')->middleware(['auth:sanctum', 'api.role:driver'])->group(function () {
    Route::post('/get', [TransactionController::class, 'get']);
  });

  #notification routes
  Route::prefix('notification')->middleware('auth:sanctum')->group(function () {
    Route::post('/read', [NotificationController::class, 'read']);
    Route::get('/get', [NotificationController::class, 'get']);
  });

  #payment routes
  Route::prefix('payment')->middleware(['auth:sanctum', 'api.role:driver'])->group(function () {
    //Route::post('/update', [PaymentController::class, 'update']);
    Route::post('/get', [PaymentController::class, 'get']);
  });

  //public routes
  Route::post('documentation/get', [DocumentationController::class, 'get']);
  Route::post('setting/get', [SettingController::class, 'get']);
  Route::post('category/get', [CategoryController::class, 'get']);
  Route::post('subcategory/get', [SubcategoryController::class, 'get']);
  Route::post('truck/type/get', [TruckTypeController::class, 'get']);
  Route::post('shipment/type/get', [ShipmentTypeController::class, 'get']);
  Route::post('wilaya/get', [WilayaController::class, 'get']);
  Route::post('price/get', [SettingController::class, 'distance_price']);
});




