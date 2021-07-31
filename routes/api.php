<?php


use App\Http\Controllers\BoardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::post('/change-password',[AuthController::class, 'changePassword']);




});

Route::prefix('list')->middleware('jwt')->group(function (){
    Route::get('{board_id}/show',[ListController::class,'showListByBoardId'])->name('list.show');
});

Route::post('list/store',[ListController::class,'store'])->name('list.store');
Route::post('list/move',[ListController::class,'moveList'])->name('list.move');


Route::prefix('board')->middleware('jwt')->group(function (){
    Route::post('store',[BoardController::class,'store'])->name('board.store');
    Route::get('/get' , [BoardController::class , 'getBoardByUserID']);
    Route::post('/add' , [BoardController::class , 'addBoard']);
});

