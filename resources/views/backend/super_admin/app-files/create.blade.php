@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Apk File')


@section('content')
    <div class="wrapper">
        @include('backend.super_admin.navbar')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('backend.super_admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @if (Session::has('message'))
                <x-alert></x-alert>
            @endif

            <x-title>
                Apk File Create
            </x-title>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-default">
                        <div class="card-body">
                            <h1>Upload New App File</h1>
                            <form action="{{ route('backside.super_admin.app-files.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="file">App File:</label>
                                    <input type="file" name="file" id="file" class="form-control-file" required
                                        accept=".apk,.ipa,.zip">
                                    @error('file')
                                        <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="operating_system" class="col-sm-3 col-form-label">Operating System:</label>
                                    <div class="col-sm-3">
                                        <select name="operating_system" id="operating_system" class="form-control" required>
                                            <option value="" disabled>Select Operating System</option>
                                            <option value="Android">Android</option>
                                            <option value="iOS">iOS</option>
                                        </select>
                                        @error('operating_system')
                                            <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="user_type" class="col-sm-3 col-form-label">User Type:</label>
                                    <div class="col-sm-3">
                                        <select name="user_type" id="user_type" class="form-control" required>
                                            <option value="" disabled>Select User Type</option>
                                            <option value="Shop User">Shop User</option>
                                            <option value="Regular User">Regular User</option>
                                        </select>
                                        @error('user_type')
                                            <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Upload</button>
                                <a href="{{ route('backside.super_admin.app-files.index') }}"
                                    class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
