import axios from "axios";

let hostname = 'https://' + location.hostname;

const storetoken = (userid,llusertoken,pagename,page_id,llpagetoken) => {
return new Promise((resolve,reject)=>{
    axios.post(hostname + '/storetoken',{'fb_user_id':userid,'longliveusertoken':llusertoken,'pagename':pagename,'page_id':page_id,'longlivepagetoken':llpagetoken}).then(response=>{
        console.log('server response');
        resolve(response);
    })
})
};
 const checkwehavetokenfromserver=()=>{
     return new Promise((resolve,reject)=>{
         axios.get(hostname + '/checkwehavetoken').then(response=>resolve(response))
     });

}

export const allfromserveraction = {checkwehavetokenfromserver: checkwehavetokenfromserver,storetoken:storetoken};
