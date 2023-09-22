<?php

namespace App\Providers;

use App\Http\Controllers\Trait\UserRole;
use App\Models\FeaturesForShops;
use App\Models\ShopOwnersAndStaffs;
use App\Models\Shops;
use App\Models\SiteSettings;
use App\Policies\ShopOwnersAndStaffsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    use UserRole;
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        ShopOwnersAndStaffs::class => ShopOwnersAndStaffsPolicy::class,
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
            Auth::guard('shop_owners_and_staffs')->user()->role_id == 2 ||
            Auth::guard('shop_owners_and_staffs')->user()->role_id == 4;
        });

        Gate::define('can_use_pos', function () {
            $checkpos = FeaturesForShops::where([['shop_id', '=', $this->get_shopid()], ['feature', '=', 'pos']])->first();
            $sitesetting = SiteSettings::where('name', 'pos')->first();
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

        Gate::define('to_create_user', [ShopOwnersAndStaffsPolicy::class, 'create']);

        Gate::define('access-shop-owner-premium', function ($user) {
            return $user->premium === 'yes';
        });

        Gate::define('access-shop-role-premium', function ($user) {
            $premiumShop = Shops::where('id', $user->shop_id)->first();

            if ($premiumShop && $premiumShop->premium === 'yes') {
                return true;
            }

            return false;
        });
    }
}
