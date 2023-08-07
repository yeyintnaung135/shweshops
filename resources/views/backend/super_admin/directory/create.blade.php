@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Directory Create')

@section('content')
    <div class="wrapper">
        @include('backend.super_admin.navbar')
        @include('backend.super_admin.sidebar')
        <section class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title>Create Shop Directory</x-title>
            </section>
            <div class="container">
                <div class="row">

                    <div id="" class="col-12">

                        <form method="POST" enctype="multipart/form-data" id="createDirectoryForm"
                            action="{{ url('/backside/super_admin/directory/create') }}">
                            @csrf

                            <div class="se form-group row">
                                <div class="col-12 col-md-6">
                                    <label for="exampleInputEmail1">ဆိုင် အမည် english<span
                                            style="color: red;">*</span></label>


                                    <div class="input-group mb-3">

                                        <input id="shop_name" type="text"
                                            class="form-control @error('shop_name') is-invalid @enderror" name="shop_name"
                                            value="{{ old('shop_name') }}" placeholder="ဆိုင် အမည်" autocomplete="name"
                                            autofocus>
                                    </div>

                                    @error('shop_name')
                                        <x-error>
                                            {{ $message }}
                                        </x-error>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="shop_name_myan">ဆိုင် အမည် myanmar<span style="color: red;">*</span></label>


                                    <div class="input-group mb-3">

                                        <input id="shop_name_myan" type="text"
                                            class="form-control @error('shop_name_myan') is-invalid @enderror"
                                            name="shop_name_myan" value="{{ old('shop_name_myan') }}"
                                            placeholder="ဆိုင် အမည် (Myanmar)" autocomplete="name" autofocus>
                                    </div>

                                    @error('shop_name_myan')
                                        <x-error>
                                            {{ $message }}
                                        </x-error>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="exampleInputEmail1">Shop Url <span style="color: red;">*</span></label>


                                    <div class="input-group mb-3">

                                        <input id="shop_name_url" type="text"
                                            class="form-control @error('shop_name_url') is-invalid @enderror"
                                            name="shop_name_url" value="{{ old('shop_name_url') }}"
                                            placeholder="ဆိုင် အမည် (url)" autocomplete="name" autofocus>
                                    </div>

                                    @error('shop_name_url')
                                        <x-error>
                                            {{ $message }}
                                        </x-error>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">

                                    <!-- <label for="password" class="col-md-4 col-form-label text-md-right">Shop NAME</label> -->
                                    <label for="exampleInputEmail1">Main Phone<span style="color: red;"></span></label>


                                    <div class="input-group mb-3">

                                        <input id="main_phone" value="{{ old('main_phone') }}" min="0" type="text"
                                            type="text" class="form-control @error('main_phone') is-invalid @enderror"
                                            name="main_phone" placeholder="Main Phone" autocomplete="new-password">
                                    </div>

                                    @error('main_phone')
                                        <x-error>
                                            {{ $message }}
                                        </x-error>
                                    @enderror

                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="additional_phones">Other Phones<span style="color: red;"></span></label>
                                    <div class="input-group mb-3">
                                        <input type="text" class=" form-control-tags js-tagify" id="additional_phones"
                                            placeholder="Press Enter after each phones" name="additional_phones">
                                    </div>
                                </div>

                                {{-- </div>

                            <div class="se form-group row"> --}}
                                <div class="col-12 col-md-6">
                                    <label for="exampleInputEmail1">Facebook Link<span style="color: red;"></span></label>


                                    <div class="input-group mb-3">

                                        <input id="facebook_link" type="text"
                                            class="form-control @error('facebook_link') is-invalid @enderror"
                                            name="facebook_link" value="{{ old('facebook_link') }}" placeholder="Facebook"
                                            autocomplete="name" autofocus>
                                    </div>

                                    @error('facebook_link')
                                        <x-error>
                                            {{ $message }}
                                        </x-error>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">

                                    <!-- <label for="password" class="col-md-4 col-form-label text-md-right">Shop NAME</label> -->
                                    <label for="exampleInputEmail1">Website Link<span style="color: red;"></span></label>


                                    <div class="input-group mb-3">

                                        <input id="main_phone" value="{{ old('website_link') }}" min="0"
                                            type="text" type="text"
                                            class="form-control @error('website_link') is-invalid @enderror"
                                            name="website_link" placeholder="Website" autocomplete="new-password">
                                    </div>

                                    @error('website_link')
                                        <x-error>
                                            {{ $message }}
                                        </x-error>
                                    @enderror

                                </div>

                                {{-- </div>

                            <div class="se form-group row"> --}}
                                {{-- <div class="col-12 col-md-6">
                                <label for="category">Category</label>
                                <select id="category" name="category" class="form-control">
                                  <option value="normal" {{ old('category')=='normal' ? 'selected' : '' }}>Normal</option>
                                  <option value="shweshops_normal" {{ old('category')=='shweshops_normal' ? 'selected' : '' }}>Shweshops Normal</option>
                                  <option value="shweshops_premium" {{ old('category')=='shweshops_premium' ? 'selected' : '' }}>Shweshops Premium</option>
                                </select>
                              </div>

                              <div class="col-12 col-md-6 d-none">
                                <label for="shweshops_link">Shweshops Link</label>
                                <input id="shweshops_link" value="{{ old('shweshops_link') }}"
                                       min="0" type="text"
                                       class="form-control"
                                       name="shweshops_link" placeholder="Shweshops"
                                >
                              </div> --}}
                            </div>

                            {{-- Test By Swe --}}



                            {{-- Test By Swe --}}

                            <div class="se form-group row">

                                <div class="col-12 col-md-6">
                                    <label for="state">State<span style="color: red;">*</span></label>
                                    <input type="hidden" id="state" name="state"
                                        value="{{ old('state') ? old('state') : '[]' }}">
                                    <div class="sn-multiple-selection">
                                        <label id="openState" for="states"
                                            class="sn-gemname sn-dropdown-select form-control @error('state') is-invalid @enderror">
                                            @if (old('state'))
                                                <span>{{ count(json_decode(old('state'))) }} state(s) selected</span>
                                            @else
                                                <span>Select a state</span>
                                            @endif
                                        </label>

                                        <div class="sn-checkbox-dropdown sn-dropdown-state d-none">
                                            @foreach ($states as $state)
                                                @if (in_array($state->id, old('state') ? json_decode(old('state')) : []))
                                                    <div class="sn-gem-list">
                                                        <input type="checkbox" value="{{ $state->id }}"
                                                            id="{{ $state->id }}_state" checked
                                                            onchange="checkState(this)" />
                                                        <label
                                                            for="{{ $state->id }}_state">{{ $state->name . ' (' . $state->myan_name . ')' }}</label>
                                                    </div>
                                                @else
                                                    <div class="sn-gem-list">
                                                        <input type="checkbox" value="{{ $state->id }}"
                                                            id="{{ $state->id }}_state" onchange="checkState(this)" />
                                                        <label
                                                            for="{{ $state->id }}_state">{{ $state->name . ' (' . $state->myan_name . ')' }}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    @error('state')
                                        <x-error>
                                            {{ $message }}
                                        </x-error>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="township">Township<span style="color: red;">*</span></label>
                                    <input type="hidden" id="township" name="township"
                                        value="{{ old('township') ? old('township') : '[]' }}">
                                    <input type="hidden" id="townshipList" name="" value="[]">
                                    <div class="sn-multiple-selection">
                                        <label id="openTownship" for="township"
                                            class="sn-gemname sn-dropdown-select form-control @error('township') is-invalid @enderror">
                                            <span>Select a state first</span>
                                        </label>

                                        <div class="sn-checkbox-dropdown sn-dropdown-township d-none">

                                        </div>
                                    </div>
                                    @error('township')
                                        <x-error>
                                            {{ $message }}
                                        </x-error>
                                    @enderror
                                </div>
                            </div>

                            <div class="se form-group row">
                                <div class="col-12 col-md-6">
                                    <label for="address">Address<span style="color: red;">*</span></label>
                                    <textarea id="address" type="description" class="form-control @error('address') is-invalid @enderror"
                                        name="address" placeholder="Address" rows="4">{{ old('address') }}</textarea>

                                    @error('address')
                                        <x-error>
                                            {{ $message }}
                                        </x-error>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">

                                    {{-- <label for="exampleInputEmail1">ဆိုင်logoတင်ရန်<span
                                            style="color: red;"></span></label> --}}

                                    {{-- <div class="custom-file">
                                        <input type="file" class="custom-file-input" name='shop_logo'
                                               id="logo">
                                        <label class="custom-file-label" for="exampleInputFile" style="color: #979797;">ဆိုင်logoတင်ရန်</label>
                                    </div> --}}
                                    <div class="custom-file">
                                        <label for="formFile" class="form-label">ဆိုင်logoတင်ရန် <span
                                                style="color: red;"></span></label>
                                        <input class="form-control" type="file" id="formFile" name="shop_logo"
                                            accept="image/png, image/gif, image/jpeg">
                                    </div>

                                    @error('shop_logo')
                                        <x-error>
                                            {{ $message }}
                                        </x-error>
                                    @enderror
                                </div>




                            </div>

                            {{-- //page --}}
                            <div class="se form-group row">
                                <div class="col-12 col-md-6">
                                </div>

                                <div class="col-12 col-md-6">

                                    <button id="createDirectoryButton" type="submit"
                                        class="btn btn-primary float-right">
                                        {{ __('Create') }}
                                    </button>
                                </div>

                            </div>
                            {{-- //page --}}
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
@endsection

@push('css')
    <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <style>
        .tagify {
            --tag-inset-shadow-size: 2em !important;
        }

        .tagify__input:empty::before {
            position: static;
        }

        .tagify {
            width: 100%;
            background: white;
            border: 1px solid #ced4da;
            border-top-color: rgb(206, 212, 218);
            border-top-style: solid;
            border-top-width: 1px;
            border-right-color: rgb(206, 212, 218);
            border-right-style: solid;
            border-right-width: 1px;
            border-bottom-color: rgb(206, 212, 218);
            border-bottom-style: solid;
            border-bottom-width: 1px;
            border-left-color: rgb(206, 212, 218);
            border-left-style: solid;
            border-left-width: 1px;
            border-image-source: initial;
            border-image-slice: initial;
            border-image-width: initial;
            border-image-outset: initial;
            border-image-repeat: initial;
        }

        .sn-multiple-selection {
            position: relative;
        }

        .sn-multiple-selection label {
            font-weight: 100 !important;
        }

        .sn-checkbox-dropdown {
            display: block;
            position: absolute;
            z-index: 999;
            background: #fff;
            border: 1px solid #cbcbcb;
            border-radius: 5px;
            top: 40px;
            width: 100%;
            min-height: 150px;
            overflow-y: scroll;
            max-height: 250px;
        }

        .sn-checkbox-dropdown input[type=checkbox] {
            -webkit-appearance: none;
            display: block;
            /* padding:10px 16px; */
            width: 100%;
            margin: 0;
            outline: none !important;
            transition: background 0.3s;
        }

        /* .sn-checkbox-dropdown label:hover {
            background: rgba(0, 0, 0, 0.1);
        } */


        .sn-checkbox-dropdown input[type=checkbox]:checked+label {
            background: rgba(0, 0, 0, 0.1);
        }

        .sn-checkbox-dropdown input[type=checkbox]:checked+label:after {
            content: '×';
            position: absolute;
            font-weight: bold;
            right: 10px;
            top: 48%;
            font-size: 18px;
            line-height: 0;
            color: #8d8d8d;
        }

        .sn-checkbox-dropdown input[type=checkbox]:after {
            display: none;
        }

        .sn-gem-list label {
            padding: 8px 16px;
            margin-bottom: 0 !important;
            position: relative;
            display: block;
        }

        .sn-dropdown-select {
            border: 0;
        }

        .sn-dropdown-select {
            color: #000 !important;
        }

        .sn-gemname {

            border: 1px solid #cbcbcb;
            border-radius: 5px;
            margin-bottom: 0 !important;
            padding: 0.375rem 0.75rem;
            line-height: 1.5;
            display: block;
            background: #fff;
        }

        .sn-gemname:after {
            content: '';
            position: absolute;
            right: 10px;
            top: 50%;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #cccccc;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/@yaireo/tagify"></script>
    <script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <script>
        $('#address').summernote({
            height: 200
        });
        $(function() {
            bsCustomFileInput.init();
        });
        var input = document.querySelector('input[name=additional_phones]');
        new Tagify(input)
    </script>
    <script>
        // select state

        function checkState(checkstate) {
            var state = $('#state').val();
            state = JSON.parse(state);
            if (checkstate.checked) {
                state.push(checkstate.value);
            } else {
                const index = state.indexOf(checkstate.value);
                if (index !== -1) {
                    state.splice(index, 1);
                }
            }
            $('#state').val(JSON.stringify(state.sort()));
            if (state.length > 0) {
                $('#openState > span').replaceWith(`<span>${state.length} state(s) selected</span>`);
            } else {
                $('#openState > span').replaceWith(`<span>Select a state</span>`);
                $('#openTownship > span').replaceWith(`<span>Select a state first</span>`);
            }
            $(".sn-dropdown-township").addClass("d-none");
            getTownship('');
        }

        // When select state, get specific township list

        function getTownship(township) {
            var state_id = JSON.parse($("#state").val());
            var township_list = [];

            var label = "";
            var input = " ";
            township = township ? JSON.parse(township) : JSON.parse($('#township')
        .val()); // has old selected township or not

            $.ajax({
                url: "{{ url('backside/super_admin/directory/get_township') }}",
                type: "get",
                data: {
                    'id': state_id
                },
                success: function(data) {

                    // township list bind
                    if (data.length != 0) {
                        for (var i = 0; i < data.length; i++) {
                            if (township.includes((data[i].id).toString())) {
                                input += `<div class="sn-gem-list">
                                <input
                                  type="checkbox"
                                  value="${data[i].id}"
                                  id="${data[i].id}_township"
                                  checked
                                  onchange="checkTownship(this)"
                                />
                                <label for="${data[i].id}_township">${data[i].name} (${data[i].myan_name})</label>
                              </div>`;
                                township_list.push(data[i].id.toString());
                            } else {
                                input += `<div class="sn-gem-list">
                                <input
                                  type="checkbox"
                                  value="${data[i].id}"
                                  id="${data[i].id}_township"
                                  onchange="checkTownship(this)"
                                />
                                <label for="${data[i].id}_township">${data[i].name} (${data[i].myan_name})</label>
                              </div>`;
                                township_list.push(data[i].id.toString());
                            }
                        }
                    }
                    $('.sn-dropdown-township').html(" ");
                    $('.sn-dropdown-township').append(input);

                    // for checking specific state selected or not
                    $('#townshipList').val(JSON.stringify(township_list.sort()));

                    var townshipcheck = JSON.parse($('#township').val()); // selected township
                    var township_listcheck = JSON.parse($('#townshipList').val()); // all township list by state
                    var townshipfinal = [];

                    // when uncheck state, related township unchecked

                    for (var i = 0; i < townshipcheck.length; i++) {
                        if (township_listcheck.includes(townshipcheck[i])) {
                            townshipfinal.push(townshipcheck[i]);
                        }
                    }
                    $('#township').val(JSON.stringify(townshipfinal.sort()));

                    // Township label
                    if (townshipfinal.length > 0) {
                        label = `<span>${townshipfinal.length} township(s) selected</span>`;
                    } else if (townshipcheck.length > 0) {
                        label = `<span>${townshipcheck.length} township(s) selected</span>`;
                    } else {
                        label = '<span>Select a township</span>';
                    }
                    $('#openTownship > span').replaceWith(label);
                },
                error: function() {
                    console.log('error');
                },
            });
        }

        // select township

        function checkTownship(checktownship) {
            var township = $('#township').val();
            township = JSON.parse(township);
            console.log('checktownship', township)
            if (checktownship.checked) {
                township.push(checktownship.value);
            } else {
                const index = township.indexOf(checktownship.value);
                if (index !== -1) {
                    township.splice(index, 1);
                }
            }
            $('#township').val(JSON.stringify(township.sort()));
            if (township.length > 0) {
                $('#openTownship > span').replaceWith(`<span>${township.length} township(s) selected</span>`);
            } else {
                $('#openTownship > span').replaceWith(`<span>Select a township</span>`);
            }
            console.log('township', township);
        }

        $(function() {
            getTownship($('#township').val()); // retrieve township in case old states exit

            $("#openState").click(function() {
                $(".sn-dropdown-state").toggleClass("d-none");
                $(".sn-dropdown-township").addClass("d-none")
            });

            $("#openTownship").click(function() {
                if (JSON.parse($('#state').val()).length > 0) {
                    $(".sn-dropdown-township").toggleClass("d-none");
                    $(".sn-dropdown-state").addClass("d-none");
                }
            });

            // check username already had or not

            $("#createDirectoryButton").on("click", function(e) {

                e.preventDefault();
                var shopName = $("#shop_name").val();

                $.ajax({
                    url: " {{ url('backside/super_admin/directory/check_shop_directory_name') }}",
                    type: "get",
                    data: {
                        'shopName': shopName
                    },
                    success: function(response) {
                        if (response.isExit) {
                            if (confirm(
                                "Shweshops has the same name. Do you want to continue?") ==
                                false) {
                                return false;
                            } else {
                                $("#createDirectoryForm").submit();
                            }
                        } else {
                            $("#createDirectoryForm").submit();
                        }
                    }

                });
            });
        });
    </script>
@endpush
