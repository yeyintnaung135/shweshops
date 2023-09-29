@extends('layouts.backend.backend')

@section('content')
    <div class="wrapper">
        @include('layouts.backend.navbar')
        @include('layouts.backend.sidebar')

        <div class="content-wrapper">
            <x-title>
                News Edit
            </x-title>

            <section class="content">
                <form method="post" action="{{ route('backside.shop_owner.news.update', $news->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="container-fluid">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ $news->title }}">
                                    @error('title')
                                        <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                        rows="7">{{ $news->description }}</textarea>
                                    @error('description')
                                        <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <img src="{{ filedopath('/news_&_events/news/' . $news->image) }}" alt="news" width="200">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="image">Upload New Photo</label>
                                    <input type="file" id="image" name="image"
                                        class="form-control-file @error('image') is-invalid @enderror">
                                    @error('image')
                                        <small class="text-danger font-weight-bolder">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button class="btn btn-primary" id="btn" type="submit"><span
                                        class="fa fa-paper-plane"></span>&nbsp;&nbsp;Edit </button>
                                <a class="btn btn-outline-secondary ml-3" href="{{ route('backside.shop_owner.news.index') }}"
                                    class="btn btn-outline-dark">Cancel</a>

                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
@endsection
