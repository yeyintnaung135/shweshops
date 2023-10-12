<template>
    <div class="row">
        <div class="col-md-12">
            <div style="text-align: center">
                <label
                    v-bind:class="{
                        'sn-required-asterick': validatedz_css(),
                    }"
                    >အနည်းဆုံး ပုံ တစ်ပုံတင်ပါ
                </label>
            </div>

            <vue-dropzone
                ref="myVueDropzone"
                :useCustomSlot="true"
                v-on:vdropzone-sending-multiple="sendingEvent"
                v-on:vdropzone-error-multiple="errorEvent"
                v-on:vdropzone-thumbnail="thumbnail"
                :include-styling="false"
                v-on:vdropzone-files-added="multiplefilesadded"
                v-on:vdropzone-mounted="callaftermount"
                v-on:vdropzone-success-multiple="successEvent"
                v-on:vdropzone-max-files-exceeded="maxfilesEvent"
                v-on:vdropzone-queue-complete="queueComplete"
                :options="dropzoneOptions"
                v-on:vdropzone-removed-file="whenuserremoveimage"
                id="customdropzone"
            >
                <div
                    class="dropzone-custom-content yk-mt-lg mb-2"
                    style="text-align: center"
                >
                    <i
                        class="fa fa-plus-circle"
                        aria-hidden="true"
                        style="font-size: 52px; vertical-align: middle"
                    ></i>
                </div>
            </vue-dropzone>
        </div>
    </div>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import axios from "axios";
import $ from "jquery";
import ykresizer from "./forimageresize/ykresizer";
import { allvalidate } from "./services/validateitemcreate";

export default {
    props: ["editdata", "collection", "link", "catlist", "main_cat"],

    name: "YkDropzoneForEdit",

    data: function () {
        return {
            discount: { show: "no", newprice: "0", newmin: "0", newmax: "0" },
            unsetdiscount: false,
            mid_photos: [],
            thumb_photos: [],
            submittedLoading: 0,
            dzerror: [],
            imgurl: "",

            removeimgqueue: [],

            tempphotonames: [],
            hostname: "",
            gold_colour_error: "",

            //forerror
            defaultphotoname: "",
            responseafterdelete: "",
            photoerror: 0,

            existingFiles: [],
            hidetoggle: false,
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            dropzoneOptions: {
                url: this.link,
                acceptedFiles: "image/*",
                maxFiles: 10,
                method: "POST",
                autoDiscover: false,
                previewTemplate: this.template(),
                renameFile: function (file) {
                    function getRandomNumber(min, max) {
                        // Generate a random number between min (inclusive) and max (inclusive)
                        return Math.floor(Math.random() * 1000);
                    }

                    let newname =
                        Date.now() +
                        "_" +
                        getRandomNumber(1, 100) +
                        file.type.replace("image/", ".");
                    return newname;
                },
                timeout: 300000,

                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxThumbnailFilesize: 111,

                maxFilesize: 20971520, //20mb
                headers: {
                    "My-Awesome-Header": "header value",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            },
        };
    },
    beforeMount() {
        if (process.env.MIX_USE_DO == "true") {
            this.imgurl = process.env.MIX_DO_URL;
        } else {
            this.imgurl = this.$hostname + "/images";
        }
    },

    mounted() {
        this.setdefaultphoto(this.editdata.default_photo);
    },
    components: {
        vueDropzone: vue2Dropzone,
    },
    methods: {
        // // sopend
        validatedz_css() {
            if (this.dzerror.length > 0) {
                return true;
            }
        },
        //id is index change in core vue multiselect in node_module (!important)
        removeHandler(removedOption, id) {
            // this.gems.splice(id, 1);
        },

        setdefaultphoto: function (id) {
            //hide set default icon in all dz profile pic
            var myElements = document.getElementsByClassName("dz-profile-pic");
            for (var i = 0; i < myElements.length; i++) {
                myElements[i].style.display = "none";
            }
            this.defaultphotoname = id;

            document.getElementById(id).style.display = "inline";
        },

        template: function () {
            return `<div class="dz-preview dz-file-preview">
              <div class="dz-image" style="width:145px !important;height:145px !important;margin:0px !important;">
                  <div data-dz-thumbnail-bg></div>
              </div>
              <div class="dz-details">
                  <div class="dz-size"><span data-dz-size></span></div>
                  <div class="dz-filename"><span data-dz-name></span></div>
              </div>
             <a class="dz-profile-pic yk-opa" yk-dz-default-pic style="display:none;"><span class="fas fa-check-circle"></span></a>

              <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
              <div class="dz-remove yk-opa" href="javascript:undefined;" data-dz-remove><span class="fas fa-times-circle"></span></div>
              <div class="dz-error-message"><span data-dz-errormessage></span></div>
<!--                // <div class="dz-success-mark"><i class="fa fa-check"></i></div>-->
<!--                <div class="dz-error-mark"><i class="fa fa-close"></i></div>-->
          </div>
      `;
        },

        //this function call while image thumbnail is created
        thumbnail: function (file, dataUrl) {
            if (typeof file.upload != "undefined") {
                //resize image
                ykresizer(file, 300, 300).then((res) => {
                    this.mid_photos.push({
                        name: file.upload.filename,
                        data: res,
                        type: file.type,
                    });
                });
                ykresizer(file, 100, 100).then((res) => {
                    this.thumb_photos.push({
                        name: file.upload.filename,
                        data: res,
                        type: file.type,
                    });
                });
                //resize image
            }

            var self = this;
            var j, len, ref, thumbnailElement, refp;
            if (file.previewElement) {
                file.previewElement.classList.remove("dz-file-preview");
                ref = file.previewElement.querySelectorAll(
                    "[data-dz-thumbnail-bg]"
                );
                refp = file.previewElement.querySelectorAll(
                    "[yk-dz-default-pic]"
                );
                for (j = 0, len = ref.length; j < len; j++) {
                    thumbnailElement = ref[j];
                    // this is for server photo
                    //note here why i use file.name and file.upload.filename because when i manullay added file from server to dz i cannot set file.upload filename  so that i use this
                    if (typeof file.upload == "undefined") {
                        thumbnailElement.alt = file.name;
                    } else {
                        thumbnailElement.alt = file.upload.filename;
                    }

                    // this is for server photo

                    thumbnailElement.style.backgroundImage =
                        'url("' + dataUrl + '")';

                    if (typeof file.upload == "undefined") {
                        refp[j].id = file.name;
                    } else {
                        refp[j].id = file.upload.filename;
                    }

                    //for dz upload icon
                    $(".dz-preview").removeClass("last");

                    for (var cf = 0; cf < this.existingFiles.length; cf++) {
                        //in here i used jquery because cannot effect v-on click in dropzome template and thumbnail
                        $(document).ready(function () {
                            $(".dz-preview").click(function (e) {
                                //this is only click one class not all dz-preview classess
                                e.stopPropagation();
                                e.stopImmediatePropagation();
                                self.setdefaultphoto(e.target.alt);
                            });
                        });
                    }
                    $(".dz-preview:last").addClass("last");

                    $(".dz-message").insertAfter(".last");

                    $(".dz-message").removeClass("yk-width-full");
                    //here is console error
                    // if (this.tempphotonames.length == 0) {
                    //     this.setdefaultphoto(file.upload.filename);
                    // }
                    // this.tempphotonames.push(file.upload.filename);

                    //for dz upload icon
                }

                return setTimeout(
                    (function (_this) {
                        return function () {
                            return file.previewElement.classList.add(
                                "dz-image-preview"
                            );
                        };
                    })(this),
                    1
                );
            }
        },

        callaftermount: function () {
            $(".dz-message").addClass("yk-width-full");
            console.log("call" + this.imgurl);

            var url = [];
            if (this.editdata.photo_one != "") {
                this.tempphotonames.push(this.editdata.photo_one);

                this.existingFiles.push({
                    name: this.editdata.photo_one,
                    size: 423,
                    type: "image/jpg",
                });
                url.push(this.imgurl + "/items/" + this.editdata.photo_one);
            }
            if (this.editdata.photo_two != "") {
                this.tempphotonames.push(this.editdata.photo_two);

                this.existingFiles.push({
                    name: this.editdata.photo_two,
                    size: 323,
                    type: "image/jpg",
                });
                url.push(this.imgurl + "/items/" + this.editdata.photo_two);
            }
            if (this.editdata.photo_three != "") {
                this.tempphotonames.push(this.editdata.photo_three);

                this.existingFiles.push({
                    name: this.editdata.photo_three,
                    size: 223,
                    type: "image/jpg",
                });
                url.push(this.imgurl + "/items/" + this.editdata.photo_three);
            }
            if (this.editdata.photo_four != "") {
                this.tempphotonames.push(this.editdata.photo_four);

                this.existingFiles.push({
                    name: this.editdata.photo_four,
                    size: 223,
                    type: "image/jpg",
                });
                url.push(this.imgurl + "/items/" + this.editdata.photo_four);
            }
            if (this.editdata.photo_five != "") {
                this.tempphotonames.push(this.editdata.photo_five);

                this.existingFiles.push({
                    name: this.editdata.photo_five,
                    size: 223,
                    type: "image/jpg",
                });
                url.push(this.imgurl + "/items/" + this.editdata.photo_five);
            }
            if (this.editdata.photo_six != "") {
                this.tempphotonames.push(this.editdata.photo_six);

                this.existingFiles.push({
                    name: this.editdata.photo_six,
                    size: 223,
                    type: "image/jpg",
                });
                url.push(this.imgurl + "/items/" + this.editdata.photo_six);
            }
            if (this.editdata.photo_seven != "") {
                this.tempphotonames.push(this.editdata.photo_seven);

                this.existingFiles.push({
                    name: this.editdata.photo_seven,
                    size: 223,
                    type: "image/jpg",
                });
                url.push(this.imgurl + "/items/" + this.editdata.photo_seven);
            }
            if (this.editdata.photo_eight != "") {
                this.tempphotonames.push(this.editdata.photo_eight);

                this.existingFiles.push({
                    name: this.editdata.photo_eight,
                    size: 223,
                    type: "image/jpg",
                });
                url.push(this.imgurl + "/items/" + this.editdata.photo_eight);
            }
            if (this.editdata.photo_nine != "") {
                this.tempphotonames.push(this.editdata.photo_nine);

                this.existingFiles.push({
                    name: this.editdata.photo_nine,
                    size: 223,
                    type: "image/jpg",
                });
                url.push(this.imgurl + "/items/" + this.editdata.photo_nine);
            }
            if (this.editdata.photo_ten != "") {
                this.tempphotonames.push(this.editdata.photo_ten);

                this.existingFiles.push({
                    name: this.editdata.photo_ten,
                    size: 223,
                    type: "image/jpg",
                });
                url.push(this.imgurl + "/items/" + this.editdata.photo_ten);
            }
            for (var i = 0; i < this.existingFiles.length; i++) {
                this.$refs.myVueDropzone.manuallyAddFile(
                    this.existingFiles[i],
                    url[i]
                );
            }
        },
        //when user added multiple file
        multiplefilesadded(files) {
            for (var key in files) {
                if (files.hasOwnProperty(key)) {
                    this.tempphotonames.push(files[key].upload.filename);
                }
            }
            console.log(files);
        },

        checkhasdefaultimage: function () {
            for (
                var s = 0;
                s < document.getElementsByClassName("dz-profile-pic").length;
                s++
            ) {
                if (
                    document.getElementsByClassName("dz-profile-pic")[s].style
                        .display == "inline"
                ) {
                    return true;
                    break;
                }
            }
        },

        //when user click remove button call this function
        whenuserremoveimage: function (file, error, xhr, data = "") {
            var filename = "test";
            if (typeof file.upload != "undefined") {
                filename = file.upload.filename;
            } else {
                filename = file.name;
            }

            if (typeof file.upload !== "undefined") {
                //remove thumbs photo and mid photo
                const tkey = this.thumb_photos.findIndex(
                    (tp) => tp.name === filename
                );
                this.thumb_photos.splice(tkey, 1);
                //mid
                const mkey = this.mid_photos.findIndex(
                    (mp) => mp.name === filename
                );
                this.mid_photos.splice(mkey, 1);
                //remove thumbs photo and mid photo
                //for default message
            }
            var get_photo_key = Object.keys(this.editdata).find(
                (key) => this.editdata[key] === file.name
            );
            this.removeimgqueue.push({
                column_name: get_photo_key,
                name: this.editdata[get_photo_key],
            });

            //if tempphotoname has delete image name
            var get_file_key = 0;
            get_file_key = this.tempphotonames.findIndex(
                (re) => re === filename
            );
            this.tempphotonames.splice(get_file_key, 1);
            console.log(this.tempphotonames);
            //check other photo has set default icon
            if (this.checkhasdefaultimage()) {
                //only delete from deleted photo name from temphotoname array
                console.log("has");
            } else {
                //if dz-profile-pic class length not equal to 1
                if (this.tempphotonames.length != 1) {
                    console.log("aa");
                    //when user delete top photo
                    if (get_file_key == 0) {
                        console.log("bb");

                        this.setdefaultphoto(this.tempphotonames[0]);
                    } else {
                        //remove deleted image name from tempphotonames array

                        //show default icon on image before deleted image
                        this.setdefaultphoto(
                            this.tempphotonames[get_file_key - 1]
                        );
                    }

                    //if images has grater than one
                } else {
                    console.log("xx");
                    //if one only image is remain just set default photo for it
                    this.setdefaultphoto(this.tempphotonames[0]);

                    console.log("sec");
                }
            }
            //to get image before deleted image
        },
        removeimagefromserver: function () {
            if (this.removeimgqueue.length > 0) {
                this.removeimgqueue.map((rimg) => {
                    if (typeof rimg.name != undefined) {
                        axios
                            .post(
                                this.$hostname +
                                    "/backside/shop_owner/removeimage",
                                {
                                    column_name: rimg.column_name,
                                    id: this.editdata.id,
                                    name: rimg.name,
                                },
                                {
                                    headers: {
                                        "My-Awesome-Header": "header value",
                                        "X-CSRF-TOKEN": document
                                            .querySelector(
                                                'meta[name="csrf-token"]'
                                            )
                                            .getAttribute("content"),
                                    },
                                }
                            )
                            .then((response) => {
                                console.log("removed from server");
                            });
                    }
                });
            }
        },

        // check added photo
        addedphoto: function (file) {
            console.log(file);
        },

        //if user added file excceed than 10
        maxfilesEvent: function (file) {
            this.$refs.myVueDropzone.removeFile(file);
            this.showerrorwithmodel("Your Can upload maximum 10 photos");
        },

        queueComplete: function () {},

        // when click submit button

        submitform: function (event) {
            var self = this;
            event.preventDefault();
            event.stopPropagation();

            //async function
            async function serverprocess() {
                await self.removeimagefromserver();
                await self.$refs.myVueDropzone.processQueue();
            }

            //async function
            //async function
            async function serverprocesscustom() {
                await self.removeimagefromserver();
                await self.customupload();
            }

            allvalidate.dzediterror(this);
            console.log(this.dzerror);
            if (this.dzerror.length == 0) {
                if (this.$refs.myVueDropzone.getAcceptedFiles() != 0) {
                    this.$parent.submittedLoading = 1;
                    serverprocess();
                } else {
                    console.log(this.$refs.myVueDropzone.getAcceptedFiles());
                    console.log("fefe");
                    this.$parent.submittedLoading = 1;

                    serverprocesscustom();
                }
            }

            //processqueue is call sendevent and real sent to server
        },

        //this is for custom upload to server while no image is added to dz
        customupload: function () {
            var bodyFormData = new FormData();
            bodyFormData.append("gems", JSON.stringify(this.$parent.gems));
            bodyFormData.append(
                "weight",
                JSON.stringify(this.$parent.$refs.aa.weight_child)
            );

            bodyFormData.append("name", this.$parent.name);
            bodyFormData.append("main_category", this.$parent.main_category);
            bodyFormData.append("gender", this.$parent.gender);
            bodyFormData.append("handmade", this.$parent.handmade);
            bodyFormData.append("charge", this.$parent.charge);
            bodyFormData.append("id", this.$parent.editdata.id);
            bodyFormData.append(
                "_token",
                document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content")
            );

            bodyFormData.append("stock", this.$parent.stock);
            bodyFormData.append("stock_count", this.$parent.stock_count);
            bodyFormData.append("description", this.$parent.description);

            bodyFormData.append(
                "undamaged_product",
                this.$parent.undamaged_product
            );
            bodyFormData.append(
                "damaged_product",
                this.$parent.damaged_product
            );
            bodyFormData.append(
                "valuable_product",
                this.$parent.valuable_product
            );
            bodyFormData.append("gold_quality", this.$parent.gold_quality);
            bodyFormData.append("gold_colour", this.$parent.gold_colour);
            bodyFormData.append("collection_id", this.$parent.collection_id);

            bodyFormData.append("category_id", this.$parent.category_id);
            bodyFormData.append("product_code", this.$parent.product_code);

            // for price
            bodyFormData.append("price", this.$parent.price);
            bodyFormData.append("min_price", this.$parent.min_price);
            bodyFormData.append("max_price", this.$parent.max_price);
            // for price

            bodyFormData.append("diamond", this.$parent.diamond);
            bodyFormData.append("carat", this.$parent.carat);
            bodyFormData.append("pwint", this.$parent.pwint);
            bodyFormData.append("yati", this.$parent.yati);
            bodyFormData.append("d_gram", this.$parent.d_gram);
            bodyFormData.append("tags", this.$parent.tags);

            bodyFormData.append("default_photo", this.defaultphotoname);
            bodyFormData.append(
                "discount",
                JSON.stringify(this.$parent.discount)
            );
            bodyFormData.append("unsetdiscount", this.$parent.unsetdiscount);

            //or

            axios
                .post(
                    this.$hostname + "/backside/shop_owner/customedit",
                    bodyFormData,
                    {
                        header: {
                            "Content-Type": "multipart/form-data",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                    }
                )
                .then((response) => {
                    console.log(response);
                    if (response.data.msg == "success") {
                        window.location.assign(
                            this.$hostname +
                                "/backside/shop_owner/items/" +
                                response.data.id
                        );
                    } else {
                        alert(response.data.error_msg);
                    }
                });
        },
        // sendevent is prepare to send before real send

        sendingEvent(files, xhr, formData) {
            //why not use v-model because vue conflit with select2 js
            formData.append("_token", this.csrf);
            formData.append("gems", JSON.stringify(this.$parent.gems));

            formData.append("discount", JSON.stringify(this.$parent.discount));
            formData.append("unsetdiscount", this.$parent.unsetdiscount);

            formData.append("name", this.$parent.name);
            formData.append("gender", this.$parent.gender);
            formData.append("handmade", this.$parent.handmade);
            formData.append("charge", this.$parent.charge);

            formData.append("id", this.$parent.editdata.id);
            formData.append("product_code", this.$parent.product_code);

            formData.append("stock", this.$parent.stock);
            formData.append("stock_count", this.$parent.stock_count);
            formData.append("description", this.$parent.description);
            formData.append("tags", this.$parent.tags);

            formData.append(
                "undamaged_product",
                this.$parent.undamaged_product
            );
            formData.append("damaged_product", this.$parent.damaged_product);
            formData.append("valuable_product", this.$parent.valuable_product);
            formData.append("gold_quality", this.$parent.gold_quality);
            formData.append("gold_colour", this.$parent.gold_colour);
            formData.append("collection_id", this.$parent.collection_id);

            formData.append("category_id", this.$parent.category_id);

            //for price
            formData.append("price", this.$parent.price);
            formData.append("min_price", this.$parent.min_price);
            formData.append("max_price", this.$parent.max_price);
            //for price
            //for diamond
            formData.append("diamond", this.$parent.diamond);
            formData.append("carat", this.$parent.carat);
            formData.append("pwint", this.$parent.pwint);
            formData.append("yati", this.$parent.yati);
            formData.append("d_gram", this.$parent.d_gram);
            //for diamond
            //for weight
            formData.append(
                "weight",
                JSON.stringify(this.$parent.$refs.aa.weight_child)
            );
            //for weight

            formData.append("default_photo", this.defaultphotoname);
            formData.append("formidphotos", JSON.stringify(this.mid_photos));
            formData.append(
                "forthumbphotos",
                JSON.stringify(this.thumb_photos)
            );
        },

        // after send
        successEvent(files, response) {
            if (response.msg == "success") {
                window.location.assign(
                    this.$hostname + "/backside/shop_owner/items/" + response.id
                );
            }
        },

        //if some errors appear while uploading to server
        errorEvent(file, message, xhr) {
            this.$refs.myVueDropzone.removeFile(file);
            $(".dz-error").remove();

            this.showerrorwithmodel(message);
        },
    },
};
</script>
