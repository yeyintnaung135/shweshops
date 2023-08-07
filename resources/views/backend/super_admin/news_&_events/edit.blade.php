@extends('backend.super_admin.layout')
@section('content')
    <div class="wrapper">
        @include('backend.super_admin.navbar')
        @include('backend.super_admin.sidebar')
        <section class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title>Edit Post</x-title>
            </section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="p-3 ">
                            <div class="card card-default">
                                <!-- form start -->
                                <div class="card-body p-4">
                                    <div class="row mb-4">
                                        <!-- <div class="col-md-4">&nbsp;</div> -->
                                        <div class="col-12">
                                            <div class="image_area bg-secondary">

                                                <label for="upload_image">
                                                    <div class="p-5 d-flex justify-content-center align-items-center">
                                                        <i class="fas fa-cloud-upload-alt"></i>Upload Photo
                                                    </div>
                                                    <img src="{{ asset('images/news/' . $news->image) }}" id="uploaded_image"
                                                        class="img-responsive" />
                                                    <div class="overlay rounded-0">
                                                        <div class="text">Click to Change Cover Photo</div>
                                                    </div>
                                                    <input type="file" name="photo" class="image" id="upload_image"
                                                        style="display:none">
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ old('title', $news->title) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Promotion Date</label>
                                        <div class="form-row">
                                            <div class="form-group col-6 col-md-2">
                                                <label for="from">From</label> <br>
                                                <span>{{ $news->from }}</span>
                                                <input type="date" class="form-control" name="from" id="from"
                                                    placeholder="dd-mm-yyyy" value="{{ $news->from }}">
                                            </div>
                                            <div class="form-group col-6 col-md-2">
                                                <label for="to">To</label><br>
                                                <span>{{ $news->to }}</span>
                                                <input type="date" class="form-control" name="to" id="to"
                                                    placeholder="dd-mm-yyyy">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" id="description" rows="15">{{ $news->description }}</textarea>
                                    </div>
                                    <a href="{{ route('backside.super_admin.news.index') }}"
                                        class="btn btn-outline-dark float-right ml-2">Back</a>
                                    <button class="btn btn-primary float-right" id="btn" type="submit"><span
                                            class="fa fa-paper-plane"></span>&nbsp;&nbsp;Update </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal section  -->
    <div class="modal" tabindex="-1" id="modal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img src="" id="sample_image" />
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/dropzone"></script>
    <script src="https://unpkg.com/cropperjs"></script>
    <script>
        $(document).ready(function() {
            var $modal = $('#modal');
            var image = document.getElementById('sample_image');
            var cropper;
            var base64data = [];
            $('#upload_image').change(function(event) {
                var files = event.target.files;
                var done = function(url) {
                    image.src = url;
                    $modal.modal('show');
                };
                // console.log(files);
                if (files && files.length > 0) {

                    reader = new FileReader();
                    reader.onload = function(event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);

                }
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 0,
                    viewMode: 4,
                    preview: '.preview'
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            });


            $("#crop").click(function() {
                canvas = cropper.getCroppedCanvas({
                    width: 800,
                    height: 400,
                });
                canvas.toBlob(function(blob) {
                    // url = URL.createObjectURL(blob);
                    var reader = new FileReader();

                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        base64data = reader.result;

                        $('#uploaded_image').attr('src', base64data);
                        $modal.modal('hide');

                    }
                });
            });

            $("#btn").click(function(e) {

                e.preventDefault();
                $.ajax({
                    url: "{{ URL('backside/super_admin/news/' . $news->id) }}",
                    method: "PATCH",
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        'title': jQuery("input[name=title]").val(),
                        'from': jQuery("input[name=from]").val(),
                        'to': jQuery("input[name=to]").val(),
                        'description': jQuery("textarea[name=description]").val(),
                        'image': base64data,
                    },

                    error: function(err) {
                        //console.log(err.responseText)
                        // you can loop through the errors object and show it to the user
                        console.warn(err.responseJSON.errors);
                        // display errors on each form field
                        $('.invalid-feedback').remove();
                        $.each(err.responseJSON.errors, function(i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            $(".image_area").removeClass('bg-secondary');
                            $(".image_area").addClass('bg-danger');
                            el.after($('<span class="invalid-feedback">' + error[0] +
                                '</span>'));
                            el.addClass('is-invalid');


                        });

                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                        } else {
                            alert("Error");
                        }
                        window.location.reload();
                    },

                });
            });



        });
    </script>
@endpush
