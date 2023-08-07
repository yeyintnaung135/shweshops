@extends('backend.super_admin.layout')
@section('content')
    <div class="wrapper">
        @include('backend.pos_super_admin.navbar')
        @include('backend.pos_super_admin.sidebar')
        <section class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title>Edit Shop</x-title>
            </section>
            <div class="container">
                <div class="row">
                    <div class="col-12">

                        {{ Form::model($shopowner, ['route' => ['pos_super_admin_shops.update', $shopowner->id], 'method' => 'post','enctype' => 'multipart/form-data']) }}

                        @csrf {{-- cross site request forgery --}}
                        @method('PUT')
                        <div class="card-body">
                            <div class="row sn-item-create-wrapper">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Shop Name ( In Eng )</legend>
                                            {{-- <label for="shopname">Shop Name ( In Eng )</label> --}}
                                            <input type="text" class="form-control sop-form-control" id="name"
                                                   placeholder="Enter shop name"
                                                   name="shop_name" value="{{ old('shop_name',$shopowner->shop_name) }}">
                                        </fieldset>
                                        @error('shop_name')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend><span style="font-family: 'Myanmar3'!important"> ဆိုင်အမည် </span>(
                                                In MM )
                                            </legend>
                                            {{-- <label for="shopname">ဆိုင် အမည် ( In MM )</label> --}}
                                            <input type="text" class="form-control sop-form-control" id="name"
                                                   placeholder="ဆိုင်အမည် ထည့်ရန်"
                                                   name="shop_name_myan"
                                                   value="{{ old('shop_name_myan',$shopowner->shop_name_myan) }}">
                                        </fieldset>
                                        @error('shop_name_myan')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Name(ဆိုင်ပိုင်ရှင်)</legend>
                                            {{-- <label for="title">Title</label> --}}
                                            <input type="text" class="form-control sop-form-control" id="Name"
                                                   placeholder="ဆိုင်ပိုင်ရှင် နာမည်"
                                                   name="name" value="{{ old('name',$shopowner->name) }}">
                                        </fieldset>
                                        @error('name')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Shop Name Link</legend>
                                            <input type="text" class="form-control sop-form-control" id="shopNameUrl"
                                                   placeholder="Shop Name Link"
                                                   name="shop_name_url" value="{{ old('shop_name_url',$shopowner->shop_name_url) }}">
                                        </fieldset>
                                        @error('shop_name_url')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row sn-item-create-wrapper">
                                <div class="col-12 col-md-6">
                                    <label for="state">State<span style="color: red;">*</span></label>
                                    <select id="state" name="state" class="form-control @error('state') is-invalid @enderror">
                                        @foreach($states as $state)
                                            @if ($state->id == $shopowner->state)
                                                <option value="{{ $state->id }}" selected>{{ $state->name . ' (' . $state->myan_name . ')' }}</option>
                                            @else
                                                @if ($shopowner->state == 0)
                                                    <option selected disabled hidden>Select a state</option>
                                                @endif
                                                <option value="{{ $state->id }}">{{ $state->name . ' (' . $state->myan_name . ')' }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('state')
                                    <x-error>
                                        {{$message}}
                                    </x-error>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="township">Township<span style="color: red;">*</span></label>
                                    <input type="hidden" id="townshipfromdata" name="" value="{{ $shopowner->township }}">
                                    <select id="township" name="township" class="form-control @error('township') is-invalid @enderror">
                                    </select>
                                    @error('township')
                                    <x-error>
                                        {{$message}}
                                    </x-error>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend for="address">Address</legend>
                                            <textarea class="form-control sop-form-control" id="summernoteAddress" name="address"rows="4">{!! old('address',$shopowner->address)  !!}  </textarea>
                                        </fieldset>
                                        @error('address')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend for="other_address">Other Address</legend>
                                            <textarea class="form-control sop-form-control" id="summernoteOtherAddress" name="other_address"rows="4">{{ old('other_address',$shopowner->other_address) }}</textarea>
                                        </fieldset>
                                        @error('other_address')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend for="address">Map</legend>
                                            <textarea class="form-control sop-form-control" id="map" name="map"rows="4">{{ old('map',$shopowner->map) }}</textarea>
                                        </fieldset>
                                        @error('address')
                                        <x-error>
                                            {{$message}}
                                        </x-error>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Main Phone</legend>
                                            {{-- <label for="shopname">Main Phone</label> --}}
                                            <input type="text" class="form-control sop-form-control" id="name"
                                                   placeholder="Enter Main Phone"
                                                   name="main_phone"
                                                   value="{{ old('main_phone',$shopowner->main_phone) }}">
                                            @error('main_phone')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Other Phones</legend>
                                            {{-- <label for="shopname">Main Phone</label> --}}
                                            <input  type="text" class="form-control-tags js-tagify" id="additional_phones" placeholder="Press Enter after each phones"
                                                    name="additional_phones" value="{{ old('additional_phones',$shopowner->additional_phones) }}" >
                                            @error('additional_phones')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Short Description</legend>
                                            {{-- <label for="description">Short Description</label> --}}
                                            <textarea class="form-control sop-form-control" id='summernoteDescription' name="description" rows="4">{{ $shopowner->description }}</textarea>
                                            @error('description')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>
                            </div>


                            <!-- photo two -->
                            <h2>ပြန်သွင်း/ပြန်လဲ အချက်အလက်များ</h2>
                            <div class="row sn-item-create-wrapper">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>အထည်မပျက် ပြန်သွင်း </legend>
                                            {{-- <label for="shopname">အထည်မပျက် ပြန်သွင်း (%)</label> --}}
                                            <input type="text" class="form-control sop-form-control" id="name"
                                                   placeholder="10 % or 10000ကျပ်"
                                                   name="valuable_product"
                                                   value="{{ old('အထည်မပျက်_ပြန်သွင်း',$shopowner->အထည်မပျက်_ပြန်သွင်း) }}"
                                                   value="{{$shopowner->အထည်မပျက်_ပြန်သွင်း}}">
                                            @error('name')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>တန်ဖိုးမြင့်အထည် နှင့် အထည်မပျက်ပြန်လဲ </legend>
                                            {{-- <label for="shopname">တန်ဖိုးမြင့်အထည် နှင့် အထည်မပျက်ပြန်လဲ (%)</label> --}}
                                            <input type="text" class="form-control sop-form-control" id="name"
                                                   placeholder="10 % or 10000ကျပ်"
                                                   name="undamage_product"
                                                   value="{{ old('တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ',$shopowner->တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ) }}">
                                            @error('name')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>အထည်ပျက်စီး ချို့ယွင်း </legend>
                                            {{-- <label for="shopname">အထည်ပျက်စီး ချို့ယွင်း (%)</label> --}}
                                            <input type="text" class="form-control sop-form-control" id="name"
                                                   placeholder="10 % or 10000ကျပ်"
                                                   name="damage_product"
                                                   value="{{ old('အထည်ပျက်စီးချို့ယွင်း',$shopowner->အထည်ပျက်စီးချို့ယွင်း) }}">
                                            @error('name')
                                            <x-error>
                                                {{$message}}
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
                                            <input type="text" class="form-control sop-form-control" id="phone_no"
                                                   placeholder="Enter Page Link"
                                                   name="page_link"
                                                   value="{{ old('page_link',$shopowner->page_link) }}">
                                            @error('page_link')
                                            <x-error>
                                                {{$message}}
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
                                            <input type="text" class="form-control sop-form-control" id="name"
                                                   placeholder="Enter shop name"
                                                   name="messenger_link"
                                                   value="{{ old('messenger_link',$shopowner->messenger_link) }}">
                                            @error('messenger_link')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <h2 style="font-family: sans-serif">Logo and Banner Upload</h2>
                            <div class="row">
                                <!-- photoone -->
                                <div class="col-6">
                                    <div class="form-group">

                                        <label for="exampleInputFile">Logo</label>

                                        <div class="form-group row">


                                            <div class="col-md-12 col-12">
                                                <div class="mb-2">
                                                    <img src="{{ asset('images/logo/'.$shopowner->shop_logo)}}" alt="" class="w-25">
                                                </div>
                                                <div class="input-group mb-3">

                                                    <div class="custom-file">
                                                        <input type="file" name="shop_logo" class="custom-file-input"
                                                               id="exampleInputFile">
                                                        <label class="custom-file-label" for="exampleInputFile">Logoတင်ရန်</label>
                                                    </div>

                                                </div>
                                                @error('shop_logo')
                                                <x-error>
                                                    {{$message}}
                                                </x-error>
                                                @enderror

                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-6">

                                    <div class="form-group row sn-item-create-wrapper">
                                    <!-- <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label> -->

                                        <div class="col-md-12 col-12 " id="banner">
                                            <label for="exampleInputFile">Banner</label>
                                            <div class="mb-3">
                                                @foreach ($shopowner->getPhotos as $photo )
                                                    <img src="{{ asset('images/banner/'. $photo->location)}}" alt="" class="w-25 mb-1">
                                                @endforeach
                                            </div>

                                            <div class="input-group mb-3">

                                                <div class="custom-file">

                                                    <label class="custom-file-label"
                                                           for="exampleInputFile">Bannerတင်ရန်</label>

                                                    <input type="file" name="banner[]"
                                                           placeholder="ဆိုင်bannerတင်ရန်" class="custom-file-input"
                                                           id="exampleInputFile" multiple>
                                                </div>

                                            </div>
                                            @error('banner.*')
                                            <x-error>
                                                {{$message}}
                                            </x-error>
                                            @enderror
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="yk form-group row">
                                <div class="col-12 col-md-6">

                                    <label for="exampleSelectRounded0">Premium</label>
                                    <select class="custom-select rounded-0" name="premium" id="premium">
                                        @if(old('premium',$shopowner->premium) == 'yes')
                                            <option value="yes" selected>Yes</option>
                                            <option value="no">No</option>
                                        @else
                                            <option value="yes">Yes</option>
                                            <option value="no" selected>No</option>
                                        @endif

                                    </select>
                                </div>
                            </div>
                            <div class="row">


                                <div class="col-6 col-md-8">&nbsp;</div>
                                @csrf

                                <div class="col-6 col-md-4">
                                    <button class="btn btn-color float-right" type="submit"><span
                                            class="fa fa-paper-plane"></span>&nbsp;&nbsp;Update
                                    </button>
                                </div>

                            </div>


                        </div>
                        <!-- /.card-body -->
                        {!! Form::close() !!}
                    </div>

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
@push('scripts')
    <script src="https://unpkg.com/@yaireo/tagify"></script>
    <script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
        var input = document.querySelector('input[name=additional_phones]');
        new Tagify(input)
    </script>
    <script src="{{url('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
            getTownship($('#townshipfromdata').val());

            $(document).on('change', '#state', function() {
                getTownship('');
            });

            function getTownship (township) {
                var state_id = $("#state").val();
                console.log('Yangon', state_id);
                var op = " ";
                $.ajax({
                    url: "{{ url('backside/super_admin/directory/get_township')}}",
                    type: "get",
                    data: {'id':state_id},
                    success: function(data){
                        op += '<option selected disabled hidden>Select a township</option>';
                        if(data.length != 0) {
                            for (var i = 0; i < data.length; i++){
                                if(township == data[i].id) {
                                    op += '<option value="'+data[i].id+'" selected>'+data[i].name +' (' + data[i].myan_name + ')</option>';
                                } else {
                                    op += '<option value="'+data[i].id+'">'+data[i].name +' (' + data[i].myan_name + ')</option>';
                                }
                            }
                        } else {
                            op += '<option selected disabled hidden>Select a state first</option>';
                        }
                        console.log('Worked', data)
                        $('#township').html(" ");
                        $('#township').append(op);
                    },
                    error: function(){
                        console.log('error');
                    },
                });
            }
        });

        $('#banner').hide();
        @if(old('premium',$shopowner->premium) == 'yes')
        $('#banner').show();
        @endif

        $('#premium').on('change', function() {
            $("#banner").toggle(this.value == "yes")
        });
    </script>


@endpush
@push('css')
    <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <style>
        .tagify{
            --tag-inset-shadow-size:2em!important;
        }
        .tagify__input:empty::before {
            position: static;
        }
        .tagify{
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
        .btn-color{
        background-color: #780116;
        color: white;
    }
    .btn-color:hover{
            color: white;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{url('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });

        $('#summernoteAddress').summernote({
            height: 200
        });
        $('#summernoteOtherAddress').summernote({
            height: 200
        });
        $('#summernoteDescription').summernote({
            height:200
        });
    </script>
@endpush
