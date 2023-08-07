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
                Apk File List
            </x-title>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header d-flex justify-content-end">
                                <h3 class="card-title">
                                    <a href="{{ route('backside.super_admin.app-files.create') }}" class="btn btn-primary">
                                        <span class="fa fa-plus-circle"></span>&nbsp;&nbsp;Create App File
                                    </a>
                                </h3>
                            </div>

                            <div class="card-body">

                                @if (count($appFiles) > 0)
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>File</th>
                                                <th>User Type</th>
                                                <th>Operating System</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($appFiles as $appFile)
                                                <tr>
                                                    <td>{{ $appFile->id }}</td>
                                                    <td>{{ $appFile->file }}</td>
                                                    <td>{{ $appFile->user_type }}</td>
                                                    <td>{{ $appFile->operating_system }}</td>
                                                    <td>
                                                        <form action="{{ route('backside.super_admin.app-files.destroy', $appFile) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this file?')"><i class="fas fa-trash-alt"></i> Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p>No app files found.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
