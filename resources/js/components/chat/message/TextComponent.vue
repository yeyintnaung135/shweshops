<template>
    <div class="site-content">
      <div class="chat-text-wrapper">
        <p v-html="this.text.linkify()" class="m-0"></p>
      </div>
    </div>
</template>

<script>

import "linkifyjs/lib/linkify-string";

export default {
    props: [
      "text",  
    ],
    name: "TextComponent",
    data: function () {
        return {
            
        };
    },

    mounted() {
        
    },

    filters: {
        
    },

    methods: {
        
    },
};
</script>

<style scoped>
  
</style>
