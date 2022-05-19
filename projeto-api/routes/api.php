<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\V1\CourseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Routes Users
Route::get('/users', [UserController::class,'index']); 
Route::get('/user/email={email}', [UserController::class, 'showEmail']);
Route::get('/user/document={document}', [UserController::class, 'showDocument']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/user', [UserController::class, 'store']);
Route::delete('/user/delete/{id}', [UserController::class, 'delete']);
Route::put('/user/update/{id}', [UserController::class, 'update']);

//Routs Transaction
Route::get('/transactions', [TransactionController::class, 'index']);
Route::get('/transactions/{id}', [TransactionController::class, 'show']);


//Routs Wallets
Route::get('/wallet/{id}', [WalletController::class, 'show']);
Route::get('/wallets', [WalletController::class, 'index']);
Route::post('/deposit', [WalletController::class, 'deposit']);
Route::post('/transfer', [WalletController::class, 'transfer']);
Route::post('/withdraw', [WalletController::class, 'withdraw']);


 Route::fallback(function(){
     return "URL não encontrada!";
}); 

