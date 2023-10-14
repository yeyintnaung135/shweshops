<template>
    <div class="site-content">
        <div
            v-infinite-scroll="loadNewItemsMore"
            infinite-scroll-disabled="busy"
            infinite-scroll-distance="340"
        >
            <!-- <div> -->
            <div
                class="products default loading row g-2 g-md-3"
                style="padding-bottom: 12px"
            >
                <div
                    class="col-6 col-sm-4 col-md-3 col-lg-2 yk-fade"
                    v-lazy-container="{ selector: 'div' }"
                    v-for="item in this.newdata"
                    :key="item.key"
                >
                    <div
                        class="ftc-product product mb-2"
                        style="
                            padding-top: 0px !important;
                            box-shadow: none !important;
                        "
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
                            <!--                                             <span class="zh-shop_name">-->
                            <!--                                                {{ item.ShopName.shop_name | strlimit(15,'..') }}-->
                            <!--                                            </span>-->
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
                    v-if="this.emptyonservernew === 0"
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

                <!-- <button @click="loadNewItemsMore()">Load More</button> -->

                <!-- modify zh -->

                <!-- <div class="d-flex justify-content-center fa-3x mb-3 sop-sans">
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

                <a
                    style="color: white !important"
                    v-else-if="this.uri == 'get_newitems_ajax'"
                    :href="this.host + '/see_all_new'"
                    class="btn btn-danger zh-button"
                    @click="test"
                >
                    <span class="fa fa-arrow-circle-right"></span>
                    See All
                </a>
                <a
                    style="color: white !important"
                    v-else
                    :href="
                        this.host +
                        '/see_all_new_for_shop/' +
                        this.newdata[0].shop_id
                    "
                    class="btn btn-danger zh-button"
                    @click="test"
                >
                    <span class="fa fa-arrow-circle-right"></span>

                    See All
                </a>
            </div> -->
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
    props: [
        "newitems",
        "current_shop_count",
        "newlimit",
        "newlatest",
        "isscrollon",
    ],
    name: "NewitemsComponent",
    data: function () {
        return {
            imgurl: "",
            hostname: "",
            test: "",
            emptyonserver: 0,
            emptyonservernew: 0,
            clickloadmorecount: 0,
            current_shop_limit: 0,
            newdata: "",
            host: "",
            newitemlatest: true,
            newitemlimit: 0,
            busy: false,
        };
    },

    mounted() {
        if (this.isscrollon != "on") {
            this.busy = true;
            this.emptyonservernew = 1;
        }
        this.host = this.$hostname;
        if (process.env.MIX_USE_DO == "true") {
            this.imgurl = process.env.MIX_DO_URL;
        } else {
            this.imgurl = this.$hostname + "/images";
        }
        this.newdata = this.newitems;
        console.log(this.current_shop_count);
        this.current_shop_limit = this.current_shop_count;
        this.newitemlatest = this.newlatest;
        this.newitemlimit = this.newlimit;
        this.latestid = this.newdata[this.newdata.length - 1].id;
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
        loadNewItemsMore() {
            this.busy = true;

            axios
                .post(
                    this.host + "/get_newitems_ajax",
                    {
                        filtertype: {
                            item_limit: this.newitemlimit,
                            latest: this.newitemlatest,
                            shop_limit: this.current_shop_limit,
                        },
                    },
                    {
                        header: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                )
                .then((response) => {
                    console.log(response.data);
                    if (response.statusText == "OK") {
                        setTimeout(() => {
                            let setemptyonserver = (
                                itemsemptyonserver,
                                shopsempty
                            ) => {
                                if (
                                    itemsemptyonserver == 1 &&
                                    this.newitemlatest === true
                                ) {
                                    // empty products for recent 2 months
                                    this.current_shop_limit = 0;
                                    this.newitemlimit = 0;
                                    this.newitemlatest = false;
                                    this.emptyonserver = 0;
                                } else if (
                                    itemsemptyonserver == 0 &&
                                    shopsempty == 1 &&
                                    this.newitemlatest === true
                                ) {
                                    // there are more products on server but shop list empty (have to restart shop list) for recent 2 months
                                    this.current_shop_limit = 0;
                                    this.newitemlimit += 4;
                                } else if (
                                    itemsemptyonserver == 0 &&
                                    shopsempty == 0 &&
                                    this.newitemlatest === true
                                ) {
                                    // there are more products on server and shops list update
                                    this.current_shop_limit =
                                        response.data["current_shop_limit"];
                                } else if (
                                    itemsemptyonserver == 1 &&
                                    this.newitemlatest === false
                                ) {
                                    // empty on server all done
                                    this.emptyonserver = 1;
                                    this.emptyonservernew = 1;
                                } else if (
                                    itemsemptyonserver == 0 &&
                                    shopsempty == 1 &&
                                    this.newitemlatest === false
                                ) {
                                    // there are more products but shop list empty (have to restart shop list) for recent 2 months before

                                    this.current_shop_limit = 0;
                                    this.newitemlimit += 4;
                                } else if (
                                    itemsemptyonserver == 0 &&
                                    shopsempty == 0 &&
                                    this.newitemlatest === false
                                ) {
                                    // there are more products on server and shops list update for recent 2 months before

                                    this.current_shop_limit +=
                                        response.data["current_shop_limit"];
                                }
                            };
                            // set data
                            let setfilterdata = (data) => {
                                data.map((d) => {
                                    this.newdata.push(d);
                                });
                            };
                            // set busy for load more
                            let setbusy = () => {
                                if (this.emptyonservernew == 1) {
                                    this.busy = true;
                                } else {
                                    this.busy = false;
                                }
                            };

                            async function tosetdata() {
                                await setemptyonserver(
                                    response.data["itemsemptyonserver"],
                                    response.data["shopsempty"]
                                );
                                await setfilterdata(response.data["newitems"]);
                                await setbusy();
                            }
                            tosetdata();
                            // emit data to parent component to save data when re render
                            this.$emit("forparentfromnew", {
                                newlimit: this.newitemlimit,
                                newlatest: this.newitemlatest,
                                shop_limit: this.current_shop_limit,
                            });
                        }, 500);
                    }
                });
        },
    },
};
</script>

<style>
.yk-fade {
    -webkit-animation: fade 2s;
    -moz-animation: fade 2s;
    -o-animation: fade 2s;
    -ms-transition: fade 2s;
    animation: fade 2s;
}
img[lazy="loading"] {
    /*your style here*/
    width: 200px !important;
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
