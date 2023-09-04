<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

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
Route::post('/login', [Api::class, 'login'])->name('login');
Route::get('/test', function () {
    return response()->json([
        'message' => 'Hello World!',
    ], 200);
});
Route::get('/properties', [Api::class, 'properties'])->name('properties');
Route::post('/propertyDetail', [Api::class, 'propertyDetail'])->name('propertyDetail');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');
    Route::get('/userProperties', [Api::class, 'userProperties'])->name('userProperties');
    Route::post('/transactionList', [Api::class, 'transactionList'])->name('transactionList');
    Route::post('/transactionDetail', [Api::class, 'transactionDetail'])->name('transactionDetail');
    Route::post('/profileUpdate', [Api::class, 'profileUpdate'])->name('resetPassword');
    Route::post('/resetPassword', [Api::class, 'resetPassword'])->name('resetPassword');
    Route::post('/logout',[Api::class,'userLogout'])->name('logout');
});

