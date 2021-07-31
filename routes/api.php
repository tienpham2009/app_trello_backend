<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserBoardController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ListController;


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
//
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/register', [AuthController::class, 'register']);


    Route::get('/boards' , [BoardController::class , 'getBoardByUserID']);
    Route::post('/boards' , [BoardController::class , 'addBoard']);


});

Route::prefix('list')->middleware('jwt')->group(function (){
    Route::post('store',[ListController::class,'store'])->name('list.store');
    Route::get('{board_id}/show',[ListController::class,'showListByBoardId'])->name('list.show');
});


Route::apiResource('add_user',UserBoardController::class);

Route::prefix('board')->middleware('jwt')->group(function (){
    Route::post('store',[BoardController::class,'store'])->name('board.store');
});

Route::post('/add_image' , [AuthController::class , 'addImage']);
