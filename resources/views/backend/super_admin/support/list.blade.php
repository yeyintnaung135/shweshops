@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Videos')

@section('content')
    <div class="wrapper">
        @include('backend.super_admin.loading')
        <!-- Navbar -->
        @include('backend.super_admin.navbar')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('backend.super_admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-alert></x-alert>

            <!-- Main content -->
            <section class="content pt-3">
                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">

                                <!-- /.card-header -->
                                <div class="card shadow-none card-outline card-primary rounded-5  mt-5">
                                    <div class="card-header">
                                        <div class=" d-flex justify-content-between align-items-center">
                                            <h2><i class="nav-icon fas fa-toolbox"></i> Support Video Lists </h2>
                                            <a href="{{ url('backside/super_admin/support/create') }}" role="button"
                                                class="btn btn-primary"> Create Support </a>
                                        </div>
                                    </div>

                                    <div class="card-body p-lg-3">

                                        <table id="superAdminTable" class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <td>Id</td>
                                                    <td>Title</td>
                                                    <td>Category</td>
                                                    <td>Video</td>
                                                    <td>Action</td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content -->
        {{-- </div> --}}
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0-rc
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">MOE</a>.</strong> All rights
            reserved.
        </footer>

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
            display: none;
            cursor: pointer;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $("#loader").hide();


        //Datatable
        $('#superAdminTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backside.super_admin.support.get_all_support') }}",

            columns: [{
                    data: 'id'
                },
                {
                    data: 'title'
                },
                {
                    data: 'category'
                },
                {
                    data: 'video',
                    render: function(data, type) {
                        return `<iframe width="300" height="200" src="${data}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
                    }
                },
                {
                    data: 'action',
                    render: function(data, type) {
                        var detail =
                            `
                    <a href="{{ url('backside/super_admin/support/detail/' . ':action') }}" class="btn btn-sm btn-warning mr-2">
                     <i class="far fa-eye"></i>
                    </a>
                    `;
                        var detail = detail.replace(':action', data);

                        var edit =
                            `
                    <a href="{{ url('backside/super_admin/support/edit/' . ':action') }}" class="btn btn-sm btn-info mr-2">
                    <i class="far fa-edit"></i>
                   </a>
                    `;
                        var edit = edit.replace(':action', data);

                        var del = `<form id='formdel' action="{{ url('backside/super_admin/support/delete/' . ':action') }}" method="POST">
                    @csrf
                    <button type="button" class="btn btn-sm btn-danger" onclick="Delete(this)"><i class="fas fa-trash-alt"></i></button>
                  </form>
                `;
                        var del = del.replace(':action', data);
                        return `
                    <div class="d-flex">
                    ${detail + edit + del}
                    </div>
                `;

                    }
                },
                {
                    data: 'created_at'
                }

            ],
            dom: 'lBfrtip',
                "responsive": true,
                "autoWidth": false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });


        function get(obj) {
            return document.getElementById(obj);
        }

        function itemTab_Panel(tab_active, tab2, panel_remove, panel2) {
            get(tab_active).classList.add("active-panel");
            get(tab2).classList.remove("active-panel");

            get(panel_remove).classList.remove("sn-panel-hide");
            get(panel2).classList.add("sn-panel-hide");
        }

        function superAdminTabSwitchOne() {
            itemTab_Panel("item-tab-1", "item-tab-2", "item-panel-1", "item-panel-2");
        }

        function superAdminTabSwitchTwo() {
            itemTab_Panel("item-tab-2", "item-tab-1", "item-panel-2", "item-panel-1");
        }

        function Delete(e) {
            $(function() {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-danger ml-2',
                        cancelButton: 'btn btn-info'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Do it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(e.form).submit();
                    }
                })
            });
        }
    </script>
@endpush
