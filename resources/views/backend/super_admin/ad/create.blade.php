@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Ads Create')

@section('content')
    <div class="wrapper">
        @include('backend.super_admin.navbar')
        @include('backend.super_admin.sidebar')
        @include('backend.super_admin.loading')
        <section class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title>Create Ad</x-title>
            </section>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-6">
                        <div class="card card-outline card-primary p-0">
                            <div class="card-header ">
                                <h3 class="font-weight-bold">Create Ad</h3>
                            </div>
                            <div class="card-body p-lg-3 p-2">

                                <div class="video">
                                    <form action="{{ url('backside/super_admin/ads_video') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label id="shop">Image For Desktop (1920 * 600)</label>
                                            <input type="file" name="photo" id=""
                                                class="form-control  @error('photo')
                                      is-invalid @enderror">
                                        </div>
                                        <div class="form-group">
                                            <label id="shop">Image For Mobile (500 * 250)</label>
                                            <input type="file" name="image_for_mobile" id=""
                                                class="form-control  @error('image_for_mobile')
                                      is-invalid @enderror">
                                        </div>
                                        <div class="form-group mb-lg-4">
                                            <div class="p-0">
                                                <label id="shop">Select Shop</label>
                                                <select
                                                    class="form-control selectVideo @error('shop_id')
                                            is-invalid
                                          @enderror"
                                                    style="width: 100%;" id="shop" name="shop_id">
                                                    <option value="">Choose</option>
                                                    @foreach ($shops as $shop)
                                                        <option value="{{ $shop->id }}">{{ $shop->shop_name }} (
                                                            {{ $shop->shop_name_myan }} )</option>
                                                    @endforeach
                                                </select>
                                                @error('shop_id')
                                                    <span class="text-danger font-weight-bolder"><i
                                                            class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label for="linkUrl">Links</label>
                                            <input type="text" name="links" class="form-control" id="linkUrl">
                                        </div>
                                        <div class="form-row mb-4">
                                            <div class="col-6">
                                                <label for="startVideo">Start</label>
                                                <div class="input-group date" id="startVideo" data-target-input="nearest">
                                                    <input type="text" name="start"
                                                        class="form-control datetimepicker-input @error('start')
                                        is-invalid
                                      @enderror"
                                                        data-target="#startVideo" />
                                                    <div class="input-group-append" data-target="#startVideo"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                @error('start')
                                                    <span class="font-weight-bolder text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <label for="endVideo">End</label>
                                                <div class="input-group date" id="endVideo" data-target-input="nearest">
                                                    <input type="text" name="end"
                                                        class="form-control datetimepicker-input @error('end')
                                        is-invalid
                                      @enderror"
                                                        data-target="#endVideo" />
                                                    <div class="input-group-append" data-target="#endVideo"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                @error('end')
                                                    <span class="font-weight-bolder text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- form row end  -->
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" id="createVideo">Create</button>
                                            <a href="" class="btn btn-outline-dark">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Modal section  -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
@endsection

@push('css')
    <style>
        /* image crop  */
        .image_area {
            position: relative;
            width: 100%;
            height: 200px;
            border: 2px dashed rgba(103, 103, 103, 0.587);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: transparent;
        }

        #uploaded_image {
            cursor: pointer;
        }

        /* #uploaded_image:hover{
                            transform: scale(1.5);
                          }
                          #uploaded_image:active{
                            transform: scale(1.5);
                          } */
        .photo-invalid {
            border: 3px dashed red;
        }

        .remove-img {
            position: absolute;
            bottom: 1px;
            cursor: pointer;
            display: none;
            transition: 5s;
        }

        .remove-img .fas {
            font-size: 20px;
        }

        .remove-img .fas:hover {
            color: red;
        }

        .upload-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;

        }

        img {
            display: block;
            max-width: 100%;
        }

        .preview {
            overflow: hidden;
            width: 100%;
            height: 160px;
            margin-left: 5px;
            border: 3px solid red;
        }

        .modal-lg {
            max-width: 1000px !important;
        }

        .text {
            color: #333;
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            text-align: center;
        }

        /* Change Modal Content Size */
        @media screen and (min-width: 990px) {
            .modal-content {
                margin-left: 120px !important;
            }

            .modal-lg {
                max-width: 750px !important;
            }
        }

        @media screen and (max-width: 726px) {
            .image_area {
                width: 100%;
                height: 200px;
                padding: 5px;
            }

            .preview {
                margin: 10px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        const base64data = [];
        $("#loader").hide();
        {{-- if($(".dropone").val() == 1){ --}}
        {{--      $(".imageAds").show(); --}}
        {{--      $(".video").hide(); --}}
        {{-- }else{ --}}
        {{--      $(".imageAds").hide(); --}}
        {{--      $(".video").show(); --}}
        {{-- } --}}
        {{-- $('.dropone').change(function(e) { --}}
        {{--    if($(this).val() == 1){ --}}
        {{--          $(".imageAds").fadeIn(); --}}
        {{--          $(".video").fadeOut(); --}}
        {{--    }else{ --}}
        {{--        $(".imageAds").fadeOut(); --}}
        {{--          $(".video").fadeIn(); --}}
        {{--    } --}}
        {{--    console.log($(this).val()) --}}
        {{-- }); --}}
        {{-- $('.selectImage').select2(); --}}
        {{-- $('.selectVideo').select2(); --}}

        {{-- $("#createAd").click(function(e){ --}}
        {{--    $(".create").attr('disabled',true); --}}
        {{--    $.ajaxSetup({ --}}
        {{--        headers: { --}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') --}}
        {{--        } --}}
        {{--    }) --}}
        {{--    e.preventDefault(); --}}
        {{--    var formData = { --}}
        {{--        shop_id : jQuery("select[name=shop_id]").val(), --}}
        {{--        links: jQuery("input[name=links]").val(), --}}
        {{--        start : jQuery("input[name=start]").val(), --}}
        {{--        end : jQuery("input[name=end]").val(), --}}
        {{--        image : base64data --}}
        {{--    } --}}
        {{--    $.ajax({ --}}
        {{--        url: "{{ route('backside.super_admin.ads.store') }}", --}}
        {{--        method: "POST", --}}
        {{--        data: formData, --}}
        {{--        beforeSend: function() { --}}
        {{--            $("#loader").show(); --}}
        {{--        }, --}}
        {{--        error:function(err){ --}}
        {{--        $("#loader").hide(); --}}
        {{--            // console.warn(err.responseJSON.errors); --}}
        {{--            $('.invalid-feedback').remove(); --}}
        {{--            $.each(err.responseJSON.errors, function (i, error) { --}}
        {{--                var al = $(document).find('[name="'+i+'"]'); --}}
        {{--                var el = al.parent(); --}}
        {{--                var pl = al.parents('div.image_area'); --}}
        {{--                pl.addClass('photo-invalid'); --}}
        {{--                el.after($('<small class="text-danger font-weight-bolder"> <i class="fas fa-exclamation-circle"></i> '+error[0]+'</small>')); --}}
        {{--                al.addClass('is-invalid'); --}}
        {{--            }); --}}
        {{--        $(".create").attr('disabled',false); --}}


        {{--        }, --}}
        {{--        success:function(response){ --}}
        {{--            if(response.success){ --}}
        {{--            alert(response.message); --}}

        {{--            }else{ --}}
        {{--                alert("Error"); --}}
        {{--            } --}}
        {{--            window.location.href = "{{ route('backside.super_admin.ads.index')}}"; --}}

        {{--        }, --}}

        {{--    }); --}}
        {{-- }); --}}
        //Date and time picker
        $('#startVideo').datetimepicker({
            icons: {
                time: 'far fa-clock',
            },
            format: 'DD-MM-YYYY hh:mm A'
        });
        $('#endVideo').datetimepicker({
            icons: {
                time: 'far fa-clock'
            },
            format: 'DD-MM-YYYY hh:mm A'
        });
    </script>
@endpush
