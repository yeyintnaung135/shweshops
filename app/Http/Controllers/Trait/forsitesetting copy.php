<?php
namespace App\Http\Controllers\traid;


use App\sitesettings;

trait forsitesetting
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
