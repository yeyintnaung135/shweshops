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
                Collection List
            </x-title>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header d-flex justify-content-end align-items-center">
                                <h3 class="card-title">
                                    <a href="{{ route('backside.shop_owner.collections.create') }}" class="btn btn-primary">
                                        <span class="fa fa-plus-circle"></span>&nbsp;&nbsp;Add New Collection
                                    </a>
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-end align-items-center">
                                    <div class="form-group">
                                        <label for="fromDate" class="form-label">Choose Date</label>
                                        <input type="text" id="fromDate" class="form-control" placeholder="From Date"
                                            autocomplete="off">
                                    </div>
                                    <div class="form-group mx-3">
                                        <label for="toDate" class="form-label">Choose Date</label>
                                        <input type="text" id="toDate" class="form-control" placeholder="To Date"
                                            autocomplete="off">
                                    </div>
                                    <div>
                                        <button id="searchButton" class="btn btn-primary mt-3">Filter</button>
                                    </div>
                                </div>
                                <table id="collectionTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Items</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize datepicker
            $('#fromDate, #toDate').datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            // Initialize DataTable
            const collectionTable = $('#collectionTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('backside.shop_owner.collections.getCollections') }}",
                    "data": function(d) {
                        d.fromDate = $('#fromDate').val();
                        d.toDate = $('#toDate').val();
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'items_count',
                        render: function(data) {
                            return data + ' Items';
                        }
                    },
                    {
                        data: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return `
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group mr-2" role="group">
                            <a class="btn btn-sm btn-success" href="${full.actions.detail_url}" title="Detail">
                                <span class="fa fa-info-circle"></span>
                            </a>
                            <a class="btn btn-sm btn-primary" href="${full.actions.edit_url}" title="Edit">
                                <span class="fa fa-edit"></span>
                            </a>
                                </div>
                                <div class="btn-group mr-2" role="group">
                            <a class="btn btn-sm btn-danger" onclick="Delete('${full.actions.delete_url}')"
                                title="Delete">
                                <span class="fa fa-trash"></span>
                            </a>
                            <form id="delete_form_${full.id}" action="${full.actions.delete_url}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                                </div>
                        </div>`;
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: 'lBfrtip',
                "responsive": true,
                "autoWidth": false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });

            // Search button click event handler
            $('#searchButton').click(function() {
                collectionTable.draw();
            });
        });

        function Delete(deleteUrl) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-danger ml-2',
                    cancelButton: 'btn btn-info'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Check if "Confirm" button was clicked
                    const deleteForm = document.createElement('form');
                    deleteForm.action = deleteUrl;
                    deleteForm.method = 'POST';
                    deleteForm.style.display = 'none';
                    deleteForm.innerHTML = `
                    @csrf
                    @method('DELETE')`;
                    document.body.appendChild(deleteForm);
                    deleteForm.submit();
                }
            });
        }
    </script>
@endpush
