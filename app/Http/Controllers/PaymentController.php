<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\discount;
use App\Models\Item;
use App\Models\Orderfordinger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentController extends Controller
{
    //
    public function order($id)
    {
        $checkitemexit = $this->chckitemexit($id);
        if ($checkitemexit == 'yes') {
            $total = $this->caltotal(1, $id);


            $orderdata = Orderfordinger::create(['user_id' => Auth::guard('web')->user()->id, 'item_id' => $id, 'item_counts' => '1', 'status' => 'start', 'amount' => $total]);

            return view('front.checkoutstart', ['item_id' => $id, 'order_id' => $orderdata->id, 'amount' => $orderdata->amount]);
        } else {
            return 'Items not exit';
        }
    }

    public function caltotal($count, $id)
    {
        $itemdata = Item::where('id', $id)->first();
        $checkdiscount = discount::where('item_id', $id)->first();
        if (!empty($checkdiscount)) {
            if ($checkdiscount->discount_price == 0) {
                $total = $count * $checkdiscount->discount_max;
                return $total;
            } else {
                $total = $count * $checkdiscount->discount_price;
                return $total;
            }
        } else {
            if ($itemdata->price == 0) {
                $total = $count * $itemdata->max_price;
                return $total;
            } else {
                $total = $count * $itemdata->price;
                return $total;
            }
        }

    }

    public function chckitemexit($itemid)
    {
        $itemdata = Item::where([['id', '=', $itemid], ['deleted_at', '=', NULL], ['stock_count', '>=', '1']])->first();
        if (!empty($itemdata)) {
            return 'yes';
        } else {
            return 'no';
        }

    }

    public function feebypercent($orprice)
    {
        $fee = ($orprice / 100) * 10;
        return $fee;

    }

    public function customizepay(Request $request)
    {
        $order = Orderfordinger::where('id', $request->orderid)->first();
        $total = $this->caltotal(1, $order->item_id);
        $totalafteraddedfee = $total + $this->feebypercent($total);
//        return $total;


        $items_data = array(
            "name" => $request->name,
            "amount" => $totalafteraddedfee,
            "quantity" => 1,
            "orderid" => $request->orderid,
            "input_phone" => $request->phone,
            "address" => $request->address

        );
        if ($request->qrorapp = "QR") {
            $qrorapp = "QR";
        }
        $data_pay = json_encode(array(
            "providerName" => $request->walletbankname,
            "methodName" => $qrorapp,
            "totalAmount" => $totalafteraddedfee,
            "items" => json_encode(array($items_data)),
            "orderId" => Carbon::now()->timestamp . '_' . $request->orderid,
            "customerName" => $request->name,
            "customerPhone" => Auth::user()->phone
        ));

        $publicKey = '-----BEGIN PUBLIC KEY-----MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCJtu2coOqkFaaxLtlnb6DAQRvw+6l9iwm6RZlGrAf6IUnZiJavYi60hTveLkFbeYLvvLcFyIGddQDUJBCvEOIk7GwgF6pPRlV9k5g7CDyHbqsjudOix+ElD2XkAiUeYWAK++uRVBqcE/xxwNMDoRwyYqoC/OifZf0pH7PA3XCUyQIDAQAB-----END PUBLIC KEY-----';

        $rsa = new \phpseclib\Crypt\RSA();

        extract($rsa->createKey(1024));
        $rsa->loadKey($publicKey); // public key
        $rsa->setEncryptionMode(2);

        $ciphertext = $rsa->encrypt($data_pay);

        $value = base64_encode($ciphertext);
        $tostring = strval($value);

        $paymenttoken = Http::get('https://staging.dinger.asia/payment-gateway-uat/api/token', [
            'projectName' => 'sannkyi staging',
            'apiKey' => 'm7v9vlk.eaOE1x3k9FnSH-Wm6QtdM1xxcEs',
            'merchantName' => 'mtktest'
        ]);
        $topay = Http::asForm()->withToken($paymenttoken['response']['paymentToken'])->post('https://staging.dinger.asia/payment-gateway-uat/api/pay', ["payload" => $value]);

        if ($request->qrorapp = "QR") {

            Orderfordinger::where('id', $request->orderid)->update(['qr' => $topay['response']['qrCode'], 'transaction_no' => $topay['response']['transactionNum']]);
            return redirect('payment/returnqrfromdinger/' . $request->orderid);
        }
        return $topay;
    }

    public function returnqrorappfromdinger($orderid)
    {
        $order = Orderfordinger::where('id', $orderid)->first();
        $imagename= 'images/qrcode/' .Carbon::now()->timestamp . $orderid . '.svg';
        QrCode::size(400)->generate('Make me into a QrCode!', public_path($imagename));
//        $img = QrCode::size(400)->format('png')->generate('Make me into a QrCode!');
//        Storage::disk('public')->put('filename.png', $img);

        return view('front.qrcode',['imagename'=>$imagename]);


    }

    public function pay(Request $request)
    {
        $orderdata = Orderfordinger::where('id', $request->orderid)->first();


        if (!empty($orderdata)) {
            $itemdata = Item::where([['id', '=', $orderdata->item_id], ['deleted_at', '=', NULL], ['stock_count', '>=', '1']])->first();
            if (!empty($itemdata)) {
                $items_data = array(
                    "name" => $itemdata->name,
                    "amount" => $orderdata->amount,
                    "quantity" => 1
                );

                $data_pay = json_encode(array(
                    "clientId" => "8e9e84f7-2f29-30fa-86e2-3a7fab12e3d9",
                    "publicKey" => "34fcb7e0bd5fcd37b246a04d77ad89ac",
                    "items" => json_encode(array($items_data)),
                    "customerName" => "shweshops",
                    "totalAmount" => $orderdata->amount,
                    "merchantOrderId" => $orderdata->id,
                    "merchantKey" => env('DIN_MER_API'),
                    "projectName" => "shweshopspb",
                    "merchantName" => "Ye Yint Naung",

                ));


                $publicKey = '-----BEGIN PUBLIC KEY-----MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCFD4IL1suUt/TsJu6zScnvsEdLPuACgBdjX82QQf8NQlFHu2v/84dztaJEyljv3TGPuEgUftpC9OEOuEG29z7z1uOw7c9T/luRhgRrkH7AwOj4U1+eK3T1R+8LVYATtPCkqAAiomkTU+aC5Y2vfMInZMgjX0DdKMctUur8tQtvkwIDAQAB-----END PUBLIC KEY-----';

                $rsa = new \phpseclib\Crypt\RSA();

                extract($rsa->createKey(1024));
                $rsa->loadKey($publicKey); // public key
                $rsa->setEncryptionMode(2);
                $ciphertext = $rsa->encrypt($data_pay);
                $value = base64_encode($ciphertext);

                $urlencode_value = urlencode($value);

                $encryptedHashValue = hash_hmac('sha256', $data_pay, env('DIN_CLIENT_SEC'));

                return redirect("https://prebuilt.dinger.asia/?hashValue=" . $encryptedHashValue . "&payload=" . $urlencode_value);

            } else {
                return 'item out of stock';
            }
        } else {
            return 'something wrong';
        }

    }
}
