<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/{any}', function () {
//     return view('welcome');
// })->where(['any' => '.*']);


Route::get('/{any?}', function () {
    return view('welcome');
})->where(['any' => '^(?!admin).*']);

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return "test";
    });
});
