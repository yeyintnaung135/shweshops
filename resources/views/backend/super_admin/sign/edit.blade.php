@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Baydin Edit')

@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('backend.super_admin.navbar')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('backend.super_admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-alert></x-alert>

            <!-- Content Header (Page header) -->

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
                                            <h2><i class="fas fa-edit"></i> Edit Baydin </h2>
                                            <a href="{{ route('backside.super_admin.super_admin_role.list') }}"> <i
                                                    class="fas fa-list"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body p-lg-5">
                                        <form method="POST"
                                            action="{{ route('backside.super_admin.baydins.update', $sign->id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Sign</label>

                                                <select class="form-select" aria-label="Default select example"
                                                    name="name" class="form-control @error('name') is-invalid @enderror"
                                                    id="exampleInputName" aria-describedby="nameHelp">
                                                    <option selected>{{ $sign->name }}</option>
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
                                                <input value="{{ old('title', $sign->title) }}" name="title"
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
                                                <input type="file" value="{{ old('photo', $sign->photo) }}"
                                                    name="photo" class="form-control @error('photo') is-invalid @enderror"
                                                    id="exampleInputPhoto" aria-describedby="nameHelp"
                                                    placeholder="Enter photo">
                                                <div class="old_photo">
                                                    <label for="exampleInputEmail1">Old Photo</label>
                                                    <img class="rounded-5 shadow-sm"
                                                        src="{{ '/images/baydin/' . $sign->photo }}" alt=""
                                                        width="150px" height="60px" />
                                                </div>

                                                @error('photo')
                                                    <span class="font-weight-bold text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Sign Logo</label>
                                                <input type="file" value="{{ old('sign_logo,$sign->sign_logo') }}"
                                                    name="sign_logo"
                                                    class="form-control @error('sign_logo') is-invalid @enderror"
                                                    id="exampleInputPhoto" aria-describedby="nameHelp"
                                                    placeholder="Enter sign logo">
                                                <div class="old_photo">
                                                    <label for="exampleInputEmail1">Old Sign Logo</label>
                                                    <img class="rounded-5 shadow-sm"
                                                        src="{{ '/images/baydin/sign/' . $sign->sign_logo }}"
                                                        alt="" width="70px" height="60px" />
                                                </div>
                                                @error('sign_logo')
                                                    <span class="font-weight-bold text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Description</label>
                                                <textarea name="description" class="ckeditor form-control @error('description') is-invalid @enderror" id=""
                                                    placeholder="Enter description">{!! $sign->description !!}
                                            </textarea>
                                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                @error('description')
                                                    <span class="font-weight-bold text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Credit</label>
                                                <input name="credit"
                                                    class="form-control @error('credit') is-invalid @enderror"
                                                    id="" placeholder="Enter credit"
                                                    value="{{ $sign->credit }}">
                                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                @error('credit')
                                                    <span class="font-weight-bold text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Update') }}
                                            </button>

                                    </div>

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

        .old_photo {
            margin-top: 2%;
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
