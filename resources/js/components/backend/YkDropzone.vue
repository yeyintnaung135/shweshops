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
                                        v-bind:class="{
                                            'border-danger': forrequire(
                                                this.requireerroryk.name,
                                                this.name
                                            ),
                                        }"
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
                                        v-bind:class="{
                                            'border-danger': forrequire(
                                                this.requireerroryk
                                                    .product_code,
                                                this.product_code
                                            ),
                                        }"
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
                                        v-bind:class="{
                                            'border-danger':
                                                this.requireerroryk
                                                    .main_category,
                                        }"
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
                                        v-bind:class="{
                                            'border-danger': forrequire(
                                                this.requireerroryk.gold_colour,
                                                this.gold_colour
                                            ),
                                        }"
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
                                            v-bind:class="{
                                                'border-danger': forrequire(
                                                    this.requireerroryk.diamond,
                                                    this.carat
                                                ),
                                            }"
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
                                            v-bind:class="{
                                                'border-danger': forrequire(
                                                    this.requireerroryk.diamond,
                                                    this.yati
                                                ),
                                            }"
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
                                            v-bind:class="{
                                                'border-danger': forrequire(
                                                    this.requireerroryk.diamond,
                                                    this.pwint
                                                ),
                                            }"
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
                                            v-bind:class="{
                                                'border-danger': forrequire(
                                                    this.requireerroryk.diamond,
                                                    this.d_gram
                                                ),
                                            }"
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
                                            v-bind:class="{
                                                'border-danger': forrequire(
                                                    this.requireerroryk
                                                        .stock_count,
                                                    this.stock_count
                                                ),
                                            }"
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
                                        v-bind:class="{
                                            'border-danger': forrequire(
                                                this.requireerroryk.description,
                                                this.description
                                            ),
                                        }"
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
                                        v-bind:class="{
                                            'border-danger':
                                                this.requireerroryk.gender,
                                        }"
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

                                            v-bind:class="[
            this.requireerroryk.minprice ? 'border-danger' : '',
            this.requireerroryk.price ? 'border-danger' : '',

          ]"
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
                                            v-bind:class="[
                                           this.requireerroryk.minprice ? 'border-danger' : '',
                                           this.requireerroryk.price ? 'border-danger' : '',
                                           ]"
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
                                            v-bind:class="[
                                           this.requireerroryk.minprice ? 'border-danger' : '',
                                           this.requireerroryk.price ? 'border-danger' : '',
                                           ]"
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
                                            v-model="recap_id"
                                            @change="recapChange($event)"
                                            style="width: 100%"
                                        >
                                            <option
                                                v-for="recap in this.recap"
                                                :value="recap.id"
                                                :key="recap.id"
                                            >
                                                {{ recap.name }}
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
                                            v-model="undamage_product"
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
                                            v-model="damage_product"
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
                            <div class="col-md-12 pt-3">
                                <div
                                    v-bind:class="{
                                        'color-danger': forrequirephoto(
                                            this.requireerroryk.photoerror,
                                            this.photoerror
                                        ),
                                    }"
                                >
                                    <label style="font-size: 15px"
                                    >အနည်းဆုံး ပုံ တစ်ပုံတင်ပါ</label
                                    >
                                </div>

                                <vue-dropzone
                                    :include-styling="false"
                                    :useCustomSlot="true"
                                    ref="myVueDropzone"
                                    v-on:vdropzone-sending-multiple="
                                        sendingEvent
                                    "
                                    v-on:vdropzone-error-multiple="errorEvent"
                                    v-on:vdropzone-removed-file="
                                        removefilefromdz
                                    "
                                    v-on:vdropzone-files-added="
                                        multiplefilesadded
                                    "
                                    v-on:vdropzone-success-multiple="
                                        successEvent
                                    "
                                    v-on:vdropzone-max-files-exceeded="
                                        maxfilesEvent
                                    "
                                    v-on:vdropzone-mounted="callaftermounted"
                                    v-on:vdropzone-thumbnail="thumbnail"
                                    :options="dropzoneOptions"
                                    id="customdropzone"
                                >
                                    <div
                                        class="dropzone-custom-content yk-mt-lg mb-2"
                                        style="text-align: center"
                                    >
                                        <i
                                            class="fa fa-plus-circle"
                                            aria-hidden="true"
                                            style="
                                                font-size: 52px;
                                                vertical-align: middle;
                                            "
                                        ></i>
                                    </div>
                                </vue-dropzone>
                            </div>
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
        "recap",
        "main_cat",
    ],
    name: "YkDropzone",
    data: function () {
        return {
            submittedLoading: 0,
            valuable_product: 0,
            undamage_product: 0,
            damage_product: 0,
            snprice_to_word_min: "",
            snprice_to_word_max: "",
            category_id: "",
            recap_id: "",
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
            //forerror
            requireerroryk: {
                gems: false,
                diamond: false,
                photoerror: false,
                name: false,
                review: false,
                description: false,
                sizing_guide: false,
                gold_colour: false,
                product_code: false,
                stock_count: false,
                weight: false,
                main_category: false,
                minprice: false
            },
            //forerror
            //for to set default photo
            tempphotonames: [],
            defaultphotoname: "",
            //for to set default photo

            hidetoggle: false,
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            dropzoneOptions: {
                url: this.link,
                maxFiles: 10,
                acceptedFiles: "image/*",

                previewTemplate: this.template(),
                method: "POST",
                renameFilename: function (file) {
                    let newname = Date.now() + "_" + file;
                    return newname;
                },

                autoDiscover: false,
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                timeout: 3000000000,
                maxThumbnailFilesize: 111,
                maxFilesize: 2097152000000, //20mb

                headers: {
                    "My-Awesome-Header": "header value",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            },
        };
    },
    mounted() {
        console.log(this.main_cat);
        this.damage_product = this.somedatafromshop.အထည်ပျက်စီးချို့ယွင်း;
        this.valuable_product =
            this.somedatafromshop.တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ;
        this.undamage_product = this.somedatafromshop.အထည်မပျက်_ပြန်သွင်း;
        this.category_id = this.catlist[0].name;

        console.log("fefe");
        console.log(this.recap);
        if (this.recap.length == 0) {
            this.recap_id = 1;
            this.undamage_product = 0;
            this.damage_product = 0;
            this.valuable_product = 0;

            this.recap[0] = {id: 1, name: "Default"};
        } else {
            this.recap_id = this.recap[0].id;
            this.handmade = this.recap[0].handmade ? this.recap[0].handmade : 0;
            this.charge = this.recap[0].charge ? this.recap[0].charge : 0;
            this.undamage_product = this.recap[0].undamage_product;
            this.damage_product = this.recap[0].damage_product;
            this.valuable_product = this.recap[0].valuable_product;
        }
        // console.log("Recap data worked", this.recap);

        console.log(
            this.somedatafromshop.တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ
        );
    },

    components: {
        vueDropzone: vue2Dropzone,
        multi: Multiselect,
        Ykweight: Ykweight,
    },
    methods: {
        temp() {
            console.log(this.gender);
        },
        // ရောင်း / ဝယ် / လဲ ရာခိုင်နှုန်း
        recapChange($event) {
            this.recap.forEach((recap) => {
                if (recap.id == this.recap_id) {
                    // this.handmade = recap.handmade;
                    // this.charge = recap.charge;
                    this.undamage_product = recap.undamage_product;
                    this.damage_product = recap.damage_product;
                    this.valuable_product = recap.valuable_product;
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
        // when click submit button
        submitform: async function (event) {
            event.preventDefault();
            event.stopPropagation();

            let tmperrorcounts = 0;

            // check all input field has value
            if (this.name == "") {
                this.requireerroryk.name = true;
                tmperrorcounts += 1;
            } else {
                this.requireerroryk.name = false;
            }


            // check all input field has value
            // if (this.name == "") {
            //     this.requireerroryk.name = true;
            //     tmperrorcounts += 1;
            // }
            if (this.description == "") {
                this.requireerroryk.description = true;
                tmperrorcounts += 1;
            } else {
                this.requireerroryk.description = false;
            }

            if (this.main_category == "") {
                this.requireerroryk.main_category = true;
                tmperrorcounts += 1;
            } else {
                this.requireerroryk.main_category = false;
            }

            if (document.getElementsByName("gold_quality")[0].value == "") {
                this.requireerroryk.gold_quality = true;
                tmperrorcounts += 1;
            } else {
                this.requireerroryk.gold_quality = false;
            }
            if (document.getElementsByName("gold_colour")[0].value == "") {
                this.requireerroryk.gold_colour = true;
                tmperrorcounts += 1;
            } else {
                this.requireerroryk.gold_colour = false;
            }

            if (this.category_id == "") {
                this.requireerroryk.category_id = true;
                tmperrorcounts += 1;
            } else {
                this.requireerroryk.category_id = false;
            }

            if (this.product_code == 0) {
                this.requireerroryk.product_code = true;
                tmperrorcounts += 1;
            } else {
                this.requireerroryk.product_code = false;
            }

            if (this.diamond == "Yes" && this.carat == 0) {
                this.requireerroryk.diamond = true;
                tmperrorcounts += 1;
            } else {
                this.requireerroryk.diamond = false;
            }

            if (this.diamond == "Yes" && this.yati == 0) {
                this.requireerroryk.diamond = true;
                tmperrorcounts += 1;
            } else {
                this.requireerroryk.diamond = false;
            }

            if (this.diamond == "Yes" && this.pwint == 0) {
                this.requireerroryk.diamond = true;
                tmperrorcounts += 1;
            } else {
                this.requireerroryk.diamond = false;
            }

            if (this.diamond == "Yes" && this.d_gram == 0) {
                this.requireerroryk.diamond = true;
                tmperrorcounts += 1;
            } else {
                this.requireerroryk.diamond = false;
            }

            if (this.price == 0 && this.min_price == 0 && this.max_price == 0) {
                this.requireerroryk.price = true;
                tmperrorcounts += 1;
            } else {
                this.requireerroryk.price = false;
            }
            if (this.exceptorrates == 'Range') {
                if (this.min_price < 10000 || this.max_price < 10000) {
                    tmperrorcounts += 1;
                    this.requireerroryk.minprice = true;

                } else {
                    this.requireerroryk.minprice = false;
                }
            }else{
                if (this.price < 10000) {
                    tmperrorcounts += 1;
                    this.requireerroryk.minprice = true;

                } else {
                    this.requireerroryk.minprice = false;
                }
            }

            if (this.stock == "In Stock" && this.stock_count == 0) {
                this.requireerroryk.stock_count = true;
                tmperrorcounts += 1;
            } else {
                this.requireerroryk.stock_count = false;
            }

            //for gems error
            var self = this;

            this.gems.map(function (e) {
                if (e.count == 0) {
                    e.error = true;
                    self.requireerroryk.gems = true;
                    tmperrorcounts += 1;
                } else {
                    e.error = false;
                    self.requireerroryk.gems = false;
                }
            });
            //for gems

            //for weight
            if (!this.$refs.aa.weight_child.length) {
                // this.$refs.aa.ew = true;
                //
                // tmperrorcounts += 1;
            } else {
                this.$refs.aa.weight_child.map(function (w) {
                    if (w.value == 0) {
                        w.error = true;
                        self.requireerroryk.weight = true;
                        tmperrorcounts += 1;
                    } else {
                        w.error = false;
                        self.requireerroryk.weight = false;
                    }
                });
            }
            //for weight

            //if input field has no error continue to check min 3 file need to upload

            if (this.$refs.myVueDropzone.getAcceptedFiles().length < 1) {
                this.requireerroryk.photoerror = true;
                this.photoerror =
                    this.$refs.myVueDropzone.getAcceptedFiles().length;
                tmperrorcounts += 1;
            } else {
                this.requireerroryk.photoerror = false;
            }

            // check require error array has data show model

            if (tmperrorcounts == 0) {
                // start dz process queue
                this.$refs.myVueDropzone.processQueue();
                this.submittedLoading = 1;
            } else {
                var alertText = new Array();
                var i = 0;

                if (this.requireerroryk.name) {
                    alertText[i] = "ပစ္စည်းနာမည် ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။";
                    i++;
                }
                if (this.requireerroryk.product_code) {
                    alertText[i] = "Product code ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။";
                    i++;
                }
                if (this.requireerroryk.description) {
                    alertText[i] = "Description ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။";
                    i++;
                }
                if (this.requireerroryk.stock_count) {
                    alertText[i] = "ပစ္စည်းအရေအတွက် ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။";
                    i++;
                }
                if (this.requireerroryk.price) {
                    alertText[i] = "စျေးနှုန်း ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။";
                    i++;
                }
                if (this.requireerroryk.photoerror) {
                    alertText[i] = "ဓာတ်ပုံ ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။";
                    i++;
                }
                if (this.requireerroryk.gems) {
                    alertText[i] = "Gems Count ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။";
                    i++;
                }
                if (this.requireerroryk.weight) {
                    alertText[i] = "weight ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။";
                    i++;
                }
                if (this.requireerroryk.minprice) {
                    alertText[i] = "စျေးနှုန်း အနည်း ဆုံး 10000 ကျပ်ဖြစ်ရမည်";
                    i++;
                }
                alert(alertText.join("\n\n"));
                console.log('alertText', i, this.requireerroryk)
                if (this.name == "") {
                    $("html").animate({scrollTop: "100"});
                } else {
                    if (
                        this.requireerroryk.price == true || this.requireerroryk.minprice == true ||
                        this.stock_count == 0 ||
                        this.requireerroryk.weight
                    ) {
                        $("html").animate({scrollTop: "500"});
                    } else {
                        if (this.description == "" || this.product_code == 0) {
                            $("html").animate({scrollTop: "1000"});
                        } else {
                            if (this.requireerroryk.gems == true) {
                                $("html").animate({scrollTop: "100"});
                            } else {
                                $("html").animate({scrollTop: "100"});
                            }
                        }
                    }
                }
            }
            //processqueue is call sendevent and real sent to server
        },
        callaftermounted() {
            $(".dz-message").addClass("yk-width-full");
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

        //for check setdefault is appear in other image not in delete image
        checkhasdefaultimage: function () {
            for (
                var s = 0;
                s < document.getElementsByClassName("dz-profile-pic").length;
                s++
            ) {
                if (
                    document.getElementsByClassName("dz-profile-pic")[s].style
                        .display == "inline"
                ) {
                    return true;
                    break;
                }
            }
        },

        removefilefromdz: function (file, error, xhr) {
            //remove thumbs photo and mid photo

            const tkey = this.thumb_photos.findIndex(
                (tp) => tp.name === file.upload.filename
            );
            this.thumb_photos.splice(tkey, 1);
            //mid
            const mkey = this.mid_photos.findIndex(
                (mp) => mp.name === file.upload.filename
            );
            this.mid_photos.splice(mkey, 1);
            //remove thumbs photo and mid photo
            console.log(this.thumb_photos);

            //for default message

            if (
                this.$refs.myVueDropzone.getAcceptedFiles().length < 3 &&
                $(".dz-message").hasClass("d-none")
            ) {
                $(".dz-message").removeClass("d-none");
            }
            //for default message

            //if tempphotoname has delete image name
            var get_file_key = 0;

            get_file_key = this.tempphotonames.findIndex(
                (re) => re === file.upload.filename
            );
            //check other photo has set default icon
            if (this.checkhasdefaultimage()) {
                //only delete from deleted photo name from temphotoname array
            } else {
                //if dz-profile-pic class length not equal to 1
                if (
                    document.getElementsByClassName("dz-profile-pic").length !=
                    1
                ) {
                    if (
                        document.getElementsByClassName("dz-profile-pic")
                            .length == 0
                    ) {
                        //if dz-profile-pic class is empty
                        //set empty array to tempphotonames

                        this.tempphotonames = [];
                    } else {
                        //when user delete top photo
                        if (get_file_key == 0) {
                            this.setdefaultphoto(this.tempphotonames[1]);
                        } else {
                            //remove deleted image name from tempphotonames array

                            //show default icon on image before deleted image
                            if (get_file_key !== 0) {
                                this.setdefaultphoto(
                                    this.tempphotonames[get_file_key - 1]
                                );
                            } else {
                                this.setdefaultphoto(
                                    this.tempphotonames[get_file_key + 1]
                                );
                            }
                        }

                        //if images has grater than one
                    }
                } else {
                    //if one only image is remain just set default photo for it
                    this.setdefaultphoto(
                        document.getElementsByClassName("dz-profile-pic")[0].id
                    );

                    console.log("sec");
                }
            }
            this.tempphotonames.splice(get_file_key, 1);

            //to get image before deleted image
        },

        template: function () {
            return `<div class="dz-preview dz-file-preview">
                <div class="dz-image" style="width:145px !important;height:145px !important;margin:0px !important;">
                    <div data-dz-thumbnail-bg></div>
                </div>
                <div class="dz-details">
                    <div class="dz-size"><span data-dz-size></span></div>
                    <div class="dz-filename"><span data-dz-name></span></div>
                </div>
               <a class="dz-profile-pic yk-opa" yk-dz-default-pic style="display:none;"><span class="fas fa-check-circle"></span></a>

                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                <div class="dz-remove yk-opa" href="javascript:undefined;" data-dz-remove><span class="fas fa-times-circle"></span></div>
                <div class="dz-error-message"><span data-dz-errormessage></span></div>
<!--                // <div class="dz-success-mark"><i class="fa fa-check"></i></div>-->
<!--                <div class="dz-error-mark"><i class="fa fa-close"></i></div>-->
            </div>
        `;
        },

        thumbnail: function (file, dataUrl) {
            //resize image
            ykresizer(file, 300, 300).then((res) => {
                this.mid_photos.push({
                    name: file.upload.filename,
                    data: res,
                    type: file.type,
                });
            });
            ykresizer(file, 100, 100).then((res) => {
                this.thumb_photos.push({
                    name: file.upload.filename,
                    data: res,
                    type: file.type,
                });
            });
            //resize image
            var self = this;
            var j, len, ref, thumbnailElement, refp;
            if (file.previewElement) {
                file.previewElement.classList.remove("dz-file-preview");
                ref = file.previewElement.querySelectorAll(
                    "[data-dz-thumbnail-bg]"
                );
                refp = file.previewElement.querySelectorAll(
                    "[yk-dz-default-pic]"
                );

                for (j = 0, len = ref.length; j < len; j++) {
                    thumbnailElement = ref[j];
                    thumbnailElement.alt = file.upload.filename;
                    thumbnailElement.style.backgroundImage =
                        'url("' + dataUrl + '")';
                    refp[j].id = file.upload.filename;
                    if (
                        this.$refs.myVueDropzone.getAcceptedFiles().length === 1
                    ) {
                        //when user start add one photo auto add setdefault icon

                        if (this.checkhasdefaultimage()) {
                        } else {
                            this.setdefaultphoto(file.upload.filename);
                        }
                    } else {
                        if (this.checkhasdefaultimage()) {
                        } else {
                            //when user start add multiple photo auto add setdefault icon
                            this.setdefaultphoto(
                                this.$refs.myVueDropzone.getAcceptedFiles()[0]
                                    .upload.filename
                            );
                        }
                    }

                    //for dz upload icon
                    $(".dz-preview").removeClass("last");
                    for (
                        var cf = 0;
                        cf < this.$refs.myVueDropzone.getAcceptedFiles().length;
                        cf++
                    ) {
                        //in here i used jquery because cannot effect v-on click in dropzome template and thumbnail
                        $(document).ready(function () {
                            $(".dz-preview").click(function (e) {
                                //this is only click one class not all dz-preview classess
                                e.stopPropagation();
                                e.stopImmediatePropagation();
                                self.setdefaultphoto(e.target.alt);
                            });
                        });
                    }
                    $(".dz-preview:last").addClass("last");

                    $(".dz-message").insertAfter(".last");
                    $(".dz-message").removeClass("yk-width-full");
                }
                return setTimeout(
                    (function (_this) {
                        return function () {
                            return file.previewElement.classList.add(
                                "dz-image-preview"
                            );
                        };
                    })(this),
                    1
                );
            }

            if (this.tempphotonames.length == 0) {
                this.setdefaultphoto(file.upload.filename);
            }
            this.tempphotonames.push(file.upload.filename);
            this.requireerroryk.photo = false;
        },

        //when user added multiple file
        multiplefilesadded(files) {
            this.photoerror += files.length;
            //this is for default message

            //this is only click one class not all dz-preview classess

            for (var f = 0; f < files.length; f++) {
                this.tempphotonames.push(files[f].upload.filename);
            }
            console.log("add multi");
        },

        //custom setdefault photo function

        setdefaultphoto: function (id) {
            //hide set default icon in all dz profile pic
            var myElements = document.getElementsByClassName("dz-profile-pic");
            for (var i = 0; i < myElements.length; i++) {
                myElements[i].style.display = "none";
            }
            this.defaultphotoname = id;

            document.getElementById(id).style.display = "inline";
            console.log("f");
        },

        //if user added file excceed than 10
        maxfilesEvent: function (file) {
            this.$refs.myVueDropzone.removeFile(file);
            this.requireerroryk.push({
                errormsg: "Your Can upload maximum 10 photos",
            });

            this.showerrorwithmodel("Your Can upload maximum 10 photos");
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

        // sendevent is prepare to send before real send

        sendingEvent(files, xhr, formData) {
            //why not use v-model because vue conflit with select2 js
            formData.append("_token", this.csrf);
            formData.append("gems", JSON.stringify(this.gems));
            formData.append("formidphotos", JSON.stringify(this.mid_photos));
            formData.append(
                "forthumbphotos",
                JSON.stringify(this.thumb_photos)
            );

            formData.append("name", this.name);

            formData.append("main_category", this.main_category);
            formData.append("gender", this.gender);
            formData.append("handmade", this.handmade);
            formData.append("charge", this.charge);

            formData.append("description", this.description);
            formData.append("အထည်မပျက်_ပြန်သွင်း", this.undamage_product);
            formData.append("အထည်ပျက်စီးချို့ယွင်း", this.damage_product);
            formData.append(
                "တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ",
                this.valuable_product
            );
            formData.append(
                "gold_quality",
                document.getElementsByName("gold_quality")[0].value
            );
            formData.append(
                "gold_colour",
                document.getElementsByName("gold_colour")[0].value
            );
            formData.append("sizing_guide", this.sizing_guide);
            formData.append("stock", this.stock);
            formData.append("review", this.review);
            formData.append("category_id", this.category_id);
            formData.append("product_code", this.product_code);
            formData.append("collection_id", this.collection_id);
            formData.append("stock_count", this.stock_count);
            formData.append("diamond", this.diamond);
            formData.append("carat", this.carat);
            formData.append("pwint", this.pwint);
            formData.append("yati", this.yati);
            formData.append("d_gram", this.d_gram);
            formData.append("tags", this.tags);

            formData.append(
                "weight",
                JSON.stringify(this.$refs.aa.weight_child)
            );

            formData.append("price", this.price);
            formData.append("min_price", this.min_price);
            formData.append("max_price", this.max_price);
            formData.append("default_photo", this.defaultphotoname);
        },

        // after send
        successEvent(files, response) {
            console.log(response);

            if (response.msg == "success") {
                window.location.assign(
                    this.$hostname + "/backside/shop_owner/items/" + response.id
                );
            } else {
                alert(response.error_msg);
                if (window.confirm("Do u want to continue?")) {
                    location.assign(window.location.href);
                } else {
                    location.assign(window.location.href);
                }
            }
        },

        //if some errors appear while uploading to server
        errorEvent(file, message, xhr) {
            this.$refs.myVueDropzone.removeFile(file);
            $('.dz-error').remove();


            this.showerrorwithmodel(message);

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
