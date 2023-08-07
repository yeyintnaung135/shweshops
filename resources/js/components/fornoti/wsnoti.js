import axios from "axios";

let hostname = 'https://' + location.hostname;
// let hostname = 'http://' + location.hostname+'/moe/public';
const checkhavefromserver=()=>{
    console.log('store to ffffffffffserver')
    return new Promise(resolve => {
        axios.get(hostname + '/webservice/checkhavefromserver').then(response=>{
            resolve(response.data);
        })

    })
}

const storetoserver=(data)=>{
    console.log('store to server')
    return new Promise(resolve => {
        axios.post(hostname + '/webservice/storewspushapi',{'data':data}).then(response=>{
            console.log('server response');
            resolve('stored');
        })

    })
}

export const allfromws={
    storetoserver:storetoserver,
    checkhavefromserver:checkhavefromserver
}
