<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DrawController;
use App\Http\Controllers\WelcomeController;

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


use App\Http\Controllers\LotteryController;

Route::get('/', [WelcomeController::class, 'index']);
Route::post('/withdraw', [WelcomeController::class, 'withdraw'])->name('lottery.withdraw');

Route::get('/lotteries', [LotteryController::class, 'index']);
Route::get('/draw', [LotteryController::class, 'draw']); //
Route::get('/draws', [DrawController::class, 'index']);
Route::post('/ticket', [TicketController::class, 'store']);
Route::get('/draw', [DrawController::class, 'draw']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/guest/signup', [GuestController::class, 'showSignupForm'])->name('guest.signup');
Route::post('/guest/signup', [GuestController::class, 'signup']);
Route::get('/guest/login', [GuestController::class, 'showLoginForm'])->name('guest.login');
Route::post('/guest/login', [GuestController::class, 'login']);

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});