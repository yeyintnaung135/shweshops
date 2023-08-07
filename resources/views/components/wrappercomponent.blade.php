<div class="remove_wrapp" id="{{$divId}}" style="height: 222px !important;">
    <div id="ct-loadding" class="style5 yk-wrapper ">
        <div class="ct-spinner5">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
</div>
@push('custom-scripts')
    <script>
       if(document.getElementById('{{$divId}}').offsetHeight > 0){
           document.getElementById('{{$toshowId}}').classList.remove('d-none');
           document.getElementById('{{$divId}}').classList.add('d-none');
       }


    </script>

@endpush
