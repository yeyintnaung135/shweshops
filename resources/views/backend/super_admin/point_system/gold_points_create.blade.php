@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Point Create')

@section('content')
    <div class="wrapper">
        @include('backend.super_admin.navbar')
        @include('backend.super_admin.sidebar')
        @include('backend.super_admin.loading')
        <section class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title></x-title>
            </section>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6">
                        <div class="card card-outline card-primary p-0">
                            <div class="card-header ">
                                <h3 class="font-weight-bold">Gold Point</h3>
                            </div>

                            <div class="card-body p-2 d-flex justify-content-center">
                                <form action="{{ url('backside/super_admin/gold_point/create') }}" action="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="InputPrice">Price</label>
                                        <input type="number" name="status"
                                            class="form-control @error('status')
                                    is-invalid
                                @enderror"
                                            id="InputPrice" aria-describedby="emailHelp">
                                        @error('status')
                                            <span class="text-danger font-weight-bolder">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="InputCount">Count</label>
                                        <input type="text"
                                            class="form-control @error('count')
                                    is-invalid
                                @enderror"
                                            name="count" id="InputCount">
                                        @error('count')
                                            <span class="text-danger font-weight-bolder">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
@endsection

@push('scripts')
    <script>
        $("#loader").hide();
    </script>
@endpush
