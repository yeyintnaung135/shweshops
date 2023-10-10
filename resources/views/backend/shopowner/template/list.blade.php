@extends('layouts.backend.datatable')
@section('content')
    <div class="wrapper">
        @include('layouts.backend.navbar')

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sn-background-light-blue">
            <!-- Content Header (Page header) -->
            @if (Session::has('message'))
                <x-alert>

                </x-alert>
            @endif
            <!-- zhheader shopname -->
            {{-- <x-header>
        @foreach ($shopowner as $shopowner)
                @endforeach
                {{$shopowner->shop_name}}
        </x-header> --}}
            <!-- end zh header shopname -->
            {{-- <x-title>
            Items list
        </x-title> --}}
            <!-- Main content -->
            <section class="content pt-3">
                {{-- <div class="sn-tab-panel">
                  <ul>
                    <li id="item-tab-1" class="active-panel" onclick="itemTabSwitchOne()">Item List</li>
                    <li id="item-tab-2" onclick="itemTabSwitchTwo()">Item Activity</li>
                  </ul>
                </div> --}}
                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">
                                <div class="border-bottom-0 mt-4 mr-2">
                                    <a href="{{ route('backside.shop_owner.items.template.create') }}"
                                        class="btn btn-primary float-right"><span
                                            class="fa fa-plus-circle"></span>&nbsp;&nbsp;Add
                                        New Template
                                    </a>
                                    <br><br>
                                </div>
                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2">
                                    <div class="card-header">


                                        <div class="">
                                            <h2>Template Lists
                                                @include('backend.shopowner.toottips')
                                            </h2>
                                            <p>Check your templates</p>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <table id="templateTable" class="table table-borderless mt-3">
                                            <thead>
                                                <tr>
                                                    <td>ID</td>
                                                    <td>Name</td>
                                                    <td>Undamaged Product</td>
                                                    <td>Damaged Product</td>
                                                    <td>Valuable_product</td>
                                                    <td>Action</td>
                                                    <td>date</td>
                                                </tr>
                                            </thead>
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
                </div>
                {{-- <div id="item-panel-2">
              <p class="mt-5 text-center pt-5">Coming Soon ...</p>
            </div> --}}
                <!-- /.container-fluid -->
            </section>
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
        $('#templateTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backside.shop_owner.template.get_template') }}",

            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'undamaged_product'
                },
                {
                    data: 'damaged_product'
                },
                {
                    data: 'valuable_product'
                },
                {
                    data: 'action',
                    render: function(data, type) {
                        var info =
                            `<a style="margin-right: 5px;" class="btn btn-sm btn-danger" href="{{ route('backside.shop_owner.template.destroy', ['id' => ':id']) }}"><span class="fa fa-trash"></span></a>`;
                        info = info.replace(':id', data);
                        var edit =
                            `<a class="btn btn-sm btn-primary" href="{{ route('backside.shop_owner.template.edit', ['id' => ':id']) }}"><span class="fa fa-edit"></span></a>`;
                        edit = edit.replace(':id', data);
                        return info + edit;
                    }
                },
                {
                    data: 'created_at'
                }

            ],
            order: [
                [6, 'desc']
            ],
        });
    </script>
@endpush
