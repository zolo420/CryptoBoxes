<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\{
    DashboardController,
    AdminController,
    DataTableController,
    UsersController,
    HintsController,
    SettingsController,
    StatisticsController,
    BoxController,
    LogsController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'cp'], function () {
    Route::get('', [DashboardController::class, 'index'])->name('cp.dashbaord.index');

    Route::group(['prefix' => 'users'], function () {
        Route::get('', [UsersController::class, 'index'])->name('cp.users.index');
        Route::get('transaction-history/{user_id}', [UsersController::class, 'transactionHistory'])->name('cp.user.transaction_history')->where('user_id', '[0-9]+');
    });

    Route::group(['prefix' => 'admins'], function () {
        Route::get('', [AdminController::class, 'index'])->name('cp.admin.index');
        Route::get('create', [AdminController::class, 'create'])->name('cp.admin.create');
        Route::post('create', [AdminController::class, 'store'])->name('cp.admin.store');
        Route::get('edit/{id}', [AdminController::class, 'edit'])->name('cp.admin.edit')->where('id', '[0-9]+');
        Route::put('update', [AdminController::class, 'update'])->name('cp.admin.update');
        Route::post('destroy', [AdminController::class, 'destroy'])->name('cp.admin.destroy');
    });

    Route::group(['prefix' => 'hints'], function () {
        Route::get('', [HintsController::class, 'index'])->name('cp.hints.index');
        Route::get('create', [HintsController::class, 'create'])->name('cp.hints.create');
        Route::post('create', [HintsController::class, 'store'])->name('cp.hints.store');
        Route::get('edit/{id}', [HintsController::class, 'edit'])->name('cp.hints.edit')->where('id', '[0-9]+');
        Route::put('update', [HintsController::class, 'update'])->name('cp.hints.update');
        Route::post('destroy', [HintsController::class, 'destroy'])->name('cp.hints.destroy');
    });

    Route::group(['prefix' => 'statistics'], function () {
        Route::get('', [StatisticsController::class, 'index'])->name('cp.statistics.index');
    });

    Route::group(['prefix' => 'box'], function () {
        Route::get('', [BoxController::class, 'index'])->name('cp.box.index');
        Route::get('create', [BoxController::class, 'create'])->name('cp.box.create');
        Route::post('create', [BoxController::class, 'store'])->name('cp.box.store');
        Route::get('edit/{id}', [BoxController::class, 'edit'])->name('cp.box.edit')->where('id', '[0-9]+');
        Route::put('update', [BoxController::class, 'update'])->name('cp.box.update');
        Route::post('destroy', [BoxController::class, 'destroy'])->name('cp.box.destroy');
        Route::post('archive', [BoxController::class, 'archive'])->name('cp.box.archive');
        Route::get('statistics/{id}', [BoxController::class, 'statistics'])->name('cp.box.statistics')->where('id', '[0-9]+');
    });

    Route::prefix('logs')->group(function () {
        Route::get('/', [LogsController::class, 'index'])->name('cp.logs.index');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('', [SettingsController::class, 'index'])->name('cp.settings.index');
        Route::get('create', [SettingsController::class, 'create'])->name('cp.settings.create');
        Route::post('create', [SettingsController::class, 'store'])->name('cp.settings.store');
        Route::get('edit/{id}', [SettingsController::class, 'edit'])->name('cp.settings.edit')->where('id', '[0-9]+');
        Route::put('update', [SettingsController::class, 'update'])->name('cp.settings.update');
        Route::post('destroy', [SettingsController::class, 'destroy'])->name('cp.settings.destroy');
    });

    Route::group(['prefix' => 'datatable'], function () {
        Route::any('users', [DataTableController::class, 'getUsers'])->name('cp.datatable.users');
        Route::any('admin', [DataTableController::class, 'getAdmin'])->name('cp.datatable.admin');
        Route::any('settings', [DataTableController::class, 'getSettings'])->name('cp.datatable.settings');
        Route::any('hints', [DataTableController::class, 'getHints'])->name('cp.datatable.hints');
        Route::any('box', [DataTableController::class, 'getBox'])->name('cp.datatable.box');
        Route::any('members/{box_id}', [DataTableController::class, 'getMembers'])->name('cp.datatable.members')->where('box_id', '[0-9]+');
        Route::any('transaction-history/{user_id}', [DataTableController::class, 'transactionHistory'])->name('cp.datatable.transaction_history')->where('user_id', '[0-9]+');
        Route::any('box-payment-history/{user_id}', [DataTableController::class, 'boxPaymentHistory'])->name('cp.datatable.box_payment_history')->where('user_id', '[0-9]+');
        Route::any('logs', [DataTableController::class, 'getLogs'])->name('cp.datatable.logs');
    });

});










