<template>
    <div>
    fffffffff
    <childtest ref="ct"></childtest>
    </div>
</template>
<script>
import childtest from './childtest.vue';
export default {
    name: "Test",
    data: function () {
        return {
           
        };
    },
    components: {
        childtest:childtest ,
    },
    beforeMount() {},

    mounted() {
      this.$refs.ct.cc='xxxx';
    },

    methods: {
     
    },
};
</script>