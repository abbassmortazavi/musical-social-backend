<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SongController;
use App\Http\Controllers\Api\SongsByUserController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('inside-mware', function () {
        return response()->json('Success', ResponseAlias::HTTP_OK);
    });
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user/show/{id}', [UserController::class, 'show']);
    Route::put('user/update/{id}', [UserController::class, 'update']);

    Route::post('songs', [SongController::class, 'store']);
    Route::delete('delete/song/{id}/{user_id}', [SongController::class, 'destroy']);
    Route::get('user/{user_id}/songs', [SongsByUserController::class, 'index']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');

});
