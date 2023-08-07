<template>
    <div class="site-content">
        <!-- Top Content -->
        <div
            class="text-center mt-3 mt-sm-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading"
        >
            <div class="elementor-widget-container" style="margin-top: 20px">
                <h3
                    v-if="this.cat_id != 'all'"
                    class="elementor-heading-title elementor-size-default"
                    style=""
                >
                    {{ this.newitems[0].YkbeautyCat }}
                </h3>
                <h3
                    v-else
                    class="elementor-heading-title elementor-size-default"
                    style=""
                >
                    {{ this.title_prop }}
                </h3>
            </div>
        </div>
        <!-- Top Content -->
        <div
            v-infinite-scroll="loaddMore"
            infinite-scroll-disabled="this.busy"
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
                            class="images post-img sop-img"
                            style="margin-bottom: 0px !important"
                        >
                            <div
                                class="yk-hover-title text-capitalize text-left g-0"
                                style="width: 100% !important"
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
                            <!--                            <div class="price">-->
                            <!--                                <span-->
                            <!--                                    class="woocommerce-Price-amount amount yk-amount sop-opacity-50"-->
                            <!--                                    style="-->
                            <!--                                        color: black !important;-->
                            <!--                                        font-weight: 300 !important;-->
                            <!--                                    "-->
                            <!--                                >-->
                            <!--                                    <bdi-->
                            <!--                                        v-html="item.MmPrice"-->
                            <!--                                        style="-->
                            <!--                                            float: left !important;-->
                            <!--                                            text-decoration: line-through !important;-->
                            <!--                                        "-->
                            <!--                                    >-->
                            <!--                                    </bdi>-->
                            <!--                                </span>-->
                            <!--                            </div>-->

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
                    v-if="this.busy == false"
                    class="col-12"
                    style="height: 222px !important"
                >
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

export default {
    props: [
        "newitems",
        "cat_id",
        "sort",
        "shop_ids",
        "selected_shop",
        "additional",
        "item_id",
        "title_prop",
    ],
    data: function () {
        return {
            title: "temp",
            hostname: "",

            emptyonserver: 0,
            togglespin: false,

            host: "",
            filterdata: "",
            busy: false,
        };
    },
    beforeMount() {
        this.title = this.title_prop;
        this.filterdata = this.newitems;

        this.newdata = this.newitems;
    },
    mounted() {
        this.itemid = this.item_id;

        this.host = this.$hostname;

        this.filterdata = this.newdata;
        console.log(this.cat_id);
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
        loaddMore: function () {
            console.log("test");
            if (this.busy == false) {
                axios
                    .post(
                        this.host + "/tags_items",
                        {
                            filtertype: {
                                tags: this.title_prop,
                                start: 0,
                                end: 20,
                            },
                        },
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
                        console.log(response.data.length);
                        if (response.data.length < 19) {
                            this.busy = true;
                        }
                    });
            }
        },
    },
    name: "TagsComponent",
};
</script>

<style scoped></style>
