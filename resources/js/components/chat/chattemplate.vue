<template>
  <div class="chatwrapperf d-flex flex-column" v-if="this.showwrapper">
    <div style="border-bottom: 1px solid #730d1829" v-if="this.shopdata != null">
      <div class="chatheaderfortemplate d-flex align-items-center">
        <div>
          <i
            class="fa-solid fa-angle-left backbutton"
            @click="passchildtoparenttoopenmain()"
          ></i>
        </div>
        <div>
          <img
            class="chatheaderimg"
            :src="this.host + '/images/logo/thumbs/' + this.shopdata.shop_logo"
          />
        </div>
        <span class="active-now" v-if="this.shopdata.status == 'online'"> </span>
        <span class="chattitle">
          {{ this.shopdata.shop_name | strlimit(19, "...") }}</span
        >

        <i
          class="fi fi-rr-cross-small d-flex align-items-center close-icon"
          @click="close()"
        ></i>
      </div>
    </div>
    <div
      class="chatmessagebox"
      @scroll="reachedtop"
      v-lazy-container="{ selector: 'div' }"
    >
      <div
        class="message"
        v-for="chatdata in this.chatdata"
        v-lazy
        v-bind:key="chatdata.message_id"
      >
        <div v-if="chatdata.from_id == userid">
          <div class="msg-own-pannel d-flex justify-content-end">
            <div style="display: flex">
              <span style="align-self: flex-end" class="msg-date"
                >{{ chatdata.created_at | beautytime(chatdata.created_at) }}
              </span>
            </div>
            <div class="msg-own-post" v-if="chatdata.type == 'post'">
              <!-- <PostComponent
                            :item=chatdata
                          /> -->
              <PostComponent
                :itemdatapar="chatdata.message"
                :shopurl="chatdata.shop_name_url"
                :hostpar="host"
              />
            </div>
            <div class="msg-own" v-if="chatdata.type == 'image'">
              <ImageComponent :images="chatdata.message" :info="'img-own'" />
            </div>
            <div class="msg-own-text" v-if="chatdata.type == 'text'">
              <TextComponent :text="chatdata.message" />
            </div>
          </div>
        </div>
        <div v-else class="d-flex" style="width: 100%">
          <div
            class="msg-own-pannel d-flex"
            :class="{ 'margin-bottom': chatdata.showsendicon }"
          >
            <img
              class="sender-img"
              v-if="chatdata.showsendicon"
              :src="imgurl + '/shop_owner/logo/thumbs/' + shopdata.shop_logo"
            />

            <div
              class="msg-other-post"
              v-if="chatdata.type == 'post'"
              :class="{ 'margin-left': !chatdata.showsendicon }"
            >
              <PostComponent
                :itemdatapar="chatdata.message"
                :shopurl="chatdata.shop_name_url"
                :hostpar="host"
              />
            </div>
            <div
              class="msg-other"
              v-if="chatdata.type == 'image'"
              :class="{ 'margin-left': !chatdata.showsendicon }"
            >
              <ImageComponent :images="chatdata.message" :info="'img-other'" />
            </div>
            <div
              class="msg-other-text"
              v-if="chatdata.type == 'text'"
              :class="{ 'margin-left': !chatdata.showsendicon }"
            >
              <TextComponent :text="chatdata.message" />
            </div>

           
            <div style="display: flex">
              <span style="align-self: flex-end" class="msg-date"
                >{{ chatdata.created_at | beautytime(chatdata.created_at) }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="chatinbox d-flex">
      <!-- Custom image upload -->
      <div>
        <form @submit="sendimg" enctype="multipart/form-data">
          <div id="chat-image-attach-wrapper">
            <input
              id="chat-image-upload"
              type="file"
              multiple
              @change="uploadImage"
              accept="image/*"
            />
            <label for="chat-image-upload" class="chat-image-upload-label">
              <div class="chat-image-icon">
                <i class="fa-solid fa-image"></i>
              </div>
            </label>
            <div class="chat-image-forshow-wrapper" v-if="chatImages.length">
              <div class="chat-list-forshow">
                <div
                  class="chat-image-holder"
                  v-for="(image, key) in chatImages"
                  :key="key"
                >
                  <img v-bind:ref="'image'" alt="" src="" />
                  <div class="chat-list-forshow-close" @click="removeImage(image, key)">
                    x
                  </div>
                </div>
              </div>
              <button class="chat-send-image">Send</button>
            </div>
          </div>
        </form>
      </div>

      <input
        autofocus
        type="text"
        @keyup="sendmsg($event)"
        class=""
        v-model="chatdatabytyping"
        style="
          border-radius: 5px;
          border: none;
          margin: 5px 5px 5px 20px;
          background: rgb(229, 229, 229);
          padding: 5px 10px;
          font-size: 14px;
          line-height: normal;
          width: 100%;
        "
      />
      <button @click="sendmsg('fromsend')" style="background: transparent; border: none">
        <i
          class="fi fi-rs-paper-plane d-flex px-2 align-items-center"
          style="color: #950a0a; font-size: 20px"
        ></i>
      </button>
    </div>
  </div>
</template>

<script>
import { allfromcommonservice } from "../commonfunction/commonservice";
import { allfrommessagefunction } from "./messagefunctions";
import TextComponent from "./message/TextComponent.vue";
import PostComponent from "./message/PostComponent.vue";
import ImageComponent from "./message/ImageComponent.vue";


import axios from "axios";

let uuid = require("uuid");

window.Pusher = require("pusher-js");

export default {
  props: ["userid", "username"],
  name: "chattemplate",
  components: {
    TextComponent: TextComponent,
    PostComponent: PostComponent,
    ImageComponent: ImageComponent,
  },
  data: function () {
    return {
      showwrapper: false,
      active: "offline",

      shopdata: "",
      host: "",
      chatdata: [],
      chatdatabytyping: "",
      messagelimit: 20,
      currentuserid: "",
      stopscroll: false,

      chatImages: [],
      imgurl:"",
    };
  },
  filters: {
    strlimit: function (str, limit, other) {
      return allfromcommonservice.strcutout(str, limit, other);
    },
    beautytime: function (timestamp) {
      return allfromcommonservice.beautytime(timestamp);
    },
  },
  created() {
    this.host = this.$hostname;
  },
  mounted() {
    this.host = this.$hostname;
    if (process.env.MIX_USE_DO == "true") {
      this.imgurl = process.env.MIX_DO_URL;
    } else {
      this.imgurl = this.host+'/images';
    }
  },

  updated() {
    //when chatdata change scroll to bottom for initial state
    this.scrollbottom();
  },

  watch: {
    // chatdata: function (val) {
    //     //when chatdata change scroll to bottom for while message arrive from echo
    //
    //     updated();
    //
    //
    // }
  },
  methods: {
    passchildtoparenttoopenmain(v) {
      this.stopscroll = false;
      // when user click back button close this pannel open main chat wrapper pannel
      return this.$emit("openmain", true);
    },
    sendmsg: async function (enterorsendclick) {
      localStorage.removeItem(window.userid + "chatlist");

      //if chat type data is not empty
      if (this.chatdatabytyping != "") {
        //user press enter or click send button from event
        if (enterorsendclick == "fromsend" || enterorsendclick.key == "Enter") {
          this.stopscroll = false;

          const data = {
            to_id: parseInt(this.shopdata.id),
            from_role: "user",
            from_name: this.username,
            to_role: "shopowner",
            message_shop_id: parseInt(this.shopdata.id),
            message_user_id: this.userid,
            from_id: this.userid,
            message: this.chatdatabytyping,
            type: "text",
            read_by_user: "no",
          };

          //append this message to chatdata array
          this.chatdatabytyping = "";

          this.chatdata.push(data);
          data.created_at = new Date();
          this.scrollbottom();
          //set data to localstorage for fast
          if (localStorage.getItem(data.to_id + "_messages") !== null) {
            var tmplsd = JSON.parse(localStorage.getItem(data.to_id + "_messages"));
            tmplsd.data.data.messages.unshift(data);
            localStorage.setItem(data.to_id + "_messages", JSON.stringify(tmplsd));
          }

          //store and fire to server
          const issend = await allfrommessagefunction.sendmessage(data);
        } else {
        }
      }
    },
    reachedtop: async function () {
      //if we have localstorage data put that data length to msg limit
      if (localStorage.getItem(this.currentuserid + "_messages") !== null) {
        const tmplsdlength = JSON.parse(
          localStorage.getItem(this.currentuserid + "_messages")
        );
        this.messagelimit = tmplsdlength.data.data.messages.length;
      }
      //if we have localstorage data put that data length to msg limit

      this.stopscroll = true;
      //when user scroll to top
      if (document.querySelector(".chatmessagebox").scrollTop == 0) {
        const d = { id: this.currentuserid, limit: this.messagelimit };
        //get data from server
        const getmessagedate = await allfrommessagefunction.getcurrentchatshops(
          this.currentuserid,
          this.messagelimit
        );
        // this function is to determine should show message sender icon
        getmessagedate.data.data.messages.map((d, index) => {
          if (typeof getmessagedate.data.data.messages[index + 1] === null) {
            if (
              getmessagedate.data.data.messages[index + 1].from_id ==
              getmessagedate.data.data.messages[index].from_id
            ) {
              getmessagedate.data.data[index].showsendicon = false;
            } else {
              getmessagedate.data.data.messages[index].showsendicon = true;
            }
          } else {
            getmessagedate.data.data.messages[index].showsendicon = true;
          }
        });

        setTimeout(() => {
          getmessagedate.data.data.messages.map((d) => {
            //add new data to top of chatdata array
            this.chatdata.unshift(d);
          });
          this.chatdata.map((d, index) => {
            if (typeof this.chatdata[index + 1] !== "undefined") {
              if (this.chatdata[index + 1].from_id == this.chatdata[index].from_id) {
                this.chatdata[index].showsendicon = false;
              } else {
                this.chatdata[index].showsendicon = true;
              }
            } else {
              this.chatdata[index].showsendicon = true;
            }
          });
        }, 100);

        //add 20 to message limit
        this.messagelimit = this.messagelimit + 20;

        //we set data to local storage
        if (localStorage.getItem(this.currentuserid + "_messages") !== null) {
          //if we have ls data we put new data to the top of array
          var tmplsarray = JSON.parse(
            localStorage.getItem(this.currentuserid + "_messages")
          );

          getmessagedate.data.data.messages.map((d) => {
            tmplsarray.data.data.messages.push(d);
          });
          localStorage.setItem(
            this.currentuserid + "_messages",
            JSON.stringify(tmplsarray)
          );

          //add new data to top of chatdata array
        } else {
          localStorage.setItem(
            this.currentuserid + "_messages",
            JSON.stringify(getmessagedate)
          );
        }
      }
    },
    scrollbottom: function () {
      if (!this.stopscroll) {
        if (document.querySelector(".chatmessagebox") != undefined) {
          return (document.querySelector(
            ".chatmessagebox"
          ).scrollTop = document.querySelector(".chatmessagebox").scrollHeight);
        }
      }
    },
    close: function () {
      this.stopscroll = false;

      this.showwrapper = false;
      document.body.style.overflow = "auto";
    },

    // custom image upload
    uploadImage(e) {
      let selectedFiles = e.target.files;
      if (
        e.target.files.length > 10 ||
        this.chatImages.length + e.target.files.length > 10
      ) {
        alert("You are only allowed to upload a maximum of 10 images !");
      } else {
        for (let i = 0; i < selectedFiles.length; i++) {
          if (
            selectedFiles[i].type == "image/jpeg" ||
            selectedFiles[i].type == "image/jpg" ||
            selectedFiles[i].type == "image/bmp" ||
            selectedFiles[i].type == "image/png" ||
            selectedFiles[i].type == "image/gif"
          ) {
            if (selectedFiles[i].size > 5242880) {
              alert("Size Should be less than 5mb");
            } else {
              this.chatImages.push(selectedFiles[i]);
            }
          } else {
            alert("Invalid File Type ! Accept only Images.");
          }
        }
        console.log("chatImages", this.chatImages);
        this.applyImage();
      }
    },

    removeImage(image, index) {
      console.log(this.chatImages);
      this.chatImages.splice(index, 1);
      this.applyImage();
    },
    applyImage() {
      for (let i = 0; i < this.chatImages.length; i++) {
        let reader = new FileReader();
        reader.onload = (e) => {
          this.$refs.image[i].src = reader.result;
        };
        reader.readAsDataURL(this.chatImages[i]);
      }
    },
    sendimg: async function (e) {
      e.preventDefault();
      localStorage.removeItem(window.userid + "chatlist");
      this.stopscroll = false;

      let data = new FormData();

      this.chatImages.forEach((chatImage) => {
        data.append("message[]", chatImage);
      });

      this.chatImages = [];

      axios
        .post(this.host + "/sendimagemessage", data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then(async (response) => {
          console.log("response", response.data.images);

          const data = {
            to_id: parseInt(this.shopdata.id),
            from_role: "user",
            from_name: this.username,
            to_role: "shopowner",
            message_shop_id: parseInt(this.shopdata.id),
            message_user_id: this.userid,
            from_id: this.userid,
            message: response.data.images,
            type: "image",
            read_by_user: "no",
          };

          //append this message to chatdata array

          this.chatdata.push(data);
          data.created_at = new Date();
          this.scrollbottom();
          //set data to localstorage for fast
          if (localStorage.getItem(data.to_id + "_messages") !== null) {
            var tmplsd = JSON.parse(localStorage.getItem(data.to_id + "_messages"));
            tmplsd.data.data.messages.unshift(data);
            localStorage.setItem(data.to_id + "_messages", JSON.stringify(tmplsd));
          }

          const issend = await allfrommessagefunction.sendmessage(data);
        })
        .catch((err) => {
          console.log("error", err);
        });
    },
  },
};
</script>

<style>
.backbutton {
  font-size: 25px;
  margin-right: 34px;
  text-align: center;
  margin-top: 5px;
  color: #730d18;
  margin-left: 10px;
}

.margin-left {
  margin-left: 40px !important;
}

.margin-bottom {
  margin-bottom: 11px !important;
}

.sender-img {
  width: 24px;
  /* border: 1px solid black; */
  border-radius: 50%;
  height: 22px;
  margin-left: 9px;
}

.close-icon {
  position: absolute;
  right: 14px;
  color: black;
  font-size: 25px;
  /* border: 2px solid #730d18; */
  text-align: center;
  width: 30px;
  height: 29px;
  border-radius: 19px;
  /* background: #730d18; */
}

.active-now {
  position: absolute;
  border: 2px solid #c8d7c6;
  width: 15px;
  height: 14px;
  border-radius: 22px;
  background: green;
  left: 87px;
  right: 10px;
  margin-top: 26px;
}

.msg-own-pannel {
  width: 100%;
  margin-bottom: 2px;
}

.msg-date {
  color: #8a8d91;
  font-weight: 500;
  font-size: 0.8rem;
  padding-left: 4px;
  max-width: 70px;
  opacity: 0.8;
}

/* .chatmessagebox {
    height: 292px;
    overflow-y: scroll;
    overflow-x: hidden;
} */

.msg-other,
.msg-other-text {
  padding: 5px 11px;
  color: black;
  width: auto;
  /* max-width: 61%; */
  max-width: 250px;
  margin-left: 7px;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  word-break: break-word;
}
.msg-other-text {
  background: #8a8d9159;
}

.msg-other:has(img) {
  padding: 0;
}

.msg-own:has(img) {
  padding: 0;
}

.msg-own,
.msg-own-text {
  padding: 5px 11px;
  color: white;
  width: auto;
  /* max-width: 61%; */
  max-width: 250px;
  margin: 0 8px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  word-break: break-word;
}
.msg-own-text {
  background: #780117d8 !important;
}

.msg-own-post,
.msg-other-post {
  padding: 5px 11px;
  color: white;
  width: auto;
  max-width: 61%;
  margin: 8px;
  border-radius: 12px;
}

.chatinbox {
  /* bottom: 1px; */
  /* position: absolute; */
  width: 100%;
  background-color: white;
  box-shadow: (149 157 165 / 20%) 0px -8px 24px;
}

/* .chatwrapperf {
    position: fixed;
    bottom: 59px;
    width: 330px;
    height: 406px;
    right: 4%;
    z-index: 1111;
    background: white;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
} */
@media only screen and (min-width: 576px) {
  .chatwrapperf {
    position: fixed;
    bottom: 59px;
    width: 360px;
    height: 413px;
    right: 22px;
    z-index: 9999;
    background: white;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }

  .chatmessagebox {
    /* height: 292px; */
    height: 100%;
    overflow-y: scroll;
    overflow-x: hidden;
  }
}

@media only screen and (max-width: 576px) {
  .chatwrapperf {
    position: fixed;
    bottom: 0 !important;
    width: 100vw !important;
    height: 100vh;
    height: -moz-available;
    height: -webkit-fill-available;
    height: stretch;
    height: calc(var(--vh) * 100);
    right: 0 !important;
    z-index: 9999;
    background: #fff;
  }

  .chatmessagebox {
    height: 100%;
    overflow-y: scroll;
    overflow-x: hidden;
    padding: 10px;
  }
}

.chatheaderfortemplate {
  margin: 0.8rem !important;
}

.chattitle {
  font-size: 16px;
  font-weight: bold;
  color: #000000c7;
  margin-left: 4px;
  margin-top: 5px;
}

.chatheaderimg {
  width: 43px;
  /* border: 1px solid black; */
  border-radius: 50%;
}

.chat-image-icon i {
  position: relative;
  color: #780116 !important;
  top: 10px;
  left: 8px;
  font-size: 18px;
  cursor: pointer;
}

#chat-image-attach-wrapper {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
.chat-list-forshow {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  height: calc(100% - 38px);
  overflow-y: scroll;
}
.chat-image-holder {
  float: left;
  position: relative;
  margin: 5px;
  width: 45%;
}
.chat-image-holder img {
}
.chat-image-holder .chat-list-forshow-close {
  position: absolute;
  right: 0px;
  top: 0px;
  background: #000;
  color: #fff;
  padding: 3px 10px;
  border-radius: 50%;
  cursor: pointer;
}

#chat-image-upload {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}
.chat-image-forshow-wrapper {
  position: absolute;
  bottom: 38px;
  background: #8f8f8fc2;
  padding: 20px 15px 30px;
  height: calc(100% - 38px);
  width: 100%;
}
.chat-image-forshow-wrapper .chat-send-image {
  position: absolute;
  bottom: 20px;
  width: 92%;
  left: 3%;
  display: block;
  background: #780116;
  color: #fff;
}

@media only screen and (max-width: 991px) {
  .chatwrapperf {
    bottom: 133px;
    width: 308px;

    right: 2%;
  }
}
/* hide scrollbar but allow scrolling */
.chatmessagebox {
  -ms-overflow-style: none; /* for Internet Explorer, Edge */
  scrollbar-width: none; /* for Firefox */
  overflow-y: scroll;
}

.chatmessagebox::-webkit-scrollbar {
  display: none; /* for Chrome, Safari, and Opera */
}
</style>
