@extends('layouts.backend.super_admin.datatable')
@section('content')
<style>
    .title {
        cursor: pointer;
    }
    .edit-section {
        display : none;
        cursor: pointer;
    }
</style>
  <div class="wrapper">
        <!-- Navbar -->
        @include('backend.pos_super_admin.navbar')
    <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('backend.pos_super_admin.sidebar')

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
                              <div class="card shadow-none card-outline  rounded-5  mt-5">
                                  <div class="card-header">
                                    <div class=" d-flex justify-content-between align-items-center">
                                      <h2><i class="fas fa-users"></i> Admins Lists </h2>
                                      <a href="{{route('pos_super_admin_role.create')}}" role="button" class="btn btn-color"> Create Admin </a>
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
                                      
                                      </tr>
                                   </thead>
                                   <tbody>
                                    <?php $i=1;?>
                                    @foreach ($super_admin as $sup)
                                        <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$sup->name}}</td>
                                        <td>{{$sup->email}}</td>
                                        <td>Super Admin</td>
                                        <td>
                                            @if(Auth::guard('pos_super_admin')->user()->name == $sup->name)
                                            <a href="{{route('pos_super_admin_role.edit',$sup->id)}}" class="btn btn-sm btn-warning mr-1">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            {{-- <a href="{{route('backside.shop_owner.pos.edit_purchase',$sup->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a> --}}
                                            @endif
                                            @if(Auth::guard('pos_super_admin')->user()->created_at == null && Auth::guard('pos_super_admin')->user()->name != $sup->name)
                                            <form action="{{route('pos_super_admin_role.delete',$sup->id)}}" method="post" >
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger mr-1" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                              </form>
                                            @endif
                                        </td>
                                        </tr>
                                    @endforeach
                                   </tbody>
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
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io" class="text-color">MOE</a>.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
@endsection
@push("scripts")
  <script>
    $('#superAdminTable').DataTable({
                    dom: 'Blfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    processing: true,
                    "ordering": true,
                    "info": true,
                    "paging": true,
                });
  </script>
@endpush
@push('css')
    <style>

        .btn-color{
        background-color: #780116;
        color: white;
    }
    .btn-color:hover{
            color: white;
        }
    .text-color{
        color: #780116;
    }

    </style>
@endpush