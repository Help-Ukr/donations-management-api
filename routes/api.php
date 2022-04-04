<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\CollectPointController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

Route::middleware('throttle')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::apiResource('item-category', ItemCategoryController::class)->only(['index']);
        Route::get('collect-point/my', [CollectPointController::class, 'getMyPoints'])->name('collect-point.my');
        Route::apiResource('collect-point', CollectPointController::class)->except('destroy');
        Route::get('/logout', LogoutController::class)->name('user.logout');
    });

    Route::post('/login', LoginController::class)->name('user.login');
});