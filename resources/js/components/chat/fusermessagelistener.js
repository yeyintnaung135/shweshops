import Echo from "laravel-echo";
import app from "../../app";
import axios from "axios";
import { allfrommessagefunction } from "./messagefunctions";
// import backend from "../../backend";

window.Pusher = require("pusher-js");

window.Echo = new Echo({
    broadcaster: "pusher",
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.host,
    wssPort: 6002,
    wsPort: 6002,
    forceTLS: true,
    disableStats: false,
    enabledTransports: ["ws", "wss"],
    authEndpoint: "/broadcasting/auth",
    // authEndpoint: '/moe/public/broadcasting/auth'
});
// var tempid = window.userid;
// if (window.userid != undefined) {
//     tempid = window.userid;
// }
window.onbeforeunload = function (event) {
    allfrommessagefunction.sendwhatuserisoffline(window.userid);
};

window.Echo.join("user.channel." + Number(window.userid))
    .here((user) => {
        //if user join to channel send i am online to server

        allfrommessagefunction.sendwhatuserisactive(window.userid);

        console.log("user is online");
    })
    .joining((user) => {

    })
    .leaving(() => {
        allfrommessagefunction.sendwhatuserisoffline(window.userid);

        console.log("user is online");
    })
    .listen("Usermessage", async (e) => {
        //listen to event laravel
        //we must clear local chatlist data
        // if( localStorage.getItem('chatlist') !== null) {
        //
        //     localStorage.removeItem("chatlist");
        // }

        console.log("user listen event data", e);
        console.log(app.$refs.chatlistref.chatdata);
        //start find specified shoplist index of chat list
        let spcindex=app.$refs.chatlistref.chatdata.findIndex(x=>{
            return x.message_shop_id === e.chatdata.message.message_shop_id

        })
        //for template

        // push latest message to current message
        if (
            app.$refs.chatref.shopdata.id == e.chatdata.shop.id
        ) {
            var temparray = app.$refs.chatref.chatdata;
            temparray.push(e.chatdata.message);


            // to show sender icon

            temparray.map((d, index) => {
                //if current message and next msg is equal from id we dnt show sender icon
                if (typeof temparray[index + 1] !== "undefined") {
                    if (
                        temparray[index + 1].from_id == temparray[index].from_id
                    ) {
                        temparray[index].showsendicon = false;
                    } else {
                        temparray[index].showsendicon = true;
                    }
                } else {
                    temparray[index].showsendicon = true;
                }
            });
            app.$refs.chatref.chatdata = temparray;
            app.$refs.chatref.stopscroll = false;

            // to set read by user true when chat template open
            if(app.$refs.chatref.showwrapper) {
                allfrommessagefunction.setreadbyuser(e.chatdata.message.message_shop_id);
            }
        }
        //for template

        //for localstrage
        if( localStorage.getItem(e.chatdata.message.message_shop_id+'_messages') !== null){
            //get
            var tmpforls=JSON.parse(localStorage.getItem(e.chatdata.message.message_shop_id+'_messages'));
            //add new data to top of array
            tmpforls.data.data.messages.unshift(e.chatdata.message);
            //reset
            localStorage.setItem(e.chatdata.message.message_shop_id+'_messages',JSON.stringify(tmpforls));

        }
        //for localstrage

        // get the last message
        const gclfs = await getlist();

        // show the last message on wrapper list
        if (gclfs.data.success) {
            app.$refs.chatlistref.chatdata = gclfs.data.data;
        }
        localStorage.setItem(window.userid + 'chatlist',JSON.stringify(gclfs));

        // showing total count on floating icon
        const total_chat_count = await allfrommessagefunction.gettotalchatcountforuser();
        localStorage.setItem(window.userid+'gettotalchatcountforuser', total_chat_count);
        app.$refs.chatlistref.getTotalCount();

        //specific count
        var count = JSON.parse(localStorage.getItem(window.userid+'getspecificcount'));
        count[e.chatdata.message.message_shop_id] = count[e.chatdata.message.message_shop_id] + 1;
        localStorage.setItem(window.userid+'getspecificcount', JSON.stringify(count));
        app.$refs.chatlistref.specificcount = count;

    });

//for what shop is online
window.Echo.channel("activeusers").listen("Activeusers", (e) => {
    console.log(e)
    //for chat template
    if (app.$refs.chatref.chatdata.length != 0) {
        //if top message from id equal to event shops_id
        if (
            app.$refs.chatref.chatdata[0].message_shop_id == e.chatdata.shops_id
        ) {
            //change active status on chat template
            app.$refs.chatref.shopdata.status = e.chatdata.status;
        }
    }

    if (app.$refs.chatlistref.chatdata.length != 0) {
        //for chat wrapper
        const findex = app.$refs.chatlistref.chatdata.findIndex((object) => {
            // find index of event shop id
            return object.message_shop_id == e.chatdata.shops_id ;
        });
        // set online status
        console.log(findex);

        app.$refs.chatlistref.chatdata[findex].shopdata.status = e.chatdata.status;
    }

    //for local stroage update
    // for chat template
    if( localStorage.getItem(e.chatdata.shops_id+'_messages') !== null){
        //retrive ls
        var tmpforlsact=JSON.parse(localStorage.getItem(e.chatdata.shops_id+'_messages'));
        //update status
        tmpforlsact.data.data.shop_data.status=e.chatdata.status;
        //set
        localStorage.setItem(e.chatdata.shops_id+'_messages',JSON.stringify(tmpforlsact));
        console.log(tmpforlsact);

    }


});

const getlist = () => {
    return new Promise((resolve) => {
        axios.get(app.host + "/getuserchatlistsfromserver").then((response) => {
            resolve(response);
        });
    });
};
const showbrowsernoti = () => {
    new Notification("title");
};
