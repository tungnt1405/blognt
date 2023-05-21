<?php

use App\Http\Controllers\Api\CategoriesController;
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
// Route::prefix("{locale}")
//     ->where(['locale' => '[a-zA-Z]{2}'])
//     ->middleware('setlocale')
//     ->group(function () {

//     });
Route::apiResource('/owner', SideBarController::class)
    ->only(['index'])
    ->except(['create', 'edit']);
Route::apiResource('/posts', PostController::class)
    ->only(['index', 'show'])
    ->except(['create', 'edit']);
Route::get('more-posts', [PostController::class, 'morePosts']);
Route::get('{id}/post-id', [PostController::class, 'show'])->where('id', '[0-9]+');
Route::get('post/{slug}', [PostController::class, 'findSlug']);
Route::get('post-search', [PostController::class, 'postSearch']);
Route::get('about-me', [SideBarController::class, 'about']);
Route::get('categories', [CategoriesController::class, 'index']);
Route::post('/suggest/posts', [PostController::class, 'suggest']);
