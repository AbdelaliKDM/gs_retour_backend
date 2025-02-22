<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TruckTypeController;
use App\Http\Controllers\TruckImageController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\DocumentationController;

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

  #truck routes
  Route::prefix('truck')->middleware('auth:sanctum')->middleware('api.role:driver')->group(function () {
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
    Route::get('/get', [TripController::class, 'get']);
    Route::middleware('api.role:driver')->group(function () {
      Route::post('/create', [TripController::class, 'create']);
      Route::post('/update', [TripController::class, 'update']);
      Route::post('/delete', [TripController::class, 'delete']);
      Route::post('/restore', [TripController::class, 'restore']);
    });
});

  //public routes
  Route::post('documentation/get', [DocumentationController::class, 'get']);
  Route::post('setting/get', [SettingController::class, 'get']);
  Route::post('category/get', [CategoryController::class, 'get']);
  Route::post('subcategory/get', [SubcategoryController::class, 'get']);
  Route::post('truck/type/get', [TruckTypeController::class, 'get']);

  //admin routes

  Route::middleware(['auth:sanctum', 'api.role:admin'])->group(function () {

      Route::post('documentation/update', [DocumentationController::class, 'update']);
      Route::post('setting/update', [SettingController::class, 'update']);

      Route::prefix('user')->middleware('auth:sanctum')->group(function () {
        Route::post('/update', [UserController::class, 'update']);
        Route::post('/delete', [UserController::class, 'delete']);
      });

      Route::prefix('category')->group(function () {
        Route::post('/create', [CategoryController::class, 'create']);
        Route::post('/update', [CategoryController::class, 'update']);
        Route::post('/delete', [CategoryController::class, 'delete']);
        Route::post('/restore', [CategoryController::class, 'restore']);
      });

      Route::prefix('subcategory')->group(function () {
        Route::post('/create', [SubcategoryController::class, 'create']);
        Route::post('/update', [SubcategoryController::class, 'update']);
        Route::post('/delete', [SubcategoryController::class, 'delete']);
        Route::post('/restore', [SubcategoryController::class, 'restore']);
      });

      Route::prefix('truck/type')->group(function () {
        Route::post('/create', [TruckTypeController::class, 'create']);
        Route::post('/update', [TruckTypeController::class, 'update']);
        Route::post('/delete', [TruckTypeController::class, 'delete']);
        Route::post('/restore', [TruckTypeController::class, 'restore']);
      });

  });











});




