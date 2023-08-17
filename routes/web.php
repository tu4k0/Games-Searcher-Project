<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'loginUser')->name('login_user');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'registerUser')->name('register_user');
    Route::get('authorized/google', 'redirectToGoogleAuthForm')->name('google_auth_form');
    Route::get('authorized/google/callback', 'authUserViaGoogle');
});


