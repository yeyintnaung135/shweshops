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
          <!-- left column -->

            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Edit Your Shop</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {{ Form::model($shop, ['route' => ['backside.shops.update', $shop->id], 'method' => 'put','enctype' => 'multipart/form-data']) }}

              @csrf {{-- cross site request forgery --}}
	                                @method('PUT')


                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="shopname">Shop Name</label>
                        <input type="text" class="form-control" id="shopname" placeholder="Enter shop name" name="name" value="{{$shop->name}}">
                        @error('name')
                        <x-error>
                            {{$message}}
                        </x-error>
                        @enderror

                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" placeholder="Enter title" name="title" value="{{$shop->title}}">
                        @error('title')
                        <x-error>
                            {{$message}}
                        </x-error>
                        @enderror

                      </div>
                    </div>
                 </div>

                 <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" name="description" rows="3"
                                                  placeholder="Enter ...">
                                                  {{$shop->description}}
                                            </textarea>
                      @error('description')
                      <x-error>
                          {{$message}}
                      </x-error>
                      @enderror

                    </div>
                  </div>

                    <!-- photoone -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputFile">Photo One</label>
                      <div class="input-group">


                      <div class="col-sm-10">
                          <nav>
                              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                              <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Old Photo</a>
                              <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">New Photo</a>

                              </div>
                          </nav>
                          <div class="tab-content" id="nav-tabContent">
                              <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                              <img src="{{asset($shop->photoone)}}" class="img-fluid" style="width: 70px;">

                              </div>
                              <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                  <input type="file" id="photoone_id" name="photoone">
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
                  </div>
                </div>


                  <!-- photo two -->
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputFile">Photo Two</label>
                    <div class="input-group">
                        <div class="col-sm-10">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-hometwo" role="tab" aria-controls="nav-home" aria-selected="true">Old Photo</a>
                                <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profiletwo" role="tab" aria-controls="nav-profiletwo" aria-selected="false">New Photo</a>

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-hometwo" role="tabpanel" aria-labelledby="nav-home-tab">

                                <img src="{{asset($shop->phototwo)}}" class="img-fluid" style="width: 70px;">

                                </div>
                                <div class="tab-pane fade" id="nav-profiletwo" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <input type="file" id="phototwo_id" name="phototwo">
                                </div>

                            </div>
                            @error('phototwo')
                            <x-error>
                                {{$message}}
                            </x-error>
                            @enderror

                        </div>
                    </div>
                  </div>
                </div>

                  <!-- photo three -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputFile">Photo Three</label>
                    <div class="input-group">
                        <div class="col-sm-10">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-homethree" role="tab" aria-controls="nav-home" aria-selected="true">Old Photo</a>
                                <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profilethree" role="tab" aria-controls="nav-profilethree" aria-selected="false">New Photo</a>

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-homethree" role="tabpanel" aria-labelledby="nav-home-tab">

                                <img src="{{asset($shop->photothree)}}" class="img-fluid" style="width: 70px;">

                                </div>
                                <div class="tab-pane fade" id="nav-profilethree" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <input type="file" id="photothree_id" name="photothree">
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
                    <div class="row">
                        <div class="col-6 col-md-8">&nbsp;</div>
                        @csrf

                        <div class="col-6 col-md-4">
                            <button class="btn btn-primary float-right" type="submit"><span
                                    class="fa fa-paper-plane"></span>&nbsp;&nbsp;Submit form
                            </button>
                        </div>
                    </div>
                </div>
                </div>
                </div>
                <!-- /.card-body -->
                {!! Form::close() !!}
            </div>
            <!-- /.card -->

            <!-- general form elements -->

          <!--/.col (left) -->
          <!-- right column -->

          <!--/.col (right) -->

        <!-- /.row -->
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
@push('scripts')
    <script src="{{url('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endpush
