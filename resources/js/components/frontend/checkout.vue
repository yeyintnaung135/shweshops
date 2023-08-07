<template xmlns="http://www.w3.org/1999/html">
    <div class="row">
        <form :action="this.host+'/payment/customizepay'" method="post" ref="form">
            <div id="main-content" class="show_dev col-sm-9 col-xs-12 d-none">
                <div class="font-weight-bold selecttitle">
                    <p>ငွေပေးချေမှုနည်းလမ်းကိုရွေးပါ</p>
                </div>
                <div id=""
                    class="row product type-product post-553 status-publish first instock product_cat-accessories product_cat-bracelet product_cat-brand product_cat-earrings product_cat-fragrances product_cat-gift-for-men has-post-thumbnail shipping-taxable purchasable product-type-simple ">
                    
                    <div class="details-img col-12 col-lg-6">
                        <div class="walletdiv mt-2" :class="{walletactive:walletactive}"
                            @click="clickonwalletormbank('wallet')">
                            <div class="d-flex align-items-center">
                                <div class="walletpadding">
                                    <span class="fas fa-wallet walletfontsize"></span>
                                </div>
                                <div class="walletpadding">
                                    <div class="wallettextone">Wallet</div>
                                    <div class="wallettexttwo">(KBZ Pay , AYA Pay ,CB Pay and etc)</div>
                                </div>
                            </div>
                        </div>
                        <div class="walletdiv mt-2" :class="{mobilebankactive:mobilebankactive}"
                            @click="clickonwalletormbank('mbank')">
                            <div class="d-flex align-items-center">
                                <div class="walletpadding">
                                    <span class="fas fa-bank walletfontsize"></span>

                                </div>
                                <div class="walletpadding">
                                    <div class="wallettextone">Mobile Banking</div>
                                    <div class="wallettexttwo">(KBZ Banking , MAB Banking)</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group pt-5" v-if="this.walletactive == true">
                            <label class="selecttitle">Choose Bank</label>
                            <!-- <b-form-select v-model="walletpays" @change="banknamechange()" :options="options" size="lg"
                            class="w-100"></b-form-select> -->
                            <div class="row justify-content-around">
                                <div class="col-6 col-sm-4" align="center">
                                    <div class="chooseBankDiv" :class="{mobilebankactive:walletPay1Active}" @click="chooseBank('KBZ Pay')">
                                        <img :src="this.host+'/'+this.item.CheckPhoto" class="bankImg"> <!-- change bank image here -->
                                    </div>
                                </div>

                                <div class="col-6 col-sm-4" align="center">
                                    <div class="chooseBankDiv" :class="{mobilebankactive:walletPay2Active}" @click="chooseBank('CB Pay')">
                                        <span><img :src="this.host+'/'+this.item.CheckPhoto" class="bankImg"> <!-- change bank image here --></span>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-4" align="center">
                                    <div class="chooseBankDiv" :class="{mobilebankactive:walletPay3Active}" @click="chooseBank('Yoma Bank')">
                                        <img :src="this.host+'/'+this.item.CheckPhoto" class="bankImg"> <!-- change bank image here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group" v-if="this.walletactive == true">
                            <div>
                                <label class="selecttitle">Choose Payment Type</label>
                            </div>
                            <div class="row justify-content-around">
                                <div class="col-12 col-sm-6" align="center">
                                    <div class="m-2" :class="{qractive:qractive}" @click="clickqrorapp('qr')">
                                        <div class="qrdiv">
                                            <span class="fas fa-qrcode paymenttypefontsize"></span>
                                            <!-- <img :src="this.host+'/images/icons/qr.png'" class="qrimg"/> -->
                                            <div class="wallettextone">QR</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6" align="center">
                                    <div class="m-2" :class="{appactive:appactive}" @click="clickqrorapp('app')"
                                    v-if="this.walletpays != 'CB Pay'">
                                    <div class="qrdiv">
                                        <span class="fas fa-mobile-android-alt paymenttypefontsize"></span>
                                        <!-- <img :src="this.host+'/images/icons/app.png'" class="qrimg"/> -->
                                        <div class="wallettextone">App</div>
                                    </div>
                                    </div>
                                </div>

                                <input type="hidden" name="qrorapp" :value="this.qrorapp"
                                v-if="this.walletactive == true">
                                <input type="hidden" name="walletbankname" :value="this.walletpays"
                                v-if="this.walletactive == true">
                                <input type="hidden" name="walletormbank" value="wallet"
                                v-if="this.walletactive == true">
                                <input type="hidden" name="walletormbank" value="mbank" v-else>
                                <input type="hidden" name="orderid" :value="this.orderid">
                                <input type="hidden" name="_token" :value="this.csrf">

                            </div>


                        </div>
                        <div class="">
                            <div class="form-group mt-3">
                            <label for="name" class="selecttitle">Customer Name <span style="color:red">*</span> <span
                                v-if="this.nameerror =='error'" style="font-size:11px;color:red;">Required</span></label>
                            <input type="text" name="name" id="name" v-model="name" placeholder="Enter your name"
                            class="form-control inputstyle" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="phone" class="selecttitle">Phone Number<span style="color:red">*</span> <span
                                v-if="this.phoneerror =='error'" style="font-size:11px;color:red;">Required</span></label>
                                <input type="text" name="phone" id="phone" v-model="phone" placeholder="Enter your name"
                                class="form-control inputstyle" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="address" class="selecttitle">Full Address<span style="color:red">*</span> <span
                                v-if="this.nameerror =='error'" style="font-size:11px;color:red;">Required</span></label>
                                <input type="text" name="address" id="address" v-model="address" placeholder="Enter your Address"
                                class="form-control inputstyle" required>
                            </div>
                            
                            <div class="form-group mt-3 px-3 row">
                                <input type="button" @click="subform()" class="btn btnStyle col p-3" value="Continue to Payment"/>
                            </div>
                        </div>
                    </div>


                    <div class="col" style="padding-right: 0;">
                        <div class="orderdiv mt-2 p-0">
                            <h5 class="p-5">Your Order</h5>
                            <div class="row g-0 px-5">
                                <div class="col-6">Product</div>
                                <div class="col-6 text-end">Sub Total</div>
                            </div>

                            <div class="row g-0 px-5 py-4 align-items-center" style="border-bottom: 2px solid #0000000f;">
                                <div class="col-6 px-0">
                                    <div class="row align-items-center">
                                        <img :src="this.host+'/'+this.item.CheckPhoto" class="orderProductImg col-3" >
                                        <div class="col">
                                            {{ this.item.name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <div v-if="this.disitem != 'no'">
                                        <span
                                            v-if="this.disitem.discount_price != 0">{{
                                                this.disitem.discount_price
                                            }}</span>
                                        <span v-else>{{ this.disitem.discount_max }}</span>
                                    </div>
                                    <div v-else>
                                        <span v-if="this.item.price != 0">{{ this.item.price }}</span>
                                        <span v-else>{{ this.item.max_price }} </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 px-5 pb-4 g-0 align-items-center" style="border-bottom: 2px solid #0000000f;">
                                <div class="col-6">
                                    <div class="row align-items-center">
                                        <img :src="this.host+'/'+this.item.CheckPhoto" class="dingerImg col-2" > <!-- change dinger image here -->
                                        <div class="col">Transaction Fees By Dinger</div>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <span class="highlighttext">10%</span> + ({{ this.fee }})
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 px-5 pb-4 g-0 align-items-center highlighttext" style="border-bottom: 2px solid #0000000f;">
                                <div class="col-6">
                                    <div class="">
                                        TOTAL
                                    </div>

                                </div>
                                <div class="col-6 text-end highlighttext">
                                    <div v-if="this.disitem != 'no'">
                                        <span
                                            v-if="this.disitem.discount_price != 0">{{
                                                Number(this.fee) + Number(this.disitem.discount_price)
                                            }}</span>
                                        <span v-else>{{ Number(this.fee) + Number(this.disitem.discount_max) }}</span>
                                    </div>
                                    <div v-else>
                                        <span v-if="this.item.price != 0">{{ Number(this.fee) + Number(this.item.price) }}</span>
                                        <span v-else>{{Number(this.fee) + Number(this.item.max_price) }} </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row mt-4 px-3">
                            <input type="button" @click="subform()" class="btn btnStyle p-3" value="PayNow"/>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>


</template>

<script>
export default {
    props: ['item', 'orderid', 'csrf', 'disitem', 'fee'],
    name: "checkout",
    data: function () {
        return {
            qractive: true,
            appactive: false,
            qrorapp: 'QR',
            name: '',
            phone: '',
            address: '',
            nameerror:'',
            phoneerror:'',

            addresserror:'',
            host: '',
            walletactive: true,
            mobilebankactive: false,
            walletpays: 'KBZ Pay',
            // options: [
            //     {value: 'KBZ Pay', text: 'KBZ Pay'},
            //     {value: 'CB Pay', text: 'CB Pay'},
            //     {value: 'AYA Pay', text: 'AYA Pay'},
            // ]
            walletPay1Active: true,
            walletPay2Active: false,
            walletPay3Active: false,
        };
    },
    mounted() {
        this.host = this.$hostname;
    },
    methods: {
        subform: function () {
            if (this.name == '') {

                this.nameerror = 'error';
            }
            if (this.address == '') {
                this.addresserror = 'error';
            }
            if (this.phoneerror == '') {
                this.phoneerror = 'error';
            }

            if (this.name != '' && this.address != '') {
                this.$refs.form.submit();
            }

        },
        clickonwalletormbank: function (d) {
            if (d == 'wallet') {
                this.walletactive = true;
                this.mobilebankactive = false;

            } else {
                this.walletactive = false;
                this.mobilebankactive = true;
            }
        },

        clickqrorapp: function (d) {
            if (this.walletpays != 'CB Pay') {
                if (d == 'qr') {
                    this.qractive = true;
                    this.appactive = false;
                    this.qrorapp = 'QR';

                } else {
                    this.qrorapp = 'app';

                    this.qractive = false;
                    this.appactive = true;
                }
            }
        },

        banknamechange: function () {
            if (this.walletpays == 'CB Pay') {

                this.qractive = true;
                this.appactive = false;
                this.qrorapp = 'QR';
            }
        },

        chooseBank: function(d) {
            this.walletpays = d;
            if(d == 'KBZ Pay'){
                this.walletPay1Active = true;
                this.walletPay2Active = false;
                this.walletPay3Active = false;
            } else if (d == 'CB Pay') {
                this.walletPay1Active = false;
                this.walletPay2Active = true;
                this.walletPay3Active = false;
            } else {
                this.walletPay1Active = false;
                this.walletPay2Active = false;
                this.walletPay3Active = true;
            }
        },

    }

}
</script>

<style>
.orderdiv {
    border: 2px solid #0000000f;
    padding-top: 23px;
    padding-bottom: 13px;
    padding-left: 12px;
    padding-right: 12px;
    border-radius: 8px;
}

.highlighttext {
    color: #780116 !important;
    font-weight: bold;
}

.qractive {
    border: 2px solid #780116;
    border-radius: 8px;
}

.appactive {
    border: 2px solid #780116;
    border-radius: 8px;
}

.walletdiv {
    border: 2px solid #0000000f;
    padding-top: 23px;
    padding-bottom: 13px;
    padding-left: 22px;
    border-radius: 8px;
    -webkit-box-shadow: 0px 0px 10px 0px rgba(120,1,22,0.25); 
    box-shadow: 0px 0px 10px 0px rgba(120,1,22,0.25);
}

.qrfont {
    font-size: 42px;

}

.qrdiv {
    border: 2px solid #0000000f;
    padding: 10px;
    border-radius: 8px;
    height: max-content;
}

.qrimg{
    height: 30px;
}

.selecttitle {
    font-size: 22px;
}

.walletactive {
    border: 2px solid #780116 !important;
    background: #78011614 !important;
}

.walletactive .walletfontsize {
    color: #780116 !important;
}

.mobilebankactive {
    border: 2px solid #780116 !important;
    background: #78011614 !important;
}

.mobilebankactive .walletfontsize {
    color: #780116 !important;

}

.walletpadding {
    padding: 7px 20px 7px 20px;
}

.walletfontsize {
    font-size: 35px;
}

.paymenttypefontsize{
    font-size: 80px;
}

.wallettextone {
    font-size: 18px;
    font-weight: bold;
}

.wallettexttwo {
    font-weight: bold;
    color: #00000061;
}

.inputstyle {
    border-radius: 10px !important;
}

.inputstyle:focus {
    border: none !important;
    border: 2px solid #780116 !important;
}

.chooseBankDiv {
    border: 2px solid #0000000f;
    height: 80%;
    border-radius: 8px;
}

.bankImg {
    height: 100%;
    overflow: hidden;
}

.btnStyle {
    background-color: #780116 !important;
    color: white !important;
    border-radius: 8px;
}

.btnStyle:hover {
    background-color: #78011614 !important;
    border: 1px solid #780116 !important;
    color: #000000 !important;
    border-radius: 8px;
}

.btnStyle:active {
    background-color: #78011650 !important;
    color: black !important;
    border-radius: 8px;
}
</style>
