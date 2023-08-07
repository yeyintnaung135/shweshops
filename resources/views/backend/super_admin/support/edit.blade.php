@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Video Edit')

@section('content')
    <div class="wrapper">
        @include('backend.super_admin.loading')
        <!-- Navbar -->
        @include('backend.super_admin.navbar')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('backend.super_admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-alert></x-alert>

            <!-- Content Header (Page header) -->
            {{-- <section class="content-header">
            <x-title>Create Admin</x-title>
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
                                            <h2><i class="nav-icon fas fa-toolbox"></i> Edit Support </h2>
                                            <a href="{{ url('/backside/super_admin/support/list') }}"> <i
                                                    class="fas fa-list"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body p-lg-5">
                                        <form method="POST"
                                            action="{{ url('backside/super_admin/support/update/' . $tooltip->id) }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Title</label>
                                                <input type="text" value="{{ old('title', $tooltip->title) }}"
                                                    name="title"
                                                    class="form-control @error('endpoint') is-invalid @enderror"
                                                    id="exampleInputName" aria-describedby="nameHelp" required>
                                                @error('title')
                                                    <span class="font-weight-bold text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Video</label>
                                                <textarea class="form-control sop-form-control" rows="4" name="video">{{ $tooltip->video }}</textarea>
                                                @error('video')
                                                    <span class="font-weight-bold text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="state">For User Or Shop Owner<span
                                                        style="color: red;">*</span></label>
                                                <select id="state" name="for_what"
                                                    class="form-control @error('for_what') is-invalid @enderror" required>
                                                    @if ($tooltip->for_what == 'for_so')
                                                        <option value="for_so" selected>For Shop Owner</option>
                                                        <option value="for_user">For User</option>
                                                    @else
                                                        <option value="for_user" selected>For User</option>
                                                        <option value="for_so">For Shop Owner</option>
                                                    @endif
                                                </select>

                                                @error('for_what')
                                                    <x-error>
                                                        {{ $message }}
                                                    </x-error>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="state">State<span style="color: red;">*</span></label>
                                                <select id="state" name="cat_id"
                                                    class="form-control @error('cat_id') is-invalid @enderror" required>
                                                    @foreach ($cats as $c)
                                                        @if ($tooltip->cat_id == $c->id)
                                                            <option value="{{ $c->id }}" selected>{{ $c->title }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $c->id }}">{{ $c->title }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>

                                                @error('cat_id')
                                                    <x-error>
                                                        {{ $message }}
                                                    </x-error>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Update') }}
                                            </button>

                                            <a href="{{ url('backside/super_admin/support/list') }}"
                                                class="btn btn-outline-dark"> back</a>
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
    </style>
@endpush

@push('scripts')
    <script>
        $("#loader").hide();
        $(function() {
            // Summernote
            $('#summernote').summernote({
                toolbar: [
                    ['style', ['style']],
                    ['fontsize', ['fontsize']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['picture', 'hr']],
                    ['table', ['table']]
                ],
                fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36', '48', '64', '82',
                    '150'
                ],
                tabsize: 2,
                height: 400,
            });

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
@endpush
