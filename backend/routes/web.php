<?php

use App\Helpers\WalletHelpers;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('singin');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/test', function () {
    $user = \App\Models\User::find(15);
    dd(\App\Models\Box::find(4)->boughtHints($user)->get());
});
