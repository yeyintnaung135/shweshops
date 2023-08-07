@extends('layouts.backend.backend')

@section('content')
    <div class="wrapper">
        @include('layouts.backend.navbar')
        @include('layouts.backend.sidebar')

        <div class="content-wrapper">
            <x-title>
                Event Create
            </x-title>

            <section class="content">
                <form method="post" action="{{ route('backside.shop_owner.events.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="container-fluid">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title') }}" />
                                    @error('title')
                                        <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                        rows="7">{{ old('description') }}</textarea>
                                    @error('description')
                                        <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="photo">Upload Photo</label>
                                    <input type="file" name="photo"
                                        class="form-control-file @error('photo') is-invalid @enderror" />
                                    @error('photo')
                                        <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button class="btn btn-primary mt-3" type="submit"><span
                                        class="fa fa-plus"></span>&nbsp;&nbsp;Create
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
@endsection
