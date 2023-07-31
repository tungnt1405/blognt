<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SideBarController;
use App\Utils\TestUtil;
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
Route::get('/test-redis', function () {
    try {
        $redis = \Illuminate\Support\Facades\Redis::connect(env('REDIS_HOST'), env('REDIS_PORT'));
        return response('redis working');
    } catch (\Exception $e) {
        return response($e->getMessage());
    }
});
Route::get('/test-redis-utils', function () {
    // if (empty(RedisUtil::getKey('test'))) {
    //     RedisUtil::setKey('test', 'datatest', 60);
    // }
    // RedisUtil::deleteKey('test');
    $data = TestUtil::test3(function () {
        return 1;
    });
    return response()->json([
        // 'data' => RedisUtil::getKey('test')
        // 'data' => json_decode(RedisUtil::getKey('posts'))
        'data' => $data,
        'hm' => 1
    ]);
});
Route::middleware(['setDefaultLocale', 'setlocale'])
    ->group(function () {
        // locale default setting in env
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

        // set language for api: where(['locale' => '[a-zA-Z]{2}'])
    });
