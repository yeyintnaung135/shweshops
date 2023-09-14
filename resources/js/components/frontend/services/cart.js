const action_to_local_storage = (itemid, parentdata) => {
  
    if (
        typeof localStorage.getItem("cart") !== 'undefined' &&
        localStorage.getItem("cart") !== null
    ) {
        let remove_tmparray = JSON.parse(
            localStorage.getItem("cart")
        );
        let index = remove_tmparray.findIndex((d) => {
            return parseInt(d.cart_id) == itemid;
        });
        if (index > -1) {
            remove_tmparray.splice(index, 1);
        }
        fav_rm_add_local_storage(itemid, parentdata);
        localStorage.setItem(
            "cart",
            JSON.stringify(remove_tmparray)
        );
        console.log("DEL ls", remove_tmparray);
    }
};

const fav_rm_add_local_storage = (itemid, parentdata) => {
    var tmprm = [];

    if (
        typeof localStorage.getItem("cart_rm") !== 'undefined' &&
        localStorage.getItem("cart_rm") !== null
    ) {
        var tmprm = JSON.parse(
            localStorage.getItem("cart_rm")
        );
    }
    let checkexit = tmprm.findIndex((d) => {
        return parseInt(d.cart_id) == itemid;
    });
    if (checkexit == -1) {
        tmprm.push({
            cart_id: itemid,
        });
    }

    localStorage.setItem("cart_rm", JSON.stringify(tmprm));
};

const remove_fav_item_to_server = (itemid, parentdata) => {
    return new Promise((resolve, reject) => {
        axios
            .post(parentdata.host + "/mycart/action", {
                cart_id: itemid,
                action: "remove",
            })
            .then((response) => {
                if (response.data.success) {
                    action_to_local_storage(itemid, parentdata);
                }
                resolve(response);
            });
    });
};

const start_process = async (itemid, parentdata) => {
    if (!parentdata.busy) {
        parentdata.busy = true;
        var tmpdata = [];
        if (parentdata.checkauth) {
            let serverdata = await remove_fav_item_to_server(
                parseInt(itemid),
                parentdata
            );
            if (serverdata.data.success) {
                tmpdata = serverdata.data.data;
            }
        } else {
            action_to_local_storage(parseInt(itemid), parentdata);
            tmpdata = JSON.parse(localStorage.getItem("cart"));
        }
        if (tmpdata.length > 0) {
            let resp = await parentdata.get_fav_items_data(tmpdata, parentdata);
            if (resp.data.success) {
                parentdata.localData = resp.data.data;
            } else {
                parentdata.localData = [];
            }
        } else {
            parentdata.localData = [];
        }
    }
  
    $(document).ready(function() {

        if (typeof localStorage.getItem('cart') !== 'undefined' && localStorage.getItem('cart') !== null) {

            let tmpcartcount = JSON.parse(localStorage.getItem('cart')).length;
            if (tmpcartcount > 10) {
                $('#cart_count').html("10+");

            } else {
                $('#cart_count').html(JSON.parse(localStorage.getItem('cart')).length);

            }

        }

    });

    parentdata.busy = false;
};

export const allservicesfromcart = {
    start_process: start_process,
};
