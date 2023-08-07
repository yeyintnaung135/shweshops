<template>
    <div class="mx-4 px-md-5">
        <div class="text-center my-3 products default">
            <h1 style="font-family: sans-serif !important">{{ header }}</h1>
        </div>

        <div
            class="row g-3 justify-content-center"
            v-if="Object.keys(localData).length != 0"
        >
            <div
                class="col-12 col-md-8 col-lg-6 col-xxl-4"
                v-for="(item, index) in this.localData"
                :key="index"
            >
                <div class="sop-border d-flex flex-warp">
                    <div class="col-5 h-100">
                        <div
                            class="images post-img sop-img sop-font ftc-product product"
                            :data-src="imgurl + item.CheckPhoto"
                            data-fancybox="group"
                        >
                            <div v-if="item.YkgetDiscount != ''">
                                <div class="sop-ribbon">
                                    <span>
                                        -{{ item.YkgetDiscount.percent }}%
                                    </span>
                                </div>
                            </div>
                            <span class="fa fa-user yk-viewcount">
                                {{ item.YkView }}
                            </span>

                            <img
                                v-lazy="imgurl + item.CheckPhoto"
                                class="sop-atc-img"
                            />
                        </div>
                    </div>
                    <div
                        class="col-7 h-100 addtocart-p d-flex flex-column justify-content-between"
                    >
                        <div class="d-flex flex-warp">
                            <div class="col-10">
                                <div class="mmprice">
                                    <a
                                        :href="
                                            host +
                                            '/' +
                                            item.ShopName.shop_name +
                                            '/product_detail/' +
                                            item.id
                                        "
                                    >
                                        <div v-html="item.MmPrice"></div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-2 d-flex justify-content-end">
                                <div
                                    class="sop-btn"
                                    @click="deleteCardFunction(index)"
                                >
                                    <i
                                        class="fas fa-times"
                                        style="color: #780116"
                                    ></i>
                                </div>
                            </div>
                        </div>
                        <div class="category_id pt-1">
                            <a
                                :href="
                                    host +
                                    '/see_by_categories/' +
                                    item.category_id
                                "
                            >
                                {{ item.category_id }}
                            </a>
                        </div>
                        <div class="product_code">
                            Code:
                            <a
                                :href="
                                    host +
                                    '/' +
                                    item.ShopName.shop_name +
                                    '/product_detail/' +
                                    item.id
                                "
                            ><span>{{ item.product_code }}</span>
                            </a>
                        </div>
                        <div class="ShopName">

                            <a :href="host + '/' + item.WithoutspaceShopname"

                            >by
                                <span>{{ item.ShopName.shop_name }}</span></a
                            >
                        </div>
                        <div class="d-flex flex-warp align-items-end">
                            <div class="col-7">
                                <div
                                    class="h-100 detail d-flex align-items-end"
                                >
                                    <a
                                        :href="
                                            host +
                                            '/' +
                                            item.ShopName.shop_name +
                                            '/product_detail/' +
                                            item.id
                                        "
                                        style="margin-bottom: 10px"
                                    >
                                        အသေးစိတ်ကြည့်မယ်
                                    </a>
                                </div>
                            </div>
                            <div
                                class="h-100 col-5 d-flex flex-row justify-content-end"
                            >
                                <!-- <a
                                    v-if="
                                        item.ShopName.ConnectedwithFacebook ==
                                        'yes'
                                    "
                                    :href="
                                        item.ShopName.Ykmessengerlink +
                                        '?ref=' +
                                        item.id
                                    "
                                    class="btn sop-buynow-button"
                                    >ဝယ်မယ်</a
                                >
                                <a
                                    v-else
                                    :href="item.ShopName.Ykmessengerlink"
                                    class="btn sop-buynow-button"
                                    >ဝယ်မယ်</a
                                > -->
                                <a
                                    class="btn btn-primary atc-buynow-button sop-font reg"
                                    @click="
                                        buynowbuttonclick(
                                            item.id
                                        )
                                    "
                                    id="buynowbutton"
                                    target="_blank"
                                    style=""
                                >ဝယ်မယ်</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            v-else
            class="d-flex flex-column justify-content-center align-items-center"
            style="height: 50vh"
        >
            <h2 class="text-center">ရွေးထားတာလေးတွေတော့ မရှိသေးပါဘူးနော်</h2>
            <p class="sop-p">ပစ္စည်းလေးတွေကြည့် ကြမလား</p>
            <a
                :href="host + '/see_by_categories'"
                class="btn btn-primary sn-buynow-button"
            >ပစ္စည်းလေးတွေကြည့် ကြမယ်</a
            >
        </div>
    </div>
</template>
<script>
import Vue from "vue";
import VueLazyload from "vue-lazyload";
import app from "../../app";

Vue.use(VueLazyload, {
    preLoad: 1.3,
    error: "dist/error.png",
    loading: "test/KSYL.gif",
    attempt: 1,
});

export default {
    props: [
        "localkey",
        "headertext",
        "userid",
        "usertype",
        "checkauth",
        "name",
        "fordate",
    ],

    data: function () {
        return {
            header: "",
            hostname: "",
            localData: [],
            host: "",
            isDeleted: false,

            SyncID: "",
            id: "",
            imgurl:'',
        };
    },
    mounted() {
        this.getDataFromLocal();
        this.host = this.$hostname;
        this.userid != null ? (this.id = this.userid.id) : (this.id = "");
        this.header = this.headertext;
        if (process.env.MIX_USE_DO == "true") {
      this.imgurl = process.env.MIX_DO_URL;
    } else {
      this.imgurl = this.$hostname;
    }
    },
    filters: {
        strlimit: function (str, limit, other) {
            if (str.length > limit) {
                let shortstring = str.substring(0, limit) + other;
                return shortstring;
            } else {
                return str;
            }
        },
    },

    methods: {
        getitemdata:function(id){
            return new Promise(resolve=>{
                axios.post(this.host+'/getitemdata', {'itemid':id},
                    {
                    })
                    .then(async (response) => {
                        resolve(response);
                    });
            });
        },
        buynowbuttonclick: async function (itemid) {

            //get itemdat by id
            const itemdata=await this.getitemdata(itemid);
            //get itemdat by id

            //set data to LS because if use is not logined user will login login form is made with Form this can be redirect
            // localStorage.removeItem('foraddtocartitems');
            // localStorage.removeItem('datenow');


            if(this.checkauth != 1){


              localStorage.setItem('foraddtocartitems',JSON.stringify(itemdata));
              localStorage.setItem('datenow',this.fordate);
          }



            //set data to LS because if use is not logined user will login login form is made with Form this can be redirect


            console.log('localStorage in vue', localStorage.getItem('foraddtocartitems'))

            this.$root.buynowbuttonclick(
                this.checkauth,
                itemdata.data.ShopName.id,
                itemdata.data,
                "post",
                this.userid ? this.userid.username : "",
                itemdata.data.ShopName,
                this.fordate
            );
        },
        getDataFromLocal: function () {
            const data = JSON.parse(
                window.localStorage.getItem(this.localkey) || "{}"
            );
            this.localData = data;
            console.log("local data", this.localData);
        },
        deleteCardFunction: function (index) {
            this.isDeleted = index;

            this.$delete(this.localData, this.isDeleted);

            localStorage.setItem(this.localkey, JSON.stringify(this.localData));

            this.SyncID = Object.keys(
                JSON.parse(window.localStorage.getItem(this.localkey))
            );

            if (this.localkey == "selection") {
                document.getElementById("temp").innerHTML =
                    parseInt(document.getElementById("temp").innerHTML) - 1;
                document.getElementById("navw-a2c-count").innerHTML =
                    parseInt(document.getElementById("navw-a2c-count").innerHTML) - 1;

                const updateSelection = JSON.parse(
                    window.localStorage.getItem("selection") || "{}"
                );
                if (Object.keys(updateSelection).length == 0) {
                    if ($("#mobile-a2c-icon").hasClass("op-100")) {
                        $("#mobile-a2c-icon")
                            .removeClass("op-100")
                            .addClass("op-50");
                    }
                }

                if (this.id != "") {
                    localStorage.setItem(
                        "selectionID",
                        JSON.stringify(this.SyncID)
                    );
                    this.SyncID = JSON.parse(
                        window.localStorage.getItem("selectionID")
                    );
                    $.ajax({
                        url: "/addtocart/update",
                        type: "post",
                        data: {
                            users: this.usertype,
                            newSelection: this.SyncID,
                            id: userID.id,
                            _token: _token,
                        },
                        success: function (response) {
                            console.log("synced", response);
                        },
                        error: function (error) {
                            console.log(error);
                        },
                    });
                }
            }
            else {
                var favourited = JSON.parse(window.localStorage.getItem("fav"));

                if (Object.keys(favourited).length == 0) {
                    $("#mobileFootHeart").toggleClass("fa-regular fa-solid");
                    this.$forceUpdate();
                }
                // document.getElementById("favw-a2c-count").innerHTML =
                //     parseInt(
                //         document.getElementById("favw-a2c-count").innerHTML
                //     ) - 1;
                // document.getElementById("favm-a2c-count").innerHTML =
                //     parseInt(
                //         document.getElementById("favm-a2c-count").innerHTML
                //     ) - 1;

                if (this.id != "") {
                    localStorage.setItem("favID", JSON.stringify(this.SyncID));
                    this.SyncID = JSON.parse(
                        window.localStorage.getItem("favID")
                    );
                    console.log("SyncIDfav", this.SyncID);
                    $.ajax({
                        url: "/myfav/update",
                        type: "post",
                        data: {
                            users: this.usertype,
                            newFav: this.SyncID,
                            id: userID.id,
                            _token: _token,
                        },
                        success: function (response) {
                            console.log("synced");
                        },
                        error: function (error) {
                            console.log(error);
                        },
                    });
                }
            }

            //had to force it which is not recommended way, delete below if there is better way
            // this.$forceUpdate();
        },
    },
};
</script>
<style scoped>
.category_id a {
    color: #780116 !important;
}

.category_id {
    text-transform: capitalize;
}

.sop-btn {
    cursor: pointer;
    margin-top: -10px;
    margin-right: -5px;
}

.ShopName span {
    color: #780116;
}

.product_code span {
    color: #780116;
}

.detail {
    text-decoration: underline;
}

.sop-border {
    border: solid 1px #cfcfcf;
    border-radius: 5px;
}

.sop-buynow-button {
    background: #780116 !important;
    border-radius: 5px !important;
    border-color: #780116 !important;
    width: 80% !important;
    margin-bottom: 10px;
    color: #fff !important;
    /* font-size: 18px !important; */
    padding: 7px 0 !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
    Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
    font-weight: 500 !important;
}

.sop-buynow-button:hover {
    background: #780117d8 !important;
}
.atc-buynow-button {
    /* zh-modify */
    background: #780116 !important;
    border-radius: 5px !important;
    border-color: #780116 !important;

    margin: 0px auto 0;
    color: rgb(255, 255, 255) !important;
    font-size: 16px !important;
    padding: 7px 20px !important;
    /*font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;*/
    font-weight: 500 !important;
}

.atc-buynow-button:hover {
    background: #a90220 !important;
}
.sop-p {
    padding-top: 20px;
    font-size: 1.2em;
    color: #7c7c7c;
}

@media only screen and (max-width: 576px) {
    
    .mmprice {
        font-size: 1.2em;
    }

    .category_id {
        text-transform: capitalize;
        font-size: 0.8em;
    }

    .product_code {
        font-size: 0.8em;
    }

    .detail {
        font-size: 0.7em;
    }

    .ShopName {
        font-size: 0.8em;
    }

    .sop-buynow-button {
        font-size: 0.8em;
    }

    .addtocart-p {
        padding: 8px;
    }

    .sop-border {
        min-height: 160px;
        height: 100%;
    }

    .sop-atc-img {
        width: 100%;
        height: 158px;
        object-fit: cover;
    }
    .atc-buynow-button{
      padding: 3px 10px !important;
    }
}

@media only screen and (min-width: 576px) {
    .mmprice {
        font-size: 1.4em;
    }

    .category_id {
        text-transform: capitalize;
        font-size: 0.9em;
    }

    .product_code {
        font-size: 0.9em;
    }

    .detail {
        font-size: 0.8em;
    }

    .ShopName {
        font-size: 0.9em;
    }

    .sop-buynow-button {
        font-size: 0.9em;
    }

    .addtocart-p {
        padding: 16px;
    }

    .sop-border {
        min-height: 180px;
        height: 100%;
    }

    .sop-atc-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

}

</style>
