<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SideBarController;
use App\Http\Controllers\Admin\System\CountryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrentTeamController;
use App\Http\Controllers\Livewire\ApiTokenController;
use App\Http\Controllers\Livewire\PrivacyPolicyController;
use App\Http\Controllers\Livewire\TeamController;
use App\Http\Controllers\Livewire\TermsOfServiceController;
use App\Http\Controllers\Livewire\UserProfileController;
use App\Http\Controllers\Admin\System\SettingsController;
use App\Http\Controllers\Admin\System\CategoryController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\TeamInvitationController;
use Laravel\Jetstream\Jetstream;

Route::prefix('admin_blog')
    ->name('admin.')
    ->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'localization'
    ])->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        })->name('home');

        // ================== Dashboard =================
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // ================== Owner Information =================
        Route::resource('side-bar', SideBarController::class)->names([
            'index' => 'side-bar',
            'store' => 'side-bar.new',
            'update' => 'side-bar.update',
        ]);

        Route::prefix('owner')->name('owner.')
            ->group(function () {
                Route::get('/more-info', [SideBarController::class, 'getMoreInfo'])->name('more-info');
                Route::post('/more-info/create', [SideBarController::class, 'postMoreInfo'])->name('more-info.create');
                Route::put('/more-info/{id}/update', [SideBarController::class, 'putMoreInfo'])->name('more-info.update');
            });

        // ================== Posts =============================
        Route::prefix('posts')->name('posts.')
            ->group(function () {
                Route::get('/', [PostController::class, 'index'])->name('index');
                Route::get('/create', [PostController::class, 'create'])->name('create');
                Route::get('/edit/{id}/post', [PostController::class, 'edit'])->name('edit')->whereNumber('id');
                Route::post('/create', [PostController::class, 'store'])->name('store');
                Route::post('/restore-posts', [PostController::class, 'restorePosts'])->name('restore');
                Route::put('/update/{id}/status', [PostController::class, 'updateStatus'])->name('update.status')->whereNumber('id');
                Route::put('/update/{id}/posts', [PostController::class, 'update'])->name('update')->whereNumber('id');
                Route::delete('/posts/destroy', [PostController::class, 'destroy'])->name('delete');
                Route::delete('/posts/soft-delete', [PostController::class, 'softDeletePosts'])->name('soft.delete');
            });

        // ================== Master Data ========================
        Route::prefix('system')->name("setting.")
            ->group(function () {
                Route::controller(SettingsController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('/redirect-to', 'redirectToSelected')->name('redirect');
                    Route::get('/{view}', 'show')->name('show')
                        ->where('view', '^([a-zA-Z]+)');
                });

                Route::prefix('countries')->name('countries.')->group(function () {
                    Route::post('/create', [CountryController::class, 'create'])->name('create');
                    Route::put('/{id}/update', [CountryController::class, 'update'])->name('update');
                    Route::delete('/{id}/delete', [CountryController::class, 'delete'])->name('delete');
                });

                Route::prefix('categories')->name('category.')
                    ->group(function () {
                        Route::post('/create', [CategoryController::class, 'create'])->name('create');
                        Route::put('/{id}/update', [CategoryController::class, 'update'])->name('update');
                        Route::delete('/{id}/delete', [CategoryController::class, 'delete'])->name('delete');
                    });
            });

        // ================== Setting systems ========================
        Route::prefix('settings')->group(function () {
            Route::controller(SettingsController::class)->group(function () {
                Route::get('/config-website', 'configWebsite')->name('system.config');
                Route::match(['post'], '/maintain', 'toggleMaintain')->name('toggle.maintain');
                Route::put('/config-website/update/{uuid?}', 'updateConfig')->name('config.update');
            });
        });

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

        // ================== Other ========================
        Route::get('/change-language/{language}', [SystemController::class, 'changeLanguage'])->name('change-language');
        Route::prefix('cache')->group(function () {
            Route::controller(App\Http\Controllers\Admin\AdminController::class)->group(function () {
                Route::get('/', 'cache')->name('cache.index');
                Route::prefix('optimize')->name('cache.optimize.')->group(function () {
                    Route::get('/', 'cacheOptimize')->name('index');
                    Route::get('/clear', 'cacheOptimizeClear')->name('clear');
                });
                Route::get('/clear-posts', 'clearCachePosts')->name('clear-cache-posts');
            });
        });

        Route::get('test-socket', fn () => view('admin.test-socket.test'));
    });
