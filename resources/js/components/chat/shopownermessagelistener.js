import Echo from "laravel-echo";
import backend from "../../backend";

window.Pusher = require("pusher-js");
import {allfrommessagefunction} from "./messagefunctions";

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
window.onbeforeunload = function (event) {
    allfrommessagefunction.sendwhatshopisoffline(window.userid);
};

window.Echo.join("yankee.shopowner.channel." + window.userid)
    .here(() => {
        allfrommessagefunction.sendwhatshopisactive(window.userid);
    })
    .listen("Shopownermessage", async (e) => {
        console.log("shop listen event data", e);


        //for template

        // push latest message to current message
        if (
            backend.$refs.chatref.userdata.id == e.chatdata.user.id
        ) {
            var temparray = backend.$refs.chatref.chatdata;
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
            backend.$refs.chatref.chatdata = temparray;
            backend.$refs.chatref.stopscroll = false;

            // to set read by user true when chat template open
            if (backend.$refs.chatref.showwrapper) {
                allfrommessagefunction.setreadbyshop(e.chatdata.message.message_user_id);
            }
        }
        //for template

        //for localstrage
        if (localStorage.getItem(e.chatdata.message.message_user_id + '_shop_messages') !== null) {
            //get
            var tmpforls = JSON.parse(localStorage.getItem(e.chatdata.message.message_user_id + '_shop_messages'));
            //add new data to top of array
            tmpforls.data.data.messages.unshift(e.chatdata.message);
            //reset
            localStorage.setItem(e.chatdata.message.message_user_id + '_shop_messages', JSON.stringify(tmpforls));

        }
        //for localstrage


        const gslfs = await backend.$refs.chatwrapper.getshopschatlistfromserver();


        if (gslfs.data.success) {
            backend.$refs.chatwrapper.chatlist = gslfs.data.data;
        }
        localStorage.setItem(window.userid+'_schatlist',JSON.stringify(gslfs));


        if (backend.$refs.chatref.showwrapper) {
            allfrommessagefunction.setreadbyshop(e.chatdata.from_id);
        }

        // showing total count on floating icon
        const total_chat_count = await allfrommessagefunction.gettotalchatcountforshop();
        localStorage.setItem(window.userid+'gettotalchatcountforshop', total_chat_count);
        backend.$refs.chatwrapper.getTotalCount();

        //specific count
        var count = JSON.parse(localStorage.getItem(window.userid+'getspecificcountforshop'));
        count[e.chatdata.message.message_user_id] = count[e.chatdata.message.message_user_id] + 1;
        localStorage.setItem(window.userid+'getspecificcountforshop', JSON.stringify(count));
        backend.$refs.chatwrapper.specificcount = count;

    });

//for who is online
window.Echo.channel("activeusers").listen("Activeusers", (e) => {
    console.log(e.chatdata);
    if (
        backend.$refs.chatref.chatdata != undefined &&
        backend.$refs.chatref.chatdata.length != 0
    ) {
        if (backend.$refs.chatref.chatdata[0].from_id == e.chatdata.users_id) {
        }
        backend.$refs.chatref.active = e.chatdata.status;

        const findex = backend.$refs.chatwrapper.chatlist.findIndex(
            (object) => {
                return object.from_id == e.chatdata.users_id;
            }
        );
        backend.$refs.chatwrapper.chatlist[findex].status = e.chatdata.status;
    }
});

// for shopowner each other
window.Echo.channel("shopownersmessage."+window.userid).listen("Shopownersmessage", async (e) => {

  backend.$refs.chatref.stopscroll = false;
  const data = e.chatdata.message;
  backend.$refs.chatref.chatdata.push(data);
  backend.$refs.chatref.scrollbottom();

  //set data to localstorage for fast
  if (
      localStorage.getItem(
          data.message_user_id + "_shop_messages"
      ) !== null
  ) {
      var tmplsd = JSON.parse(
          localStorage.getItem(
              data.message_user_id + "_shop_messages"
          )
      );
      tmplsd.data.data.messages.unshift(data);
      localStorage.setItem(
          data.message_user_id + "_shop_messages",
          JSON.stringify(tmplsd)
      );
  }

  const gslfs = await backend.$refs.chatwrapper.getshopschatlistfromserver();

  if (gslfs.data.success) {
      backend.$refs.chatwrapper.chatlist = gslfs.data.data;
  }
  localStorage.setItem(window.userid+'_schatlist',JSON.stringify(gslfs));
});


