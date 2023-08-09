<?php

namespace App\Providers;

use App\Models\Featuresforshops;
use App\Http\Controllers\Trait\UserRole;
use App\Policies\ItemYkPolicy;

use App\Models\Item;
use App\Models\Role;
use App\Models\sitesettings;
use App\Models\User;
use App\Models\Manager;
use App\Models\Shops;
use App\Models\ShweNews\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;


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
        // Shops::class => ShopownerPolicy::class,
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
        Gate::define('can_show_dashboard', function () {
            return 
            Auth::guard('shop_owners_and_staffs')->user()->role_id == 1 ||
            Auth::guard('shop_owners_and_staffs')->user()->role_id == 2  ||
            Auth::guard('shop_owners_and_staffs')->user()->role_id == 4;
        });
      
        Gate::define('can_use_pos', function () {
            $checkpos = Featuresforshops::where([['shop_id', '=', $this->get_shopid()], ['feature', '=', 'pos']])->first();
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
            $shopRole = Shops::where('id', $user->shop_id)->first();

            if ($shopRole && $shopRole->premium === 'yes') {
                return true;
            }

            return false;
        });
    }
}
