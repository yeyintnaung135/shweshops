<template>
    <div>
        <div v-if="this.showloader === false">
            <div class="sn-no-items" v-if="this.recdata == ''">
                <div class="sn-cross-sign"></div>
                <i class="fa-solid fa-box-open"></i>
                <span>No Items Found.</span>
            </div>
            <div class="col-12 mt-4 main-content" v-else>
                <div
                    class="owl-carousel owl-theme w-100 ps-4 px-md-5 owl-loaded owl-drag"
                >
                    <carousel
                        :dots="false"
                        :autoplay="false"
                        :margin="20"
                        :nav="false"
                        :responsive="{
                            0: {
                                items: 2,
                                stagePadding: 0,
                            },
                            600: {
                                items: 2,
                                stagePadding: 0,
                            },
                            900: {
                                items: 3,
                                stagePadding: 0,
                            },
                            1200: {
                                items: 4,
                                stagePadding: 0,
                            },
                            1400: {
                                items: 6,
                                stagePadding: 0,
                            },
                        }"
                    >
                        <article
                            class="post-wrapper"
                            v-for="item in this.recdata"
                            :key="item.key"
                        >
                            <div class="post-img sop-img">
                                <a
                                    class=""
                                    :href="
                                        host +
                                        '/' +
                                        item.WithoutspaceShopname +
                                        '/product_detail/' +
                                        item.id
                                    "
                                >
                                    <img
                                        :src="imgurl + item.CheckPhoto"
                                        class="sn-shop-image attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded sop-image-w-h"
                                        alt=""
                                    />
                                </a>

                               
                            </div>
                            <div class="post-info">
                                <div
                                    class="product-text-eng"
                                    style="font-size: 16px; font-weight: bold"
                                    v-if="item.price == 0"
                                    v-html="item.MmPrice"
                                ></div>
                                <div
                                    class="product-text-eng"
                                    style="font-size: 16px; font-weight: bold"
                                    v-else
                                    v-html="item.MmPrice"
                                ></div>
                            </div>
                        </article>
                    </carousel>
                </div>
            </div>
        </div>
        <div class="col-12" style="height: 222px !important" v-else>
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
</template>
<script>
import axios from "axios";
import carousel from "vue-owl-carousel";
export default {
    components: { carousel },

    name: "NewitemsComponent",
    data: function () {
        return {
            imgurl: "",

            recdata: "",
            host: "",
            showloader: true,
        };
    },

    mounted() {
        this.host = this.$hostname;
        if (process.env.MIX_USE_DO == "true") {
            this.imgurl = process.env.MIX_DO_URL;
        } else {
            this.imgurl = this.$hostname + "/images";
        }
        this.loadrec();
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
        loadrec() {
            this.busy = true;

            axios.get(this.host + "/ger_rec_foryou").then((response) => {
                this.recdata = response.data;
                this.showloader = false;
            });
        },
    },
};
</script>
