<template>
    <div>
        <div class="d-lg-none" style="position: relative">
        </div>
        <div class="site-content mm_font">
            <!-- Top Content -->
            <div
                class="text-center mt-3 mt-sm-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading"
            ></div>
            <!-- Top Content -->
            <nav
                class="navbar navbar-expand-sm bg-light justify-content-start mb-3"
                style="background-color: #fff !important"
            >
                <ul class="zh_nav navbar-nav">
                    <li class="s_items_nav nav-item active">
                        <a
                            class="nav-link"
                            id="items"
                            style=""
                            @click="showshoporitem('items')"
                            >Items</a
                        >
                    </li>
                    <li class="s_shops_nav nav-item">
                        <a
                            class="nav-link"
                            id="shops"
                            @click="showshoporitem('shops')"
                            >Shops</a
                        >
                    </li>
                    <li class="s_news_nav nav-item d-none">
                        <a
                            class="nav-link"
                            id="news"
                            @click="showshoporitem('news')"
                            >News</a
                        >
                    </li>
                    <li class="s_events_nav nav-item d-none">
                        <a
                            class="nav-link"
                            id="events"
                            @click="showshoporitem('events')"
                            >Events</a
                        >
                    </li>
                </ul>
            </nav>
            <!-- itempannel-->
            <div>
                <div
                    class="products default loading row g-2 g-md-3"
                    style="padding-bottom: 12px"
                >

                    <seeallforcat
                        ref="saf"
                        @forparent="getdatafromchild"
                        v-bind:class="this.shoppannel ? 'd-none' : 'd-block'"
                        :typesearchfromblade="this.searchtext"
                        :newitems="this.searcheddataitems"
                        :discount="'no'"
                        :cat_list="this.cat_list_from_blade"
                        :selected_shop="'all'"
                        :additional="'no'"
                        :sort="'latest'"
                        :title_prop="'ALL DISCOUNT ITEMS'"
                        :cat_id="'all'"
                        :shop_ids="this.shop_ids_from_blade"
                        :selected_gems="[]"
                        :gender="'all'"
                    ></seeallforcat>

                    <!--items data-->
                </div>
            </div>
            <!-- itempannel-->
            <!--shop pannel-->
            <div
                v-infinite-scroll="getsearchresultfromserver"
                infinite-scroll-disabled="busyforshops"
                infinite-scroll-distance="340"
                v-bind:class="this.shoppannel ? 'd-block' : 'd-none'"
                class="site-content"
            >
                <div
                    class="products default loading row g-2 g-md-3"
                    style="padding-bottom: 12px"
                >
                    <!--empty div-->
                    <div
                        class="sn-no-items"
                        v-if="
                            shoppannel == true &&
                            searcheddatashops.length == 0 &&
                            showempty == true
                        "
                    >
                        <div class="sn-cross-sign"></div>
                        <i class="fa-solid fa-box-open"></i>
                        <span>No Shops Available. Try Check Items Tab.</span>
                    </div>
                    <!--empty div-->

                    <!--shops data-->
                    <div
                        v-if="searcheddatashops.length != 0"
                        class="products default loading row g-2 g-md-3"
                        style="padding-bottom: 12px"
                    >
                        <div
                            class="col-6 col-sm-4 col-md-3 col-lg-2 yk-fade"
                            v-lazy-container="{ selector: 'div' }"
                            v-for="item in this.searcheddatashops"
                            :key="item.key"
                        >
                            <div
                                class="ftc-product product mb-2 sop-font"
                                style="
                                    padding-top: 0px !important;
                                    box-shadow: none !important;
                                "
                            >
                                <div
                                    class="ftc-product product mb-2"
                                    style="box-shadow: none !important"
                                >
                                    <div class="images post-img sop-img shop-img">
                                        <a
                                            :href="
                                                host +
                                                '/shops/' +
                                                item.WithoutspaceShopname
                                            "
                                        >
                                            <img
                                                :src="
                                                    host +
                                                    '/images/logo/mid/' +
                                                    item.shop_logo
                                                "
                                                class="sop-image-w-h"
                                            />
                                        </a>
                                    </div>
                                </div>
                                <div class="post-info">
                                    <header class="entry-header">
                                        <!-- Blog Title -->
                                        <h3 class="yk-product-title">
                                            <a
                                                class="sop-font-content mt-2"
                                                style="
                                                    font-family: sans-serif !important;
                                                "
                                                :href="
                                                    host +
                                                    '/shops/' +
                                                    item.WithoutspaceShopname +
                                                    '/' +
                                                    item.id
                                                "
                                                >{{
                                                    item.shop_name
                                                        | strlimit(12, "...")
                                                }}</a
                                            >
                                        </h3>

                                        <span
                                            class="vcard author"
                                            style=""
                                        ></span>
                                        <!-- Blog Categories -->
                                    </header>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--shops data-->
                    <!--wrapper loader-->
                    <div
                        v-if="this.emptyonserverforshops === 0"
                        class="col-12"
                        style="height: 222px !important"
                    >
                        <div
                            class="yk-wrapper"
                            style="
                                position: relative !important;
                                margin-top: 56px;
                            "
                        >
                            <div class="ct-spinner5">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </div>
                    </div>
                    <!--wrapper loader-->
                </div>
            </div>
            <!--shop pannel-->
        </div>
    </div>
</template>

<script>
import axios from "axios";
import VueLazyload from "vue-lazyload";
import seeallforcat from "./forcategories/seeallforcat";
import Ykfilter from "./Ykfilter";

Vue.use(VueLazyload, {
    preLoad: 1.3,
    // error: Vue.prototype.$hostname + "/dist/errofefr.png",
    // loading: Vue.prototype.$hostname + "/tFFest/KSYL.gif",
    attempt: 1,
});
export default {
    props: ["searchtext", "cat_list_from_blade", "shop_ids_from_blade"],
    name: "SearchresultComponent",
    data() {
        return {
            shop_ids: "",
            itempannel: true,
            shopslimit: 0,
            shoppannel: false,
            host: "",
            catlist: "",
            showempty: false,
            forsearchtext: "",
            searcheddataitems: [],
            searcheddatashops: [],
            emptyonserver: 0,
            itemslimit: 0,
            busy: false,
            busyforshops: false,
            emptyonserverforshops: 0,
            inputval: "",
        };
    },
    components: { seeallforcat: seeallforcat },

    mounted() {
        // this.catlist = this.cat_list_from_blade;
        // this.shop_ids = this.shop_ids_from_blade;
        this.host = this.$hostname;
        this.forsearchtext = this.searchtext;
        this.inputval = this.forsearchtext;
        this.callaftermountsearch();
    },
    methods: {
        searchSubmit: function (event) {
            event.preventDefault();
            return location.assign(
                this.host + "/ajax_search_result/" + this.inputval
            );
        },
        callaftermountsearch: async function () {
            const isdone = await this.getsearchresultfromserver();
            if (isdone == "done") {
                // if (this.searcheddataitems.length == 0) {
                //     this.itempannel = false;
                //     this.shoppannel = true;
                // } else {
                //     this.itempannel = true;
                //     this.shoppannel = false;
                // }
                this.showempty = true;
            }
        },
        showshoporitem: function (data) {
            if (data == "items") {
                this.itempannel = true;
                this.shoppannel = false;
            } else {
                this.itempannel = false;
                this.shoppannel = true;
            }
        },

        getdatafromchild: function (v) {
            if (this.forsearchtext != v.typesearch) {
                this.forsearchtext = v.typesearch;
                this.searcheddatashops = [];
                this.shopslimit = 0;
                this.getsearchresultfromserver();
            }
        },

        getsearchresultfromserver: function () {
            return new Promise((resolve) => {
                this.busy = true;
                this.busyforshops = true;
                axios
                    .post(this.host + "/search_by_type", {
                        data: this.forsearchtext,
                        limit: this.shopslimit,
                    })
                    .then((response) => {
                        // response.data.resultdataitems.map((d) => {
                        //     this.searcheddataitems.push(d);
                        // });
                        response.data.resultdatashops.map((d) => {
                            this.searcheddatashops.push(d);
                        });
                        // if (response.data.resultdataitems.length < 20) {
                        //     this.emptyonserver = 1;
                        //     this.busy = true;
                        // } else {
                        //     this.itemslimit +=
                        //         response.data.resultdataitems.length;
                        //     this.busy = false;
                        // }

                        if (response.data.resultdatashops.length < 20) {
                            this.emptyonserverforshops = 1;
                            this.busyforshops = true;
                        } else {
                            this.shopslimit +=
                                response.data.resultdatashops.length;
                            this.busyforshops = false;
                        }
                        resolve("done");
                    });
            });
        },
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
};
</script>

<style scoped></style>
