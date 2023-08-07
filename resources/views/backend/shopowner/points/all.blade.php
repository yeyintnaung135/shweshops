@extends('layouts.backend.datatable')
@section('content')
    <div class="wrapper">
        @include('layouts.backend.navbar')
        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sn-background-light-blue">
            <!-- Main content -->
            <section class="content pt-3">

                <div id="item-panel-1" class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <span class="card-title">
                                        Add Customer Point
                                    </span>
                                </div>
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>

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
