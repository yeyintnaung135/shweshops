<template>
    <div class="chatwrapperf d-flex flex-column" v-if="this.showwrapper">
        <div style="border-bottom: 1px solid #730d1829">
            <div class="chatheaderfortemplate d-flex align-items-center">
                <div>
                    <i
                        class="fa-solid fa-angle-left backbutton"
                        @click="passchildtoparenttoopenmain()"
                    ></i>
                </div>
                <div>
                    <div 
                      class="text-circle"
                      :style="{'background-color': '#de'+ this.userdata.username.slice(-4)}"
                    >
                        <!-- {{ this.userdata.username | strlimit(1, "") }} -->
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>
                <span
                    class="active-now"
                    v-if="this.userdata.status == 'online'"
                >
                </span>
                <span class="chattitle">
                    {{ this.userdata.username | strlimit(19, "...") }}
                    <br>
                    <a :href="'tel:'+this.userdata.phone">{{ this.userdata.phone }}</a>
                </span>
                 

                <i
                    class="fi fi-rr-cross-small d-flex align-items-center close-icon"
                    @click="close()"
                ></i>
            </div>
        </div>
        <div class="chatmessagebox" @scroll="reachedtop">
            <div class="message" v-for="chatdata in this.chatdata" :key="chatdata.key">
                <div v-if="chatdata.from_id == shopdatafromparent.id">
                    <div class="msg-own-pannel d-flex justify-content-end">
                        <div style="display: flex;">
                            <span style="align-self: flex-end" class="msg-date"
                                >{{
                                    chatdata.created_at
                                        | beautytime(chatdata.created_at)
                                }}
                            </span>
                            <div class="shop-role">{{chatdata.shop_role ? chatdata.shop_role : ''}}</div>
                        </div>
                        <div
                            class="msg-own-post"
                            v-if="chatdata.type == 'post'"
                        >
                            <!-- <PostComponent
                            :item=chatdata
                          /> -->
                            <PostComponent
                                :itemdatapar="chatdata.message"
                                :shopurl="shopdatafromparent.shop_name_url"
                                :hostpar="host"
                            />
                        </div>
                        <div class="msg-own" v-if="chatdata.type == 'image'">
                            <ImageComponent :images="chatdata.message" :info="'img-own'"/>
                        </div>
                        <div class="msg-own-text" v-if="chatdata.type == 'text'">
                            <TextComponent :text="chatdata.message"/>
                        </div>
                    </div>
                </div>
                <div v-else class="d-flex" style="width: 100%">
                    <div
                        class="msg-own-pannel d-flex"
                        :class="{ 'margin-bottom': chatdata.showsendicon }"
                    >
                        <div
                            class="text-circle-chat"
                            v-if="chatdata.showsendicon"
                            :style="{'background-color': '#de'+ chatdata.from_name.slice(-4)}"
                        >
                            <i class="fa-solid fa-user"></i>
<!--                            {{ chatdata.from_name | strlimit(1, "") }}-->
                        </div>

                        <div
                            class="msg-other-post"
                            v-if="chatdata.type == 'post'"
                            :class="{ 'margin-left': !chatdata.showsendicon }"
                        >
                            <PostComponent
                                :itemdatapar="chatdata.message"
                                :shopurl="shopdatafromparent.shop_name_url"
                                :hostpar="host"
                            />
                        </div>
                        <div
                            class="msg-other"
                            v-if="chatdata.type == 'image'"
                            :class="{ 'margin-left': !chatdata.showsendicon }"
                        >
                            <ImageComponent :images="chatdata.message" :info="'img-other'"/>
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
                                >{{
                                    chatdata.created_at
                                        | beautytime(chatdata.created_at)
                                }}
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
                <input id="chat-image-upload" type="file" multiple @change="uploadImage" accept="image/*" />
                <label for="chat-image-upload" class="chat-image-upload-label">
                  <div class="chat-image-icon">
                    <i class="fa-solid fa-image"></i>
                  </div>
                </label>
                <div class="chat-image-forshow-wrapper" v-if="chatImages.length">
                  <div class="chat-list-forshow">
                    <div class="chat-image-holder" v-for="(image, key) in chatImages" :key="key">
                      <img v-bind:ref="'image'" alt="" src="" />
                      <div class="chat-list-forshow-close" @click="removeImage(image, key)">x</div>
                    </div>
                  </div>
                  <button class="chat-send-image">Send</button>
                </div>
              </div>
            </form>
          </div>

          <div v-if="this.productcodelist.length != 0" class="productcodelist">
            <ul class="list-group">
              <li v-for="productcode in this.productcodelist" :key="productcode.key" 
                  class="list-group-item bg-transparent border-0 d-flex align-items-center"
              >
                <img class="p-1" style="border-radius: 50%; max-width:60px !important;" :src="host +'/'+productcode.CheckPhotothumbs">
                <p class="mb-0 ml-1 p-1">{{productcode.product_code}}</p>
                <button class="ml-auto p-1 send-product" v-on:click="selectProduct(productcode)">send</button>
              </li>
            </ul>
          </div>

            <input
                autofocus
                type="text"
                placeholder="Enter Text Here"
                @keyup="sendmsg($event)"
                @input="getProductCode"
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
            <button
                class=""
                style="background: transparent; border: none"
                @click="sendmsg('fromsend')"
            >
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
import axios from 'axios';

export default {
    props: ["chatdatafromparent", "shopdatafromparent", "shop_role"],
    name: "shopownerchattemplate",
    components: {
        TextComponent: TextComponent,
        PostComponent: PostComponent,
        ImageComponent: ImageComponent,
    },
    data: function () {
        return {
            active: "offline",
            showwrapper: false,
            chatdata: [],
            userdata: "",
            currentuserid: "",
            host: "",
            chatdatabytyping: "",
            stopscroll: false,
            messagelimit: 20,
            chatImages: [],
            productcodelist: [],
        };
    },
    filters: {
        strlimit: function (str, limit, other) {
            return allfromcommonservice.strcutout(str, limit, other);
        },
        //for message arrive time
        beautytime: function (timestamp) {
            return allfromcommonservice.beautytime(timestamp);
        },
    },
    created() {
        this.host = this.$hostname;
        console.log("fefe");
    },
    mounted() {
        this.chatdata = this.chatdatafromparent;
        this.host = this.$hostname;
    },
    updated() {
        //when chatdata change scroll to bottom for initial state
        this.scrollbottom();
    },
    watch: {
        //when chatdata change scroll to bottom
        // chatdata: function (val) {
        //     this.scrollbottom();
        //
        // }
    },
    methods: {
        reachedtop: async function () {
            //if we have localstorage data put that data length to msg limit
            if (
                localStorage.getItem(this.currentuserid + "_shop_messages") !==
                null
            ) {
                const tmplsdlength = JSON.parse(
                    localStorage.getItem(this.currentuserid + "_shop_messages")
                );
                this.messagelimit = tmplsdlength.data.data.messages.length;
            }
            this.stopscroll = true;
            //when user scroll to top
            if (document.querySelector(".chatmessagebox").scrollTop == 0) {
                const d = { id: this.userdata.id, limit: this.messagelimit };
                //get data from server
                const getmessagedate =
                    await allfrommessagefunction.getcurrentchatuser(
                        this.currentuserid,
                        this.messagelimit
                    );
                // this function is to determine should show message sender icon
                getmessagedate.data.data.messages.map((d, index) => {
                    if (
                        typeof getmessagedate.data.data.messages[index + 1] !==
                        "undefined"
                    ) {
                        if (
                            getmessagedate.data.data.messages[index + 1]
                                .from_id ==
                            getmessagedate.data.data.messages[index].from_id
                        ) {
                            getmessagedate.data.data.messages[
                                index
                            ].showsendicon = false;
                        } else {
                            getmessagedate.data.data.messages[
                                index
                            ].showsendicon = true;
                        }
                    } else {
                        getmessagedate.data.data.messages[
                            index
                        ].showsendicon = true;
                    }
                });

                setTimeout(() => {
                    getmessagedate.data.data.messages.map((d) => {
                        //add new data to top of chatdata array
                        this.chatdata.unshift(d);
                    });
                    this.chatdata.map((d, index) => {
                        if (typeof this.chatdata[index + 1] !== "undefined") {
                            if (
                                this.chatdata[index + 1].from_id ==
                                this.chatdata[index].from_id
                            ) {
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
                if (
                    localStorage.getItem(
                        this.currentuserid + "_shop_messages"
                    ) !== null
                ) {
                    //if we have ls data we put new data to the top of array
                    var tmplsarray = JSON.parse(
                        localStorage.getItem(
                            this.currentuserid + "_shop_messages"
                        )
                    );

                    getmessagedate.data.data.messages.map((d) => {
                        tmplsarray.data.data.messages.push(d);
                    });
                    localStorage.setItem(
                        this.currentuserid + "_shop_messages",
                        JSON.stringify(tmplsarray)
                    );

                    //add new data to top of chatdata array
                } else {
                    localStorage.setItem(
                        this.currentuserid + "_shop_messages",
                        JSON.stringify(getmessagedate)
                    );
                }
            }
        },

        passchildtoparenttoopenmain(v) {
            this.stopscroll = false;
            return this.$emit("openmain", true);
        },
        sendmsg: async function (enterorsendclick) {
            //store chatlist by user to local
            if (localStorage.getItem(window.userid + "_schatlist") !== null) {
                localStorage.removeItem(window.userid + "_schatlist");
            }

            console.log(this.chatdata[0].from_id);
            if (this.chatdatabytyping != "") {
                if (
                    enterorsendclick == "fromsend" ||
                    enterorsendclick.key == "Enter"
                ) {
                    this.stopscroll = false;

                    const data = {
                        to_id: this.currentuserid,
                        from_id: this.shopdatafromparent.id,
                        message_shop_id: this.shopdatafromparent.id,
                        message_user_id: this.currentuserid,
                        from_role: "shopowner",
                        to_role: "user",
                        message: this.chatdatabytyping,
                        type: "text",
                        read_by_user: "no",
                        shop_role: this.shop_role,
                    };

                    //append this message to chatdata array

                    // this.chatdata.push(data);
                    data.created_at = new Date();

                    this.chatdatabytyping = "";
                    this.scrollbottom();

                    //store and fire to server
                    const issend = await allfrommessagefunction.sendmessagetouser(data);
                } else {
                }
            }
        },
        scrollbottom: function () {
            if (!this.stopscroll) {
                if (document.querySelector(".chatmessagebox") != undefined) {
                    return (document.querySelector(
                        ".chatmessagebox"
                    ).scrollTop =
                        document.querySelector(".chatmessagebox").scrollHeight);
                }
            }
        },
        close: function () {
            this.showwrapper = false;
            this.chatImages = [];
            document.body.style.overflow = "auto";
        },

        // custom image upload
        uploadImage(e) {
          let selectedFiles = e.target.files;
          if(e.target.files.length > 10 || (this.chatImages.length + e.target.files.length) > 10){
            alert("You are only allowed to upload a maximum of 10 images !");
          }
          else {
            for (let i = 0; i < selectedFiles.length; i++) {
              if(selectedFiles[i].type == 'image/jpeg' ||
                 selectedFiles[i].type == 'image/jpg' ||
                 selectedFiles[i].type == 'image/bmp' ||
                 selectedFiles[i].type == 'image/png' ||
                 selectedFiles[i].type == 'image/gif') {
                    if( selectedFiles[i].size > 5242880) {
                      alert("Size Should be less than 5mb");
                    } else {
                      this.chatImages.push(selectedFiles[i]);
                    }
                 } else {
                  alert("Invalid File Type ! Accept only Images.")
                 }
            }
            console.log('chatImages', this.chatImages);
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
        sendimg: async function(e) {
          e.preventDefault();
          localStorage.removeItem(window.userid + "chatlist");
          this.stopscroll = false;

          let data = new FormData();

          this.chatImages.forEach(chatImage => {
            data.append('message[]', chatImage);
          });

          this.chatImages = [];

          axios.post(this.host+'/backside/shop_owner/sendimagemessage', data,
              {
                headers: { "Content-Type": "multipart/form-data" }
              })
              .then(async (response) => {
                console.log('response', response.data.images);

                const data = {
                    to_id: this.currentuserid,
                    from_id: this.shopdatafromparent.id,
                    message_shop_id: this.shopdatafromparent.id,
                    message_user_id: this.currentuserid,
                    from_role: "shopowner",
                    to_role: "user",
                    message: response.data.images,
                    type: "image",
                    read_by_user: 'no',
                    shop_role: this.shop_role,
                };

                //append this message to chatdata array

                // this.chatdata.push(data);
                data.created_at = new Date();
                this.scrollbottom();
                //set data to localstorage for fast
                // if (localStorage.getItem(data.message_user_id + '_shop_messages') !== null) {
                //     var tmplsd = JSON.parse(localStorage.getItem(data.message_user_id + '_shop_messages'));
                //     tmplsd.data.data.messages.unshift(data);
                //     localStorage.setItem(data.message_user_id + '_shop_messages', JSON.stringify(tmplsd));
                // }

                const issend = await allfrommessagefunction.sendmessagetouser(data);
              })
              .catch((err) => {
                console.log('error', err);
              });
        },

        // Get Product Code by Typing
        getProductCode() {
          if(this.chatdatabytyping.charAt(0) == '@' && this.chatdatabytyping.length >= 2 && !(/\s/.test(this.chatdatabytyping))) {
            axios
              .post(this.host + "/backside/shop_owner/getproductcodebytyping",
                {
                  chatdatabytyping: this.chatdatabytyping.slice(1),
                  shop_id: this.shopdatafromparent.id
                },
                {
                    header: {
                        "Content-Type": "multipart/form-data",
                    },
                })
              .then((response) => {
                if(response.data.length != 0) {
                  this.productcodelist = response.data;
                } else {
                  this.productcodelist = [];
                }
              });
          } else if (this.chatdatabytyping.charAt(0) == '@' && this.chatdatabytyping.length < 2) {
            this.productcodelist = [];
          } else {
            this.productcodelist = [];
          }
        },

        selectProduct: async function(productcode) {
          if (localStorage.getItem(window.userid + "_schatlist") !== null) {
              localStorage.removeItem(window.userid + "_schatlist");
          }

          this.stopscroll = false;
          const data = {
              to_id: this.currentuserid,
              from_id: this.shopdatafromparent.id,
              message_shop_id: this.shopdatafromparent.id,
              message_user_id: this.currentuserid,
              from_role: "shopowner",
              to_role: "user",
              message: JSON.stringify(productcode),
              type: "post",
              read_by_user: "no",
              shop_role: this.shop_role,
              created_at: new Date()
          }
          this.productcodelist = [];
          this.chatdatabytyping = '';
          this.scrollbottom();
          //store and fire to server
          const issend = await allfrommessagefunction.sendmessagetouser(data);
        }
    },
};
</script>

<style scoped>
.send-product {
  background: #fff;
  border: 1px solid #780116;
  border-radius: 3px;
  color: #780116;
  font-size: 14px;
}
.send-product:hover {
  background: #780116;
  color: #fff;
}
.message {
  margin-bottom: 10px;
  position: relative;
}
.text-circle-chat {
    height: 32px;
    width: 32px;
    min-width: 32px;
    border-radius: 27px;
    text-align: center;
    background: #950a0a;
    color: white;
    padding-top: 5px;
    font-weight: bolder;
    font-size: 16px;
}

.text-circle {
    height: 44px;
    width: 43px;
    border-radius: 27px;
    text-align: center;
    background: #950a0a;
    color: white;
    padding-top: 5px;
    font-weight: bolder;
    font-size: 24px;
}

.backbutton {
    font-size: 25px;
    margin-right: 22px;
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
    /* color: #ffffff; */
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
    left: 90px;
    right: 10px;
    margin-top: 26px;
}

.msg-own-pannel {
    width: 100%;
    margin-bottom: 2px;
    padding: 10px;
}

.msg-date {
    color: #8a8d91;
    font-weight: 500;
    font-size: 0.8rem;
    padding-left: 4px;
    max-width: 70px;
    opacity: 0.8;
}

.msg-other, .msg-other-text {
    padding: 5px 11px;
    color: black;
    width: auto;
    max-width: 250px;
    margin-left: 7px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    word-break: break-word;
}
.msg-other-text {
    background: rgba(138, 141, 145, 0.34901960784313724) !important;
}

.msg-other:has(img) {
    padding: 0;
}

.msg-own, .msg-own-text {
    padding: 5px 11px;
    color: rgb(255, 255, 255);
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
    background: #950a0a;
}
.msg-own:has(img) {
    padding: 0;
}

.msg-own-post,
.msg-other-post {
    padding: 5px;
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
    box-shadow: (149 157 165 / 20%) 0 px - 8 px 24 px;
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
.shop-role {
  position: absolute;
  width: 200px;
  font-size: 12px;
  bottom: -10px;
  right: 20px;
  text-align: right;
  color: #6495ed;
}
@media only screen and (min-width: 576px) {
    .chatwrapperf {
        position: fixed;
        bottom: 86px;
        width: 360px;
        height: 413px;
        right: 22px;
        z-index: 9999;
        background: white;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2),
            0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .chatmessagebox {
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
        /* height: 100vh !important; */
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
    margin-left: 10px;
}

.chatheaderimg {
    width: 43px;
    border: 1px solid black;
    border-radius: 22px;
}

.msg-other img {
    border-radius: 5px;
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

/* Product Code list by typing */
.productcodelist {
  position: absolute;
    bottom: 38px;
    background: #fff;
    padding: 20px 15px 30px;
    height: calc(100% - 38px);
    width: 100%;
    overflow-y: scroll;
}
.productcodelist li{
  border-bottom: 1px solid #ddd !important;
  border-radius: 0 !important;
}
.productcodelist ul li:last-child {
  border-bottom: 0 !important;
}
</style>
