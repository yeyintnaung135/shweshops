<template>
    <div
      v-infinite-scroll="loadShopsMore"
      infinite-scroll-disabled="busy"
      infinite-scroll-distance="10"
      class="site-content mt-md-4 sn-shop-list"
    >
      <slick
        ref="shopslick"
        :options="slickOptions"
      >
        <div class="all_nav shop-item" :class="{ shop_active: this.activeItem == 'all' }">
            <a class="shop-link" id="all" @click.prevent="setActive('all')">အားလုံး</a>
        </div>
        <div class="shop-item popular_nav" :class="{ shop_active: this.activeItem == 'popular' }">
            <a class="shop-link" id="popular" @click.prevent="setActive('popular')">လူကြိုက်များသောဆိုင်များ</a>
        </div>
        <div class="premium_nav shop-item" :class="{ shop_active: this.activeItem == 'premium' }">
            <a class="shop-link" id="premium" @click.prevent="setActive('premium')">Premium</a>
        </div>
      </slick>
    
      <div
          class="products default loading row g-2 g-md-3"
          style="padding-bottom: 12px"
      >
          <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="col-5">
                  <label
                      class="mb-0"
                      style="
                          text-align: left;
                          font-size: 1.2rem;
                          color: #780116 !important;
                      "
                      >ဆိုင်များရွေးရန်</label
                  >
              </div>
              <div class="d-flex align-items-center position-relative sn-shop-search">
                <input
                    type="text"
                    v-model="search"
                    placeholder="ဆိုင်အမည်"
                    id="sop-filter-search"
                    @input="getShopsbyFilter"
                />
                <i class="fas fa-search px-3"></i>
              </div>
          </div>
          <div
              class="col-6 col-sm-4 col-md-3 col-lg-3 yk-fade mb-3 p-0"
              v-for="d in this.shops"
              v-bind:key="d.id"
          >
              <div
                  class="ftc-product product mb-1"
                  style="box-shadow: none !important; width: 100%;"
              >
                <div class="images post-img sop-img shop-img position-relative pt-1">
                  <div v-if="d.premium=='yes'">
                    <a :href="'/' +d.shop_name_url">
                      <img  class="kanok-frame"
                        :src="host + '/images/directory/banner/Frame 925.png'"
                      />
                    </a>
                  </div>
                  <a :href="'/' +d.shop_name_url">
                      <img
                          :src="'images/logo/mid/' + d.shop_logo"
                          class="sn-image-w-h sn-shop-image"
                      />
                  </a>
                </div>
              </div>
              <div class="post-info px-2">
                  <header class="entry-header">
                      <!-- Blog Title -->
                      <h3 class="yk-product-title multiline-truncate">
                          <a
                              class="sop-font-content mt-2"
                              style="font-family: sans-serif !important"
                              :href="
                                  host +
                                  '/' +
                                  d.shop_name_url

                              "
                              >{{ d.shop_name }}</a
                          >
                      </h3>

                      <span class="vcard author" style=""></span>
                      <!-- Blog Categories -->
                  </header>

                  <div class="clear"></div>
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
</template>

<script>
import axios from "axios";
import Slick from 'vue-slick';

export default {
    props: ["latest_shops","default"],
    components: {
      Slick
    },
    name: "ShopsComponent",
    data: function () {
        return {
            shops: "",
            host: "",
            hostname: "",
            shoplimit: 0,
            emptyonserver: 0,
            busy: false,
            togglespin: false,
            clickloadmorecount: 0,
            search: "",
            activeItem: 'all',
            premium: '',
            isPopular: '',
            slickOptions: {
              slidesToShow: 6,
              infinite: false,
              arrows: false,
              responsive: [
                {
                  "breakpoint": 1024,
                  "settings": {
                    "slidesToShow": 6,
                  }
                },
                {
                  "breakpoint": 767,
                  "settings": {
                    "slidesToShow": 3,
                  }
                },
                {
                  "breakpoint": 480,
                  "settings": {
                    "slidesToShow": 2,
                  }
                },
              ]
            }

        };
    },

    mounted() {
        this.host = this.$hostname;
        this.shops = this.latest_shops;
        this.activeItem = this.default;
        this.shoplimit = this.shops.length;

        if(this.activeItem == 'all') {
          this.premium = '';
          this.isPopular = '';
        } else if (this.activeItem == 'popular') {
          this.premium = '';
          this.isPopular = 'yes';
        } else if (this.activeItem == 'premium') {
          this.isPopular = '';
          this.premium = 'yes';
        }
    },
    beforeUpdate() {
      if (this.$refs.shopslick) {
        this.$refs.shopslick.destroy();
      }
    },
    updated() {
      this.$nextTick(function () {
        if (this.$refs.shopslick) {
          this.$refs.shopslick.create(this.slickOptions);
        }
      });
    },

    computed: {
        // filteredList() {
        //     return Object.values(this.shops).filter((shop) => {
        //         return shop.shop_name
        //             .toLowerCase()
        //             .includes(this.search.toLowerCase());
        //     });
        // },
    },
    filters: {},
    methods: {
      setActive(type) {
        this.activeItem = type;
        if(type == 'all') {
          this.premium = '';
          this.isPopular = '';
        } else if (type == 'popular') {
          this.premium = '';
          this.isPopular = 'yes';
        } else if (type == 'premium') {
          this.isPopular = '';
          this.premium = 'yes';
        }
        this.getShopsbyFilter();
      },
      getShopsbyFilter() {
        axios
          .post(
            this.host + "/get_shops_byfilter",
            {
              filtertype: {
                shopname: this.search,
                shoplimit: 0,
                premium: this.premium,
                isPopular: this.isPopular,
              },
            },
            {
              header: {
                "Content-Type": "multipart/form-data",
              },
            }
          )
          .then((response) => {
            this.shops = response.data.shops;

            if (response.data['empty_on_server'] == 1) {
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
            this.host + "/get_shops_byfilter",
            {
              filtertype: {
                shopname: this.search,
                shoplimit: this.shoplimit,
                premium: this.premium,
                isPopular: this.isPopular,
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
                  this.shoplimit += response.data['count'];
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
                    response.data['empty_on_server']
                  );
                  await setfilterdata(response.data['shops']);
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

<style>
.kanok-frame {
  position: absolute;
  top: 2px;
  z-index: 9;
  width: 98% !important;
  height: 102% !important;
  left: 4px !important;
  object-fit: fill;
}

.shop_active {
  background: #780116;
}
.shop_active .shop-link {
  color: #fff !important;
}
.shop-item {
  text-align: center;
  padding: 5px 10px;
  border-radius: 50px;
  border: 1px solid #780116;
}
.shop-link {
  padding: 5px;
}
.sn-shop-search {

}
.sn-shop-search input {
  border: 0 !important;
  border-bottom: 1px solid #ccc !important;
  padding-left: 0 !important;
}
.sn-shop-search i {
  position: absolute;
  right: 0;
  color: #ccc;
}
.kanok-frame {
  position: absolute;
  top: 0;
  z-index: 9;
  width: 100%;
  left: 1px;
}
.kanok-frame img:hover {
  opacity: 1 !important;
}
.yk-fade {
    -webkit-animation: fade 2s;
    -moz-animation: fade 2s;
    -o-animation: fade 2s;
    -ms-transition: fade 2s;
    animation: fade 2s;
}
.sop-filter-search {
    border: 1px solid #780116;
    border-left: 0;
    background-color: #780116;
    color: white;
    border-radius: 0 5px 5px 0;
    padding: 0rem 1rem 0 0rem;
}
input[type="text"],
input[type="email"],
input[type="url"],
input[type="password"],
input[type="search"],
input[type="number"],
input[type="tel"],
input[type="range"],
input[type="date"],
input[type="month"],
input[type="week"],
input[type="time"],
input[type="datetime"],
input[type="datetime-local"],
input[type="color"],
textarea {
    color: #666;
    filter: none !important;
    border-radius: 0;
    -moz-border-radius: 0;
    -webkit-border-radius: 0;
    display: inline-block;
    border: 1px solid #e5e5e5;
    background: #fff;
    padding: 11px 15px;
    margin: 0;
    width: 100%;
    border-radius: 0;
    -moz-border-radius: 0;
    -webkit-border-radius: 0;
    text-align: left;
    width: 100%;
    box-shadow: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
}
.sn-shop-list .slick-initialized .slick-slide {
  width: auto !important;
  margin-right: 13px;
}
.sn-shop-list .slick-slider {
  margin: 0px 0 30px;
}


@media only screen and (max-width: 576px) {
    .sop-filter-search {
        width: 50px;
    }
    input[type="text"],
    input[type="email"],
    input[type="url"],
    input[type="password"],
    input[type="search"],
    input[type="number"],
    input[type="tel"],
    input[type="range"],
    input[type="date"],
    input[type="month"],
    input[type="week"],
    input[type="time"],
    input[type="datetime"],
    input[type="datetime-local"],
    input[type="color"],
    textarea {
        padding: 5px 10px;
    }

    .kanok-frame {
      position: absolute;
      top: 2px;
      z-index: 9;
      width: 97% !important;
      height: 99% !important;
      left: 2px !important;
      object-fit: fill;
    }

    .multiline-truncate{
      white-space: nowrap;     
      overflow: hidden;        
      text-overflow: ellipsis; 
      max-height: 400px;
    }
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
