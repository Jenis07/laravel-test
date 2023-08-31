<?php

use App\Http\Controllers\TaskController;
use App\Http\Middleware\customAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(customAuth::class)->group(function(){
    Route::post('/todo/add',[TaskController::class,'add'])->name('addtodo');
    Route::post('/todo/status',[TaskController::class,'updateStatus'])->name('updateStatus');
});
