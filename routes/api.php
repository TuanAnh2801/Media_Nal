<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MediaController;


Route::post('/auth/login', [
    AuthController::class, 'login'
])->name('login');
Route::post('/auth/refresh', [
    AuthController::class, 'refresh'
]);
Route::post('/auth/logout', [
    AuthController::class, 'logout']);

Route::post('/auth/register', [
    AuthController::class, 'register'
]);

Route::post('/auth/me', [
    AuthController::class, 'me'
])->name('me');
//Route::middleware('jwt.auth')->group(function () {
Route::get('/index', [MediaController::class, 'index']);
Route::delete('/delete/{media}', [MediaController::class, 'destroy']);
Route::post('/create', [MediaController::class, 'store']);
Route::post('/update/{media}', [MediaController::class, 'update']);


//});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
