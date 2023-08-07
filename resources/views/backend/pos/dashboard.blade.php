@extends('layouts.backend.posbackend')
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
               

            </div><!-- /.container-fluid -->
        </section>

        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="logo" >
                                            <img src="{{url('logo/Gold.png')}}" alt="">
                                        </div>
                                    </div>
                            
                                    <div class="col-8" >
                                        <h4 class="font-weight-bold mt-2">{{$gold}}</h4>
                                        <h6 class="text-color mt-1">​ရွှေထည်စုစု​ပေါင်း</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="logo" >
                                            <img src="{{url('logo/Platinum.png')}}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <h4 class="font-weight-bold mt-2">{{$platinum}}</h4>
                                        <h6 class="text-color mt-1">​ပလက်တီနမ်စုစု​ပေါင်း</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="logo" >
                                            <img src="{{url('logo/White-Gold.png')}}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <h4 class="font-weight-bold mt-2">{{$whitegold}}</h4>
                                        <h6 class="text-color mt-1">​​ရွှေဖြူစုစု​ပေါင်း</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="logo" >
                                            <img src="{{url('logo/Diamond.png')}}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <h4 class="font-weight-bold mt-2">{{$kyout}}</h4>
                                        <h6 class="text-color mt-1 d-flex" style="font-size: 15px;">​ကျောက်ထည်စုစု​ပေါင်း</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <h6 class="text-color">ရောင်းအားစုစု​ပေါင်း</h6>​
                                    </div>
                                    <div class="col-3">
                                        {{-- <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                              <a class="nav-link active" href="#profile" role="tab" data-toggle="tab">profile</a>
                                            </li>
                                            <li class="nav-item">
                                              <a class="nav-link" href="#buzz" role="tab" data-toggle="tab">buzz</a>
                                            </li>
                                          </ul> --}}
                                    </div>
                                </div>
                                 <!-- Tab panes -->
                                 {{-- <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="profile"> --}}
                                        <div class="main">
                                            <canvas id="barChart" height="130"></canvas>
                                        </div>
                                    {{-- </div>
                                    <div role="tabpanel" class="tab-pane fade" id="buzz">week</div>
                                  </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-color">ယ​နေ့​ရောင်းအား</h4>
                                <div class="row">
                                    <div class="col-6">
                                        @foreach ($counters as $counter)
                                        <h6 class="font-weight-bold" style="margin-top:30px;">{{$counter->shop_name}}</h6>
                                        @endforeach
                                        <h6 class="font-weight-bold" style="margin-top:30px;">ယ​နေ့​ရွှေ​ပေါက်​စျေး</h6>
                                        {{-- <h6 class="font-weight-bold" style="margin-top:30px;">ယ​နေ့အလဲထည်များ</h6>
                                        <h6 class="font-weight-bold" style="margin-top:30px;">staff စုစု​ပေါင်း</h6>
                                        <h6 class="font-weight-bold" style="margin-top:30px;">ကုန်သည်စုစု​ပေါင်း</h6> --}}
                                    </div>
                                    <div class="col-1">
                                        @foreach ($counters as $counter)
                                        <h6 class="font-weight-bold" style="margin-top:30px;">-</h6>
                                        @endforeach
                                        <h6 class="font-weight-bold" style="margin-top:30px;">-</h6>
                                        {{-- <h6 class="font-weight-bold" style="margin-top:30px;">-</h6>
                                        <h6 class="font-weight-bold" style="margin-top:30px;">-</h6>
                                        <h6 class="font-weight-bold" style="margin-top:30px;">-</h6> --}}
                                    </div>
                                    <div class="col-5">
                                        @foreach ($arr as $ar)
                                        <h6 class="font-weight-bold" style="margin-top:30px;">{{$ar}} ကျပ်</h6>
                                        @endforeach
                                        <h6 class="font-weight-bold" style="margin-top:30px;">{{$gold_price}} ကျပ်</h6>
                                        {{-- <h6 class="font-weight-bold" style="margin-top:30px;">{{$return}}</h6>
                                        <h6 class="font-weight-bold" style="margin-top:30px;">{{$staffs}}</h6>
                                        <h6 class="font-weight-bold" style="margin-top:30px;">{{$sup}}</h6> --}}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-color">​ရွှေ​စျေး အတက်အကျနှုန်းများ</h6>
                                <canvas id="line-chart" height="150"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-color">လတ်တ​လော ပန်းထိမ်ဆိုင်များ</h6>
                                <table class="mt-3 table table table-hover">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;?>
                                        @foreach ($suppliers as $sup)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$sup->shop_name}}</td>
                                        </tr>
                                        @endforeach

                                        @foreach ($counts as $count)
                                        <tr hidden id="seemore">
                                            <td>{{$i++}}</td>
                                            <td>{{$count->shop_name}}</td>
                                        </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                                <a class="text-color text-right mt-2" onclick="seemore()" id="more">Seemore...</a>
                                <a class="text-color text-right mt-2" onclick="seeless()" id="less" hidden>Seeless...</a>
                            </div>
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
        function seemore(){
            $('#seemore').removeAttr('hidden');
            $('#less').removeAttr('hidden');
            $('#more').prop('hidden','hidden');
        }
        function seeless(){
            $('#seemore').prop('hidden','hidden');
            $('#more').removeAttr('hidden');
            $('#less').prop('hidden','hidden');
        }
        $(document).ready(function () {
            $.ajax({
           type:'POST',
           url: '{{route("backside.shop_owner.pos.totalamount")}}',
           dataType:'json',
           data:{
                "_token": "{{ csrf_token() }}",
            },

           success:function(data){
               console.log(data);

            var canvas = document.getElementById("barChart");
            var ctx = canvas.getContext("2d");
// Global Options:
                Chart.defaults.global.defaultFontColor = "#780116";
                Chart.defaults.global.defaultFontSize = 11;
                // Data with datasets options
                var data = {
                    labels: [
                        "January",
                        "Febuary",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December",
                    ],
                    datasets: [
                        {
                            label: "Sale Amount",
                            fill: false,
                            backgroundColor: '#780116',
                            data: [data.jan_income,data.feb_income,data.mar_income,data.apr_income,data.may_income,data.jun_income,data.jul_income,data.aug_income,data.sep_income,data.oct_income,data.nov_income,data.dec_income]
                        }
                    ]
                };

        //         // Notice how nested the beginAtZero is
                var options = {
                    title: {
                        display: true,
                        text: "Monthly Sale Fulfillment",
                        position: "top",
                        fontSize: 14,
                    },
                    scales: {
                        xAxes: [
                            {
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false
                                }
                            }
                        ],
                        yAxes: [
                            {
                                ticks: {
                                    precision: 0
                                    // beginAtZero: true
                                }
                            }
                        ]
                    }
                };

        //         // added custom plugin to wrap label to new line when \n escape sequence appear
                var labelWrap = [
                    {
                        beforeInit: function (chart) {
                            chart.data.labels.forEach(function (e, i, a) {
                                if (/\n/.test(e)) {
                                    a[i] = e.split(/\n/);
                                }
                            });
                        }
                    }
                ];

        //         // Chart declaration:
                var myBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: options,
                    plugins: labelWrap
                });

        //     // end chart
            }
            })

        //start line chart
        $.ajax({
           type:'POST',
           url: '{{route("backside.shop_owner.pos.goldprice")}}',
           dataType:'json',
           data:{
                "_token": "{{ csrf_token() }}",
            },

           success:function(data){
        new Chart(document.getElementById("line-chart"), {
        type: 'line',
        data: {
            labels: [
                        "January",
                        "Febuary",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December",
                    ],
            datasets: [{
                data: [data.jan,data.feb,data.mar,data.apr,data.may,data.jun,data.jul,data.aug,data.sep,data.oct,data.nov,data.dec],
                label: "Gold Price",
                borderColor: "#F9A602",
                fill: false
            },
            ]
        },
        options: {
            title: {
            display: true,
            text: 'Gold Price per month (MMK)'
            }
        }
        });
    }
})
        })
    </script>
@endpush
@push('css')
    <style>
        body {
            background: #F0F7FA;
            font-family: 'Myanmar3', Sans-Serif !important;
        }
        .text-color{
        color: #780116;
    }
        .logo{
        width:70px;
        height:70px;
        border:none;
        border-radius: 70px;
        }

    </style>
@endpush

