<?php if(!empty($display) && $display == "product"): ?> 
<div class="d-xl-none px-md-5 " style="">
  <div class="mx-4 mx-md-3 mx-lg-0 cart-item" style="position: relative">

      <form action="" id="searchformM">
          
          <div class="cart-total my-3 d-flex align-items-end sn-search-form">
            <i class="fa-solid fa-search sn-search-placeholder"></i>
            <input class="sop-input" type="text" id="SearchTextM"
                    placeholder="Search by typing ...">
            
            <button id="SearchButtonM" type="submit">Go</button>
        </div>
      </form>

  </div>
</div>
<?php else: ?>
<div class="d-xl-none px-md-5 " style="">
  <div class="mx-4 mx-md-3 mx-lg-0 cart-item" style="position: relative">

      <form action="" id="searchformM">
          
          <div class="cart-total my-3 d-flex align-items-end sn-search-form">
            <i class="fa-solid fa-search sn-search-placeholder"></i>
            <input class="sop-input" type="text" id="SearchTextM"
                    placeholder="Search by typing ...">
            
            <button id="SearchButtonM" type="submit">Go</button>
        </div>
      </form>

  </div>
</div>
<?php endif; ?>


<?php $__env->startPush('custom-scripts'); ?>
<Script>
        $("#searchformM").submit(function(event){
            var inputval=$('#SearchTextM').val();
            window.localStorage.setItem('searchtext',inputval);
            event.preventDefault();
            return location.assign("<?php echo e(url('ajax_search_result')); ?>"+'/'+inputval);

        });
        $(document).ready(function () {
            if(window.localStorage.getItem('SearchTextM') != undefined){
                $('#SearchTextM').val(window.localStorage.getItem('SearchTextM'));
            }else{
                $('#SearchTextM').val('');
            }
            //for search form
            $("#searchformM").submit(function (event) {
              var inputval = $('#SearchTextM').val();
              window.localStorage.setItem('SearchTextM',inputval);
              event.preventDefault();
              return location.assign("<?php echo e(url('ajax_search_result')); ?>" + '/' + inputval);
            });
        });

</Script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('css'); ?>
<style>
    /* .sop-m-search{
        width: 80px;
        background-color: #780116;
        color:white;
    } */
    #SearchTextM {
      margin-right: 5px !important;
      border-radius: 5px !important;
    }
    #SearchButtonM {
      background: #780116;
      color: #fff;
      border-radius: 5px;
    }
    @media (min-width: 576px){
        #searchformM input{
            width: 100%;
            box-sizing: border-box;
            padding:8px;
        }
        
    }
</style>
<?php $__env->stopPush(); ?><?php /**PATH P:\xampp\htdocs\shweshops\resources\views/layouts/frontend/allpart/mobile_search.blade.php ENDPATH**/ ?>