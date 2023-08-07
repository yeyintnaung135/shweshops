@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Baydin List')

@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('backend.super_admin.navbar')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('backend.super_admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-alert> </x-alert>

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title>All Baydins</x-title>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="card">
                                <div class="card-header">
                                    <a href=" {{ route('baydins.create') }} " class="btn btn-primary">Add Baydin</a>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="newsTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Photo</th>
                                                <th>Sign Logo</th>
                                                <th>Sign</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Credit</th>
                                                <th>Action</th>
                                                <!-- <th>Created Date</th> -->
                                                <!--<th>Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($signs as $sign)
                                                <tr>
                                                    <td class="w-25">{{ $sign->id }}</td>
                                                    <td class="w-25"><img class="rounded-5 shadow-sm"
                                                            src="{{ '/images/baydin/' . $sign->photo }}" alt=""
                                                            width="150px" height="60px" /></td>
                                                    <td class="w-25"><img class="center rounded-5 shadow-sm"
                                                            src="{{ '/images/baydin/sign/' . $sign->sign_logo }}"
                                                            alt="" width="70px" height="60px" /></td>
                                                    <td class="w-25">{{ $sign->name }}</td>
                                                    <td class="w-25">{{ $sign->title }}</td>
                                                    <td maxlength="50" class="w-25">{!! $sign->description !!}</td>
                                                    <td maxlength="50" class="w-25">{{ $sign->credit }}</td>
                                                    <td class="w-25">
                                                        <div class="title">
                                                            <div class="edit-section p-2 ">
                                                                <div
                                                                    class="d-block d-lg-flex align-items-center justify-content-around">
                                                                    <a href="{{ route('baydins.edit', $sign->id) }}"
                                                                        class="btn btn-sm btn-info"><i
                                                                            class="far fa-edit"></i></a> |

                                                                            <button type="button" onclick="delete_sign('delete_sign', '{{ $sign->id }}')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>


                                                                    | <a href="{{ route('baydins.show', $sign->id) }}"
                                                                        class="btn btn-sm btn-warning"><i
                                                                            class="far fa-eye"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <!-- <td class="w-25">{{ $sign->created_at }}</td> -->
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Photo</th>
                                                <th>Sign Logo</th>
                                                <th>Sign</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Credit</th>
                                                <th>Action</th>
                                                <!-- <th>Created Date</th> -->
                                                <!--<th>Action</th> -->
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
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
    <style>
        .title {
            cursor: pointer;
        }

        .edit-section {
            /* display : none; */
            cursor: pointer;
        }

        .w-25 p {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(function() {

            $("#post").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"],
                // 'columnDefs': [
                //     { responsivePriority: 1, targets: 0 },
                //     { responsivePriority: 2, targets: 4 },
                //     { responsivePriority: 3, targets: 2 },
                //     { responsivePriority: 4, targets: 1},
                // ],
                "order": [0, 'desc']
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#newsTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $(".title").click(function(e) {
                $(e.target).children().toggle(500);
            });

        });

        function delete_sign(deleteUrl, value) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-danger ml-2',
                    cancelButton: 'btn btn-info'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: deleteUrl,
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "sign_id": value,
                        },
                        success: function() {
                            swalWithBootstrapButtons.fire({
                                title: 'Success!',
                                text: 'Successfully Deleted!',
                                icon: 'success'
                            });
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    });
                }
            });
        }
    </script>
@endpush
@push('css')
    <style>
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }

        @media only screen and (max-width: 1240px) {
            .center {
                width: 60%;
            }
        }

        @media only screen and (max-width: 1145px) {
            .center {
                width: 77%;
            }
        }

        @media only screen and (max-width: 1080px) {
            .center {
                width: 80%;
            }
        }
    </style>
@endpush
