<?php

namespace App\Http\Controllers\Trait;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


trait YKImage
{
    public function save_image($file, $fileName, $directory): string
    {
        if (env('USE_DO') != 'true') {
            $file->storeAs($directory, $fileName, 'public_image');

            return 'done';
        } else {
            return $this->save_image_digitalocean($file, $fileName, $directory);
        }
    }
    public function save_image_digitalocean($file, $fileName, $directory)
    {

        $file->storeAs('prod/' . $directory, $fileName, 'digitalocean');

        return 'done';
    }

    public function delete_image($imagePath, $thumbnailPath=null)
    {
      if(env('USE_DO') == 'true') {

        Storage::disk('digitalocean')->delete('/prod/'.$imagePath);
        if($thumbnailPath != null){
            Storage::disk('digitalocean')->delete('/prod/'.$thumbnailPath);
        }

      }else{
        Storage::disk('public_image')->delete($imagePath);
        if($thumbnailPath != null){
            Storage::disk('public_image')->delete($thumbnailPath);
        }
      }
    }

   

    function base64_to_image($base64_string, $output_file):string
    {
        if (env('USE_DO') != 'true') {

            // open the output file for writing
            $ifp = fopen(public_path('/images/'.$output_file), 'wb');

            // split the string on commas
            // $data[ 0 ] == "data:image/png;base64"
            // $data[ 1 ] == <actual base64 string>
            $data = explode(',', $base64_string);

            // we could add validation here with ensuring count( $data ) > 1
            fwrite($ifp, base64_decode($data[1]));

            // clean up the file resource
            fclose($ifp);
        } else {
            $data = explode(',', $base64_string);
            $image = base64_decode($data[1]);
            Storage::disk('digitalocean')->put('prod/'.$output_file, $image);
        }





        return 'done';
    }

    public function setthumbs($path, $imagename)
    {
        $forthumb = Image::make($path);
        $forthumb->resize(300, 300)->save(public_path('images/items/mid/') . $imagename, 60);
        $forthumb->resize(100, 100)->save(public_path('images/items/thumbs/') . $imagename, 60);
    }

    public function setthumbslogo($path, $imagename)
    {
        $forthumb = Image::make($path);
        $forthumb->resize(300, 300)->save(public_path('images/logo/mid/') . $imagename, 60);
        $forthumb->resize(100, 100)->save(public_path('images/logo/thumbs/') . $imagename, 60);
    }

    public function setthumbsbanner($path, $imagename)
    {
        $forthumb = Image::make($path);
        $forthumb->resize(300, 300)->save(public_path('images/banner/mid/') . $imagename, 60);
        $forthumb->resize(100, 100)->save(public_path('images/banner/thumbs/') . $imagename, 60);
    }
    public function setthumbsadsbanner($path, $imagename)
    {
        $forthumb = Image::make($path);
        $forthumb->resize(800, 250)->save(public_path('images/banner/mid/') . $imagename, 60);
        $forthumb->resize(500, 200)->save(public_path('images/banner/thumbs/') . $imagename, 30);
    }

    //NOTE Reusable as long as it meets requirements
    public function resizeImages($baseDirectory, $subDirectory, $imageName)
    {
        $imageDirectory = public_path("images/{$baseDirectory}/{$subDirectory}/");
        $imagePath = "{$imageDirectory}{$imageName}";

        Image::make($imagePath)
            ->fit(1000, 1000)
            ->save("{$imageDirectory}{$imageName}", 60)
            ->fit(50, 50)
            ->save("{$imageDirectory}thumbs/{$imageName}", 60);
    }

    //NOTE please check these links for more information https://shorturl.at/imx06 and https://shorturl.at/hjGMY
    public function resizeImagesDigitalOcean($baseDirectory, $subDirectory, $imageName)
    {
        $imageDirectory = "prod/{$baseDirectory}/{$subDirectory}/";
        $imagePath = $imageDirectory . $imageName;

        $image = Image::make(Storage::disk('digitalocean')->get($imagePath))
            ->fit(1000, 1000)
            ->stream()
            ->__toString();

        $thumbImage = Image::make($image)
            ->fit(50, 50)
            ->stream()
            ->__toString();

        Storage::disk('digitalocean')->put($imagePath, $image);
        Storage::disk('digitalocean')->put($imageDirectory . 'thumbs/' . $imageName, $thumbImage);
    }
}
