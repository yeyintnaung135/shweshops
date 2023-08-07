<template>
  <div class="">
    <div class="mt-1 mb-4">
      <h3 v-if="this.typesearch != ''">Search Results</h3>
      <h3 v-else>Results</h3>
      <span class="d-none">( 212 Results ) static data</span>
    </div>
    <div class="sn-no-items" v-if="this.shownoitems">
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
        class="products default loading row d-flex flex-wrap"
        style="padding-bottom: 12px"
      >
        <div
          class="indi-product yk-fade"
          v-lazy-container="{ selector: 'div' }"
          v-for="item in this.filterdata"
          :key="item.key"
        >
          <div
            v-if="item.YkgetDiscount == 0"
            class="ftc-product product mb-2 sop-font"
            style="padding-top: 0px !important; box-shadow: none !important"
          >
            <div class="images sop-img">
              <div
                class="yk-hover-title sop-rounded-top text-uppercase text-left g-0"
                style="width: 100% !important"
              >
                <a
                  style="color: #ffe775 !important"
                  :href="host + '/' + item.WithoutspaceShopname"
                >
                  <img
                    :src="host + '/images/logo/thumbs/' + item.ShopName.shop_logo"
                    class="yk-hover-logo float-left"
                  />
                  <span>
                    {{ item.ShopName.shop_name | strlimit(15, "..") }}
                  </span>
                </a>
              </div>

              <span class="fa fa-user yk-viewcount">
                <!--                                                 //you want to use yk_view from laravel eloquent but in vue you must write camelcase-->
                {{ item.YkView }}
              </span>

              <a
                :href="
                  host + '/' + item.WithoutspaceShopname + '/product_detail/' + item.id
                "
              >
                <img v-lazy="imgurl + item.CheckPhoto" class="sop-image-w-h" />
                <!-- <img :src="host + '/images/items/16806830130392.jpg'" class="sop-image-w-h" /> -->
              </a>
            </div>
            <div class="item-description">
              <span class="price">
                <span class="woocommerce-Price-amount amount sop-amount">
                  <bdi v-if="item.price == 0" v-html="item.MmPrice"> </bdi>
                  <bdi v-else v-html="item.MmPrice"> </bdi>
                </span>
              </span>

              <h3 class="product_title product-name">
                <a
                  :href="
                    host + '/' + item.WithoutspaceShopname + '/product_detail/' + item.id
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
            style="padding-top: 0px !important; box-shadow: none !important"
          >
            <a
              :href="
                host + '/' + item.WithoutspaceShopname + '/product_detail/' + item.id
              "
            >
              <div class="sop-ribbon">
                <span>-{{ item.YkgetDiscount.percent }}%</span>
              </div>
            </a>
            <div class="post-img sop-img" style="margin-bottom: 0px !important">
              <div
                class="yk-hover-title text-capitalize text-left g-0"
                style="width: 100% !important"
              >
                <a
                  style="color: #ffe775 !important"
                  :href="host + '/' + item.WithoutspaceShopname"
                >
                  <img
                    :src="host + '/images/logo/thumbs/' + item.ShopName.shop_logo"
                    class="yk-hover-logo float-left"
                  />
                  <span>
                    {{ item.ShopName.shop_name | strlimit(15, "..") }}
                  </span>
                </a>
              </div>
              <span class="fa fa-user yk-viewcount sop-hover-show">
                {{ item.YkView }}
              </span>
              <a
                :href="
                  host + '/' + item.WithoutspaceShopname + '/product_detail/' + item.id
                "
              >
                <img v-lazy="imgurl + item.CheckPhoto" class="sop-image-w-h" />
                <!-- <img :src="host + '/images/items/16806830130392.jpg'" class="sop-image-w-h" /> -->
              </a>
            </div>

            <div class="item-description mt-2">
              <div class="price">
                <span
                  class="woocommerce-Price-amount amount yk-amount"
                  style="color: #780116 !important; font-weight: 600 !important"
                >
                  <bdi v-html="item.YkgetDiscount.MmPrice" style="float: left !important">
                  </bdi>
                </span>
              </div>
            </div>
          </div>
        </div>

        <div
          v-if="this.empty_on_server === 0"
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
export default {
  props: [
    "initialitems",
    "selected_product_quality",
    "search_key",
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
      newdata: "",
      filterdata: "",
      busy: false,
      ini_check: true,
      filterdata_from_server: [],
    };
  },
  beforeMount() {},
  updated() {},
  mounted() {
    this.host = this.$hostname;
    if (process.env.MIX_USE_DO == "true") {
      this.imgurl = process.env.MIX_DO_URL;
    } else {
      this.imgurl = this.$hostname;
    }
    this.filterdata = this.initialitems;
    this.newdata = this.initialitems;
    // this.emptyonserver = this.empty_on_server;

    this.filterdata_from_server[this.search_key] = {
      data: this.filterdata,
      limit: this.filterdata.length,
    };
  },
  watch: {
    initialitems: function (newitems, olditems) {
      this.filterdata = newitems;
      this.busy = false;
      this.filterdata_from_server[this.search_key] = {
        data: this.filterdata,
        limit: this.filterdata.length,
      };
      if (this.filterdata.length == 0) {
        this.shownoitems = true;
      } else {
        this.shownoitems = false;
      }
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
  methods: {
    loadMore: function () {
      this.busy = true;

      let tmp_limit = 0;
      if (this.filterdata_from_server[this.search_key] !== undefined) {
        tmp_limit = this.filterdata_from_server[this.search_key].limit;
      } else {
        tmp_limit = 20;
      }

      axios
        .post(
          this.$hostname + "/catfilter",
          {
            data: this.filterdata,
            filtertype: {
              sort: this.sortby,
              byshop: this.byshop,
              price_range: this.price_range,
              cat_id: this.cat_id,
              gems: this.selected_gems,
              gender: this.gender,
              gold_colour: this.gold_colour,
              gold_quality: this.gold_quality,
              typesearch: this.typesearch,
              additional: this.additional,
              limit: tmp_limit,
              item_id: this.item_id,
              discount: this.discount,
              ini_checked: this.ini_check,
              selected_product_quality: this.selected_product_quality,
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
          if (response.statusText == "OK") {
            if (response.data[0].length > 0) {
              setTimeout(() => {
                let setemptyonserver = async (e) => {
                  // this.emptyonserver = e;
                  this.$emit("forparent", { emptyonserver: e });
                };

                let setbusy = () => {
                  if (this.empty_on_server == 1) {
                    this.busy = true;
                  } else {
                    this.busy = false;
                  }
                  console.log(this.busy);
                };
                let setfilterdata = (d) => {
                  if (this.filterdata_from_server[this.search_key] !== undefined) {
                    d.map((x) =>
                      this.filterdata_from_server[this.search_key].data.push(x)
                    );
                    this.filterdata_from_server[this.search_key].limit += 20;
                    this.filterdata = this.filterdata_from_server[this.search_key].data;
                  } else {
                    this.filterdata_from_server[this.search_key] = {
                      data: d,
                      limit: 20,
                    };
                    this.filterdata = d;
                    console.log(this.filterdata_from_server[this.search_key].limit);
                    //
                  }
                };

                async function tosetdata() {
                  await setemptyonserver(response.data["empty_on_server"]);

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

<style scoped>
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
