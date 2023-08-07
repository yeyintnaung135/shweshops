@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Event Create')

@section('content')
    @php
        use Illuminate\Support\Carbon;
    @endphp

    <div class="wrapper">
        @include('backend.super_admin.navbar')
        @include('backend.super_admin.sidebar')
        <section class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title>Create Event</x-title>
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
                                    <form action="{{ route('backside.super_admin.events.store') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        {{-- <div class="form-group">
                            <label for="shop">Select Shop</label>
                                <select class="form-control select2" style="width: 100%;" name="shop_id">
                                    <option value="">Choose</option>
                                    @foreach ($shopowners as $shop)
                                        <option value="{{ $shop->id }}" {{ old('shop_id') == $shop->id ? 'selected' : '' }} > {{ $shop->shop_name }} ( {{ $shop->shop_name_myan }} )</option>
                                    @endforeach
                                </select>
                                @error('shop_id')
                                    <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                @enderror
                            </div> --}}
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text"
                                                class="form-control @error('title')
                                    is-invalid
                                @enderror"
                                                id="title" name="title" value="{{ old('title') }}">
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
                                                name="description" id="description" rows="7">{{ old('description') }}</textarea>
                                            @error('description')
                                                <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="fileUpload">Upload Photo</label>
                                            <input type="file" name="file_upload"
                                                class="form-control @error('file_upload')
                                    is-invalid
                                @enderror">
                                            @error('file_upload')
                                                <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <button class="btn btn-primary float-right" id="btn" type="submit"><span
                                                class="fa fa-paper-plane"></span>&nbsp;&nbsp;Create </button>
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
                                        @forelse ($events as $event)
                                            <tr>
                                                <th scope="row">{{ $event->id }}</th>
                                                <td>{{ $event->title }}</td>
                                                <td class="mobile w-25">{{ Str::words($event->description, 6) }}</td>
                                                <td class="d-flex justify-content-center">
                                                    <img src="{{ filedopath('/news_&_events/event/' . $event->photo) }}"
                                                        alt="" class="w-50">
                                                </td>
                                                <td>
                                                    <div class="d-flex ">
                                                        <a href="{{ route('backside.super_admin.events.edit', $event->id) }}"
                                                            class="btn btn-sm btn-success mr-1"><i
                                                                class="fa fa-edit text-light"></i></a>
                                                        <form
                                                            action="{{ route('backside.super_admin.events.destroy', $event->id) }}"
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
                                    {{ $events->links() }}
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
