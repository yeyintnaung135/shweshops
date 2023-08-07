<template>
    <div
        class="site-content px-lg-5 px-md-3 sop-font"
        style="border-bottom: 2px solid #a0793614"
    >
        <div
            class="sop-discount products default loading d-flex flex-wrap g-2 g-md-3"
            style="padding-bottom: 12px"
        >
            <div
                class="col-6 col-sm-4 col-md-3 col-xl-2 yk-fade d-flex justify-content-center px-1"
                v-lazy-container="{ selector: 'div' }"
                v-for="item in this.newdata"
                :key="item.id"
            >
                <div
                    class="ftc-product product mb-2"
                    style="box-shadow: none !important"
                >
                    <div class="images post-img sop-img">
                        <div
                            class="yk-hover-title sop-rounded-top text-capitalize text-left g-0"
                            style="width: 100% !important"
                        >
                            <img
                                :src="host + '/' + item.ShopName.shop_logo"
                                class="yk-hover-logo float-left"
                            />
                            <span>
                                {{
                                    item.ShopName.shop_name | strlimit(15, "..")
                                }}
                            </span>
                        </div>

                        <span class="fa fa-eye yk-viewcount">
                            <!-- //you want to use yk_view from laravel eloquent but in vue you must write camelcase-->
                            {{ item.YkView }}
                        </span>
                        <a :href="host + '/product_detail/' + item.id">
                            <img
                                v-lazy="host + '/' + item.CheckPhoto"
                                class="sop-image-w-h w-sm-100 rounded"
                            />
                        </a>
                    </div>
                    <div class="item-description my-2">
                        <span class="price">
                            <span
                                class="woocommerce-Price-amount amount sop-color-vermilion float-start"
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
                            <a :href="host + '/product_detail/' + item.id">{{
                                item.name | strlimit(12, "...")
                            }}</a>
                        </h3>
                        <!--                        <h3 class="product_title product-name"><a-->
                        <!--                            :href="host+'/product_detail/'+item.id">{{ item.ShopName.shop_name | strlimit(12,'...') }}</a>-->
                        <!--                        </h3>-->
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center w-100 fa-3x mb-3">
                <button
                    v-if="
                        this.clickloadmorecount < 5 && this.forcheck_count != 0
                    "
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
                    v-else-if="this.forcheck_count != 0"
                    :href="
                        this.host +
                        '/see_all_new_for_shop/' +
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
import Vue from "vue";
import VueLazyload from "vue-lazyload";

Vue.use(VueLazyload, {
    preLoad: 1.3,
    error: "dist/error.png",
    loading: "test/KSYL.gif",
    attempt: 1,
});

export default {
    props: ["allitems", "uri", "forcheck_count"],
    name: "ItemsForShopAllComponent",
    data: function () {
        return {
            test: "",
            hostname: "",
            emptyonserver: 0,
            togglespin: false,
            clickloadmorecount: 0,
            newdata: "",
            host: "",
            latestid: "",
        };
    },

    mounted() {
        this.host = this.$hostname;
        this.newdata = this.allitems;
        this.latestid = this.newdata[this.newdata.length - 1].id;

        console.log(this.newdata);
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
                        this.latestid +
                        "/" +
                        this.newdata[0].shop_id
                )
                .then((response) => {
                    console.log(response);
                    if (response.statusText == "OK") {
                        setTimeout(() => {
                            this.togglespin = false;
                            // this.newdata.concat([{'test':'ff'}]);

                            response.data[0].map((d) => {
                                this.newdata.push(d);
                            });
                            this.latestid =
                                this.newdata[this.newdata.length - 1].id;
                            if (response.data[1] == 0) {
                                this.clickloadmorecount = 10;
                            } else {
                                this.clickloadmorecount += 1;
                            }
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
