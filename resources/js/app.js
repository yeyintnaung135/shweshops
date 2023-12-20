/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from "vue";
import VueLazyload from "vue-lazyload";
import VueAxios from "vue-axios";
import axios from "axios";

//for notification
require("./components/chat/usermessagelistener");
//for notification

Vue.use(VueAxios, axios);

import { BootstrapVue, IconsPlugin } from "bootstrap-vue";

Vue.directive("click-outside", {
    bind: function (el, binding, vnode) {
        window.event = function (event) {
            if (!(el == event.target || el.contains(event.target))) {
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener("click", window.event);
    },
    unbind: function (el) {
        document.body.removeEventListener("click", window.event);
    },
});

var infiniteScroll = require("vue-infinite-scroll");
Vue.use(infiniteScroll);
require("./bootstrap");

require("jquery.cookie");
require("jquery.sticky");

window.Vue = require("vue");
Vue.use("jquery.cookie");
Vue.use("jquery.sticky");
Vue.use(BootstrapVue);

Vue.component(
    "main-items-component",
    require("./components/frontend/MainItemsComponent.vue").default
);

Vue.component(
    "shops-component",
    require("./components/frontend/shops/ShopsComponent.vue").default
);
Vue.component(
    "shops-all",
    require("./components/frontend/shops/ShopsAll.vue").default
);
Vue.component(
    "discount-items",
    require("./components/frontend/discount/DiscountitemsComponent.vue").default
);
Vue.component(
    "discount-items-for-shop",
    require("./components/frontend/discount/DiscountitemsForShopComponent.vue")
        .default
);

Vue.component(
    "readmore-detail",
    require("./components/ReadMoreDetail.vue").default
);

Vue.component(
    "new-items",
    require("./components/frontend/NewitemsComponent.vue").default
);
Vue.component(
    "pop-items",
    require("./components/frontend/PopitemsComponent.vue").default
);

Vue.component(
    "newitems-forshop",
    require("./components/frontend/NewitemsforshopComponent.vue").default
);

Vue.component(
    "pop-items-forshop",
    require("./components/frontend/PopItemsForShopComponent.vue").default
);

Vue.component(
    "products_filter",
    require("./components/frontend/product/productsFilterComponent").default
);
Vue.component(
    "sn-searchbyproductcode",
    require("./components/backend/SnSearchByProductCode.vue").default
);

Vue.component(
    "shopscreatevalidate",
    require("./components/backend/ShopsCreateValidate.vue").default
);

Vue.component(
    "my-favourite",
    require("./components/frontend/Favourite.vue").default
);
Vue.component("my-cart", require("./components/frontend/Cart.vue").default);

Vue.component("a2cicon-com", require("./components/temp/a2cicon.vue").default);
Vue.component(
    "tags-com",
    require("./components/frontend/tags/TagsComponent.vue").default
);
Vue.component(
    "type-search",
    require("./components/frontend/TypesearchComponent.vue").default
);

Vue.component(
    "chat-template",
    require("./components/chat/chattemplate.vue").default
);
Vue.component(
    "chat-wrapper",
    require("./components/chat/chatwrapper.vue").default
);

Vue.component(
    "live-wrapper",
    require("./components/forlivestream/livewrapper.vue").default
);

Vue.component(
    "see-all-shop-directory",
    require("./components/frontend/directory/seeallshopdirectory.vue").default
);

Vue.component(
    "support-help",
    require("./components/frontend/SupportComponent.vue").default
);
Vue.component(
    "checkout",
    require("./components/frontend/checkout.vue").default
);
Vue.prototype.$hostname = "https://" + window.location.hostname;

// Vue.prototype.$hostname =
//     "http://" + window.location.hostname + "/shweshops/public";

//HostName for Laragon or Valet Virtual Host
// Vue.prototype.$hostname = "http://shweshops.test";

//

import VueChatScroll from "vue-chat-scroll";

Vue.use(VueChatScroll);
//for host name global var

// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";

import { allfromws } from "./components/fornoti/wsnoti";
import { allfromfirebase } from "./components/forfirebase/forfirebase";
import { allfrommessagefunction } from "./components/chat/messagefunctions";

Window.allfrommsg = allfrommessagefunction;
Vue.use(VueLazyload, {
    preLoad: 1.3,
    error: Vue.prototype.$hostname + "/dist/errofefr.png",
    loading: Vue.prototype.$hostname + "/tFFest/KSYL.gif",
    attempt: 1,
});

const app = new Vue({
    functional: true,

    el: "#app",

    data: {
        chatdata: [],
        notimessage: "fafe",
        togglespin: false,
        //for forgot password
        phone: "",
        code: "",
        fperrors: 0,
        password: "",
        password_confirmation: "",
        fperrorscode: 0,
        host: "",
        fperrorspassword: 0,
        shownewpasswordform: false,
        //for forgot password
        showchodecheckform: false,
    },
    created() {
        console.log("vue start====");
        this.host = this.$hostname;
        this.afterloginforaddtocard();
    },
    mounted() {
        this.firebaserequestpermission();
    },

    methods: {
        //when user click back button in chat template
        toopenmainchatwrapper: function (v) {
            
            this.$refs.chatlistref.showchatlist = v;
            this.$refs.chatref.showwrapper = false;
            this.$refs.chatlistref.onclickmsgicon("frombackbutton");
        },

        //when user click one of shop chat in chat wrapper
        getfromidparent: async function (value) {
            var fromcache = false;
            if (value.read_by_user == "no") {
                localStorage.removeItem(value.id + "_messages");
            }

            if (localStorage.getItem(value.id + "_messages") === null) {
                fromcache = false;
                // get data for user clicked shop
                var currentuserdata =
                    await allfrommessagefunction.getcurrentchatshops(
                        value.id,
                        0
                    );
                //set shops messages to localstorage
                localStorage.setItem(
                    value.id + "_messages",
                    JSON.stringify(currentuserdata)
                );
            } else {
                fromcache = true;
                // get data for user clicked shop
                var currentuserdata = JSON.parse(
                    localStorage.getItem(value.id + "_messages")
                );
            }

            const temrevarray = currentuserdata.data.data.messages.reverse();
            console.log('HERE',temrevarray);
            //loop array to show message sender icon
            temrevarray.map((d, index) => {
                if (typeof temrevarray[index + 1] !== "undefined") {
                    if (
                        temrevarray[index + 1].from_id ==
                        currentuserdata.data.data.messages[index].from_id
                    ) {
                        temrevarray[index].showsendicon = false;
                    } else {
                        temrevarray[index].showsendicon = true;
                    }
                } else {
                    temrevarray[index].showsendicon = true;
                }
            });
            if (currentuserdata.data.success) {
                if (value.info != "frombuynow") {
                    const setreadbyuser = allfrommessagefunction.setreadbyuser(
                        value.id
                    );
                    let tmplscl = JSON.parse(
                        localStorage.getItem(window.userid + "chatlist")
                    );

                    tmplscl.data.data.map((d) => {
                        if (d.message_shop_id == value.id) {
                            d.read_by_user = "yes";
                        }
                    });

                    localStorage.setItem(
                        window.userid + "chatlist",
                        JSON.stringify(tmplscl)
                    );
                }
                // await this.$refs.chatref.showwrapper
                this.$refs.chatref.showwrapper = true;

                this.$refs.chatref.chatdata = temrevarray;
                let froshop = currentuserdata.data.data.shop_data;

                if (froshop.shop_logo !== null) {
                    //if no result for this shop in db table online status
                    let status;
                    status = froshop.status;

                    this.$refs.chatref.shopdata = {
                        shop_logo: froshop.shop_logo,
                        shop_name: froshop.shop_name,
                        id: value.id,
                        status: status,
                    };
                }

                this.$refs.chatref.messagelimit = 20;
                this.$refs.chatlistref.showchatlist = false;
                this.$refs.chatref.messagelimit += 20;
                this.$refs.chatref.currentuserid = value.id;
                this.$refs.chatref.stopscroll = false;

                // showing total count on floating icon
                const total_chat_count =
                    await allfrommessagefunction.gettotalchatcountforuser();
                localStorage.setItem(
                    value.user_id + "gettotalchatcountforuser",
                    total_chat_count
                );
                app.$refs.chatlistref.getTotalCount();

                //specific count
                var count = JSON.parse(
                    localStorage.getItem(value.user_id + "getspecificcount")
                );
                if (count !== null) {
                    count[froshop.shops_id] = 0;
                    localStorage.setItem(
                        value.user_id + "getspecificcount",
                        JSON.stringify(count)
                    );
                    app.$refs.chatlistref.specificcount = count;
                }
            }
        },

        afterloginforaddtocard: function () {
            const getls = localStorage.getItem("foraddtocartitems");
            const dt = localStorage.getItem("datenow");

            if (getls !== null) {
                var tmp = JSON.parse(getls);
                this.buynowbuttonclick(
                    "1",
                    tmp.data.ShopName.id,
                    tmp.data,
                    "post",
                    tmp.data.username,
                    tmp.data.ShopName,
                    new Date()
                );
                console.log("fefe");
                console.log(getls);
                localStorage.removeItem("foraddtocartitems");
                localStorage.removeItem("datenow");
            }
        },
        messengerbuttonclick: async function (checkauth, link, shopid, itemid) {
            let auth = checkauth;
            // console.log('M.ME LINK',link);
            if (window.userid == undefined && auth != "1") {
                // user must be logined to send msg
                $(document).ready(function () {
                    $("#orangeModalSubscription").modal("show");
                    $(".userLogin").show();

                    document.getElementById("loginbeforemessenger").value =
                        "clickmessenger";
                });
            } else {
                await this.addfbmsglog(shopid, itemid);
                location.assign(link);
            }
        },
        addfbmsglog: function (shopid, itemid) {
            return new Promise((resolve, reject) => {
                axios
                    .post(this.host + "/fb_message_log/add", {
                        userid: window.userid,
                        shopid: shopid,
                        itemid: itemid,
                    })
                    .then((response) => {
                        resolve(response);
                    });
            });
        },
        paymentbuttonclick: async function (checkauth, link) {
            let auth = checkauth;
            if (window.userid == undefined && auth != "1") {
                // user must be logined to send msg
                $(document).ready(function () {
                    $("#orangeModalSubscription").modal("show");
                    $(".userLogin").show();

                    document.getElementById("loginbeforepayment").value =
                        "clickpayment";
                });
            } else {
                location.assign(link);
            }
        },
        buynowbuttonclick: async function (
            checkauth,
            to,
            message,
            type,
            name,
            shopdata,
            dt
        ) {
            console.log("BUYNOW CLICKED", "CLICKED ====" + to);
            //we must clear local chatlist data
            if (localStorage.getItem(window.userid + "chatlist") !== null) {
                localStorage.removeItem(window.userid + "chatlist");
            }

            let auth = checkauth;
            if (window.userid == undefined && auth != "1") {
                // user must be logined to send msg
                $(document).ready(function () {
                    $("#orangeModalSubscription").modal("show");
                    $(".userLogin").show();

                    document.getElementById("loginbeforebuynow").value =
                        "clickbuynow";
                });
            } else {
                const data = [
                    {
                        to_id: parseInt(to),
                        from_name: name,
                        read_by_user: "no",
                        from_id: window.userid,
                        message_shop_id: parseInt(to),
                        message_user_id: window.userid,
                        from_role: "user",
                        to_role: "shopowner",
                        message: JSON.stringify(message),
                        type: type,
                        created_at: dt,
                    },
                    {
                        read_by_user: "no",
                        message_shop_id: parseInt(to),
                        message_user_id: window.userid,
                        to_id: parseInt(to),
                        from_role: "user",
                        to_role: "shopowner",
                        from_id: window.userid,
                        message: "စုံစမ်းရန်",
                        type: "text",
                        from_name: name,
                        created_at: dt,
                    },
                ];
                let shopdatatmp = {
                    shop_logo: shopdata.shop_logo,
                    shop_name: shopdata.shop_name,
                    id: shopdata.id,
                    status: shopdata.status,
                };

                if (localStorage.getItem(to + "_messages") === null) {
                    await Promise.all(
                        data.map(async (d) => {
                            const issend =
                                await allfrommessagefunction.sendmessage(d);
                        })
                    );
                    await app.$refs.chatlistref.passchildtoparent(
                        to,
                        "",
                        "frombuynow"
                    );
                } else {
                    data.map(async (d) => {
                        const issend = await allfrommessagefunction.sendmessage(
                            d
                        );
                    });

                    var tmplsd = JSON.parse(
                        localStorage.getItem(to + "_messages")
                    );
                    tmplsd.data.data.messages.unshift(data[0]);
                    tmplsd.data.data.messages.unshift(data[1]);
                    localStorage.setItem(
                        to + "_messages",
                        JSON.stringify(tmplsd)
                    );
                    await app.$refs.chatlistref.passchildtoparent(
                        to,
                        "",
                        "frombuynow"
                    );
                    console.log(tmplsd);
                }

                // this.$refs.chatref.showwrapper = true;
            }
        },
        firebaserequestpermission: async function () {
            // const check = await allfromfirebase.checkhavefromserverfireb();
            const check = "none";
            if (check == "none") {
                console.log("Requesting permission...");

                await Notification.requestPermission().then((permission) => {
                    if (permission === "granted") {
                        console.log("Notification permission granted.");
                        this.startregisterfirebase();
                    }
                });
            }
        },
        startregisterfirebase: function () {
            console.log("firebase register");

            const firebaseConfig = {
                apiKey: "AIzaSyD1e63wA6bVB2PVPvA5o-mq7aEtEo8DVdk",
                authDomain: "shweshops-82763.firebaseapp.com",
                projectId: "shweshops-82763",
                storageBucket: "shweshops-82763.appspot.com",
                messagingSenderId: "770728201881",
                appId: "1:770728201881:web:8897d40feb23b33c1fb208",
                measurementId: "G-6LB2JC63PV",
            };

            // Initialize Firebase
            const firebaseapp = initializeApp(firebaseConfig);
            const messaging = getMessaging(firebaseapp);

            getToken(messaging, {
                // vapidKey: "BJ1NPqHXAjJHPf4VfQDH_Q8ubT1JAAbi1TzVJKcc30sXms5Qs7KVjtBvvCQk6m73Oqvf8V9Fax46sVK2-gAJvzc",
                // Added by Swe
                vapidKey:
                    "BMUJKZnROYZ8mwdOfQSNPq8PmjVi2nIx7aE9RRkzZnilv2JHjICRzjR-N9PmsCTD1eXDB4i8ESLQXgFhaWrC1uE",
            })
                .then((currentToken) => {
                    if (currentToken) {
                        allfromfirebase.storefirebasetoken(currentToken);
                    } else {
                        // Show permission request UI
                        console.log(
                            "No registration token available. Request permission to generate one."
                        );
                        // ...
                    }
                })
                .catch((err) => {
                    console.log(
                        "An error occurred while retrieving token. ",
                        err
                    );
                    // ...
                });
        },

        requestpermission: async function () {
            let ready = await navigator.serviceWorker.ready;
            let checkalreadyhave = await allfromws.checkhavefromserver();
            console.log(checkalreadyhave);
            if (checkalreadyhave == "none") {
                let subscribe = await ready.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey:
                        "BDp4y42lJL3ScdJdnjG-splBj-5_NIusKVEwfY07WSf750ZaDZM0tnkkM_XqDjICOvuGsMynIcH_6tUT7tfEY2U",
                });
                let storeddatatoserver = await allfromws.storetoserver(
                    JSON.stringify(subscribe)
                );
                console.log("start store ws token");

                console.log(storeddatatoserver);
            } else {
                console.log("already have ws token");
            }
        },

        //for facebook
        //forgot password
        sendphonetoserver: function () {
            axios
                .post(
                    Vue.prototype.$hostname + "/" + "forgot_password",
                    { emailorphone: this.phone },
                    {
                        header: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                )
                .then((response) => {
                    if (response.data.success == false) {
                        this.fperrors = response.data.errors;
                    } else {
                        this.showchodecheckform = response.data.success;
                    }
                    console.log(response);
                });
        },
        sendcodetoserver: function () {
            axios
                .post(
                    Vue.prototype.$hostname + "/" + "check_code",
                    { emailorphone: this.phone, code: this.code },
                    {
                        header: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                )
                .then((response) => {
                    if (response.data.success == false) {
                        this.fperrorscode = response.data.errors;
                    } else {
                        this.shownewpasswordform = response.data.success;
                        this.showchodecheckform = false;
                    }
                    console.log(response);
                });
        },
        sendnewpasswordtoserver: function () {
            axios
                .post(
                    Vue.prototype.$hostname + "/" + "add_new_password",
                    {
                        emailorphone: this.phone,
                        code: this.code,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    },
                    {
                        header: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                )
                .then((response) => {
                    if (response.data.success == false) {
                        this.fperrorspassword = response.data.errors;
                    } else {
                        window.location.assign(window.location.href);
                    }
                    console.log(response);
                });
        },

        addanimatespin() {
            if (this.togglespin == false) {
                this.togglespin = true;
            } else {
                this.togglespin = false;
            }
        },
        //forgot password

        // for selection
    },
});
//fornoti
export default app;
//fornoti
