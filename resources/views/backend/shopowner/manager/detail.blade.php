@extends('layouts.backend.datatable')

@section('content')
    <div class="wrapper">

        @include('layouts.backend.navbar')

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @if (Session::has('message'))
                <x-alert>

                </x-alert>
            @endif

            <!-- zhheader shopname -->
            <x-header>
                @foreach ($shopowner as $shopowner)
                    {{ $shopowner->shop_name }}
                @endforeach

            </x-header>
            <!-- end zh header shopname -->

            <x-title>
                {{ $manager->name }}
            </x-title>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <table class="table">

                                <tbody>
                                    <tr>

                                        <th>Username</th>
                                        <td>{{ $manager->name }}</td>

                                    </tr>
                                    <tr>

                                        <th>Phone</th>
                                        <td>{{ $manager->phone }}</td>

                                    </tr>
                                    <tr>

                                        <th>Role</th>
                                        <td> {{ $manager->role->name }}</td>

                                        <td>
                                            @isset(Auth::guard('shop_role')->user()->id)
                                                @if (Auth::guard('shop_role')->user()->role_id == 1)
                                                    <button type="button" onclick="Delete()"
                                                        class="btn btn-block bg-gradient-danger btn-sm">Delete</button>
                                                @else(Auth::guard('shop_role')->user()->role_id == 2)
                                                    <button type="button" onclick="Delete()"
                                                        class="btn btn-block bg-gradient-danger btn-sm">Delete</button>
                                                @endif
                                            @endisset

                                            @isset(Auth::guard('shop_owner')->user()->id)
                                                <button type="button" onclick="Delete()"
                                                    class="btn btn-block bg-gradient-danger btn-sm">Delete</button>
                                            @endisset
                                            <form id="delete_form"
                                                action="{{ route('backside.shop_owner.managers.remove_user', $manager->id) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <input type="hidden" name="id" value="{{ $manager->id }}" />
                                            </form>
                                        </td>

                                    </tr>

                                </tbody>
                            </table>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
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
@push('scripts')
    <script>
        function Delete() {
            $(function() {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-danger ml-2',
                        cancelButton: 'btn btn-info'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete_form').submit();
                    }
                })
            });
        };

        function unsetDiscount() {
            $(function() {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-danger ml-2',
                        cancelButton: 'btn btn-info'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Unset Discount it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('unset').submit();
                    }
                })
            });
        }
    </script>
@endpush
