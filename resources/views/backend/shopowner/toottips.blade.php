<?php
$endpoint = str_replace(url('/'), '', url()->current());

$gettt = \Illuminate\Support\Facades\DB::table('for_tooltips')->where('endpoint', 'like', '%' . $endpoint . '%');

?>
@if($gettt->count() > 0)

    <span class="yk-info fa fa-info-circle">
        <div class="yk-tootips">
         {!! $gettt->first()->info !!}
        </div>
    </span>
@endif
