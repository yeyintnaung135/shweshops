<template>
  <section class="content">
      <div class="container-fluid sn-item-container">
          <!-- SELECT2 EXAMPLE -->
          <div class="sn-item-create-wrapper">
              <div class="">
                  <h3 class="">Create Your Item</h3>
              </div>

              <div>
                  <div class="">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label
                                  >Item Name
                                      <span
                                          v-if="this.name == ''"
                                          class="sn-required-asterick"
                                      >*</span
                                      ></label
                                  >
                                  <input
                                      type="text"
                                      class="form-control"
                                     
                                      v-model="name"
                                      placeholder="Enter name"
                                  />
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label
                                  >Product Code
                                      <span
                                          v-if="this.product_code == 0"
                                          class="sn-required-asterick"
                                      >*</span
                                      ></label
                                  >
                                  <input
                                      type="text"
                                     
                                      class="form-control"
                                      v-model="product_code"
                                      placeholder="Enter Product Code"
                                  />
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Main Category</label>
                                  <select
                                      class="form-control"
                                     
                                      name="main_category"
                                      v-model="main_category"
                                      style="width: 100%"
                                  >
                                      <option
                                          v-for="cat in main_cat"
                                          :value="cat.id"
                                          :key="cat.id"
                                      >
                                          {{ cat.name }}
                                      </option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Gold Colour</label>
                                  <select
                                      class="form-control select2"
                                      name="gold_colour"
                                     
                                      style="width: 100%"
                                  >
                                      <option value="အဝါရောင်ရွှေ" selected>
                                          အဝါရောင်ရွှေ
                                      </option>
                                      <option value="အဖြူရောင်ရွှေ">
                                          အဖြူရောင်ရွှေ
                                      </option>
                                      <option value="ပန်းရောင်ရွှေ">
                                          ပန်းရောင်ရွှေ
                                      </option>
                                      <option value="နှစ်ရောင်စပ်ရွှေ">
                                          နှစ်ရောင်စပ်ရွှေ
                                      </option>
                                      <option value="သုံးရောင်စပ်ရွှေ">
                                          သုံးရောင်စပ်ရွှေ
                                      </option>
                                  </select>
                              </div>
                          </div>

                          <!-- /.col -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Gold Quality</label>
                                  <select
                                      class="form-control select2"
                                      name="gold_quality"
                                      style="width: 100%"
                                  >
                                      <option value="24K ၁၆ပဲရည်" selected>
                                          24K ၁၆ပဲရည်
                                      </option>
                                      <option value="23K ၁၅ပဲရည်">
                                          23K ၁၅ပဲရည်
                                      </option>
                                      <option value="22K ၁၄ပဲ ၂ပြားရည်">
                                          22K ၁၄ပဲ ၂ပြားရည်
                                      </option>
                                      <option value="21K ၁၄ပဲရည်">
                                          21K ၁၄ပဲရည်
                                      </option>
                                      <option value="20K ၁၃ပဲရည်">
                                          20K ၁၃ပဲရည်
                                      </option>
                                      <option value="19K ၁၂ပဲ ၂ပြားရည်">
                                          19K ၁၂ပဲ ၂ပြားရည်
                                      </option>
                                      <option value="18K ၁၂ပဲရည်">
                                          18K ၁၂ပဲရည်
                                      </option>
                                      <option value="17K ၁၁ပဲ ၂ပြားရည်">
                                          17K ၁၁ပဲ ၂ပြားရည်
                                      </option>
                                      <option value="16K ၁၁ပဲရည်">
                                          16K ၁၁ပဲရည်
                                      </option>
                                      <option value="15K ၁၀ပဲရည်">
                                          15K ၁၀ပဲရည်
                                      </option>
                                      <option value="14K ၉ပဲရည်">
                                          14K ၉ပဲရည်
                                      </option>
                                      <option value="13K ၈ပဲ ၂ပြားရည်">
                                          13K ၈ပဲ ၂ပြားရည်
                                      </option>
                                      <option value="12K ၈ပဲရည်">
                                          12K ၈ပဲရည်
                                      </option>
                                  </select>
                              </div>
                          </div>
                          <!--                            //temporary hide div-->
                          <div class="col-md-6 d-none">
                              <div class="form-group row">
                                  <div class="col-6">
                                      <label>Diamond Include </label>

                                      <select
                                          class="form-control form-select"
                                          v-on:change="changeprice"
                                          v-model="diamond"
                                      >
                                          <option value="Yes">Yes</option>

                                          <option value="No">No</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <div
                                      class="col-6"
                                      v-if="this.diamond == 'Yes'"
                                  >
                                      <label style="font-size: 14px"
                                      >ကာရက်(Carat)<span
                                          v-if="this.carat == 0"
                                          class="sn-required-asterick"
                                      >*</span
                                      >
                                      </label>

                                      <input
                                          type="number"
                                          class="form-control"
                                         
                                          name="carat"
                                          v-model="carat"
                                          value=""
                                          placeholder="Enter Count"
                                      />
                                  </div>
                                  <div
                                      class="col-6"
                                      v-if="this.diamond == 'Yes'"
                                  >
                                      <label style="font-size: 14px"
                                      >ရတီ(Yati)<span
                                          v-if="this.yati == 0"
                                          class="sn-required-asterick"
                                      >*</span
                                      >
                                      </label>

                                      <input
                                          type="number"
                                          class="form-control"
                                         
                                          name="yati"
                                          v-model="yati"
                                          value=""
                                          placeholder="Enter Count"
                                      />
                                  </div>
                                  <div
                                      class="col-6"
                                      v-if="this.diamond == 'Yes'"
                                  >
                                      <label style="font-size: 14px"
                                      >ပွင့်<span
                                          v-if="this.pwint == 0"
                                          class="sn-required-asterick"
                                      >*</span
                                      >
                                      </label>

                                      <input
                                          type="number"
                                          class="form-control"
                                         
                                          name="yati"
                                          v-model="pwint"
                                          value=""
                                          placeholder="Enter Count"
                                      />
                                  </div>
                                  <div
                                      class="col-6"
                                      v-if="this.diamond == 'Yes'"
                                  >
                                      <label style="font-size: 14px"
                                      >ဂရမ်(Gram)<span
                                          v-if="this.d_gram == 0"
                                          class="sn-required-asterick"
                                      >*</span
                                      >
                                      </label>

                                      <input
                                          type="number"
                                          class="form-control"
                                         
                                          name="yati"
                                          v-model="d_gram"
                                          value=""
                                          placeholder="Enter Count"
                                      />
                                  </div>
                              </div>
                          </div>
                          <!--                            //temporary hide div-->

                          <div class="col-md-6 p-0">
                              <div class="form-group row">
                                  <div class="col-12">
                                      <label>Include Gems count </label>
                                      <multi
                                          v-model="gems"
                                          :options="optionsm"
                                          :multiple="true"
                                          placeholder="Pick some"
                                          @select="inputHandler"
                                          @remove="removeHandler"
                                          label="name"
                                      ></multi>
                                  </div>
                              </div>

                              <div
                                  class="form-group row"
                                  v-for="g in this.gems"
                                  :key="g.index"
                              >
                                  <div class="col-12">
                                      <label>Name</label>

                                      <div class="form-control">
                                          {{ g.name }}
                                      </div>
                                  </div>
                                  <div class="col-6">
                                      <label
                                          v-if="g.error == false"
                                          class="sn-required-asterick"
                                      >Counts<span>*</span>
                                      </label>
                                      <label
                                          v-else
                                          class="sn-required-asterick"
                                      >Counts<span>*</span>
                                      </label>

                                      <input
                                          type="number"
                                          class="form-control"
                                          v-model="g.count"
                                          v-bind:class="{
                                              'border-danger': g.error,
                                          }"
                                          placeholder="Enter Count"
                                      />
                                  </div>
                                  <div class="col-6">
                                      <label style="font-size: 14px"
                                      >ကာရက်<span></span>
                                      </label>

                                      <input
                                          type="number"
                                          class="form-control"
                                          v-model="g.carat"
                                          placeholder="Enter Count"
                                      />
                                  </div>

                                  <div class="col-6">
                                      <label style="font-size: 14px"
                                      >ရတီ<span></span>
                                      </label>

                                      <input
                                          type="number"
                                          class="form-control"
                                          v-model="g.yati"
                                          placeholder="Enter Count"
                                      />
                                  </div>
                                  <div class="col-6">
                                      <label style="font-size: 14px"
                                      >ဘီ<span></span>
                                      </label>

                                      <input
                                          type="number"
                                          class="form-control"
                                          v-model="g.pwint"
                                          placeholder="Enter Count"
                                      />
                                  </div>
                              </div>
                          </div>


                          <div class="col-md-6 p-0">
                              <div class="form-group row">
                                  <div class="col-6">
                                      <label>Stock</label>
                                      <select
                                          class="form-control"
                                          v-model="stock"
                                          v-on:change="stockchange"
                                          style="width: 100%"
                                      >
                                          <option value="In Stock">
                                              In Stock
                                          </option>
                                          <option value="Out Of Stock">
                                              Out Of Stock
                                          </option>
                                      </select>
                                  </div>
                                  <div
                                      class="col-6"
                                      v-if="this.stock === 'In Stock'"
                                  >
                                      <label
                                      >Counts
                                          <span
                                              v-if="this.stock_count == 0"
                                              class="sn-required-asterick"
                                          >*</span
                                          ></label
                                      >

                                      <input
                                          type="number"
                                          class="form-control"
                                          v-model="stock_count"
                                         
                                          placeholder="Enter Exact Count"
                                      />
                                  </div>
                              </div>
                          </div>
                          <!-- /.col -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Category</label>
                                  <select
                                      class="form-control"
                                      v-model="category_id"
                                      style="width: 100%"
                                  >
                                      <option
                                          v-for="cat in this.catlist"
                                          :key="cat.index"
                                          :value="cat.name"
                                      >
                                          {{ cat.mm_name }}
                                      </option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <!-- textarea -->
                              <div class="form-group">
                                  <label
                                  >Description
                                      <span
                                          v-if="this.description == ''"
                                          class="sn-required-asterick"
                                      >*</span
                                      ></label
                                  >

                                  <textarea
                                      class="form-control"
                                      v-model="description"
                                     
                                      rows="5"
                                      placeholder="Size"
                                  >
                                  </textarea>
                              </div>
                          </div>
                          <!-- /.col -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Gender </label>
                                  <select
                                      @change="temp"
                                      class="form-control"
                                     
                                      v-model="gender"
                                      style="width: 100%"
                                  >
                                      <option value="Kid">Kid</option>

                                      <option value="Men">Men</option>
                                      <option value="Women">Women</option>
                                      <option value="Couple">Couple</option>
                                      <option value="UniSex">Uni Sex</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-6 p-0">
                              <div class="form-group row">
                                  <div class="col-4">
                                      <label>Price Type </label>

                                      <select
                                          class="form-control form-select"
                                          v-on:change="changeprice()"
                                          v-model="exceptorrates"
                                      >
                                          <option value="Range">Range</option>

                                          <option value="Exactly">
                                              Exactly
                                          </option>
                                      </select>
                                  </div>
                                  <div
                                      class="col-4"
                                      v-if="this.exceptorrates == 'Range'"
                                  >
                                      <label style="font-size: 14px"
                                      >MIN(Ks)
                                          <span
                                              v-if="this.min_price == 0"
                                              class="sn-required-asterick"
                                          >*</span
                                          >
                                      </label>

                                      <input
                                          @focus="$event.target.select()"
                                          type="number"
                                          v-on:input="
                                              priceToWordLogic(
                                                  min_price,
                                                  'min'
                                              )
                                          "
                                          class="form-control"
                                          name="min_price"

                                         
                                          v-model="min_price"
                                          value=""
                                          placeholder="Enter Min price"
                                      />
                                      <!-- <span id="min_price_word"></span> -->
                                      <div>{{ snprice_to_word_min }}</div>
                                  </div>
                                  <div
                                      class="col-4"
                                      v-if="this.exceptorrates == 'Range'"
                                  >
                                      <label style="font-size: 14px"
                                      >MAX(Ks)
                                          <span
                                              v-if="this.max_price == 0"
                                              class="sn-required-asterick"
                                          >*</span
                                          >
                                      </label>

                                      <input
                                          @focus="$event.target.select()"
                                          type="number"
                                          v-on:input="
                                              priceToWordLogic(
                                                  max_price,
                                                  'max'
                                              )
                                          "
                                          class="form-control"
                                         
                                          name="max_price"
                                          v-model="max_price"
                                          value=""
                                          placeholder="Enter MAX price"
                                      />
                                      <div>{{ snprice_to_word_max }}</div>
                                  </div>
                                  <div
                                      class="col-8"
                                      v-if="this.exceptorrates == 'Exactly'"
                                  >
                                      <label
                                      >Price Exactly(Ks)
                                          <span
                                              v-if="this.price == 0"
                                              class="sn-required-asterick"
                                          >*</span
                                          ></label
                                      >

                                      <input
                                          @focus="$event.target.select()"
                                          v-on:input="
                                              priceToWordLogic(price, 'exact')
                                          "
                                          type="number"
                                          class="form-control"
                                         
                                          v-model="price"
                                          name="price"
                                          placeholder="Enter Exact price"
                                      />
                                      <div>{{ snprice_to_word_exact }}</div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label style="font-size: 15px"
                                  >အလျော့တွက်
                                  </label>
                                  <input
                                      type="text"
                                      class="form-control"
                                      v-model="handmade"
                                      placeholder="10 % or 10000ကျပ် "
                                  />
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label style="font-size: 15px">လက်ခ </label>
                                  <input
                                      type="text"
                                      class="form-control"
                                      v-model="charge"
                                      placeholder="10 % or 10000ကျပ် "
                                  />
                              </div>
                          </div>
                          <div class="row sn-percent">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label
                                      >ရောင်း / ဝယ် / လဲ
                                          ရာခိုင်နှုန်း</label
                                      >
                                      <select
                                          class="form-control"
                                          v-model="percenttemplate_id"
                                          @change="percenttemplateChange($event)"
                                          style="width: 100%"
                                      >
                                          <option
                                              v-for="percenttemplate in this.percenttemplate"
                                              :value="percenttemplate.id"
                                              :key="percenttemplate.id"
                                          >
                                              {{ percenttemplate.name }}
                                          </option>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label style="font-size: 15px"
                                      >အထည်မပျက် ပြန်သွင်း</label
                                      >
                                      <input
                                          type="text"
                                          class="form-control"
                                          v-model="undamaged_product"
                                          placeholder="10 % or 10000ကျပ် "
                                      />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label style="font-size: 15px"
                                      >အထည်ပျက်စီးချို့ယွင်း</label
                                      >
                                      <input
                                          type="text"
                                          class="form-control"
                                          v-model="damaged_product"
                                          id=""
                                          placeholder="10 % or 10000ကျပ် "
                                      />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label style="font-size: 15px"
                                      >တန်ဖိုးမြင့်အထည် နှင့်
                                          အထည်မပျက်ပြန်လဲ</label
                                      >
                                      <input
                                          type="text"
                                          class="form-control"
                                          v-model="valuable_product"
                                          placeholder="10 % or 10000ကျပ် "
                                      />
                                  </div>
                              </div>
                          </div>
                          <!-- /.col -->
                          <Ykweight ref="aa"></Ykweight>

                          <img src="" id="img-ff"/>
                          <canvas
                              id="canvas"
                              class="d-none"
                              width="300"
                          ></canvas>
                          <div class="col-md-6 pt-3">
                              <label for="tags-basic"
                              >Type a new tag and press enter</label
                              >
                              <b-form-tags
                                  input-id="tags-basic"
                                  v-model="tags"
                                  :limit="10"
                                  separator=",;"
                              ></b-form-tags>
                          </div>
                          <ykdropzone :link="this.link" ref="ykdz"></ykdropzone>
                         
                          <div class="pc"></div>
                          <div class="col-6 col-md-8">&nbsp;</div>

                          <div class="col-12">
                              <button
                                  class="sn-item-create-button btn btn-primary float-right float-sm-none"
                                  type="submit"
                                  @click="submitform"
                              >
                                  Create
                              </button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div
          v-if="this.submittedLoading === 1"
          class="sn_remove_wrapp"
          style=""
      >
          <div id="ct-loadding" class="ct-loader style5 yk-wrapper">
              <div class="ct-spinner5">
                  <div class="bounce1"></div>
                  <div class="bounce2"></div>
                  <div class="bounce3"></div>
              </div>
          </div>
      </div>
  </section>
</template>

<script>
import YkDropzone from "./YkDropzone.vue";
import vue2Dropzone from "vue2-dropzone";
import Ykweight from "./Ykweight";
import ykresizer from "./forimageresize/ykresizer";
import pricelogicsn from "./pricelogin/pricelogic";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import $ from "jquery";

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
  data: function () {
      return {
          submittedLoading: 0,
          valuable_product: 0,
          undamaged_product: 0,
          damaged_product: 0,
          snprice_to_word_min: "",
          snprice_to_word_max: "",
          category_id: "",
          percenttemplate_id: "",
          tags: [],
          mid_photos: [],
          thumb_photos: [],
          optionsm: [
              {
                  name: "Diamond စိန်",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Ruby ပတ္တမြား",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Jade ကျောက်စိမ်း",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Emerald မြ",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Sapphire နီလာ",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Morganite မြပန်းရောင်",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Spinel အညံ့ပန်း",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Topaz ဥသ၁ဖယား/ ထပ်တရာ",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Zircon ဂေါ်မိတ်",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Bloodstone သွေးကျောက်",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },

              {
                  name: "Coral သန္တာကျောက်",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Oryx မဟူရာ",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Turquoise စိမ်းပြာကျောက်",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Beryl မြကျောက်",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Garnet ဥဒေါင်",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Coral သန္တာကျောက်",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Moonstone လကျောက်",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Rose quartz ပန်းရောင်သလင်းကျောက်",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Aquamarine မြပြာ",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Amethyst ခရမ်းစွဲ",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Sodalite ကျောက်မျက်",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Tourmaline ဖရဲအူ",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Coral သန္တာကျောက်",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Peridot ပြောင်ခေါင်းစိမ်း",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Blue Star",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Agate သဘော်မဟူရာ",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "စလင်းဝါ",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "blue topaz",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Cat's Eye",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
              {
                  name: "Pearl ပုလဲ",
                  count: 0,
                  carat: 0,
                  yati: 0,
                  pwint: 0,
                  error: false,
              },
          ],

          gender: "UniSex",
          handmade: "",
          charge: "",
          gems: [],
          gems_value: [],
          //for diamond
          // for weight
          weight: 0,

          weight_unit: "အောင်စ",
          // for weight

          d_gram: 0,
          diamond: "No",

          //for diamond

          // forstock
          stock: "In Stock",
          collection_id: 0,

          stock_count: 0,
          // forstock
          photoerror: 0,
          //for price
          exceptorrates: "Range",
          price: 0,
          hostname: "",
          price_word: "",
          min_price: 0,
          max_price: 0,
          //for price
          //for default icon
          displaynone: false,
          //for default icon
          name: "",
          gold_colour: "",
          description: "",
          product_code: 0,
          gems_count: "",
          dzerror: "",
          main_category: 1,
       

          hidetoggle: false,
       
      };
  },
  mounted() {
      console.log(this.main_cat);

      this.category_id = this.catlist[0].name;

      console.log("fefe");
      console.log(this.percenttemplate);
          this.percenttemplate_id = 1;
          this.undamaged_product = 0;
          this.damaged_product = 0;
          this.valuable_product = 0;

          this.percenttemplate.unshift({id: 1, name: "Default"});

     
  },

  components: {
      ykdropzone: YkDropzone,
      multi: Multiselect,
      Ykweight: Ykweight,
  },
  methods: {
    submitform($event){
      this.$refs.ykdz.gold_colour=document.getElementsByName("gold_colour")[0].value;
      this.$refs.ykdz.gold_quality=document.getElementsByName("gold_quality")[0].value;


      this.$refs.ykdz.submitform($event);
    },
      temp() {
          console.log(this.gender);
      },
      // ရောင်း / ဝယ် / လဲ ရာခိုင်နှုန်း
      percenttemplateChange($event) {
          this.percenttemplate.forEach((percenttemplate) => {
              if (percenttemplate.id == this.percenttemplate_id) {
                  // this.handmade = percenttemplate.handmade;
                  // this.charge = percenttemplate.charge;
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

    
    
     

     

    
    
      
      //if error was apper call this bootstrap model
      showerrorwithmodel: function (msg) {
          this.dzerror = msg;
          var myModal = new bootstrap.Modal(
              document.getElementById("myModal")
          );
          myModal.show();
          this.hidetoggle = false;
      },

      clearerrormsgfrommodel: function () {
          console.log("close");
          //customize bs model because i dnt want to add bs to vue
          this.hidetoggle = true;
          var paras = document.getElementsByClassName("modal-backdrop");
          $("body").removeClass("modal-open");
          $("body").addClass("yk-model");
          while (paras[0]) {
              paras[0].parentNode.removeChild(paras[0]);
          }
          this.requireerroryk = [];
      },

     
     
     
  },
  computed: {},
};
</script>

<style>
.yk-width-full {
  width: 100%;
  margin-top: 21px;
}

.last + div {
  padding-left: 37px;
}

#customdropzone {
  border: 2px solid #007bff8c;
  /* font-family: "Arial", sans-serif; */
  letter-spacing: 0.2px;
  color: #777;
  transition: background-color 0.2s linear;
  height: auto;
  min-height: 222px;
  display: flex;
  flex-wrap: wrap;
  border-style: dashed;
  padding: 10px;
  width: 100%;
}

.yk-mt-lg {
  margin-top: 55px !important;
}

.yk-mt-sm {
  margin-top: 22px !important;
}

body {
}

/*this class auto add by dropzone when max file reach limit*/
.dz-max-files-reached .dz-message {
}

/*this class auto add by dropzone when max file reach limit*/

.dz-preview {
  width: 142px !important;
  display: inline-block;
  margin-right: 9px !important;
  margin-top: 2px;
}

.vue-dropzone > .dz-preview .dz-remove {
  position: relative;
}

.dz-profile-pic {
  position: absolute !important;
  margin-left: 0px !important;
  color: #33ff00 !important;
  /* border: 2px #ff0000a8 solid !important; */
  top: 0px;
  left: 0px;
  width: 28px;
  font-size: 27px;
}

.dz-image-preview {
  position: relative !important;
}

#customdropzone .dz-preview .dz-image {
  width: 123px !important;
  height: 115px !important;
  margin-bottom: 14px;
  margin-right: 22px !important;
}

.dz-details {
  display: none !important;
}

.dz-remove {
  position: absolute !important;
  margin-left: 0px !important;
  color: #ff6643 !important;
  /* border: 2px #ff0000a8 solid !important; */
  top: 0px;
  right: 0px;
  width: 28px;
  font-size: 27px;
}

.select2.select2-container {
  width: 100% !important;
}

.hide {
  display: none !important;
}

#customdropzone .dz-preview .dz-image > div {
  width: inherit;
  height: inherit;
  background-size: cover;
  background-repeat: no-repeat;
}

#customdropzone .dz-preview .dz-image > img {
  width: 100%;
}

.yk-model {
  padding-right: 0px !important;
}

#customdropzone .dz-preview .dz-details {
  color: white;
  transition: opacity 0.2s linear;
  text-align: center;
}

.dz-progress {
  display: none;
}

/*.dz-error-message {*/
/*    display: none;*/
/*}*/

.color-danger {
  color: red !important;
}
</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
