<template>
    <div class="ftc_excerpt sn-product-title">
        <!-- <div class="" v-bind:class="{ 'd-none': this.more }"> -->
            <span class="" v-bind:class="{ 'd-none': this.more }">
                {{ this.longdesc }}
            </span>
        <!-- </div> -->
        <!-- <div class="" v-bind:class="{ 'd-none': this.less }"> -->
            <span class="" v-bind:class="{ 'd-none': this.less }">
                {{ this.shortdesc }}
            </span>
            <span v-if="this.noti != 0">
              <a
                  v-bind:class="{ 'd-none': this.less }"
                  class="btn-sm"
                  @click="readmore"
                  style="color: rgb(120, 1, 22) !important;"
              >
                  See more
              </a>
              <a
                  v-bind:class="{ 'd-none': this.more }"
                  class="btn-sm"
                  @click="readless"
                  style="color: rgb(120, 1, 22) !important;"
              >
                  See less
              </a>
          </span>
        <!-- </div> -->
        
    </div>
</template>

<script>
export default {
    name: "ReadMoreDetail.vue",
    props: ["shortdesc", "longdesc", "noti"],
    data() {
        return {
            more: true,
            less: false,
        };
    },
    methods: {
        readmore() {
            this.more = false;

            this.less = true;
            console.log("test");
        },
        readless() {
            this.more = true;

            this.less = false;
        },
    },
};
</script>

<style scoped></style>
