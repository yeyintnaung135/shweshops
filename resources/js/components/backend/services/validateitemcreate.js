const validatecreate = (data) => {
    data.validate_errors=[];
    var tempobj={};
    if (data.name == "") {
        tempobj.name={msg:'Name ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။'};




    }
    if (data.product_code == "" || data.product_code == 0) {
        tempobj.product_code={msg:'Product code ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။'};


    }
    if (data.description == '') {
        tempobj.description={msg:'Description ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။'};


    }
    if(data.stock=='In Stock' && Number(data.stock_count) < 1 ){
        tempobj.stock_count={msg:'ပစ္စည်းအရေအတွက် ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။'};

    }
    if(Number(data.price) < 9999 && (Number(data.max_price) < 9999 || Number(data.min_price)==9999)){
        tempobj.price={msg:'စျေးနှုန်း အနည်း ဆုံး 10000 ကျပ်ဖြစ်ရမည်'};

    }else if(Number(data.price) == 0 && (Number(data.min_price)>Number(data.max_price))){
        tempobj.price={msg:'Wrong Price'};

    }
  if(JSON.stringify(tempobj) !== "{}"){
    data.validate_errors.push(tempobj);

  }

};

const dzcreateerror=(data)=>{
    data.dzerror=[];
    var tempobjdz={};
    if (data.$refs.myVueDropzone.getAcceptedFiles().length == 0) {
        tempobjdz.photo={msg:'ဓာတ်ပုံ ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။'};

    }
    if(JSON.stringify(tempobjdz) !== "{}"){
        data.dzerror.push(tempobjdz);
    
      }

}
const dzediterror=(data)=>{
    data.dzerror=[];
    var tempobjdz={};
    if (data.tempphotonames == 0) {
        tempobjdz.photo={msg:'ဓာတ်ပုံ ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။'};

    }
    if(JSON.stringify(tempobjdz) !== "{}"){
        data.dzerror.push(tempobjdz);
    
      }

}


export const allvalidate={
    validatecreate:validatecreate,
    dzcreateerror:dzcreateerror,
    dzediterror:dzediterror

};
