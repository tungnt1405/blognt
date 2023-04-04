<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SideBarController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', fn () => response()->json(['message' => 'tested ok!']));
Route::apiResource('/owner', SideBarController::class)
    ->only(['index'])
    ->except(['create', 'edit']);
Route::apiResource('/posts', PostController::class)
    ->only(['index'])
    ->except(['create', 'edit']);
