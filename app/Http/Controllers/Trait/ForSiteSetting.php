<?php
namespace App\Http\Controllers\Trait;


use App\Models\sitesettings;

trait ForSiteSetting
{
   public function is_chat_on(){
       $check_chat=sitesettings::where('name','ownchat')->first();
       if($check_chat->action == 'on'){
           return true;
       }else{
           return false;
       }

   }
}

?>
