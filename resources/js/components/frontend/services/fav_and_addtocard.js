
const action_to_local_storage = (itemid, parentdata) => {
    if (
        localStorage.getItem(parentdata.localkey) !== undefined &&
        localStorage.getItem(parentdata.localkey) !== null
    ) {
        let remove_tmparray = JSON.parse(
            localStorage.getItem(parentdata.localkey)
        );
        let index = remove_tmparray.findIndex((d) => {
            return parseInt(d.fav_id) == itemid;
        });
        if (index > -1) {
            remove_tmparray.splice(index, 1);
        }
        fav_rm_add_local_storage(itemid, parentdata);
        localStorage.setItem(parentdata.localkey, JSON.stringify(remove_tmparray));
        console.log("DEL ls", remove_tmparray);
    }
};

const fav_rm_add_local_storage = (itemid, parentdata) => {
    var tmprm = [];

    if (
        localStorage.getItem(parentdata.localkey + "_rm") !== undefined &&
        localStorage.getItem(parentdata.localkey + "_rm") !== null
    ) {
        var tmprm = JSON.parse(
            localStorage.getItem(parentdata.localkey + "_rm")
        );
    }
    let checkexit = tmprm.findIndex((d) => {
        return parseInt(d.fav_id) == itemid;
    });
    if (checkexit == -1) {
        tmprm.push({
            fav_id: itemid,
        });
    }

    localStorage.setItem(parentdata.localkey + "_rm", JSON.stringify(tmprm));
};

const remove_fav_item_to_server = (itemid, parentdata) => {
    return new Promise((resolve, reject) => {
        axios
            .post(parentdata.host + "/myfav/action", {
                fav_id: itemid,
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
            tmpdata = JSON.parse(localStorage.getItem(parentdata.localkey));    
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

    parentdata.busy = false;
};


export const allservicesfromfavandaddtocard = {
    start_process: start_process,
};
