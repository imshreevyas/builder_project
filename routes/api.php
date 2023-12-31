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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');
    Route::get('/properties', [Api::class, 'properties'])->name('properties');
});
Route::post('/login', [Api::class, 'login'])->name('login');
Route::get('/test', function () {
    return response()->json([
        'message' => 'Hello World!',
    ], 200);
});
