<?php

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
});

Route::middleware('web')->group(function (){

    Route::get('grant-access/{clientId}',[\App\Http\Api\AuthenticationController::class,'grantAccess'])->name('grant-access');
    Route::get('callback', [\App\Http\Api\AuthenticationController::class,'callback']);

});
