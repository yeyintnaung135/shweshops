<template>
  <div class="site-content">
    <div
      class="chat-image-wrapper-for-one"
      style="max-width: 100% !important"
      :class="this.info"
      v-if="this.images.length == 1"
    >
      <div
        v-for="(imageurl, index) in this.images"
        v-bind:key="index"
        :data-src="host + '/images/chat/' + imageurl"
        data-fancybox="chat"
      >
        <img v-lazy="host + '/images/chat/' + imageurl" />
      </div>
    </div>
    <div
      class="chat-image-wrapper-for-two"
      style="max-width: 100% !important"
      :class="this.info"
      v-if="this.images.length == 2 || this.images.length == 4"
    >
      <div
        v-for="(imageurl, index) in this.images"
        v-bind:key="index"
        :data-src="host + '/images/chat/' + imageurl"
        data-fancybox="chat"
      >
        <img v-lazy="host + '/images/chat/' + imageurl" />
      </div>
    </div>
    <div
      class="chat-image-wrapper-for-many"
      style="max-width: 100% !important"
      :class="this.info"
      v-if="this.images.length == 3 || this.images.length > 4"
    >
      <div
        v-for="(imageurl, index) in this.images"
        v-bind:key="index"
        :data-src="host + '/images/chat/' + imageurl"
        data-fancybox="chat"
      >
        <img v-lazy="host + '/images/chat/' + imageurl" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["images", "info"],
  name: "ImageComponent",
  data: function () {
    return {
      host: "",
    };
  },
  created() {
    this.host = this.$hostname;
  },
  mounted() {},

  filters: {},

  methods: {},
};
</script>
<style>
.img-own {
  justify-content: flex-end;
}
.img-other {
  justify-content: flex-start;
}

.chat-image-wrapper-for-two,
.chat-image-wrapper-for-many {
  display: flex;
  flex-wrap: wrap;
}
.chat-image-wrapper-for-two > div {
  width: 45%;
  height: 100px;
  margin: 2px;
}
.chat-image-wrapper-for-two img {
  height: 100px;
  border-radius: 5px;
  object-fit: cover;
}
.chat-image-wrapper-for-one img {
  border-radius: 5px;
  object-fit: contain;
}
.chat-image-wrapper-for-many > div {
  width: 31%;
  height: 65px;
  margin: 2px;
}
.chat-image-wrapper-for-many img {
  height: 65px;
  border-radius: 5px;
  object-fit: cover;
}
.fancybox__container {
  z-index: 9999 !important;
}
</style>
