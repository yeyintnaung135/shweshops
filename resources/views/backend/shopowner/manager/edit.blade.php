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

            <!-- zhheader shopname -->
            <x-header>
                @foreach ($shopowner as $shopowner)
                    {{ $shopowner->shop_name }}
                @endforeach
            </x-header>
            <!-- end zh header shopname -->

            <!-- Content Header (Page header) -->
            <x-title>
                User Create
            </x-title>
            @csrf
            <!-- Main content -->

            <section class="content">

                {{ Form::model($shopowner, ['route' => ['backside.shop_owner.managers.update', $manager->id], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                @csrf {{-- cross site request forgery --}}
                @method('PUT')
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        @csrf

                        <div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label>User Name </label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                name="name" placeholder="Enter name" required
                                                value="{{ $manager->name }}" />
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label>Phone-no </label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                name="phone" placeholder="Enter Phone-no" required
                                                value="{{ $manager->phone }}" />
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select class="form-control select2" name="role_id" style="width: 100%">

                                                @foreach ($role as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ $manager->role_id == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="d-none d-sm-block">&nbsp </label>

                                        <button class="btn btn-primary float-right float-sm-none" type="submit"><span
                                                class="fa fa-paper-plane"></span>&nbsp;&nbsp;Edit
                                        </button>

                                    </div>
                                    <!--                            <Ykweight v-on:forparent="getdatafromykweight"></Ykweight>-->


                                </div>


                                <br />

                            </div>
                            <!-- /.FORM END -->


                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                {!! Form::close() !!}
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
