<template>
<form @submit="searchfromserver(e)">
    <div class="cart-total d-flex align-items-end">
        <input class="sop-search" type="text" v-model="searchtext" placeholder="Search">
        <button type="submit" class="fa-solid fa-search px-2 "  style="padding-bottom:0.5rem;font-size:1rem;opacity:0.9;color:#F7B538; border-bottom:1px solid #F7B538"></button>

    </div>
</form>
</template>

<script>
import axios from "axios";
export default {
    data:function (){
        return {
            searchtext:""

        }
    },
    mounted() {
        this.host = this.$hostname;
        if(window.localStorage.getItem('searchtext')!=undefined){
            this.searchtext=window.localStorage.getItem('searchtext');
        }

    },
    methods: {
        searchfromserver:function (e){
            window.localStorage.setItem('searchtext',this.searchtext);
            e.preventDefault();
            return location.assign(this.host+'/ajax_search_result/'+this.searchtext);

        }
    }
}
</script>

<style scoped>

</style>
