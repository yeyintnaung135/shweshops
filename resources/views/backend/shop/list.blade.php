@extends('layouts.backend.datatable')


@section('content')
    <div class="wrapper">
        <!-- Navbar -->
@include('layouts.backend.navbar')
    <!-- /.navbar -->
        <!-- Main Sidebar Container -->
    @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-alert>

            </x-alert>

            <!-- Content Header (Page header) -->
            <section class="content-header">
                
                    <x-title>
                    Shop List
                    </x-title>
                   
               
            </section>

    <!-- Main content -->
    <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="card">
                                <div class="card-header">

                                <div class="row">

                                    <div class="col-sm-11 col-lg-11 col-md-11 col-9">
                                        <h3 class="card-title">DataTable with default features</h3>
                                    </div>

                                    <div class="col-sm-1 col-lg-1 col-md-1 col-3">
                                            <a href="{{route('backside.shops.create')}}" class="btn btn-outline-primary">
                                            <i class="far fa-plus-square"></i>
                                            </a>
                                    </div>
                                   
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="icofont-logout"></i>
                                                Logout
                                            </a>


                                            <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                                                                
                                                                @csrf
                                            </form> 
                                        
                                </div>
                                    
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Shop Name</th>
                                            <th>Title</th>
                                            <th>Desc</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($shops as $shop)
                                            <tr>
                                                <td>{{$shop->id}}</td>
                                                <td>{{$shop->name}}</td>
                                                <td>{{$shop->title}}</td>
                                                <td>{{Str::limit($shop->description, 80)}}</td>
                                                <td><a class="btn btn-sm btn-success" href="{{route('backside.shops.show',['shop'=>$shop->id])}}"><span class="fa fa-info-circle"></span></a> <a class="btn btn-sm btn-primary" href="{{route('backside.shops.edit',['shop' => $shop->id])}}"><span class="fa fa-edit"></span></a>  </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Shop Name</th>
                                            <th>Title</th>
                                            <th>Desc</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    @foreach($shop_owners as $shop_owner)
                                    <img src="{{url($shop_owner->shop_logo)}}" class="product-image" alt="Product Image">
                                    @endforeach
                                    @foreach($shop_owners as $shop_owner)
                                    <img src="{{url($shop_owner->shop_banner)}}" class="product-image" alt="Product Image">
                                    @endforeach
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
