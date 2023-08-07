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
                <div class="row d-flex mb-3">
                    <h4 class="text-color">ကြွေးကျန်စာရင်းများ</h4>
                    {{-- <a class="btn btn-m btn-color ml-3" href="{{route('backside.shop_owner.pos.create_diamond')}}">
                    <i class="fa fa-plus mr-2"></i>Create</a> --}}
                    {{-- <div class="dropdown ml-5">
                        <a class="btn btn-m btn-color dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-filter"></i></a>
                        <ul class="dropdown-menu px-1">
                        <li><label><input type="checkbox" id="gold" > ​ရွှေထည်</label></li>
                        <li><label><input type="checkbox" id="kyout"> ​ကျောက်မျက်ရတနာ</label></li>
                        <li><label><input type="checkbox" id="diamond"> စိန်ထည်</label></li>
                        <li><label><input type="checkbox" id="platinum"> ပလက်တီနမ်</label></li>
                        <li><hr class="dropdown-divider"/></li>
                        <li><a href="#" class="btn btn-color btn-sm" style="margin-left: 50px;" onclick="typefilter(1)">Save</a></li>
                        </ul>
                    </div> --}}
                </div>
                <div class="row">
                    <label for="">From:<input type="date" id="start_date"></label>
                    <label for="" class="ml-3">To:<input type="date" id="end_date"></label>
                    <label for="" style="margin-left: 20px;margin-top:30px;"><a href="#" class="btn btn-color btn-m" onclick="typefilter(2)">Search</a></label>
                </div>
                <div class="card mt-2">
                    <div class="card-body">
                        <table class="table table-striped" id="example23">
                            <thead>
                                <th>နံပါတ်</th>
                                <th>​ဝယ်သူအမည်</th>
                                <th>ဖုန်းနံပါတ်</th>
                                <th>လိပ်စာ</th>
                                <th>ပစ္စည်းကုဒ်နံပါတ်</th>
                                <th>ပေးရန်ကျန်ငွေ</th>
                                <th>ဝယ်ယူသည့်နေ့</th>
                                <th></th>
                            </thead>
                            <tbody class="text-center" id="filter">
                                <?php $i=1;?>
                            @foreach ($credits as $credit)
                                <tr>
                                 <td>{{$i++}}</td>
                                 <td>{{$credit->customer_name}}</td>
                                 <td>{{$credit->phone}}</td>
                                 <td>{{$credit->address}}</td>
                                 <td>{{$credit->purchase_code}}</td>
                                 <td>{{$credit->credit}}</td>
                                 <td>{{$credit->purchase_date}}</td>
                                 <td>
                                    <div class="d-flex">
                                        <a href="#myModal{{$credit->id}}" class="btn btn-sm btn-color" data-toggle="modal">Repay</a>
                                        {{-- <a href="#myModal{{$credit->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a> --}}
                                        {{-- <a href="{{route('backside.shop_owner.pos.edit_diamond',$credit->id)}}" class="ml-4 text-warning"><i class="fa fa-edit" ></i></a> --}}
                                        {{-- <a href="#" class="ml-4 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a> --}}
                                    </div>
                                 </td>

                                 <div id="myModal{{$credit->id}}" class="modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Repay List</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center">Are you Sure to pay credit amount for this List?</p>
                                            </div>
                                            <div class="modal-footer text-center">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCLE</button>
                                                <button type="button" class="btn btn-color" onclick="suredelete({{$credit->id}})">REPAY</button>
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
@push('css')
<style>
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
@push('scripts')
    <script type="text/javascript">
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

                    url: '{{route("backside.shop_owner.pos.delete_credit")}}',

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
            // if($("#gold").is(":checked") == true){
            //     html += 'option1'
            // }
            // if($("#kyout").is(":checked") == true){
            //     html += '/option2'
            // }
            // if($("#diamond").is(":checked") == true){
            //     html += '/option3'
            // }
            // if($("#platinum").is(":checked") == true){
            //     html += '/option4'
            // }
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();

            $.ajax({

            type:'POST',

            url: '{{route("backside.shop_owner.pos.credit_type_filter")}}',

            data:{
            "_token":"{{csrf_token()}}",
            "start_date" : start_date,
            "end_date" : end_date,
            "type" : val,
            },

            success:function(data){
                dataTable.clear().draw();
               
                $.each(data.data, function(i, v) {
                    var html1 = `<div class="d-flex">
                                        <a href="#myModal${v.id}" class="btn btn-sm btn-color" data-toggle="modal">Repay</a>
                                    </div>`;
                    dataTable.row.add([++i,v.customer_name,v.phone,v.address,v.purchase_code,v.credit,v.purchase_date,html1]).draw();
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
        background: #780116;
        color:white;
        padding: 5px 25px;
        }

    </style>
@endpush
