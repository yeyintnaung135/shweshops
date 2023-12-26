const get_data_from_server = (parmsdata) => {
    let cachekey = createcachekey(parmsdata);
    let checkcachehas = check_cache_has_data(cachekey);
    if (!parmsdata.$refs.productcom.isloadmoreprocessing && checkcachehas) {
     

        parmsdata.$refs.productcom.filterdata = get_cache_data_by_key(cachekey).data;
        console.log("cf", cachekey);


    } else {
        console.log(
            "cache not",
            parmsdata.$refs.productcom.isloadmoreprocessing
        );

        parmsdata.busy = true;
        // console.log(parmsdata.filterdata_from_server);

        let tmp_limit = 0;
        tmp_limit = parmsdata.$refs.productcom.filterdata.length;

        //for similar
        if (parmsdata.price_range != "all") {
            parmsdata.item_child_id = "empty";
        }
        // var self = parmsdata;
        parmsdata.rqcontroller = new AbortController();
        var tmpresp = 0;

        axios
            .post(
                parmsdata.$hostname + "/catfilter",
                {
                    data: parmsdata.fdata,

                    filtertype: {
                        item_id: parmsdata.item_child_id,
                        sort: parmsdata.sortby,
                        typesearch: parmsdata.typesearch,
                        byshop: parmsdata.byshop,
                        price_range: parmsdata.price_range,
                        cat_id: parmsdata.specific_cat_id,
                        gender: parmsdata.selectedgender,
                        gems: parmsdata.byspecificgems,
                        gold_colour: parmsdata.main_product_type,
                        additional: parmsdata.additional,
                        ini_checked: false,
                        discount: parmsdata.discountonly,
                        selected_product_quality:
                            parmsdata.selected_product_quality,
                        limit: tmp_limit,
                    },
                },

                { signal: parmsdata.rqcontroller.signal }
            )
            .then((response) => {
                parmsdata.busy = false;
                parmsdata.showloader = false;
                var tempthis = parmsdata;
                tmpresp = response.data[0].length;
                response.data[0].map((d) => {
                    parmsdata.$refs.productcom.filterdata.push(d);
                });

                if (response.data[0].length < 1) {
                    parmsdata.$refs.productcom.shownoitems = true;
                } else {
                    parmsdata.$refs.productcom.shownoitems = false;
                }
            })
            .then(() => {
                if (tmpresp != 0) {
                    if (localStorage.getItem("filter_cachedata") == null) {
                        var cachedata = {};
                        cachedata[cachekey] = {
                            'data': parmsdata.$refs.productcom.filterdata,
                            'timeout': new Date().addHours(1),
                        };
                        localStorage.setItem(
                            "filter_cachedata",
                            JSON.stringify(cachedata)
                        );
                        console.log("one", cachedata);
                    }
                    else {
                        var cachedata = {};
    
                        var cachedata = JSON.parse(
                            localStorage.getItem("filter_cachedata")
                        );
                        cachedata[cachekey] = {
                            data: parmsdata.$refs.productcom.filterdata,
                            timeout: new Date().addHours(5),
                        };
                        localStorage.setItem(
                            "filter_cachedata",
                            JSON.stringify(cachedata)
                        );
                        console.log("ctow", cachedata);
    
                    }

                }

            });
    }
};
Date.prototype.addHours = function(h) {
    this.setTime(this.getTime() + (h*60*60*1000));
    return this;
  }
const check_cache_has_data = (key) => {
 

    if(localStorage.getItem("filter_cachedata") != undefined){
        let cache_data = JSON.parse(localStorage.getItem("filter_cachedata"));
        if (cache_data == null) {
            return false;
        } else {
            if (cache_data[key] != undefined) {
                if(Date.parse(cache_data[key].timeout) < new Date()){
                    console.log(key,'timeout');
                    return false;
                }else{
                    return true;
    
                }
            } else {
                return false;
            }
        }
    }else{
        return false;
    }
  
};
const get_cache_data_by_key = (key) => {
    let cache_data = JSON.parse(localStorage.getItem("filter_cachedata"));
    return cache_data[key];
};
var cachedata = [];
const createcachekey = (parmsdata) => {
    console.log('gafefe',parmsdata.selectedgender);
    let cachekey =
        parmsdata.item_child_id +
        "-" +
        parmsdata.sortby +
        "-" +
        parmsdata.typesearch +
        parmsdata.byshop +
        "-" +
        parmsdata.price_range +
        "-" +
        parmsdata.specific_cat_id +
        "-" +
        parmsdata.selectedgender +
        "-" +
        parmsdata.byspecificgems +
        "-" +
        parmsdata.main_product_type +
        "-" +
        +parmsdata.additional +
        "-" +
        parmsdata.discountonly +
        "-" +
        parmsdata.selected_product_quality;
    return cachekey;
};

export const allservicesfromproductfilter = {
    get_data_from_server: get_data_from_server,
};
