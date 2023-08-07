<template>
    <div class="w-100 h-100 d-flex justify-content-center align-items-center">
        <a :href="host + '/addtocart/'">
            <i
                id="mobile-a2c-icon"
                class="fa-solid fa-basket-shopping"
                style="margin-top: 3px; color: #fff"
                v-bind:class="{
                    'op-90': localData == 0,
                }"
            ></i>
            <div id="temp" class="sop-cart-count">{{ localData }}</div>
        </a>
    </div>
</template>
<script>
export default {
    props: ["localdata"],
    name: "a2ciconComponent",
    data: function () {
        return {
            localData: 0,
            host: "",
        };
    },
    mounted() {
        this.getDataFromLocal();
        this.host = this.$hostname;
    },
    methods: {
        getDataFromLocal: function () {
            const data = JSON.parse(
                window.localStorage.getItem("selection") || "{}"
            );
            this.localData = Object.keys(data).length;
            console.log("length", this.localData);
        },
    },
};
</script>
<style scoped>
.sop-cart-count {
    position: absolute;
    top: 5px;
    right: 3px;

    width: 25px;
    height: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 12px;
}

.footer-mobile i:hover {
    color: white !important;
}
</style>
