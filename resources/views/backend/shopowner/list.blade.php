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

            {{-- <x-title>
            Items list
        </x-title> --}}
            <!-- Main content -->
            <section class="content pt-3">
                <div class="sn-tab-panel">
                    <ul>
                        <li id="item-tab-1" class="active-panel" onclick="itemTabSwitchOne()">Item List</li>
                        <li id="item-tab-2" onclick="itemTabSwitchTwo()">Item Activity</li>
                    </ul>
                </div>
                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">
                                {{-- <div class="card-header">
                                <h3 class="card-title">DataTable with default features</h3>
                            </div> --}}
                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5">
                                    <div class="card-header border-0">
                                        <h2>Today’s Update Products</h2>
                                        <p>Check your store’s daily updates</p>
                                    </div>
                                    <table id="shopownerItemList" class="table table-borderless mt-2">
                                        <thead>
                                            <tr>
                                                <td>ID</td>
                                                <td>Item Name</td>
                                                <td>Desc</td>
                                                <td>Price</td>
                                                <td>Action</td>
                                                <td>Created Date</td>
                                            </tr>
                                        </thead>
                                        {{-- <tbody>
                                        @php $i=1; @endphp
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$item->name}}</td>
                                                <td>{{Str::limit($item->description, 80)}}</td>
                                                <td>{{$item->price}}</td>
                                                <td><a class="btn btn-sm btn-success" href="{{route('backside.shop_owner.items.show',['item'=>$item->id])}}"><span class="fa fa-info-circle"></span></a> <a class="btn btn-sm btn-primary" href="{{route('backside.shop_owner.items.edit',['item' => $item->id])}}"><span class="fa fa-edit"></span></a>  </td>
                                            </tr>
                                        @endforeach

                                        </tbody> --}}
                                        <tfoot>
                                            <tr>
                                                <td>ID</td>
                                                <td>Item Name</td>
                                                <td>Desc</td>
                                                <td>Price</td>
                                                <td>Action</td>
                                                <td>Created Date</td>
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
                <div id="item-panel-2" class="sn-panel-hide">
                    <p class="mt-5 text-center pt-5">Coming Soon ...</p>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        {{-- @include('layouts.backend.footer') --}}

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
@endsection

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

        function itemTabSwitchOne() {
            itemTab_Panel("item-tab-1", "item-tab-2", "item-panel-1", "item-panel-2");
        }

        function itemTabSwitchTwo() {
            itemTab_Panel("item-tab-2", "item-tab-1", "item-panel-2", "item-panel-1");
        }
    </script>
@endpush
