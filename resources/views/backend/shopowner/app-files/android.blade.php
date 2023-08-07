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
                <x-alert></x-alert>
            @endif

            <x-title>
                Shweshops Mobile App
            </x-title>

            @if (session('error'))
                <div class="text-center">
                    <div class="alert alert-danger d-inline-block">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-center">{{ $appFile->file }}</h3>
                            </div>

                            <div class="card-body">
                                <p class="text-center">Download the APK file below:</p>
                                <div class="text-center">
                                    <a href="{{ route('backside.shop_owner.app-files.download', $appFile) }}"
                                        class="btn btn-primary">Download APK</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
