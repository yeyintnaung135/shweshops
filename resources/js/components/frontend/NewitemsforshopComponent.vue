<template>
    <div class="site-content sop-font">
        <div
            class="products default loading row g-2 g-md-3"
            style="padding-bottom: 12px"
        >
            <div
                class="col-6 col-sm-4 col-md-3 col-xl-2 yk-fade d-flex justify-content-center pe-2"
                v-lazy-container="{ selector: 'div' }"
                v-for="item in this.newdata"
                :key="item.id"
            >
                <div
                    class="ftc-product mb-2"
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
                                    :src="
                                        imgurl +
                                        '/shop_owner/logo/thumbs/' +
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
                            </div>
                        </a>

                        <span class="fa fa-user-group yk-viewcount">
                            <!-- //you want to use yk_view from laravel eloquent but in vue you must write camelcase-->
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
                    <p style="color:#222 text-align:left;" class="my-2">
                        {{ item.name }}
                    </p>
                    <div class="item-description">
                        <span class="price">
                            <span
                                class="woocommerce-Price-amount amount sop-amount sop-color-vermilion float-start"
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

            <div class="d-flex justify-content-center w-100 fa-3x mb-3">
                <button
                    v-if="this.clickloadmorecount < 5"
                    id=""
                    class="btn btn-danger sop-view-button"
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
                    v-else
                    :href="
                        this.host +
                        '/see_all_for_shop/latest/' +
                        this.newdata[0].shop_id
                    "
                    class="btn btn-danger sop-view-button"
                    @click="test"
                >
                    <span class="fa fa-arrow-circle-right"></span>
                    See All
                </a>
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
    props: ["newitems", "uri"],
    name: "NewitemsforshopComponent",
    data: function () {
        return {
            test: "",
            emptyonserver: 0,
            togglespin: false,
            clickloadmorecount: 0,
            newdata: "",
            host: "",
            latestid: "",
            hostname: "",
            limit: "",
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
        this.newdata = this.newitems;
        this.limit = this.newdata.length;
        if (this.limit < 20) {
            this.clickloadmorecount = 6;
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
        loadmoreclick(e) {
            e.preventDefault();
            console.log(this.latestid);

            if (this.togglespin) {
                this.togglespin = false;
            } else {
                this.togglespin = true;
            }
            axios
                .get(
                    this.host +
                        "/" +
                        this.uri +
                        "/" +
                        this.limit +
                        "/" +
                        this.newdata[0].shop_id
                )
                .then((response) => {
                    console.log(response);
                    if (response.statusText == "OK") {
                        setTimeout(() => {
                            this.togglespin = false;
                            // this.newdata.concat([{'test':'ff'}]);

                            response.data.map((d) => {
                                this.newdata.push(d);
                            });

                            if (response.data.length < 20) {
                                this.clickloadmorecount = 10;
                            } else {
                                this.clickloadmorecount += 1;
                                this.limit += 20;
                            }
                        }, 500);
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
    transition: fade 2s;
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
