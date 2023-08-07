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
                <x-title>All Posts</x-title>
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
                                                <!--<th>Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($posts as $post)
                                                <tr>
                                                    <td class="w-25">
                                                        <div class="title">{{ $post->title }}
                                                            <div class="edit-section p-2 ">
                                                                <div
                                                                    class="d-block d-lg-flex align-items-center justify-content-around">
                                                                    <a href="{{ route('backside.super_admin.news.edit', $post->id) }}"
                                                                        class="btn btn-sm btn-info">Edit <i
                                                                            class="far fa-edit"></i></a> |
                                                                    <form
                                                                        action="{{ route('backside.super_admin.news.destroy', $post->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="btn btn-sm btn-danger"
                                                                            onclick="return confirm('Are you sure you want to delete this item?');">Trash
                                                                            <i class="fas fa-trash-alt"></i></button>
                                                                    </form>
                                                                    | <a href="#" class="btn btn-sm btn-warning">View
                                                                        <i class="far fa-eye"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="w-25">From {{ $post->from }} To {{ $post->to }}</td>
                                                    <td class="w-25">{{ Str::words($post->description, '25') }}</td>
                                                    <td class="w-25">
                                                        <img src="{{ asset('images/news/' . $post->image) }}" alt=""
                                                            class="w-50">
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
