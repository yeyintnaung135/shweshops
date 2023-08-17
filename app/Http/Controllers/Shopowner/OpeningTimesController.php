<?php

namespace App\Http\Controllers\Shopowner;

use File;
use App\Models\OpeningTimes;
use App\Models\Shops;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OpeningTimesController extends Controller
{
    public function opening_times(): View
    {
        $current_shop = $this->get_current_shop_id();

        $openingTime = OpeningTimes::where('shop_id', $current_shop->id)->first();
        return view('backend.Shops.opening_times.opening_times', ["shop_id" => $current_shop->id, "opening_time" => $openingTime]);
    }

    public function opening_times_upload(Request $request): RedirectResponse
    {
        $current_shop = $this->get_current_shop_id();

        $this->validate($request, [
            'opening_time' => 'required|string|max:200',
        ]);

        $checkExist = OpeningTimes::where('shop_id', $current_shop->id)->first();
        //dd($checkExist);
        if ($checkExist) {
            OpeningTimes::where('shop_id', $current_shop->id)->delete();
        }

        OpeningTimes::create([
            'opening_time' => $request->opening_time,
            'shop_id' => $request->shopId,
        ]);

        return back()->with('success', 'Opening time updated!');
    }

    public function opening_times_delete(): RedirectResponse
    {
        $current_shop = $this->get_current_shop_id();
        OpeningTimes::where('shop_id', $current_shop->id)->delete();
        return back()->with('success', 'Deleted successfully!');
    }

    private function get_current_shop_id(): Shops
    {

        return $this->current_shop_data();
    }
}
