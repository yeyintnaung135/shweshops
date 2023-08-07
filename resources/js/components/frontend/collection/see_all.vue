<template>
    <div class="site-content" style="border-bottom: 2px solid #a0793614">
        <!-- Top Content -->
        <div
            class="text-center mt-3 mt-sm-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading"
        >
            <Ykfilter
                ref="ykf"
                @forparent="getdatafromchild"
                :fdata="this.newdata"
            ></Ykfilter>

            <div class="elementor-widget-container mt-3">
                <h3
                    class="elementor-heading-title elementor-size-default"
                    style=""
                >
                    All Collections
                </h3>
            </div>
        </div>
        <!-- Top Content -->
        <div
            v-infinite-scroll="loadMore"
            infinite-scroll-disabled="busy"
            infinite-scroll-distance="10"
        >
            <div
                class="products default loading row g-2 g-md-3"
                style="padding-bottom: 12px"
            >
                <div
                    class="col-6 col-sm-4 col-md-3 col-lg-2 yk-fade"
                    v-lazy-container="{ selector: 'div' }"
                    v-for="item in this.filterdata"
                    :key="filterdata.key"
                >
                    <div
                        class="ftc-product product mb-2 sop-img"
                        style="
                            padding-top: 0px !important;
                            box-shadow: none !important;
                        "
                    >
                        <div class="images">
                            <div
                                class="yk-hover-title sop-rounded-top text-uppercase text-left g-0"
                                style="width: 100% !important"
                            >
                                <img
                                    :src="host + '/' + item.ShopName.shop_logo"
                                    class="yk-hover-logo float-left"
                                />
                                <span>
                                    {{
                                        item.ShopName.shop_name
                                            | strlimit(15, "..")
                                    }}
                                </span>
                            </div>

                            <span class="fa fa-user yk-viewcount">
                                <!--                                                 //you want to use yk_view from laravel eloquent but in vue you must write camelcase-->
                                {{ item.YkView }}
                            </span>
                            <a :href="host + '/product_detail/' + item.id">
                                <img
                                    v-lazy="host + '/' + item.CheckPhoto"
                                    class="yk-image"
                                />
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
                                    :href="host + '/product_detail/' + item.id"
                                    >{{ item.name | strlimit(12, "...") }}</a
                                >
                            </h3>
                            <!--                        <h3 class="product_title product-name"><a-->
                            <!--                            :href="host+'/product_detail/'+item.id">{{ item.ShopName.shop_name | strlimit(12,'...') }}</a>-->
                            <!--                        </h3>-->
                        </div>
                    </div>
                </div>

                <div class="col-12" style="height: 222px !important">
                    <div
                        class="yk-wrapper"
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
import $ from "jquery";
import Vue from "vue";
import Ykfilter from "../Ykfilter.vue";


export default {
    props: ["newitems", "uri"],
    name: "see_all",
    components: { Ykfilter: Ykfilter },

    data: function () {
        return {
            test: "",
            emptyonserver: 0,
            togglespin: false,
            clickloadmorecount: 0,
            newdata: "",
            hostname: "",
            host: "",
            filterdata: "",

            latestid: "",
            busy: false,
        };
    },
    beforeMount() {
        this.filterdata = this.newitems;

        this.newdata = this.newitems;
    },
    mounted() {
        this.host = this.$hostname;
        this.newdata = this.newitems;
        this.filterdata = this.newdata;

        this.latestid = this.newdata[this.newdata.length - 1].id;

        console.log(this.uri);
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
        //for filter
        getdatafromchild: function (v) {
            this.filterdata = v.newfilterdata;
        },
        //for filter
        loadMore: function () {
            this.busy = true;

            axios
                .post(
                    this.host + "/" + this.uri,
                    { data: this.newdata },
                    {
                        header: {
                            "Content-Type": "multipart/form-data",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                    }
                )
                .then((response) => {
                    console.log(response.statusText);
                    if (response.statusText == "OK") {
                        console.log(response.data.length);
                        if (response.data.length == 0) {
                            this.emptyonserver = 1;
                        } else {
                            this.clickloadmorecount += 1;

                            setTimeout(() => {
                                this.togglespin = false;
                                let self = this;
                                // this.newdata.concat([{'test':'ff'}]);
                                let setbusy = () => {
                                    self.busy = false;
                                };
                                let setfilterdata = () => {
                                    self.filterdata = self.newdata;
                                };

                                async function tosetdata() {
                                    await response.data[0].map((d) => {
                                        self.newdata.push(d);
                                    });
                                    await setfilterdata();
                                    await setbusy();

                                    await self.$refs.ykf.byshopfilter();

                                    console.log("filter data");
                                }

                                tosetdata();

                                this.latestid =
                                    this.newdata[this.newdata.length - 1].id;
                            }, 500);
                        }
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

@keyframes fade {
    0% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}
</style>
