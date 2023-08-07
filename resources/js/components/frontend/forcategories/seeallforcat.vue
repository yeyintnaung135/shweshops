<template>
    <div class="site-content mm_font">
        <!-- Top Content -->
        <div
            class="text-center mt-3 mt-sm-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading"
        >
            <Ykfilter
                ref="ykf"
                :for_child_discount="this.discount"
                :for_child_cat_list="this.cat_list"
                @forparent="getdatafromchild"
                :for_child_filterdata_from_server="this.filterdata_from_server"
                :additional_child="this.additional"
                :selected_shop="this.selected_shop"
                :selected_gems="this.selected_gems"
                :for_child_cat_id="this.cat_id"
                :shop_ids="this.shop_ids"
                :for_child_sort="this.sort"
                :for_child_typesearch="this.typesearchfromblade"
                :for_child_item_id="this.item_id"
                :fdata="this.newdata"
            ></Ykfilter>
        </div>
        <!-- Top Content -->
        <div class="sn-no-items" v-if="this.filterdata.length == 0">
            <div class="sn-cross-sign"></div>
            <i class="fa-solid fa-box-open"></i>
            <span>No Items Available.</span>
        </div>
        <div
            v-infinite-scroll="loadMore"
            infinite-scroll-disabled="busy"
            infinite-scroll-distance="340"
        >
            <div
                class="products default loading row g-2 g-md-3"
                style="padding-bottom: 12px"
            >
                <div
                    class="col-6 col-sm-4 col-md-3 col-lg-2 yk-fade"
                    v-lazy-container="{ selector: 'div' }"
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
                                        host +
                                        '/' +
                                        item.WithoutspaceShopname
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
                                <img
                                    v-lazy="host + '/' + item.CheckPhoto"
                                    class="sop-image-w-h"
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
                                        host +
                                        '/' +
                                        item.WithoutspaceShopname
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
                                <img
                                    v-lazy="host + '/' + item.CheckPhoto"
                                    class="sop-image-w-h"
                                />
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
                <div
                    v-if="this.emptyonserver === 0"
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
import $ from "jquery";
import Ykfilter from "../Ykfilter.vue";
import Vue from "vue";
import VueLazyload from "vue-lazyload";

Vue.use(VueLazyload, {
    preLoad: 1.3,
    // error: Vue.prototype.$hostname + "/dist/errofefr.png",
    // loading: Vue.prototype.$hostname + "/tFFest/KSYL.gif",
    attempt: 1,
});

export default {
    props: [
        "newitems",
        "discount",
        "cat_list",
        "cat_id",
        "sort",
        "shop_ids",
        "selected_shop",
        "selected_gems",
        "additional",
        "typesearchfromblade",
        "item_id",
        // "title_prop",
    ],
    components: { Ykfilter: Ykfilter },

    name: "seeallforcat",
    data: function () {
        return {
            // title: "temp",
            // hostname: "",
            // test: "",
            emptyonserver: 0,
            // togglespin: false,
            // clickloadmorecount: 0,
            newdata: "",
            // host: "",
            // latestid: "",
            filterdata: "",
            addit: "",
            itemid: "",
            busy: false,
            // filterdata_from_server: [],
            typesearch: "",
        };
    },
    // beforeMount() {
    //     // this.title = this.title_prop;
    //     this.filterdata = this.newitems;
    //     this.newdata = this.newitems;
    // },
    mounted() {
        //set initial data to initial key
        this.filterdata_from_server[this.$refs.ykf.search_key] = {
            data: this.newitems,
            limit: this.newdata.length,
        };
        //set initial data to initial key

        this.itemid = this.item_id;
        this.addit = this.additional;
        // this.host = this.$hostname;
        this.newdata = this.newitems;
        this.filterdata = this.newdata;
        // this.emptyonserver = this.newdata.length < 20 ? 1 : 0;

    },
    // filters: {
    //     strlimit: function (str, limit, other) {
    //         if (str.length > limit) {
    //             let shortstring = str.substring(0, limit) + other;
    //             return shortstring;
    //         } else {
    //             return str;
    //         }
    //     },
    // },
    computed: {},
    methods: {
        //get data from child ykfilter vue component
        getdatafromchild: function (v) {
            if (this.filterdata_from_server[v.search_key] !== undefined) {
                v.newfilterdata.map((d) =>
                    this.filterdata_from_server[v.search_key].data.push(d)
                );
                this.filterdata =
                    this.filterdata_from_server[v.search_key].data;
                this.filterdata_from_server[v.search_key].limit += 20;
                console.log(this.filterdata_from_server[v.search_key].limit);
            } else {
                this.filterdata_from_server[v.search_key] = {
                    data: v.newfilterdata,
                    limit: 20,
                };
                this.filterdata = v.newfilterdata;
                console.log(this.filterdata_from_server[v.search_key].limit);
                //
            }
            this.emptyonserver = v.empty_on_server;
            if (this.emptyonserver == 1) {
                //open infinite scroll
                this.busy = true;
            } else {
                //close infinite scroll

                this.busy = false;
            }
            console.log(this.emptyonserver, "emptyonserver");
            this.typesearch = v.typesearch;
            this.$emit("forparent", { typesearch: this.typesearch });
        },
        //get data from child ykfilter vue component

        //when user scroll up
        loadMore: function () {
            this.busy = true;
            // console.log(this.$refs.ykf.byshop);
            // this.newdata.concat([{'test':'ff'}]);

            let tmp_limit = 0;
            if (
                this.filterdata_from_server[this.$refs.ykf.search_key] !==
                undefined
            ) {
                tmp_limit =
                    this.filterdata_from_server[this.$refs.ykf.search_key]
                        .limit;
            } else {
                tmp_limit = 20;
            }
            let ini_check = false;
            if (
                this.$refs.ykf.price_range == "all" &&
                this.$refs.ykf.byshop == "all" &&
                (this.$refs.ykf.sortby == "latest" ||
                    this.$refs.ykf.sortby == "all") &&
                this.$refs.ykf.cat_id == this.cat_id &&
                this.$refs.ykf.selected_gems == "all" &&
                this.$refs.ykf.gender == "all" &&
                this.$refs.ykf.gold_colour == "all" &&
                this.$refs.ykf.gold_quality == "all"
            ) {
                console.log("latest");
                ini_check = true;
            } else {
                console.log("yesss");
                console.log(this.filterdata);
            }
            axios
                .post(
                    this.$hostname + "/catfilter",
                    {
                        data: this.filterdata,
                        filtertype: {
                            sort: this.$refs.ykf.sortby,
                            byshop: this.$refs.ykf.byshop,
                            price_range: this.$refs.ykf.price_range,
                            cat_id: this.$refs.ykf.cat_id,
                            gems: this.$refs.ykf.selected_gems,
                            gender: this.$refs.ykf.gender,
                            gold_colour: this.$refs.ykf.gold_colour,
                            gold_quality: this.$refs.ykf.gold_quality,
                            typesearch: this.$refs.ykf.typesearch,
                            additional: this.addit,
                            limit: tmp_limit,
                            item_id: this.$refs.ykf.item_child_id,
                            discount: this.$refs.ykf.discount,
                            ini_checked: ini_check,
                        },
                    },
                    {
                        header: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                )
                .then((response) => {
                    var self = this;
                    console.log(response);
                    if (response.statusText == "OK") {
                        console.log(response.data["empty_on_server"]);

                        console.log(response.data.length);

                        if (response.data[0].length > 0) {
                            // if (this.response.data[0].length > 0) {
                            //     this.filterdata = this.response.data[0];
                            //     this.newdata = this.response.data[0];
                            //     console.log('gone')
                            // }

                            setTimeout(() => {
                                let setemptyonserver = (e) => {
                                    this.emptyonserver = e;
                                };

                                let setbusy = () => {
                                    if (this.emptyonserver == 1) {
                                        this.busy = true;
                                    } else {
                                        this.busy = false;
                                    }
                                    console.log(this.busy);
                                };
                                let setfilterdata = (d) => {
                                    if (
                                        this.filterdata_from_server[
                                            this.$refs.ykf.search_key
                                        ] !== undefined
                                    ) {
                                        d.map((x) =>
                                            this.filterdata_from_server[
                                                this.$refs.ykf.search_key
                                            ].data.push(x)
                                        );
                                        this.filterdata_from_server[
                                            this.$refs.ykf.search_key
                                        ].limit += 20;
                                        this.filterdata =
                                            this.filterdata_from_server[
                                                this.$refs.ykf.search_key
                                            ].data;
                                    } else {
                                        this.filterdata_from_server[
                                            this.$refs.ykf.search_key
                                        ] = {
                                            data: d,
                                            limit: 20,
                                        };
                                        this.filterdata = d;
                                        console.log(
                                            this.filterdata_from_server[
                                                this.$refs.ykf.search_key
                                            ].limit
                                        );
                                        //
                                    }
                                    console.log(this.filterdata);

                                    // self.filterdata = d;
                                    // self.newdata = d;
                                };

                                async function tosetdata() {
                                    await setemptyonserver(
                                        response.data["empty_on_server"]
                                    );

                                    await setfilterdata(response.data[0]);
                                    await setbusy();
                                    console.log("filter data");
                                }

                                tosetdata();
                            }, 500);
                        }
                    }
                });
            console.log(this.busy);
        },
    },
};
</script>

<style scoped></style>
