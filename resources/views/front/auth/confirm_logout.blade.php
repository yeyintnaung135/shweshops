<div class="modal modal-bottom  xs fade" id="confirm_logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-warning" role="document" style="position:relative;bottom: -32%;">
        <!--Content-->
        <div class="modal-content" style="background-color: #F3F4F9;">
            <!-- <button type="button" class="close sop-close" data-dismiss="modal" aria-label="Close" style=" background-color: #F3F4F9">
                <i class="fa-solid fa-xmark" style="font-size: 28px;background-color: #F3F4F9;"></i>
            </button> -->
            <div class="modal-header confirm" style="margin-top: -12px;">
                <h4 class="modal-title white-text w-100 font-weight-bold py-2" id="" style="color:#780116!important;" >
                အကောင့်ထွက်ရန် အတည်ပြုပါ <br/>
                <span style="font-size:1rem; color:rgba(0, 0, 0, 0.592)!important;">
                    ရွေးမှတ်ထားသည်များ ကြည့်လိုလျှင် အကောင့်ပြန်ဝင်ရန် လိုအပ်မည်
                </span>
                </h4>
            </div>
            <div class="d-flex justify-content-around align-items-center bg-white" style="min-height: 50px">

                <div>
                    <a data-dismiss="modal" aria-label="Close" style="color:#780116!important;" >
                        <i class="fa-solid fa-xmark"></i> ပယ်ဖြတ်မည်
                    </a>
                </div>

                <div>
                    <a class="" href="javascript:void(0)" style="color:#780116!important;" onclick=" deleteLocalData();">
                        <i class="fa-solid fa-check"></i> ထွက်မည်
                    </a>
                </div>
            </div>
            <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>
@push('css')
<style>
    .sop-close{
        display: flex;
        justify-content: end;
        margin-right:10px;
        color: #780117c8!important;

    }
    .sop-close :hover,.sop-close:focus {
        background-color: #000;
        color: #780116!important;
    }
</style>
@endpush
@push('custom-scripts')
<script>
    function deleteLocalData(){
        event.preventDefault();

        localStorage.clear();
        document.getElementById('logout-form').submit();
    }
</script>
@endpush
