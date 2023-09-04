<!-- forgotpassword Code  -->
<div class="modal-header header5" style="margin-top: -12px;">
    <div class="d-block w-100">
        <div class="d-flex justify-content-center w-100" id="shweShops">
            <img class="item pe-3 " src="{{ url('test/img/logo-m.png') }}"
                style="height: 40px;padding-bottom:5px" />
            <p class="sop-lr-h">Shwe Shops</p>
        </div>
        <h4 class="modal-title text-center white-text w-100 font-weight-bold py-2"
            style="font-weight: bold;font-size: 20px;">
            Reset Your Password
        </h4>
    </div>
</div>

<div class="forgotpassword">
    <div class="p-3">
        <form v-if="showchodecheckform===false && shownewpasswordform===false ">
            <!--Body-->
            <div class="modal-body">
                <div class="md-form mb-5">

                    <label data-error="wrong" data-success="right" for="form3"><i
                            class="fas fa-phone prefix grey-text"
                            style="
                        margin-right: 10px;
                        color: #780116!important;
                        "></i>Phone</label>
                    <input type="text" id="form13"
                        class="form-control @error('phone') is-invalid @enderror validate" name="value"
                        placeholder="" v-model="phone" required autocomplete="phone" autofocus
                        style="
                        border-top: none;
                        border-left: none;
                        border-right: none;
                        border-color: black;
                        background-color: #F3F4F9;
                        ">


                    <span v-if="fperrors !== 0" class="" style="color:red;" role="alert">
                        <strong>@{{ fperrors.emailorphone[0] }}</strong>
                    </span>
                </div>

            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <a type="button" href="javascript:void(0);" class="shopLogin" aria-pressed="true"
                    style="
                color: #0d6efd !important;
                text-decoration: underline !important;
                ">
                    {{ __('back') }}</a>

                <input type="button" class="btn yk-btn-success w-100" value="Submit"
                    v-on:click="sendphonetoserver"
                    style="
                background-color: #780116!important;
                color: white;
                width: 100% !important;
                border-radius: 10px;
                height: 44px;
                " />

                <br>
                <br>

            </div>
        </form>

        <div v-if="showchodecheckform">
            <!--Body-->
            <div class="modal-body">
                <div class="md-form mb-5">

                    <label for="form113"><i class="fas fa-phone prefix grey-text"
                            style="margin-right: 10px;
                        color: #780116!important;
                        "></i>Successfully
                        Send Reset Code</label>
                    <input type="text" class="form-control" placeholder="Put Your Code Here"
                        v-model="code" required autocomplete="" autofocus
                        style="
                        border-top: none;
                        border-left: none;
                        border-right: none;
                        border-color: black;
                        background-color: #F3F4F9;
                        ">


                    <span v-if="fperrorscode !== 0" class="" style="color:red;" role="alert">
                        <strong>@{{ fperrorscode }}</strong>
                    </span>
                </div>

            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <input type="button" class="btn yk-btn-success w-100" value="Submit"
                    v-on:click="sendcodetoserver"
                    style="
                    background-color: #780116!important;
                    color: white;
                    width: 100% !important;
                    border-radius: 10px;
                    height: 44px;
                    " />

                <br>
                <br>
            </div>
        </div>
        <div v-if="shownewpasswordform">
            <!--Body-->
            <div class="modal-body">
                <div class="md-form mb-5">

                    <label for="form1113"><i class="fas fa-phone prefix grey-text"
                            style="margin-right: 10px;
                                color: #780116!important;
                                "></i>Add
                        New Pin</label>
                    <input type="number" class="form-control" placeholder="New Password"
                        v-model="password" required autocomplete="" autofocus
                        style="
                                border-top: none;
                                border-left: none;
                                border-right: none;
                                border-color: black;
                                background-color: #F3F4F9;
                                ">

                    <input type="number" class="form-control" placeholder="Confirm Your Password"
                        v-model="password_confirmation" required autocomplete="" autofocus
                        style="
                                border-top: none;
                                border-left: none;
                                border-right: none;
                                border-color: black;
                                background-color: #F3F4F9;
                                ">


                    <span v-if="fperrorspassword !== 0" class="" style="color:red;"
                        role="alert">
                        <strong>@{{ fperrorspassword.password[0] }}</strong>
                    </span>
                </div>

            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">


                <input type="button" class="btn yk-btn-success w-100" value="Submit"
                    v-on:click="sendnewpasswordtoserver"
                    style="
                    background-color: #780116!important;
                    color: white;
                    width: 100% !important;
                    border-radius: 10px;
                    height: 44px;
                    " />

                <br>
                <br>

            </div>

        </div>
    </div>
</div>