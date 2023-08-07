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
            @if(Session::has('message'))

                <x-alert>

                </x-alert>
        @endif
        <!-- Content Header (Page header) -->
        <section class="content-header sn-content-header">
            <div class="container-fluid">
                @foreach($shopowner as $shopowner )
                @endforeach


            </div><!-- /.container-fluid -->
        </section>

        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-7">
                <div class="row d-flex">
                    <h4 class="text-color">ဆိုင်ခွဲစာရင်းများ</h4>
                    <a class="btn btn-m btn-color ml-3" href="{{route('backside.shop_owner.pos.create_counter')}}">
                    <i class="fa fa-plus mr-2"></i>Create</a>
                </div>
                <div class="row mt-3">
                    <label for="">From:<input type="date" id="start_date"></label>
                    <label for="" class="ml-3">To:<input type="date" id="end_date"></label>
                    <label for="" style="margin-left: 20px;margin-top:30px;">
                        <a href="#" class="btn btn-color btn-m" onclick="typefilter(2)">Search</a>
                    </label>
                </div>
            </div>

        </div>
                <div class="card mt-2">
                    <div class="card-body">
                        <div class=" table-responsive text-black">
                        <table class="table table-striped" id="example23">
                            <thead>
                                <th>နံပါတ်</th>
                                <th>​ဆိုင်ခွဲအမည်</th>
                                <th>​​ကောင်တာအမည်</th>
                                <th>​ဝန်ထမ်းစုစု​ပေါင်းအ​ရေ​အတွက်</th>
                                <th>လိပ်စာ</th>
                                <th>​နေ့စွဲ</th>
                                <th></th>
                            </thead>
                            <tbody class="text-center" id="filter">
                                <?php $i = 1;?>
                                @foreach ($counters as $counter)
                                <tr>
                                 <td>{{$i++}}</td>
                                 <td>{{$counter->shop_name}}</td>
                                 <td>{{$counter->counter_name}}</td>
                                 <td>{{$counter->staff_no}}</td>
                                 <td>{{$counter->address}}</td>
                                 <td> ​
                                    {{$counter->date}}
                                 </td>
                                 <td>
                                    <a href="#myModal{{$counter->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>
                                    <a href="{{route('backside.shop_owner.pos.edit_counter',$counter->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a>
                                 </td>

                                 <div id="myModal{{$counter->id}}" class="modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete List</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center">Are you Sure to Delete this List?</p>
                                            </div>
                                            <div class="modal-footer text-center">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCLE</button>
                                                <button type="button" class="btn btn-color" onclick="suredelete({{$counter->id}})">DELETE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
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
    <script>
        $(document).ready(function(){
            function alignModal(){
        var modalDialog = $(this).find(".modal-dialog");

        // Applying the top margin on modal to align it vertically center
        modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
        }
        // Align modal when it is displayed
        $(".modal").on("shown.bs.modal", alignModal);

        // Align modal when user resize the window
        $(window).on("resize", function(){
            $(".modal:visible").each(alignModal);
        });
            $('#example23').DataTable({

                dom: 'Blfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    processing: true,
                    "ordering": true,
                    "info": true,
                    "paging": true,

            });
            $('#example-getting-started').multiselect();
        });
        function suredelete(id){
                // alert('ok');
                $.ajax({

                    type:'POST',

                    url: '{{route("backside.shop_owner.pos.delete_counter")}}',

                    data:{
                    "_token":"{{csrf_token()}}",
                    "id" : id,
                    },

                    success:function(data){
                        location.reload();
                        // console.log('success');
                    }
                })
        }

        function typefilter(val){
            var dataTable = $('#example23').DataTable();
            var html = '';
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();

            $.ajax({

            type:'POST',

            url: '{{route("backside.shop_owner.pos.counter_type_filter")}}',

            data:{
            "_token":"{{csrf_token()}}",
            "start_date" : start_date,
            "end_date" : end_date,
            "type" : val,
            },

            success:function(data){
                dataTable.clear().draw();
                $.each(data, function(i, v) {
                    var url1 = '{{ route('backside.shop_owner.pos.edit_counter', ':counter_id') }}';

                    url1 = url1.replace(':counter_id', v.id);
                    var html1 = `<div class="d-flex">
                            <a href="#myModal${v.id}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>
                            <a href="${url1}" class="ml-4 text-warning"><i class="fa fa-edit" ></i></a>
                        </div>`;
                    dataTable.row.add([++i,v.shop_name,v.counter_name,v.staff_no,v.address,v.date,html1]).draw();
                })
                }
            })
        }

    </script>
@endpush
@push('css')
    <style>
        body {
            background: #F0F7FA;
            font-family: 'Myanmar3', Sans-Serif !important;
        }
        .btn-color{
        background-color: #780116;
        color: white;
    }
    .btn-color:hover{
            color: white;
        }
    .text-color{
        color: #780116;
    }

    </style>
@endpush

