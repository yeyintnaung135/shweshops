@extends('layouts.backend.backend')

@section('content')
    <div class="wrapper">
        @include('layouts.backend.navbar')
        @include('layouts.backend.sidebar')

        <div class="content-wrapper">
            <x-title>
                Collection Edit
            </x-title>

            <section class="content">
                <form method="post" action="{{ route('backside.shop_owner.collections.update', $collection->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="container-fluid">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text"
                                                    class="form-control  @error('name') is-invalid @enderror"
                                                    value="{{ $collection->name }}" name="name" placeholder="Enter collection name"
                                                    required />
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary" id="btn" type="submit">
                                                <span class="fa fa-paper-plane"></span>&nbsp;&nbsp;Edit 
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
