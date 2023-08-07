import axios from "axios";

let hostname = 'https://' + location.hostname;
// let hostname = 'http://' + location.hostname;
// let hostname = 'http://' + location.hostname+'/moe/public';
const checkhavefromserverfireb=()=>{
    console.log('auth check')
    return new Promise(resolve => {
        axios.get(hostname + '/webservice/checkhavefromserverfirebase').then(response=>{
            resolve(response.data);
        })

    })
}
const storefirebasetoken=(data)=>{
    console.log('store to server')
    return new Promise(resolve => {
        axios.post(hostname + '/webservice/storefirebasetoken',{'token':data}).then(response=>{
            console.log('server response');
            resolve('stored');
        })

    })
}
const storefirebasetokenforshop=(data)=>{
    console.log('store to server')
    return new Promise(resolve => {
        axios.post(hostname + '/backside/shop_owner/storefirebasetokenforshop',{'token':data}).then(response=>{
            console.log('server response');
            resolve('stored');
        })

    })
}
export const allfromfirebase={
    storefirebasetoken:storefirebasetoken,
    checkhavefromserverfireb:checkhavefromserverfireb,
    storefirebasetokenforshop:storefirebasetokenforshop
}
