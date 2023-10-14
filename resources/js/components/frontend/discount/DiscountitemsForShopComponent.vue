<template>
    <div class="site-content">
        <div
            class="products default loading row g-2 g-md-3"
            style="padding-bottom: 12px"
        >
            <div
                class="col-6 col-sm-4 col-md-3 col-lg-2 yk-fade"
                v-for="d in this.discountdata"
                :key="d.id"
            >
                <div
                    class="ftc-product product mb-2"
                    style="box-shadow: none !important"
                >
                    <a
                        :href="
                            host +
                            '/' +
                            d.WithoutspaceShopname +
                            '/product_detail/' +
                            d.id
                        "
                    >
                        <div class="sop-ribbon">
                            <span>-{{ d.YkgetDiscount.percent }}%</span>
                        </div>
                    </a>
                    <div class="post-img sop-img">
                        <a
                            style="color: #ffe775 !important"
                            :href="
                                host + '/shop_detail/' + d.WithoutspaceShopname
                            "
                        >
                            <div
                                class="yk-hover-title sop-rounded-top text-capitalize text-left g-0"
                                style="width: 100% !important"
                            >
                                <img
                                    :src="
                                        imgurl +
                                        '/shop_owner/logo/thumbs/' +
                                        d.ShopName.shop_logo
                                    "
                                    class="yk-hover-logo float-left"
                                />
                                <span>
                                    {{
                                        d.ShopName.shop_name
                                            | strlimit(15, "..")
                                    }}</span
                                >
                            </div>
                        </a>
                        <span class="fa fa-user yk-viewcount">
                            <!--                                                 //you want to use yk_view from laravel eloquent but in vue you must write camelcase-->
                            {{ d.YkView }}
                        </span>
                        <a
                            :href="
                                host +
                                '/' +
                                d.WithoutspaceShopname +
                                '/product_detail/' +
                                d.id
                            "
                        >
                            <div v-lazy-container="{ selector: 'img' }">
                                <img
                                    :data-src="imgurl + d.CheckPhoto"
                                    :data-loading="imgurl + d.CheckPhotothumbs"
                                    class="sop-image-w-h"
                                    lazy="loading"
                                />
                            </div>
                        </a>
                    </div>
                    <p style="color:#222 text-align:left;" class="my-2">
                        {{ d.name }}
                    </p>
                    <div class="item-description">
                        <!--                                                 <span class="zh-shop_name">-->
                        <!--                                                     {{item.ShopName.shop_name | strlimit(15,'..')}}-->
                        <!--                                                </span>-->

                        <span class="price">
                            <span
                                class="woocommerce-Price-amount amount sop-amount"
                            >
                                <bdi v-html="d.MmPrice"> </bdi>
                            </span>
                        </span>

                        <!--                        <h3 class="product_title product-name"><a-->
                        <!--                            :href="host+'/product_detail/'+item.id">{{ item.ShopName.shop_name | strlimit(12,'...') }}</a>-->
                        <!--                        </h3>-->
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center fa-3x mb-3 sop-sans">
                <button
                    v-if="this.clickloadmorecount < 5"
                    id=""
                    class="btn btn-danger zh-button"
                    @click="loadmoreclick($event)"
                >
                    <span
                        class="fa fa-spinner"
                        v-bind:class="{ 'fa-spin': togglespin }"
                    ></span>
                    View More
                </button>
                <div v-else>
                    <a
                        style="color: white !important"
                        :href="this.host + '/see_all_discount/' + this.shopid"
                        v-if="this.shopid == 'all'"
                        class="btn btn-danger zh-button"
                    >
                        <span class="fa fa-arrow-circle-right"></span>
                        See All
                    </a>
                    <a
                        style="color: white !important"
                        :href="
                            this.host +
                            '/see_all_discount_for_shop/' +
                            this.shopid
                        "
                        v-else
                        class="btn btn-danger zh-button"
                    >
                        <span class="fa fa-arrow-circle-right"></span>
                        See All
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import VueLazyload from "vue-lazyload";
import Vue from "vue";
Vue.use(VueLazyload, {
    preLoad: 1.3,

    attempt: 1,
});

export default {
    props: ["discountitems", "shop_id"],
    name: "DiscountitemsComponent",
    data: function () {
        return {
            shopid: "all",
            emptyonserver: 0,
            togglespin: false,
            discountdata: "",
            clickloadmorecount: 0,
            popdata: "",
            host: "",
            latestviewcount: "",
            limit: 0,
            imgurl: "",
        };
    },

    mounted() {
        this.host = this.$hostname;
        if (process.env.MIX_USE_DO == "true") {
            this.imgurl = process.env.MIX_DO_URL;
        } else {
            this.imgurl = this.$hostname + "/images";
        }
        if (this.shop_id != undefined) {
            this.shopid = this.shop_id;
        }

        console.log("this is discount ffffffffffff  ");
        console.log(this.discountitems);
        this.discountdata = this.discountitems;
        if (this.discountdata.length < 12) {
            this.clickloadmorecount = 10;
        }
        this.limit = 12;

        console.log(this.discountdata);
    },

    computed: {},
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
        loadmoreclick(e) {
            e.preventDefault();

            if (this.togglespin) {
                this.togglespin = false;
            } else {
                this.togglespin = true;
            }
            axios
                .get(
                    this.host +
                        "/get_discount_ajax/" +
                        this.limit +
                        "/" +
                        this.shopid
                )
                .then((response) => {
                    console.log(response.statusText);
                    if (response.statusText == "OK") {
                        setTimeout(() => {
                            this.togglespin = false;
                            // this.newdata.concat([{'test':'ff'}]);

                            response.data[0].map((d) => {
                                this.discountdata.push(d);
                            });

                            if (response.data[3] == 0) {
                                this.clickloadmorecount = 10;
                            } else {
                                this.clickloadmorecount += 1;
                                this.limit += 20;
                            }
                        }, 500);

                        console.log(response.data.length);
                    }
                });
        },
    },
};
</script>

<style>
img[lazy="loading"] {
    /*your style here*/
    width: 200px !important;
}
.yk-fade {
    -webkit-animation: fade 2s;
    -moz-animation: fade 2s;
    -o-animation: fade 2s;
    -ms-transition: fade 2s;
    animation: fade 2s;
}
@keyframes fade {
    0% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}
</style>
