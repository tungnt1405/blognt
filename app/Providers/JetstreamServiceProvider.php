<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Http\Livewire\Admin\SideBar\MoreInfo as SideBarMoreInfo;
use App\Http\Livewire\Admin\SideBar\Show;
use App\Http\Livewire\Jetstream\ApiTokenManager;
use App\Http\Livewire\Jetstream\ChangeLanguageForm;
use App\Http\Livewire\Jetstream\CreateTeamForm;
use App\Http\Livewire\Jetstream\DeleteTeamForm;
use App\Http\Livewire\Jetstream\DeleteUserForm;
use App\Http\Livewire\Jetstream\LogoutOtherBrowserSessionsForm;
use Illuminate\Support\ServiceProvider;
use App\Http\Livewire\Jetstream\NavigationMenu;
use App\Http\Livewire\Jetstream\TeamMemberManager;
use App\Http\Livewire\Jetstream\TwoFactorAuthenticationForm;
use App\Http\Livewire\Jetstream\UpdatePasswordForm;
use App\Http\Livewire\Jetstream\UpdateProfileInformationForm;
use App\Http\Livewire\Jetstream\UpdateTeamNameForm;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Jetstream;
use Livewire\Livewire;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Livewire::component('admin.navigation-menu', NavigationMenu::class);
        Livewire::component('admin.profile.update-profile-information-form', UpdateProfileInformationForm::class);
        Livewire::component('admin.profile.update-password-form', UpdatePasswordForm::class);
        Livewire::component('admin.profile.two-factor-authentication-form', TwoFactorAuthenticationForm::class);
        Livewire::component('admin.profile.logout-other-browser-sessions-form', LogoutOtherBrowserSessionsForm::class);
        Livewire::component('admin.profile.delete-user-form', DeleteUserForm::class);
        Livewire::component('admin.profile.change-language-form', ChangeLanguageForm::class);

        if (Features::hasApiFeatures()) {
            Livewire::component('api.api-token-manager', ApiTokenManager::class);
        }

        if (Features::hasTeamFeatures()) {
            Livewire::component('admin.teams.create-team-form', CreateTeamForm::class);
            Livewire::component('admin.teams.update-team-name-form', UpdateTeamNameForm::class);
            Livewire::component('admin.teams.team-member-manager', TeamMemberManager::class);
            Livewire::component('admin.teams.delete-team-form', DeleteTeamForm::class);
        }

        Livewire::component('admin.side-bar', Show::class);
        Livewire::component('admin.side-bar.more-info', SideBarMoreInfo::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
