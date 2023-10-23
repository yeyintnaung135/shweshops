import {allfromserveraction} from "./serveraction";
import {allfromwebhook} from "./webhook";

var templltoken = 'ff';
const ftest = function (thisfromparent) {
    thisfromparent.testfbdata = 'xx'

    console.log('dd')
};

const initialfacebook = function (thisfromparent) {
    window.fbAsyncInit = () => {
        FB.init({
            appId: process.env.MIX_FACEBOOK_APP_ID,
            autoLogAppEvents: true,
            xfbml: true,
            version: 'v13.0'
        });

        wehavetokenshowconnected(thisfromparent)
    };

    ((d, s, id) => {
        var js,
            fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    })(document, "script", "facebook-jssdk");
}

const wehavetokenshowconnected=async function (thisfromparent){
    const temp = await allfromserveraction.checkwehavetokenfromserver();
    if(temp.data.status){
        thisfromparent.fbdata.connected='yes'
    }else{
        thisfromparent.fbdata.connected='no'
    }
    thisfromparent.fbdata.showdv='yes'

}

const checkfblogined = async function (thisfromparent) {
    console.log('checkstarting login ====');
    var self = thisfromparent;

    await FB.getLoginStatus(async function (response) {
        if (response.status == 'connected') {
//check ltusertoken or page token has in our server
            const temp = await allfromserveraction.checkwehavetokenfromserver();
            if (temp.data.status) {
                console.log('success');
                self.fbdata.connected = 'yes';

            } else {

                console.log('start get ll user token ======')
                const getllusertoken =await getlongliveuseraccepttoken(self, response.authResponse.accessToken);
                console.log('success')
                console.log(getllusertoken)

                //temp
                self.llusertoken=getllusertoken;
                self.userid=response.authResponse.userID;
                showpageidinputform(thisfromparent);

                //temp

                console.log('start get ll page token ======')
                const getpagelltoken=await getlonglivepageaccesstoken(response.authResponse.userID,getllusertoken)
                console.log('success')

                console.log('start store token  ======')
                const tstoretoken=await allfromserveraction.storetoken(response.authResponse.userID,getllusertoken,getpagelltoken.name,getpagelltoken.id,getpagelltoken.access_token);
                console.log('success')

                console.log('webhook subscribe====')
                const temptosubscribefields=await allfromwebhook.tosubscribefields(getpagelltoken.id,getpagelltoken.access_token);
                console.log('success')


                const tempgetstart=await allfromwebhook.getstartbuttonsetup();
                console.log('getstart button====')

                console.log('success')
                self.fbdata.connected = 'yes';


            }

        } else {
            console.log(response);

        }


    });


}
//temp
const showpageidinputform=(thisfromparent)=>{
    thisfromparent.modalShow=true;

}

//temp

const getlongliveuseraccepttoken = (thisfromparent, sltoken) => {
    var publicsltoken = sltoken;


    return new Promise((resolve,reject)=>{
        FB.api(
            '/oauth/access_token',
            'GET',
            {
                "grant_type": "fb_exchange_token",
                "client_id": process.env.MIX_FACEBOOK_APP_ID,
                "client_secret": process.env.MIX_FACEBOOK_APP_SECRET,
                "fb_exchange_token": publicsltoken
            },
            (response) => {
                resolve(response.access_token)
            }
        );})


};
const getlonglivepageaccesstoken = (userid, llusertoken) => {



    return new Promise((resolve,reject)=>{
        FB.api(
            '/'+userid+'/accounts?',
            'GET',
            {
                "fields": "name,access_token",
                "access_token": llusertoken
            },
            (response) => {

                console.log(response)
                //we will store only one page
                resolve(response.data[0])
            }
        );})


};



const fblogin = function (thisfromparent) {
    var self = thisfromparent;
    FB.login(function (response) {
        if (response.status == 'connected') {
            checkfblogined(self)
        }
    }, {scope: 'public_profile,catalog_management,email,pages_messaging,pages_show_list,pages_manage_posts,pages_read_engagement,pages_manage_metadata'});
}


const getdataafterlogin = function (thisfromparent) {
    console.log('get data of user login ====')

    var self = thisfromparent;

    FB.api(
        '/me',
        'GET',
        {"fields": "id,name,email,birthday"},
        function (response) {
            self.testfbdata = response;
            // Insert your code here
            return response;
        }
    );
}


export const allfromfbjs = {
    initialfacebook: initialfacebook,
    ftest: ftest,
    checkfblogined: checkfblogined,
    fblogin: fblogin
};

