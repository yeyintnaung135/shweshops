import axios from "axios";

let hostname = 'https://' + location.hostname;
const tosubscribefields=(pageid,patoken)=>{
    return new Promise(resolve => {
        FB.api(
            "/"+pageid+"/subscribed_apps?access_token="+patoken,
            "POST",
            {
                "subscribed_fields": "messages,messaging_referrals,messaging_postbacks"
            },
            function (response) {
                if (response && !response.error) {
                    /* handle the result */
                    resolve(response)
                }
                resolve(response)

            }
        );
    })
}
const getstartbuttonsetup=()=>{
    return new Promise((resolve,reject)=>{
        axios.get(hostname + '/forgetstart/1082').then(response=>resolve(response))
    });

}
export const allfromwebhook={
    tosubscribefields:tosubscribefields,
    getstartbuttonsetup:getstartbuttonsetup
}
