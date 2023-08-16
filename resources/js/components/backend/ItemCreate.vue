<template>
 <div>
 <ykdropzone :link="this.link" :catlist="this.catlist" :main_cat="this.main_cat" :percenttemplate="this.percenttemplate">
 </ykdropzone>
 </div>
</template>

<script>

import YkDropzone from "./YkDropzone.vue";
import Ykweight from "./Ykweight";
import pricelogicsn from "./pricelogin/pricelogic";

import Multiselect from "vue-multiselect-with-duplicates";

export default {
  // register globally
  props: [
    "link",
    "somedatafromshop",
    "collection",
    "worldgoldprice",
    "catlist",
    "percenttemplate",
    "main_cat",
  ],
  name: "ItemCreate",
  

  components: {
    ykdropzone: YkDropzone,
    multi: Multiselect,
    Ykweight: Ykweight,
  },
  methods: {
    // ရောင်း / ဝယ် / လဲ ရာခိုင်နှုန်း
    percenttemplateChange($event) {
      this.percenttemplate.forEach((percenttemplate) => {
        if (percenttemplate.id == this.percenttemplate_id) {
          this.undamaged_product = percenttemplate.undamaged_product;
          this.damaged_product = percenttemplate.damaged_product;
          this.valuable_product = percenttemplate.valuable_product;
          return;
        }
      });
    },
    inputHandler(selectedOption, id) {
      this.gems.push(selectedOption);
    },
    //id is index change in core vue multiselect in node_module (!important)
    removeHandler(removedOption, id) {
      // this.gems.splice(id, 1);
    },

    // // sopend

    // SN Price Number to Word
    priceToWordLogic: function (price, info) {
      const res = pricelogicsn(price);
      if (info == "exact") {
        this.snprice_to_word_exact = res;
      } else if (info == "min") {
        this.snprice_to_word_min = res;
      } else {
        this.snprice_to_word_max = res;
      }
    },
    // End of SN Price Number to Word

    forrequire: function (data, model) {
      if (data == true && (model == "" || model == 0)) {
        return true;
      }
    },
    forrequirephoto: function (data, model) {
      if (data == true && model < 3) {
        return true;
      }
    },

    stockchange() {
      if (this.stock == "Out Of Stock") {
        this.stock_count = 0;
      }
    },

    //when user change price exact or min max
    changeprice() {
      if (this.exceptorrates == "Range") {
        this.price = 0;
      } else {
        this.min_price = 0;
        this.max_price = 0;
        this.domInWords(this.price, "price_word");
      }
    },
  },
};
</script>

<style>
.select2.select2-container {
  width: 100% !important;
}

.color-danger {
  color: red !important;
}
</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
