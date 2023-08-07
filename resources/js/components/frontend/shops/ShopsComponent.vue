<template>
    <div
      v-infinite-scroll="loadShopsMore"
      infinite-scroll-disabled="busy"
      infinite-scroll-distance="10"
      class="site-content"
    >
        <div
            class="products default loading row g-2 g-md-3"
            style="padding-bottom: 12px"
        >
            <div
                class="col-6 col-sm-4 col-md-3 col-lg-2 yk-fade"
                v-for="d in this.shops"
                v-bind:key="d.id"
            >
                <div
                    class="ftc-product product mb-2"
                    style="box-shadow: none !important"
                >
                    <div class="images post-img sop-img shop-img">
                        <a  :href="host+'/'+d.WithoutspaceShopname ">
                            <img
                                :src="'images/logo/mid/' + d.shop_logo"
                                class="sop-image-w-h sn-shop-image"
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
                                style="font-family: sans-serif !important"
                                :href="host+'/'+d.WithoutspaceShopname"
                                >{{ d.shop_name | strlimit(12, "...") }}</a
                            >
                        </h3>

                        <span class="vcard author" style=""></span>
                        <!-- Blog Categories -->
                    </header>
                    <div class="clear"></div>

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
            <!-- <div class="d-flex justify-content-center fa-3x mb-3 sop-sans">
                <button
                    v-if="
                        this.clickloadmorecount < 5 && this.emptyonserver == 0
                    "
                    id=""
                    class="btn btn-danger zh-button"
                    @click="loadmoreclick($event)"
                >
                    <span
                        class="fa fa-spinner"
                        v-bind:class="{ 'fa-spin': togglespin }"
                    ></span>
                    View More
                </button> -->
                <!--                <a-->
                <!--                    style="color: white !important"-->
                <!--                    :href="this.host + '/see_all_discount'"-->
                <!--                    v-else-->
                <!--                    class="btn btn-danger zh-button"-->
                <!--                >-->
                <!--                    <span class="fa fa-arrow-circle-right"></span>-->
                <!--                    See All-->
                <!--                </a>-->
            <!-- </div> -->
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: ["latest_shops", "shoplimitfromparent"],
    name: "ShopsComponent",

    data: function () {
        return {
            shops:[],
            host: "",
            hostname: "",
            emptyonserver: 0,
            shoplimit: 0,
            // togglespin: false,
            busy: false,
            clickloadmorecount: 0,
        };
    },

    mounted() {
        this.host = this.$hostname;

        console.log("shops==");
        console.log(this.latest_shops);
        this.shoplimit = this.shoplimitfromparent;
        this.loadShopsMore();
        // if (this.shops < 20) {
        //     this.clickloadmorecount = 10;
        // }
        // this.limit = 20;
    },

    computed: {},
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
        loadShopsMore() {

            this.busy = true;

            axios
                .get(this.host + "/get_shop_ajax/" + this.shoplimit)
                .then((response) => {
                    console.log(response.statusText);
                    if (response.statusText == "OK") {
                      setTimeout(() => {
                          let setemptyonserver = (e) => {
                              this.emptyonserver = e;
                              this.shoplimit += response.data[1];
                          };

                          let setfilterdata = (data) => {
                            data.map((d) => {
                                this.shops.push(d);
                            });
                          }

                          let setbusy = () => {
                              if (this.emptyonserver == 1) {
                                  this.busy = true;
                              } else {
                                  this.busy = false;
                              }
                          };

                          async function tosetdata() {

                            await setemptyonserver(
                                response.data[2]
                            );
                            await setfilterdata(response.data[0]);
                            await setbusy();
                          }
                          tosetdata();
                          this.$emit("forparentfromshops", {
                              shoplimitfromparent: this.shoplimit
                          });

                        }, 500);

                        console.log("shop data length", response.data.length);
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
