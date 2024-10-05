<?php

namespace App\Providers;

use App\Models\City;
use App\Models\Neighbourhood;
use App\Models\PaymentMethod;
use App\Models\SettingsText;
use App\Policies\LocationPolicy;
use App\Policies\PaymentMethodPolicy;
use App\Policies\RolePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\SettingTextPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading();
//        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(City::class, LocationPolicy::class);
        Gate::policy(Neighbourhood::class, LocationPolicy::class);
        Gate::policy(SettingsText::class, SettingTextPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(PaymentMethod::class, PaymentMethodPolicy::class);

    }
}
