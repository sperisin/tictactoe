<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
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



Route::post('user/register', [UserController::class, 'register']);
Route::post('user/login', [UserController::class, 'login']);
Route::get('user/profile', [UserController::class, 'profile']);
Route::get('game/index', [GameController::class, 'index']);
Route::post('game/create', [UserController::class, 'create']);
Route::get('game/join', [GameController::class, 'join']);
Route::get('game/fields', [GameController::class, 'fields']);
Route::get('game/move', [GameController::class, 'move']);
