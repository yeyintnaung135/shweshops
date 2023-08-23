<template>
    <div class="col-md-12 pt-3">
        <div>
            <label
                style="font-size: 15px"
                v-bind:class="{
                    'sn-required-asterick': validatedz_css(),
                }"
                >အနည်းဆုံး ပုံ တစ်ပုံတင်ပါ</label
            >
        </div>

        <vue-dropzone
            :include-styling="false"
            :useCustomSlot="true"
            ref="myVueDropzone"
            v-on:vdropzone-sending-multiple="sendingEvent"
            v-on:vdropzone-error-multiple="errorEvent"
            v-on:vdropzone-removed-file="removefilefromdz"
            v-on:vdropzone-files-added="multiplefilesadded"
            v-on:vdropzone-success-multiple="successEvent"
            v-on:vdropzone-max-files-exceeded="maxfilesEvent"
            v-on:vdropzone-mounted="callaftermounted"
            v-on:vdropzone-thumbnail="thumbnail"
            :options="dropzoneOptions"
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
</template>
<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import ykresizer from "./forimageresize/ykresizer";
import { allvalidate } from "./services/validateitemcreate";

import $ from "jquery";

export default {
    // register globally
    props: [
        "link",
        "somedatafromshop",
        "collection",
        "worldgoldprice",
        "catlist",
        "percenttemplate",
        "main_cat",
    ],
    mounted() {},
    name: "YkDropzone",
    data: function () {
        return {
            mid_photos: [],
            thumb_photos: [],
            gold_colour: "",
            gold_quality: "",

            //for default icon
            displaynone: false,
            //for default icon

            dzerror: [],
            tempphotonames: [],
            defaultphotoname: "",

            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            dropzoneOptions: {
                url: this.link,
                maxFiles: 10,
                acceptedFiles: "image/*",

                previewTemplate: this.template(),
                method: "POST",
                renameFilename: function (file) {
                    let newname = Date.now() + "_" + file;
                    return newname;
                },

                autoDiscover: false,
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                timeout: 3000000000,
                maxThumbnailFilesize: 111,
                maxFilesize: 2097152000000, //20mb

                headers: {
                    "My-Awesome-Header": "header value",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            },
        };
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

        forrequirephoto: function (data, model) {
            if (data == true && model < 3) {
                return true;
            }
        },
        // when click submit button
        submitform: async function (event) {
            console.log("submit form ===");
            event.preventDefault();
            event.stopPropagation();
            allvalidate.dzcreateerror(this);
            if (this.dzerror.length > 0) {
                console.log(this.dzerror[0].photo.msg);
            } else {
                this.$parent.submittedLoading = 1;
                this.$refs.myVueDropzone.processQueue();
            }
        },
        callaftermounted() {
            $(".dz-message").addClass("yk-width-full");
        },

        //for check setdefault is appear in other image not in delete image
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

        removefilefromdz: function (file, error, xhr) {
            //remove thumbs photo and mid photo

            const tkey = this.thumb_photos.findIndex(
                (tp) => tp.name === file.upload.filename
            );
            this.thumb_photos.splice(tkey, 1);
            //mid
            const mkey = this.mid_photos.findIndex(
                (mp) => mp.name === file.upload.filename
            );
            this.mid_photos.splice(mkey, 1);
            //remove thumbs photo and mid photo
            console.log(this.thumb_photos);

            //for default message

            if (
                this.$refs.myVueDropzone.getAcceptedFiles().length < 3 &&
                $(".dz-message").hasClass("d-none")
            ) {
                $(".dz-message").removeClass("d-none");
            }
            //for default message

            //if tempphotoname has delete image name
            var get_file_key = 0;

            get_file_key = this.tempphotonames.findIndex(
                (re) => re === file.upload.filename
            );
            //check other photo has set default icon
            if (this.checkhasdefaultimage()) {
                //only delete from deleted photo name from temphotoname array
            } else {
                //if dz-profile-pic class length not equal to 1
                if (
                    document.getElementsByClassName("dz-profile-pic").length !=
                    1
                ) {
                    if (
                        document.getElementsByClassName("dz-profile-pic")
                            .length == 0
                    ) {
                        //if dz-profile-pic class is empty
                        //set empty array to tempphotonames

                        this.tempphotonames = [];
                    } else {
                        //when user delete top photo
                        if (get_file_key == 0) {
                            this.setdefaultphoto(this.tempphotonames[1]);
                        } else {
                            //remove deleted image name from tempphotonames array

                            //show default icon on image before deleted image
                            if (get_file_key !== 0) {
                                this.setdefaultphoto(
                                    this.tempphotonames[get_file_key - 1]
                                );
                            } else {
                                this.setdefaultphoto(
                                    this.tempphotonames[get_file_key + 1]
                                );
                            }
                        }

                        //if images has grater than one
                    }
                } else {
                    //if one only image is remain just set default photo for it
                    this.setdefaultphoto(
                        document.getElementsByClassName("dz-profile-pic")[0].id
                    );

                    console.log("sec");
                }
            }
            this.tempphotonames.splice(get_file_key, 1);

            //to get image before deleted image
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

        thumbnail: function (file, dataUrl) {
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
                    thumbnailElement.alt = file.upload.filename;
                    thumbnailElement.style.backgroundImage =
                        'url("' + dataUrl + '")';
                    refp[j].id = file.upload.filename;
                    if (
                        this.$refs.myVueDropzone.getAcceptedFiles().length === 1
                    ) {
                        //when user start add one photo auto add setdefault icon

                        if (this.checkhasdefaultimage()) {
                        } else {
                            this.setdefaultphoto(file.upload.filename);
                        }
                    } else {
                        if (this.checkhasdefaultimage()) {
                        } else {
                            //when user start add multiple photo auto add setdefault icon
                            this.setdefaultphoto(
                                this.$refs.myVueDropzone.getAcceptedFiles()[0]
                                    .upload.filename
                            );
                        }
                    }

                    //for dz upload icon
                    $(".dz-preview").removeClass("last");
                    for (
                        var cf = 0;
                        cf < this.$refs.myVueDropzone.getAcceptedFiles().length;
                        cf++
                    ) {
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

            if (this.tempphotonames.length == 0) {
                this.setdefaultphoto(file.upload.filename);
            }
            this.tempphotonames.push(file.upload.filename);
            this.requireerroryk.photo = false;
        },

        //when user added multiple file
        multiplefilesadded(files) {
            this.photoerror += files.length;
            //this is for default message

            //this is only click one class not all dz-preview classess

            for (var f = 0; f < files.length; f++) {
                this.tempphotonames.push(files[f].upload.filename);
            }
            console.log("add multi");
        },

        //custom setdefault photo function

        setdefaultphoto: function (id) {
            //hide set default icon in all dz profile pic
            var myElements = document.getElementsByClassName("dz-profile-pic");
            for (var i = 0; i < myElements.length; i++) {
                myElements[i].style.display = "none";
            }
            this.defaultphotoname = id;

            document.getElementById(id).style.display = "inline";
            console.log("f");
        },

        //if user added file excceed than 10
        maxfilesEvent: function (file) {
            this.$refs.myVueDropzone.removeFile(file);
            this.requireerroryk.push({
                errormsg: "Your Can upload maximum 10 photos",
            });

            this.showerrorwithmodel("Your Can upload maximum 10 photos");
        },

        // sendevent is prepare to send before real send

        sendingEvent(files, xhr, formData) {
            //why not use v-model because vue conflit with select2 js
            formData.append("_token", this.csrf);
            formData.append("gems", JSON.stringify(this.$parent.gems));
            formData.append("formidphotos", JSON.stringify(this.mid_photos));
            formData.append(
                "forthumbphotos",
                JSON.stringify(this.thumb_photos)
            );

            formData.append("name", this.$parent.name);

            formData.append("main_category", this.$parent.main_category);
            formData.append("gender", this.$parent.gender);
            formData.append("handmade", this.$parent.handmade);
            formData.append("charge", this.$parent.charge);

            formData.append("description", this.$parent.description);
            formData.append(
                "undamaged_product",
                this.$parent.undamaged_product
            );
            formData.append("damaged_product", this.$parent.damaged_product);
            formData.append("valuable_product", this.$parent.valuable_product);
            formData.append("gold_quality", this.gold_quality);
            formData.append("gold_colour", this.gold_colour);
            formData.append("sizing_guide", this.$parent.sizing_guide);
            formData.append("stock", this.$parent.stock);
            formData.append("review", this.$parent.review);
            formData.append("category_id", this.$parent.category_id);
            formData.append("product_code", this.$parent.product_code);
            formData.append("collection_id", this.$parent.collection_id);
            formData.append("stock_count", this.$parent.stock_count);
            formData.append("diamond", this.$parent.diamond);
            formData.append("carat", this.$parent.carat);
            formData.append("pwint", this.$parent.pwint);
            formData.append("yati", this.$parent.yati);
            formData.append("d_gram", this.$parent.d_gram);
            formData.append("tags", this.$parent.tags);

            formData.append(
                "weight",
                JSON.stringify(this.$parent.$refs.aa.weight_child)
            );

            formData.append("price", this.$parent.price);
            formData.append("min_price", this.$parent.min_price);
            formData.append("max_price", this.$parent.max_price);
            formData.append("default_photo", this.defaultphotoname);
        },

        // after send
        successEvent(files, response) {
            this.$parent.submittedLoading = 0;

            console.log(response);

            if (response.msg == "success") {
                window.location.assign(
                    this.$hostname + "/backside/shop_owner/items/" + response.id
                );
            } else {
                console.log(response);
                alert(response);
                //   if (window.confirm("Do u want to continue?")) {
                //       location.assign(window.location.href);
                //   } else {
                //       location.assign(window.location.href);
                //   }
            }
        },

        //if some errors appear while uploading to server
        errorEvent(file, message, xhr) {
            console.log("dz error =====");
            this.$refs.myVueDropzone.removeFile(file);
            $(".dz-error").remove();

            this.showerrorwithmodel(message);
        },
    },
    computed: {},
};
</script>
