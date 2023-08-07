<template>
    <div class="ms-md-4 me-md-4 yksupport" style="margin-top:22px;border-radius:8px;">
        <div class="ms-md-4 me-md-4">
            <div class="row g-0">
            <div class="col-6  mb-4 display-6" style="color:black;font-weight: bold;">
                Help & Support
            </div>

            <div class="col-6 mb-4 d-flex justify-content-end" style="color:black;font-weight: bold;    font-size: 22px;">
                <div class="col-12 col-md-6">


                    <select   v-model="selected_cat"
                              @change="changecat"

                              class="form-control" placeholder="CAT" required>
                        <option selected value="0">Choose Category</option>
                        <option  v-for="c in this.catall"
                                 :key="c.key" :value="c.id">{{ c.title }}</option>


                    </select>

                </div>
            </div>
            </div>
            <div>
                <div class="">

                    <div class="site-content"
                        v-infinite-scroll="loadMore"
                        infinite-scroll-disabled="busy"
                        infinite-scroll-distance="340"
                    >
                        <!-- <div> -->


                        <div
                            class="products default loading row g-2 g-md-3"
                            style="padding-bottom: 12px"

                        >
                            <div
                                class="col-12  mb-4 mb-sm-0 col-sm-6 col-md-6 col-lg-4 yk-fade"
                                v-for="item in this.showdata"
                                :key="item.key"
                            >

                                <div class="row ml-2">

                                    <iframe style="width: 100%;
                height: 211px;" :src="item.video" title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>
                                    <div style="    margin-top: -13px;
">{{ item.title }}
                                    </div>

                                </div>


                            </div>

                            <div
                                v-if="this.emptyonserver === 0"
                                class="col-12"
                                style="height: 222px !important"
                            >
                                <div
                                    class="yk-wrapper fff"
                                    style="position: relative !important; margin-top: 56px"
                                >
                                    <div class="ct-spinner5">
                                        <div class="bounce1"></div>
                                        <div class="bounce2"></div>
                                        <div class="bounce3"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from "axios";

export default {
    props: [
        "data",'cats'

    ],
    name: "SupportsoComponent",
    data: function () {
        return {
            showdata: '',
            selected_cat: '0',
            emptyonserver: 0,
            busy: false,
            host: "",
            shoplimit: 0,
            catall:''


        }
    },
    mounted() {

        this.host = this.$hostname;

        this.showdata = this.data;
        this.catall = this.cats;
        console.log(this.showdata)
        this.shoplimit = this.showdata.length;
        if (this.showdata.length < 20) {
            this.emptyonserver = 1;
        }
    },
    methods: {
        changecat() {
            console.log(this.selected_cat);
            this.shoplimit=0;
            axios
                .post(
                    this.host + "/backside/shop_owner/get_support_by_cat",
                    {
                        filtertype: {
                            cat_id:this.selected_cat,
                            limit: 0,
                        },
                    },
                    {
                        header: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                )
                .then((response) => {
                    console.log('feres');
                    this.showdata =response.data['shops'];

                    if (response.data['empty_on_server'] == 1) {
                        this.emptyonserver = 1;
                        this.busy = true;
                    } else {
                        this.emptyonserver = 0;
                        this.busy = false;
                    }
                });
        },


        loadMore() {

            this.busy = true;

            axios
                .post(
                    this.host + "/backside/shop_owner/get_support",
                    {
                        filtertype: {
                            cat_id:this.selected_cat,

                            // shopname: this.search,
                            limit: this.shoplimit,
                        },
                    },
                    {
                        header: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                )
                .then((response) => {
                    if (response.statusText == "OK") {
                        setTimeout(() => {
                            let setemptyonserver = (e) => {
                                this.emptyonserver = e;
                                this.shoplimit += response.data['count'];
                            };

                            let setfilterdata = (data) => {
                                data.map((d) => {
                                    this.showdata.push(d);
                                });
                            }

                            let setbusy = () => {
                                if (this.emptyonserver == 1) {
                                    this.busy = true;
                                } else {
                                    this.busy = false;
                                }
                            };

                            async function tosetdata() {
                                await setemptyonserver(
                                    response.data['empty_on_server']
                                );
                                await setfilterdata(response.data['shops']);
                                await setbusy();
                            }

                            tosetdata();
                        }, 500);
                    }
                });
        },
    },

}
</script>

<style scoped>

</style>
