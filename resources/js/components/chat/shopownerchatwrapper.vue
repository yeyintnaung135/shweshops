<template>
    <div class="">
        <div class="px-3">
            <div @click="onclickmsgicon('')" class="chaticon-container">
                <span
                    class="total-count-badge"
                    v-if="this.showtotalbadge && this.count != 0"
                    >{{ this.count }}</span
                >
                <img :src="host + '/images/icons/chat.png'" class="chaticon" />
                <!--                <i class="fa fa-message fa-lg" style="color:#F7B538 !important;" id="mobileFootNoti"></i>-->
            </div>
        </div>
        <div class="main-chat-list" v-if="this.showchatlist">
            <div
                style="border-bottom: 1px solid #730d1829"
                class="d-flex justify-content-between"
            >
                <div class="chat-header pl-2 pl-sm-0">Chat List</div>
                <div
                    class="chat-header d-flex align-items-center"
                    @click="close()"
                >
                    <i
                        class="fi fi-rr-cross-small d-flex align-items-center"
                    ></i>
                </div>
            </div>
            <div class="container px-4 py-2 px-sm-3">
                <div
                    class="row no-gutters mt-2 d-flex position-relative"
                    v-for="chatdata in this.chatlist"
                    @click="passchildtoparent(chatdata.message_user_id, chatdata.read_by_user)"
                    :key="chatdata.key"
                >
                    <!--                    v-if="chatdata.status"-->

                    <div class="col-2 no-gutters">
                        <div
                            class="text-circle"
                            v-if="chatdata.userdata.username !== undefined"
                            :style="{'background-color': '#de'+ chatdata.userdata.username.slice(-4)}"
                        >
                            <!-- {{ chatdata.userdata.username | strlimit(1, "") }} -->
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div v-else></div>
                    </div>
                    <span
                        class="active-now-user"
                        v-if="
                            active == 'online' ||
                            chatdata.userdata.status == 'online'
                        "
                    ></span>
                    <div class="col-10 no-gutters">
                        <div class="row chattitle no-gutters">
                         <!-- v-if="chatdata.userdata.username !== undefined" -->
                            {{
                                chatdata.userdata.username | strlimit(15, "...")
                            }}
                        </div>
                        
                        <!-- v-else -->
                        <div
                            class="row chatbody no-gutters"
                            v-if="chatdata.read_by_user == 'yes'"
                        >
                            <div
                                class="d-flex flex-row"
                                v-if="chatdata.type == 'text'"
                            >
                                <div class="d-flex">
                                    {{ chatdata.message | strlimit(15, "...") }}
                                </div>
                                <div
                                    class="d-flex justify-content-end chatdate"
                                    style="position: absolute; right: 14px"
                                >
                                    {{
                                        chatdata.created_at
                                            | beautytime(chatdata.created_at)
                                    }}
                                </div>
                            </div>
                            <div
                                class="d-flex flex-row"
                                v-if="chatdata.type == 'post'"
                            >
                                <div class="d-flex">An attachment</div>
                                <div
                                    class="d-flex justify-content-end chatdate"
                                    style="position: absolute; right: 14px"
                                >
                                    {{
                                        chatdata.created_at
                                            | beautytime(chatdata.created_at)
                                    }}
                                </div>
                            </div>
                            <div
                                class="d-flex flex-row"
                                v-if="chatdata.type == 'image'"
                            >
                                <div class="d-flex">image</div>
                                <div
                                    class="d-flex justify-content-end chatdate"
                                    style="position: absolute; right: 14px"
                                >
                                    {{
                                        chatdata.created_at
                                            | beautytime(chatdata.created_at)
                                    }}
                                </div>
                            </div>
                        </div>
                        <div
                            class="row chatbody unread"
                            v-if="chatdata.read_by_user == 'no'"
                        >
                            <div class="d-flex" v-if="chatdata.type == 'text'">
                                <div>
                                    {{ chatdata.message | strlimit(15, "...") }}
                                </div>
                                <div
                                    class="count-badge"
                                    v-if="specificcount[chatdata.message_user_id]"
                                >
                                    {{ specificcount[chatdata.message_user_id] }}
                                </div>
                                <div
                                    class="justify-content-end"
                                    style="position: absolute; right: 14px"
                                >
                                    {{
                                        chatdata.created_at
                                            | beautytime(chatdata.created_at)
                                    }}
                                </div>
                            </div>
                            <div class="d-flex" v-if="chatdata.type == 'post'">
                                <div>An attachment</div>
                                <div
                                    class="count-badge"
                                    v-if="specificcount[chatdata.message_user_id]"
                                >
                                    {{ specificcount[chatdata.message_user_id] }}
                                </div>
                                <div
                                    class="justify-content-end"
                                    style="position: absolute; right: 14px"
                                >
                                    {{
                                        chatdata.created_at
                                            | beautytime(chatdata.created_at)
                                    }}
                                </div>
                            </div>
                            <div class="d-flex" v-if="chatdata.type == 'image'">
                                <div>image</div>
                                <div
                                    class="count-badge"
                                    v-if="specificcount[chatdata.message_user_id]"
                                >
                                    {{ specificcount[chatdata.message_user_id] }}
                                </div>
                                <div
                                    class="justify-content-end"
                                    style="position: absolute; right: 14px"
                                >
                                    {{
                                        chatdata.created_at
                                            | beautytime(chatdata.created_at)
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import backend from "../../backend";
import { allfrommessagefunction } from "./messagefunctions";

import { allfromcommonservice } from "../commonfunction/commonservice";

export default {
    props: ["shopid"],
    name: "shopownerchatwrapper",
    data: function () {
        return {
            active: "offline",
            count: "",
            specificcount: {},
            chatlist: [],
            host: "",
            showchatlist: false,
            showtotalbadge: true,
        };
    },
    mounted() {
        this.host = this.$hostname;
        localStorage.removeItem(window.userid+'gettotalchatcountforshop');
        this.getTotalCount();
    },
    filters: {
        strlimit: function (str, limit, other) {
            return allfromcommonservice
                .strcutout(str, limit, other)
                .toUpperCase();
        },
        beautytime: function (timestamp) {
            return allfromcommonservice.beautytime(timestamp);
        },
    },
    methods: {
        close() {
            this.showchatlist = false;
            document.body.style.overflow = "auto";
            this.showtotalbadge = true;
        },
        onclickmsgicon: async function (info) {
            if (info == "frombackbutton") {
                this.showchatlist = true;
            } else {
                this.showchatlist = !this.showchatlist;
            }
            if (localStorage.getItem(window.userid + "_schatlist") === null || this.count > 0) {
                var gslfs = await this.getshopschatlistfromserver();
                console.log("getshopschatlistfromserver", gslfs);
            } else {
                var gslfs = JSON.parse(
                    localStorage.getItem(window.userid + "_schatlist")
                );
            }
            this.getSpecificCount(gslfs.data.data);

            if (gslfs.data.success) {
                this.chatlist = gslfs.data.data;
                backend.$refs.chatref.showwrapper = false;
            }
            var x = window.matchMedia("(max-width: 576px)");
            if (x.matches) {
                // If media query matches
                if (this.showchatlist == true) {
                    document.body.style.overflow = "hidden";
                } else {
                    document.body.style.overflow = "auto";
                }
            }
            this.showtotalbadge = this.showchatlist ? false : true;
            localStorage.setItem(
                window.userid + "_schatlist",
                JSON.stringify(gslfs)
            );
        },
        //when user click one of chat list
        passchildtoparent(v, read_by_user) {
            const d = { id: parseInt(v), limit: 20, shopid: this.shopid, read_by_user };
            //pass from id to parent
            this.$emit("getfromid", d);
        },
        //get all chat data while web page start load
        getshopschatlistfromserver: function () {
            return new Promise((resolve) => {
                axios
                    .get(this.host + "/backside/shop_owner/getshopschatslist")
                    .then((response) => {
                        resolve(response);
                    });
            });
        },
        getTotalCount: async function () {
          let total_chat_count;
          if(localStorage.getItem(this.shopid+'gettotalchatcountforshop') === null) {
            total_chat_count = await allfrommessagefunction.gettotalchatcountforshop();
            localStorage.setItem(this.shopid+'gettotalchatcountforshop', total_chat_count);
          } else {
            total_chat_count = localStorage.getItem(this.shopid+'gettotalchatcountforshop');
          }
          this.count = total_chat_count < 10 ? total_chat_count : "9+";
        },
        getSpecificCount: async function (datas) {
          if(localStorage.getItem(this.shopid+'getspecificcountforshop') === null || this.count > 0) {
            var count = {};
            for (const data of datas) {
              let speccount = await allfrommessagefunction.getspecificchatcountforshop(data.message_user_id);
              count[data.message_user_id] = speccount < 10 ? speccount : "9+";
            }
            localStorage.setItem(this.shopid+'getspecificcountforshop', JSON.stringify(count));
          }
          this.setSpecificCount();
        },
        setSpecificCount: function () {
          this.specificcount = localStorage.getItem(this.shopid+'getspecificcountforshop') ? JSON.parse(localStorage.getItem(this.shopid+'getspecificcountforshop')) : {};
        }
    },
};
</script>

<style scoped>
.chattitle {
    font-size: 16px;
    font-weight: bold;
    color: #000000c7;
    margin-left: 4px;
    margin-top: 5px;
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

.chatdate {
    font-size: 12px;
}
.chat-header {
    font-size: 20px;
    font-weight: bold;
    margin: 0.8rem !important;
}

.chaticon {
    width: 48px;
    height: 48px;
}
.chaticon-container {
    position: fixed;
    bottom: 22px;
    right: 22px;
    z-index: 2222;
}
/* .main-chat-list {
    position: fixed;
    bottom: 90px;
    width: 330px;
    height: 406px;
    right: 2%;
    z-index: 1111;
    background: white;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

} */
@media only screen and (max-width: 991px) {
    .chaticon-container {
        position: fixed;
        bottom: 22px;
        right: 22px;

        z-index: 2222;
    }
    .main-chat-list {
        bottom: 133px;
    }
}
@media only screen and (min-width: 576px) {
    .main-chat-list {
        position: fixed;
        border: 2px solid #d5d5d5;
        width: 360px;
        z-index: 1111;
        height: 406px;
        right: 22px;
        overflow: hidden;
        background: white;
        box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%);
        bottom: 86px;
    }
    .main-chat-list .container {
      height: 348px;
      overflow-y: scroll;
    }
}
@media only screen and (max-width: 576px) {
    .main-chat-list {
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
    .main-chat-list .container {
      height: calc(var(--vh) * 100 - 56px);
      overflow-y: scroll;
    }
}


.chatbody {
    font-size: 14px;
    color: #0000006e;
    font-weight: bold;
    margin-left: 4px;
}
.active-now-user {
    position: absolute;
    border: 2px solid #c8d7c6;
    width: 13px;
    height: 13px;
    border-radius: 22px;
    background: green;
    left: 33px;
    margin-top: 30px;
}
.unread {
    color: black;
}

.chatlist {
    margin: 10px;
    padding: 3px;
}

.chatlistimg {
    width: 43px;
    border: 1px solid black;
    border-radius: 28px;
}
.list-container {
    position: relative;
}
.count-badge,
.total-count-badge {
    position: absolute;
    right: 10px;
    top: 12px;
    background: #e92525;
    display: inline;
    color: #fff;
    padding: 2px 6px 0;
    border-radius: 50%;
    font-size: 12px;
}
.total-count-badge {
    right: -8px;
    top: -8px;
}
</style>
