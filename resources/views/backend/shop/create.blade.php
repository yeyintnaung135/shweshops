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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Shops</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Shops</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Create Your Shop</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{url('backside/shops')}}" method="post" enctype="multipart/form-data">
                <div class="card-body">

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="shopname">Shop Name</label>
                    <input type="text" class="form-control" id="shopname" placeholder="Enter shop name" name="name">
                    @error('name')
                    <x-error>
                        {{$message}}
                    </x-error>
                    @enderror
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" placeholder="Enter title" name="title">
                    @error('title')
                    <x-error>
                        {{$message}}
                    </x-error>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" rows="3" placeholder="Enter ...">
                                                {{old('description')}}
                    </textarea>
                    @error('description')
                    <x-error>
                        {{$message}}
                    </x-error>
                    @enderror
                  </div>
                </div>


                  <div class="col-sm-6">

                      <div class="form-group">
                          <label for="exampleInputFile">Photo One</label>
                          <div class="input-group">
                              <div class="custom-file">
                                  <input type="file" name='photoone' class="custom-file-input" id="exampleInputFile">
                                  <label class="custom-file-label" for="exampleInputFile">Choose
                                      file</label>
                              </div>

                          </div>
                          @error('photoone')
                          <x-error>
                              {{$message}}
                          </x-error>
                          @enderror
                      </div>
                  </div>
                </div>


                <div class="row">
                <div class="col-sm-6">

                        <div class="form-group">
                            <label for="exampleInputFile">Photo Two</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name='phototwo' class="custom-file-input" id="exampleInputFile2">
                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                        file</label>
                                </div>


                            </div>
                            @error('phototwo')
                            <x-error>
                                {{$message}}
                            </x-error>
                            @enderror
                        </div>
                  </div>

                 <div class="col-sm-6">

                    <div class="form-group">
                        <label for="exampleInputFile">Photo Three</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name='photothree' class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose
                                    file</label>
                            </div>

                        </div>
                        @error('photothree')
                        <x-error>
                            {{$message}}
                        </x-error>
                        @enderror
                    </div>
                </div>
              </div>
                <br>
                <!-- /.card-body -->

                <div class="row">
                  <div class="col-6 col-md-8">&nbsp;</div>
                  @csrf

                  <div class="col-6 col-md-4">
                      <button class="btn btn-primary float-right" type="submit"><span class="fa fa-paper-plane"></span>&nbsp;&nbsp;Submit form</button>
                  </div>
              </div>

              </form>
            </div>
      </div>
    </section>
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
@push('scripts')
    <script src="{{url('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endpush