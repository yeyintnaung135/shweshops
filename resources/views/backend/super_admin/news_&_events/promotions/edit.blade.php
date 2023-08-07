@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Promotion Edit')

@section('content')
    <div class="wrapper">
        @include('backend.super_admin.navbar')
        @include('backend.super_admin.sidebar')
        <section class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title>Edit Promotion</x-title>
            </section>
            <div class="container-fluid">
                <div class="row flex-column-reverse flex-md-row">
                    <div class="col-12 col-lg-6">
                        <div class="p-1">
                            <div class="card card-outline card-dark">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ session('success') }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <!-- form start -->
                                <div class="card-body p-4">
                                    <form action="{{ route('backside.super_admin.promotion.update', $promotion->id) }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text"
                                                class="form-control @error('title')
                                    is-invalid
                                @enderror"
                                                id="title" name="title" value="{{ $promotion->title }}">
                                            @error('title')
                                                <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea
                                                class="form-control @error('description')
                                    is-invalid
                                @enderror"
                                                name="description" id="description" rows="7">{{ $promotion->description }}</textarea>
                                            @error('description')
                                                <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="fileUpload">Upload Photo</label>
                                            <div class="mb-2">
                                                <img src="{{ asset('images/news_&_events/promotion/' . $promotion->photo) }}"
                                                    alt="" class="w-lg-50 w-25">
                                            </div>
                                            <input type="file" id="fileUpload" name="file_upload"
                                                class="form-control @error('file_upload')
                                    is-invalid
                                @enderror">
                                            @error('file_upload')
                                                <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <button class="btn btn-primary" id="btn" type="submit"><span
                                                class="fa fa-paper-plane"></span>&nbsp;&nbsp;Edit </button>
                                        <a href="{{ route('backside.super_admin.promotion.create') }}"
                                            class="btn btn-outline-dark">Cancel</a>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Table  -->
                    <div class="col-lg-6 col-12">
                        <div class="p-1">
                            <div class="">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Title</th>
                                            <th scope="col" class="mobile">Description</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Handle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($promotions as $p)
                                            <tr>
                                                <th scope="row">{{ $p->id }}</th>
                                                <td class="w-25">{{ $p->title }}</td>
                                                <td class="mobile w-25">{{ Str::words($p->description, 6) }}</td>
                                                <td class="d-flex justify-content-center">
                                                    <img src="{{ asset('images/news_&_events/promotion/' . $p->photo) }}"
                                                        alt="" class="w-50">
                                                </td>
                                                <td>
                                                    <div class="d-flex ">
                                                        <a href="{{ route('backside.super_admin.promotion.edit', $p->id) }}"
                                                            class="btn btn-sm btn-success mr-1"><i
                                                                class="fa fa-edit text-light"></i></a>
                                                        <form
                                                            action="{{ route('backside.super_admin.promotion.destroy', $p->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure?')"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No Data found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="float-right">
                                    {{ $promotions->links() }}
                                </div>
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

@push('css')
    <style>
        @media screen and (max-width: 726px) {
            .mobile {
                display: none;
            }
        }
    </style>
@endpush
