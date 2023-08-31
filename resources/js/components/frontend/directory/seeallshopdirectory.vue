<template>
  <div
    v-infinite-scroll="loadShopsMore"
    infinite-scroll-disabled="busy"
    infinite-scroll-distance="10"
    id="main-content"
    class="col-sm-12 col-xs-12"
  >
    <div class="directory-banner">
      <div class="sn-dir-banner">
        <div class="directory-header mb-4">
          <h1>Directory Lists Myanmar</h1>
        </div>
        <div
          class="sn-dir-search container-fluid d-flex flex-column flex-md-row justify-content-center align-items-center rounded pe-md-0"
        >
          <div class="mx-2 sn-dir-search-icon d-none d-md-block">
            <i class="fa-solid fa-search"></i>
          </div>
          <select
            v-model="selected_state"
            @change="changeState"
            id="sn-dir-state"
            class="form-control align-items-center me-0 me-md-3 mb-2 mb-md-0 m-0 border-0 rounded-0 shadow-none"
          >
            <option value="0" class="" selected>All State</option>
            <option v-for="state in this.states" :key="state.key" :value="state.id">
              {{ state.name + " (" + state.myan_name + ")" }}
            </option>
          </select>
          <select
            v-model="selected_township"
            @change="changeTownship"
            id="sn-dir-township"
            class="form-control align-items-center border-0 mb-2 mb-md-0 rounded-0 shadow-none"
          >
            <option value="0" class="" selected>All Township</option>
            <option
              v-for="township in this.townships"
              :key="township.key"
              :value="township.id"
            >
              {{ township.name + " (" + township.myan_name + ")" }}
            </option>
          </select>
          <div class="sn-dir-search-button">
            <button @click="searchbyFilter">Search</button>
          </div>
        </div>
      </div>
    </div>
    <div class="px-md-3">
      <div
        id="main-content"
        class="mt-5 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5"
      >
        <div class="site-content">
          <div
            class="products default loading row gx-5 gy-3"
            style="padding-bottom: 12px"
          >
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
              <h2 class="mb-3">Directory Lists Myanmar</h2>
              <div class="d-flex align-items-center">
                <input
                  type="text"
                  v-model="search"
                  placeholder="ဆိုင်အမည်.."
                  id="shop-dir-name-search"
                  @input="searchbyFilter"
                />
                <div
                  class="d-flex align-items-center align-self-stretch sop-filter-search"
                >
                  <i class="fas fa-search px-3"></i>
                </div>
              </div>
            </div>
            <div v-if="!this.filtershops.length">
              <div class="text-center h3">Not Found !</div>
            </div>
            <div v-else class="container-fluid">
              <div class="row">
                <div
                  v-for="shop in this.filtershops"
                  :key="shop.key"
                  class="col-sm-12 col-md-6 col-lg-4 yk-fade mb-3 mb-md-5"
                >
                  <div
                    class="ftc-product product mb-1"
                    style="box-shadow: none !important; width: 100%"
                  >
                    <div class="images post-img sop-img shop-img position-relative pt-1">
                      <div
                        class="kanok-frame"
                        v-if="shop.shweshops_premium_status == 'yes'"
                      >
                        <a
                          :href="
                            shop.shweshops_premium_status
                              ? host + '/' + shop.shop_name_url
                              : host +
                                '/directory/detail/' +
                                [
                                  shop.shop_name_url
                                    ? shop.shop_name_url.split(' ').join('')
                                    : shop.shop_name.split(' ').join(''),
                                ]
                          "
                        >
                          <img
                            :src="host + '/images/directory/banner/Kanote frame.png'"
                          />
                        </a>
                      </div>
                      <div class="d-none" v-if="shop.shweshops_premium_status == 'yes'">
                        <div class="sn-premium-ribbon text-center"></div>
                        <div class="sn-premium-text">Premium<br />Shop</div>
                      </div>
                      <a
                        :href="
                          shop.shweshops_premium_status
                            ? host + '/' + shop.shop_name_url
                            : host +
                              '/directory/detail/' +
                              [
                                shop.shop_name_url
                                  ? shop.shop_name_url.split(' ').join('')
                                  : shop.shop_name.split(' ').join(''),
                              ]
                        "
                      >
                        <img
                          v-if="shop.shop_logo"
                          :src="imgurl + '/shop_owner/logo/thumbs/' + shop.shop_logo"
                          class="sn-image-w-h sn-shop-image"
                        />
                        <img
                          v-else-if="shop.dir_shop_logo"
                          :src="imgurl + '/directory/' + shop.dir_shop_logo"
                          class="sn-image-w-h sn-shop-image"
                        />
                        <div v-else>
                          <i
                            class="fas fa-store-alt sn-image-w-h sn-shop-image sn-dir-store"
                          ></i>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="post-info px-2">
                    <header class="entry-header">
                      <!-- Directory Title -->
                      <div class="sn-directory-title">
                        <h3 class="yk-product-title">
                          <a
                            class="sop-font-content mt-1"
                            :href="
                              shop.shweshops_premium_status
                                ? host + '/' + shop.shop_name_url
                                : host +
                                  '/directory/detail/' +
                                  [
                                    shop.shop_name_url
                                      ? shop.shop_name_url.split(' ').join('')
                                      : shop.shop_name.split(' ').join(''),
                                  ]
                            "
                            style="font-family: sans-serif !important"
                            >{{ shop.shop_name }}</a
                          >
                        </h3>
                        <img
                          v-if="shop.shweshops_premium_status"
                          :src="host + '/images/logo/favicon.gif'"
                          alt=""
                        />
                      </div>
                      <!-- <span class="vcard author" style=""></span> -->
                      <!-- Directory Categories -->
                    </header>
                    <div class="clear"></div>
                    <div class="shop-dir-ph mt-1 mb-1">
                      <span>Phone Number : {{ shop.main_phone }}</span>
                    </div>
                    <div class="shop-dir-links">
                      <a
                        :href="shop.facebook_link"
                        :class="shop.facebook_link ? '' : 'grey-out'"
                        style="flex-grow: 1"
                        ><i class="fa-brands fa-facebook"></i
                      ></a>
                      <a
                        :href="shop.website_link"
                        :class="shop.website_link ? '' : 'grey-out'"
                        style="flex-grow: 1"
                        ><i class="fa-solid fa-globe"></i
                      ></a>
                      <div style="flex-grow: 15; text-align: right">
                        <a
                          :href="
                            shop.shweshops_premium_status
                              ? host + '/' + shop.shop_name_url
                              : host +
                                '/directory/detail/' +
                                [
                                  shop.shop_name_url
                                    ? shop.shop_name_url.split(' ').join('')
                                    : shop.shop_name.split(' ').join(''),
                                ]
                          "
                          >More Detail</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="this.emptyonserver === 0" class="col-12" style="height: 222px !important">
      <div class="yk-wrapper fff" style="position: relative !important; margin-top: 56px">
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
import { async } from "q";

export default {
  props: ["shops", "states"],
  name: "seeallshopdirectory",
  data: function () {
    return {
      filtershops: [],
      shoplimit: 0,
      host: "",
      emptyonserver: 0,
      busy: false,
      townships: [],
      selected_state: 0,
      selected_township: 0,
      search: "",
    };
  },
  beforeMount() {},
  mounted() {
    this.filtershops = this.shops;
    this.host = this.$hostname;
    this.shoplimit = this.shops.length;
    if (this.shops.length < 20) {
      this.emptyonserver = 1;
    }
    if (localStorage.getItem("selected_state") != undefined) {
      this.selected_state = localStorage.getItem("selected_state");
      this.changeState();
    }
    if (localStorage.getItem("selected_township") != undefined) {
      console.log(this.selected_township);

      this.selected_township = localStorage.getItem("selected_township");
    }

    if (localStorage.getItem("search") != undefined) {
      this.search = localStorage.getItem("search");
    }

    this.getShopsbyFilter();
    console.log(localStorage.getItem("selected_state"));
  },
  filters: {},
  computed: {},
  methods: {
    changeState() {
      console.log("state change");
      return new Promise((resolve, response) => {
        axios
          .get(this.host + "/get_township_bystate/" + this.selected_state)
          .then((response) => {
            this.townships = response.data;
            if (localStorage.getItem("selected_township") == undefined) {
              this.selected_township = 0;
            }
            // this.getShopsbyFilter();
          });
      });
    },

    changeTownship() {
      // this.getShopsbyFilter();
    },

    searchbyFilter() {
      localStorage.setItem("selected_state", this.selected_state.toString());
      localStorage.setItem("selected_township", this.selected_township.toString());
      localStorage.setItem("search", this.search);

      this.getShopsbyFilter();
    },

    getShopsbyFilter() {
      axios
        .post(
          this.host + "/get_shop_directory",
          {
            filtertype: {
              state: this.selected_state,
              township: this.selected_township,
              shopname: this.search,
              shoplimit: 0,
            },
          },
          {
            header: {
              "Content-Type": "multipart/form-data",
            },
          }
        )
        .then((response) => {
          this.filtershops = response.data.shops;

          if (response.data["empty_on_server"] == 1) {
            this.emptyonserver = 1;
            this.busy = true;
          } else {
            this.emptyonserver = 0;
            this.busy = false;
          }
        });
    },

    loadShopsMore() {
      this.busy = true;

      axios
        .post(
          this.host + "/get_shop_directory",
          {
            filtertype: {
              state: this.selected_state,
              township: this.selected_township,
              shopname: this.search,
              shoplimit: this.shoplimit,
            },
          },
          {
            header: {
              "Content-Type": "multipart/form-data",
            },
          }
        )
        .then((response) => {
          if (response.statusText == "OK") {
            setTimeout(() => {
              let setemptyonserver = (e) => {
                this.emptyonserver = e;
                this.shoplimit += response.data["count"];
              };

              let setfilterdata = (data) => {
                data.map((d) => {
                  this.filtershops.push(d);
                });
              };

              let setbusy = () => {
                if (this.emptyonserver == 1) {
                  this.busy = true;
                } else {
                  this.busy = false;
                }
              };

              async function tosetdata() {
                await setemptyonserver(response.data["empty_on_server"]);
                await setfilterdata(response.data["shops"]);
                await setbusy();
              }
              tosetdata();
            }, 500);
          }
        });
    },
  },
};
</script>

<style scoped>
.kanok-frame {
  position: absolute;
  top: 2px;
  z-index: 9;
  width: 98% !important;
  height: 102% !important;
  left: 4px !important;
  object-fit: fill;
}
.kanok-frame img:hover {
  opacity: 1 !important;
}
</style>
