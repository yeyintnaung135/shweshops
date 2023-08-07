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
                @endforeach
                {{ $shopowner->shop_name }}
            </x-header>
            <!-- end zh header shopname -->

            <!-- Content Header (Page header) -->
            <x-title>
                Item Edit
            </x-title>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->

                    <yk-dropzoneforedit :main_cat="{{ $main_cat }}" :editdata="{{ $item }}"
                        :catlist="{{ $cat_list }}" :collection="{{ $collection }}"
                        link="{{ url('/backside/shop_owner/editajax') }}"></yk-dropzoneforedit>

                    <!-- /.card -->
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

@push('scripts')
    <script src="{{ url('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endpush
