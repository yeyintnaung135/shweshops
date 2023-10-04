@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Baydin Detail')

@section('content')
    <div class="wrapper">
        @include('backend.super_admin.navbar')
        @include('backend.super_admin.sidebar')
        <section class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header p-0">
            </section>
            <div class="container p-lg-3 vh-100 ">
                <div class="row">
                    <div class="col-12 p-0 mt-1 p-lg-3">
                        <div class="mb-4">
                            <div class="cover-image">
                                <img src="{{ asset('images/baydin/' . $sign->photo) }}" alt="cover" class="w-100 h-100">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <h3 class="font-weight-bold">{{ $sign->name }}</h3>
                        <div class="time">
                            <p class="time-d mr-3">
                                {!! $sign->description !!}
                            </p>
                            <div class="action mb-4">
                                <a href="{{ route('backside.super_admin.baydins.edit', $sign->id) }}" role="button"
                                    class="btn btn-sm btn-success">Edit</a>
                                <a href="{{ route('backside.super_admin.baydins.index') }}"
                                    class="btn btn-sm btn-outline-dark">Back</a>
                            </div>
                            <div class="action mb-4">
                                <button type="button" onclick="delete_sign('{{ $sign->id }}')"
                                    class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                            </div>
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

@push('css')
    <style>
        /* .my-container {
              position: relative;
              border:1px solid red;
            } */

        .icon {
            cursor: pointer;
            font-size: 20px;
        }

        .cover-image {
            height: 450px;
            cursor: pointer;
        }

        .time {

            height: 100px;
            /* display: flex; */
        }

        .time-d {
            width: 300px;
        }

        .editFormRow {
            padding: 0px;
            width: 100%;
        }

        .line-through {
            text-decoration: line-through;
        }

        .filter {
            filter: grayscale(100%);
        }

        @media screen and (max-width: 726px) {

            /* Ads Detail  */
            .cover-image {
                height: 200px;
                width: 100%;
            }

            .time {
                display: block;
            }

        }
    </style>
@endpush

@push('scripts')
    <script>
        function delete_sign(value) {
            // alert(value);
            swal({
                    title: "Are You Sure Delete",
                    icon: 'warning',
                    buttons: ["No", "Yes"]
                })

                .then((isConfirm) => {

                    if (isConfirm) {

                        $.ajax({
                            type: 'POST',
                            url: '/delete_sign',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "sign_id": value,
                            },

                            success: function() {

                                swal({
                                    title: "Success!",
                                    text: "Successfully Deleted!",
                                    icon: "success",
                                });
                                var url = '{{ route('backside.super_admin.baydins.index') }}';



                                window.location.href = url;
                                setTimeout(function() {
                                    window.location.href = url;
                                }, 1000);


                            },
                        });
                    }
                });
        }
    </script>
@endpush
