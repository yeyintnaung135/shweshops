<div class="footer-mobile">
    <div class="mobile-home">
        <a href="{{url('/')}}">
            <i class="zh-icon fa fa-home" style="@if(Request::path() == "/" || Request::path() == "unittest/index") color:#780116 !important; @else color:#666666 !important; @endif"></i>
            Home </a>
    </div>
    <div class="mobile-home">
        <a href="{{url('see_by_categories')}}">

            <i class="zh-icon fa-solid fa-magnifying-glass" style="@if(Request::path() == "see_by_categories") color:#780116 !important; @else color:#666666 !important; @endif"></i>
            Search</a>
    </div>
    <div
        class="sop-mobile-nav ">
        <a2cicon-com></a2cicon-com>
    </div>



    <div class="mobile-home">
        <a href="{{url('/shops')}}">
            <div class="position-relative">
                <i class="fas fa-store" style="@if(Request::path() == "shops") color:#780116 !important; @else color:#666666 !important; @endif" id="mobileFootHeart"></i>
                {{-- <span id="favm-a2c-count" class="position-absolute" style="top:0;right:5px;color:#780116 !important;">0</span> --}}
            </div>

            Shop</a>

    </div>

    @if(isset(Auth::guard('web')->user()->id))
        <form type="hidden" id="fav-server"  method="POST" style="display: none;">
            @csrf
        </form>
        <form type="hidden" id="selection-server"  method="POST" style="display: none;">
            @csrf
        </form>
        <div class="mobile-account">
            <a href="{{route('backside.user.user_profile')}}">
                <!--<i class="zh-icon fa-solid fa-arrow-right-from-bracket" style="color:#780116 !important;"></i>-->
                <!--Logout-->
                <i class="zh-icon fa-solid fa-user-gear a-arrow-right-from-bracket" style="color:#666666 !important;"></i>
                Profile
            </a>
        </div>

    @elseif(isset(Auth::guard('shop_owners_and_staffs')->user()->id))
        <div class="mobile-account">
            <a href="{{url('backside/shop_owner/detail')}}">
                <i class="zh-icon fa-solid fa-user-gear" style="color:#666666 !important;"></i>
                Shop Owner
            </a>
        </div>

    @elseif(isset(Auth::guard('shop_owners_and_staffs')->user()->id))
        <div class="mobile-account">
            <a href="{{url('backside/shop_owner/detail')}}" title="Logout">
                <i class="zh-icon fa-solid fa-user-gear" style="color:#666666 !important;"></i>
                Shop
            </a>
        </div>
    @else
        <div class="mobile-account">

            <a href="" class="checkForm" title="checkForm" data-toggle="modal" data-target="#orangeModalSubscription">
                <i class="zh-icon fa fa-user" style="color:#666666 !important;"></i>
                Login</a>

        </div>
    @endif


</div>
{{-- noti --}}
@include('layouts.frontend.allpart.noti')
{{-- noti --}}
{{-- confirm logout --}}
@include('layouts.frontend.allpart.confirm_logout')
{{-- confirm logout --}}
<!-- zh pop up -->
@include('layouts.frontend.allpart.popup')
<!-- end zh pop up -->
@push('custom-scripts')
    <script>

        @if (isset(Auth::guard('web')->user()->id))
        var userID = {!! (Auth::guard('web')->user()) !!};
        let userType = "Users"
        console.log('userID',userID)
        @elseif(isset(Auth::guard('shop_owners_and_staffs')->user()->id))
        var userID = {!! (Auth::guard('shop_owners_and_staffs')->user()) !!};
        let userType = "Shop_owners";
        console.log('userID',userID);
        @elseif(isset(Auth::guard('shop_owners_and_staffs')->user()->id))
        var userID = {!! (Auth::guard('shop_owners_and_staffs')->user()) !!};
        let userType = "Manager"
        console.log('userID',userID)
        @endif

        @if (isset(Auth::guard('web')->user()->id) || isset(Auth::guard('shop_owners_and_staffs')->user()->id) || isset(Auth::guard('shop_owners_and_staffs')->user()->id))
        //remove dup from array
        Array.prototype.unique = function() {
            var a = this.concat();
            for(var i=0; i<a.length; ++i) {
                for(var j=i+1; j<a.length; ++j) {
                    if(a[i] === a[j])
                        a.splice(j--, 1);
                }
            }
            return a;
        };
        //fav from server
        let tempFavIds = userID.favIds;
        let tempFavIdsArray = [];
        console.log('tempFavIds',tempFavIds)
        for (i=0; i<tempFavIds.length;i++){
            let tempArray= tempFavIds[i].fav_id;
            tempFavIdsArray.push(tempArray.toString());
        }
        //selection from server
        let tempselectionIds = userID.selectionIds;
        let tempselectionIdsArray = [];
        for (i=0; i<tempselectionIds.length;i++){
            let tempArray= tempselectionIds[i].selection_id;
            tempselectionIdsArray.push(tempArray.toString());
        }

        let favouritedLocal = window.localStorage.getItem("fav") != null ? Object.keys(JSON.parse(window.localStorage.getItem("fav"))) : [];
        let selectionLocal =  window.localStorage.getItem("selection") != null ? Object.keys(JSON.parse(window.localStorage.getItem("selection"))) : [];

        let favouritedServer = tempFavIdsArray || []   ;
        let selectionServer = tempselectionIdsArray || [] ;

        let newSelectionSync = selectionLocal.concat(selectionServer).unique() || [];
        let newFavSync = favouritedLocal.concat(favouritedServer).unique()  || [];

        function syncLocalOnlineData(){

            localStorage.setItem("favID", JSON.stringify(newFavSync));
            localStorage.setItem("selectionID", JSON.stringify(newSelectionSync));
            //api call here



        }
        @endif

        function getSyncSelectionID(){
            let syncArrayID = JSON.parse(window.localStorage.getItem("selectionID")) || '';

            if(syncArrayID.length!=0){

                $.ajax({
                    url: "/addtocart",
                    type:"PUT",
                    data:{
                        data:syncArrayID,
                        _token: _token
                    },
                    success:function(response){
                        var responseObj = convertArrayToObject(response,'id');
                        localStorage.setItem("selection", JSON.stringify(responseObj));
                        addtocartcount();
                        ifChosenSelectionLength();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }
        function getSyncFavID(){
            let syncArrayFID = JSON.parse(window.localStorage.getItem("favID")) || '';

            if(syncArrayFID.length!=0){
                $.ajax({
                    url: "/myfav",
                    type:"PUT",
                    data:{
                        data:syncArrayFID,
                        _token: _token
                    },
                    success:function(response){
                        var responseObj = convertArrayToObject(response,'id');
                        localStorage.setItem("fav", JSON.stringify(responseObj));
                        ifChosenFavLength();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

        }

        function postSyncSelectionID(){
            @if (isset(Auth::guard('web')->user()->id) || isset(Auth::guard('shop_owners_and_staffs')->user()->id))
            $.ajax({
                url: "/addtocart/update",
                type:"post",
                data:{
                    users: userType,
                    newSelection: newSelectionSync,
                    id: userID.id,
                    _token: _token,
                },
                success:function(response){
                    console.log(response)
                },
                error: function(error) {
                    console.log(error);
                }
            });
            @else
                return
            @endif
        }
        function postSyncFavID(){
            @if (isset(Auth::guard('web')->user()->id) || isset(Auth::guard('shop_owners_and_staffs')->user()->id))
            $.ajax({

                url: "/myfav/update",
                type:"post",
                data:{
                    users: userType,
                    newFav: newFavSync,
                    id: userID.id,
                    _token: _token,
                },
                success:function(response){
                    console.log(response)
                },
                error: function(error) {
                    console.log(error);
                }
            });
            @else
                return
            @endif
        }

        function ifChosenFavM() {

            var favourited = JSON.parse(window.localStorage.getItem("fav"));

            if (favourited!= null && Object.keys(favourited).length != 0) {
                $("#mobileFootHeart").toggleClass("fa-regular fa-solid")
                $("#windowFavNav").toggleClass("fa-regular fa-solid")
            }
            return
        }

        function addtocartcount(){
            let selectionLocal =  window.localStorage.getItem("selection") != null ? Object.keys(JSON.parse(window.localStorage.getItem("selection"))).length : 0;
            document.getElementById("temp").innerHTML = selectionLocal;

        }
        function checkDiscount(){
            let discountedID = {};
            let favouritedLocalAll = window.localStorage.getItem("fav") != null ? (JSON.parse(window.localStorage.getItem("fav"))) : {};
            for (const [key, value] of Object.entries(favouritedLocalAll)) {
                for (const [keyChild, valueChild] of Object.entries(value)) {
                    if(keyChild == 'YkgetDiscount' && valueChild != 0){
                        // discountedID.push(key);
                        var temp = {
                            [key]: value
                        }
                        console.log('test', temp)
                        Object.assign(discountedID, temp)
                    }
                }
            }
            console.log('discountedID,',discountedID);
            localStorage.setItem("discountedID", JSON.stringify(discountedID));
        }
        function ifChosenDiscountM() {

            var discounted = JSON.parse(window.localStorage.getItem("discountedID"));

            if (discounted!= null && Object.keys(discounted).length != 0) {
                $("#mobileFootNoti").toggleClass("far fas")
            }
            return
        }
        $( document ).ready(function() {
            @if (isset(Auth::guard('web')->user()->id) || isset(Auth::guard('shop_owners_and_staffs')->user()->id))
            syncLocalOnlineData();
            getSyncFavID();
            getSyncSelectionID();
            postSyncSelectionID();
            postSyncFavID();
            checkDiscount();
            ifChosenDiscountM();
            @endif

        });
    </script>

@endpush
