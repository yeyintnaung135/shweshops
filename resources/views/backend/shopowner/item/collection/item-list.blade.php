@extends('layouts.backend.datatable')

@section('content')
    <div class="wrapper">
        @include('layouts.backend.navbar')
        @include('layouts.backend.sidebar')

        <div class="content-wrapper">
            @if (Session::has('message'))
                <x-alert> </x-alert>
            @endif

            <x-title>
                Add Item to {{ $collection->name }}
            </x-title>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card" data-collection-id="{{ $collection->id }}">
                                <div class="card-header">
                                    <h3 class="card-title"><a
                                            href="{{ route('backside.shop_owner.collections.show', $collection->id) }}"
                                            type="button" class="btn btn-block bg-gradient-primary"><span
                                                class="fa fa-arrow-circle-left"></span> Back To {{ $collection->name }}</a>
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="collectionItem" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product Code</th>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Price&#40;MMK&#41;</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // To pass $collection->id to controller
            var collectionId = $('.card').data('collection-id');

            $('#collectionItem').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('backside.shop_owner.collections.getItems') }}",
                    data: {
                        collection: collectionId
                    } // Pass collectionId as a parameter
                },
                columns: [{
                        data: 'product_code'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'check_photothumbs',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            const image = `<img src= "{{ filedopath('/items/' . '${data}') }}"/>`;
                            return image;
                        }
                    },
                    {
                        data: 'formatted_price',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                "responsive": true,
                "autoWidth": false
            });
        });
    </script>
@endpush
