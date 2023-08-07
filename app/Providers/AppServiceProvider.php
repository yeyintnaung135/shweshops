<?php

namespace App\Providers;

use App\Models\Event;
use App\Http\Controllers\traid\category;
use App\Models\News;
use App\Models\Promotions;
use App\Models\Shopowner;
use App\Models\sitesettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class   AppServiceProvider extends ServiceProvider
{
    use category;
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
        $all_shop_id = Shopowner::where('id', '!=', 1)->orderBy('shop_name', 'asc')->get();
        View::share('shop_ids', $all_shop_id);
        //for chat
        $check_chat = sitesettings::where('name', 'ownchat')->first();
        View::share('is_chat_on', $check_chat->action);

        $check_fb = sitesettings::where('name', 'facebook')->first();
        View::share('is_fb_on', $check_fb->action);

        $foryouon = sitesettings::where('name', 'foryou')->first();
        View::share('is_foryou_on', $foryouon->action);

        $isscrollon = sitesettings::where('name', 'infinitescroll')->first();
        View::share('is_scroll_on', $isscrollon->action);

        $all_shop_id_bylatest = Shopowner::where('id', '!=', 1)->orderBy('id', 'desc')->limit(4)->get();
        View::share('latest_shops', $all_shop_id_bylatest);

        $catlist = $this->getallcatlistbycount();
        View::share('cat_list', $catlist);

        date_default_timezone_set('Asia/Yangon');
    }
}
