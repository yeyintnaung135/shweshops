@extends('layouts.backend.datatable')

@section('content')
    <div class="wrapper">
        @include('layouts.backend.navbar')
        @include('layouts.backend.sidebar')

        <div class="content-wrapper">
            @if (Session::has('message'))
                <x-alert></x-alert>
            @endif

            <x-title>
                Items In {{ $collection->name }}
            </x-title>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card" data-collection-id="{{ $collection->id }}">
                                <div class="card-header d-flex justify-content-end align-items-center">
                                    <h3 class="card-title"><a
                                            href="{{ route('backside.shop_owner.collections.items', ['collection' => $collection->id]) }}"
                                            type="button" class="btn btn-block bg-gradient-primary"><span
                                                class="fa fa-plus-circle"></span> Add Items</a></h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="collectionItemsTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product Code</th>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Price&#40;MMK&#41;</th>
                                                <th></th>
                                            </tr>
                                        </thead>
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
            $('#collectionItemsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('backside.shop_owner.collections.getCollectionItems') }}",
                    data: {
                        collection: collectionId
                    } // Pass collectionId as a parameter
                },
                columns: [
                    {
                        data: 'product_code',
                    },
                    {
                        data: 'name',
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
                    },
                ],
                dom: 'lBfrtip',
                "responsive": true,
                "autoWidth": false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
        });

        function Delete(itemId) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-danger ml-2',
                    cancelButton: 'btn btn-info'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: 'Want to remove this item from the collection',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Do it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const deleteForm = document.createElement('form');
                    deleteForm.method = 'POST';
                    deleteForm.action = '{{ route('backside.shop_owner.collections.remove.item') }}';
                    deleteForm.style.display = 'none';

                    deleteForm.innerHTML = `
                @csrf
                @method('DELETE')
                <input type="hidden" name="item_id" value="${itemId}">
            `;

                    document.body.appendChild(deleteForm);
                    deleteForm.submit();
                }
            });
        }
    </script>
@endpush
