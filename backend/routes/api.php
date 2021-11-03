<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\{
    ForgotPasswordController,
    AuthController,
    ResetPasswordController,
    EmailConfirmationController,
    GoogleSocialiteController,
};

use App\Http\Controllers\Api\FrontendController;
use App\Http\Controllers\Api\ProfileController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('api.auth.login');
    Route::post('registration', [AuthController::class, 'registration'])->name('api.auth.registration');
    Route::get('info', [AuthController::class, 'info'])->name('api.auth.info');
    Route::post('forgot-password', ForgotPasswordController::class)->name('api.auth.forgot_password');
    Route::get('logout', [AuthController::class, 'logout'])->name('api.auth.logout');
    Route::post('reset', ResetPasswordController::class)->name('api.auth.reset');
    Route::any('email-confirm', EmailConfirmationController::class)->name('api.auth.email_confirm');
    Route::any('google', [GoogleSocialiteController::class, 'redirectToGoogle']);
});

Route::group(['prefix' => 'profile'], function () {
    // пригласить друга
    Route::post('send-invitation', [ProfileController::class, 'sendInvitation'])->name('api.profile.send_invitation');
    // история приглашения друзей
    Route::get('invitation-history', [ProfileController::class, 'getInvitationHistory'])->name('api.profile.invitation_history');
    // История транзакциЙ
    Route::get('transaction-history', [ProfileController::class, 'getTransactionHistory'])->name('api.profile.transaction_history');
    // запрос на получения баланса
    Route::get('balance/{cryptocurrency}', [ProfileController::class, 'getBalance'])->name('api.profile.balance');
    // редактирование профиля пользователя
    Route::post('edit', [ProfileController::class, 'edit'])->name('api.profile.edit');
    // история кейсов
    Route::get('box-payment-history', [ProfileController::class, 'getBoxPaymentHistory'])->name('api.profile.box_payment_history');
    // запрос на покупку бокса
    Route::post('buy-box', [ProfileController::class, 'buyBox'])->name('api.profile.buy_box');
    // количество бонусов
    Route::get('bonus', [ProfileController::class, 'bonus'])->name('api.profile.bonus');
    //wap
    Route::post('swap', [ProfileController::class, 'swap'])->name('api.profile.swap');
    // вывод денег
    Route::post('withdrawal', [ProfileController::class, 'withdrawal'])->name('api.profile.withdrawal');
    // список кошельков пользователя
    Route::get('wallets', [ProfileController::class, 'wallets'])->name('api.profile.wallets');

});

// запрос курса криптавалют
Route::get('rate-currency/{cryptocurrency}', [FrontendController::class, 'getRateCurrency'])->name('api.frontend.rate_currency');
// конвертируем курс в btc
Route::post('convert-to-btc', [FrontendController::class, 'convertToBTC'])->name('api.frontend.convert_to_btc');
// конвертируем курс в eth
Route::post('convert-to-eth', [FrontendController::class, 'convertToETH'])->name('api.frontend.convert_to_eth');

Route::get('box-list', [FrontendController::class, 'boxList'])->name('api.frontend.box_list');
Route::get('box-info/{box}', [FrontendController::class, 'boxInfo'])->name('api.frontend.box_info');


Route::get('seed-list', [FrontendController::class, 'seedList'])->name('api.frontend.seed_list');
// общий баланс
Route::any('total-balance', [FrontendController::class, 'totalBalance'])->name('api.frontend.total_balance');

Route::get('callback/google', [GoogleSocialiteController::class, 'handleCallback']);


