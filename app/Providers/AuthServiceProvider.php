<?php

namespace App\Providers;

use App\Featuresforshops;
use App\Http\Controllers\Trait\UserRole;
use App\Policies\ItemYkPolicy;

use App\Models\Item;
use App\Models\Role;
use App\sitesettings;
use App\Models\User;
use App\Models\Manager;
use App\Models\Shopowner;
use App\ShweNews\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use UserRole;
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        // Item::class => ItemPolicy::class,
        // Shopowner::class => ShopownerPolicy::class,
        // 'App\Manager' => 'App\Policies\ManagerPolicy'

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('can_use_pos', function () {
            $checkpos = Featuresforshops::where([['shop_id', '=', $this->getshopid()], ['feature', '=', 'pos']])->first();
            $sitesetting = sitesettings::where('name', 'pos')->first();
            if ($sitesetting->action == 'on' && !empty($checkpos)) {
                return true;
            } else {
                return false;
            }
        });
        // Gate::define('role-users', function ($user,$manager) {
        //     return $user->id === $manager->shop_id;
        // });

        // Gate::define('users', function (Manager $user) {
        //     return $user->role_id === 2;
        // });

        Gate::define('access-shop-owner-premium', function ($user) {
            return $user->premium === 'yes';
        });

        Gate::define('access-shop-role-premium', function ($user) {
            $shopRole = Shopowner::where('id', $user->shop_id)->first();

            if ($shopRole && $shopRole->premium === 'yes') {
                return true;
            }

            return false;
        });
    }
}
