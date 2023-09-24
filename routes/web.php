<?php

use App\Http\Controllers\SystemController;
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

Route::get('/', function () {
    abort(404);
});
// Route::get('/{any}', function () {
//     // return redirect(app()->getLocale());
//     // abort(404);
//     return view('guest.app');
// })->where(['any' => '^(?!api|admin_blog|maintain|images).*']);

Route::get("/maintain", [SystemController::class, 'maintain']);
