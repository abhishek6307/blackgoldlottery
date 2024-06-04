<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DrawController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PaymentController;

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

Route::post('/lottery/payment', [PaymentController::class, 'initiatePayment'])->name('lottery.payment');

// Route for handling payment callback
Route::get('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');
use App\Http\Controllers\LotteryController;

Route::get('/', [WelcomeController::class, 'index']);
Route::post('/withdraw', [WelcomeController::class, 'withdraw'])->name('lottery.withdraw');

Route::get('/lotteries', [LotteryController::class, 'index']);
Route::get('/draw', [LotteryController::class, 'draw']);
Route::post('/ticket', [TicketController::class, 'store']);

Auth::routes();



Route::get('/guest/signup', [GuestController::class, 'showSignupForm'])->name('guest.signup');
Route::post('/guest/signup', [GuestController::class, 'signup']);
Route::get('/guest/login', [GuestController::class, 'showLoginForm'])->name('guest.login');
Route::post('/guest/login', [GuestController::class, 'login']);


Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile')->middleware('auth');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});