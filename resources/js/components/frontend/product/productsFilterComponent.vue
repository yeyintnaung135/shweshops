<template>
    <div>
        <div
            v-if="this.showbigloader"
            class="yk-wrapper fff"
            style="
                position: relative !important;
                margin-top: 36px;
                height: 560px;
            "
        >
            <div class="ct-spinner5">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <div class="container-fluid px-1" v-if="!this.showbigloader">
            <div class="mb-3 col-12 mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="state-dropdown">
                            <input id="toggle2" type="checkbox" />
                            <label for="toggle2" class="animate"
                                >{{
                                    this.state_label
                                        ? this.state_label + "ဆိုင်များ"
                                        : "ဆိုင်များအားလုံး"
                                }}
                                <i class="fas fa-chevron-down"></i
                            ></label>
                            <ul class="animate p-0">
                                <li
                                    class="animate"
                                    value="all"
                                    @click="filterShop()"
                                >
                                    ဆိုင်များအားလုံး
                                </li>
                                <li
                                    class="animate"
                                    v-for="state in this.states"
                                    :value="state.id"
                                    :key="state.key"
                                    @click="
                                        filterShop(state.myan_name, state.id)
                                    "
                                >
                                    {{ state.myan_name }}ဆိုင်များ
                                </li>
                            </ul>
                        </div>
                    </div>
                    <button
                        class="p-2 filter-button d-block d-md-none"
                        @click="showFilter"
                    >
                        <i class="fa-solid fa-sliders-h"></i> Filter
                    </button>
                </div>

                <div class="col-12 pt-4 main-content">
                    <slick ref="slick" :options="settings">
                        <div>
                            <article class="post-wrapper">
                                <div
                                    id="cato_slide"
                                    class="post-img sop-cato-img"
                                >
                                    <input
                                        type="checkbox"
                                        value="all"
                                        id="allshop"
                                        v-model="byspecificshop"
                                        @change="
                                            checkedSelectedShop(),
                                                checkedF(),
                                                removeSelectOther()
                                        "
                                        class="shop-icon"
                                    />
                                    <label
                                        for="allshop"
                                        class="px-1 px-md-2 mb-0"
                                    >
                                        <img
                                            :src="
                                                host + '/test/img/allshops.png'
                                            "
                                            class="attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded sop-image"
                                            alt=""
                                        />
                                    </label>
                                </div>
                                <div class="post-info">
                                    <div
                                        class="mt-2 sop-font-content text-center w-100"
                                    >
                                        <p class="sop-item-count mb-2">
                                            All Shops
                                        </p>
                                        <span class="textsmall">
                                            (ဆိုင်အားလုံး)
                                        </span>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div
                            v-for="f in this.shoplist"
                            :key="f.id"
                            class="shop-count"
                        >
                            <article class="post-wrapper">
                                <div
                                    id="cato_slide"
                                    class="post-img sop-cato-img"
                                >
                                    <input
                                        type="checkbox"
                                        :value="f.id"
                                        :id="f.id"
                                        v-model="byspecificshop"
                                        @change="
                                            checkedF(), checkedSelectedShop()
                                        "
                                        class="shop-icon"
                                    />
                                    <label
                                        :for="f.id"
                                        class="px-1 px-md-2 mb-0"
                                    >
                                        <img
                                            :src="
                                                host +
                                                '/images/logo/mid/' +
                                                f.shop_logo
                                            "
                                            class="attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded sop-image"
                                            alt=""
                                        />
                                    </label>
                                </div>
                                <div class="post-info">
                                    <div
                                        class="mt-2 sop-font-content text-center w-100"
                                    >
                                        <p class="sop-item-count mb-2">
                                            {{
                                                f.shop_name | strlimit(10, "..")
                                            }}
                                        </p>
                                        <span
                                            v-if="f.shop_name_myan"
                                            class="sop-textsmall"
                                            >({{
                                                f.shop_name_myan
                                                    | strlimit(20, "..")
                                            }})</span
                                        >
                                    </div>
                                </div>
                            </article>
                        </div>
                    </slick>
                </div>
            </div>
            <div class="row container-fluid p-0 m-0">
                <div class="col-3 mb-2 position-absolute sorting-filter">
                    <div class="position-relative">
                        <i class="fas fa-filter d-none"></i>
                        <select
                            class="form-control shadow-none"
                            v-model="sortby"
                            @change="getSorting"
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
                                v-if="this.isdiscount == 'yes'"
                                value="discountpercent"
                            >
                                Discount Percent
                            </option>
                        </select>
                    </div>
                </div>
                <div
                    class="d-none d-md-block col-12 col-md-3 pe-md-3 pe-lg-5 filter-container"
                >
                    <div class="filter-sticky">
                        <button
                            @click="hideFilter"
                            class="d-block d-md-none filter-close-button"
                        >
                            <i class="fa fa-close"></i>
                        </button>
                        <h3 class="mb-3">Filters</h3>
                        <div class="col-12 mb-2 mt-2">
                            <div class="sn-price-range">
                                <label class="sn-label">Price Range</label>
                                <div
                                    class="sn-from-price mm_font mb-3"
                                    v-click-outside="fromPriceBoxBlur"
                                >
                                    <span
                                        class="sn-price-error"
                                        v-if="error_message"
                                        >Invalid Price Range</span
                                    >
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
                            </div>
                        </div>
                        <div class="col-12 mb-2 mt-2 sn-radio-filter">
                            <label class="sn-label" for="">Product Type</label>

                            <radio
                                name="product_type"
                                value="all"
                                v-model="main_product_type"
                                @input="getMainProductType"
                            >
                                All
                            </radio>
                            <radio
                                name="product_type"
                                value="Gold ( ရွှေ )"
                                v-model="main_product_type"
                                @input="getMainProductType"
                            >
                                Gold (ရွှေ)
                            </radio>
                            <radio
                                name="product_type"
                                value="Diamond ( စိန် )"
                                v-model="main_product_type"
                                @input="getMainProductType"
                            >
                                Diamond ( စိန် )
                            </radio>
                            <radio
                                name="product_type"
                                value="White Gold ( ရွှေဖြူ )"
                                v-model="main_product_type"
                                @input="getMainProductType"
                            >
                                White Gold ( ရွှေဖြူ )
                            </radio>
                            <radio
                                name="product_type"
                                value="Platinum ( ပလက်တီနမ် )"
                                v-model="main_product_type"
                                @input="getMainProductType"
                            >
                                Platinum ( ပလက်တီနမ် )
                            </radio>
                            <radio
                                name="product_type"
                                value="18k ( 12 ပဲရည် ရွှေ )"
                                v-model="main_product_type"
                                @input="getMainProductType"
                            >
                                18k ( 12 ပဲရည် ရွှေ )
                            </radio>
                        </div>

                        <div class="col-12 mb-2 mt-2 sn-radio-filter">
                            <label class="sn-label" for=""
                                >Product Qualities</label
                            >
                            <radio
                                name="product_quality"
                                value="All"
                                v-model="selected_product_quality"
                                @input="getGender"
                            >
                                All
                            </radio>
                            <radio
                                name="product_quality"
                                value="24K ၁၆ပဲရည်"
                                v-model="selected_product_quality"
                                @input="getGender"
                            >
                                24K ၁၆ပဲရည်
                            </radio>
                            <radio
                                name="product_quality"
                                value="23K ၁၅ပဲရည်"
                                v-model="selected_product_quality"
                                @input="getGender"
                            >
                                23K ၁၅ပဲရည်
                            </radio>
                            <radio
                                name="product_quality"
                                value="22K ၁၄ပဲ ၂ပြားရည်"
                                v-model="selected_product_quality"
                                @input="getGender"
                            >
                                22K ၁၄ပဲ ၂ပြားရည်
                            </radio>
                            <radio
                                v-if="this.showquality"
                                name="product_quality"
                                value="21K ၁၄ပဲရည်"
                                v-model="selected_product_quality"
                                @input="getGender"
                            >
                                21K ၁၄ပဲရည်
                            </radio>
                            <radio
                                v-if="this.showquality"
                                name="product_quality"
                                value="20K ၁၃ပဲရည်"
                                v-model="selected_product_quality"
                                @input="getGender"
                            >
                                20K ၁၃ပဲရည်
                            </radio>
                            <radio
                                v-if="this.showquality"
                                name="product_quality"
                                value="19K ၁၂ပဲ ၂ပြားရည်"
                                v-model="selected_product_quality"
                                @input="getGender"
                            >
                                19K ၁၂ပဲ ၂ပြားရည်
                            </radio>
                            <radio
                                v-if="this.showquality"
                                name="product_quality"
                                value="18K ၁၂ပဲရည်"
                                v-model="selected_product_quality"
                                @input="getGender"
                            >
                                18K ၁၂ပဲရည်
                            </radio>
                            <radio
                                v-if="this.showquality"
                                name="product_quality"
                                value="17K ၁၁ပဲ ၂ပြားရည်"
                                v-model="selected_product_quality"
                                @input="getGender"
                            >
                                17K ၁၁ပဲ ၂ပြားရည်
                            </radio>
                            <radio
                                v-if="this.showquality"
                                name="product_quality"
                                value="16K ၁၁ပဲရည်"
                                v-model="selected_product_quality"
                                @input="getGender"
                            >
                                16K ၁၁ပဲရည်
                            </radio>
                            <radio
                                v-if="this.showquality"
                                name="product_quality"
                                value="15K ၁၀ပဲရည်"
                                v-model="selected_product_quality"
                                @input="getGender"
                            >
                                15K ၁၀ပဲရည်
                            </radio>
                            <radio
                                v-if="this.showquality"
                                name="product_quality"
                                value="14K ၉ပဲရည်"
                                v-model="selected_product_quality"
                                @input="getGender"
                            >
                                14K ၉ပဲရည်
                            </radio>
                            <radio
                                v-if="this.showquality"
                                name="product_quality"
                                value="13K ၈ပဲ ၂ပြားရည်"
                                v-model="selected_product_quality"
                                @input="getGender"
                            >
                                13K ၈ပဲ ၂ပြားရည်
                            </radio>
                            <radio
                                v-if="this.showquality"
                                name="product_quality"
                                value="12K ၈ပဲရည်"
                                v-model="selected_product_quality"
                                @input="getGender"
                            >
                                12K ၈ပဲရည်
                            </radio>

                            <button
                                @click="qseemore()"
                                class="d-block seemorebtn"
                            >
                                {{ this.seemoretext }}
                            </button>
                        </div>

                        <div class="col-12 mb-2 mt-2">
                            <label class="sn-label" for="">Categories </label>
                            <span
                                v-for="cl in this.notnullcatlist.slice(0, 4)"
                                :key="cl.category_id"
                                class="mm_font"
                            >
                                <checkbox
                                    :name="cl.mm_name"
                                    :value="cl.category_id"
                                    v-model="specific_cat_id"
                                    @input="setCategory()"
                                >
                                    {{ cl.category_id }} ({{ cl.mm_name }})
                                </checkbox>
                            </span>
                            <div id="cat-more">
                                <span
                                    v-for="cl in this.notnullcatlist.slice(4)"
                                    :key="cl.category_id"
                                    class="mm_font"
                                >
                                    <checkbox
                                        :name="cl.mm_name"
                                        :value="cl.category_id"
                                        v-model="specific_cat_id"
                                        @input="setCategory()"
                                    >
                                        {{ cl.category_id }} ({{ cl.mm_name }})
                                    </checkbox>
                                </span>
                            </div>
                            <button
                                @click="catSeeMore()"
                                class="d-block"
                                id="cat-more-btn"
                            >
                                See more...
                            </button>
                        </div>

                        <div class="col-12 mb-2 mt-2">
                            <label class="sn-label" for="">Discount</label>
                            <checkbox
                                name="isdiscount"
                                value="yes"
                                v-model="checkdiscount"
                                @input="isDiscount()"
                            >
                                Discount Products Only
                            </checkbox>
                        </div>

                        <div class="col-12 mb-2 mt-2 gems-container">
                            <label class="sn-label" for="">Included Gems</label>
                            <span
                                v-for="(gem, index) in this.gems.slice(0, 4)"
                                :key="index"
                                class="mm_font position-relative mb-3 d-block"
                            >
                                <checkbox
                                    :name="gem[0]"
                                    :value="gem[0]"
                                    v-model="byspecificgems"
                                    @input="setGems()"
                                >
                                    <span
                                        class="gem-checked-icon position-absolute"
                                        ><i class="fa-solid fa-check"></i
                                    ></span>
                                    <span class="gem-img">
                                        <img
                                            :src="
                                                host +
                                                '/images/icons/included_gems/' +
                                                gem[1]
                                            "
                                        />
                                    </span>
                                    {{ gem[0] }}
                                </checkbox>
                            </span>
                            <div id="gems-more">
                                <span
                                    v-for="(gem, index) in this.gems.slice(4)"
                                    :key="index"
                                    class="mm_font position-relative mb-3 d-block"
                                >
                                    <checkbox
                                        :name="gem[0]"
                                        :value="gem[0]"
                                        v-model="byspecificgems"
                                        @input="setGems()"
                                    >
                                        <span
                                            class="gem-checked-icon position-absolute"
                                            ><i class="fa-solid fa-check"></i
                                        ></span>
                                        <span class="gem-img">
                                            <img
                                                :src="
                                                    host +
                                                    '/images/icons/included_gems/' +
                                                    gem[1]
                                                "
                                            />
                                        </span>
                                        {{ gem[0] }}
                                    </checkbox>
                                </span>
                            </div>
                            <button
                                @click="gemsSeeMore()"
                                class="d-block"
                                id="gems-more-btn"
                            >
                                See more...
                            </button>
                        </div>

                        <div class="col-12 mb-2 mt-2 sn-radio-filter">
                            <label class="sn-label" for="">Gender</label>
                            <radio
                                name="gender"
                                value="all"
                                v-model="selectedgender"
                                @input="getGender"
                            >
                                All
                            </radio>
                            <radio
                                name="gender"
                                value="Women"
                                v-model="selectedgender"
                                @input="getGender"
                            >
                                Women
                            </radio>
                            <radio
                                name="gender"
                                value="Men"
                                v-model="selectedgender"
                                @input="getGender"
                            >
                                Men
                            </radio>
                            <radio
                                name="gender"
                                value="Kid"
                                v-model="selectedgender"
                                @input="getGender"
                            >
                                Kid
                            </radio>
                            <radio
                                name="gender"
                                value="Couple"
                                v-model="selectedgender"
                                @input="getGender"
                            >
                                Couple
                            </radio>
                            <radio
                                name="gender"
                                value="UniSex"
                                v-model="selectedgender"
                                @input="getGender"
                            >
                                Uni Sex
                            </radio>
                        </div>
                        <button
                            class="d-block d-md-none filter-save"
                            @click="hideFilter"
                        >
                            Save
                        </button>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <!-- <div
                        v-if="this.showloader"
                        class="yk-wrapper fff"
                        style="position: relative !important; margin-top: 56px"
                    >
                        <div class="ct-spinner5">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>
                    </div> -->
                    <Products
                        ref="productcom"
                        @forparent="getdatafromchild"
                        :initialitems="this.newfilterdata"
                        :price_range="this.price_range"
                        :byshop="this.byshop"
                        :sortby="this.sortby"
                        :cat_id="this.specific_cat_id"
                        :selected_gems="this.byspecificgems"
                        :gender="this.selectedgender"
                        :gold_colour="this.gold_colour"
                        :discount="this.isdiscount"
                        :item_id="this.item_child_id"
                        :additional="this.additional"
                        :typesearch="this.typesearch"
                        :empty_on_server="this.empty_on_server"
                        :selected_product_quality="
                            this.selected_product_quality
                        "
                    ></Products>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Slick from "vue-slick";
import $ from "jquery";
import productsComponent from "./productsComponent.vue";
import { Checkbox, Radio } from "vue-checkbox-radio";

Vue.component("checkbox", Checkbox);
Vue.component("radio", Radio);
export default {
    props: [
        "initialitems",
        "discount",
        "cat_list",
        "cat_id",
        "maincat_list",
        "maincat_id",
        "shop_ids",
        "selected_shop",
        "sort",
        "selected_gems",
        "gender",
        "additional",
        "typesearchfromblade",
        "item_id",
        "title_prop",
        "fromprice_prop",
        "toprice_prop",
    ],
    components: {
        Products: productsComponent,
        Slick,
    },
    name: "productsFilter",
    data: function () {
        return {
            showquality: false,
            seemoretext: "see more ...",
            states: "",
            showbigloader: false,
            state_label: "",
            host: "", // get base url

            newfilterdata: "",
            busy: false,

            shoplist: [],
            byshop: [],
            byspecificshop: [],
            hidefrompriceoption: true,
            hidetopriceoption: true,
            to_price: "",
            showloader: false,
            from_price: "",
            price_range: "all",
            error_message: false,
            main_product_type: "all",
            gold_colour: "all",
            selected_product_quality: "All",
            product_qualities: [
                "All",
                "24K ၁၆ပဲရည်",
                "18K ၁၂ပဲရည်",
                "17K ၁၁ပဲ ၂ပြားရည်",
                "15K ၁၀ပဲရည်",
            ],
            notnullcatlist: "",
            final_maincatlist: [],
            specific_cat_id: [],
            byspecificgems: [],
            gems: [
                ["Diamond စိန်", "Diamond.png"],
                ["Ruby ပတ္တမြား", "Rubys.png"],
                ["Jade ကျောက်စိမ်း", "Jade.png"],
                ["Emerald မြ", "Emeralds.png"],
                ["Sapphire နီလာ", "Sapphire.png"],
                ["Morganite မြပန်းရောင်", "Morganite.png"],
                ["Spinel အညံ့ပန်း", "spinel.png"],
                ["Topaz ဥသ၁ဖယား/ ထပ်တရာ", "Topaz.png"],
                ["Zircon ဂေါ်မိတ်", "Zircon.png"],
                ["Bloodstone သွေးကျောက်", "BloodStone.png"],
                ["Coral သန္တာကျောက်", "Coral Stone.png"],
                ["Oryx မဟူရာ", "Oryx.png"],
                ["Turquoise စိမ်းပြာကျောက်", "Turquoise.png"],
                ["Beryl မြကျောက်", "Beryl.png"],
                ["Garnet ဥဒေါင်", "Garnet.png"],
                ["Moonstone လကျောက်", "Moon Stone.png"],
                ["Rose quartz ပန်းရောင်သလင်းကျောက်", "Rose Quartz.png"],
                ["Aquamarine မြပြာ", "Aquamaine.png"],
                ["Amethyst ခရမ်းစွဲ", "Amethyst.png"],
                ["Sodalite ကျောက်မျက်", "Sodalite.png"],
                ["Tourmaline ဖရဲအူ", "Tourmaline.png"],
                ["Peridot ပြောင်ခေါင်းစိမ်း", "Peridot.png"],
                ["Blue Star", "Blue-STAR.png"],
                ["Agate သဘော်မဟူရာ", "Agate.png"],
                ["စလင်းဝါ", "Jade.png"],
                ["blue topaz", "Blue Topaz.png"],
                ["Cat's Eye", "Cat_s eye.png"],
                ["Pearl ပုလဲ", "Perl.png"],
            ],
            selectedgender: "all",
            sortby: "all",
            typesearch: "",

            isdiscount: "no",
            checkdiscount: [],

            item_child_id: "empty",
            filterdata_from_server: [],
            empty_on_server: 0,

            // Shop Slider Setting
            settings: {
                dots: false,
                infinite: false,
                speed: 500,
                slidesToShow: 9,
                slidesToScroll: 9,
                arrows: false,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 9,
                            slidesToScroll: 9,
                        },
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 5,
                        },
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 3.5,
                            slidesToScroll: 3,
                        },
                    },
                ],
            },
        };
    },
    beforeMount() {
        this.newfilterdata = this.initialitems;
        this.showloader = this.newfilterdata.length == 0 ? true : false;
        // props
        if (!Array.isArray(this.selected_shop)) {
            this.byspecificshop.push(this.selected_shop);
            this.byshop.push(this.selected_shop);
        } else {
            this.byspecificshop = this.selected_shop;
            this.byshop = this.selected_shop;
        }

        if (this.discount != undefined) {
            this.isdiscount = this.discount;
        } else {
            this.isdiscount = "no";
        }
        this.notnullcatlist = this.cat_list.filter(
            (f) => f.category_id != null
        );
        this.final_maincatlist = this.maincat_list;
        this.main_product_type = this.maincat_id;
        this.byspecificgems = this.selected_gems;
        this.sortby = this.sort;
        if (this.typesearchfromblade != undefined) {
            this.typesearch = this.typesearchfromblade;
            // this.inputval = this.typesearchfromblade;
        }
        if (!this.cat_id.includes("all")) {
            this.specific_cat_id = this.cat_id;
        }

        if (this.item_id != undefined) {
            this.item_child_id = this.item_id;
        }
        const currenturl = document.referrer;
        if (this.fromprice_prop != undefined) {
            this.price_range = this.fromprice_prop + "-" + this.toprice_prop;
            this.from_price = this.fromprice_prop;
            this.to_price = this.toprice_prop;
        }

        if (this.gender != undefined) {
            this.selectedgender = this.gender;
        }

        if (localStorage.getItem("price_range") != undefined) {
            this.price_range = localStorage.getItem("price_range");
            this.from_price = localStorage.getItem("from");
            this.to_price = localStorage.getItem("to");
        }
        if (localStorage.getItem("product_quality") != undefined) {
            this.selected_product_quality =
                localStorage.getItem("product_quality");
        } else {
            this.selected_product_quality = "All";
        }
        if (localStorage.getItem("order") != undefined) {
            this.sortby = localStorage.getItem("order");
        }
        if (localStorage.getItem("specific_cat_id") != undefined) {
            this.specific_cat_id = JSON.parse(
                localStorage.getItem("specific_cat_id")
            );
        }
        if (localStorage.getItem("byspecificgems") != undefined) {
            this.byspecificgems = JSON.parse(
                localStorage.getItem("byspecificgems")
            );
        }
        if (localStorage.getItem("byshop") != undefined) {
            this.byshop = JSON.parse(localStorage.getItem("byshop"));
            this.byspecificshop = JSON.parse(localStorage.getItem("byshop"));
        }
        if (localStorage.getItem("selectedgender") != undefined) {
            this.selectedgender = localStorage.getItem("selectedgender");
        }
        if (localStorage.getItem("removecatcache") != undefined) {
            console.log(localStorage.getItem("removecatcache"));
        }
       
    },
    mounted() {
        this.$refs.productcom.tt='xxx';

        this.host = this.$hostname;
        if (localStorage.getItem("product_quality") != undefined) {
            this.selected_product_quality =
                localStorage.getItem("product_quality");
        } else {
            this.selected_product_quality = "All";
        }
        // get States for dropdown select
        this.getstatefromserver();
        // shop list to bind in slider
        this.shoplist = this.shop_ids;
        // this.empty_on_server = this.newfilterdata.length < 20 ? 1 : 0;
        // console.log("empty_on_server", this.empty_on_server);
        // this.showbigloader = true;
        this.gold_colour = this.main_product_type;
        this.getdatafromserver_bysort();
    },
    beforeUpdate() {
        if (this.$refs.slick) {
            this.$refs.slick.destroy();
        }
    },
    updated() {
        // this.$nextTick(function () {
        //     if (this.$refs.slick) {
        //         this.$refs.slick.create(this.slickOptions);
        //     }
        // });
    },
    watch: {},
    methods: {
        qseemore: function () {
            if (this.showquality) {
                this.seemoretext = "see more ....";

                this.showquality = false;
            } else {
                this.seemoretext = "see less ....";
                this.showquality = true;
            }
        },
        showFilter: function () {
            $(".filter-container").toggleClass("d-none");
        },
        hideFilter: function () {
            $(".filter-container").toggleClass("d-none");
        },

        // shops filter functions
        // Filter Shop by State
        filterShop: function (state_name, state_id) {
            this.state_label = state_name;
            if (!state_name && !state_id) {
                this.shoplist = this.shop_ids;
            } else {
                axios
                    .get(this.$hostname + "/getshopbystate/" + state_id)
                    .then((response) => {
                        this.shoplist = response.data;
                    });
            }
        },
        checkedF: function () {
            if (this.byspecificshop.length == 0) {
                this.byshop = ["all"];
                this.byspecificshop = ["all"];
                document.getElementById("allshop").checked = true;
            } else if (
                this.byspecificshop.length >= 2 &&
                this.byspecificshop.includes("all")
            ) {
                for (var i = 0; i < this.byspecificshop.length; i++) {
                    if (this.byspecificshop[i] === "all") {
                        this.byspecificshop.splice(i, 1);
                    }
                }
                this.byshop = this.byspecificshop;
            }
            if (
                this.byspecificshop.length == this.shop_ids.length &&
                !this.byspecificshop.includes("all")
            ) {
                for (var i = 0; i < this.byspecificshop.length; i++) {
                    document.getElementById(
                        this.byspecificshop[i]
                    ).checked = false;
                }
                this.byspecificshop = ["all"];
                document.getElementById("allshop").checked = true;
                this.byshop = ["all"];
            }
        },
        checkedSelectedShop: function () {

            this.showbigloader = true;
            this.byshop = [];
            if (this.byspecificshop.length != 0) {
                if (this.byspecificshop.includes("all")) {
                    this.byshop = ["all"];
                } else {
                    this.byshop.push(...this.byspecificshop);
                }
            } else {
                this.byshop.push("all");
            }
            localStorage.setItem("byshop", JSON.stringify(this.byshop));

            this.$refs.productcom.shownoitems = false;

            this.getdatafromserver_bysort();
        },
        removeSelectOther: function () {
            if (!this.byspecificshop.includes("all")) {
                for (var i = 0; i < this.byspecificshop.length; i++) {
                    document.getElementById(
                        this.byspecificshop[i]
                    ).checked = false;
                }
                this.byshop = ["all"];
                this.byspecificshop = ["all"];
                document.getElementById("allshop").checked = true;
            }
        },

        // price range
        togglepriceoptionshow: function ($event, p) {
            console.log(p);
            if (p == "from") {
                this.hidefrompriceoption = !this.hidefrompriceoption;
                this.hidetopriceoption = true;
            } else if (p == "to") {
                this.hidetopriceoption = !this.hidetopriceoption;
                this.hidefrompriceoption = true;
            }
        },
        getfrompricedata: function ($event, p) {
            console.log(p, $event.target.getAttribute("yk-value"));
            this.hidefrompriceoption = false;
            this.hidetopriceoption = false;

            if (p == "from") {
                this.from_price = $event.target.getAttribute("yk-value");
                this.hidefrompriceoption = true;
                this.hidetopriceoption = true;
            } else if (p == "to") {
                this.to_price = $event.target.getAttribute("yk-value");
                this.hidetopriceoption = true;
                this.hidefrompriceoption = true;
            }
            if (this.to_price != "") {
                this.showbigloader = true;

                this.snPriceCheck();
            }
        },
        snPriceCheck: function () {
            this.$refs.productcom.shownoitems = false;

            if (
                this.to_price != "" &&
                parseInt(this.from_price) > parseInt(this.to_price)
            ) {
                this.error_message = true;
            } else if (this.from_price != "" && this.to_price != "") {
                this.error_message = false;
                localStorage.setItem(
                    "price_range",
                    this.from_price + "-" + this.to_price
                );
                localStorage.setItem("from", this.from_price);
                localStorage.setItem("to", this.to_price);

                this.price_range = this.from_price + "-" + this.to_price;
                this.getdatafromserver_bysort();
            } else if (this.to_price == "" && this.from_price == "") {
                this.price_range = "all";
                this.getdatafromserver_bysort();
            } else {
                this.price_range = "all";
                this.getdatafromserver_bysort();
            }
        },
        fromPriceBoxBlur: function () {
            // this.hidefrompriceoption = true;
        },
        toPriceBoxBlur: function () {
            this.hidetopriceoption = true;
        },

        // Categories
        setCategory: function () {

            localStorage.setItem(
                "specific_cat_id",
                JSON.stringify(this.specific_cat_id)
            );
            this.showbigloader = true;

            this.$refs.productcom.shownoitems = 'aaaaaaaaaaaa';

            this.getdatafromserver_bysort();
        },
        catSeeMore: function () {
            var moreText = document.getElementById("cat-more");
            var btnText = document.getElementById("cat-more-btn");

            if (moreText.style.display === "block") {
                btnText.innerHTML = "See more...";
                moreText.style.display = "none";
            } else {
                btnText.innerHTML = "See less...";
                moreText.style.display = "block";
            }
        },

        // Sorting
        getSorting: function () {
            localStorage.setItem("order", this.sortby);
            this.showbigloader = true;
            this.getdatafromserver_bysort();
        },

        // Gems
        setGems: function () {
            localStorage.setItem(
                "byspecificgems",
                JSON.stringify(this.byspecificgems)
            );
            this.showbigloader = true;
            this.$refs.productcom.shownoitems = false;

            this.getdatafromserver_bysort();
        },
        gemsSeeMore: function () {
            var moreText = document.getElementById("gems-more");
            var btnText = document.getElementById("gems-more-btn");

            if (moreText.style.display === "block") {
                btnText.innerHTML = "See more...";
                moreText.style.display = "none";
            } else {
                btnText.innerHTML = "See less...";
                moreText.style.display = "block";
            }
        },

        // Gender
        getGender: function () {
            localStorage.setItem("selectedgender", this.selectedgender);

            this.$refs.productcom.shownoitems = false;
            localStorage.setItem(
                "product_quality",
                this.selected_product_quality
            );
            this.getdatafromserver_bysort();
        },

        // Discount
        isDiscount: function (isdis) {
            if (this.checkdiscount[0] == "yes") {
                this.isdiscount = "yes";
            } else {
                this.isdiscount = "no";
            }
            this.showbigloader = true;
            this.$refs.productcom.shownoitems = false;

            this.getdatafromserver_bysort();
        },

        // Gold Type
        getMainProductType: function () {
            if (this.main_product_type == "all") {
                this.gold_colour = "all";
            } else if (this.main_product_type == "၁၂ပဲရည်") {
                this.gold_colour = "all";
            } else {
                this.gold_colour = this.main_product_type;
            }
            this.$refs.productcom.shownoitems = false;
            console.log(this.gold_colour + "!!!!!");

            this.getdatafromserver_bysort();
        },

        getdatafromserver_bysort: function () {
            if (!this.busy) {
                this.busy = true;
                // console.log(this.filterdata_from_server);
                console.log("type search", this.typesearch);
                this.empty_on_server = 0;
             
                let tmp_limit = 0;
                if (
                    this.newfilterdata.length > 0
                ) {
                    tmp_limit =
                        this.newfilterdata.length;
                } else {
                    tmp_limit = 0;
                }
                //for similar
                if (this.price_range != "all") {
                    this.item_child_id = "empty";
                }
                // var self = this;
                this.showloader = true;
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
                                cat_id: this.specific_cat_id,
                                gender: this.selectedgender,
                                gems: this.byspecificgems,
                                gold_colour: this.gold_colour,
                                additional: this.additional,
                                ini_checked: false,
                                discount: this.isdiscount,
                                selected_product_quality:
                                    this.selected_product_quality,
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
                        this.busy = false;
                        this.showbigloader = false;
                        this.showloader = false;
                        console.log(this);

                        this.newfilterdata = response.data[0];
                        this.empty_on_server = response.data.empty_on_server;
                        console.log("byshop response",'afefae');
                    });
            }

            // }
        },
        getdatafromchild: function (v) {
            this.empty_on_server = v.emptyonserver;
        },

        // Get State from Server
        getstatefromserver: function () {
            axios.get(this.$hostname + "/getstates").then((response) => {
                this.states = response.data.data;
            });
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
};
</script>

<style scoped>
#cato_slide input[type="checkbox"] {
    display: none;
}

:checked + label img {
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
    justify-content: center;
    align-items: center;
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

.state-dropdown {
    display: inline-block;
    /* margin: 20px 50px; */
    position: relative;
}
.state-dropdown label,
.state-dropdown ul li {
    display: block;
    width: 200px;
    background: #fff;
    padding: 10px 10px;
    font-size: 17px;
    border-bottom: 1px solid #efefef;
}
.state-dropdown label {
    position: relative;
    z-index: 2;
    border-bottom: none;
    margin-bottom: 0 !important;
    font-weight: 600 !important;
}
.state-dropdown input {
    display: none;
}
.state-dropdown input ~ ul {
    visibility: hidden;
    opacity: 0;
    top: 0px;
    z-index: 1;
    position: absolute;
}
.state-dropdown input:checked ~ ul {
    visibility: visible;
    opacity: 1;
    top: 50px;
    z-index: 9999;
    border: 1px solid #efefef;
    height: 200px;
    overflow-y: scroll;
    border-radius: 5px;
}
.state-dropdown .fa-chevron-down {
    margin-left: 5px;
    font-size: 15px;
}
/* .animate {
  -webkit-transition: all .3s;
    -moz-transition: all .3s;
    -ms-transition: all .3s;
    -ms-transition: all .3s;
    transition: all .3s;
    backface-visibility:hidden;
    -webkit-backface-visibility:hidden;
    -moz-backface-visibility:hidden;
    -ms-backface-visibility:hidden;
} */

.sorting-filter {
    right: 50px;
    width: auto;
}
.sorting-filter .fa-filter {
    position: absolute;
    left: -25px;
    top: 13px;
}
.sn-label {
    font-size: 20px;
    margin: 30px 0 15px 0 !important;
    color: #000 !important;
}
.sn-dropdown-select {
    background: #f1f1f1;
    padding: 8px 15px;
    border-radius: 3px;
    border: 1px solid #f1f1f1;
}
.sn-dropdown-select:focus {
    border: 1px solid #f1f1f1;
}
.input-box {
    margin-right: 4px !important;
}
/* .filter-container {
} */
.filter-sticky {
    position: -webkit-sticky;
    position: sticky;
    top: 0;
}
.filter-button {
    font-size: 18px;
    background: none;
}
.filter-button i {
    color: #780116;
}
.filter-button:hover {
    color: #000;
}
.filter-close-button {
    position: absolute;
    top: 4%;
    z-index: 9999;
    right: 5%;
    border-radius: 50%;
    padding: 5px 12px 0px;
    border: 1px solid #000;
    background: #fff;
    font-size: 20px;
}
.filter-close-button:hover {
    color: #000;
    border: 1px solid #000;
}
.filter-save {
    margin-top: 10px;
    background: #780116;
    color: #fff;
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    font-weight: bold;
}

@media only screen and (max-width: 576px) {
    .sop-textsmall {
        font-size: 0.8rem;
    }
}

@media only screen and (max-width: 767px) {
    .filter-sticky {
        position: fixed;
        z-index: 9999;
        background: #fff;
        top: 0;
        left: 0;
        padding: 30px 20px;
        overflow-y: scroll;
        width: 100%;
        height: 100%;
        /* display:none; */
    }
    .sorting-filter {
        position: relative !important;
        right: 0 !important;
        width: auto;
    }
}
#cat-more,
#gems-more {
    display: none;
}
#cat-more-btn,
#gems-more-btn,
.seemorebtn {
    float: none;
    background: none;
    padding: 0;
    padding-left: 18px;
    font-size: 15px;
    color: #838383;
}
</style>
