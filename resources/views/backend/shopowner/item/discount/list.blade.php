@extends('layouts.backend.datatable')

@push('css')
    <style>
        .multiple_unset_btn {
            display: none;
        }
    </style>
@endpush

@section('content')
    <div class="wrapper">
        @include('layouts.backend.navbar')

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sn-background-light-blue">
            <!-- Content Header (Page header) -->
            @if (Session::has('message'))
                <x-alert>

                </x-alert>
            @endif

            <!-- zhheader shopname -->
            {{-- <x-header>
            @foreach ($shopowner as $shopowner)
                    @endforeach
                    {{$shopowner->shop_name}}
            </x-header> --}}
            <!-- end zh header shopname -->

            {{-- <x-title>
           Discount Items list
            </x-title> --}}
            <!-- Main content -->
            <section class="content pt-3">
                <div class="sn-tab-panel">
                    <ul>
                        <li id="item-tab-1" class="active-panel" onclick="discountTabSwitchOne()">Item List</li>
                        <li id="item-tab-2" onclick="discountTabSwitchTwo()">Item Activity</li>
                    </ul>
                </div>
                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">
                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5">
                                    <div class="card-header d-flex align-items-center">
                                        <div class="">
                                            <h2>Discount Item Lists</h2>
                                            <p>Check your store’s discount items</p>
                                        </div>
                                        <div class="ml-3">
                                            <form action="{{ url('backside/shop_owner/multipe_unset_discount') }}"
                                                method="post">
                                                @csrf

                                                <input type="hidden" name="unsetItems" value=""
                                                    class="unsetDiscountItems">
                                                <button type="submit" class="btn btn-danger multiple_unset_btn ml-2"
                                                    onclick="return confirm('Are You Sure To Unset?')"> Unset
                                                    Discount</button>
                                            </form>
                                        </div>
                                    </div>
                                    <table id="discountTable" class="table table-borderless mt-5">
                                        <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Image</th>
                                                <th>Product Code</th>
                                                <th>Old Price</th>
                                                <th>New Price</th>
                                                <th>Date Time</th>
                                                <th>Action</th>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Select</th>
                                                <th>Image</th>
                                                <th>Product Code</th>
                                                <th>Old Price</th>
                                                <th>New Price</th>
                                                <th>Date Time</th>
                                                <th>Action</th>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <div id="item-panel-2" class="sn-panel-hide">
                    <p class="mt-5 text-center pt-5">Coming Soon ...</p>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
@endsection

@push('scripts')
    <script>
        let unsetItems = new Array();

        function Delete(item_id) {
            $(function() {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-danger ml-2',
                        cancelButton: 'btn btn-info'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Do it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(item_id + '_delete_form').submit();
                    }
                })
            });
        }
        //Multipe Unset Btn
        function checkBox(e) {
            if ($(e).is(':checked')) {
                unsetItems.push(e.value);
                $(".unsetDiscountItems").val(unsetItems);
                $('.multiple_unset_btn').show();
                localData = localStorage.setItem("localData", JSON.stringify(unsetItems));

            } else {
                const index = unsetItems.indexOf(e.value);
                if (index > -1) {
                    unsetItems.splice(index, 1);
                    $(".unsetDiscountItems").val(unsetItems);
                }

                if (unsetItems.length === 0) {
                    $('.multiple_unset_btn').hide();
                }
                localData = localStorage.removeItem("localData", JSON.stringify(unsetItems));
            }

        }

        function get(obj) {
            return document.getElementById(obj);
        }

        function itemTab_Panel(tab_active, tab2, panel_remove, panel2) {
            get(tab_active).classList.add("active-panel");
            get(tab2).classList.remove("active-panel");

            get(panel_remove).classList.remove("sn-panel-hide");
            get(panel2).classList.add("sn-panel-hide");
        }

        function discountTabSwitchOne() {
            itemTab_Panel("item-tab-1", "item-tab-2", "item-panel-1", "item-panel-2");
        }

        function discountTabSwitchTwo() {
            itemTab_Panel("item-tab-2", "item-tab-1", "item-panel-2", "item-panel-1");
        }

        $('#discountTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backside.shop_owner.getDiscountItems') }}",
            columns: [{
                    data: 'id',
                    render: function(data, type) {
                        let localRetri = JSON.parse(window.localStorage.getItem("localData")) || [];
                        return (localRetri.length == 0) ?
                            `<input type="checkbox" value="${data}" onclick='checkBox(this)' id="1_${data}">` :
                            (localRetri.find(element => element == data) == data) ?
                            `<input type="checkbox" value="${data}" onclick='checkBox(this)' id="1_${data}" checked>` :
                            `<input type="checkbox" value="${data}" onclick='checkBox(this)' id="1_${data}">`
                    }

                },
                {
                    data: 'image',
                    render: function(data, type) {
                        const image = `<img src= "{{ filedopath('/items/' . '${data}') }}"/>`;
                        return image;
                    }
                },
                {
                    data: 'product_code',
                    name: 'items.product_code'
                },
                {
                    data: 'old_price'
                },
                {
                    data: 'new_price'
                },
                {
                    data: 'date_time',
                },
                {
                    data: 'unset_discount',
                    render: function(data, type, row) {
                        console.log(row);
                        var discountButton =
                            `<button type="button" onclick="Delete(${data})" class="btn btn-block bg-gradient-danger btn-sm">Unset Discount</button>`;
                        var deleteFunction = `
                  <form id="${data}_delete_form"
                        action="{{ url('backside/shop_owner/item/discount_remove') }}"
                        method="POST"
                        style="display: none;">
                      @csrf
                      {{ method_field('DELETE') }}
                       <input type="hidden" name="item_id" value="${row.item_id}"/>
                      <input type="hidden" name="id" value="${data}"/>
                  </form></td>`;
                        var result = discountButton + deleteFunction;
                        return result;
                    }
                },
            ],
            dom: 'lBfrtip',
                "responsive": true,
                "autoWidth": false,
        });
    </script>
@endpush
