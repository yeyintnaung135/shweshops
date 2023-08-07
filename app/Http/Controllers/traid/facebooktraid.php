<?php
namespace App\Http\Controllers\traid;


use App\Models\discount;
use App\Models\facebooktable;
use App\Models\Item;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

trait facebooktraid
{
    use similarlogic;

    public function basetemplate($name, $showprice, $photo, $description, $wsshopname, $id)
    {
        return ["title" => $name . ' (' . $showprice . ')',
            "image_url" => $photo,
            "subtitle" => $description,
            "default_action" => [
                "type" => "web_url",
                "url" => url($wsshopname . '/product_detail/' . $id),
                "webview_height_ratio" => "tall",


            ]
        ];
    }

    public function sendimagetemplate($psid, $ref_parm)
    {
        $get_item = Item::where('id', $ref_parm)->first();
        $forshowprice = 0;
        if ($get_item->price == 0) {
            $forshowprice = $get_item->min_price . '-' . $get_item->max_price . ' Kyats';
        } else {
            $forshowprice = $get_item->price . ' Kyats';

        }
        $photo = url($get_item->check_photobig);
        $access_token = facebooktable::where('shop_id', $get_item->shop_id)->first()->longlivepagetoken;
        $response = Http::withHeaders([
            'Content-Type' => "application/json"
        ])->post('https://graph.facebook.com/v13.0/me/messages?access_token=' . $access_token,
            [
                "recipient" => ['id' => $psid], 'message' => ['attachment' => ['type' => 'template', 'payload' => ["template_type" => "generic",
                'elements' => [
                    [
                        "title" => $get_item->name . ' (' . $forshowprice . ')',
                        "image_url" => $photo,
                        "subtitle" => $get_item->description,
                        "default_action" => [
                            "type" => "web_url",
                            "url" => url($get_item->WithoutspaceShopname . '/product_detail/' . $get_item->id),
                            "webview_height_ratio" => "tall",


                        ],

                    ]

                ]
            ]
            ]
            ]
            ]);
        return $response;
    }

    public function sendslidetemplate($psid, $ref_parm)
    {
        $get_item = Item::where('id', $ref_parm)->first();

        $elements = [];


        $similaritems = Item::select('items.*')->leftjoin('discount', 'items.id', '=', 'discount.item_id')->where(function ($query) use ($ref_parm) {
            $query->whereRaw($this->getsimilarsqlcode($ref_parm));
        })->where('items.shop_id', '=', $get_item->shop_id)->where('items.category_id', $get_item->category_id)->orderByRaw("CASE
                        WHEN discount.discount_price = 0 THEN discount.discount_min
            WHEN discount.discount_price !=  0 THEN discount.discount_price
            WHEN items.price=0 THEN min_price
            WHEN items.price!=0 THEN price
            END
            ASC")->limit(20)->get();


        $forshowprice = 0;

        if ($get_item->price == 0) {
            $forshowprice = $get_item->min_price . '-' . $get_item->max_price . ' Kyats';
        } else {
            $forshowprice = $get_item->price . ' Kyats';

        }

        $photo = url($get_item->check_photobig);
        $access_token = facebooktable::where('shop_id', $get_item->shop_id)->first()->longlivepagetoken;

        $elements[0] = $this->basetemplate($get_item->name, $forshowprice, $photo, $get_item->description, $get_item->WithoutspaceShopname, $get_item->id);

        foreach ($similaritems as $key => $value) {
            $sphoto = url($value->check_photobig);

            if ($value->price == 0) {
                $sforshowprice = $value->min_price . '-' . $value->max_price . ' Kyats';
            } else {
                $sforshowprice = $value->price . ' Kyats';

            }

            $elements[$key+1] = $this->basetemplate($value->name, $sforshowprice, $sphoto, $value->description, $value->WithoutspaceShopname, $value->id);;
        }


        $response = Http::withHeaders([
            'Content-Type' => "application/json"
        ])->post('https://graph.facebook.com/v13.0/me/messages?access_token=' . $access_token,
            [
                "recipient" => ['id' => $psid], 'message' => ['attachment' =>
                ['type' => 'template',
                    'payload' => ["template_type" => "generic",
                        'elements' => $elements
                    ]
                ]
            ]
            ]);
        return $response;
    }

    public function posttofbpage($shopid,$data,$photolink){
        $getfbdata=facebooktable::where('shop_id',$shopid)->first();
        $response = Http::withHeaders([
            'Content-Type' => "application/json"
        ])->post('https://graph.facebook.com/'.$getfbdata->page_id.'/photos',
            [
                'message'=>Str::limit($data,100,'...'),
                'url'=>url($photolink),
                'access_token'=>$getfbdata->longlivepagetoken

            ]);
        return $response;
    }


}


?>
