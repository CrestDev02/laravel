<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('user', UserController::class);
    Route::post('/user/check-email-exist', [UserController::class, 'checkEmailExist'])->name('user.checkEmail');
});
