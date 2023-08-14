@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Ads Edit')
@php
    use Illuminate\Support\Carbon;
@endphp

@section('content')
    <div class="wrapper">
        @include('backend.super_admin.navbar')
        @include('backend.super_admin.sidebar')
        <section class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title>Edit Ad</x-title>
            </section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="form-row ">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3 p-lg-3">
                                    <div class="">
                                        <img src="{{ asset('images/banner/' . $ad->image) }}" alt="" class="w-100 ">
                                    </div>
                                    <br>
                                    <div class="">
                                        <img src="{{ asset('images/banner/thumbs/' . $ad->image_for_mobile) }}"
                                            alt="" class="w-50 ">
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('backside.super_admin.ads.update', $ad->id) }}" method="post"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="col-12 col-lg-12">
                                    <div class="form-group">
                                        <label id="shop">Image</label>

                                        <input type="file" name="image"
                                            class=" form-control
                                        @error('image')
                                            is-invalid
                                        @enderror">
                                    </div>
                                    {{--                            <div class="form-group mb-2"> --}}
                                    {{--                            <div class="image_area"> --}}
                                    {{--                                    <label for="upload_image" > --}}
                                    {{--                                        <div class="upload-icon"> --}}
                                    {{--                                            <div class="icon-text"> --}}
                                    {{--                                              <div class="text-center"> --}}
                                    {{--                                                  <i class="fas fa-cloud-upload-alt"></i> --}}
                                    {{--                                                  <span class="mb-2">Upload Ad Photo</span> --}}
                                    {{--                                                  <div class="file-invalid d-none"> --}}
                                    {{--                                                      <span class="text-danger font-weight-bolder"> --}}
                                    {{--                                                      <i class="fas fa-exclamation-circle"></i> --}}
                                    {{--                                                        Photo သည် Jpeg (သို့မဟုတ်) JPG (သို့မဟုတ်) PNG ဖြစ်ရမည် --}}
                                    {{--                                                      </span> --}}
                                    {{--                                                  </div> --}}
                                    {{--                                              </div> --}}
                                    {{--                                            </div> --}}
                                    {{--                                            <input type="file" name="image" class="image" id="upload_image" form="createAds" style="display:none"> --}}
                                    {{--                                        </div> --}}
                                    {{--                                    </label> --}}
                                    {{--                                    <div class="remove-img"> --}}
                                    {{--                                        <i class="fas fa-times-circle"></i> --}}
                                    {{--                                    </div> --}}
                                    {{--                                    <img src="" id="uploaded_image" class="img-responsive"/> --}}
                                    {{--                                </div> --}}
                                    {{--                            </div> --}}
                                    <div class="form-group">
                                        <label id="shop">Image For Mobile (500 * 250)</label>
                                        <input type="file" name="image_for_mobile" id=""
                                            class="form-control  @error('image_for_mobile')
                                  is-invalid @enderror">
                                    </div>
                                    <div class="form-group mb-lg-12">
                                        <div class="p-0">
                                            <label id="shop">Select Shop</label>
                                            <select class="form-control select2" style="width: 100%;" id="shop"
                                                name="shop_id">
                                                <!-- <option value="">Choose</option> -->
                                                <option value="">Choose</option>

                                                @foreach ($shops as $shop)
                                                    <option value="{{ $shop->id }}"
                                                        {{ $ad->shop_id == $shop->id ? 'selected' : '' }}>
                                                        {{ $shop->shop_name }}
                                                        ({{ $shop->shop_name_myan }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="linkUrl">Links</label>
                                        <input type="url" name="links" value="{{ $ad->links }}"
                                            class="form-control" id="linkUrl">
                                    </div>
                                    <div class="form-row mb-4">
                                        <div class="col-6">
                                            <label for="start">Start</label>
                                            <p>{{ Carbon::createFromFormat('Y-m-d H:i:s', $ad->start)->format('d M Y (h:i A)') }}
                                            </p>
                                            <div class="input-group date" id="start" data-target-input="nearest">
                                                <input type="text" name="start"
                                                    class="form-control datetimepicker-input" data-target="#start" />
                                                <div class="input-group-append" data-target="#start"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="end">End</label>
                                            <p>{{ Carbon::createFromFormat('Y-m-d H:i:s', $ad->end)->format('d M Y (h:i A)') }}
                                            </p>
                                            <div class="input-group date" id="end" data-target-input="nearest">
                                                <input type="text" name="end"
                                                    class="form-control datetimepicker-input" data-target="#end" />
                                                <div class="input-group-append" data-target="#end"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- form row end  -->
                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn-warning" id="">Update</button>
                                        <a href="{{ route('backside.super_admin.ads.index') }}"
                                            class="btn btn-dark">Cancel</a>
                                    </div>
                                </div>
                            </form>
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
            height: 250px;
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
        $("#updateAd").click(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            e.preventDefault();
            var formData = {
                shop_id: jQuery("select[name=shop_id]").val(),
                start: jQuery("input[name=start]").val(),
                end: jQuery("input[name=end]").val(),
                image: base64data
            }
            $.ajax({
                url: "{{ route('backside.super_admin.ads.update', $ad->id) }}",
                method: "PUT",
                data: formData,
                error: function(err) {
                    // console.warn(err.responseJSON.errors);
                    $('.invalid-feedback').remove();
                    $.each(err.responseJSON.errors, function(i, error) {
                        var al = $(document).find('[name="' + i + '"]');
                        var el = al.parent();
                        var pl = al.parents('div.image_area');
                        pl.addClass('photo-invalid');
                        el.after($('<small class="text-danger font-weight-bolder"> <i class="fas fa-exclamation-circle"></i> ' +
                            error[0] + '</small>'));
                        al.addClass('is-invalid');
                    });
                    $(".create").attr('disabled', false);


                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);

                    } else {
                        alert("Error");
                    }
                    window.location.href = "{{ route('backside.super_admin.ads.index') }}";
                },

            });
            $(".create").attr('disabled', true);


        });
    </script>
@endpush
