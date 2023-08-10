@extends('layouts.backend.backend')
@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.backend.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')
        @php
            use App\Shopowner;
            use App\Manager;


                $current_shop = $currentShop;

        @endphp
        <div class="content-wrapper sn-background-light-blue">
            <div class="sn-admin-wrapper">

            </div>
        </div>
        <!-- Content Wrapper. Contains page content -->
    </div>
    {{-- <!-- /.card -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->

    @include('components.searchbyproductcode')
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('layouts.backend.footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div> --}}
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endpush
