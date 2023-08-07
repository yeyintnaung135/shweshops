@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Baydin Create')

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
                <x-title>Create Baydin</x-title>
            </section> --}}

            <!-- Main content -->
            <section class="content pt-3">

                <div class="container">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">

                                <!-- /.card-header -->
                                <div class="card shadow-none card-outline card-primary rounded-5 pb-2 mt-5">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h2><i class="fas fa-user"></i> Create Baydin </h2>
                                            <a href="{{ route('baydins.index') }}"> <i class="fas fa-list"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body p-lg-5">
                                        <form method="POST" action="{{ route('baydins.store') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Sign</label>

                                                <select class="form-select" aria-label="Default select example"
                                                    name="name" class="form-control @error('name') is-invalid @enderror"
                                                    id="exampleInputName" aria-describedby="nameHelp">
                                                    <option selected>Select Sign</option>
                                                    <option value="Aries">Aries</option>
                                                    <option value="Gemini">Gemini</option>
                                                    <option value="Cancer">Cancer</option>
                                                    <option value="Leo">Leo</option>
                                                    <option value="Virgo">Virgo</option>
                                                    <option value="Libra">Libra</option>
                                                    <option value="Scorpion">Scorpion</option>
                                                    <option value="Sagitarius">Sagitarius</option>
                                                    <option value="Capricorn">Capricorn</option>
                                                    <option value="Aquarius">Aquarius</option>
                                                    <option value="Pisces">Pisces</option>
                                                    <option value="Taurus">Taurus</option>
                                                </select>
                                                @error('name')
                                                    <span class="font-weight-bold text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Title</label>
                                                <input value="{{ old('title') }}" name="title"
                                                    class="form-control @error('title') is-invalid @enderror" id=""
                                                    placeholder="Enter title">
                                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                @error('title')
                                                    <span class="font-weight-bold text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Photo</label>
                                                <input type="file" value="hello" name="photo"
                                                    class="form-control @error('photo') is-invalid @enderror"
                                                    id="exampleInputPhoto" aria-describedby="nameHelp"
                                                    placeholder="Enter photo">
                                                @error('photo')
                                                    <span class="font-weight-bold text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Sign Logo</label>
                                                <input type="file" value="{{ old('sign_logo') }}" name="sign_logo"
                                                    class="form-control @error('sign_logo') is-invalid @enderror"
                                                    id="exampleInputPhoto" aria-describedby="nameHelp"
                                                    placeholder="Enter sign logo">
                                                @error('sign_logo')
                                                    <span class="font-weight-bold text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Description</label>
                                                <textarea value="{{ old('description') }}" name="description"
                                                    class="ckeditor form-control @error('description') is-invalid @enderror" id=""
                                                    placeholder="Enter description"></textarea>
                                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                @error('description')
                                                    <span class="font-weight-bold text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Credit</label>
                                                <input value="{{ old('credit') }}" name="credit"
                                                    class="form-control @error('credit') is-invalid @enderror"
                                                    id="" placeholder="Enter credit">
                                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                @error('credit')
                                                    <span class="font-weight-bold text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Create') }}
                                            </button>
                                        </form>
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
                <!-- <div id="item-panel-2">
                          <p class="mt-5 text-center pt-5">Coming Soon ...</p>
                      </div> -->
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content -->
    </div>
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
    <script src="//cdn.ckeditor.com/4.19.0/full/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>
@endpush
