<template>
  <div class="site-content">
    <div>
      <a
        class="message-post"
        style="border-top-left-radius: 7px; border-top-right-radius: 7px"
        :href="
          host +
          '/' +
          this.itemdata.WithoutspaceShopname +
          '/product_detail/' +
          this.itemdata.id
        "
      >
        <!-- <img :src="host +'/images/items/mid/'+this.item.default_photo != '' ? this.item.default_photo : this.item.photo_one"> -->
        <img
          style="
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            max-width: 100% !important;
          "
          :src="imgurl + this.itemdata.CheckPhoto"
        />
        <div class="post-info-msg">
          <div class="product" style="font-size: 17px">Product Code</div>
          <div style="margin-bottom: 15px; font-size: 15px">
            {{ this.itemdata.product_code }}
          </div>
          <div v-if="this.itemdata.YkgetDiscount === 0">
            <div v-if="this.itemdata.price == 0">
              <div class="price" style="font-size: 17px">Price 0</div>
              <div style="margin-bottom: 15px; font-size: 15px">
                {{ this.itemdata.min_price | pricewithcomma() }} မှ
                {{ this.itemdata.max_price | pricewithcomma() }} ကြား
              </div>
            </div>
            <div v-else>
              <div class="price" style="font-size: 17px">Price 1</div>
              <div style="margin-bottom: 15px; font-size: 15px">
                {{ this.itemdata.price | pricewithcomma() }}
              </div>
            </div>
          </div>
          <div v-else>
          <div v-if="this.itemdata.YkgetDiscount !== undefined">
            <div v-if="this.itemdata.YkgetDiscount.discount_price === undefined">
              <div class="price" style="font-size: 17px">Price 2</div>
              <div style="margin-bottom: 15px; font-size: 15px">
                {{ this.itemdata.YkgetDiscount.discount_min | pricewithcomma() }} မှ
                {{ this.itemdata.YkgetDiscount.discount_max | pricewithcomma() }} ကြား
              </div>
            </div>
            <div v-else>
              <div class="price" style="font-size: 17px">Price 3</div>
              <div style="margin-bottom: 15px; font-size: 15px">
                {{ this.itemdata.YkgetDiscount.discount_price | pricewithcomma() }}
              </div>
            </div>
          </div></div>
        </div>
      </a>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { allfromcommonservice } from "../../commonfunction/commonservice";

export default {
  props: [
    // "item"
    "itemdatapar",
    "shopurl",
    "hostpar",
  ],
  name: "PostComponent",
  data: function () {
    return {
      host: "",
      itemdata: "",
      default_photo: "",
      imgurl:"",
    };
  },
  created() {},
  mounted() {
    this.host = this.hostpar;
    if (process.env.MIX_USE_DO == "true") {
      this.imgurl = process.env.MIX_DO_URL;
    } else {
      this.imgurl = this.hostpar+'/images';
    }
    this.parsepostdata();
  },

  filters: {
    pricewithcomma: function (number) {
      console.log("number", number);
      return allfromcommonservice.pricewithcomma(number);
    },
  },

  methods: {
    parsepostdata: function () {
      this.itemdata = JSON.parse(this.itemdatapar);
    },
  },
};
</script>

<style scoped>
.message-post {
  display: block;
  border: 1px solid #d3d3d3;
  box-shadow: 0px 0px 5px -1px #c7c7c7;
}

.post-info-msg {
  padding: 5px;
  background: #730d18;
  color: white;
}
</style>
