<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware("auth:sanctum")->group(function() {

    Route::post('logout', [AuthController::class, 'logout']);

    Route::controller(UserController::class)->group(function(){
        Route::get('users', 'index');
        Route::post('users', 'store');
        Route::get('users/permission', 'userPermission');
        Route::get('users/{id}', 'show');
        Route::put('users/{id}', 'update');
        Route::delete('users/{id}', 'destroy');
    });

    Route::controller(RoleController::class)->group(function(){
        Route::get('roles',  'index');
        Route::post('roles',  'store');
        Route::get('roles/{id}', 'show');
        Route::put('roles/{id}', 'update');
    });

});
