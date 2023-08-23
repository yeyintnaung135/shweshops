<template>
    <section class="content">
        <div class="container-fluid sn-item-container">
            <!-- SELECT2 EXAMPLE -->
            <div class="sn-item-create-wrapper">
                <div class="">
                    <h3 class="">Edit Your Item</h3>
                    <div
                        class="alert alert-success"
                        v-if="this.editdata.YkgetDiscount != 0"
                        role="alert"
                    >
                        This item is discounted item !
                    </div>
                </div>
              
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label
                                        >Item Name
                                        <span
                                            v-if="this.name == ''"
                                            style="
                                                color: red;
                                                font-size: 14px !important;
                                            "
                                            >(Required**)</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-bind:class="{
                                            'border-danger':
                                                forvalidate_css('name'),
                                        }"
                                        v-model="name"
                                        placeholder="Enter name"
                                    />
                                    <div
                                        class="sn-required-asterick"
                                        v-if="forvalidate_css('name')"
                                    >
                                        {{ this.validate_errors[0].name.msg }}
                                    </div>
                                </div>
                            </div>
                            <!--                            <Ykweight v-on:forparent="getdatafromykweight"></Ykweight>-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label
                                        >Product Code
                                        <span
                                            v-if="this.product_code == 0"
                                            style="
                                                color: red;
                                                font-size: 14px !important;
                                            "
                                            >(Required**)</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        v-bind:class="{
                                            'border-danger':
                                                forvalidate_css('product_code'),
                                        }"
                                        class="form-control"
                                        v-model="product_code"
                                        placeholder="Enter Product Code"
                                    />
                                    <div
                                        class="sn-required-asterick"
                                        v-if="forvalidate_css('product_code')"
                                    >
                                        {{ this.validate_errors[0].product_code.msg }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                                        v-model="gold_colour"
                                      
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
                        </div>

                        <br />
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gold Quality</label>
                                    <select
                                        class="form-control select2"
                                        v-model="gold_quality"
                                        style="width: 100%"
                                    >
                                        <option value="24K ၁၆ပဲရည်">
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
                            <div class="col-md-6">
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
                                            style="font-size: 14px"
                                            >Counts<span>***</span>
                                        </label>
                                        <label
                                            v-else
                                            style="font-size: 14px; color: red"
                                            >Counts<span>***</span>
                                        </label>

                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="g.count"
                                          
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
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-6">
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
                                        v-if="this.stock == 'In Stock'"
                                    >
                                        <label
                                            >Counts
                                            <span
                                                v-if="this.stock_count == 0"
                                                style="
                                                    color: red;
                                                    font-size: 14px !important;
                                                "
                                                >(Required**)</span
                                            ></label
                                        >

                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="stock_count"
                                            v-bind:class="{
                                                'border-danger':
                                                    forvalidate_css(
                                                        'stock_count'
                                                    ),
                                            }"
                                            placeholder="Enter Exact Count"
                                        />
                                    </div>
                                    <div
                                        class="sn-required-asterick"
                                        v-if="forvalidate_css('stock_count')"
                                    >
                                        {{
                                            this.validate_errors[0].stock_count
                                                .msg
                                        }}
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
                        </div>
                        <br />

                        <div class="row">
                            <div class="col-md-6">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label
                                        >Description
                                        <span
                                            v-if="this.description == ''"
                                            style="
                                                color: red;
                                                font-size: 14px !important;
                                            "
                                            >(Required**)</span
                                        ></label
                                    >
                                    <textarea
                                        class="form-control"
                                        v-model="description"
                                        v-bind:class="{
                                            'border-danger':
                                                forvalidate_css('description'),
                                        }"
                                        rows="3"
                                        placeholder="Enter ..."
                                    ></textarea>
                                </div>
                                <div
                                        class="sn-required-asterick"
                                        v-if="forvalidate_css('description')"
                                    >
                                        {{
                                            this.validate_errors[0].description
                                                .msg
                                        }}
                                    </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender </label>
                                    <select
                                        class="form-control select2"
                                      
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
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-6">
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
                                        <label
                                            >MIN(Ks)
                                            <span
                                                v-if="this.min_price == 0"
                                                style="
                                                    color: red;
                                                    font-size: 12px !important;
                                                "
                                                >(Required**)</span
                                            >
                                        </label>

                                        <input
                                            type="number"
                                            class="form-control"
                                            name="min_price"
                                            v-bind:class="{
                                                'border-danger':
                                                    forvalidate_css('price'),
                                            }"
                                            v-model="min_price"
                                            v-on:input="
                                                priceToWordLogic(
                                                    min_price,
                                                    'min'
                                                ),
                                                    discountchangewhenpricechange()
                                            "
                                            placeholder="Enter Min price"
                                        />
                                        <div>{{ snprice_to_word_min }}</div>
                                    </div>
                                    <div
                                        class="col-4"
                                        v-if="this.exceptorrates == 'Range'"
                                    >
                                        <label
                                            >MAX(Ks)
                                            <span
                                                v-if="this.max_price == 0"
                                                style="
                                                    color: red;
                                                    font-size: 12px !important;
                                                "
                                                >(Required**)</span
                                            >
                                        </label>

                                        <input
                                            type="number"
                                            class="form-control"
                                            v-bind:class="{
                                                'border-danger':
                                                    forvalidate_css('price'),
                                            }"
                                            name="max_price"
                                            v-model="max_price"
                                            v-on:input="
                                                priceToWordLogic(
                                                    max_price,
                                                    'max'
                                                ),
                                                    discountchangewhenpricechange()
                                            "
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
                                                style="
                                                    color: red;
                                                    font-size: 12px !important;
                                                "
                                                >(Required**)</span
                                            ></label
                                        >

                                        <input
                                            type="number"
                                            class="form-control"
                                            v-bind:class="{
                                                'border-danger':
                                                    forvalidate_css('price'),
                                            }"
                                            v-model="price"
                                            v-on:input="
                                                priceToWordLogic(
                                                    price,
                                                    'exact'
                                                ),
                                                    discountchangewhenpricechange()
                                            "
                                            name="price"
                                            placeholder="Enter Exact price"
                                        />
                                        <div>{{ snprice_to_word_exact }}</div>
                                    </div>
                                    <div
                                        class="sn-required-asterick"
                                        v-if="forvalidate_css('price')"
                                    >
                                        {{ this.validate_errors[0].price.msg }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>အလျော့တွက် </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                      
                                        v-model="handmade"
                                        placeholder="10 % or 10000ကျပ် "
                                    />
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="row">
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
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <!--                            //price-->

                            <!--                            //price-->
                        </div>
                        <br />
                        <!--                        <div class="row">-->
                        <!--                            <div class="col-md-6">-->
                        <!--                                <div class="form-group">-->
                        <!--                                    <label>Collection</label>-->

                        <!--                                    <select-->
                        <!--                                        class="form-control"-->
                        <!--                                        name="purchase_order_number"-->
                        <!--                                        id="purchase_order_number"-->
                        <!--                                        v-model="collection_id"-->
                        <!--                                    >-->
                        <!--                                        <option value="0">-->
                        <!--                                            Not In Collection-->
                        <!--                                        </option>-->
                        <!--                                        <option-->
                        <!--                                            v-for="col in this.collection"-->
                        <!--                                            :value="col.id"-->
                        <!--                                            :key="col.id"-->
                        <!--                                        >-->
                        <!--                                            {{ col.name }}-->
                        <!--                                        </option>-->
                        <!--                                    </select>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->

                        <div class="row sn-percent">
                           
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
                                        >damaged_product</label
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
                        <br />
                        <br />

                        <div class="row">
                            <Ykweight
                                ref="aa"
                                :editdataweight="this.editdata.weight"
                            ></Ykweight>
                            <div class="col-md-6">
                                <label for="tags-basic"
                                    >Type a new tag and press enter</label
                                >
                                <b-form-tags
                                    input-id="tags-basic"
                                    v-model="tags"
                                    :limit="10"
                                    separator=" ,;"
                                ></b-form-tags>
                            </div>
                        </div>
                        <br />
                        <br />
                        <ykdropzoneedit
                            :link="this.link"
                            :editdata="this.editdata"
                            ref="ykdzed"
                        ></ykdropzoneedit>
                        <br />
                        <div class="row">
                            <div
                                class="col-12 col-md-12"
                                v-if="
                                    this.editdata.YkgetDiscount != 0 &&
                                    this.discount.show == 'yes'
                                "
                            >
                                <div class="alert alert-success" role="alert">
                                    Your Items Discount Price will change to
                                    <br />
                                    <div>
                                        <div
                                            v-if="
                                                this.editdata.YkgetDiscount
                                                    .discount_price == 0
                                            "
                                        >
                                            from ({{
                                                this.editdata.YkgetDiscount
                                                    .discount_min
                                            }}
                                            -
                                            {{
                                                this.editdata.YkgetDiscount
                                                    .discount_max
                                            }}) ({{
                                                fordismmprice(
                                                    this.editdata.YkgetDiscount
                                                        .discount_min
                                                )
                                            }}-{{
                                                fordismmprice(
                                                    this.editdata.YkgetDiscount
                                                        .discount_max
                                                )
                                            }})
                                        </div>
                                        <div v-else>
                                            from ({{
                                                this.editdata.YkgetDiscount
                                                    .discount_price
                                            }}) ({{
                                                fordismmprice(
                                                    this.editdata.YkgetDiscount
                                                        .discount_price
                                                )
                                            }})
                                        </div>
                                    </div>

                                    <div>
                                        <div v-if="this.price == 0">
                                            to ({{ this.discount.newmin }} -
                                            {{ this.discount.newmax }}) ({{
                                                fordismmprice(
                                                    this.discount.newmin
                                                )
                                            }}-{{
                                                fordismmprice(
                                                    this.discount.newmax
                                                )
                                            }})
                                        </div>
                                        <div v-else>
                                            to ({{ this.discount.newprice }})
                                            ({{
                                                fordismmprice(
                                                    this.discount.newprice
                                                )
                                            }})
                                        </div>
                                    </div>
                                    <input
                                        type="checkbox"
                                        style="color: white"
                                        id="vehicle1"
                                        v-model="unsetdiscount"
                                    />
                                    <label for="vehicle1" style="color: white">
                                        Will Unset Discount?</label
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-4">&nbsp;</div>

                            <div class="col-6 col-md-4">
                                <button
                                    class="btn btn-primary float-right"
                                    type="submit"
                                    @click="submitform"
                                >
                                    <span class="fa fa-paper-plane"></span
                                    >&nbsp;&nbsp;Edit Item
                                </button>
                            </div>
                        </div>

                        <br />
                    </div>
                    <!-- /.FORM END -->
               
                <!-- /.card -->
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
import YkDropzoneForEdit from "./YkDropzoneForEdit.vue";
import $ from "jquery";
import Ykweight from "./Ykweight";
import Multiselect from "vue-multiselect-with-duplicates";
import pricelogicsn from "./pricelogin/pricelogic";
import { allstaticdata } from "./services/allstaticdata";
import {allvalidate} from "./services/validateitemcreate";


export default {
    props: ["editdata", "collection", "link", "catlist", "main_cat"],

    name: "ItemEdit",

    data: function () {
        return {
            discount: { show: "no", newprice: "0", newmin: "0", newmax: "0" },
            unsetdiscount: false,
          
            submittedLoading: 0,
            tags: [],
            // for gem
            optionsm: allstaticdata.gemsname,

            gems: [],
            gems_value: [],
            // for gem
            // for weight
            weight: 0,

            weight_unit: "အောင်စ",
            // for weight

            //for diamond
            carat: 0,
            yati: 0,
            pwint: 0,
            d_gram: 0,
            diamond: "No",

            //for diamond
            name: "",
            product_code: 0,
            description: "",
            collection_id: "",
            //forstock
            stock: "In Stock",
            stock_count: 0,
            //forstock
            validate_errors: [],
            //for price
            exceptorrates: "Range",
            price: 0,
            price_word: "",
            min_price: 0,
            max_price: 0,
            //for price
            category_id: "",
            dzerror: "",
            gold_quality: "",
            removeimgqueue: [],
            item_id: "",
            gender: "",
            undamaged_product:0,
            damaged_product:0,
            valuable_product:0,
            // SN Price Number to Word Logic
            snprice_to_word_exact: "",
            snprice_to_word_min: "",
            snprice_to_word_max: "",

            renameFilename: function (file) {
                let newname = Date.now() + file;
                return newname;
            },
            hostname: "",
            gold_colour_error: "",
            gold_colour: "",
            main_category: 1,
            //forerror
          
            handmade: "",
            charge: "",
            //forerror
            responseafterdelete: "",

            existingFiles: [],
            hidetoggle: false,

            valuable_product: 0,
            undamage_product: 0,
            damage_product: 0,
        };
    },

    mounted() {
        console.log(this.editdata)
        this.undamaged_product = this.editdata.undamaged_product;
        this.damaged_product = this.editdata.damaged_product;
        this.valuable_product = this.editdata.valuable_product;

        console.log(this.editdata.YkgetDiscount);
        this.main_category = this.editdata.main_category;
  
        //for cat

        //for cat

        //for gems
        if (this.editdata.GemsData === "empty") {
            this.gems = [];
        } else {
            this.gems = JSON.parse(this.editdata.GemsData);
        }

        //for gems
        this.editdata.tagged.map((t) => {
            this.tags.push(t.tag_name);
        });
        //for weight

        this.weight = this.editdata.weight;

        //for weight

        if (this.editdata.diamond == "Yes") {
            //for diamond

            this.diamond = this.editdata.diamond;
            this.carat = this.editdata.carat;
            this.pwint = this.editdata.pwint;
            this.d_gram = this.editdata.d_gram;
            this.yati = this.editdata.yati;
        }
        this.gender = this.editdata.gender;
        this.handmade = this.editdata.handmade;
        this.charge = this.editdata.charge;
        this.name = this.editdata.name;
        this.product_code = this.editdata.product_code;

        this.description = this.editdata.description;
        //for price
        this.stock = this.editdata.stock;
        this.stock_count = this.editdata.stock_count;
        this.collection_id = this.editdata.collection_id;

        if (this.editdata.price == 0) {
            this.exceptorrates = "Range";
            this.min_price = this.editdata.min_price;
            this.max_price = this.editdata.max_price;
            this.price = 0;
            this.priceToWordLogic(this.min_price, "min");
            this.priceToWordLogic(this.max_price, "max");
        } else {
            this.exceptorrates = "Exactly";
            this.price = this.editdata.price;
            this.min_price = 0;
            this.max_price = 0;
            this.priceToWordLogic(this.price, "exact");
        }
        //for price
        this.gold_quality = this.editdata.gold_quality;
        this.category_id = this.editdata.category_id;
        this.gold_colour = this.editdata.gold_colour;
        // show default icon
    },
    components: {
        ykdropzoneedit: YkDropzoneForEdit,
        multi: Multiselect,
        Ykweight: Ykweight,
    },
    methods: {
        forvalidate_css(fieldname) {
            if (this.validate_errors.length > 0) {
                if (fieldname == "stock_count") {
                    if (
                        this.stock == "In Stock" &&
                        this[fieldname] < 1 &&
                        this.validate_errors[0][fieldname]
                    ) {
                        return true;
                    }
                } else if (fieldname == "price") {
                    if (
                        this.validate_errors[0][fieldname] &&
                        Number(this.price) < 9999 &&
                        (Number(this.max_price) < 9999 ||
                            Number(this.min_price) == 9999)
                    ) {
                        return true;
                    } else if (
                        this.validate_errors[0][fieldname] &&
                        Number(this.price) == 0 &&
                        Number(this.min_price) > Number(this.max_price)
                    ) {
                        this.validate_errors[0].price.msg = "Wrong Price";
                        return true;
                    }
                } else if (fieldname != "price" && fieldname != "stock_count") {
                    if (
                        (this.validate_errors[0][fieldname] &&
                            this[fieldname] == "") ||
                        (this.validate_errors[0][fieldname] &&
                            this[fieldname] == 0)
                    ) {
                        return true;
                    }
                }
            }
        },
        discountchangewhenpricechange() {
            if (this.editdata.YkgetDiscount != 0) {
                if (
                    (this.price != this.editdata.price && this.price != 0) ||
                    ((this.min_price != this.editdata.min_price ||
                        this.max_price != this.editdata.max_price) &&
                        (this.min_price != 0 || this.max_price != 0))
                ) {
                    this.discount.show = "yes";
                    if (this.price == 0) {
                        if (this.editdata.YkgetDiscount.dec_price != 0) {
                            this.discount.newmin =
                                this.min_price -
                                this.editdata.YkgetDiscount.dec_price;
                            this.discount.newmax =
                                this.max_price -
                                this.editdata.YkgetDiscount.dec_price;
                        } else {
                            this.discount.newmin = Math.round(
                                this.min_price -
                                    (this.min_price *
                                        this.editdata.YkgetDiscount.percent) /
                                        100
                            );
                            this.discount.newmax = Math.round(
                                this.max_price -
                                    (this.max_price *
                                        this.editdata.YkgetDiscount.percent) /
                                        100
                            );
                        }
                    } else {
                        if (this.editdata.YkgetDiscount.dec_price != 0) {
                            this.discount.newprice =
                                this.price -
                                this.editdata.YkgetDiscount.dec_price;
                        } else {
                            this.discount.newprice = Math.round(
                                this.price -
                                    (this.price *
                                        this.editdata.YkgetDiscount.percent) /
                                        100
                            );
                        }
                    }
                } else {
                    this.discount.show = "no";
                }
            }
        },
        // for weight
        // get data from child weight
        getdatafromykweight(value) {
            this.weight = value.weight;
            this.weight_unit = value.unit;
            console.log(this.weight);
        },
        getdatafromykweightforerror(value) {
        },
        //for weight
        inputHandler(selectedOption, id) {
            this.gems.push(selectedOption);
        },
        //id is index change in core vue multiselect in node_module (!important)
        removeHandler(removedOption, id) {
            // this.gems.splice(id, 1);
        },

   
        stockchange() {
            if (this.stock == "Out Of Stock") {
                this.stock_count = 0;
            }
        },
        //for price
        changeprice() {
            if (this.exceptorrates == "Range") {
                this.price = 0;
                this.snprice_to_word_exact = 0;
            } else {
                this.snprice_to_word_min = 0;
                this.snprice_to_word_max = 0;
                this.min_price = 0;
                this.max_price = 0;
            }
        },
        //for price

        // SN Price Number to Word
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
        fordismmprice: function (price) {
            return pricelogicsn(price);
        },
        // End of SN Price Number to Word
        // End of SN Price Number to Word

        // when click submit button

        submitform: function (event) {
            allvalidate.validatecreate(this);
            if (this.validate_errors.length < 1) {


            this.$refs.ykdzed.submitform(event);
            }
        },
    },
};
</script>
<style>
.sn-percent {
    border: 1px solid #e9e9e9;
    border-radius: 5px;
    background: #e9e9e9;
}</style>