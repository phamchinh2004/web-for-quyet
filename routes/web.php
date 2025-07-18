<?php

use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\User\BalanceFluctuationController;
use App\Http\Controllers\User\MeController;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['role:guest'])->group(function () {
    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register');
    Route::post('register/check_referral_code', [RegisterController::class, 'check_referral_code'])->name('check_referral_code');
    Route::post('register/check_email', [RegisterController::class, 'check_email'])->name('check_email');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::get('login', [LoginController::class, 'index'])->name('login');
});
Route::get('/forgot-password', [LoginController::class, 'forgot_password'])->name('forgot_password');
Route::post('/send-new-password', [LoginController::class, 'send_new_password'])->name('send_new_password');
Route::post('login/check_username', [LoginController::class, 'check_username'])->name('check_username');
Route::post('login/check_phone', [LoginController::class, 'check_phone'])->name('check_phone');

Route::middleware(['role:member', 'checkBanned'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/distribution', [HomeController::class, 'distribution'])->name('distribution');
    Route::get('/balance-fluctuation', [BalanceFluctuationController::class, 'index'])->name('balance_fluctuation');
    Route::get('/withdraw', [HomeController::class, 'withdraw_money'])->name(name: 'withdraw_money');
    Route::get('/order', [OrderController::class, 'index'])->name('order');
    Route::get('/me', [MeController::class, 'index'])->name('me');
    Route::get('/personal-information', [MeController::class, 'personal_information'])->name('personal_information');
    Route::get('/vip', [MeController::class, 'vip'])->name('vip');
    Route::get('/get-10-order-next', [HomeController::class, 'get_10_orders_next'])->name('get_10_orders_next');
    Route::get('/check-frozen-order', [HomeController::class, 'check_frozen_order'])->name('check_frozen_order');
    Route::post('/get-list-orders-by-tab', [OrderController::class, 'get_list_orders_by_tab'])->name(name: 'get_list_orders_by_tab');
    Route::post('/handle-distribution', [OrderController::class, 'handle_distribution'])->name('handle_distribution');
    Route::post('/handle-withdraw', [HomeController::class, 'handle_withdraw'])->name('handle_withdraw');
    Route::post('/bank_link', [HomeController::class, 'bank_link'])->name('bank_link');
    Route::post('change-password', [LoginController::class, 'change_password'])->name('change_password');
    Route::post('change-transaction-password', [LoginController::class, 'change_transaction_password'])->name('change_transaction_password');
    Route::post('/reset-transaction-password', [LoginController::class, 'reset_transaction_password'])->name('reset_transaction_password');
});
Route::get('/log-out', [LoginController::class, 'log_out'])->name('logout')->middleware('auth');
Route::get('/log-out-by-locked', [LoginController::class, 'log_out_by_locked'])->name('log_out_by_locked')->middleware('auth');
Route::post('/change-language', [LanguageController::class, 'change'])->name('language.change');
Route::get('/debug-broadcast', function () {
    return [
        'broadcast_driver' => config('broadcasting.default'),
        'reverb_host' => config('broadcasting.connections.reverb.options.host'),
        'reverb_port' => config('broadcasting.connections.reverb.options.port'),
    ];
});
