<?php
namespace App\Http\Controllers\Trait;

use App\Models\Ads;
<<<<<<< HEAD
use App\Models\Item;
use App\Models\Event;
use App\Models\Manager;
use App\Models\Discount;
use App\Models\Collection;
use App\Models\Promotions;
use App\Models\FacebookTable;
use App\Models\BuyNowClickLog;
use App\Models\ItemLogActivity;
use App\Models\Percent_template;
use App\Models\AddToCartClickLog;
use App\Models\BackRoleLogActivity;
=======
use App\Models\BackroleLogActivity;
use App\Models\Collection;
>>>>>>> 3f9a9a3d8cef9b7a5371a5700376357bba0f709c
use App\Models\CountSetting;
use App\Models\discount;
use App\Models\Event;
use App\Models\FacebookTable;
use App\Models\Item;
use App\Models\ItemLogActivity;
use App\Models\Manager;
use App\Models\MultipleDamageLogs;
use App\Models\MultipleDiscountLogs;
use App\Models\MultiplePriceLogs;
use App\Models\PercentTemplate;
<<<<<<< HEAD
=======
use App\Models\Promotions;
>>>>>>> 3f9a9a3d8cef9b7a5371a5700376357bba0f709c
use App\Models\ShopLogActivity;
use App\Models\ShopOwnerLogActivity;

trait ShopDelete
{
    /** Shop Relevant Destroy */
    private function shop_relevant_destroy($id)
    {
        $this->model_accept_delete(new Ads(), $id);
        $this->model_accept_delete(new Event, $id);
        $this->model_accept_delete(new Promotions(), $id);
        //items
<<<<<<< HEAD
        $this->model_accept_delete(new Item(),$id);
        $this->model_accept_delete(new Collection(),$id);
        $this->model_accept_delete(new Discount(),$id);
        $this->model_accept_delete(new PercentTemplate(),$id);
        $this->model_accept_delete(new ItemLogActivity(), $id); //recheck
        $this->model_accept_delete(new FacebookTable(),$id);
        //log activities
        // $this->model_accept_delete(new AddToCartClickLog(),$id);
        $this->model_accept_delete(new BackRoleLogActivity(),$id);
        // $this->model_accept_delete(new BuyNowClickLog(),$id);
        $this->model_accept_delete(new ShopOwnerLogActivity(),$id);
        $this->model_accept_delete2(new ShopLogActivity(),$id);
        $this->model_accept_delete(new MultipleDamageLogs(),$id);
        $this->model_accept_delete(new MultipleDiscountLogs(),$id);
        $this->model_accept_delete(new MultiplePriceLogs(),$id);
=======
        $this->model_accept_delete(new Item(), $id);
        $this->model_accept_delete(new Collection(), $id);
        $this->model_accept_delete(new discount(), $id);
        $this->model_accept_delete(new PercentTemplate(), $id);
        $this->model_accept_delete(new ItemLogActivity(), $id); //recheck
        $this->model_accept_delete(new FacebookTable(), $id);
        //log activities
        // $this->model_accept_delete(new AddToCartClickLog(),$id);
        $this->model_accept_delete(new BackRoleLogActivity(), $id);
        // $this->model_accept_delete(new BuyNowClickLog(),$id);
        $this->model_accept_delete(new ShopOwnerLogActivity(), $id);
        $this->model_accept_delete2(new ShopLogActivity(), $id);
        $this->model_accept_delete(new MultipleDamageLogs(), $id);
        $this->model_accept_delete(new MultipleDiscountLogs(), $id);
        $this->model_accept_delete(new MultiplePriceLogs(), $id);
>>>>>>> 3f9a9a3d8cef9b7a5371a5700376357bba0f709c
        //users role
        $this->model_accept_delete(new Manager(), $id);

        $this->model_accept_delete(new CountSetting(), $id);

    }
    private function model_accept_delete($model, $id)
    {
        $get_id = $model::where('shop_id', $id)->pluck('id');
        $model::destroy($get_id);
    }
    private function model_accept_delete2($model, $id)
    {
        $get_id = $model::where('shop', $id)->pluck('id');
        return $model::destroy($get_id);
    }

    /** Shop Relevant Restore */
    private function shop_relevant_restore($id)
    {
        $this->model_accept_restore(new Ads(), $id);
        $this->model_accept_restore(new Event(), $id);
        $this->model_accept_restore(new Promotions(), $id);
        $this->model_accept_restore(new Item(), $id);
        // $this->model_accept_restore(new Collection(),$id);
        $this->model_accept_restore(new discount(), $id);
        $this->model_accept_restore(new PercentTemplate(), $id);
        $this->model_accept_restore(new ItemLogActivity(), $id);
        $this->model_accept_restore(new FacebookTable(), $id);
        // $this->model_accept_restore(new AddToCartClickLog(),$id);
        $this->model_accept_restore(new BackRoleLogActivity(), $id);
        // $this->model_accept_restore(new BuyNowClickLog(),$id);
        $this->model_accept_restore(new ShopOwnerLogActivity(), $id);
        $this->model_accept_restore(new Manager(), $id);
        $this->model_accept_restore2(new ShopLogActivity(), $id);
        $this->model_accept_restore(new MultipleDamageLogs(), $id);
        $this->model_accept_restore(new MultipleDiscountLogs(), $id);
        $this->model_accept_restore(new MultiplePriceLogs(), $id);
        $this->model_accept_restore(new CountSetting(), $id);
    }
    private function model_accept_restore($model, $id)
    {
        $model::onlyTrashed()->where('shop_id', $id)->restore();
    }
    private function model_accept_restore2($model, $id)
    {
        $model::onlyTrashed()->where('shop', $id)->restore();
    }

    /** Shop Relevant ForceDelete */
    private function shop_relevant_force_delete($id)
    {
        $this->model_accept_force_delete(new Ads(), $id);
        $this->model_accept_force_delete(new Event, $id);
        $this->model_accept_force_delete(new Promotions(), $id);
        //items
        $this->model_accept_force_delete(new Item(), $id);
        // $this->model_accept_force_delete(new Collection(),$id);
        $this->model_accept_force_delete(new discount(), $id);
        $this->model_accept_force_delete(new PercentTemplate(), $id);
        $this->model_accept_force_delete(new ItemLogActivity(), $id); //recheck
        $this->model_accept_force_delete(new FacebookTable(), $id);
        //log activities
        // $this->model_accept_force_delete(new AddToCartClickLog(),$id);
        $this->model_accept_force_delete(new BackRoleLogActivity(), $id);
        // $this->model_accept_force_delete(new BuyNowClickLog(),$id);
        $this->model_accept_force_delete(new ShopOwnerLogActivity(), $id);
        $this->model_accept_force_delete2(new ShopLogActivity(), $id);
        $this->model_accept_force_delete(new MultipleDamageLogs(), $id);
        $this->model_accept_force_delete(new MultipleDiscountLogs(), $id);
        $this->model_accept_force_delete(new MultiplePriceLogs(), $id);
        //users role
        $this->model_accept_force_delete(new Manager(), $id);
        $this->model_accept_force_delete(new CountSetting(), $id);
    }

    private function model_accept_force_delete($model, $id)
    {
        $get_id = $model::where('shop_id', $id)->onlyTrashed()->pluck('id');
        foreach ($get_id as $i) {
            $model::onlyTrashed()->findOrFail($i)->forceDelete();
        }
    }
    private function model_accept_force_delete2($model, $id)
    {
        $get_id = $model::where('shop', $id)->onlyTrashed()->pluck('id');
        foreach ($get_id as $i) {
            $model::onlyTrashed()->findOrFail($i)->forceDelete();
        }
    }
}
