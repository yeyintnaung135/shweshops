const action_to_local_storage = (itemid, parentdata) => {
    if (
        typeof localStorage.getItem("favourite") !== "undefined" &&
        localStorage.getItem("favourite") !== null
    ) {
        let remove_tmparray = JSON.parse(localStorage.getItem("favourite"));
        let index = remove_tmparray.findIndex((d) => {
            return parseInt(d.fav_id) == itemid;
        });
        if (index > -1) {
            remove_tmparray.splice(index, 1);
        }
        fav_rm_add_local_storage(itemid, parentdata);
        localStorage.setItem("favourite", JSON.stringify(remove_tmparray));
        console.log("DEL ls", remove_tmparray);
    }
};

const fav_rm_add_local_storage = (itemid, parentdata) => {
    var tmprm = [];

    if (
        typeof localStorage.getItem("favourite_rm") !== "undefined" &&
        localStorage.getItem("favourite_rm") !== null
    ) {
        var tmprm = JSON.parse(localStorage.getItem("favourite_rm"));
    }
    let checkexit = tmprm.findIndex((d) => {
        return parseInt(d.fav_id) == itemid;
    });
    if (checkexit == -1) {
        tmprm.push({
            fav_id: itemid,
        });
    }

    localStorage.setItem("favourite_rm", JSON.stringify(tmprm));
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
            tmpdata = JSON.parse(localStorage.getItem("favourite"));
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
    if (
        typeof localStorage.getItem("favourite") !== "undefined" &&
        localStorage.getItem("favourite") !== null
    ) {
        let tmpfavcount = JSON.parse(localStorage.getItem("favourite")).length;
        if (tmpfavcount > 0) {
            $(".windowFavNav").removeClass("fa-regular");
            $(".windowFavNav").addClass("fa-solid");
        } else {
            $(".windowFavNav").removeClass("fa-solid");
            $(".windowFavNav").addClass("fa-regular");
        }
    }
    parentdata.busy = false;
};

export const allservicesfromfavourite = {
    start_process: start_process,
};
