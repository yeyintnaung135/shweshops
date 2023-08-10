@extends('layouts.backend.backend')

@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.backend.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sn-background-white">

            <!-- zhheader shopname -->
            <x-header>
                @foreach ($shopowner as $shopowner)
                @endforeach
                {{-- <div class="sn-shop-header d-sm-none">{{$shopowner->shop_name}}  </div>  --}}
            </x-header>
            <!-- end zh header shopname -->

            <!-- Content Header (Page header) -->
            {{-- <x-title>

            @isset(Auth::guard('shop_role')->user()->id)
                  @if (Auth::guard('shop_role')->user()->role_id === 1)
                  Create Managers And Staffs
                  @elseif(Auth::guard('shop_role')->user()->role_id === 2)
                  Create Staffs
                  @endif
                 @endisset

            @isset(Auth::guard('shop_owner')->user()->id)
            Create Admin,Managers And Staffs
            @endisset
            </x-title> --}}
            <!-- Main content -->

            <section class="content">
                <form method="post" action="{{ url('backside/shop_owner/users/create') }}" enctype="multipart/form-data">
                    <div class="">
                        <!-- SELECT2 EXAMPLE -->
                        <div class="">

                            <div class="container-fluid">
                                <div class="sn-item-create-wrapper">
                                    <div class="">
                                        <h3 class="">Create A New User </h3>
                                        <p class="create-user-text">ဆိုင်အတွက် လိုအပ်သည့် User Roleကို ပြုလုပ်နိုင်ပါသည်</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <fieldset>
                                                    <legend>User Name </legend>
                                                    <input type="text"
                                                        class="form-control sop-form-control @error('name') is-invalid @enderror"
                                                        name="name" placeholder="Enter name" autocomplete="off"
                                                        required />
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </fieldset>
                                            </div>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <fieldset>
                                                    <legend>Phone-no </legend>
                                                    <input type="text"
                                                        class="form-control sop-form-control @error('phone') is-invalid @enderror"
                                                        name="phone" placeholder="Enter Phone-no" autocomplete="off"
                                                        required />
                                                    @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </fieldset>
                                            </div>
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group ">

                                                <fieldset>
                                                    <legend>Password</legend>
                                                    <div class="position-relative">
                                                        <input type="password" pattern="[0-9]*" inputmode="numeric"
                                                            id="password"
                                                            class="pin form-control sop-form-control @error('password') is-invalid @enderror"
                                                            name="password" placeholder="Enter password" autocomplete="off"
                                                            required />
                                                        <span class="zh-eye-picon d-flex align-items-center">
                                                            <button id="eye_slash" type="button"
                                                                onclick="Peyeslash(this.id)"
                                                                style="
                                                 background-color: transparent;
                                                 ">
                                                                <i class="fi fi-rr-eye-crossed"></i>
                                                            </button>
                                                            <button id="eye" type="button" onclick="Peye(this.id)"
                                                                style=" background-color: transparent; display:none; ">
                                                                <i class="fi fi-rs-eye"></i>
                                                            </button>
                                                        </span>
                                                    </div>

                                                </fieldset>
                                                <div class="sn_generatepass_wrapper">
                                                    <button type="button"
                                                        class="sn_generate_password btn btn-secondary d-block float-right">Generate
                                                        Password</button>
                                                </div>
                                                <div class="col-12 sn-pin-noti">
                                                    <i class="fa fa-info-circle"></i>
                                                    <p>Pin Number ကို အနည်းဆုံးခြောက်လုံးထားပေးပါရန် <br />(eg . 0123456)
                                                    </p>
                                                </div>
                                            </div>

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <fieldset>
                                                    <legend>Role</legend>
                                                    <select class="selectpicker form-control sop-form-control select2"
                                                        name="role_id" style="width: 100%">

                                                        @foreach ($role as $role)
                                                            <option value="{{ $role->id }}" selected>
                                                                {{ $role->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />


                                        <div class="col-md-12 sn-form-button">
                                            <a href="{{ url()->previous() }}" style="margin-top: 25px;">Cancel</a>
                                            <button class="sn-item-create-button btn btn-primary float-right float-sm-none"
                                                type="submit" style="margin-top: 25px;">
                                                Create
                                            </button>
                                        </div>
                                        <!--                            <Ykweight v-on:forparent="getdatafromykweight"></Ykweight>-->


                                    </div>


                                    <br />

                                </div>
                                <!-- /.FORM END -->


                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </form>
            </section>


            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        {{-- @include('layouts.backend.footer') --}}

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
@endsection

@push('css')
    <style>
        .zh-eye-picon:hover button i {
            color: black;

        }

        .zh-eye-picon:focus button i {
            color: black;

        }

        .zh-eye-picon:hover button i {
            transform: scale(1)
        }

        .zh-eye-picon button i {
            display: flex;
            color: #808080;
            transform: scale(0.9);
        }

        .zh-eye-picon {
            z-index: 9999 !important;
            position: absolute !important;
            right: 0;
            top: 0;
            margin-top: -3px;
        }

        /* .zh-eye-picon{
                            height: 40px;

                        }
                    @media only screen and (max-width: 576px){
                        .zh-eye-picon{
                            height: 38px;
                        }
                    } */
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.sn_generate_password').click(function() {
                var chars = "0123456789";
                var passwordLength = 6;
                var generated_password = "";
                for (var i = 1; i <= passwordLength; i++) {
                    var randomNumber = Math.floor(Math.random() * chars.length);
                    generated_password += chars.substring(randomNumber, randomNumber + 1);
                }
                document.getElementById("password").type = 'text';


                var element = document.getElementById("password");
                document.getElementById("eye").style.display = "block";
                document.getElementById('eye_slash').style.display = "none";
                document.getElementById("password").value = generated_password;
            })
        })
        document.querySelectorAll(".pin").forEach(elem => {
            elem.addEventListener("keypress", function(evt) {
                if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
                    evt.preventDefault();
                }

            });
        });

        function Peyeslash(id) {
            eye = "eye"
            var element = document.getElementById("password");
            document.getElementById(eye).style.display = "block";
            document.getElementById(id).style.display = "none";
            element.type = "text";
        }

        function Peye(id) {

            eye_slash = "eye_slash"
            var element = document.getElementById("password");
            document.getElementById(eye_slash).style.display = "block";
            document.getElementById(id).style.display = "none";
            element.type = "password";
        }
    </script>
@endpush
