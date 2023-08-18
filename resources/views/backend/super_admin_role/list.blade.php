@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Admins List')

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
            {{-- <section class="content-header">
                <x-title>All Admin</x-title>
            </section> --}}

            <!-- Main content -->
            <section class="content pt-3">
                {{-- <div class="sn-tab-panel">
                  <ul>
                  <li id="item-tab-1" class="active-panel" onclick="superAdminTabSwitchOne()">Admin List</li>
                  <li id="item-tab-2" onclick="superAdminTabSwitchTwo()">Admin Activity</li>
                  </ul>
              </div> --}}
                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">

                                <!-- /.card-header -->
                                <div class="card shadow-none card-outline card-primary rounded-5  mt-5">
                                    <div class="card-header">
                                        <div class=" d-flex justify-content-between align-items-center">
                                            <h2><i class="fas fa-users"></i> Admins Lists </h2>
                                            <a href="{{ route('backside.super_admin.super_admin_role.create') }}" role="button"
                                                class="btn btn-primary"> Create Admin </a>
                                        </div>
                                    </div>
                                    <div class="card-body p-lg-3">

                                        <table id="superAdminTable" class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <td>id</td>
                                                    <td>Name</td>
                                                    <td>Email</td>
                                                    <td>Role</td>
                                                    <td>Action</td>
                                                    <td>Created Date</td>
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


        $('#superAdminTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backside.super_admin.super_admin_role.getAllAdmins') }}",

            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'role',
                    render: function(data, type, row, meta) {
                        if (row.role == 0 || row.role == 4) {
                            var result = '<span class="font-weight-bolder">SUPER ADMIN</span>'
                        } else if (row.role == 1) {
                            var result = 'sub-admin'
                        } else if (row.role == 3) {
                            var result = `<span class="badge badge-danger">banned</span>`
                        } else {
                            var result = '<span class="badge badge-primary">Request</span>'
                        }
                        return result;
                    }, searchable: false
                },
                {
                    data: 'action',
                    render: function(data, type, row, meta) {
                        if (row.role != 4) {
                            var remove = ``;
                            var remove = `
            @if (Auth::guard('super_admin')->check() && Auth::guard('super_admin')->user()->role == 4)
                <form action="{{ url('backside/super_admin/delete') }}" method="post" >
                  @csrf
                  <input type="hidden" name="id" value=":id">
                  <button class="btn btn-sm btn-danger mr-1" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                </form>
            @endif
                `;
                        } else {
                            var remove = ``;
                        }
                        remove = remove.replace(':id', data);
                        if (row.role == 2 || row.role == 3) {
                            var approve = '';
                            var approve = `
            @if (Auth::guard('super_admin')->check() && Auth::guard('super_admin')->user()->role == 0)
                <form action="{{ route('backside.super_admin.approve', ':id') }}" method="post" >
                  @csrf
                  @method('PUT')
                  <button class="btn btn-sm btn-info mr-1" onclick="return confirm('Are you sure?')"><i class="fas fa-thumbs-up"></i> Approve</button>
                </form>
            @endif
                `;

                        } else {
                            var approve = ``;
                        }
                        approve = approve.replace(':id', data);

                        if (row.role == 1 || row.role == 2) {
                            var ban = '';
                            var ban = `
             @if (Auth::guard('super_admin')->check() && Auth::guard('super_admin')->user()->role == 0)
                <form action="{{ route('backside.super_admin.banned', ':id') }}" method="post">
                  @csrf
                  @method('PUT')
                  <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-ban"></i> Ban </button>
                </form>
              @endif
                `;
                        } else {
                            var ban = ``;
                        }
                        ban = ban.replace(':id', data);

                        if (`{{ Auth::guard('super_admin')->user()->id }}` &&
                            `{{ Auth::guard('super_admin')->user()->id }}` == row.id) {
                            var edit = `
                  <a href="{{ route('backside.super_admin.super_admin_role.edit', ':id') }}">
                    <i class="fas fa-edit"></i>
                  </a>
                `;
                        } else {
                            var edit = ``;
                        }

                        edit = edit.replace(':id', data);

                        return `
           <div class="d-flex">
              ${ edit }
              ${ remove }
           </div>
          `;
                    },orderable: false, searchable: false
                },
                {
                    data: 'created_at',
                }

            ],

            dom: 'lBfrtip',
                "responsive": true,
                "autoWidth": false,
        });
    </script>
@endpush
