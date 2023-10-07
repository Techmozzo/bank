<?php

use App\Http\Controllers\BankerController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\SetupController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConfirmationRequestController;
use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Auth;

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

// Route::group(['middleware' => 'https'], function () {

Route::get('/', [LoginController::class, 'showLoginForm']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/setup', [SetupController::class, 'index'])->name('setup');

Route::group(['middleware' => ['auth', 'block']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::get('/{id}/email-verification', [BankerController::class, 'verification'])->name('email.verification');

Route::group(['middleware' => ['auth', 'block', 'bank.verify']], function () {

    Route::post('confirmation-requests/approve', [ConfirmationRequestController::class, 'approveRequest'])->name('approve.request');
    Route::post('confirmation-requests/decline', [ConfirmationRequestController::class, 'declineRequest'])->name('decline.request');
    Route::resource('confirmation-requests', ConfirmationRequestController::class);

    Route::post('/profile', [SettingController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile', [SettingController::class, 'profile'])->name('profile.index');

    // generate otp
    Route::get('/generate-otp/{user_id?}', OtpController::class);
});

Route::group(['middleware' => ['auth', 'banker', 'block', 'bank.verify']], function () {
    // Help Center
    Route::match(['get', 'post'], '/help-center', HelpCenterController::class)->name('help-center');
});

Route::group(['middleware' => ['auth', 'admin', 'block']], function () {

    Route::get('/bankers/{id}/verification', [BankerController::class, 'verification'])->name('bankers.verification');
    Route::get('/bankers/{id}/delete', [BankerController::class, 'destroy'])->name('bankers.delete');
    Route::get('/bankers/{id}/block', [BankerController::class, 'block'])->name('bankers.block');

    Route::resource('bankers', BankerController::class);
});
// });
