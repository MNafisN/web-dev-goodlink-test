<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

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

Route::group([
    'prefix' => 'member'
], function() {
    Route::post('register', [MemberController::class, 'register']);
    Route::post('login', [MemberController::class, 'login']);
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::post('logout', [MemberController::class, 'logout']);
        Route::post('refresh', [MemberController::class, 'refresh']);
        Route::get('data', [MemberController::class, 'data']);
    });
});