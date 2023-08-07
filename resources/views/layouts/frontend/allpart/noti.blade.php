<div class="modal fade" id="notiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Title">Notification</h5>
                <button type="button" class="close sop-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body sop-noti-bg">
                <div id="discountStatic" class="d-flex flex-column justify-content-center align-items-center">
                    <p>No noti yet</p>

                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
<style>
    .sop-close{
        background: #fff;
    }
    .sop-close:hover{

        background: #fff;
    }
    .sop-close span:hover{
        color:#780116;
        background: #fff;
        transform: scale(1.2);
    }
    .noti-card{
        background: rgb(255, 255, 255);
        border: solid 1px #959595a5;
        border-radius: 10px;
        padding: 10px;
        width: 100%;
        margin-bottom: 15px ;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }
    .sop-noti-bg{
        background: #f3f3f3a5;
    }
    .sop-noti-bg .noti-card a:hover{
        color:black!important;
    }
</style>
@endpush

@push('custom-scripts')
<script>

    function pushDiscount(){
        let discountedItemsArray = window.localStorage.getItem("discountedID") != '' ? JSON.parse(window.localStorage.getItem("discountedID")) : '';
        let discountedItems = Object.keys(discountedItemsArray);
        let discountArrayLength = discountedItems.length;
        let discountArrayBuffer = discountArrayLength -1;

        let firstItem = Object.keys(discountedItemsArray).length !== 0 ? discountedItemsArray[Object.keys(discountedItemsArray)[0]].name : '';


        console.log('firstItem',firstItem)
        let discountForText = '';
        let be = 'are';
        if(discountArrayLength-1 > 1 ){
             discountForText = ` and ${discountArrayBuffer} other items `;
        }else if(discountArrayLength-1 == 1 ){
             discountForText = ` and ${discountArrayBuffer} other item `;

        }else if(discountArrayLength-1 >99 ){
             discountForText = ` and 99+ other item `;
        }
        else{

             discountForText = "";
             be = 'is';
        }
        console.log(discountForText);
        console.log(discountArrayLength);
        if(discountArrayLength ==0){
            $("#discountStatic").html(`<div class="noti-card">
                <div>
                    <p>
                        No Item is on discount yet. We will notify you as soon as the items in your
                        favourite list are on Discount!
                    </p>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{url('/myfav')}}">
                        <i class="fa-regular fa-heart" style="color:#780116 !important;" id="mobileFootHeart"></i>
                        Check Favourite List <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>`);
        }
        else{
            $("#discountStatic").html(`<div class="noti-card">
                <div>
                    <p>
                        Item ${firstItem} ${discountForText} from your favourite list ${be} on Discount!
                    </p>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{url('/myfav')}}">
                        <i class="fa-regular fa-heart" style="color:#780116 !important;" id="mobileFootHeart"></i>
                        Check Favourite List <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>`);
        }
        @if (isset(Auth::guard('shop_owner')->user()->id) )
            var noti = {!! Auth::guard('shop_owner')->user() !!}.notification
        @elseif (isset(Auth::guard('web')->user()->id) )
            var noti = {!! Auth::guard('web')->user() !!}.notification
        @elseif (isset(Auth::guard('shop_role')->user()->id) )
            var noti = {!! Auth::guard('shop_role')->user() !!}.notification
        @endif

        console.log('noti',noti.length)
        for (i=0;i<noti.length;i++){
            let temp = noti[i];
            console.log('temp', temp)
            $("#discountStatic").append(`<div class="noti-card">
                <div>
                    <a href="//${location.hostname}/${temp.WithoutspaceShopname}/product_detail/${temp.item_id}" onClick="notiRead(${temp.sender_shop_id},${temp.receiver_user_id},${temp.item_id},'${temp.user_type}')">
                        <p>
                            ${temp.message}
                        </p>
                    </a>
                </div>
            </div>`);
        }
    }
    function notiRead(sender,receiver,item,user){
        $.ajax({
                url: "/notification",
                type:"post",
                data:{
                    sender: sender,
                    receiver: receiver,
                    item: item,
                    user: user,
                    read_by_receiver: 1,
                    _token: _token,
                },
                success:function(response){
                    console.log(response)
                },
                error: function(error) {
                    console.log(error);
                }
            });
    }
    $( document ).ready(function() {
        @if (isset(Auth::guard('web')->user()->id) || isset(Auth::guard('shop_owner')->user()->id) || isset(Auth::guard('shop_role')->user()->id))
        pushDiscount();

        @endif
        ifChosenFavM();
    });
</script>
@endpush
