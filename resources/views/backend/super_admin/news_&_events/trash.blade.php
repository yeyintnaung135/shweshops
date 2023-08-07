@extends('layouts.backend.super_admin.datatable')
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
            <section class="content-header">
                <x-title>Trash</x-title>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="card">
                                <div class="card-header">
                                    <a href=" {{ route('backside.super_admin.news.create') }} " class="btn btn-primary">Add
                                        New</a>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="post" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th>Desc</th>
                                                <th>cover</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($posts as $post)
                                                <tr>
                                                    <td class="w-25">{{ $post->title }} </td>
                                                    <td class="w-25"><span class="text-danger h3">From</span>
                                                        {{ $post->from }} <span class="text-danger h3">To</span>
                                                        {{ $post->to }} </td>
                                                    <td class="w-25">{{ Str::words($post->description, 20) }}</td>
                                                    <td class="w-25">
                                                        <img src="{{ asset('images/news/' . $post->image) }}" alt=""
                                                            class="w-50">
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('news.restore', $post->id) }}">
                                                            <button class="btn btn-sm btn-warning">Restore <i
                                                                    class="fas fa-trash-restore"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
        $(function() {

            $("#post").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"],
                'columnDefs': [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 4
                    },
                    {
                        responsivePriority: 3,
                        targets: 2
                    },
                    {
                        responsivePriority: 4,
                        targets: 1
                    },
                ],
                "order": [0, 'desc']
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $(".title").click(function(e) {
                $(e.target).children().toggle(500);
            });

        });
    </script>
@endpush
