<template>
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Edit Your Item</h3>
                    <div
                        class="alert alert-success"
                        v-if="this.editdata.YkgetDiscount != 0"
                        role="alert"
                    >
                        This item is discounted item !
                    </div>
                </div>
                <div>
                    <div class="card-body">
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
                        </div>
                        <div class="row">
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
                        </div>

                        <br />
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gold Colour</label>
                                    <select
                                        class="form-control select2"
                                        v-model="gold_colour"
                                        v-bind:class="{
                                            'border-danger': forrequire(
                                                this.requireerroryk.gold_colour,
                                                this.gold_colour_error
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
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-6 d-none d-none">
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
                                                style="
                                                    color: red;
                                                    font-size: 12px !important;
                                                "
                                                >***</span
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
                                                style="
                                                    color: red;
                                                    font-size: 12px !important;
                                                "
                                                >***</span
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
                                                style="
                                                    color: red;
                                                    font-size: 12px !important;
                                                "
                                                >***</span
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
                                                style="
                                                    color: red;
                                                    font-size: 12px !important;
                                                "
                                                >***</span
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
                        </div>
                        <br />

                        <div class="row">
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
                                            'border-danger': forrequire(
                                                this.requireerroryk.description,
                                                this.description
                                            ),
                                        }"
                                        rows="3"
                                        placeholder="Enter ..."
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender </label>
                                    <select
                                        class="form-control select2"
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

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>အလျော့တွက် </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-bind:class="{
                                            'border-danger': forrequire(
                                                this.requireerroryk.name,
                                                this.name
                                            ),
                                        }"
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>အထည်မပျက် ပြန်သွင်း </label>
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
                                    <label>အထည်ပျက်စီးချို့ယွင်း</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="damage_product"
                                        placeholder="10 % or 10000ကျပ် "
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label
                                        >တန်ဖိုးမြင့်အထည် နှင့် အထည်မပျက်ပြန်လဲ
                                    </label>

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
                        <div class="row">
                            <!-- /.col -->
                            <!--                            //price-->

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
                                            v-bind:class="[
                                                this.requireerroryk.minprice
                                                    ? 'border-danger'
                                                    : '',
                                                this.requireerroryk.price
                                                    ? 'border-danger'
                                                    : '',
                                            ]"
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
                                            v-bind:class="[
                                                this.requireerroryk.minprice
                                                    ? 'border-danger'
                                                    : '',
                                                this.requireerroryk.price
                                                    ? 'border-danger'
                                                    : '',
                                            ]"
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
                                            v-bind:class="[
                                                this.requireerroryk.minprice
                                                    ? 'border-danger'
                                                    : '',
                                                this.requireerroryk.price
                                                    ? 'border-danger'
                                                    : '',
                                            ]"
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
                                </div>
                            </div>
                            <Ykweight
                                ref="aa"
                                :editdataweight="this.editdata.weight"
                            ></Ykweight>
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
                        <div class="row">
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
                        <div class="row">
                            <div class="col-md-6 pt-3">
                                <div class="form-group">
                                    <label>Collection</label>
                                    <select
                                        class="form-control"
                                        v-model="collection_id"
                                        style="width: 100%"
                                    >
                                        <option
                                            v-for="collection in this
                                                .collection"
                                            :key="collection.index"
                                            :value="collection.id"
                                        >
                                            {{ collection.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- </br> -->
                        <div class="row">
                            <div class="col-md-12 pt-3">
                                <div
                                    id="myModal"
                                    v-bind:class="{ hide: hidetoggle }"
                                    class="modal fade"
                                    tabindex="-1"
                                >
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    Modal Title
                                                </h5>
                                                <!--                                                <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                                            </div>
                                            <div class="modal-body">
                                                <span>
                                                    {{ this.dzerror }}
                                                </span>
                                            </div>
                                            <div class="modal-footer">
                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                    @click="
                                                        clearerrormsgfrommodel
                                                    "
                                                >
                                                    Close Modal
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    style="text-align: center"
                                    v-bind:class="{
                                        'color-danger':
                                            this.requireerroryk.photo,
                                    }"
                                >
                                    <label>အနည်းဆုံး ပုံ တစ်ပုံတင်ပါ </label>
                                </div>

                                <vue-dropzone
                                    ref="myVueDropzone"
                                    :useCustomSlot="true"
                                    v-on:vdropzone-sending-multiple="
                                        sendingEvent
                                    "
                                    v-on:vdropzone-error-multiple="errorEvent"
                                    v-on:vdropzone-thumbnail="thumbnail"
                                    :include-styling="false"
                                    v-on:vdropzone-files-added="
                                        multiplefilesadded
                                    "
                                    v-on:vdropzone-mounted="callaftermount"
                                    v-on:vdropzone-success-multiple="
                                        successEvent
                                    "
                                    v-on:vdropzone-max-files-exceeded="
                                        maxfilesEvent
                                    "
                                    :options="dropzoneOptions"
                                    v-on:vdropzone-removed-file="
                                        whenuserremoveimage
                                    "
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
                        </div>
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
                </div>
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
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import axios from "axios";
import $ from "jquery";
import Ykweight from "./Ykweight";
import Multiselect from "vue-multiselect-with-duplicates";
import ykresizer from "./forimageresize/ykresizer";
import pricelogicsn from "./pricelogin/pricelogic";

export default {
    props: ["editdata", "collection", "link", "catlist", "main_cat"],

    name: "YkDropzoneForEdit",

    data: function () {
        return {
            discount: { show: "no", newprice: "0", newmin: "0", newmax: "0" },
            unsetdiscount: false,
            mid_photos: [],
            thumb_photos: [],
            submittedLoading: 0,
            tags: [],
            // for gem
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
            collection_id: 0,
            //forstock
            stock: "In Stock",
            stock_count: 0,
            //forstock

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

            // SN Price Number to Word Logic
            snprice_to_word_exact: "",
            snprice_to_word_min: "",
            snprice_to_word_max: "",

            renameFilename: function (file) {
                let newname = Date.now() + file;
                return newname;
            },
            tempphotonames: [],
            hostname: "",
            gold_colour_error: "",
            gold_colour: "",
            main_category: 1,
            //forerror
            requireerroryk: {
                gender: false,
                minprice: false,
                gems: false,
                diamond: false,
                photo: false,
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
            },
            handmade: "",
            charge: "",
            //forerror
            defaultphotoname: "",
            responseafterdelete: "",
            photoerror: 0,

            existingFiles: [],
            hidetoggle: false,
            // csrf: document
            //     .querySelector('meta[name="csrf-token"]')
            //     .getAttribute("content"),
            dropzoneOptions: {
                url: this.link,
                acceptedFiles: "image/*",
                maxFiles: 10,
                method: "POST",
                autoDiscover: false,
                previewTemplate: this.template(),
                renameFilename: function (file) {
                    let newname = Date.now() + file;
                    return newname;
                },
                timeout: 300000,

                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxThumbnailFilesize: 111,

                maxFilesize: 20971520, //20mb
                headers: {
                    "My-Awesome-Header": "header value",
                    // "X-CSRF-TOKEN": document
                    //     .querySelector('meta[name="csrf-token"]')
                    //     .getAttribute("content"),
                },
            },

            valuable_product: 0,
            undamage_product: 0,
            damage_product: 0,
        };
    },

  mounted() {
    console.log(this.editdata.YkgetDiscount);

    this.main_category = this.editdata.main_category;
    this.valuable_product = this.editdata.တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ;
    this.undamage_product = this.editdata.အထည်မပျက်_ပြန်သွင်း;
    this.damage_product = this.editdata.အထည်ပျက်စီးချို့ယွင်း;
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
        this.setdefaultphoto(this.editdata.default_photo);
    },
    components: {
        vueDropzone: vue2Dropzone,
        multi: Multiselect,
        Ykweight: Ykweight,
    },
    methods: {
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
            this.requireerroryk.weight = value;
        },
        //for weight
        inputHandler(selectedOption, id) {
            this.gems.push(selectedOption);
        },
        //id is index change in core vue multiselect in node_module (!important)
        removeHandler(removedOption, id) {
            // this.gems.splice(id, 1);
        },

        forrequire: function (data, model) {
            if (data == true && (model == "" || model == 0)) {
                return true;
            }
        },
        forrequirephoto: function (data, model) {
            if (data == true && model < 1) {
                return true;
            }
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

        setdefaultphoto: function (id) {
            //hide set default icon in all dz profile pic
            var myElements = document.getElementsByClassName("dz-profile-pic");
            for (var i = 0; i < myElements.length; i++) {
                myElements[i].style.display = "none";
            }
            this.defaultphotoname = id;

            document.getElementById(id).style.display = "inline";
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

        //this function call while image thumbnail is created
        thumbnail: function (file, dataUrl) {
            if (typeof file.upload != "undefined") {
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
            }

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
                    // this is for server photo
                    //note here why i use file.name and file.upload.filename because when i manullay added file from server to dz i cannot set file.upload filename  so that i use this
                    if (typeof file.upload == "undefined") {
                        thumbnailElement.alt = file.name;
                    } else {
                        thumbnailElement.alt = file.upload.filename;
                    }

                    // this is for server photo

                    thumbnailElement.style.backgroundImage =
                        'url("' + dataUrl + '")';

                    refp[j].id = file.name;

                    if (typeof file.upload == "undefined") {
                        refp[j].id = file.name;
                    } else {
                        refp[j].id = file.upload.filename;
                    }

                    //for dz upload icon
                    $(".dz-preview").removeClass("last");

                    for (var cf = 0; cf < this.existingFiles.length; cf++) {
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
                    //here is console error

                    if (this.tempphotonames.length == 0) {
                        this.setdefaultphoto(file.name);
                    }
                    this.tempphotonames.push(file.name);
                    this.requireerroryk.photo = false;

                    //for dz upload icon
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
        },

        callaftermount: function () {
            $(".dz-message").addClass("yk-width-full");

            var url = [];
            if (this.editdata.photo_one != "") {
                this.tempphotonames.push("photo_one");

                this.existingFiles.push({
                    name: "photo_one",
                    size: 423,
                    type: "image/jpg",
                });
                url.push(
                    process.env.MIX_DO_URL + "/items/" + this.editdata.photo_one
                );
            }
            if (this.editdata.photo_two != "") {
                this.tempphotonames.push("photo_two");

                this.existingFiles.push({
                    name: "photo_two",
                    size: 323,
                    type: "image/jpg",
                });
                url.push(
                    process.env.MIX_DO_URL + "/items/" + this.editdata.photo_two
                );
            }
            if (this.editdata.photo_three != "") {
                this.tempphotonames.push("photo_three");

                this.existingFiles.push({
                    name: "photo_three",
                    size: 223,
                    type: "image/jpg",
                });
                url.push(
                    process.env.MIX_DO_URL +
                        "/items/" +
                        this.editdata.photo_three
                );
            }
            if (this.editdata.photo_four != "") {
                this.tempphotonames.push("photo_four");

                this.existingFiles.push({
                    name: "photo_four",
                    size: 223,
                    type: "image/jpg",
                });
                url.push(
                    process.env.MIX_DO_URL +
                        "/items/" +
                        this.editdata.photo_four
                );
            }
            if (this.editdata.photo_five != "") {
                this.tempphotonames.push("photo_five");

                this.existingFiles.push({
                    name: "photo_five",
                    size: 223,
                    type: "image/jpg",
                });
                url.push(
                    process.env.MIX_DO_URL +
                        "/items/" +
                        this.editdata.photo_five
                );
            }
            if (this.editdata.photo_six != "") {
                this.tempphotonames.push("photo_six");

                this.existingFiles.push({
                    name: "photo_six",
                    size: 223,
                    type: "image/jpg",
                });
                url.push(
                    process.env.MIX_DO_URL + "/items/" + this.editdata.photo_six
                );
            }
            if (this.editdata.photo_seven != "") {
                this.tempphotonames.push("photo_seven");

                this.existingFiles.push({
                    name: "photo_seven",
                    size: 223,
                    type: "image/jpg",
                });
                url.push(
                    process.env.MIX_DO_URL +
                        "/items/" +
                        this.editdata.photo_seven
                );
            }
            if (this.editdata.photo_eight != "") {
                this.tempphotonames.push("photo_eight");

                this.existingFiles.push({
                    name: "photo_eight",
                    size: 223,
                    type: "image/jpg",
                });
                url.push(
                    process.env.MIX_DO_URL +
                        "/items/" +
                        this.editdata.photo_eight
                );
            }
            if (this.editdata.photo_nine != "") {
                this.tempphotonames.push("photo_nine");

                this.existingFiles.push({
                    name: "photo_nine",
                    size: 223,
                    type: "image/jpg",
                });
                url.push(
                    process.env.MIX_DO_URL +
                        "/items/" +
                        this.editdata.photo_nine
                );
            }
            if (this.editdata.photo_ten != "") {
                this.tempphotonames.push("photo_ten");

                this.existingFiles.push({
                    name: "photo_ten",
                    size: 223,
                    type: "image/jpg",
                });
                url.push(
                    process.env.MIX_DO_URL + "/items/" + this.editdata.photo_ten
                );
            }
            for (var i = 0; i < this.existingFiles.length; i++) {
                this.$refs.myVueDropzone.manuallyAddFile(
                    this.existingFiles[i],
                    url[i]
                );
            }
        },
        //when user added multiple file
        multiplefilesadded(files) {},

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

        //when user click remove button call this function
        whenuserremoveimage: function (file, error, xhr, data = "") {
            console.log(file);
            if (typeof file.upload !== "undefined") {
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
                //for default message
            } else {
                this.removeimgqueue.push({
                    column_name: file.name,
                    name: this.editdata[file.name],
                });
            }

            console.log(this.removeimgqueue);

            //if tempphotoname has delete image name
            var get_file_key = 0;
            get_file_key = this.tempphotonames.findIndex(
                (re) => re === file.name
            );

            //check other photo has set default icon
            if (this.checkhasdefaultimage()) {
                //only delete from deleted photo name from temphotoname array
                console.log("has");
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
                            this.setdefaultphoto(
                                this.tempphotonames[get_file_key - 1]
                            );
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
                this.tempphotonames.splice(get_file_key, 1);
                console.log(this.tempphotonames);
            }
            //to get image before deleted image
        },
        removeimagefromserver: function () {
            this.removeimgqueue.map((rimg) => {
                if (typeof rimg.name != undefined) {
                    axios
                        .post(
                            this.$hostname + "/backside/shop_owner/removeimage",
                            {
                                column_name: rimg.column_name,
                                id: this.editdata.id,
                                name: rimg.name,
                            },
                            {
                                headers: {
                                    "My-Awesome-Header": "header value",
                                    // "X-CSRF-TOKEN": document
                                    //     .querySelector('meta[name="csrf-token"]')
                                    //     .getAttribute("content"),
                                },
                            }
                        )
                        .then((response) => {
                            console.log("removed from server");
                        });
                }
            });
        },

        // check added photo
        addedphoto: function (file) {
            console.log(file);
        },

        //if user added file excceed than 10
        maxfilesEvent: function (file) {
            this.$refs.myVueDropzone.removeFile(file);
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

        // when click submit button

        submitform: function (event) {
            event.preventDefault();
            event.stopPropagation();
            let tmperrorcounts = 0;

            // check all input field has value
            if (this.name == "") {
                this.requireerroryk.name = true;
                tmperrorcounts += 1;
            }
            if (this.main_category == "") {
                this.requireerroryk.main_category = true;
                tmperrorcounts += 1;
            }

            if (this.gender == "") {
                this.requireerroryk.gender = true;
                tmperrorcounts += 1;
            }
            if (this.description == "") {
                this.requireerroryk.description = true;

                tmperrorcounts += 1;
            }

            if (this.gold_quality == "") {
                this.requireerroryk.gold_quality = true;
                tmperrorcounts += 1;
            }
            if (this.gold_colour == "") {
                this.requireerroryk.gold_colour = true;
                tmperrorcounts += 1;
            }

            if (this.category_id == "") {
                this.requireerroryk.category_id = true;
                tmperrorcounts += 1;
            }
            if (this.product_code == 0) {
                this.requireerroryk.product_code = true;
                tmperrorcounts += 1;
            }
            if (this.exceptorrates == "Range") {
                if (this.min_price < 10000 || this.max_price < 10000) {
                    tmperrorcounts += 1;
                    this.requireerroryk.minprice = true;
                } else {
                    this.requireerroryk.minprice = false;
                }
            } else {
                if (this.price < 10000) {
                    tmperrorcounts += 1;
                    this.requireerroryk.minprice = true;
                } else {
                    this.requireerroryk.minprice = false;
                }
            }

            // if (this.weight == 0) {
            //     this.requireerroryk.push({errormsg: 'Weight  field require'});
            //
            //
            // }
            if (this.price == 0 && this.min_price == 0 && this.max_price == 0) {
                this.requireerroryk.price = true;
                tmperrorcounts += 1;
            }
            if (this.stock == "In Stock" && this.stock_count == 0) {
                this.requireerroryk.stock_count = true;
                tmperrorcounts += 1;
            }
            if (this.diamond == "Yes" && this.carat == 0) {
                this.requireerroryk.diamond = true;
                tmperrorcounts += 1;
            }
            if (this.diamond == "Yes" && this.yati == 0) {
                this.requireerroryk.diamond = true;
                tmperrorcounts += 1;
            }
            if (this.diamond == "Yes" && this.pwint == 0) {
                this.requireerroryk.diamond = true;
                tmperrorcounts += 1;
            }
            if (this.diamond == "Yes" && this.d_gram == 0) {
                this.requireerroryk.diamond = true;
                tmperrorcounts += 1;
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
                }
            });

            // for weight require
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
                    }
                });
            }

            //for gems
            //if input field has no error continue to check min 3 file need to upload
            //if originial image data array length < 3
            var temlength =
                this.existingFiles.length -
                this.removeimgqueue.length +
                this.$refs.myVueDropzone.getAcceptedFiles().length;
            console.log("fefe");

            console.log(this.existingFiles.length);
            console.log(this.removeimgqueue.length);
            console.log(this.$refs.myVueDropzone.getAcceptedFiles().length);
            console.log(temlength);

            if (temlength == 0) {
                //if originial image data array length < 3
                this.requireerroryk.photo = true;
                this.photoerror = temlength;
                tmperrorcounts += 1;

                console.log(this.$refs.myVueDropzone.getAcceptedFiles());
            }

            //async function
            async function serverprocess() {
                await self.removeimagefromserver();
                console.log(self.removeimgqueue);
                await self.$refs.myVueDropzone.processQueue();
            }

            //async function
            //async function
            async function serverprocesscustom() {
                console.log(self.removeimgqueue);

                await self.removeimagefromserver();
                await self.customupload();
            }

            //async function

            // check require error array has data show model
            console.log(tmperrorcounts);
            if (tmperrorcounts == 0) {
                // start dz process queue
                for (var i = 0; i < this.removeimgqueue.length; i++) {}
                //if no image is addded to dz will call customupload function
                if (this.$refs.myVueDropzone.getAcceptedFiles().length != 0) {
                    this.submittedLoading = 1;
                    serverprocess();
                } else {
                    serverprocesscustom();
                    console.log("custom upload");
                }
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
                    alertText[i] =
                        "ပစ္စည်းအရေအတွက် ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။";
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
                if (this.name == "") {
                    $("html").animate({ scrollTop: "100" });
                } else {
                    if (
                        this.requireerroryk.price == true ||
                        this.requireerroryk.minprice == true ||
                        this.stock_count == 0 ||
                        this.requireerroryk.weight
                    ) {
                        $("html").animate({ scrollTop: "500" });
                    } else {
                        if (this.description == "" || this.product_code == 0) {
                            $("html").animate({ scrollTop: "1000" });
                        } else {
                            $("html").animate({ scrollTop: "100" });
                        }
                    }
                }
            }
            //processqueue is call sendevent and real sent to server
        },

        //this is for custom upload to server while no image is added to dz
        customupload: function () {
            var bodyFormData = new FormData();
            bodyFormData.append("gems", JSON.stringify(this.gems));
            bodyFormData.append(
                "weight",
                JSON.stringify(this.$refs.aa.weight_child)
            );

            bodyFormData.append("name", this.name);
            bodyFormData.append("main_category", this.main_category);
            bodyFormData.append("gender", this.gender);
            bodyFormData.append("handmade", this.handmade);
            bodyFormData.append("charge", this.charge);
            bodyFormData.append("id", this.editdata.id);
            // bodyFormData.append(
            //     "_token",
            //     document
            //         .querySelector('meta[name="csrf-token"]')
            //         .getAttribute("content")
            // );

            bodyFormData.append("stock", this.stock);
            bodyFormData.append("stock_count", this.stock_count);
            bodyFormData.append("description", this.description);

            bodyFormData.append("အထည်မပျက်_ပြန်သွင်း", this.undamage_product);
            bodyFormData.append("အထည်ပျက်စီးချို့ယွင်း", this.damage_product);
            bodyFormData.append(
                "တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ",
                this.valuable_product
            );
            bodyFormData.append("gold_quality", this.gold_quality);
            bodyFormData.append("gold_colour", this.gold_colour);
            bodyFormData.append("collection_id", this.collection_id);

            bodyFormData.append("category_id", this.category_id);
            bodyFormData.append("product_code", this.product_code);

            // for price
            bodyFormData.append("price", this.price);
            bodyFormData.append("min_price", this.min_price);
            bodyFormData.append("max_price", this.max_price);
            // for price

            bodyFormData.append("diamond", this.diamond);
            bodyFormData.append("carat", this.carat);
            bodyFormData.append("pwint", this.pwint);
            bodyFormData.append("yati", this.yati);
            bodyFormData.append("d_gram", this.d_gram);
            bodyFormData.append("tags", this.tags);

            bodyFormData.append("default_photo", this.defaultphotoname);
            bodyFormData.append("discount", JSON.stringify(this.discount));
            bodyFormData.append("unsetdiscount", this.unsetdiscount);

            //or

      axios
        .post(this.$hostname + "/backside/shop_owner/customedit", bodyFormData, {
          header: {
            "Content-Type": "multipart/form-data",
            // "X-CSRF-TOKEN": document
            //     .querySelector('meta[name="csrf-token"]')
            //     .getAttribute("content"),
          },
        })
        .then((response) => {
          console.log(response);
          if (response.data.msg == "success") {
            window.location.assign(
              this.$hostname + "/backside/shop_owner/items/" + response.data.id
            );
          } else {
            alert(response.data.error_msg);
            if (window.confirm("Do u want to continue?")) {
              location.assign(window.location.href);
            } else {
              location.assign(window.location.href);
            }
          }
        });
    },
    // sendevent is prepare to send before real send

        sendingEvent(files, xhr, formData) {
            console.log(files.length);

            //why not use v-model because vue conflit with select2 js
            // formData.append("_token", this.csrf);
            formData.append("gems", JSON.stringify(this.gems));

            formData.append("discount", JSON.stringify(this.discount));
            formData.append("unsetdiscount", this.unsetdiscount);

            formData.append("name", this.name);
            formData.append("gender", this.gender);
            formData.append("handmade", this.handmade);
            formData.append("charge", this.charge);

            formData.append("id", this.editdata.id);
            formData.append("product_code", this.product_code);

            formData.append("stock", this.stock);
            formData.append("stock_count", this.stock_count);
            formData.append("description", this.description);
            formData.append("tags", this.tags);

            formData.append("အထည်မပျက်_ပြန်သွင်း", this.undamage_product);
            formData.append("အထည်ပျက်စီးချို့ယွင်း", this.damage_product);
            formData.append(
                "တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ",
                this.valuable_product
            );
            formData.append("gold_quality", this.gold_quality);
            formData.append("gold_colour", this.gold_colour);
            formData.append("collection_id", this.collection_id);

            formData.append("category_id", this.category_id);

            //for price
            formData.append("price", this.price);
            formData.append("min_price", this.min_price);
            formData.append("max_price", this.max_price);
            //for price
            //for diamond
            formData.append("diamond", this.diamond);
            formData.append("carat", this.carat);
            formData.append("pwint", this.pwint);
            formData.append("yati", this.yati);
            formData.append("d_gram", this.d_gram);
            //for diamond
            //for weight
            formData.append(
                "weight",
                JSON.stringify(this.$refs.aa.weight_child)
            );
            //for weight

            formData.append("default_photo", this.defaultphotoname);
            formData.append("formidphotos", JSON.stringify(this.mid_photos));
            formData.append(
                "forthumbphotos",
                JSON.stringify(this.thumb_photos)
            );
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
            $(".dz-error").remove();

            this.showerrorwithmodel(message);
        },
    },
};
</script>
