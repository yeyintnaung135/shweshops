<?php
namespace App\Http\Controllers\Trait;

use App\Models\SiteSettings;

trait ForSiteSetting
{
    public function is_chat_on()
    {
        $check_chat = SiteSettings::where('name', 'ownchat')->first();
        if ($check_chat->action == 'on') {
            return true;
        } else {
            return false;
        }

    }
}
