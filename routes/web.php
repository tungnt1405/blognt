<?php

use App\Http\Controllers\Admin\SideBarController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrentTeamController;
use App\Http\Controllers\Livewire\ApiTokenController;
use App\Http\Controllers\Livewire\PrivacyPolicyController;
use App\Http\Controllers\Livewire\TeamController;
use App\Http\Controllers\Livewire\TermsOfServiceController;
use App\Http\Controllers\Livewire\UserProfileController;
use App\Http\Controllers\TeamInvitationController;
use Laravel\Jetstream\Jetstream;

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
    return view('guest.app');
})->where(['any' => '^(?!admin).*']);

Route::prefix('admin')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    })->name('admin.home');
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/side-bar', [SideBarController::class, 'index'])->name('admin.side-bar');
    Route::post("/side-bar/new", [SideBarController::class, 'store'])->name('admin.side-bar.new');

    Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
        if (Jetstream::hasTermsAndPrivacyPolicyFeature()) {
            Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])->name('terms.show');
            Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');
        }

        $authMiddleware = config('jetstream.guard')
            ? 'auth:' . config('jetstream.guard')
            : 'auth';

        $authSessionMiddleware = config('jetstream.auth_session', false)
            ? config('jetstream.auth_session')
            : null;

        Route::group(['middleware' => array_values(array_filter([$authMiddleware, $authSessionMiddleware]))], function () {
            // User & Profile...
            Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');

            Route::group(['middleware' => 'verified'], function () {
                // API...
                if (Jetstream::hasApiFeatures()) {
                    Route::get('/user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
                }

                // Teams...
                if (Jetstream::hasTeamFeatures()) {
                    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
                    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
                    Route::put('/current-team', [CurrentTeamController::class, 'update'])->name('current-team.update');

                    Route::get('/team-invitations/{invitation}', [TeamInvitationController::class, 'accept'])
                        ->middleware(['signed'])
                        ->name('team-invitations.accept');
                }
            });
        });
    });
});
