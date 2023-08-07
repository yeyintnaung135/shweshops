<template>
    <div>
        <div class="px-3">
            <div @click="onclickmsgicon('')" class="chaticon-container">
                <img :src="host + '/images/icons/chat.png'" class="chaticon" />
                <span
                    class="total-count-badge"
                    v-if="this.showtotalbadge && this.count != 0"
                    >{{ this.count }}</span
                >
            </div>
        </div>

        <div class="main-chat-list" v-if="this.showchatlist">
            <div
                style="border-bottom: 1px solid #730d1829"
                class="d-flex justify-content-between"
            >
                <div class="chat-header ps-2 ps-md-0">Chat List</div>
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
                    class="row g-0 mt-2 d-flex list-container"
                    v-for="data in this.chatdata"
                    @click="passchildtoparent(data.message_shop_id, data.read_by_user, '')"
                    :key="data.key"
                >
                    <div v-if="data.shopdata != null" class="col-2 g-0 d-flex align-items-center">
                        <img
                            class="chatlistimg"
                            :src="
                                host +
                                '/images/logo/thumbs/' +
                                data.shopdata.shop_logo
                            "
                        />
                    </div>
                    <div class="active-now-user" v-if="data.shopdata != null">
                         <span

                             v-if="active == 'online' || data.shopdata.status == 'online'"
                         ></span>
                    </div>

                    <div v-if="data.shopdata != null" class="col-10 g-0">
                        <div class="row chattitle g-0">
                            {{ data.shopdata.shop_name | strlimit(15, "...") }}
                        </div>
                        <div
                            class="row chatbody g-0"
                            v-if="data.read_by_user == 'yes'"
                        >
                            <div
                                class="d-flex flex-row"
                                v-if="data.type == 'text'"
                            >
                                <div class="d-flex">
                                    {{ data.message | strlimit(15, "...") }}
                                </div>
                                <div
                                    class="d-flex justify-content-end chatdate"
                                    style="position: absolute; right: 14px"
                                >
                                    {{
                                        data.created_at
                                            | beautytime(data.created_at)
                                    }}
                                </div>
                            </div>
                            <div
                                class="d-flex flex-row"
                                v-if="data.type == 'post'"
                            >
                                <div class="d-flex">An attachment</div>
                                <div
                                    class="justify-content-end chatdate"
                                    style="position: absolute; right: 14px"
                                >
                                    {{
                                        data.created_at
                                            | beautytime(data.created_at)
                                    }}
                                </div>
                            </div>
                            <div
                                class="d-flex flex-row"
                                v-if="data.type == 'image'"
                            >
                                <div class="d-flex">images</div>
                                <div
                                    class="d-flex justify-content-end chatdate"
                                    style="position: absolute; right: 14px"
                                >
                                    {{
                                        data.created_at
                                            | beautytime(data.created_at)
                                    }}
                                </div>
                            </div>
                        </div>
                        <div
                            class="row chatbody unread g-0"
                            v-if="data.read_by_user == 'no'"
                        >
                            <div class="d-flex" v-if="data.type == 'text'">
                                <div>
                                    {{ data.message | strlimit(15, "...") }}
                                </div>
                                <div
                                    class="count-badge"
                                    v-if="specificcount[data.message_shop_id]"
                                >
                                    {{ specificcount[data.message_shop_id] }}
                                </div>
                                <div
                                    class="justify-content-end"
                                    style="position: absolute; right: 14px"
                                >
                                    {{
                                        data.created_at
                                            | beautytime(data.created_at)
                                    }}
                                </div>
                            </div>
                            <div class="d-flex" v-if="data.type == 'post'">
                                <div>An attachment</div>
                                <div
                                    class="count-badge"
                                    v-if="specificcount[data.message_shop_id]"
                                >
                                    {{ specificcount[data.message_shop_id] }}
                                </div>
                                <div
                                    class="justify-content-end"
                                    style="position: absolute; right: 14px"
                                >
                                    {{
                                        data.created_at
                                            | beautytime(data.created_at)
                                    }}
                                </div>
                            </div>
                            <div class="d-flex" v-if="data.type == 'image'">
                                <div>images</div>
                                <div
                                    class="count-badge"
                                    v-if="specificcount[data.message_shop_id]"
                                >
                                    {{ specificcount[data.message_shop_id] }}
                                </div>
                                <div
                                    class="justify-content-end"
                                    style="position: absolute; right: 14px"
                                >
                                    {{
                                        data.created_at
                                            | beautytime(data.created_at)
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
import app from "../../app";
import { allfrommessagefunction } from "./messagefunctions";

import { allfromcommonservice } from "../commonfunction/commonservice";

export default {
    props: ["userid"],
    name: "chatwrapper",
    data() {
        return {
            host: "",
            count: "",
            specificcount: {},
            active: "offline",
            showchatlist: false,
            showtotalbadge: true,
            chatdata: [],
        };
    },
    mounted() {
        this.host = this.$hostname;
        localStorage.removeItem(window.userid+'gettotalchatcountforuser');
        this.getTotalCount();
    },
    filters: {
        strlimit: function (str, limit, other) {
            return allfromcommonservice.strcutout(str, limit, other);
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
        passchildtoparent(v, read_by_user, info) {
            const d = { id: parseInt(v), limit: 20, info: info, user_id: this.userid, read_by_user };
            return this.$emit("getfromid", d);
        },
        onclickmsgicon: async function (info) {
            if (info == "frombackbutton") {
                this.showchatlist = true;
            } else {
                this.showchatlist = !this.showchatlist;
            }
            if (localStorage.getItem(window.userid + "chatlist") === null || this.count > 0) {
                var gclfs = await this.getuserchatlistsfromserver();
            } else {
                var gclfs = JSON.parse(localStorage.getItem(window.userid + "chatlist"));
            }
            this.getSpecificCount(gclfs.data.data);

            if (gclfs.data.success) {

                app.$refs.chatref.showwrapper = false;
                this.chatdata = gclfs.data.data;
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
            localStorage.setItem(window.userid + "chatlist", JSON.stringify(gclfs));

            console.log("user chat lists", gclfs);
        },
        getuserchatlistsfromserver: function (e) {
            return new Promise((resolve) => {
                axios
                    .get(this.host + "/getuserchatlistsfromserver")
                    .then((response) => {
                        resolve(response);
                    });
            });
        },
        getTotalCount: async function () {
          let total_chat_count;
          if(localStorage.getItem(this.userid+'gettotalchatcountforuser') === null) {
            total_chat_count = await allfrommessagefunction.gettotalchatcountforuser();
            localStorage.setItem(this.userid+'gettotalchatcountforuser', total_chat_count);
          } else {
            total_chat_count = localStorage.getItem(this.userid+'gettotalchatcountforuser');
          }
          this.count = total_chat_count < 10 ? total_chat_count : "9+";
        },
        getSpecificCount: async function (datas) {
          if(localStorage.getItem(this.userid+'getspecificcount') === null || this.count > 0) {
            var count = {};
            for (const data of datas) {
              let speccount = await allfrommessagefunction.getspecificchatcountforuser(data.message_shop_id);
              count[data.message_shop_id] = speccount < 10 ? speccount : "9+";
            }
            localStorage.setItem(this.userid+'getspecificcount', JSON.stringify(count));
          }
          this.setSpecificCount();
        },
        setSpecificCount: function () {
          this.specificcount = localStorage.getItem(this.userid+'getspecificcount') ? JSON.parse(localStorage.getItem(this.userid+'getspecificcount')) : {};
        }
    },
};
</script>

<style scoped>
.chatdate {
    font-size: 12px;
}
.chat-header {
    font-size: 20px;
    font-weight: bold;
    margin: 0.8rem !important;
}

.chaticon {
    width: 40px;
    height: 40px;
}
.chaticon-container {
    position: fixed;
    bottom: 22px;
    right: 20px;
    z-index: 2222;
}
@media only screen and (max-width: 991px) {
    .chaticon-container {
        position: fixed;
        bottom: 90px;
        right: 22px;
        z-index: 2222;
    }
    .main-chat-list {
        bottom: 133px;
        width: 360px;
    }
}

@media only screen and (min-width: 576px) {
    .main-chat-list {
        position: fixed;
        bottom: 59px;
        width: 360px;
        height: 406px;
        right: 22px;
        z-index: 9999;
        background: white;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2),
            0 6px 20px 0 rgba(0, 0, 0, 0.19);
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
        height: -moz-available;
        height: -webkit-fill-available;
        height: stretch;
        height: calc(var(--vh) * 100);
        /* height: 100vh !important; */
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
    left: 32px;
    margin-top: 32px;
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
    /* border: 1px solid black; */
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
