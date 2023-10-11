<?php

namespace App\Providers;

use App\Http\Controllers\Trait\Category;
use App\Models\Shops;
use App\Models\SiteSettings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use Category;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //        URL::forceScheme('https');

        Blade::if('isRole', function ($role, $secrole = 'empty', $throle = 'empty', $forthrole = 'empty') {
            return Auth::guard('shop_owners_and_staffs')->check()
                && (Auth::guard('shop_owners_and_staffs')->user()->role->name === $role
                || Auth::guard('shop_owners_and_staffs')->user()->role->name === $secrole
                || Auth::guard('shop_owners_and_staffs')->user()->role->name === $throle
                || Auth::guard('shop_owners_and_staffs')->user()->role->name === $forthrole)

            ;
        });

        $all_shop_id = Shops::where('id', '!=', 1)->orderBy('shop_name', 'asc')->get();
        View::share('shop_ids', $all_shop_id);
        //for chat
        $check_chat = SiteSettings::where('name', 'ownchat')->first();
        View::share('is_chat_on', $check_chat->action);

        $check_fb = SiteSettings::where('name', 'facebook')->first();
        View::share('is_fb_on', $check_fb->action);

        $foryouon = SiteSettings::where('name', 'foryou')->first();
        View::share('is_foryou_on', $foryouon->action);

        $isscrollon = SiteSettings::where('name', 'infinitescroll')->first();
        View::share('is_scroll_on', $isscrollon->action);

        $all_shop_id_bylatest = Shops::where('id', '!=', 1)->orderBy('id', 'desc')->limit(4)->get();
        View::share('latest_shops', $all_shop_id_bylatest);

        $catlist = $this->getallcatlistbycount();
        View::share('cat_list', $catlist);

        date_default_timezone_set('Asia/Yangon');

        Paginator::useBootstrap();
    }
}
