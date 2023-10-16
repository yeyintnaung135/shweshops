<template>
    <div class="site-content">
        <div
            v-if="isscrollon == 'on'"
            v-infinite-scroll="loadPopularItemsMore"
            infinite-scroll-disabled="busy"
            infinite-scroll-distance="140"
        >
            <div
                class="products default loading row g-2 g-md-3"
                style="padding-bottom: 12px"
            >
                <div
                    class="col-6 col-sm-4 col-md-3 col-lg-2 yk-fade"
                    v-for="(item, index) in this.popdata"
                    :key="index"
                >
                    <div
                        class="ftc-product product mb-2"
                        style="box-shadow: none !important"
                    >
                        <div class="post-img sop-img">
                            <a
                                style="color: #ffe775 !important"
                                :href="host + '/' + item.WithoutspaceShopname"
                            >
                                <div
                                    class="yk-hover-title sop-rounded-top text-capitalize text-left g-0"
                                    style="width: 100% !important"
                                >
                                    <img
                                    :src="imgurl + '/shop_owner/logo/thumbs/' + item.ShopName.shop_logo"

                                        class="yk-hover-logo float-left"
                                    />
                                    <span>
                                        {{
                                            item.ShopName.shop_name
                                                | strlimit(15, "..")
                                        }}</span
                                    >
                                </div>
                            </a>
                            <span class="fa fa-user yk-viewcount">
                                <!--                                                 //you want to use yk_view from laravel eloquent but in vue you must write camelcase-->
                                {{ item.YkView }}
                            </span>
                            <a
                                :href="
                                    host +
                                    '/' +
                                    item.WithoutspaceShopname +
                                    '/product_detail/' +
                                    item.id
                                "
                            >
                                <div v-lazy-container="{ selector: 'img' }">
                                    <img
                                    :data-src="imgurl + item.CheckPhotobig"
                                        :data-loading="
                                            imgurl + item.CheckPhotothumbs
                                        "
                                        class="sop-image-w-h"
                                        lazy="loading"
                                    />
                                </div>
                            </a>
                        </div>
                        <div class="item-description">
                            <!--                                                 <span class="zh-shop_name">-->
                            <!--                                                     {{item.ShopName.shop_name | strlimit(15,'..')}}-->
                            <!--                                                </span>-->

                            <span class="price">
                                <span
                                    class="woocommerce-Price-amount amount sop-amount"
                                >
                                    <bdi
                                        v-if="item.price == 0"
                                        v-html="item.MmPrice"
                                    >
                                    </bdi>
                                    <bdi v-else v-html="item.MmPrice"> </bdi>
                                </span>
                            </span>

                            <h3 class="product_title product-name">
                                <a
                                    :href="
                                        host +
                                        '/' +
                                        item.WithoutspaceShopname +
                                        '/product_detail/' +
                                        item.id
                                    "
                                    >{{ item.name | strlimit(12, "...") }}</a
                                >
                            </h3>
                            <!--                        <h3 class="product_title product-name"><a-->
                            <!--                            :href="host+'/product_detail/'+item.id">{{ item.ShopName.shop_name | strlimit(12,'...') }}</a>-->
                            <!--                        </h3>-->
                        </div>
                    </div>
                </div>
                <div
                    v-if="this.emptyonserverpop === 0"
                    class="col-12"
                    style="height: 222px !important"
                >
                    <div
                        class="yk-wrapper fff"
                        style="position: relative !important; margin-top: 56px"
                    >
                        <div class="ct-spinner5">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else>
            <div
                class="products default loading row g-2 g-md-3"
                style="padding-bottom: 12px"
            >
                <div
                    class="col-6 col-sm-4 col-md-3 col-lg-2 yk-fade"
                    v-for="(item, index) in this.popdata"
                    :key="index"
                >
                    <div
                        class="ftc-product product mb-2"
                        style="box-shadow: none !important"
                    >
                        <div class="post-img sop-img">
                            <a
                                style="color: #ffe775 !important"
                                :href="host + '/' + item.WithoutspaceShopname"
                            >
                                <div
                                    class="yk-hover-title sop-rounded-top text-capitalize text-left g-0"
                                    style="width: 100% !important"
                                >
                                    <img
                                        v-lazy="
                                            host +
                                            '/images/logo/thumbs/' +
                                            item.ShopName.shop_logo
                                        "
                                        class="yk-hover-logo float-left"
                                    />
                                    <span>
                                        {{
                                            item.ShopName.shop_name
                                                | strlimit(15, "..")
                                        }}</span
                                    >
                                </div>
                            </a>
                            <span class="fa fa-user yk-viewcount">
                                <!--                                                 //you want to use yk_view from laravel eloquent but in vue you must write camelcase-->
                                {{ item.YkView }}
                            </span>
                            <a
                                :href="
                                    host +
                                    '/' +
                                    item.WithoutspaceShopname +
                                    '/product_detail/' +
                                    item.id
                                "
                            >
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
                            </a>
                        </div>
                        <div class="item-description">
                            <span class="price">
                                <span
                                    class="woocommerce-Price-amount amount sop-amount"
                                >
                                    <bdi
                                        v-if="item.price == 0"
                                        v-html="item.MmPrice"
                                    >
                                    </bdi>
                                    <bdi v-else v-html="item.MmPrice"> </bdi>
                                </span>
                            </span>

                            <h3 class="product_title product-name">
                                <a
                                    :href="
                                        host +
                                        '/' +
                                        item.WithoutspaceShopname +
                                        '/product_detail/' +
                                        item.id
                                    "
                                    >{{ item.name | strlimit(12, "...") }}</a
                                >
                            </h3>
                            <!--                        <h3 class="product_title product-name"><a-->
                            <!--                            :href="host+'/product_detail/'+item.id">{{ item.ShopName.shop_name | strlimit(12,'...') }}</a>-->
                            <!--                        </h3>-->
                        </div>
                    </div>
                </div>
                <div
                    v-if="this.emptyonserverpop === 0"
                    class="col-12"
                    style="height: 222px !important"
                >
                    <div
                        class="yk-wrapper fff"
                        style="position: relative !important; margin-top: 56px"
                    >
                        <div class="ct-spinner5">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import VueLazyload from "vue-lazyload";
import Vue from "vue";
Vue.use(VueLazyload);

export default {
    props: ["popitems", "poplimit", "poplatest", "isscrollon"],
    name: "PopitemsComponent",
    data: function () {
        return {
            imgurl: "",

            emptyonserver: 0,
            emptyonserverpop: 0,
            // togglespin: false,
            // clickloadmorecount: 0,
            popdata: [],
            hostname: "",
            host: "",
            // latestviewcount: "",
            popularlatest: true,
            popularlimit: 0,
            busy: false,
        };
    },

    mounted() {
        this.host = this.$hostname;
        if (process.env.MIX_USE_DO == "true") {
            this.imgurl = process.env.MIX_DO_URL;
        } else {
            this.imgurl = this.$hostname + "/images";
        }
        this.popularlatest = this.poplatest;
        this.popularlimit = this.poplimit;
        this.loadPopularItemsMore();
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
    computed: {},

    methods: {
        loadPopularItemsMore() {
            this.busy = true;

            axios
                .get(
                    this.host +
                        "/get_popitems_ajax/" +
                        this.popularlatest +
                        "/" +
                        this.popularlimit
                )
                .then((response) => {
                    if (response.statusText == "OK") {
                        setTimeout(() => {
                            let setemptyonserver = (e) => {
                                if (e == 1 && this.popularlatest == false) {
                                    this.emptyonserver = e;
                                    this.emptyonserverpop = e;
                                    this.busy = true;
                                } else if (e == 1) {
                                    this.emptyonserver = 0;
                                    this.popularlimit = 0;
                                    this.busy = false;
                                    this.popularlatest = !this.popularlatest;
                                    // this.loadMore();
                                } else {
                                    this.emptyonserver = e;
                                    this.popularlimit += response.data[1];
                                    // console.log("limit update", this.limit);
                                }
                            };

                            let setfilterdata = (data) => {
                                data.map((d) => {
                                    this.popdata.push(d);
                                });
                            };

                            let setbusy = () => {
                                if (
                                    this.emptyonserver == 1 &&
                                    this.popularlatest == false
                                ) {
                                    this.busy = true;
                                } else {
                                    this.busy = false;
                                }
                            };

                            async function tosetdata() {
                                await setemptyonserver(response.data[2]);
                                await setfilterdata(response.data[0]);
                                await setbusy();
                            }
                            tosetdata();
                            if (this.isscrollon != "on") {
                                this.emptyonserverpop = 1;
                            }
                            this.$emit("forparentfrompop", {
                                poplimit: this.popularlimit,
                                poplatest: this.popularlatest,
                            });
                        }, 10);

                        // console.log("Popular Items response data", response.data[1]);
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
