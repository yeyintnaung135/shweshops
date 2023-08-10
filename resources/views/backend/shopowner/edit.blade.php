@extends('layouts.backend.backend')

@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.backend.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper ">
            <!-- Content Header (Page header) -->
            <section class="content-header px-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 pt-3 ps-3">
                            <h1 style="font-family: sans-serif!important">Edit Your Shop</h1>
                            <p>ဆိုင်အတွက်လိုအပ်သည့်အချက်အလက်များကိုထည့်သွင်းနိုင်ပါသည်
                            <p>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- left column -->

                    <!-- general form elements -->
                    <div class="">

                        <!-- /.card-header -->
                        <!-- form start -->
                        @foreach ($shopowner as $shopowner)
                        @endforeach
                        {{ Form::model($shopowner, ['route' => ['backside.shop_owner.update', $shopowner->id], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}

                        @csrf {{-- cross site request forgery --}}
                        @method('PUT')

                        <div class="card-body">
                            <div class="row sn-item-create-wrapper">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Shop Name ( In Eng )</legend>
                                            {{-- <label for="shopname">Shop Name ( In Eng )</label> --}}
                                            <input @focus="$event.target.select()" type="text"
                                                class="form-control sop-form-control" id="name"
                                                placeholder="Enter shop name" name="shop_name"
                                                value="{{ old('shop_name', $shopowner->shop_name) }}">
                                        </fieldset>
                                        @error('shop_name')
                                            <x-error>
                                                {{ $message }}
                                            </x-error>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><span style="font-family: 'Myanmar3'!important"> ဆိုင်အမည် </span>( In
                                                MM )</legend>
                                            {{-- <label for="shopname">ဆိုင် အမည် ( In MM )</label> --}}
                                            <input @focus="$event.target.select()" type="text"
                                                class="form-control sop-form-control" id="name"
                                                placeholder="ဆိုင်အမည် ထည့်ရန်" name="shop_name_myan"
                                                value="{{ old('name', $shopowner->shop_name_myan) }}">
                                        </fieldset>
                                        @error('shop_name_myan')
                                            <x-error>
                                                {{ $message }}
                                            </x-error>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Name(ဆိုင်ပိုင်ရှင်)</legend>
                                            {{-- <label for="title">Title</label> --}}
                                            <input @focus="$event.target.select()" type="text"
                                                class="form-control sop-form-control" id="Name"
                                                placeholder="ဆိုင်ပိုင်ရှင် နာမည်" name="name"
                                                value="{{ old('name', $shopowner->name) }}">
                                        </fieldset>
                                        @error('name')
                                            <x-error>
                                                {{ $message }}
                                            </x-error>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Shop Link Name</legend>
                                            {{-- <label for="title">Title</label> --}}
                                            <input @focus="$event.target.select()" type="text"
                                                class="form-control sop-form-control" id="shopNameUrl"
                                                placeholder="Shop name url" name="shop_name_url"
                                                value="{{ old('shop_name_url', $shopowner->shop_name_url) }}">
                                        </fieldset>
                                        @error('shop_name_url')
                                            <x-error>
                                                {{ $message }}
                                            </x-error>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Main Phone</legend>
                                            {{-- <label for="shopname">Main Phone</label> --}}
                                            <input @focus="$event.target.select()" type="text"
                                                class="form-control sop-form-control" id="name"
                                                placeholder="Enter Main Phone" name="main_phone"
                                                value="{{ old('main_phone', $shopowner->main_phone) }}">
                                            @error('main_phone')
                                                <x-error>
                                                    {{ $message }}
                                                </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset class="other_phones">
                                            <legend>Other Phones</legend>
                                            {{-- <label for="shopname">Main Phone</label> --}}
                                            <input type="text" class="form-control-tags js-tagify" id="additional_phones"
                                                placeholder="Press Enter after each phones" name="additional_phones"
                                                value="{{ old('additional_phones', $shopowner->additional_phones) }}">
                                            @error('additional_phones')
                                                <x-error>
                                                    {{ $message }}
                                                </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>
                            </div>



                            <div class="row sn-item-create-wrapper">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset class="sop-texarea">
                                            <legend for="address">Address</legend>

                                            <textarea rows="5" name="address">{{ old('address', $shopowner->address) }}</textarea>
                                        </fieldset>
                                        @error('address')
                                            <x-error>
                                                {{ $message }}
                                            </x-error>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <fieldset class="sop-texarea">
                                            <legend for="other_address">Other Address</legend>

                                            <textarea id="other_address" rows="4" name="other_address">{{ old('other_address', $shopowner->other_address) }}</textarea>
                                        </fieldset>
                                        @error('other_address')
                                            <x-error>
                                                {{ $message }}
                                            </x-error>
                                        @enderror --}}

                                        <fieldset class="other_address">
                                            <legend>Other Addresses</legend>
                                            {{-- <label for="shopname">Main Phone</label> --}}
                                            <textarea id="other_address" rows="5" name="other_address">{{ old('other_address', $shopowner->other_address) }}</textarea>
                                            @error('other_address')
                                                <x-error>
                                                    {{ $message }}
                                                </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset class=" sop-texarea">
                                            <legend for="address">Map</legend>

                                            <textarea id="map" rows="4" name="map">{{ old('map', $shopowner->map) }}</textarea>
                                        </fieldset>


                                    </div>
                                </div>

                            </div>

                            <div class="row sn-item-create-wrapper">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset class=" sop-texarea">
                                            <legend>Short Description</legend>
                                            {{-- <label for="description">Short Description</label> --}}
                                            <textarea id="summernoteDescription" @focus="$event.target.select()" class="form-control sop-form-control"
                                                name="description" rows="3" placeholder="Enter ...">{{ $shopowner->description }}</textarea>
                                            @error('description')
                                                <x-error>
                                                    {{ $message }}
                                                </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>


                            </div>


                            <!-- photo two -->
                            <h2>ပြန်သွင်း/ပြန်လဲ အချက်အလက်များ (%)</h2>
                            <div class="row sn-item-create-wrapper">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>အထည်မပျက် ပြန်သွင်း</legend>
                                            {{-- <label for="shopname">အထည်မပျက် ပြန်သွင်း (%)</label> --}}
                                            <input @focus="$event.target.select()" type="text"
                                                class="form-control sop-form-control" id="name"
                                                name="undamaged_product"
                                                value="{{ old('undamaged_product', $shopowner->undamaged_product) }}"
                                                value="{{ $shopowner->undamaged_product }}">
                                            @error('name')
                                                <x-error>
                                                    {{ $message }}
                                                </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>တန်ဖိုးမြင့်အထည်-အထည်မပျက်ပြန်လဲ</legend>
                                            {{-- <label for="shopname">တန်ဖိုးမြင့်အထည် နှင့် အထည်မပျက်ပြန်လဲ (%)</label> --}}
                                            <input @focus="$event.target.select()" type="text"
                                                class="form-control sop-form-control" id="name"
                                                name="valuable_product"
                                                value="{{ old('valuable_product', $shopowner->valuable_product) }}">
                                            @error('name')
                                                <x-error>
                                                    {{ $message }}
                                                </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>အထည်ပျက်စီး ချို့ယွင်း</legend>
                                            {{-- <label for="shopname">အထည်ပျက်စီး ချို့ယွင်း (%)</label> --}}
                                            <input @focus="$event.target.select()" type="text"
                                                class="form-control sop-form-control" id="name"
                                                name="damaged_product"
                                                value="{{ old('damaged_product', $shopowner->damaged_product) }}">
                                            @error('name')
                                                <x-error>
                                                    {{ $message }}
                                                </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>



                            </div>
                            <h2 style="font-family: sans-serif">Social Link</h2>
                            <div class="row sn-item-create-wrapper">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Facebook page link</legend>
                                            {{-- <label for="shopname">Facebook page link</label> --}}
                                            <input @focus="$event.target.select()" type="text"
                                                class="form-control sop-form-control" id="phone_no"
                                                placeholder="Enter Page Link" name="page_link"
                                                value="{{ old('page_link', $shopowner->page_link) }}">
                                            @error('page_link')
                                                <x-error>
                                                    {{ $message }}
                                                </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Messenger Link</legend>
                                            {{-- <label for="shopname">Messenger Link</label> --}}
                                            <input @focus="$event.target.select()" type="text"
                                                class="form-control sop-form-control" id="name"
                                                placeholder="Enter Messenger Link" name="messenger_link"
                                                value="{{ old('messenger_link', $shopowner->messenger_link) }}">
                                            @error('messenger_link')
                                                <x-error>
                                                    {{ $message }}
                                                </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <h2 style="font-family: sans-serif">Logo and Banner Upload</h2>
                            <div class="row mt-3">
                                <!-- photoone -->
                                <div class="col-6">
                                    <div class="form-group">

                                        <label for="exampleInputFile">Logo</label>

                                        <div class="form-group row">


                                            <div class="col-md-12 col-12">
                                                <div class="mb-2">
                                                    <img src="{{ asset('images/logo/' . $shopowner->shop_logo) }}"
                                                        alt="" class="w-25">
                                                </div>
                                                <div class="input-group mb-3">

                                                    <div class="custom-file">
                                                        <input @focus="$event.target.select()" type="file"
                                                            name="shop_logo" class="custom-file-input"
                                                            id="exampleInputFile">
                                                        <label class="custom-file-label"
                                                            for="exampleInputFile">Logoတင်ရန်</label>
                                                    </div>

                                                </div>
                                                @error('shop_logo')
                                                    <x-error>
                                                        {{ $message }}
                                                    </x-error>
                                                @enderror

                                            </div>
                                        </div>

                                    </div>

                                </div>
                                @if ($shopowner->premium == 'yes')
                                    <div class="col-6">

                                        <div class="form-group row sn-item-create-wrapper">
                                            <!-- <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label> -->

                                            <div class="col-md-12 col-12">
                                                <label for="exampleInputFile">Banner</label>
                                                <div class="mb-3">
                                                    @foreach ($shopowner->getPhotos as $photo)
                                                        <img src="{{ asset('images/banner/' . $photo->location) }}"
                                                            alt="" class="w-25 mb-1">
                                                    @endforeach
                                                </div>

                                                <div class="input-group mb-3">

                                                    <div class="custom-file">

                                                        <label class="custom-file-label"
                                                            for="exampleInputFile">Bannerတင်ရန်</label>

                                                        <input @focus="$event.target.select()" type="file"
                                                            name="banner[]" multiple placeholder="ဆိုင်bannerတင်ရန်"
                                                            class="custom-file-input" id="exampleInputFile">
                                                    </div>

                                                </div>
                                                @error('banner.*')
                                                    <x-error>
                                                        {{ $message }}
                                                    </x-error>
                                                @enderror
                                            </div>


                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div class="row">


                                <div class="col-6 col-md-8">&nbsp;</div>
                                @csrf

                                <div class="col-6 col-md-4">
                                    <button class="btn btn-primary float-right" type="submit"><span
                                            class="fa fa-paper-plane"></span>&nbsp;&nbsp;Update
                                    </button>
                                </div>

                            </div>


                        </div>
                        <!-- /.card-body -->
                        {!! Form::close() !!}
                    </div>
                    <!-- /.card -->

                    <!-- general form elements -->

                    <!--/.col (left) -->
                    <!-- right column -->

                    <!--/.col (right) -->

                    <!-- /.row -->
                    <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
@endsection

@push('css')
    <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <style>
        .content-wrapper {
            background: #ffffff !important;
        }

        label {
            color: #707070;
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 600px;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        .custom-file-input {
            cursor: pointer !important;
        }

        .sn-item-create-wrapper {
            padding: 0 !important;
            margin: 0 !important;
        }

        .tagify__tag {
            margin: 0px 0 0px 5px;
        }

        .tagify__input {
            margin: 2px 0 0 0;
        }

        .tagify {
            border: none;
        }

        .other_phones {
            min-height: 66px !important;
            height: auto !important;
        }

        .tagify__input::before {
            line-height: 1.5 !important;
        }

        .tagify {
            --tag-inset-shadow-size: 2em !important;
        }

        .tagify__input:empty::before {
            position: static;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ url('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script src="https://unpkg.com/@yaireo/tagify"></script>

    <script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>

    <script>
        $('#summernoteAddress').summernote();
        $('#summernoteDescription').summernote();
        $(function() {
            bsCustomFileInput.init();
        });
        var other_phone_input = document.querySelector('input[name=additional_phones]');
        new Tagify(other_phone_input);

        var other_addresses_input = document.querySelector('textarea[name=other_address]');
        new Tagify(other_addresses_input, {
            delimiters       : null,
        });
    </script>
@endpush
