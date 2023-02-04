<?php

use App\Http\Controllers\Admin\SideBarController;
use App\Http\Controllers\Admin\System\CountryController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrentTeamController;
use App\Http\Controllers\Livewire\ApiTokenController;
use App\Http\Controllers\Livewire\PrivacyPolicyController;
use App\Http\Controllers\Livewire\TeamController;
use App\Http\Controllers\Livewire\TermsOfServiceController;
use App\Http\Controllers\Livewire\UserProfileController;
use App\Http\Controllers\Admin\System\SettingsController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\TeamInvitationController;
use Laravel\Jetstream\Jetstream;

Route::prefix('admin_blog')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'localization'
])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    })->name('admin.home');

    // ================== Dashboard =================
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // ================== Owner Information =================
    Route::resource('side-bar', SideBarController::class)->names([
        'index' => 'admin.side-bar',
        'store' => 'admin.side-bar.new',
        'update' => 'admin.side-bar.update',
    ]);
    Route::get('/owner/more-info', [SideBarController::class, 'getMoreInfo'])->name('admin.owner.more-info');

    // ================== Master Data ========================
    Route::controller(SettingsController::class)->group(function () {
        Route::get('/system', 'index')->name('admin.setting');
        Route::post('/system/redirect-to', 'redirectToSelected')->name('admin.setting.redirect');
        Route::get('/system/{view}', 'show')->name('admin.setting.show')
            ->where('view', '^([a-zA-Z]+)');
    });
    Route::post('/system/countries/create', [CountryController::class, 'create'])->name('admin.setting.countries.create');
    Route::put('/system/countries/{id}/update', [CountryController::class, 'update'])->name('admin.setting.countries.update');
    Route::delete('/system/countries/{id}/delete', [CountryController::class, 'delete'])->name('admin.setting.countries.delete');

    // ================== Jetstream ========================
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

    Route::get('/change-language/{language}', [SystemController::class, 'changeLanguage'])->name('admin-change-language');
});