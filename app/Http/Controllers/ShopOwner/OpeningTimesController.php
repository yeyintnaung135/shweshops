<?php

namespace App\Http\Controllers\Shopowner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\UserRole;
use App\Models\OpeningTimes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OpeningTimesController extends Controller
{
    use UserRole;

    public function opening_times(): View
    {
        $current_shop = $this->get_shopid();

        $openingTime = OpeningTimes::where('shop_id', $current_shop)->first();
        return view('backend.shopowner.opening_times.opening_times', ["shop_id" => $current_shop, "opening_time" => $openingTime]);
    }

    public function opening_times_upload(Request $request): RedirectResponse
    {
        $current_shop = $this->get_shopid();

        $this->validate($request, [
            'opening_time' => 'required|string|max:200',
        ]);

        $checkExist = OpeningTimes::where('shop_id', $current_shop)->first();
        //dd($checkExist);
        if ($checkExist) {
            OpeningTimes::where('shop_id', $current_shop)->delete();
        }

        OpeningTimes::create([
            'opening_time' => $request->opening_time,
            'shop_id' => $request->shopId,
        ]);

        return back()->with('success', 'Opening time updated!');
    }

    public function opening_times_delete(): RedirectResponse
    {
        $current_shop = $this->get_shopid();
        OpeningTimes::where('shop_id', $current_shop)->delete();
        return back()->with('success', 'Deleted successfully!');
    }

}
