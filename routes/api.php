<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\IsAdmin;

Route::post('/register',[UserController::class, 'register']);
Route::post('/login',[UserController::class, 'login']);
Route::get('/logout',[UserController::class, 'logout']);

Route::group(['middleware' => 'jwt.auth'], function (){
    Route::get('/user',[UserController::class, 'show']);

    Route::post('/accounts',[AccountController::class, 'create']);
    Route::get('/accounts',[AccountController::class, 'show']);
    Route::delete('/accounts',[AccountController::class, 'destroy']);

    Route::post('/transactions',[TransactionController::class, 'create']);
    Route::get('/transactions',[TransactionController::class, 'show']);

    Route::get('/transactions',[TransactionController::class, 'show']);

    Route::middleware(IsAdmin::class)->group(function (){
        Route::post('/block/{user}',[AdminController::class, 'block']);
        Route::post('/unlock/{user}',[AdminController::class, 'unlock']);
        Route::get('/accounts/{id}',[AdminController::class, 'showFromCache']);
        Route::delete('/accounts/{user}',[AdminController::class, 'destroy']);
    });
});
