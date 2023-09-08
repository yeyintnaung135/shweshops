<template>
    <div class="mx-4 px-md-5">
        <div class="text-center my-3 products default">
            <h1 style="font-family: sans-serif !important">{{ header }}</h1>
        </div>

    </div>
</template>
<script>
import Vue from "vue";
import VueLazyload from "vue-lazyload";
import app from "../../app";

Vue.use(VueLazyload, {
    preLoad: 1.3,
    error: "dist/error.png",
    loading: "test/KSYL.gif",
    attempt: 1,
});

export default {
    props: ["localkey", "headertext", "checkauth", "fordate"],

    data: function () {
        return {
            header: "",
            hostname: "",
            localData: [],
            host: "",
            isDeleted: false,

            SyncID: "",
            id: "",
            imgurl: "",
        };
    },
    mounted() {
        this.getDataFromLocal();
        this.host = this.$hostname;
        this.userid != null ? (this.id = this.userid.id) : (this.id = "");
        this.header = this.headertext;
        if (process.env.MIX_USE_DO == "true") {
            this.imgurl = process.env.MIX_DO_URL;
        } else {
            this.imgurl = this.$hostname;
        }
        this.getfav_or_addtocarddata();
    },
    filters: {
        strlimit: function (str, limit, other) {
            if (str.length > limit) {
                let shortstring = str.substring(0, limit) + other;
                return shortstring;
            } else {
                return str;
            }
        },
    },

    methods: {
        getitemdata: function (id) {
            return new Promise((resolve) => {
                axios
                    .post(this.host + "/getitemdata", { itemid: id }, {})
                    .then(async (response) => {
                        resolve(response);
                    });
            });
        },
        buynowbuttonclick: async function (itemid) {
            //get itemdat by id
            const itemdata = await this.getitemdata(itemid);
            //get itemdat by id

            //set data to LS because if use is not logined user will login login form is made with Form this can be redirect
            // localStorage.removeItem('foraddtocartitems');
            // localStorage.removeItem('datenow');

            if (this.checkauth != 1) {
                localStorage.setItem(
                    "foraddtocartitems",
                    JSON.stringify(itemdata)
                );
                localStorage.setItem("datenow", this.fordate);
            }

            //set data to LS because if use is not logined user will login login form is made with Form this can be redirect

            console.log(
                "localStorage in vue",
                localStorage.getItem("foraddtocartitems")
            );

            this.$root.buynowbuttonclick(
                this.checkauth,
                itemdata.data.ShopName.id,
                itemdata.data,
                "post",
                this.userid ? this.userid.username : "",
                itemdata.data.ShopName,
                this.fordate
            );
        },
        getfav_or_addtocarddata: async function() {
            if (!this.checkauth) {
                let localdata = this.getDataFromLocal();
                let getallfavlist = await new Promise((resolve) => {
                    axios
                        .post(this.host + "/myfav/see_all", {
                            fav_ids: localdata,
                        })
                        .then(async (response) => {
                            resolve(response);
                        });
                });
                console.log("auth check", 'ff');

            }
            console.log("auth check", this.checkauth);
        },
        getDataFromLocal: function () {
            const data = JSON.parse(
                window.localStorage.getItem(this.localkey) || "{}"
            );
            return data;
        },
    },
};
</script>
<style scoped>
.category_id a {
    color: #780116 !important;
}

.category_id {
    text-transform: capitalize;
}

.sop-btn {
    cursor: pointer;
    margin-top: -10px;
    margin-right: -5px;
}

.ShopName span {
    color: #780116;
}

.product_code span {
    color: #780116;
}

.detail {
    text-decoration: underline;
}

.sop-border {
    border: solid 1px #cfcfcf;
    border-radius: 5px;
}

.sop-buynow-button {
    background: #780116 !important;
    border-radius: 5px !important;
    border-color: #780116 !important;
    width: 80% !important;
    margin-bottom: 10px;
    color: #fff !important;
    /* font-size: 18px !important; */
    padding: 7px 0 !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
        Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
    font-weight: 500 !important;
}

.sop-buynow-button:hover {
    background: #780117d8 !important;
}
.atc-buynow-button {
    /* zh-modify */
    background: #780116 !important;
    border-radius: 5px !important;
    border-color: #780116 !important;

    margin: 0px auto 0;
    color: rgb(255, 255, 255) !important;
    font-size: 16px !important;
    padding: 7px 20px !important;
    /*font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;*/
    font-weight: 500 !important;
}

.atc-buynow-button:hover {
    background: #a90220 !important;
}
.sop-p {
    padding-top: 20px;
    font-size: 1.2em;
    color: #7c7c7c;
}

@media only screen and (max-width: 576px) {
    .mmprice {
        font-size: 1.2em;
    }

    .category_id {
        text-transform: capitalize;
        font-size: 0.8em;
    }

    .product_code {
        font-size: 0.8em;
    }

    .detail {
        font-size: 0.7em;
    }

    .ShopName {
        font-size: 0.8em;
    }

    .sop-buynow-button {
        font-size: 0.8em;
    }

    .addtocart-p {
        padding: 8px;
    }

    .sop-border {
        min-height: 160px;
        height: 100%;
    }

    .sop-atc-img {
        width: 100%;
        height: 158px;
        object-fit: cover;
    }
    .atc-buynow-button {
        padding: 3px 10px !important;
    }
}

@media only screen and (min-width: 576px) {
    .mmprice {
        font-size: 1.4em;
    }

    .category_id {
        text-transform: capitalize;
        font-size: 0.9em;
    }

    .product_code {
        font-size: 0.9em;
    }

    .detail {
        font-size: 0.8em;
    }

    .ShopName {
        font-size: 0.9em;
    }

    .sop-buynow-button {
        font-size: 0.9em;
    }

    .addtocart-p {
        padding: 16px;
    }

    .sop-border {
        min-height: 180px;
        height: 100%;
    }

    .sop-atc-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
}
</style>
