<template>
  <div class="px-md-5">
    <div class="mx-4 mx-md-3">
      <!-- <div class="zh_nav col-12 mb-2 row g-0 d-flex d-sm-none">
        <div
          class="newest_nav col-4 col-sm-3"
          :class="{ active: this.activeItem == 'newest' }"
        >
          <div class="nav-item-button">
            <a
              class="nav-link pl-2"
              :class="{ active: this.activeItem == 'newest' }"
              id="newest"
              @click.prevent="setActive('newest')"
              >Newest</a
            >
          </div>
        </div>
        <div
          class="popular_nav col-4 col-sm-3"
          :class="{ active: this.activeItem == 'popular' }"
        >
          <div class="nav-item-button p-0">
            <a
              class="nav-link"
              :class="{ active: this.activeItem == 'newest' }"
              id="popular"
              @click.prevent="setActive('popular')"
              >Popular</a
            >
          </div>
        </div>
        <div
          class="discount_nav col-4 col-sm-3"
          v-if="this.checkdison == 'on'"
          :class="{ active: this.activeItem == 'discount' }"
        >
          <div class="nav-item-button p-0">
            <a
              class="nav-link"
              :class="{ active: this.activeItem == 'newest' }"
              id="discount"
              @click.prevent="setActive('discount')"
              >Discount</a
            >
          </div>
        </div>
        <div
          class="shop_nav col-4 col-sm-3 mt-2 mb-2 mb-sm-0 mt-sm-0"
          :class="{ active: this.activeItem == 'shops' }"
        >
          <div class="nav-item-button p-0">
            <a
              class="nav-link"
              :class="{ active: this.activeItem == 'newest' }"
              id="shops"
              @click.prevent="setActive('shops')"
              >Shops</a
            >
          </div>
        </div>
      </div> -->
      <!-- <nav
        class="navbar navbar-expand-sm justify-content-start mb-3"
        style="background-color: #fff !important"
      > -->
      <nav class="btns-wrapper mb-3">
            <div class="nav-item-button popular_nav btn-item me-2" 
            :class="{ active: this.activeItem == 'popular' }">
              <a
                class="nav-link btn-padding"
                :class="{ active: this.activeItem == 'popular' }"
                id="popular"
                @click.prevent="setActive('popular')"
                >
                <img class="mb-1" v-show="this.activeItem == 'popular'" :src="host + '/images/icons/Fire.png'" width="12px">
                <img class="mb-1" v-show="this.activeItem != 'popular'" :src="host + '/images/icons/Popular-Outlied.png'" width="14px">
                Popular</a
              >
            </div>

          
            <div class="nav-item-button btn-item discount_nav me-2"
            v-if="this.checkdison == 'on'"
            :class="{ active: this.activeItem == 'discount' }">
              <a
                class="nav-link btn-padding"
                :class="{ active: this.activeItem == 'discount' }"
                id="discount"
                @click.prevent="setActive('discount')"
                >
                <img class="mb-1" v-show="this.activeItem == 'discount'" :src="host + '/images/icons/Percent-Filled.png'" width="14px">
                <img class="mb-1" v-show="this.activeItem != 'discount'" :src="host + '/images/icons/Percent-outlined.png'" width="14px">

                &nbsp;Discount</a
              >
            </div>

            <div class="nav-item-button newest_nav btn-item me-2"
            :class="{ active: this.activeItem == 'newest' }"
            >
              <a
                class="nav-link btn-padding"
                :class="{ active: this.activeItem == 'newest' }"
                id="newest"
                @click.prevent="setActive('newest')"
                >
                <img class="mb-1" v-show="this.activeItem == 'newest'" :src="host + '/images/icons/Latest.png'" width="20px">
                <img class="mb-1" v-show="this.activeItem != 'newest'" :src="host + '/images/icons/Latest-outline.png'" width="20px">

                &nbsp;Latest&nbsp;</a
              >
            </div>
          
            <!-- <div class="nav-item-button btn-item shop_nav d-lg-block d-none" 
            :class="{ active: this.activeItem == 'shops' }">
              <a
                class="nav-link mt-1"
                :class="{ active: this.activeItem == 'shops' }"
                id="shops"
                @click.prevent="setActive('shops')"
                ><i class="fas fa-store"></i>&nbsp;Shops</a
              >
            </div> -->

      </nav>
      <div>
        <NewitemsComponent
          v-if="this.activeItem == 'newest'"
          :newitems="this.newitems"
          :current_shop_count="this.shop_limit"
          :newlimit="this.newlimit"
          :newlatest="this.newlatest"
          :isscrollon="this.isscrollon"
          ref="new"
          @forparentfromnew="getdatafromnew"
        ></NewitemsComponent>

        <PopitemsComponent
          v-if="this.activeItem == 'popular'"
          :poplimit="this.poplimit"
          :poplatest="this.poplatest"
          :isscrollon="this.isscrollon"

          ref="pop"
          @forparentfrompop="getdatafrompop"
        ></PopitemsComponent>

        <DiscountitemsComponent
          v-if="this.activeItem == 'discount'"
          :discountlimit="this.discountlimit"
          :discountlatest="this.discountlatest"
          :isscrollon="this.isscrollon"

          ref="dis"
          @forparentfromdiscount="getdatafromdiscount"
        ></DiscountitemsComponent>

        <ShopsComponent
          v-if="this.activeItem == 'shops'"
          :shoplimitfromparent="this.shoplimitfromparent"
          ref="shop"
          @forparentfromshops="getdatafromshops"
        ></ShopsComponent>
      </div>
    </div>
  </div>
</template>

<script>
import NewitemsComponent from "./NewitemsComponent.vue";
import PopitemsComponent from "./PopitemsComponent.vue";
import DiscountitemsComponent from "./discount/DiscountitemsComponent.vue";
import ShopsComponent from "./shops/ShopsComponent.vue";

export default {
  props: ["newitems", "current_shop_count", "checkdison","isscrollon"],
  components: {
    NewitemsComponent: NewitemsComponent,
    PopitemsComponent: PopitemsComponent,
    DiscountitemsComponent: DiscountitemsComponent,
    ShopsComponent: ShopsComponent,
  },
  name: "MainItemsComponent",
  data: function () {
    return {
      host: "",
      popitems: [],
      activeItem: "popular",
      poplimit: 0,
      newlimit: 20,
      discountlimit: 0,
      shoplimitfromparent: 0,
      poplatest: true,
      newlatest: true,
      shop_limit: 0,
      discountlatest: true,
    };
  },
  beforeMount() {
    this.shop_limit = this.current_shop_count;
  },
  mounted() {
    this.host = this.$hostname;
  },
  watch: {
    // whenever question changes, this function will run
  },
  computed: {},
  filters: {},
  methods: {
    isActive(menuItem) {
      return this.activeItem === menuItem;
    },
    setActive(menuItem) {
      console.log(menuItem);

      this.activeItem = menuItem;
      if (menuItem == "popular") {
        this.poplimit = 0;
      }
      if (menuItem == "discount") {
        this.discountlimit = 0;
      }
      if (menuItem == "shops") {
        this.shoplimitfromparent = 0;
      }
    },
    // getinitialpop: function () {
    //     return new Promise((resolve, reject) => {
    //         axios.get(this.host + '/initial_pop_items').then(response => resolve(response));
    //     });
    //
    // },
    getdatafrompop: function (data) {
      this.poplimit = data.poplimit;
      this.poplatest = data.poplatest;
    },
    getdatafromnew: function (data) {
      console.log("it worked");
      this.newlimit = data.newlimit;
      this.newlatest = data.newlatest;
      this.shop_limit = data.shop_limit;
    },
    getdatafromdiscount: function (data) {
      this.discountlimit = data.discountlimit;
      this.discountlatest = data.discountlatest;
    },
    getdatafromshops: function (data) {
      this.shoplimitfromparent = data.shoplimitfromparent;
    },
  },
};
</script>

<style>
.nav-item-button {
  background-color: #fff8f7;
  color: #780116;
  border-radius: 40px;
  border: 1px solid #780116;
  margin-right: 10px;
  padding: 0px 20px;
}

.active.nav-item-button {
  background-color: #780116;
  color: #fff8f7 !important;
  position: relative;
}

.navbar-nav.nav-link {
  text-align: center;
}

.btn-item .active {
  color: #ffffff !important;
  /* position: relative; */
  /* border-bottom: 2px solid #780116; */
}
.btn-item a {
  color: #666 !important;
  /* font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
  font-family: "Myanmar3", Sans-Serif !important;
  font-weight: normal;
  font-size: 16px;
  white-space: nowrap;
  overflow: hidden;
}

.btns-wrapper {
  max-height: 80px;
  /* border: 1px solid #ddd; */
  display: flex;
  overflow-x: auto;
  white-space: nowrap;
  -ms-overflow-style: none;  /* IE and Edge */
}

.btns-wrapper::-webkit-scrollbar{
  display:none;
}

.btn-item {
  text-align: center;
}
@media (max-width: 576px) {
  .nav-item-button {
    margin-right: 4px;
  }
  .navbar-nav .nav-link {
    font-size: 14px !important;
  }

  .btn-padding {
      padding-right: 30px !important;
      padding-left: 20px !important;
  }
}

@media (min-width: 576px) {
  
}
</style>