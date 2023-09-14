<script>
    var CARTBUSY = false;
    const cartclick = async (itemid, checkauth) => {
        if (!CARTBUSY) {
            CARTBUSY = true;
            if (checkauth == "1") {
                if ($("#selection").html() == 'ရွေးထားမယ်') {
                    let serverdata = await store_or_remove_cart_item_to_server(
                        parseInt(itemid),
                        "add"
                    );
                } else {
                    let serverdata = await store_or_remove_cart_item_to_server(
                        parseInt(itemid),
                        "remove"
                    );
                }
            } else {
                if ($("#selection").html() == 'ရွေးထားမယ်') {
                    cart_action_to_local_storage(parseInt(itemid), "add");
                    $("#selection").html('ရွေးပြီးပြီ');
                } else {
                    cart_action_to_local_storage(parseInt(itemid), "remove");
                    $("#selection").html('ရွေးထားမယ်');

                }
            }
            if (typeof localStorage.getItem('cart') !== 'undefined' && localStorage.getItem('cart') !==
                null) {

                let tmpcartcount = JSON.parse(localStorage.getItem('cart')).length;
                if (tmpcartcount > 10) {
                    $('#cart_count').html("10+");

                } else {
                    $('#cart_count').html(JSON.parse(localStorage.getItem('cart')).length);

                }

            }
            CARTBUSY = false;
        }
    };
    const cart_rm_add_local_storage = (itemid) => {
        var tmprm = JSON.parse(localStorage.getItem("cart_rm"));
        if (tmprm === null || tmprm===undefined) {
            tmprm = [];
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
    const cart_rm_rm_local_storage = (itemid) => {
        var tmparray = JSON.parse(localStorage.getItem("cart_rm"));
        if (tmparray !== null) {
            let remove_tmparray = JSON.parse(localStorage.getItem("cart_rm"));
            let rmindex = remove_tmparray.findIndex((d) => {
                return parseInt(d.cart_id) == parseInt(itemid);
            });
            if (rmindex > -1) {
                remove_tmparray.splice(rmindex, 1);
            }
            localStorage.setItem("cart_rm", JSON.stringify(remove_tmparray));
        }
    };

    const cart_action_to_local_storage = (itemid, action) => {
        if (action == "add") {
            var tmparray = JSON.parse(localStorage.getItem("cart"));
            if (tmparray == null) {
                tmparray = [];
            }
            tmparray.push({
                cart_id: itemid,
            });
            cart_rm_rm_local_storage(itemid);
            localStorage.setItem("cart", JSON.stringify(tmparray));
            console.log("add ls", tmparray);
        }
        if (action == "remove") {
            if (
                typeof localStorage.getItem("cart") !== 'undefined' &&
                localStorage.getItem("cart") !== null
            ) {
                let remove_tmparray = JSON.parse(localStorage.getItem("cart"));
                let index = remove_tmparray.findIndex((d) => {
                    return parseInt(d.cart_id) == itemid;
                });
                if (index > -1) {
                    remove_tmparray.splice(index, 1);
                }
                cart_rm_add_local_storage(itemid);
                localStorage.setItem("cart", JSON.stringify(remove_tmparray));
            }
        }
    };
    const ini_cart_check = (itemid, auth) => {
        if (auth == 1) {
            axios
                .post("{{ url('/mycart/check') }}", {
                    cart_id: itemid,
                })
                .then((response) => {
                    if (response.data.success) {
                        $("#selection").html('ရွေးပြီးပြီ');
                    } else {
                        $("#selection").html('ရွေးထားမယ်');
                    }
                });
        } else {
            if (
                typeof localStorage.getItem("cart") !== 'undefined' &&
                localStorage.getItem("cart") !== null
            ) {
                let remove_tmparray = JSON.parse(localStorage.getItem("cart"));

                let index = remove_tmparray.findIndex((d) => {
                    return parseInt(d.cart_id) == itemid;
                });
                if (index > -1) {
                    $("#selection").html('ရွေးပြီးပြီ');

                } else {
                    $("#selection").html('ရွေးထားမယ်');

                }
            }
        }
        console.log("ini check", itemid);
    };
    ini_cart_check("{{ $item->id }}", "{{ Auth::check() }}");

    const store_or_remove_cart_item_to_server = (itemid, action) => {
        var act = action;
        return new Promise((resolve, reject) => {
            axios
                .post("{{ url('/mycart/action') }}", {
                    cart_id: itemid,
                    action: action,
                })
                .then((response) => {
                    if (response.data.success) {
                        if (act == "add") {
                            $("#selection").html('ရွေးပြီးပြီ');

                            localStorage.setItem(
                                "cart",
                                JSON.stringify(response.data.data)
                            );
                            cart_rm_rm_local_storage(itemid);
                        } else {
                            $("#selection").html('ရွေးထားမယ်');

                            cart_action_to_local_storage(itemid, "remove");
                        }
                    }
                    resolve(response);
                });
        });
    };
</script>
