<?php

use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('index');
})->name('index');


// Auth::routes();
Route::get('/login',function(){
    return view('auth.login');
})->name('login');
Route::get('/register',function(){
    return view('auth.register');
})->name('register');
Route::post('data-register',[HomeController::class,'custom_register'])->name('data-register');
Route::post('data-login',[HomeController::class,'custom_login'])->name('data-login');
Route::post('logout',[HomeController::class,'logout'])->name('logout');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

