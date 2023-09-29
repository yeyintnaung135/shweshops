@extends('layouts.backend.backend')

@section('content')
    <div class="wrapper">
        @include('layouts.backend.navbar')
        @include('layouts.backend.sidebar')

        <div class="content-wrapper">
            <x-title>
                Event Edit
            </x-title>

            <section class="content">
                <form method="post" action="{{ route('backside.shop_owner.events.update', $event->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="container-fluid">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ $event->title }}">
                                    @error('title')
                                        <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                        rows="7">{{ $event->description }}</textarea>
                                    @error('description')
                                        <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <img src="{{ filedopath('/news_&_events/event/' . $event->photo) }}" alt="event" width="200">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="photo">Upload New Photo</label>
                                    <input type="file" id="photo" name="photo"
                                        class="form-control-file @error('photo') is-invalid @enderror">
                                    @error('photo')
                                        <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button class="btn btn-primary" id="btn" type="submit"><span
                                        class="fa fa-paper-plane"></span>&nbsp;&nbsp;Edit </button>
                                <a class="btn btn-outline-secondary ml-3"
                                    href="{{ route('backside.shop_owner.events.index') }}"
                                    class="btn btn-outline-dark">Cancel</a>

                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
@endsection
