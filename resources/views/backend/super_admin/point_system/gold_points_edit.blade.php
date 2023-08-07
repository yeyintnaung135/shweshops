@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Point Edit')

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
                    <div class="col-12 col-lg-6">
                        <div class="card card-outline card-primary p-0">
                            <div class="card-header ">
                                <h3 class="font-weight-bold">Gold Point</h3>
                            </div>

                            <div class="card-body p-3 ">
                                <form action="{{ url('backside/super_admin/gold_point/store') }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="InputPrice">Price</label>
                                        <input type="text" value="{{ $gold_point->status }}" name="status"
                                            class="form-control @error('status')
                                    is-invalid
                                @enderror"
                                            id="InputPrice">
                                        @error('status')
                                            <span class="text-danger font-weight-bolder">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="InputCount">Count</label>
                                        <input type="text" value="{{ $gold_point->counts }}"
                                            class="form-control @error('counts')
                                    is-invalid
                                @enderror"
                                            name="counts" id="InputCount">
                                        @error('counts')
                                            <span class="text-danger font-weight-bolder">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ url('backside/super_admin/gold_points') }}" role="button"
                                        class="btn btn-sm btn-outline-dark">Back</a>
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
