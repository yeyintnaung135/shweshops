@extends('layouts.backend.backend')
@section('title','MOE Admin Team | Ads Create')
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
@section('content')
    <div class="wrapper">
        @include('layouts.backend.navbar')
        @include('layouts.backend.sidebar')
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
                                <h3 class="font-weight-bold">Update with Excel</h3>
                            </div>
                            <div class="card-body p-lg-3 p-2">

                                <div class="video">
                                    <form action="{{ url('backside/shop_owner/items/updateexcel')}}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label id="shop">Upload Excel File</label>

                                            <input type="file" name="excel" id="" class="form-control  @error('excel')  is-invalid @enderror">
                                            @error('excel')
                                            <span class="text-danger font-weight-bolder"><i
                                                    class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- form row end  -->
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" id="createVideo">Create
                                            </button>
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
@push('scripts')
    <script>
        const base64data = [];
        $("#loader").hide();
        {{--if($(".dropone").val() == 1){--}}
        {{--      $(".imageAds").show();--}}
        {{--      $(".video").hide();--}}
        {{--}else{--}}
        {{--      $(".imageAds").hide();--}}
        {{--      $(".video").show();--}}
        {{--}--}}
        {{--$('.dropone').change(function(e) {--}}
        {{--    if($(this).val() == 1){--}}
        {{--          $(".imageAds").fadeIn();--}}
        {{--          $(".video").fadeOut();--}}
        {{--    }else{--}}
        {{--        $(".imageAds").fadeOut();--}}
        {{--          $(".video").fadeIn();--}}
        {{--    }--}}
        {{--    console.log($(this).val())--}}
        {{--});--}}
        {{--$('.selectImage').select2();--}}
        {{--$('.selectVideo').select2();--}}

        {{--$("#createAd").click(function(e){--}}
        {{--    $(".create").attr('disabled',true);--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    })--}}
        {{--    e.preventDefault();--}}
        {{--    var formData = {--}}
        {{--        shop_id : jQuery("select[name=shop_id]").val(),--}}
        {{--        links: jQuery("input[name=links]").val(),--}}
        {{--        start : jQuery("input[name=start]").val(),--}}
        {{--        end : jQuery("input[name=end]").val(),--}}
        {{--        image : base64data--}}
        {{--    }--}}
        {{--    $.ajax({--}}
        {{--        url: "{{ route('backside.super_admin.ads.store') }}",--}}
        {{--        method: "POST",--}}
        {{--        data: formData,--}}
        {{--        beforeSend: function() {--}}
        {{--            $("#loader").show();--}}
        {{--        },--}}
        {{--        error:function(err){--}}
        {{--        $("#loader").hide();--}}
        {{--            // console.warn(err.responseJSON.errors);--}}
        {{--            $('.invalid-feedback').remove();--}}
        {{--            $.each(err.responseJSON.errors, function (i, error) {--}}
        {{--                var al = $(document).find('[name="'+i+'"]');--}}
        {{--                var el = al.parent();--}}
        {{--                var pl = al.parents('div.image_area');--}}
        {{--                pl.addClass('photo-invalid');--}}
        {{--                el.after($('<small class="text-danger font-weight-bolder"> <i class="fas fa-exclamation-circle"></i> '+error[0]+'</small>'));--}}
        {{--                al.addClass('is-invalid');--}}
        {{--            });--}}
        {{--        $(".create").attr('disabled',false);--}}


        {{--        },--}}
        {{--        success:function(response){--}}
        {{--            if(response.success){--}}
        {{--            alert(response.message);--}}

        {{--            }else{--}}
        {{--                alert("Error");--}}
        {{--            }--}}
        {{--            window.location.href = "{{ route('backside.super_admin.ads.index')}}";--}}

        {{--        },--}}

        {{--    });--}}
        {{--});--}}
        //Date and time picker
        $('#startVideo').datetimepicker({
            icons: {
                time: 'far fa-clock',
            },
            format: 'DD-MM-YYYY hh:mm A'
        });
        $('#endVideo').datetimepicker({icons: {time: 'far fa-clock'}, format: 'DD-MM-YYYY hh:mm A'});
    </script>
@endpush
@push('excel')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/cropperjs/dist/cropper.css">
@endpush
