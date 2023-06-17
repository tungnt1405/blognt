<?php

use App\Helpers\ToastrHelper;
use App\Http\Controllers\Admin\PostController;
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
use App\Http\Controllers\Admin\System\CategoryController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\TeamInvitationController;
use App\Utils\RedisUtil;
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
    Route::post('/owner/more-info/create', [SideBarController::class, 'postMoreInfo'])->name('admin.owner.more-info.create');
    Route::put('/owner/more-info/{id}/update', [SideBarController::class, 'putMoreInfo'])->name('admin.owner.more-info.update');

    // ================== Posts =============================
    Route::get('/posts', [PostController::class, 'index'])->name('admin.posts');
    Route::get('/posts/create', [PostController::class, 'create'])->name('admin.posts.create');
    Route::get('/posts/edit/{id}/post', [PostController::class, 'edit'])->name('admin.posts.edit')->whereNumber('id');
    Route::post('/posts/create', [PostController::class, 'store'])->name('admin.posts.store');
    Route::post('/posts/restore-posts', [PostController::class, 'restorePosts'])->name('admin.posts.restore');
    Route::put(
        '/posts/update/{id}/status',
        [PostController::class, 'updateStatus']
    )->name('admin.posts.update.status')->whereNumber('id');
    Route::put(
        '/posts/update/{id}/posts',
        [PostController::class, 'update']
    )->name('admin.posts.update')->whereNumber('id');
    Route::delete('/posts/destroy', [PostController::class, 'destroy'])->name('admin.posts.delete');
    Route::delete('/posts/soft-delete', [PostController::class, 'softDeletePosts'])->name('admin.posts.soft.delete');

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

    Route::post('/system/categories/create', [CategoryController::class, 'create'])->name('admin.setting.category.create');
    Route::put('/system/categories/{id}/update', [CategoryController::class, 'update'])->name('admin.setting.category.update');
    Route::delete('/system/categories/{id}/delete', [CategoryController::class, 'delete'])->name('admin.setting.category.delete');

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
            Route::get('/user/profile', [UserProfileController::class, 'show'])->name('admin.profile.show');

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
    Route::get('/clear-cache-posts', function () {
        if (RedisUtil::deleteKey('posts')) {
            ToastrHelper::toastrSuccess('Clear cache success!', 'Success');
        } else {
            ToastrHelper::toastrWarning('Not found cache posts.', 'Warning');
        }
        return redirect()->back();
    })->name('admin-clear-cache-posts');
});
