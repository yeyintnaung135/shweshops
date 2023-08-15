@extends('layouts.backend.backend')


@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.backend.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">


            @foreach ($shopowner as $shopowner)
                <div class="sn-shop-header d-sm-none">{{ $shopowner->shop_name }}</div>
            @endforeach

            <!-- Main content -->
            <div class="row justify-content-center">
                <div class="card col-9 col-lg-6 card-outline card-primary mt-5">
                    <div class="card-header">Create Template</div>
                    <div class="card-body">
                        <form>
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-12">
                                    <label for="a-1" class="col-form-label">Template Name</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" min=0 class="form-control" name="name" id="a-1"
                                        value="{{ $template->name }}">
                                </div>
                            </div>


                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-12">
                                    <label for="a-2" class="col-form-label">အထည်မပျက် ပြန်သွင်း %</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" min=0 class="form-control" name="undamaged_product" id="a-2"
                                        value="{{ $template->undamaged_product }}">
                                </div>
                            </div>
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-12">
                                    <label for="a-3" class="col-form-label">အထည်ပျက်စီး ချို့ယွင်း %</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" min=0 class="form-control" name="damaged_product" id="a-3"
                                        value="{{ $template->damaged_product }}">
                                </div>
                            </div>
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-12">
                                    <label for="a-4" class="col-form-label">တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲ
                                        %</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" min=0 class="form-control" name="valuable_product" id="a-4"
                                        value="{{ $template->valuable_product }}">
                                </div>
                            </div>
                        </form>
                        <button class="btn btn-primary templateUpdate">Update</button>

                    </div>
                </div>
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
@push('scripts')
    <script>
        $('.templateUpdate').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('backside.shop_owner.items.template.update', [$template->id]) }}",
                method: "PATCH",
                data: {
                    _token: '{{ csrf_token() }}',

                    name: jQuery("input[name=name]").val(),
                    undamaged_product: jQuery("input[name=undamaged_product]").val(),
                    damaged_product: jQuery("input[name=damaged_product]").val(),
                    valuable_product: jQuery("input[name=valuable_product]").val(),
                },
                error: function(err) {
                    console.warn(err.responseJSON.errors);
                    $.each(err.responseJSON.errors, function(i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<span class="invalid-feedback">' + error[0] + '</span>'));
                        el.addClass('is-invalid');
                    });

                },
                success: function(response) {
                    $('.templateUpdate').attr('disabled', 'disabled');
                    if (response.success) {
                        alert(response.message);
                        window.location.href = "{{ route('backside.shop_owner.items.template.list') }}";

                    } else {
                        alert("Error");
                    }

                },

            });
        })
    </script>
@endpush
