<?php
namespace App\Models;

use App\Ads;
use Illuminate\Support\Carbon;
use App\Http\Controllers\traid\ykimage;

class Ajax{
    use ykimage;


    public function expiration()
    {
      Ads::where('end','<=',Carbon::now()->format('Y-m-d H:i:s A'))->delete();
    }

    public function encode($request,$folderPath){

        // $folderPath = public_path('images/news/');

        foreach($request as $re){
          $image_parts = explode(";base64,", $re);
          $image_type_aux = explode("image/", $image_parts[0]);
          // $image_type = $image_type_aux[1];
          $image_base64 = base64_decode($image_parts[1]);

          $imageName = uniqid() . '.png';

          $imageFullPath = $folderPath.$imageName;


          file_put_contents($imageFullPath, $image_base64);
        }

        return $imageName;
    }

    public function fileStore($file,$folderPath){

      $newFileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $lpath=$file->move(public_path($folderPath), $newFileName);
      // $this->setthumbsadsbanner($lpath, $newFileName);
      return $newFileName;
    }



}
