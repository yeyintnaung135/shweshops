@extends('layouts.backend.datatable')
@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.backend.pos_nav')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.backend.pos_sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sn-background-light-blue">
            @if (Session::has('message'))
                <x-alert>

                </x-alert>
            @endif
            <!-- Content Header (Page header) -->
            <section class="content-header sn-content-header">
                <div class="container-fluid">
                </div><!-- /.container-fluid -->
            </section>

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row d-flex mb-3">
                        <h4 class="text-color">ပန်းထိမ်ကုန်သည်စာရင်းများ</h4>
                        <a class="btn btn-m btn-color ml-3" href="{{ route('backside.shop_owner.pos.create_supplier') }}">
                            <i class="fa fa-plus mr-2"></i>Create</a>
                        <div class="dropdown ml-5">
                            <a class="btn btn-m btn-color dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-filter"></i></a>
                            <ul class="dropdown-menu px-1">
                                <li><label><input type="checkbox" id="gold"> ​ရွှေထည်</label></li>
                                <li><label><input type="checkbox" id="kyout"> ​ကျောက်မျက်ရတနာ</label></li>
                                <li><label><input type="checkbox" id="diamond"> စိန်ထည်</label></li>
                                <li><label><input type="checkbox" id="platinum"> ပလက်တီနမ်</label></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a href="#" id='save' class="btn btn-color btn-sm"
                                        style="margin-left: 50px;">Save</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center mt-3">
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
                            <button id="searchButton" class="btn btn-color btn-m mt-3">Filter</button>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-body">
                            <table class="table table-striped" id="suppliersTable">
                                <thead>
                                    <th>နံပါတ်</th>
                                    <th>ဆိုင်အမည်</th>
                                    <th>ဆိုင်အမျိုးအစား</th>
                                    <th>ကုဒ်နံပါတ်</th>
                                    <th>ပန်းထိမ်ဆရာအမည်</th>
                                    <th>ဖုန်းနံပါတ်</th>
                                    <th>တခြားဖုန်းနံပါတ်</th>
                                    <th>နေ့စွဲ</th>
                                    <th></th>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        {{-- @include('layouts.backend.footer') --}}


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#fromDate, #toDate').datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            var suppliersTable = $('#suppliersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('backside.shop_owner.pos.get_supplier_list') }}",
                    "data": function(d) {
                        d.fromDate = $('#fromDate').val();
                        d.toDate = $('#toDate').val();
                        d.text = ''; // Initialize text parameter

                        // Build the text parameter based on checkbox values
                        if ($("#gold").is(":checked")) {
                            d.text += 'option1';
                        }
                        if ($("#kyout").is(":checked")) {
                            if (d.text !== '') {
                                d.text += '/';
                            }
                            d.text += 'option2';
                        }
                        if ($("#diamond").is(":checked")) {
                            if (d.text !== '') {
                                d.text += '/';
                            }
                            d.text += 'option3';
                        }
                        if ($("#platinum").is(":checked")) {
                            if (d.text !== '') {
                                d.text += '/';
                            }
                            d.text += 'option4';
                        }
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'shop_name',
                        name: 'shop_name'
                    },
                    {
                        data: 'shop_type',
                        name: 'shop_type',
                    },
                    {
                        data: 'code_number',
                        name: 'code_number'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'other_phone',
                        name: 'other_phone'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return `
    <a class="btn btn-sm btn-primary" href="${full.actions.edit_url}" title="Edit">
        <span class="fa fa-edit"></span>
    </a>
    <a class="btn btn-sm btn-danger" onclick="Delete('${full.actions.delete_url}')"
        title="Delete">
        <span class="fa fa-trash"></span>
    </a>
    <form id="delete_form_${full.id}" action="${full.actions.delete_url}" method="POST"
        style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</div>`;
                        }
                    },
                ],
                dom: 'lBfrtip',
                "responsive": true,
                "autoWidth": false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [
                    [7, 'desc']
                ],
            });

            //Date Filter
            $('#searchButton').click(function() {
                suppliersTable.draw();
            });

            $('#save').click(function() {
                suppliersTable.draw();
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

        $(document).ready(function() {
            function alignModal() {
                var modalDialog = $(this).find(".modal-dialog");

                // Applying the top margin on modal to align it vertically center
                modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
            }
            // Align modal when it is displayed
            $(".modal").on("shown.bs.modal", alignModal);

            // Align modal when user resize the window
            $(window).on("resize", function() {
                $(".modal:visible").each(alignModal);
            });
            $('#example-getting-started').multiselect();
        });
    </script>
@endpush
@push('css')
    <style>
        .btn-color {
            background-color: #780116;
            color: white;
        }

        .btn-color:hover {
            color: white;
        }

        .text-color {
            color: #780116;
        }

        body {
            background: #F0F7FA;
            font-family: 'Myanmar3', Sans-Serif !important;
        }
    </style>
@endpush
