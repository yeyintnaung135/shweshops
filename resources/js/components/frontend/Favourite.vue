<template>
    <div class="mx-4 px-md-5">
        <div
            v-if="this.busy"
            class="yk-wrapper fff"
            style="
                position: relative !important;
                margin-top: 36px;
                height: 560px;
            "
        >
            <div class="ct-spinner5">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <div v-else>
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
                                :data-src="imgurl + item.CheckPhotobig"
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

                                <div v-lazy-container="{ selector: 'img' }">
                                    <img
                                        :data-src="imgurl + item.CheckPhoto"
                                        :data-loading="
                                            imgurl + item.CheckPhotothumbs
                                        "
                                        class="sop-image-w-h"
                                        lazy="loading"
                                    />
                                </div>
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
                                        @click="deletefav(item.id)"
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
                                <a
                                    :href="
                                        host + '/' + item.WithoutspaceShopname
                                    "
                                    >by
                                    <span>{{
                                        item.ShopName.shop_name
                                    }}</span></a
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
                                    <a
                                        class="btn btn-primary atc-buynow-button sop-font reg"
                                        @click="buynowbuttonclick(item.id)"
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
                <h2 class="text-center">
                    ရွေးထားတာလေးတွေတော့ မရှိသေးပါဘူးနော်
                </h2>
                <p class="sop-p">ပစ္စည်းလေးတွေကြည့် ကြမလား</p>
                <a
                    :href="host + '/see_by_categories'"
                    class="btn btn-primary sn-buynow-button"
                    >ပစ္စည်းလေးတွေကြည့် ကြမယ်</a
                >
            </div>
        </div>
    </div>
</template>
<script>
import VueLazyload from "vue-lazyload";
import Vue from "vue";
import { allservicesfromfavourite } from "./services/favorite";
Vue.use(VueLazyload);

export default {
    props: ["localkey", "headertext", "checkauth", "fordate", "checkloginnow"],
    name: "my-favourite",

    data: function () {
        return {
            header: "",
            hostname: "",
            localData: [],
            host: "",
            isDeleted: false,
            SyncID: "",
            id: "",
            imgurl: "",
            uri: "",
            busy: false,
        };
    },
    async mounted() {
        this.getDataFromLocal();
        this.busy = true;
        this.host = this.$hostname;
        this.header = this.headertext;
        if (process.env.MIX_USE_DO == "true") {
            this.imgurl = process.env.MIX_DO_URL;
        } else {
            this.imgurl = this.$hostname + "/images";
        }
        if (this.checkloginnow) {
            const tmpupfav =
                await this.upload_fav_localstorage_to_server_after_logined();
            this.busy = false;
        }

        this.getfav_or_addtocarddata();
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
        getitemdata: function (id) {
            return new Promise((resolve) => {
                axios
                    .post(this.host + "/getitemdata", { itemid: id }, {})
                    .then(async (response) => {
                        resolve(response);
                    });
            });
        },

        deletefav: function (itemid) {
            console.log("delete");
            allservicesfromfavourite.start_process(itemid, this);
        },
        buynowbuttonclick: async function (itemid) {
            //get itemdat by id
            const itemdata = await this.getitemdata(itemid);
            //get itemdat by id

            //set data to LS because if use is not logined user will login login form is made with Form this can be redirect
            // localStorage.removeItem('foraddtocartitems');
            // localStorage.removeItem('datenow');

            if (this.checkauth != 1) {
                localStorage.setItem(
                    "foraddtocartitems",
                    JSON.stringify(itemdata)
                );
                localStorage.setItem("datenow", this.fordate);
            }

            //set data to LS because if use is not logined user will login login form is made with Form this can be redirect

            console.log(
                "localStorage in vue",
                localStorage.getItem("foraddtocartitems")
            );

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
        upload_fav_localstorage_to_server_after_logined: function () {
            if (
                typeof localStorage.getItem("favourite") !== "undefined" &&
                localStorage.getItem("favourite") !== "null"
            ) {
                var tmp_rm = "[]";
                if (
                    localStorage.getItem("favourite_rm") !== "undefined" &&
                    localStorage.getItem("favourite_rm") !== "null"
                ) {
                    var tmp_rm = localStorage.getItem("favourite_rm");
                }
                return new Promise((resolve, reject) => {
                    axios
                        .post(this.host + "/myfav/upload_after_logined", {
                            fav_ids: localStorage.getItem("favourite"),
                            fav_rm_ids: tmp_rm,
                        })
                        .then((response) => {
                            if (response.data.success) {
                                localStorage.setItem(
                                    "favourite",
                                    JSON.stringify(response.data.data)
                                );
                                localStorage.setItem("favourite" + "_rm", "[]");
                            }
                            resolve(response);
                        });
                });
            }
        },
        getfav_or_addtocarddata: async function () {
            if (!this.checkauth) {
                let localdata_fav_keys = this.getDataFromLocal();
                let getallfavlist = await this.get_fav_items_data(
                    localdata_fav_keys
                );
                this.busy = false;

                if (getallfavlist.data.success) {
                    this.localData = getallfavlist.data.data;
                }
            } else {
                let getallfavlist_forauthuser =
                    await this.get_fav_items_data_authuser();
                this.busy = false;

                if (getallfavlist_forauthuser.data.success) {
                    this.localData = getallfavlist_forauthuser.data.data;
                }
            }

            console.log("auth check", this.checkauth);
        },
        get_fav_items_data: function (fav_ids) {
            return new Promise((resolve) => {
                axios
                    .post(this.host + "/myfav/get_fav_items_data", {
                        fav_ids: fav_ids,
                    })
                    .then(async (response) => {
                        resolve(response);
                    });
            });
        },
        get_fav_items_data_authuser: function (fav_ids) {
            return new Promise((resolve) => {
                axios
                    .post(this.host + "/myfav/get_fav_items_data_authuser", {})
                    .then(async (response) => {
                        resolve(response);
                    });
            });
        },
        getDataFromLocal: function () {
            const data = JSON.parse(
                window.localStorage.getItem("favourite") || "{}"
            );
            return data;
        },
    },
};
</script>
<style scoped>
.category_id a {
    color: #780116 !important;
}
.item_img {
    width: 200px !important;
    height: 100px !important;
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
    .atc-buynow-button {
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
