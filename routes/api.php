<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;

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
Route::post('/login',[App\Http\Controllers\PassportAuthController::class, 'login'])->name('login.api');
Route::post('/register', [App\Http\Controllers\PassportAuthController::class, 'register'])->name('register.api');

Route::middleware('auth:api')->group(function () {
  Route::post('/logout', [App\Http\Controllers\PassportAuthController::class, 'logout'])->name('logout.api');
});







