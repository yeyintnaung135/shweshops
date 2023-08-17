@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Gold Price Edit')
@section('content')
    <div class="wrapper">
        @include('backend.super_admin.navbar')
        @include('backend.super_admin.sidebar')

        <section class="content-wrapper">
            <section class="content-header">
                <x-title>Gold Price Edit</x-title>
            </section>
            <div class="col-md-12 mb-3">

                <form class="sop-form" method="post" action="{{ route('backside.super_admin.superAdmin.gold_price_update') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row pt-3">
                        <div class="col-12 col-md-6">
                            <label for="sell_price">Sell Price</label>
                            <div class="form-group">
                                <input onFocus="this.select()"
                                    class="form-control @error('sell_price') is-invalid @enderror" type="text"
                                    name="sell_price" id=""
                                    value="@isset($gold_price->sell_price){!! $gold_price->sell_price !!}@endisset">
                                @error('sell_price')
                                    <x-error>
                                        {{ $message }}
                                    </x-error>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="buy_price">Buy Price</label>
                            <div class="form-group">
                                <input onFocus="this.select()" class="form-control @error('buy_price') is-invalid @enderror"
                                    type="text" name="buy_price" id=""
                                    value="@isset($gold_price->buy_price){!! $gold_price->buy_price !!}@endisset">
                                @error('buy_price')
                                    <x-error>
                                        {{ $message }}
                                    </x-error>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="active" value="1">
                    <div class="col-12 pt-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit"><span
                                class="fa fa-paper-plane"></span>&nbsp;&nbsp;Update
                        </button>
                    </div>
            </div>
            </form>

    </div>
    </section>
    </div>
@endsection

@push('css')
    <style>
        .sop-form {
            background-color: rgb(255, 255, 255);
            padding: 20px 30px;
            border-radius: 10px;
        }

        #preview {
            padding: 15px;
        }

        .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
        }

        .custom-file-upload:hover {
            border: 1px solid #780116;
            color: #780116;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
        }

        input[type="file"] {
            display: none;
        }

        .mid-img img {
            min-height: 400px;
            max-height: 500px;
            width: 100%;
            object-fit: cover;
        }

        .image_area {
            position: relative;
            width: 100%;
            height: 450px;
            border: 2px dashed rgba(103, 103, 103, 0.587);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: transparent;
        }

        #uploaded_image {
            cursor: pointer;
        }

        /* #uploaded_image:hover{
                transform: scale(1.5);
            }
            #uploaded_image:active{
                transform: scale(1.5);
            } */
        .photo-invalid {
            border: 3px dashed red;
        }

        .remove-img {
            position: absolute;
            bottom: 1px;
            cursor: pointer;
            display: none;
            transition: 5s;
        }

        .remove-img .fas {
            font-size: 20px;
        }

        .remove-img .fas:hover {
            color: red;
        }

        .upload-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;

        }

        img {
            display: block;
            max-width: 100%;
        }


        .preview {
            overflow: hidden;
            width: 100%;
            height: 160px;
            margin-left: 5px;
            border: 3px solid red;
        }

        .modal-lg {
            max-width: 1000px !important;
        }



        .text {
            color: #333;
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            text-align: center;
        }

        @media screen and (max-width: 726px) {
            .image_area {
                width: 100%;
                height: 200px;
                padding: 5px;
            }

            .preview {
                margin: 10px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="//cdn.ckeditor.com/4.19.0/full/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
        image.onchange = evt => {
            const [file] = image.files
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }
    </script>
@endpush
