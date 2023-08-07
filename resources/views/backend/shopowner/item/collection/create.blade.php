@extends('layouts.backend.backend')

@section('content')
    <div class="wrapper">
        @include('layouts.backend.navbar')
        @include('layouts.backend.sidebar')

        <div class="content-wrapper">
            <x-title>
                Collection Create
            </x-title>

            <section class="content">
                <form method="post" action="{{ route('backside.shop_owner.collections.store') }}">
                    @csrf
                    <div class="container-fluid">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                name="name" placeholder="Enter collection name" required />
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">
                                                <span class="fa fa-plus"></span> Create
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
@endsection
