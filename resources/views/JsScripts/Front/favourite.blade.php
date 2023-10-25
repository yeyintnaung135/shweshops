<script>
    var FAVBUSY = false;
    const favclick = async (itemid, checkauth) => {
        if (!FAVBUSY) {
            FAVBUSY = true;
            if (checkauth == "1") {
                if ($("#ficon").hasClass("fa-regular")) {
                    let serverdata = await store_or_remove_fav_item_to_server(
                        parseInt(itemid),
                        "add"
                    );
                } else {
                    let serverdata = await store_or_remove_fav_item_to_server(
                        parseInt(itemid),
                        "remove"
                    );
                }
            } else {
                if ($("#ficon").hasClass("fa-regular")) {
                    fav_action_to_local_storage(parseInt(itemid), "add");
                    $("#ficon").removeClass("fa-regular");
                    $("#ficon").addClass("fa-solid");
                 
                } else {
                    fav_action_to_local_storage(parseInt(itemid), "remove");
                    $("#ficon").removeClass("fa-solid");
                    $("#ficon").addClass("fa-regular");
              
                }
            }
            if (typeof localStorage.getItem('favourite') !== 'undefined' && localStorage.getItem('favourite') !==
                null) {

                let tmpfavcount = JSON.parse(localStorage.getItem('favourite')).length;
                if (tmpfavcount > 0) {
                    $('.windowFavNav').removeClass("fa-regular");
                    $('.windowFavNav').addClass("fa-solid");
                } else {
                    $('.windowFavNav').removeClass("fa-solid");
                    $('.windowFavNav').addClass("fa-regular");
                }


            }
            FAVBUSY = false;
        }
    };
    const fav_rm_add_local_storage = (itemid) => {
        var tmprm = JSON.parse(localStorage.getItem("favourite_rm"));
        if (tmprm === null) {
            tmprm = [];
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
    const fav_rm_rm_local_storage = (itemid) => {
        var tmparray = JSON.parse(localStorage.getItem("favourite_rm"));
        if (tmparray !== null) {
            let remove_tmparray = JSON.parse(localStorage.getItem("favourite_rm"));
            let rmindex = remove_tmparray.findIndex((d) => {
                return parseInt(d.fav_id) == parseInt(itemid);
            });
            if (rmindex > -1) {
                remove_tmparray.splice(rmindex, 1);
            }
            localStorage.setItem("favourite_rm", JSON.stringify(remove_tmparray));
        }
    };

    const fav_action_to_local_storage = (itemid, action) => {
        if (action == "add") {
            var tmparray = JSON.parse(localStorage.getItem("favourite"));
            if (tmparray === null) {
                tmparray = [];
            }
            tmparray.push({
                fav_id: itemid,
            });
            fav_rm_rm_local_storage(itemid);
            localStorage.setItem("favourite", JSON.stringify(tmparray));
            console.log("add ls", tmparray);
        }
        if (action == "remove") {
            if (
                typeof localStorage.getItem("favourite") !== 'undefined' &&
                localStorage.getItem("favourite") !== null
            ) {
                let remove_tmparray = JSON.parse(localStorage.getItem("favourite"));
                let index = remove_tmparray.findIndex((d) => {
                    return parseInt(d.fav_id) == itemid;
                });
                if (index > -1) {
                    remove_tmparray.splice(index, 1);
                }
                fav_rm_add_local_storage(itemid);
                localStorage.setItem("favourite", JSON.stringify(remove_tmparray));
                console.log("DEL ls", remove_tmparray);
            }
        }
    };
    const ini_fav_check = (itemid, auth) => {
        if (auth == 1) {
            axios
                .post("{{ url('/myfav/check') }}", {
                    fav_id: itemid,
                })
                .then((response) => {
                    if (response.data.success) {
                        $("#ficon").removeClass("fa-regular");
                        $("#ficon").addClass("fa-solid");
                    } else {
                        $("#ficon").removeClass("fa-solid");
                        $("#ficon").addClass("fa-regular");
                    }
                });
        } else {
            if (
                typeof localStorage.getItem("favourite") !== 'undefined' &&
                localStorage.getItem("favourite") !== null
            ) {
                let remove_tmparray = JSON.parse(localStorage.getItem("favourite"));

                let index = remove_tmparray.findIndex((d) => {
                    return parseInt(d.fav_id) == itemid;
                });
                if (index > -1) {
                    $("#ficon").removeClass("fa-regular");
                    $("#ficon").addClass("fa-solid");
                } else {
                    $("#ficon").removeClass("fa-solid");
                    $("#ficon").addClass("fa-regular");
                }
            }
        }
        console.log("ini check", itemid);
    };
    ini_fav_check("{{ $item->id }}", "{{ Auth::check() }}");

    const store_or_remove_fav_item_to_server = (itemid, action) => {
        var act = action;
        return new Promise((resolve, reject) => {
            axios
                .post("{{ url('/myfav/action') }}", {
                    fav_id: itemid,
                    action: action,
                })
                .then((response) => {
                    if (response.data.success) {
                        if (act == "add") {
                            $("#ficon").removeClass("fa-regular");
                            $("#ficon").addClass("fa-solid");
                            localStorage.setItem(
                                "favourite",
                                JSON.stringify(response.data.data)
                            );
                            fav_rm_rm_local_storage(itemid);
                        } else {
                            $("#ficon").removeClass("fa-solid");
                            $("#ficon").addClass("fa-regular");
                            fav_action_to_local_storage(itemid, "remove");
                        }
                    }
                    resolve(response);
                });
        });
    };
</script>
