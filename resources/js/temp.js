import Vue from "vue";
import $ from "jquery";

import VueLazyload from "vue-lazyload";
import axios from "axios";

require("./components/chat/shopownermessagelistener.js");

import { BootstrapVue, IconsPlugin } from "bootstrap-vue";

window.Vue = require("vue");
Vue.use(VueLazyload, {
    preLoad: 1.3,
    error: Vue.prototype.$hostname + "/dist/errofefr.png",
    loading: Vue.prototype.$hostname + "/tFFest/KSYL.gif",
    attempt: 1,
});
Vue.use(BootstrapVue);
Vue.component(
    "yk-dropzone",
    require("./components/backend/YkDropzone.vue").default
);
Vue.component(
    "yk-dropzoneforedit",
    require("./components/backend/YkDropzoneForEdit.vue").default
);
Vue.component(
    "shopownerchattemplate",
    require("./components/chat/shopownerchattemplate.vue").default
);
Vue.component(
    "shopownerchatwrapper",
    require("./components/chat/shopownerchatwrapper.vue").default
);

//services
import { allfromfbjs } from "./components/forfacebook/facebook";
import { allfromserveraction } from "./components/forfacebook/serveraction";

import pricelogicsn from "./components/backend/pricelogin/pricelogic";
import { allfrommessagefunction } from "./components/chat/messagefunctions";
import { initializeApp } from "firebase/app";
import { getMessaging, getToken } from "firebase/messaging";
import { allfromfirebase } from "./components/forfirebase/forfirebase";
Window.allfrommsg = allfrommessagefunction;

window.pricelogicsn = pricelogicsn;

//for host name global var
Vue.prototype.$hostname = "https://" + window.location.hostname;
// Vue.prototype.$hostname = "http://" + window.location.hostname;

// Vue.prototype.$hostname = "http://" + window.location.hostname + "/moe/public";


//for host name global var
const backend = new Vue({
    el: "#backend",
    data: {
        //message
        chatdata: [],

        message: "",
        hostname: "",
        //message

        //temp
        modalShow: false,
        pageid: "",
        errorpageid: false,
        userid: "",
        llusertoken: "",
        //temp
        testfbdata: "ff",

        fbdata: { connected: "no", longliveusertoken: "empty" },
    },
    created() {
        console.log("backend start====ff");

        allfromfbjs.initialfacebook(this);
    },
    mounted() {
        this.hostname = this.$hostname;
        this.firebaserequestpermission();
    },

    methods: {
        //when user click back button in chat template
        toopenmainchatwrapper: function(v) {
            this.$refs.chatwrapper.showchatlist = v;
            this.$refs.chatref.showwrapper = false;
            this.$refs.chatwrapper.onclickmsgicon("frombackbutton");
        },
        //message

        getfromidparent: async function(value) {
            //we want to store messages data for fast purpose
            //
            let fromcache = false;

            // localStorage.removeItem(value.id + '_shop_messages')

            if (localStorage.getItem(value.id + '_shop_messages') === null) {

                fromcache = false;

                console.log(value.id + '_shop_messages')

                // get data for user clicked shop
                var currentuserdata = await allfrommessagefunction.getcurrentchatuser(value.id, 0);
                //set shops messages to localstorage
                localStorage.setItem(value.id + '_shop_messages', JSON.stringify(currentuserdata))


            } else {
                fromcache = true;

                // get data for user clicked shop
                var currentuserdata = JSON.parse(localStorage.getItem(value.id + '_shop_messages'));

            }

            // var currentuserdata=await allfrommessagefunction.getcurrentchatuser(value.id,0);

            console.log(currentuserdata.data.data.messages);


            if (currentuserdata.data.success) {

                const setreadbyshop = await allfrommessagefunction.setreadbyshop(value.id);

                // }
                const tempchatdata = currentuserdata.data.data.messages.reverse();

                tempchatdata.map((d, index) => {



                    if (
                        typeof currentuserdata.data.data.messages[index + 1] !==
                        "undefined"
                    ) {
                        if (
                            tempchatdata[index + 1].from_id ==
                            tempchatdata[index].from_id
                        ) {
                            tempchatdata[index].showsendicon = false;
                        } else {
                            tempchatdata[index].showsendicon = true;
                        }
                    } else {
                        tempchatdata[index].showsendicon = true;
                    }
                });

                this.$refs.chatref.messagelimit = 20;

                await this.$refs.chatref.showwrapper;
                this.$refs.chatref.showwrapper = true;
                this.$refs.chatref.currentuserid = value.id;
                this.$refs.chatref.messagelimit += 20;

                this.$refs.chatref.chatdata = tempchatdata;


                //for user data
                var foruserdata=currentuserdata.data.data.userdata;


                if (foruserdata.phone != undefined) {
                    //if no result for this shop in db table online status
                    let status;
                    if (foruserdata.status == undefined) {
                        status = 'offline';
                    } else {
                        status = foruserdata.status;
                    }
                    this.$refs.chatref.userdata = { 'username': foruserdata.username, 'phone': foruserdata.phone, 'id': value.id, 'status': status };
                    console.log(this.$refs.chatref.userdata);
                }

                //close wrapper pannel
                this.$refs.chatwrapper.showchatlist = false;
                //and set stopscroll to false we want to scroll to bottom
                this.$refs.chatref.stopscroll = false;

                this.$refs.chatref.active =
                    this.$refs.chatref.userdata.status;

            }
            console.log('foruserdata', foruserdata);

            // showing total count on floating icon
            const total_chat_count  = await allfrommessagefunction.gettotalchatcountforshop();
            localStorage.setItem(value.shopid+'gettotalchatcountforshop', total_chat_count);
            backend.$refs.chatwrapper.getTotalCount();

            //specific count
            var count = JSON.parse(localStorage.getItem(value.shopid+'getspecificcountforshop'));
            count[foruserdata.users_id] = 0;
            localStorage.setItem(value.shopid+'getspecificcountforshop', JSON.stringify(count));
            backend.$refs.chatwrapper.specificcount = count;
        },

        //message

        //for facebook

        testf: function() {
            return allfromfbjs.ftest(this);
        },

        fblogin() {
            console.log("start fb login====");
            allfromfbjs.fblogin(this);
            console.log(this.testfbdata);
        },
        //for facebook
        //
        // //temp
        //
        // getpagetokenclick: async function() {
        //     if (this.pageid == "") {
        //         this.errorpageid = "required";
        //     } else {
        //         const temppagetoken = await this.getpagetokenfromfb(
        //             this.pageid,
        //             this.llusertoken
        //         );
        //         console.log("tempgood");
        //         console.log(temppagetoken);
        //
        //         console.log("start store token  ======");
        //         const tstoretoken = await allfromserveraction.storetoken(
        //             this.userid,
        //             this.llusertoken,
        //             temppagetoken.name,
        //             temppagetoken.id,
        //             temppagetoken.access_token
        //         );
        //         console.log("success");
        //         console.log(tstoretoken);
        //         this.fbdata.connected = "yes";
        //         this.modalShow = false;
        //     }
        //
        //     console.log("getpagetoken");
        // },
        // getpagetokenfromfb: function(pageid, llusertoken) {
        //     return new Promise((resolve, reject) => {
        //         FB.api(
        //             "/" + pageid + "?",
        //             "GET", {
        //                 fields: "access_token",
        //                 access_token: llusertoken,
        //             },
        //             (response) => {
        //                 //we will store only one page
        //                 resolve(response);
        //             }
        //         );
        //     });
        // },
        //
        // //temp

        // firebase
        firebaserequestpermission: async function() {
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
        startregisterfirebase: function() {
            console.log("firebase register");

            // Your web app's Firebase configuration
            // For Firebase JS SDK v7.20.0 and later, measurementId is optional
            const firebaseConfig = {
                // apiKey: "AIzaSyDBV05S5tzHy_O6Q4nTi_ffvnEz0NY_he0",
                // authDomain: "shweshops-d289a.firebaseapp.com",
                // projectId: "shweshops-d289a",
                // storageBucket: "shweshops-d289a.appspot.com",
                // messagingSenderId: "583933213745",
                // appId: "1:583933213745:web:2892f64591132059922910",
                // measurementId: "G-H4L7Q3SRWM",
                // Added by Swe
                apiKey: "AIzaSyD1e63wA6bVB2PVPvA5o-mq7aEtEo8DVdk",
                authDomain: "shweshops-82763.firebaseapp.com",
                projectId: "shweshops-82763",
                storageBucket: "shweshops-82763.appspot.com",
                messagingSenderId: "770728201881",
                appId: "1:770728201881:web:8897d40feb23b33c1fb208",
                measurementId: "G-6LB2JC63PV"
            };

            // Initialize Firebase
            const firebaseapp = initializeApp(firebaseConfig);
            const messaging = getMessaging(firebaseapp);

            getToken(messaging, {
                // vapidKey: "BJ1NPqHXAjJHPf4VfQDH_Q8ubT1JAAbi1TzVJKcc30sXms5Qs7KVjtBvvCQk6m73Oqvf8V9Fax46sVK2-gAJvzc",
                // Added by Swe
                vapidKey: "BMUJKZnROYZ8mwdOfQSNPq8PmjVi2nIx7aE9RRkzZnilv2JHjICRzjR-N9PmsCTD1eXDB4i8ESLQXgFhaWrC1uE",
            })
                .then((currentToken) => {
                    if (currentToken) {
                        allfromfirebase.storefirebasetokenforshop(currentToken);
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

        // for selection
    },
});

export default backend;
