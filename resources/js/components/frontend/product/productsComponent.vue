<template>
    <div class="">
        <div class="mt-1 mb-4">
            <h3 v-if="this.typesearch != ''">Search Results</h3>
            <h3 v-else>Results</h3>
            <span class="d-none">( 212 Results ) static data</span>
        </div>
        <div
            v-infinite-scroll="loadMore"
            infinite-scroll-disabled="busy"
            infinite-scroll-distance="10"
        >
            <div
                class="products default loading row d-flex flex-wrap"
                style="padding-bottom: 12px"
            >
                <div
                    class="indi-product yk-fade"
                    v-for="item in this.filterdata"
                    :key="item.key"
                >
                    <div
                        v-if="item.YkgetDiscount == 0"
                        class="ftc-product product mb-2 sop-font"
                        style="
                            padding-top: 0px !important;
                            box-shadow: none !important;
                        "
                    >
                        <div class="images sop-img">
                            <div
                                class="yk-hover-title sop-rounded-top text-uppercase text-left g-0"
                                style="width: 100% !important"
                            >
                                <a
                                    style="color: #ffe775 !important"
                                    :href="
                                        host + '/' + item.WithoutspaceShopname
                                    "
                                >
                                    <img
                                        :src="
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
                                        }}
                                    </span>
                                </a>
                            </div>

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

                    <div
                        v-else
                        class="ftc-product product sop-font"
                        style="
                            padding-top: 0px !important;
                            box-shadow: none !important;
                        "
                    >
                        <a
                            :href="
                                host +
                                '/' +
                                item.WithoutspaceShopname +
                                '/product_detail/' +
                                item.id
                            "
                        >
                            <div class="sop-ribbon">
                                <span>-{{ item.YkgetDiscount.percent }}%</span>
                            </div>
                        </a>
                        <div
                            class="post-img sop-img"
                            style="margin-bottom: 0px !important"
                        >
                            <div
                                class="yk-hover-title text-capitalize text-left g-0"
                                style="width: 100% !important"
                            >
                                <a
                                    style="color: #ffe775 !important"
                                    :href="
                                        host + '/' + item.WithoutspaceShopname
                                    "
                                >
                                    <img
                                        :src="
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
                                        }}
                                    </span>
                                </a>
                            </div>
                            <span
                                class="fa fa-user yk-viewcount sop-hover-show"
                            >
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
                                        :data-loading="imgurl + item.CheckPhotothumbs"
                                        class="sop-image-w-h"
                                        lazy="loading"
                                    />
                                </div>
                                <!-- <img :src="host + '/images/items/16806830130392.jpg'" class="sop-image-w-h" /> -->
                            </a>
                        </div>

                        <div class="item-description mt-2">
                            <div class="price">
                                <span
                                    class="woocommerce-Price-amount amount yk-amount"
                                    style="
                                        color: #780116 !important;
                                        font-weight: 600 !important;
                                    "
                                >
                                    <bdi
                                        v-html="item.YkgetDiscount.MmPrice"
                                        style="float: left !important"
                                    >
                                    </bdi>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sn-no-items" v-if="this.shownoitems">
            <div class="sn-cross-sign"></div>
            <i class="fa-solid fa-box-open"></i>
            <span>No More Items Available.</span>
        </div>
    </div>
</template>
<script>
import VueLazyload from "vue-lazyload";
import Vue from "vue";
Vue.use(VueLazyload, {
    preLoad: 1.3,

    attempt: 1,
});
export default {
    props: [
        "initialitems",
        "selected_product_quality",
        "price_range",
        "byshop",
        "sortby",
        "cat_id",
        "selected_gems",
        "gender",
        "gold_colour",
        "gold_quality",
        "discount",
        "item_id",
        "additional",
        "typesearch",
        "empty_on_server",
    ],
    name: "products",
    data: function () {
        return {
            shownoitems: false,
            imgurl: "",
            host: "",
            // emptyonserver: 0,
            isloadmoreprocessing: false,
            filterdata: [],
            busy: false,
            ini_check: true,
        };
    },

    beforeMount() {},
    updated() {},
    mounted() {
        this.busy = this.$parent.busy;
        this.host = this.$hostname;
        if (process.env.MIX_USE_DO == "true") {
            this.imgurl = process.env.MIX_DO_URL;
        } else {
            this.imgurl = this.$hostname + "/images";
        }
        // this.emptyonserver = this.empty_on_server;
    },
    watch: {},
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
        loadMore: function () {
            if (!this.shownoitems) {
                this.$parent.showloader = true;
                this.isloadmoreprocessing = true;
                this.$parent.getdatafromserver_bysort();
            }
        },
    },
};
</script>

<style scoped>
.item_img {
    width: 200px !important;
    height: 100px !important;
}
img[lazy="loading"] {
    /*your style here*/
    width: 200px !important;
}
.indi-product {
    width: 50%;
}
@media only screen and (min-width: 600px) {
    .indi-product {
        width: 33%;
    }
}

@media only screen and (min-width: 991px) {
    .indi-product {
        width: 20%;
    }
}
</style>
