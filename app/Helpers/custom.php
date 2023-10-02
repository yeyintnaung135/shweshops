<?php

use Illuminate\Support\Facades\Storage;

function filedopath($uri)
{
    if (env('USE_DO') == 'true') {
        return env('DIGITALOCEAN_SPACES_ENDPOINT') . '/prod' . $uri;

    } else {
        return url('/images' . $uri);
    }
}
function dofile_exists($uri)
{
    if (env('USE_DO') == 'true') {
        return Storage::disk('digitalocean')->exists('/prod' . $uri);
    } else {
        return Storage::disk('public_image')->exists($uri);
    }
}
