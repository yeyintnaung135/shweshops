<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" sizes="19x19" href="{{ url('images/logo/favicon.png')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php
    // if (session()->has('guest_id')) {
    //     $getid = \App\Guestoruserid::where('guest_id', session()->get('guest_id'));
    //     \App\frontuserlogs::where('userorguestid', $getid->first()->id)->delete();
    //     $getid->delete();
    //     }
    ?>
    @if(\Illuminate\Support\Facades\Session::has('loginedSO'))
        <script>
            window.facebook = {{$is_fb_on}};

            var myItem = localStorage.getItem('guest_id');

            localStorage.clear();
            localStorage.setItem('guest_id', myItem);

        </script>
    @endif
    {{--    <script>--}}
    {{--        localStorage.clear();--}}

    {{--    </script>--}}
    @if(Auth::check())
        <?php
      
            $shopid = Auth::guard('shop_owners_and_staffs')->user()->shop_id;

   
        ?>
        <script>
            window.userid = {{$shopid}};

            function calculateVh() {
                var vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', vh + 'px');
            }

            // Initial calculation
            calculateVh();

            // Re-calculate on resize
            window.addEventListener('resize', calculateVh);

            // Re-calculate on device orientation change
            window.addEventListener('orientationchange', calculateVh);
        </script>
    @endif


    <link rel="stylesheet" type="text/css" href="{{url('plugins/jquery-ui/jquery-ui.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{url('fonts/ssp.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">

    {{-- select2 --}}
    <link href="{{asset('assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css">

    <!-- DataTables -->
    <link
        rel="stylesheet"
        href="{{url('test/css/fancybox.css')}}"
    />
    <link rel='stylesheet' id='ftc-style-css' href="{{url('test/wp-content/themes/karo1/style.css')}}" type='text/css'
          media='all'/>
    <link rel="stylesheet" href="{{url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
{{--    <link rel="stylesheet" href="{{url('plugins/datatables-select/css/select.bootstrap4.css')}}">--}}
    <link rel="stylesheet" href="{{url('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{url('test/css/bootstrap-toggle.css')}}">

    <!-- <script> -->
    {{--        window.userid = {{\Illuminate\Support\Facades\Auth::user()->id}};--}}
<!-- </script> -->

    <style>
        @font-face {
            font-family: 'Myanmar3';
            src: local('Myanmar3'), url("{{url('mmfont/PyidaungsuZawDecode.woff2?93a8fffb927d8bfcaac5683829dcd048')}}") format('woff2'), url("{{url('PyidaungsuZawDecode.woff?0e8dd9ee5f902f7ff573524de8b4f94d')}}") format('woff');
        }

        .swal-yk-title {
            color: #28a745 !important;
        }
    </style>
    <style>
        /* .chat-image-holder img {
            width: 150px;
        }
        .chat-image-holder .chat-list-forshow-close{
            right: -5px !important;
        }
        .chat-image-forshow-wrapper .chat-send-image {
            border: none !important;
            padding: 7px !important;
        } */
        .sop-font, .sn-product-title {
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        .yk-circle {
            border: 2px solid black;
            width: 36px;
            height: 36px;
            border-radius: 20px;
            text-align: center;
        }

        .yk-info {
            color: black;
        }

        .yk-info .yk-tootips {
            border: 2px solid #680606;
            background: #730d18;
            color: white;
            padding: 10px;
            width: 333px;
            position: absolute;
            left: 154px;
            z-index: 2222;
            visibility: hidden;
            font-family: 'Myanmar3', Sans-Serif !important;
            line-height: 1.5;


        }

        .yk-info:hover .yk-tootips {
            visibility: visible;
        }

        .yk-background {
            background-color: #f7b538;

        }

        .yk-btn-success {
            color: #fff;
            background-color: #f7b538;
            border-color: #ffa713;
        }

        .yk-btn-success:hover {
            color: #fff;
            background-color: #f7b538;
            border-color: #d99421;
        }

        html, body {
            height: 100%;
            margin: 0;
            overflow: auto;
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        h1 {
            font-weight: bold !important;
        }

        /* zh-media-query */
        @media (max-width: 576px) {
            .zh-header_shop {
                margin-left: 0% !important;
            }

            .yk-info .yk-tootips {
                border: 2px solid #680606;
                background: #730d18;
                color: white;
                padding: 10px;
                width: 314px;
                position: absolute;
                left: 14px;
                z-index: 2222;
                visibility: hidden;
                font-family: 'Myanmar3', Sans-Serif !important;
                line-height: 1.5;


            }
        }

    </style>
    @stack('css')
</head>
<body onbeforeunload="useroffline()" class="hold-transition sidebar-mini">
@php
    use App\Models\Shops;
    if($is_chat_on){
    if(Auth::guard('shop_owners_and_staffs')->check() ){

           $current_shop=Shops::where('id',Auth::guard('shop_owners_and_staffs')->user()->shop_id)->first();
      
      if(Auth::guard('shop_owners_and_staffs')->user()->role_id == 4) {
        $shop_role = Auth::guard('shop_owners_and_staffs')->user()->name . ' (Owner)';
      } else if(Auth::guard('shop_owners_and_staffs')->user()->role->id == 1) {
        $shop_role = Auth::guard('shop_owners_and_staffs')->user()->name . ' (Admin)';
      } else if(Auth::guard('shop_owners_and_staffs')->user()->role->id== 2) {
        $shop_role = Auth::guard('shop_owners_and_staffs')->user()->name . ' (Manager)';
      } else if(Auth::guard('shop_owners_and_staffs')->user()->role->id== 3) {
        $shop_role = Auth::guard('shop_owners_and_staffs')->user()->name . ' (Staff)';
      }
    }
    }

@endphp
<div class="wrapper" id="backend" style="height: 100%;">
    @if($is_chat_on='on')

        @if(isset(Auth::guard('shop_owners_and_staffs')->user()->id))

            <shopownerchatwrapper
                ref="chatwrapper"
                v-on:getfromid="getfromidparent"
                v-bind:shopid="{{$current_shop->id}}"
            ></shopownerchatwrapper>
            <shopownerchattemplate ref="chatref" v-on:openmain="toopenmainchatwrapper"
                                   v-bind:chatdatafromparent="this.chatdata"
                                   v-bind:shopdatafromparent="{{$current_shop}}"
                                   v-bind:shop_role="'{{ $shop_role }}'"
            ></shopownerchattemplate>

        @endif
    @endif

    @yield('content')


</div>
<!-- ./wrapper -->

<!-- jQuery -->

<script type='text/javascript' src="{{url('js/backend.js')}}"></script>
<script src="{{url('test/js/fancybox.js')}}"></script>
<script src="{{url('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{url('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{url('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{url('js/be7d01d228.js')}}" crossorigin="anonymous"></script>
<script src="{{url('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/datatables-select/js/select.bootstrap4.js')}}"></script>

<script src="{{url('plugins/datatables-select/js/dataTables.select.js')}}"></script>
<script src="{{url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<script src="{{url('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script src="{{url('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{url('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{url('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- summernote -->
<link rel="stylesheet" href="{{ url('plugins/summernote/summernote-bs4.min.css') }}">
<script src="{{ url('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{url('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('dist/js/demo.js')}}"></script>
<!-- Page specific script -->
<script src="{{url('plugins/sweetalert2/sweetalert2.all.js')}}"></script>
<link rel="stylesheet" href="{{url('test/css/sntable.css')}}">

{{-- Sweet Alert --}}
<script src="{{url('plugins/sweetalert2/sweetalert2.all.js')}}"></script>
<script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>

{{-- select2 --}}
<script src="{{asset('assets/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>

@push('scripts')
    <script type="text/javascript">
        //test

        // Customize Fancybox
        Fancybox.bind('[data-fancybox="gallery"]', {
            Carousel: {
                on: {
                    change: (that) => {
                        mainCarousel.slideTo(mainCarousel.findPageForSlide(that.page), {
                            friction: 0,
                        });
                    },
                },
            },
        });

        function useroffline() {
            if (typeof Window.userid != undefined) {
                return Window.allfrommsg.sendwhatuserisoffline(window.userid);

            }
        }

        let data = new Array();
        let localData = new Array();
        let item_id = new Array();
        let boxes = new Array();

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $.fn.dataTable
                .tables({visible: true, api: true})
                .columns.adjust().responsive.recalc();
        })
        //items table end


        //Unique Item Activity Table
        $('#uniqueitemsActivityTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backside.shop_owner.items.uniquegetitems_activity_log') }}",

            columns: [
                {data: 'id',},
                {data: 'item_code'},
                {data: 'name'},
                {data: 'user_id'},
                {data: 'user_name'},
                {data: 'created_at'}

            ],

            responsive: true,
            lengthChange: true,
            // searching: false,
            autoWidth: false,
            paging: true,
            dom: 'Blfrtip',
            buttons: ["copy", "csv", "excel", "pdf", "print"],
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: 2},
                {responsivePriority: 3, targets: 3},
                {responsivePriority: 4, targets: 4},
            ],
            language: {
                "search": '<i class="fa-solid fa-search"></i>',
                "searchPlaceholder": 'Search...',
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>',// or '←'


                    "order": [[5, "desc"]],

                }
            }
        });

        // {{--                    // Append to data--}}
        // {{--                    data.searchByFromdate = from_date;--}}
        // {{--                    data.searchByTodate = to_date;--}}
        // {{--                }--}}
        // {{--            },--}}
        // {{--            columns: [--}}
        // {{--                {data: 'id'},--}}
        // {{--                {data: 'product_code'},--}}
        // {{--                {data: 'name'},--}}
        // {{--                {data: 'user_id'},--}}
        // {{--                {data: 'user_name'},--}}
        // {{--                {data: 'user_role'},--}}
        // {{--                {data: 'old_price'},--}}
        // {{--                {data: 'old_min_price'},--}}
        // {{--                {data: 'old_max_price'},--}}
        // {{--                {data: 'percent'},--}}
        // {{--                {data: 'old_discount_price'},--}}
        // {{--                {data: 'new_discount_price'},--}}
        // {{--                {data: 'old_discount_min'},--}}
        // {{--                {data: 'old_discount_max'},--}}
        // {{--                {data: 'new_discount_min'},--}}
        // {{--                {data: 'new_discount_max'},--}}
        // {{--                {data: 'created_at'}--}}

        // {{--            ],--}}

        // {{--            responsive: true,--}}
        // {{--            lengthChange: true,--}}
        // {{--            // searching: false,--}}
        // {{--            autoWidth: false,--}}
        // {{--            paging: true,--}}
        // {{--            dom: 'Blfrtip',--}}
        // {{--            buttons: ["copy", "csv", "excel", "pdf", "print"],--}}
        // {{--            columnDefs: [--}}
        // {{--                {responsivePriority: 1, targets: 0},--}}
        // {{--                {responsivePriority: 2, targets: 2},--}}
        // {{--                {responsivePriority: 3, targets: 3},--}}
        // {{--                {responsivePriority: 4, targets: 4},--}}
        // {{--            ],--}}
        // {{--            language: {--}}
        // {{--                "search": '<i class="fa-solid fa-search"></i>',--}}
        // {{--                "searchPlaceholder": 'Search...',--}}
        // {{--                paginate: {--}}
        // {{--                    next: '<i class="fa fa-angle-right"></i>', // or '→'--}}
        // {{--                    previous: '<i class="fa fa-angle-left"></i>' // or '←'--}}
        // {{--                }--}}
        // {{--            },--}}


        // {{--            "order": [[16, "desc"]],--}}

        // {{--        });--}}

        // {{--        // Multiple Damage Activity Table--}}
        // {{--        var multipleDamageActivityTable = $('#multipleDamageActivityTable').DataTable({--}}
        // {{--            processing: true,--}}
        // {{--            serverSide: true,--}}
        // {{--            ajax: {--}}
        // {{--                "url": "{{ route('backside.shop_owner.items.getmultiple_damage_activity_log') }}",--}}
        // {{--                'data': function (data) {--}}
        // {{--                    // Read values--}}
        // {{--                    var from_date = $('#search_fromdate_mulperact').val() ? $('#search_fromdate_mulperact').val() + " 00:00:00" : null;--}}
        // {{--                    var to_date = $('#search_todate_mulperact').val() ? $('#search_todate_mulperact').val() + " 23:59:59" : null;--}}

        // {{--                    // Append to data--}}
        // {{--                    data.searchByFromdate = from_date;--}}
        // {{--                    data.searchByTodate = to_date;--}}
        // {{--                }--}}
        // {{--            },--}}
        // {{--            columns: [--}}
        // {{--                {data: 'id'},--}}
        // {{--                {data: 'product_code'},--}}
        // {{--                {data: 'name'},--}}
        // {{--                {data: 'user_id'},--}}
        // {{--                {data: 'user_name'},--}}
        // {{--                {data: 'user_role'},--}}
        // {{--                {data: 'name'},--}}
        // {{--                {data: 'decrease'},--}}
        // {{--                {data: 'fee'},--}}
        // {{--                {data: 'undamage'},--}}
        // {{--                {data: 'damage'},--}}
        // {{--                {data: 'expensive_thing'},--}}
        // {{--                {data: 'new_decrease'},--}}
        // {{--                {data: 'new_fee'},--}}
        // {{--                {data: 'new_undamage'},--}}
        // {{--                {data: 'new_damage'},--}}
        // {{--                {data: 'new_expensive_thing'},--}}
        // {{--                {data: 'created_at'}--}}

        // {{--            ],--}}

        // {{--            responsive: true,--}}
        // {{--            lengthChange: true,--}}
        // {{--            // searching: false,--}}
        // {{--            autoWidth: false,--}}
        // {{--            paging: true,--}}
        // {{--            dom: 'Blfrtip',--}}
        // {{--            buttons: ["copy", "csv", "excel", "pdf", "print"],--}}
        // {{--            columnDefs: [--}}
        // {{--                {responsivePriority: 1, targets: 0},--}}
        // {{--                {responsivePriority: 2, targets: 2},--}}
        // {{--                {responsivePriority: 3, targets: 3},--}}
        // {{--                {responsivePriority: 4, targets: 4},--}}
        // {{--            ],--}}
        // {{--            language: {--}}
        // {{--                "search": '<i class="fa-solid fa-search"></i>',--}}
        // {{--                "searchPlaceholder": 'Search...',--}}
        // {{--                paginate: {--}}
        // {{--                    next: '<i class="fa fa-angle-right"></i>', // or '→'--}}
        // {{--                    previous: '<i class="fa fa-angle-left"></i>' // or '←'--}}
        // {{--                }--}}
        // {{--            },--}}


        // {{--            "order": [[17, "desc"]],--}}

        // {{--        });--}}

        // User Activity Table
        var usersActivityTable = $('#usersActivityTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': "{{ route('backside.shop_owner.users.getusers_activity_Log') }}",
                'data': function (data) {
                    // Read values
                    var from_date = $('#search_fromdate_user').val() ? $('#search_fromdate_user').val() + " 00:00:00" : null;
                    var to_date = $('#search_todate_user').val() ? $('#search_todate_user').val() + " 23:59:59" : null;

                    // Append to data
                    data.searchByFromdate = from_date;
                    data.searchByTodate = to_date;
                }
            },
            columns: [
                {data: 'id'},
                {data: 'product_code'},
                {data: 'item_name'},
                {data: 'user_name'},
                {data: 'action'},
                {
                    data: 'btn',
                    render: function (data, type, row) {
                        if (row.action == 'Edit') {
                            var detail = `<button class="btn btn-primary" data-toggle="modal" data-target="#item_myModal" onclick="checkItemDetail(:id, :action)"><span class="fa fa-eye"></span></button>`;
                            detail = detail.replace(':id', data);
                            detail = detail.replace(':action', "'" + row.action + "'");
                        } else {
                            detail = null;
                        }
                        return detail;
                    }
                },
                {data: 'role'},
                {data: 'created_at'}

            ],

            responsive: true,
            lengthChange: true,
            autoWidth: false,
            paging: true,
            dom: 'Blfrtip',
            buttons: ["copy", "csv", "excel", "pdf", "print"],
            columnDefs: [
                {responsivePriority: 0, targets: 1},
                {responsivePriority: 1, targets: 2},
                {responsivePriority: 2, targets: 3},
                {
                        "targets": [5],
                        'orderable': false,
                    }
                // { responsivePriority: 3, targets: 4},
            ],
            language: {
                "search": '<i class="fa-solid fa-search"></i>',
                "searchPlaceholder": 'Search...',
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←'
                }
            },
            "order": [[7, "desc"]],
        });

        var backroleActivityTable = $('#backroleActivityTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route('backside.shop_owner.getbackrole') }}",
                'data': function (data) {
                    // Read values
                    var from_date = $('#search_fromdate_role').val() ? $('#search_fromdate_role').val() + " 00:00:00" : null;
                    var to_date = $('#search_todate_role').val() ? $('#search_todate_role').val() + " 23:59:59" : null;

                    // Append to data
                    data.searchByFromdate = from_date;
                    data.searchByTodate = to_date;
                }
            },
            columns: [
                {data: 'id'},
                {data: 'user_name'},
                {data: 'user_role'},
                {data: 'action'},
                {
                    data: 'btn',
                    render: function (data, type, row) {
                        if (row.action == 'edit') {
                            var detail = `<button class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="checkDetail(:id, :action)"><span class="fa fa-eye"></span></button>`;
                            detail = detail.replace(':id', data);
                            detail = detail.replace(':action', "'" + row.action + "'");
                        } else {
                            detail = null;
                        }
                        return detail;
                    }
                },
                {data: 'name'},
                {data: 'role'},
                {data: 'created_at'}

            ],

            responsive: true,
            lengthChange: true,
            autoWidth: false,
            paging: true,
            dom: 'Blfrtip',
            buttons: ["copy", "csv", "excel", "pdf", "print"],
            columnDefs: [
                {responsivePriority: 1, targets: 1},
                {responsivePriority: 2, targets: 2},
                {responsivePriority: 3, targets: 3},
                {responsivePriority: 4, targets: 4},
                {
                        "targets": [4],
                        'orderable': false,
                }
            ],
            language: {
                "search": '<i class="fa-solid fa-search"></i>',
                "searchPlaceholder": 'Search ...',
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←'
                }
            },
            "order": [[7, "desc"]],

        });

        $(function () {

            $("#datatable").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                'columnDefs': [
                    {responsivePriority: 1, targets: 2},
                    {responsivePriority: 2, targets: 1},
                    {responsivePriority: 3, targets: 3},
                    {
                        "targets": [4],
                        'orderable': false,
                    }
                ],
                language: {
                    "search": '<i class="fa-solid fa-search sn-search-icon"></i>',
                    "searchPlaceholder": 'Search by name or role or phone',
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>', // or '→'
                        previous: '<i class="fa fa-angle-left"></i>' // or '←'
                    }
                },
                "order": [0, 'desc']
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


            $('#shopownerItemList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('backside.shop_owner.items.getItems') }}",

                columns: [
                    {data: 'id',},
                    {data: 'name'},
                    {data: 'description'},
                    {
                        data: 'price',
                        render: function (data) {
                            return `<div> ${data[0]} </div>`;
                        }

                    },
                    {
                        data: 'action',
                        render: function (data, type) {
                            var info = `<a style="margin-right: 5px;" class="btn btn-sm btn-success" href="{{ route ('backside.shop_owner.items.show',['item'=>':id'])}}"><span class="fa fa-info-circle"></span></a>`;
                            info = info.replace(':id', data);
                            var edit = `<a class="btn btn-sm btn-primary" href="{{ route ('backside.shop_owner.items.edit',['item'=>':id'])}}"><span class="fa fa-edit"></span></a>`;
                            edit = edit.replace(':id', data);
                            return info + edit;
                        }
                    },
                    {data: 'created_at'}

                ],
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                paging: true,
                dom: 'Blfrtip',
                buttons: ["copy", "csv", "excel", "pdf", "print"],
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: 2},
                    {responsivePriority: 3, targets: 3},
                    {responsivePriority: 4, targets: 4},
                    {
                        'targets': [4],
                        'orderable': false,
                    },
                    {
                        'orderable': false,
                        'className': 'select-checkbox',
                        'targets': 2
                    },
                    {
                        'targets': [5],
                        'visible': false,
                        'searchable': false,
                    }
                ],
                language: {
                    "search": '<i class="fa-solid fa-search"></i>',
                    "searchPlaceholder": 'Search...',
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>', // or '→'
                        previous: '<i class="fa fa-angle-left"></i>' // or '←'
                    }
                },


                "order": [[5, "desc"]],

            });

            $('#templateTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('backside.shop_owner.template.get_template') }}",

                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'undamage_product'},
                    {data: 'damage_product'},
                    {data: 'valuable_product'},
                    {
                        data: 'action',
                        render: function (data, type) {
                            var info = `<a style="margin-right: 5px;" class="btn btn-sm btn-danger" href="{{ route ('backside.shop_owner.template.destroy',['id'=>':id'])}}"><span class="fa fa-trash"></span></a>`;
                            info = info.replace(':id', data);
                            var edit = `<a class="btn btn-sm btn-primary" href="{{ route ('backside.shop_owner.template.edit',['id'=>':id'])}}"><span class="fa fa-edit"></span></a>`;
                            edit = edit.replace(':id', data);
                            return info + edit;
                        }
                    },
                    {data: 'created_at'}

                ],
                responsive: true,
                lengthChange: true,
                // pageLength: 2,
                autoWidth: false,
                paging: true,

                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: 2},
                    {responsivePriority: 3, targets: 3},
                    {responsivePriority: 4, targets: 4},
                    {
                        'targets': [4],
                        'orderable': false,
                    },
                    {
                        'targets': [5],
                        'orderable': false,
                    },
                    {
                        'targets': [6],
                        'visible': false,
                        'searchable': false,
                    }
                ],
                language: {
                    "search": '<i class="fa-solid fa-search sn-search-icon" style="left: 12px;"></i>',
                    "searchPlaceholder": 'Search...',
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>', // or '→'
                        previous: '<i class="fa fa-angle-left"></i>' // or '←'
                    }
                },


                "order": [[4, "desc"]],


            });


        });


        if (window.performance) {
            localStorage.removeItem('localData');
        }

        // shop_view
        $('#shopViewTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backside.shop_owner.detail.get_shop_view') }}",

            columns: [
                {data: 'id'},
                {data: 'shop'},
                {data: 'shop_name'},
                {data: 'user_id'},
                {data: 'user_name'},
                {data: 'created_at'},
            ],
            responsive: true,
            lengthChange: true,
            // pageLength: 2,
            autoWidth: false,
            paging: true,

            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: 2},
                {responsivePriority: 3, targets: 3},
                {responsivePriority: 4, targets: 4},
                {
                    'targets': [2, 4, 5],
                    'orderable': false,
                },
                {
                    'targets': [5],
                    'visible': true,
                    'searchable': false,
                }
            ],
            language: {
                "search": '<i class="fa-solid fa-search sn-search-icon" style="left: 12px;"></i>',
                "searchPlaceholder": 'Search...',
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←'
                }
            },


            "order": [[5, "desc"]],


        });

        // buy now click
        $('#buynowclickTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backside.shop_owner.detail.get_buy_now_click') }}",

            columns: [
                {data: 'id'},
                {data: 'user_id'},
                {data: 'user_name'},
                {data: 'created_at'}


            ],
            responsive: true,
            lengthChange: true,
            // pageLength: 2,
            autoWidth: false,
            paging: true,

            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: 2},
                {responsivePriority: 3, targets: 3},
                {
                    'targets': [2, 3],
                    'orderable': false,
                },
                {
                    'targets': [3],
                    'visible': true,
                    'searchable': false,
                }
            ],
            language: {
                "search": '<i class="fa-solid fa-search sn-search-icon" style="left: 12px;"></i>',
                "searchPlaceholder": 'Search...',
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←'
                }
            },


            "order": [[3, "desc"]],


        });

        // unique add to cart click
        $('#uniqueaddtocartTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backside.shop_owner.detail.get_unique_add_to_cart_click') }}",

            columns: [
                {data: 'id'},
                {data: 'user_id'},
                {data: 'user_name'},
                {data: 'created_at'},

            ],
            responsive: true,
            lengthChange: true,
            // pageLength: 2,
            autoWidth: false,
            paging: true,

            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: 2},
                {responsivePriority: 3, targets: 3},
                {
                    'targets': [2, 3],
                    'orderable': false,
                },
                {
                    'targets': [3],
                    'visible': true,
                    'searchable': false,
                }
            ],
            language: {
                "search": '<i class="fa-solid fa-search sn-search-icon" style="left: 12px;"></i>',
                "searchPlaceholder": 'Search...',
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←'
                }
            },


            "order": [[3, "desc"]],


        });


        // unique whishlist click
        $('#uniquewhishlistTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backside.shop_owner.detail.get_unique_whishlist_click') }}",

            columns: [
                {data: 'id'},
                {data: 'user_id'},
                {data: 'user_name'},
                {data: 'created_at'}


            ],
            responsive: true,
            lengthChange: true,
            // pageLength: 2,
            autoWidth: false,
            paging: true,

            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: 2},
                {responsivePriority: 3, targets: 3},
                {
                    'targets': [2, 3],
                    'orderable': false,
                },
                {
                    'targets': [3],
                    'visible': true,
                    'searchable': false,
                }
            ],
            language: {
                "search": '<i class="fa-solid fa-search sn-search-icon" style="left: 12px;"></i>',
                "searchPlaceholder": 'Search...',
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←'
                }
            },


            "order": [[3, "desc"]],


        });

        // unique whishlist click
        $('#uniqueadsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backside.shop_owner.detail.get_unique_ads_view') }}",

            columns: [
                {data: 'id'},
                {data: 'user_id'},
                {data: 'user_name'},
                {data: 'created_at'},


            ],
            responsive: true,
            lengthChange: true,
            // pageLength: 2,
            autoWidth: false,
            paging: true,

            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: 2},
                {responsivePriority: 3, targets: 3},
                {
                    'targets': [2, 3],
                    'orderable': false,
                },
                {
                    'targets': [3],
                    'visible': true,
                    'searchable': false,
                }

            ],
            language: {
                "search": '<i class="fa-solid fa-search sn-search-icon" style="left: 12px;"></i>',
                "searchPlaceholder": 'Search...',
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←'
                }
            },


            "order": [[3, "desc"]],


        });

        // discount product view
        $('#discountproductviewTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backside.shop_owner.detail.get_discount_product_view') }}",

            columns: [
                {data: 'id'},
                {data: 'user_id'},
                {data: 'user_name'},
                {data: 'created_at'}


            ],
            responsive: true,
            lengthChange: true,
            // pageLength: 2,
            autoWidth: false,
            paging: true,

            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: 2},
                {responsivePriority: 3, targets: 3},
                {
                    'targets': [2, 3],
                    'orderable': false,
                },
                {
                    'targets': [3],
                    'visible': true,
                    'searchable': false,
                }
            ],
            language: {
                "search": '<i class="fa-solid fa-search sn-search-icon" style="left: 12px;"></i>',
                "searchPlaceholder": 'Search...',
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←'
                }
            },


            "order": [[3, "desc"]],


        });

    </script>

    <script src="{{url('test/js/bootstrap-toggle.js')}}"></script>

@endpush

@stack('scripts')

</body>
</html>
