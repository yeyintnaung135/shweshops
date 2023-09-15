
            <!-- Verification Code  -->
            <div class="modal-header header4" style="margin-top: -12px;">
                <div class="d-block w-100">
                    <div class="d-flex justify-content-center w-100" id="shweShops">
                        <img class="item pe-3 " src="{{ url('test/img/logo-m.png') }}"
                            style="height: 40px;padding-bottom:5px" />
                        <p class="sop-lr-h">Shwe Shops</p>
                    </div>

                    <h4 class="modal-title text-center white-text w-100 font-weight-bold py-2"
                        style="font-weight: bold;font-size: 20px;">
                        Verification Code
                    </h4>
                </div>

            </div>

            <div class="modal-body" id="codecheckforreg">
                <div class="p-3">
                    <div class="md-form mb-5">
                        <div class="text-center">We have to sent the code verification to <br> Your Phone Number</div>
                        <h1 id="time" class="text-center mb-3">0</h1>
                        <input id='phoneforresendcode' name='phoneforresendcode' value='' type='hidden'>
                        <input id="loginbeforebuynow" name="frombuynow" type="hidden" value="">
                        <input type="text" id="regotpcode" name="code" class="form-control "
                            placeholder="Put Your Code Here" required autocomplete="" autofocus
                            style="
                                border-top: none;
                                text-align: center;
                                border-left: none;
                                border-right: none;
                                border-color: black;
                                background-color: #F3F4F9;
                                ">


                        <span id="regerrorcode"></span>
                    </div>
                    <div class="d-flex justify-content-center w-100 ">
                        <button type="submit" id='resendCode'
                            class="btn btn-outline-dark btn-sm sop-resend-otp mr-5 disabled">Resend Code</button>
                        <button type="submit" id='checkcodereg'
                            class="btn sop-submit-otp yk-btn-success tz-btn text-light">Submit</button>
                    </div>
                </div>
            </div>
            <!-- Verification Code end  -->