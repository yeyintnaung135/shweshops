@extends('backend.super_admin.layout')
@section('content')
    <div class="wrapper">
        @include('backend.super_admin.navbar')
        @include('backend.super_admin.sidebar')
        <section class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title>Create Post</x-title>
            </section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="p-3 ">
                            <div class="card card-default">
                                <!-- form start -->
                                <div class="card-body p-4">
                                    <form action="{{ route('backside.super_admin.promotion.store') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label id="shop">Select Shop</label>
                                            <select class="form-control select2" style="width: 100%;" id="shop"
                                                form="createAds" name="shop_id">
                                                <option value="">Choose</option>
                                                @foreach ($shops as $shop)
                                                    <option value="{{ $shop->id }}">{{ $shop->shop_name }} (
                                                        {{ $shop->shop_name_myan }} )</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title">
                                        </div>
                                        <div class="form-group">
                                            <label>Promotion Date</label>
                                            <div class="form-row">
                                                <div class="form-group col-6 col-md-2">
                                                    <label for="from">From</label>
                                                    <input type="date" class="form-control" name="from" id="from"
                                                        placeholder="dd-mm-yyyy">
                                                </div>
                                                <div class="form-group col-6 col-md-2">
                                                    <label for="to">To</label>
                                                    <input type="date" class="form-control" name="to" id="to"
                                                        placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" name="description" id="description" rows="6"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="photo" id="" class="form-control">
                                        </div>
                                        <button class="btn btn-primary float-right" id="btn" type="submit"><span
                                                class="fa fa-paper-plane"></span>&nbsp;&nbsp;Create </button>
                                </div>
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
@endpush
