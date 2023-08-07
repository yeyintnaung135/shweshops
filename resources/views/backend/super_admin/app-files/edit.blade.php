
{{-- INFO if you are seeing this in future and these are still not being used, you should delete them. --}}

{{-- @extends('layouts.backend.super_admin.datatable')
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
                Apk File Edit
            </x-title>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-default">
                        <div class="card-body">
                            <h1>Edit App File</h1>
                            <form action="{{ route('backside.super_admin.app-files.update', $appFile) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="file">Current App File:</label>
                                    <p>{{ $appFile->file }}</p>
                                    <input type="file" name="file" id="file" class="form-control-file" required
                                    accept=".apk,.ipa">
                                    <small class="form-text text-muted">Upload a new file to replace the current one
                                    </small>
                                    @error('file')
                                        <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <a href="{{ route('backside.super_admin.app-files.index') }}"
                                    class="btn btn-secondary">Cancel</a>
                            </form>

                        </div>
                    </div>
                </div>
                </form>
            </section>
        </div>
    </div>
@endsection --}}
