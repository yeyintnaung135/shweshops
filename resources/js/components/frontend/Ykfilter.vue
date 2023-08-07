<template>
  <div>
    <div>
      <div class="cart-item">
          <!-- <div class="d-none cart-total d-flex align-items-end sn-search-form">
              <i class="fa-solid fa-search sn-search-placeholder"></i>
              <input
                  class=""
                  type="text"
                  id=""
                  placeholder="Search by typing ..."
                  autocomplete="on"
                  v-model="typesearch"
                  @keyup.enter="searchItems"
              />
              <div
                  class="sn-advanced-search"
                  data-toggle="collapse"
                  href="#collapseSearch"
                  id="filterdropout"
                  aria-expanded="false"
                  aria-controls="collapseSearch"
              >
                  <div>
                      <i class="fa-solid fa-sliders-h"></i
                      ><span>Filter</span>
                  </div>
              </div>
              <button @click="searchItems">Go</button>
          </div> -->

      </div>
      <div class="noselect">
          <div class="d-none collapse sn-collapse" id="collapseSearch">
              <div class="sn-collapse-wrapper row">
                  <div>
                      <h1 class="sn-adv-search-title">Advanced Search</h1>
                  </div>
                  <!-- <div class="d-flex sop-filter form-group justify-content-between"> -->
                  <!-- <div class="col-lg-3 col-md-6 col-12 mb-2">
                      <label class="sn-label" for="">Sorting : </label>
                      <select
                          class="form-control shadow-none sn-dropdown-select"
                          v-model="sortby"
                      >
                          <option value="all" disabled>Randomly</option>
                          <option value="latest">By Latest</option>
                          <option value="price_low_to_high">
                              By Price(low to high)
                          </option>
                          <option value="price_high_to_low">
                              By Price(high to low)
                          </option>
                          <option value="popular">Popular</option>
                          <option
                              v-if="this.discount == 'yes'"
                              value="discountpercent"
                          >
                              Discount Percent
                          </option>
                      </select>
                  </div> -->
                  <!-- <div class="col-lg-3 col-md-6 col-12 mb-2">
                      <label class="sn-label" for=""
                          >Product Type :
                      </label>
                      <select
                          class="form-control shadow-none sn-dropdown-select"
                          v-model="main_product_type"
                          @change="getMainProductType"
                      >
                          <option value="all" selected>All</option>
                          <option value="အဝါရောင်ရွှေ">
                              Gold (ရွှေ)
                          </option>
                          <option value="အဖြူရောင်ရွှေ">
                              Platinum (ပလက်တီနမ်)
                          </option>
                          <option value="၁၂ပဲရည်">18k (၁၂ပဲရည်)</option>
                      </select>
                  </div> -->
                  <!-- <div class="col-lg-3 col-md-6 col-12 mb-2">
                      <div
                          class="d-flex sop-filter form-group justify-content-between"
                      >
                          <div class="col-12">
                              <label class="sn-label" for=""
                                  >Category :
                              </label>
                              <select
                                  class="form-control shadow-none mm_font sn-dropdown-select"
                                  v-model="cat_id"
                              >
                                  <option value="all" selected>
                                      All Categories
                                  </option>

                                  <option
                                      class="mm_font"
                                      v-for="cl in this.notnullcatlist"
                                      :value="cl.category_id"
                                      :key="cl.category_id"
                                  >
                                      {{ cl.mm_name }}
                                  </option>
                              </select>
                          </div>
                      </div>
                  </div> -->
                  <!-- <div class="col-lg-3 col-md-6 col-12 mb-2">
                      <div
                          class="d-flex sop-filter form-group justify-content-between"
                      >
                          <div
                              class="col-12 sn-multiple-selection"
                              v-click-outside="gemsBlur"
                              v-bind:class="{ show: isshow }"
                          >
                              <label class="sn-label" for="gems"
                                  >Included Gems :
                              </label>
                              <label
                                  for="forgems"
                                  @click="snToggleFilter"
                                  class="sn-gemname sn-dropdown-select"
                              >
                                  <span
                                      v-if="
                                          !byspecificgems.includes(
                                              'all'
                                          ) && byspecificgems.length == 1
                                      "
                                      >{{ byspecificgems[0] }}</span
                                  >
                                  <span
                                      v-else-if="
                                          byspecificgems.includes('all')
                                      "
                                      >All</span
                                  >
                                  <span v-else-if="byspecificgems.length"
                                      >{{ byspecificgems.length }} gems
                                      selected</span
                                  >
                                  <span v-else>All</span>
                              </label>

                              <div
                                  class="sn-checkbox-dropdown"
                                  v-bind:class="{
                                      'd-none': hidegemsoption,
                                  }"
                              >
                                  <div class="sn-gem-list">
                                      <input
                                          type="checkbox"
                                          value="all"
                                          id="allgems"
                                          v-model="byspecificgems"
                                          @change="checkAllGems()"
                                      />
                                      <label for="allgems">All</label>
                                  </div>
                                  <div
                                      class="sn-gem-list"
                                      v-for="(gem, index) in this.gems"
                                      :key="index"
                                  >
                                      <input
                                          type="checkbox"
                                          :value="gem"
                                          :id="gem"
                                          v-model="byspecificgems"
                                          @change="uncheckAllGems()"
                                      />
                                      <label :for="gem">{{ gem }}</label>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div> -->
                  <!-- <div class="col-lg-3 col-md-6 col-12 mb-2">
                      <div
                          class="d-flex sop-filter form-group justify-content-between"
                      >
                          <div class="col-12">
                              <label class="sn-label" for=""
                                  >Gender :
                              </label>
                              <select
                                  class="form-control shadow-none sn-dropdown-select"
                                  v-model="gender"
                              >
                                  <option value="all">All</option>
                                  <option value="Kid">Kid</option>
                                  <option value="Men">Men</option>
                                  <option value="Women">Women</option>
                                  <option value="Couple">Couple</option>
                                  <option value="UniSex">Uni Sex</option>
                              </select>
                          </div>
                      </div>
                  </div> -->
                  <!-- <div class="col-lg-3 col-md-6 col-12 mb-2">
                      <label class="sn-label" for="">Discount : </label>
                      <select
                          class="form-control shadow-none sn-dropdown-select"
                          v-model="discount"
                      >
                          <option value="no">All Products</option>
                          <option value="yes">
                              Discount Products Only
                          </option>
                      </select>
                  </div> -->
                  <div class="col-lg-6 col-12 mb-2">
                      <!-- <label for="">{{ to_price }} - {{ from_price }}</label> -->
                      <!-- <div
                          class="sn-price-range d-flex justify-content-center align-items-center"
                      >
                          <div
                              class="sn-from-price mm_font"
                              v-click-outside="fromPriceBoxBlur"
                          >
                              <span
                                  class="sn-price-error"
                                  v-if="error_message"
                                  >Invalid Price Range</span
                              >
                              <label class="sn-label" for=""
                                  >Price (From) :
                              </label>
                              <input
                                  type="number"
                                  class="mm_font sn-dropdown-select"
                                  min="0"
                                  v-model="from_price"
                                  placeholder="စျေးနှုန်း (မှ)"
                                  @click="
                                      togglepriceoptionshow(
                                          $event,
                                          'from'
                                      )
                                  "
                                  @input="snPriceCheck"
                                  v-bind:class="{
                                      price_error: error_message,
                                  }"
                              />
                              <div
                                  class="sn-price-list form-control shadow-none position-absolute p-0"
                                  v-bind:class="{
                                      'd-none': hidefrompriceoption,
                                  }"
                              >
                                  <div
                                      yk-value="50000"
                                      @click="
                                          getfrompricedata($event, 'from')
                                      "
                                  >
                                      ၅ သောင်း
                                  </div>
                                  <div
                                      yk-value="100000"
                                      @click="
                                          getfrompricedata($event, 'from')
                                      "
                                  >
                                      ၁ သိန်း
                                  </div>
                                  <div
                                      yk-value="500000"
                                      @click="
                                          getfrompricedata($event, 'from')
                                      "
                                  >
                                      ၅ သိန်း
                                  </div>
                                  <div
                                      yk-value="1000000"
                                      @click="
                                          getfrompricedata($event, 'from')
                                      "
                                  >
                                      ၁၀ သိန်း
                                  </div>
                                  <div
                                      yk-value="5000000"
                                      @click="
                                          getfrompricedata($event, 'from')
                                      "
                                  >
                                      သိန်း ၅၀
                                  </div>
                                  <div
                                      yk-value="10000000"
                                      @click="
                                          getfrompricedata($event, 'from')
                                      "
                                  >
                                      သိန်း ၁၀၀
                                  </div>
                                  <div
                                      yk-value="50000000"
                                      @click="
                                          getfrompricedata($event, 'from')
                                      "
                                  >
                                      သိန်း ၅၀၀
                                  </div>
                              </div>
                              <div class="arrow"></div>
                          </div>
                          <div
                              class="sn-to-price"
                              v-click-outside="toPriceBoxBlur"
                          >
                              <label class="sn-label" for=""
                                  >Price (To) :
                              </label>
                              <input
                                  type="number"
                                  min="0"
                                  class="sn-dropdown-select"
                                  v-model="to_price"
                                  placeholder="စျေးနှုန်း (အထိ)"
                                  @click="
                                      togglepriceoptionshow($event, 'to')
                                  "
                                  @input="snPriceCheck"
                              />
                              <div
                                  class="sn-price-list form-control shadow-none position-absolute p-0"
                                  v-bind:class="{
                                      'd-none': hidetopriceoption,
                                  }"
                              >
                                  <div
                                      yk-value="50000"
                                      @click="
                                          getfrompricedata($event, 'to')
                                      "
                                  >
                                      ၅ သောင်း
                                  </div>
                                  <div
                                      yk-value="100000"
                                      @click="
                                          getfrompricedata($event, 'to')
                                      "
                                  >
                                      ၁ သိန်း
                                  </div>
                                  <div
                                      yk-value="500000"
                                      @click="
                                          getfrompricedata($event, 'to')
                                      "
                                  >
                                      ၅ သိန်း
                                  </div>
                                  <div
                                      yk-value="1000000"
                                      @click="
                                          getfrompricedata($event, 'to')
                                      "
                                  >
                                      ၁၀ သိန်း
                                  </div>
                                  <div
                                      yk-value="5000000"
                                      @click="
                                          getfrompricedata($event, 'to')
                                      "
                                  >
                                      သိန်း ၅၀
                                  </div>
                                  <div
                                      yk-value="10000000"
                                      @click="
                                          getfrompricedata($event, 'to')
                                      "
                                  >
                                      သိန်း ၁၀၀
                                  </div>
                                  <div
                                      yk-value="50000000"
                                      @click="
                                          getfrompricedata($event, 'to')
                                      "
                                  >
                                      သိန်း ၅၀၀
                                  </div>
                              </div>
                              <div class="arrow"></div>
                          </div>
                      </div> -->
                  </div>
                  <!-- <div><button class="sn-adv-search-btn" data-toggle="collapse" href="#collapseSearch" aria-expanded="false" aria-controls="collapseSearch">Search</button></div> -->
              </div>
          </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import $ from "jquery";
import Slick from 'vue-slick';

export default {
    props: [
        "fdata",
        "for_child_typesearch",
        "for_child_cat_id",
        "for_child_sort",
        "for_child_discount",
        "shop_ids",
        "selected_shop",
        "selected_gems",
        "additional_child",
        "for_child_item_id",
        "for_child_cat_list",
        "for_child_filterdata_from_server",
        "searchtext",
    ],
    name: "Ykfilter",
    components: { Slick },
    data: function () {
        return {
            // state:'1',
            // typesearch: "",
            // sortby: "all",
            // notnullcatlist: "",
            // byshop: [],
            // discount: "no",
            // byspecificshop: [],
            // hidefrompriceoption: true,
            // hidetopriceoption: true,
            // hidegemsoption: true,
            // price_range: "all",
            // newfilterdata: "",
            // tempbyshopname: "",
            ini_data: "",
            // states:'',
            // cat_id: "",
            // search_result_shops: "",
            // search_key: "",
            item_child_id: "empty",
            // isshow: false,
            // to_price: "",
            // from_price: "",
            // error_message: false,
            // host: "",
            search: "",
            // gender: "all",
            // searchBuffer: [],
            // bygems: [],
            // byspecificgems: [],
            // main_product_type: "all",
            // gold_colour: "all",
            // gold_quality: "all",
            // gems: [
            //     "Diamond စိန်",
            //     "Ruby ပတ္တမြား",
            //     "Jade ကျောက်စိမ်း",
            //     "Emerald မြ",
            //     "Sapphire နီလာ",
            //     "Morganite မြပန်းရောင်",
            //     "Spinel အညံ့ပန်း",
            //     "Topaz ဥသ၁ဖယား/ ထပ်တရာ",
            //     "Zircon ဂေါ်မိတ်",
            //     "Bloodstone သွေးကျောက်",
            //     "Coral သန္တာကျောက်",
            //     "Oryx မဟူရာ",
            //     "Turquoise စိမ်းပြာကျောက်",
            //     "Beryl မြကျောက်",
            //     "Garnet ဥဒေါင်",
            //     "Moonstone လကျောက်",
            //     "Rose quartz ပန်းရောင်သလင်းကျောက်",
            //     "Aquamarine မြပြာ",
            //     "Amethyst ခရမ်းစွဲ",
            //     "Sodalite ကျောက်မျက်",
            //     "Tourmaline ဖရဲအူ",
            //     "Peridot ပြောင်ခေါင်းစိမ်း",
            //     "Blue Star",
            //     "Agate သဘော်မဟူရာ",
            //     "စလင်းဝါ",
            //     "blue topaz",
            //     "Cat's Eye",
            //     "Pearl ပုလဲ",
            // ],
            // inputval: "",
            // advanced_search: false,
            // input_active: false,
            // shop_label: '',
            // shoplist: [],
            // settings: {
            //   "dots": false,
            //   "infinite": false,
            //   "speed": 500,
            //   "slidesToShow": 10,
            //   "slidesToScroll": 8,
            //   "arrows": false,
            //   "responsive": [
            //     {
            //       "breakpoint": 1024,
            //       "settings": {
            //         "slidesToShow": 10,
            //         "slidesToScroll": 8
            //       }
            //     },
            //     {
            //       "breakpoint": 600,
            //       "settings": {
            //         "slidesToShow": 5,
            //         "slidesToScroll": 5
            //       }
            //     },
            //     {
            //       "breakpoint": 480,
            //       "settings": {
            //         "slidesToShow": 3.5,
            //         "slidesToScroll": 3
            //       }
            //     }
            //   ]
            // }
        };
    },
    mounted() {
        // this.sortby = this.for_child_sort;

        // this.notnullcatlist = this.for_child_cat_list.filter(
        //     (f) => f.category_id != null
        // );
        //for discount only item
        // if (this.for_child_discount != undefined) {
        //     this.discount = this.for_child_discount;
        // } else {
        //     this.discount = "no";
        // }
        //for discount only item
        
        // this.byshop.push(this.selected_shop);
        // this.byspecificshop.push(this.selected_shop);
        // this.bygems = this.selected_gems;
        if (
            this.price_range == "all" &&
            this.byshop.includes("all") &&
            this.sortby == "all" &&
            this.cat_id == "all" &&
            this.bygems.includes("all") &&
            this.gender == "all"
        ) {
            this.ini_data = this.fdata;
        }
        this.cat_id = this.for_child_cat_id;
        if (this.for_child_item_id != undefined) {
            this.item_child_id = this.for_child_item_id;
        }

        //pass current categories to parent

        // this.search_key =
        //     this.item_child_id +
        //     this.sortby +
        //     this.typesearch +
        //     this.byshop +
        //     this.price_range +
        //     this.cat_id +
        //     this.additional_child +
        //     this.discount;
        //pass current categories to parent
        // document.getElementById("allgems").checked = true;
        // if (this.for_child_typesearch != undefined) {
        //     this.typesearch = this.for_child_typesearch;
        //     // this.inputval = this.for_child_typesearch;
        //     this.getdatafromserver_bysort();
        // }
    },
    // watch: {
    //     discount: function (val) {
    //         if (val == "no") {
    //             this.sortby = "all";
    //         }
    //         // this.getdatafromserver_bysort();
    //     },
    // },
    methods: {
        // searchSubmit: function (event) {
        //     event.preventDefault();
        //     return location.assign(
        //         this.host + "/ajax_search_result/" + this.inputval
        //     );
        // },
        // advancedSearchClick: function (event) {
        //     console.log(
        //         "event test",
        //         event.currentTarget.getAttribute("aria-expanded")
        //     );
        //     console.log(this.input_active);
        //     if (
        //         event.currentTarget.getAttribute("aria-expanded") &&
        //         this.input_active
        //     ) {
        //         this.advanced_search = false;
        //         this.input_active = false;
        //     } else {
        //         this.advanced_search = !this.advanced_search;
        //     }
        // },
        // advancedGoClick: function () {
        //     this.advanced_search = false;
        //     this.input_active = false;
        // },
        // focusSearchInput: function () {
        //     this.advanced_search = false;
        //     this.input_active = true;
        // },
        // focusAdvancedSearch: function () {
        //     this.advanced_search = true;
        // },
        // togglepriceoptionshow: function ($event, p) {
        //     console.log(p);
        //     if (p == "from") {
        //         this.hidefrompriceoption = !this.hidefrompriceoption;
        //         this.hidetopriceoption = true;
        //     } else if (p == "to") {
        //         this.hidetopriceoption = !this.hidetopriceoption;
        //         this.hidefrompriceoption = true;
        //     }
        // },
        // getfrompricedata: function ($event, p) {
        //     console.log(p, $event.target.getAttribute("yk-value"));
        //     this.hidefrompriceoption = false;
        //     this.hidetopriceoption = false;

        //     if (p == "from") {
        //         this.from_price = $event.target.getAttribute("yk-value");
        //         this.hidefrompriceoption = true;
        //         this.hidetopriceoption = true;
        //     } else if (p == "to") {
        //         this.to_price = $event.target.getAttribute("yk-value");
        //         this.hidetopriceoption = true;
        //         this.hidefrompriceoption = true;
        //     }
        //     if (this.to_price != "") {
        //         this.snPriceCheck();
        //     }
        // },
        // checkAllGems: function () {
        //     for (var i = 0; i < this.byspecificgems.length; i++) {
        //         if (this.byspecificgems[i] == "all") continue;
        //         document.getElementById(this.byspecificgems[i]).checked = false;
        //     }
        //     document.getElementById("allgems").checked = true;
        //     this.byspecificgems = ["all"];
        //     this.checkSelectedGems();
        // },
        // uncheckAllGems: function () {
        //     document.getElementById("allgems").checked = false;
        //     var myIndex = this.byspecificgems.indexOf("all");
        //     if (myIndex !== -1) {
        //         this.byspecificgems.splice(myIndex, 1);
        //     }
        //     this.checkSelectedGems();
        // },
        // checkSelectedGems: function () {
        //     this.bygems = this.byspecificgems;
        //     // this.getdatafromserver_bysort();
        // },
        // getMainProductType: function () {
        //     if (this.main_product_type == "all") {
        //         this.gold_quality = "all";
        //         this.gold_colour = "all";
        //     } else if (this.main_product_type == "၁၂ပဲရည်") {
        //         this.gold_quality = this.main_product_type;
        //         this.gold_colour = "all";
        //     } else {
        //         this.gold_colour = this.main_product_type;
        //         this.gold_quality = "all";
        //     }
        //     // this.getdatafromserver_bysort();
        // },
        // searchItems: function () {
        //     if (
        //         document
        //             .getElementById("filterdropout")
        //             .getAttribute("aria-expanded") == "true"
        //     ) {
        //         document.getElementById("filterdropout").click();
        //     }
        //     this.getdatafromserver_bysort();
        // },
       
        getdatafromserver_bysort: function () {
            // console.log(this.for_child_filterdata_from_server);
            console.log("type search", this.typesearch);
            this.search_key =
                this.item_child_id +
                this.sortby +
                this.typesearch +
                this.byshop +
                this.gender +
                this.bygems +
                this.gold_colour +
                this.gold_quality +
                this.price_range +
                this.cat_id +
                this.additional_child +
                this.discount;
            let tmp_limit = 0;
            if (
                this.for_child_filterdata_from_server[this.search_key] !==
                undefined
            ) {
                tmp_limit =
                    this.for_child_filterdata_from_server[this.search_key]
                        .limit;
            } else {
                tmp_limit = 0;
            }
            // if (this.price_range == 'all' && this.byshop.includes('all') && this.sortby == 'all' && this.cat_id == 'all') {
            //     this.$emit('forparent', {'newfilterdata': this.ini_data});

            // } else {
            //for similar
            if (this.price_range != "all") {
                this.item_child_id = "empty";
            }
            // var self = this;
            axios
                .post(
                    this.$hostname + "/catfilter",
                    {
                        data: this.fdata,
                        filtertype: {
                            item_id: this.item_child_id,
                            sort: this.sortby,
                            typesearch: this.typesearch,
                            byshop: this.byshop,
                            price_range: this.price_range,
                            cat_id: this.cat_id,
                            gender: this.gender,
                            gems: this.bygems,
                            gold_colour: this.gold_colour,
                            gold_quality: this.gold_quality,
                            additional: this.additional_child,
                            ini_checked: false,
                            discount: this.discount,
                            limit: tmp_limit,
                        },
                    },
                    {
                        header: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                )
                .then((response) => {
                    this.$emit("forparent", {
                        newfilterdata: response.data[0],
                        empty_on_server: response.data.empty_on_server,
                        search_key: this.search_key,
                        typesearch: this.typesearch,
                    });
                    console.log("byshop response", this.byshop);
                });

            // }
        },

        // snToggleFilter: function () {
        //     this.hidegemsoption = !this.hidegemsoption;
        //     this.isshow = !this.isshow;
        // },

        // // snHideFilter: function () {
        // //     this.isshow = false;
        // // },
        // // snPriceCheck: function () {
        // //     if (
        // //         this.to_price != "" &&
        // //         parseInt(this.from_price) > parseInt(this.to_price)
        // //     ) {
        // //         this.error_message = true;
        // //     } else if (this.from_price != "" && this.to_price != "") {
        // //         this.error_message = false;
        // //         this.price_range = this.from_price + "-" + this.to_price;
        // //         // this.getdatafromserver_bysort();
        // //     } else if (this.to_price == "" && this.from_price == "") {
        // //         this.price_range = "all";
        // //         // this.getdatafromserver_bysort();
        // //     }
        // //     //  else {
        // //     //     this.price_range = "all";
        // //     //     this.getdatafromserver_bysort();
        // //     // }
        // // },
        // // fromPriceBoxBlur: function () {
        // //     this.hidefrompriceoption = true;
        // // },
        // // toPriceBoxBlur: function () {
        // //     this.hidetopriceoption = true;
        // // },
        // gemsBlur: function () {
        //     this.hidegemsoption = true;
        //     this.isshow = false;
        // },
    },
};
</script>

<style scoped>

.sop-allshop {
    border: solid 2px black;
    border-radius: 50%;
    opacity: 1;
    min-height: 100px;
    min-width: 100px;
}

input[type="checkbox"] {
    display: none;
}

:checked + label img {
    transform: scale(0.95);
    box-shadow: 0 0 5px #333;
    border: solid 4px #780116;
    opacity: 1;
    z-index: -1;
}

:checked + label .sop-allshop {
    transform: scale(0.95);
    box-shadow: 0 0 5px #333;
    border: solid 4px #780116;
    opacity: 1;
    z-index: -1;
}

label img {
    opacity: 0.9;
}

.post-wrapper {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.sop-filter-search {
    border: 1px solid #e5e5e5;
    border-left: 0;
    background-color: #780116;
    color: white;
    border-radius: 0 5px 5px 0;
}

.hide {
    display: none;
    width: 0;
    height: 0;
}

dropdown{
   display: inline-block;
   /* margin: 20px 50px; */
   position: relative;
}
dropdown label, dropdown ul li{
  display: block;
  width: 200px;
  background: #ECF0F1;
  padding: 15px 10px;
}

dropdown label{
  position: relative;
  z-index: 2;
}
dropdown input{
  display: none;
}
dropdown input ~ ul{
  visibility: hidden;
  opacity: 0;
  top: 0px;
  z-index: 1;
  position: absolute;
  
}

dropdown input:checked ~ ul{
  visibility: visible;
  opacity: 1;
  top: 60px;
  z-index: 9999;
}

.animate{
  -webkit-transition: all .3s;
  -moz-transition: all .3s;
  -ms-transition: all .3s;
  -ms-transition: all .3s;
  transition: all .3s;  
  backface-visibility:hidden;
  -webkit-backface-visibility:hidden; /* Chrome and Safari */
  -moz-backface-visibility:hidden; /* Firefox */
  -ms-backface-visibility:hidden; /* Internet Explorer */
}

@media only screen and (max-width: 576px) {
    :checked + label .sop-allshop .allshop-h1 {
        transform: scale(0.9);
    }

    .sop-textsmall {
        font-size: 0.8rem;
    }
}

@media only screen and (max-width: 376px) {
    :checked + label .sop-allshop .allshop-h1 {
        transform: scale(0.8);
    }

    .allshop-h1 {
        transform: scale(0.9);
    }
}
</style>
