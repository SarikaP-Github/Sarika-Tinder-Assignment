<?php

use App\Http\Controllers\UserController;
use App\Http\Resources\UserCollection;
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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::get('users', [UserController::class, 'userList']);
Route::post('login', [UserController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('my-users', [UserController::class, 'userList']);

    Route::post('like-dislike', [UserController::class, 'userLikeDisLike']);
    Route::get('liked-users', [UserController::class, 'likedList']);
    Route::get('like-dislike-users/{type}', [UserController::class, 'likeDislikeList']);
});