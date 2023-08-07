<?php

use App\Models\Sign;
use App\Models\User;
use App\Models\Manager;
use App\Models\Shopowner;
use Carbon\Carbon;
use function Safe\strtotime;
use Illuminate\Http\Request;
use App\View\Components\alert;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\traid\ykimage;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\FrontForDiscountController;
use App\Http\Controllers\SupportFrontController;
use App\Http\Controllers\FrontShopController;

use App\Http\Controllers\Shwe_News;

use App\Http\Controllers\FrontForCatController;


use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;




//URL::forceScheme('https');  //at the top of the file
Route::get('/getprice', [Shopowner\DiscountController::class,'price_update']);


Route::group(
    ['middleware' => ['web', 'foratc']],
    function () {
        // for frontend user
        Route::get('/adsclick/{name}/{id}', [LogController::class,'storeadsclicklog']);
        Route::get('/support', [SupportFrontController::class,'support']);
        Route::post('/get_support_by_cat', [SupportFrontController::class,'get_support_by_cat']);
        Route::post('/get_support', [SupportFrontController::class,'get_support']);
        Route::get('/initial_pop_items', [FrontController::class,'initial_pop_items']);
        Route::post('/addtohome/update', [FrontController::class,'addtohomeupdate']);
        Route::post('/fb_message_log/add', [forfacebook\FacebookController::class,'addlog']);

        //for chat

        Route::get('getuserchatlistsfromserver', [message\UserMessageController::class,'getuserchatlistsfromserver']);
        Route::get('gettotalchatcountforuser', [message\UserMessageController::class,'gettotalchatcountforuser']);
        Route::get('getspecificchatcountforuser/{shop_id}', [message\UserMessageController::class,'getspecificchatcountforuser']);
        Route::post('/getcurrentchatshops', [message\UserMessageController::class,'getcurrentchatshops']);
        Route::post('/setreadbyuser', [message\UserMessageController::class,'setreadbyuser']);
        Route::post('/sendwhatuserisactive', [message\UserMessageController::class,'sendwhatuserisactive']);
        Route::post('/sendwhatuserisoffline', [message\UserMessageController::class,'sendwhatuserisoffline']);
        Route::get('/getpostbyproductid/{item_id}', [message\UserMessageController::class,'getpostbyproductid']);
        Route::post('/getitemdata', [message\UserMessageController::class,'getitemdata']);

        Route::get('/directory/all', [FrontController::class,'directory']);
        Route::get('/directory/detail/{shop_name}', [FrontController::class,'directdetail']);
        Route::post('/get_shop_directory', [FrontController::class,'get_shop_directory']);
        Route::get('/get_township_bystate/{id}', [FrontController::class,'getTownshipbyState']);
        Route::get('/getstates', [FrontController::class,'getstates']);
        Route::get('/getshopbystate/{id}', [FrontController::class,'getshopbystate']);

        //forchat

        //all routes for authenciation defined here
        Auth::routes();
        //for super admin

        require "superadminroutes.php";

        // //for super admin
        
        // //for pos super admin
        // require "possuperadminroutes.php";
        // //for pos super admin

        // //for webservice

        require "shopownerroutes.php";
        // //for webservice


        // //for user
        require "userroutes.php";
        // require "payment.php";

        //for frontend
        Route::post('checkvalidate', [Auth\RegisterController::class,'checkvalidate']);
        Route::post('checkvalidateregister', [Auth\RegisterController::class,'check_validate_register']);
        Route::post('checkcodereg', [Auth\RegisterController::class,'checkcodereg']);
        Route::post('updatename', [Auth\RegisterController::class,'update_name']);
        Route::get('/', [FrontController::class,'index'])->name('front');
        Route::get('/gold_calculator', [FrontController::class,'gold_calculator']);
        // zh
        Route::get('/{shop_name}/product_detail/{product_id}', [FrontController::class,'product_detail'])->name('front_productdetail');
        Route::get('/buynow', [FrontController::class,'buynow'])->name('buynow');
        Route::get('/addtocartclick', [FrontController::class,'addtocartclick'])->name('addtocartclick');
        Route::post('/whislistclick', [FrontController::class,'whislistclick'])->name('whislistclick');

        Route::post('/get_newitems_ajax', [FrontController::class,'get_newitems_ajax']);
        Route::get('/get_popitems_forshop_ajax/{latest}/{shop_id}', [FrontShopController::class,'get_popitems_forshop_ajax']);
        Route::get('/get_newitems_forshop_ajax/{limit}/{shop_id}', [FrontShopController::class,'get_newitems_forshop_ajax']);
        Route::get('/get_popitems_ajax/{latest}/{limit}', [FrontController::class,'get_popitems_ajax']);
        Route::get('/get_discount_ajax/{limit}/{shop_id?}', [FrontForDiscountController::class,'get_discount_ajax']);
        Route::get('/get_discount_forshop_ajax/{limit}/{shop_id?}', [FrontForDiscountController::class,'get_discount_forshop_ajax']);
        Route::get('/get_shop_ajax/{limit}', [FrontShopController::class,'view_more_ajax']);
        Route::get('/see_all_discount/{shop_id}', [FrontForDiscountController::class,'see_all']);
        Route::get('/see_all_discount_for_shop/{shop_id}', [FrontForDiscountController::class,'see_all']);

        Route::post('/search_by_type', [FrontController::class,'search_by_type']);
        Route::get('/ajax_search_result/{searchtext?}', [FrontController::class,'ajax_search_result']);


        Route::get('/shop_detail/{id}/{cat}', [FrontController::class,'getitem_fromshop_bycat']);
        Route::get('/see_all_new', [FrontController::class,'see_all_new']);
        Route::get('/see_all_for_shop/{neworpop}/{shop_id}', [FrontController::class,'see_all_for_shop']);
        Route::get('/get_newitems_forshop_ajax/{shop_id}', [FrontController::class,'get_newitems_forshop_ajax']);
        Route::get('/see_all_pop', [FrontController::class,'see_all_pop']);
        Route::get('/see_by_categories/{id}', [FrontForCatController::class,'see_all']);
        //for search page
        Route::get('/see_by_categories', [FrontForCatController::class,'search_items']);
        //for search page
        //all 404 error page is not show by this link (need to repair later)
        Route::get('/{shop_name}/{cat_name}/{shop_id}', [FrontShopController::class,'see_all']);
        //all 404 error page is not show by this link (need to repair later)

        Route::post('/get_items_cat_ajax/{id}', [FrontForCatController::class,'get_items_cat_ajax']);
        Route::post('/catfilter', [FrontForCatController::class,'catfilter']);

        Route::get('/seeallforyou', [FrontForCatController::class,'seeall_foryou']);

        Route::get('/tags/{name}', [TagsController::class,'index']);
        Route::post('/tags_items', [TagsController::class,'get_tags_items']);
        Route::get('/allcollections', [FrontcollectionController::class,'see_all']);
        //for similar
        Route::get('/{shop_name}/similar_items/{cat}/{item_id}/{shop_id}', [FrontSimilarOrotherController::class,'similar_by_cat']);

        //forgot password user

        Route::get('forgot_password', [Auth\YkforgotpasswordController::class,'showLinkRequestForm']);
        Route::post('forgot_password', [Auth\YkforgotpasswordController::class,'send_reset_code_form']);

        Route::post('check_code', [Auth\YkforgotpasswordController::class,'codeCheck']);
        Route::post('add_new_password', [Auth\YkforgotpasswordController::class,'add_new_password']);


        Route::get('/temp/see_all_cato', [TempController::class,'see_all_cato'])->name('temp');

        Route::get('/addtocart', function () {

            // for account
            if (isset(Auth::guard('shop_owner')->user()->id)) {
                $shopowner_acc = Shopowner::where('id', Auth::guard('shop_owner')->user()->id)->orderBy('created_at', 'desc')->get();
            } else if (isset(Auth::guard('shop_role')->user()->id)) {
                $manager = Manager::where('id', Auth::guard('shop_role')->user()->id)->pluck('shop_id');
                $shopowner_acc = Shopowner::where('id', $manager)->orderBy('created_at', 'desc')->get();
            }

            if (isset(Auth::guard('shop_owner')->user()->id)) {
                return view('front.temp.addtocart', ['shopowner_acc' => $shopowner_acc]);
            } elseif (isset(Auth::guard('shop_role')->user()->id)) {
                return view('front.temp.addtocart', ['shopowner_acc' => $shopowner_acc]);
            } else {
                return view('front.temp.addtocart');
            }
        });
        Route::get('/myfav', function () {
            // for account
            if (isset(Auth::guard('shop_owner')->user()->id)) {
                $shopowner_acc = Shopowner::where('id', Auth::guard('shop_owner')->user()->id)->orderBy('created_at', 'desc')->get();
            } else if (isset(Auth::guard('shop_role')->user()->id)) {
                $manager = Manager::where('id', Auth::guard('shop_role')->user()->id)->pluck('shop_id');
                $shopowner_acc = Shopowner::where('id', $manager)->orderBy('created_at', 'desc')->get();
            }

            if (isset(Auth::guard('shop_owner')->user()->id)) {
                return view('front.temp.fav', ['shopowner_acc' => $shopowner_acc]);
            } elseif (isset(Auth::guard('shop_role')->user()->id)) {
                return view('front.temp.fav', ['shopowner_acc' => $shopowner_acc]);
            } else {
                return view('front.temp.fav');
            }
        });

        Route::put('/addtocart', [FrontController::class,'addtocart_search']);
        Route::put('/myfav', [FrontController::class,'fav_search']);

        Route::get('/addtocart/update', function () {

            // for account
            if (isset(Auth::guard('shop_owner')->user()->id)) {
                $shopowner_acc = Shopowner::where('id', Auth::guard('shop_owner')->user()->id)->orderBy('created_at', 'desc')->get();
            } else if (isset(Auth::guard('shop_role')->user()->id)) {
                $manager = Manager::where('id', Auth::guard('shop_role')->user()->id)->pluck('shop_id');
                $shopowner_acc = Shopowner::where('id', $manager)->orderBy('created_at', 'desc')->get();
            }

            if (isset(Auth::guard('shop_owner')->user()->id)) {
                return view('front.temp.addtocart', ['shopowner_acc' => $shopowner_acc]);
            } elseif (isset(Auth::guard('shop_role')->user()->id)) {
                return view('front.temp.addtocart', ['shopowner_acc' => $shopowner_acc]);
            } else {
                return view('front.temp.addtocart');
            }
        });
        Route::get('/myfav/update', function () {
            // for account
            if (isset(Auth::guard('shop_owner')->user()->id)) {
                $shopowner_acc = Shopowner::where('id', Auth::guard('shop_owner')->user()->id)->orderBy('created_at', 'desc')->get();
            } else if (isset(Auth::guard('shop_role')->user()->id)) {
                $manager = Manager::where('id', Auth::guard('shop_role')->user()->id)->pluck('shop_id');
                $shopowner_acc = Shopowner::where('id', $manager)->orderBy('created_at', 'desc')->get();
            }

            if (isset(Auth::guard('shop_owner')->user()->id)) {
                return view('front.temp.fav', ['shopowner_acc' => $shopowner_acc]);
            } elseif (isset(Auth::guard('shop_role')->user()->id)) {
                return view('front.temp.fav', ['shopowner_acc' => $shopowner_acc]);
            } else {
                return view('front.temp.fav');
            }
        });

        Route::get('baydin_detail/{id}', function (Request $request, $id) {
            $baydin = Sign::findOrFail($id);
            $sign = $baydin->name;
            $baydins = Sign::where('id', '!=', $id)->where('name', $sign)->get();
            // return dd($baydins);
            if (isset(Auth::guard('web')->user()->id)) {
                return view('front.baydins.baydin_detail', compact('baydin', 'baydins'));
            } else {
                return redirect()->back();
            }
        })->name('baydin_detail');

        Route::post('/addtocart/update', [FrontController::class,'addtocart_update']);
        Route::post('/myfav/update', [FrontController::class,'fav_update']);
        Route::get('/contact-us', [FrontController::class,'contact_us']);


// News and Events
Route::get('news&events', [Shwe_News\NewsFrontController::class,'index']);
Route::get('news_and_events/{id}', [Shwe_News\NewsFrontController::class,'show']);
Route::get('news', [Shwe_News\NewsFrontController::class,'allNews']);
Route::get('promotions', [Shwe_News\NewsFrontController::class,'allPromotions']);
Route::get('events', [Shwe_News\NewsFrontController::class,'allEvents']);
Route::get('news/{id}', [Shwe_News\NewsFrontController::class,'NewsDetail'])->name('news.detail');
Route::get('promotions/{id}', [Shwe_News\NewsFrontController::class,'PromotionDetail'])->name('promotions.detail');
Route::get('event/{id}', [Shwe_News\NewsFrontController::class,'EventDetail'])->name('events.detail');

Route::get('all_news/{id}', [Shwe_News\NewsFrontController::class,'pAllNews']); //allNews for premium shops
Route::get('all_events/{id}', [Shwe_News\NewsFrontController::class,'pAllEvents']); //allEvents for premium shops
Route::get('news/p/{id}/{shopid}', [Shwe_News\NewsFrontController::class,'pNewsDetail'])->name('pNews.detail'); //newsDetail for premium shops
Route::get('events/p/{id}/{shopid}', [Shwe_News\NewsFrontController::class,'pEventDetail'])->name('pEvents.detail'); //eventDetail for premium shops


        //-------------------------------------------------------------------------
        //for webservice

        // require "webserviceroutes.php";
        //for webservice

        //For unit testing
        // require "unittest.php";
    }
);


Route::get('webhook', [FacebookWebhookController::class,'webhook']);
Route::get('checkwehavetoken', [forfacebook\FacebookController::class,'checkwehavetoken']);
Route::post('storetoken', [forfacebook\FacebookController::class,'storetoken']);
Route::post('webhook', [FacebookWebhookController::class,'webhook_post']);
Route::get('forgetstart/{id}', [FacebookWebhookController::class,'forgetstart']);

Route::get('testfbpost', function () {
    $response = Http::withHeaders([
        'Content-Type' => "application/json"
    ])->post(
        'https://graph.facebook.com/107646812265437/feed',
        [
            'message' => 'test message',
            'link' => 'https://test.shweshops.com/MoeGaungGoldShop/product_detail/6888',
            'access_token' => 'EAAHrG0ta9TIBAFP46COMZCTcbTzo8WY2C8GFgBMpSegmbEBHtJjhqivfYNxXSVIS44fngAvc9EPV0Qd297DrjCtYjCiTZAmVnv2LWPOovmidJ0WpvmNaKo4k8oyzP6iTg9X76JimjqN9rKUWZAzsm55wLlzX32Lew4IQePu9bTxDqypFegHOgQDOm9zYydMOx6hIRyYrwZDZD'

        ]
    );
    return $response;
});

// zh log activity
Route::get('add-to-log', [LogController::class,'myTestAddToLog']);
Route::get('logActivity', [LogController::class,'logActivity']);

Route::get('notification', [FrontController::class,'getNoti']);
Route::post('notification', [FrontController::class,'readNoti']);

Route::get('shops', [FrontController::class,'getShops']);
Route::get('premium_shops', [FrontController::class,'getPremiumShops']);
Route::get('popular_shops', [FrontController::class,'getPopularShops']);
Route::post('/get_shops_byfilter', [FrontController::class,'get_shops_byfilter']);

//test
Route::get('backside/pos/index', [Shopowner\PosController::class,'index']);



Route::get('baydin', [Auth\RegisterController::class,'baydin']);



Route::get('terms', function () {
    return view('front.terms');
});

Route::get('/{shop_name}', [FrontController::class,'shop_detail']);
Route::get('/shop_collection/p/{shop_name}/{col_id}', [ShopCollectionController::class,'collection_for_shop'])->name('pCollections');


