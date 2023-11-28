@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Shop Chat Detail')

@section('content')
    <div class="wrapper">
        @include('backend.super_admin.loading')
        @include('backend.super_admin.navbar')
        @include('backend.super_admin.sidebar')
        <section class="content-wrapper">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12 col-md-6 mt-4 mb-3 p-2">
                        @foreach ($shop_owner->ShopName as $s)
                            <h1 class="font-weight-bolder">{{ $s->shop_name }}</h1>
                        @endforeach
                        <span class="badge badge-primary">Total</span> -
                        <span class="font-weight-bolder">{{ $counts->count() }}</span>
                    </div>
                    <form action="{{url('backside/super_admin/shopowner_using_chat_detail/'.$shop_id->id)}}" method="GET">
                        <div class="d-flex justify-content-end my-3">
                            <div class="form-group mr-md-2">
                                <fieldset>
                                    <legend>From Date</legend>
                                    <input type="text" name="from" value="{{$from}}" id='search_fromdate_shop' class="shopdatepicker form-control"
                                        placeholder='Choose date' autocomplete="off" />
                                </fieldset>
                            </div>
                            <div class="form-group mr-md-2">
                                <fieldset>
                                    <legend>To Date</legend>
                                    <input type="text" name="to" value="{{$to}}" id='search_todate_shop' class="shopdatepicker form-control"
                                        placeholder='Choose date' autocomplete="off" />
                                </fieldset>
                            </div>
                            <div class="pr-md-4 mt-4">
                                <input type='submit' id="shop_search_button" value="Search" class="btn bg-info">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row justify-content-center  mt-5">
                    <div class="col-12 col-lg-8 p-lg-5 ">
                        <div class="p-1">
                            <div class="chart-lists">
                                @forelse ($messages_all_users as $m)
                                    @foreach ($m->UserName as $u)
                                        <div class="card direct-chat direct-chat-primary"
                                            style="position: relative; left: 0px; top: 0px;">
                                            <div class="card-header ui-sortable-handle chat-title-hight"
                                                style="cursor: move;">
                                                <div class="d-flex justify-content-between align-items-center w-100">
                                                    <div class="chat-title">
                                                        <h3 class="card-title">{{ $u->username }}</h3>
                                                        <span>( {{ $u->phone }} )</span>
                                                    </div>
                                                    <div class="card-tools d-flex aligin-items-center">
                                                        <div class="nav-item">
                                                            <a class="nav-link text-black-50" href="#" role="button"
                                                                onclick="navbarSearch(this)">
                                                                <i class="fas fa-search"></i>
                                                            </a>
                                                            <div class="navbar-search-block">
                                                                <div class="form-inline mt-3">
                                                                    <div class="input-group input-group-sm">
                                                                        <input class="form-control form-control-navbar"
                                                                            type="search" placeholder="Search"
                                                                            aria-label="Search">
                                                                        <div class="input-group-append">
                                                                            <button class="btn btn-navbar" type="button">
                                                                                <i class="fas fa-search"></i>
                                                                            </button>
                                                                            <button class="btn btn-navbar" type="button"
                                                                                onclick="navbarSearchClose(this)">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-tool my-chat-toggle">
                                                            <!--data-card-widget="collapse"-->
                                                                <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body direct-chat-body">
                                                <!-- Conversations are loaded here -->
                                                <div class="direct-chat-messages">
                                                    <!-- Message. Default to the left -->
                                                    @foreach ($messages as $mg)
                                                        @if ($mg->message_user_id === $m->message_user_id)
                                                            @if ($mg->type === 'text')
                                                                @if ($mg->from_role === 'user')
                                                                    <div class="direct-chat-msg mb-3">
                                                                        <div class="chat-info">
                                                                            <span class="direct-chat-name ml-1">User</span>
                                                                            <span
                                                                                class="direct-chat-timestamp ml-3 mt-1 time-font">{{ $mg->created_at->format('d M h:i A') }}</span>
                                                                        </div>
                                                                        <!-- /.direct-chat-infos -->
                                                                        <img class="direct-chat-img"
                                                                            src="{{ asset('images/chat/user-1.png') }}"
                                                                            alt="message user image">
                                                                        <!-- /.direct-chat-img -->
                                                                        <div class="position-relative">
                                                                            <div class="my-direct-chat-text rounded">
                                                                                {{ $mg->message }}
                                                                            </div>
                                                                        </div>
                                                                        <!-- /.direct-chat-text -->
                                                                    </div>
                                                                @elseif($mg->from_role === 'shopowner')
                                                                    <div class="direct-chat-msg right mb-3">
                                                                        <div
                                                                            class="d-flex justify-content-end align-items-center">
                                                                            <span
                                                                                class="direct-chat-timestamp time-font mr-2">{{ $mg->created_at->format('d M h:i A') }}</span>
                                                                            <span
                                                                                class="direct-chat-name float-right">Owner</span>


                                                                        </div>
                                                                        <!-- /.direct-chat-infos -->
                                                                        <img class="direct-chat-img"
                                                                            src="{{ asset('images/chat/user-2.png') }}"
                                                                            alt="message user image">
                                                                        <!-- /.direct-chat-img -->
                                                                        <div class="position-relative">
                                                                            <div class="my-direct-chat-text-2 rounded">
                                                                                {{ $mg->message }}
                                                                            </div>
                                                                        </div>

                                                                        <!-- /.direct-chat-text -->
                                                                    </div>
                                                                @endif
                                                            @elseif($mg->type === 'post')
                                                                <div class="direct-chat-msg position-relative mb-4">
                                                                    <div class="chat-info">
                                                                        <span class="direct-chat-name ml-1">User</span>
                                                                        <span
                                                                            class="direct-chat-timestamp ml-3 mt-1 time-font">{{ $mg->created_at->format('d M h:i A') }}</span>
                                                                    </div>
                                                                    <!-- /.direct-chat-infos -->
                                                                    <img class="direct-chat-img"
                                                                        src="{{ asset('images/chat/user-1.png') }}"
                                                                        alt="message user image">
                                                                    <!-- /.direct-chat-img -->
                                                                    <div class="my-direct-chat-text rounded">

                                                                        @php
                                                                            $item = json_decode($mg->message, true);
                                                                        @endphp
                                                                        <p> Product Code :
                                                                            {{ print_r($item['product_code']) }}</p>
                                                                    </div>
                                                                    <!-- /.direct-chat-text -->
                                                                </div>
                                                            @elseif($mg->type === 'image')
                                                                @foreach ($mg->message as $image)
                                                                    @if ($mg->from_role === 'user')
                                                                        <div class="direct-chat-msg mb-3">
                                                                            <div class="chat-info">
                                                                                <span
                                                                                    class="direct-chat-name ml-1">User</span>
                                                                                <span
                                                                                    class="direct-chat-timestamp ml-3 mt-1 time-font">{{ $mg->created_at->format('d M h:i A') }}</span>
                                                                            </div>
                                                                            <!-- /.direct-chat-infos -->
                                                                            <img class="direct-chat-img"
                                                                                src="{{ asset('images/chat/user-1.png') }}"
                                                                                alt="message user image">
                                                                            <!-- /.direct-chat-img -->
                                                                            <div class="">
                                                                                <img src="{{ asset('images/chat/' . $image) }}"
                                                                                    alt="image"
                                                                                    class="w-25 my-2 ml-2 rounded">
                                                                            </div>
                                                                            <!-- /.direct-chat-text -->
                                                                        </div>
                                                                    @elseif($mg->from_role === 'shopowner')
                                                                        <div class="direct-chat-msg right mb-3">
                                                                            <div
                                                                                class="d-flex justify-content-end align-items-center">
                                                                                <span
                                                                                    class="direct-chat-timestamp time-font mr-2">{{ $mg->created_at->format('d M h:i A') }}</span>
                                                                                <span
                                                                                    class="direct-chat-name float-right">Owner</span>
                                                                            </div>
                                                                            <!-- /.direct-chat-infos -->
                                                                            <img class="direct-chat-img"
                                                                                src="{{ asset('images/chat/user-2.png') }}"
                                                                                alt="message user image">
                                                                            <!-- /.direct-chat-img -->
                                                                            <div class="">
                                                                                <img src="{{ asset('images/chat/' . $image) }}"
                                                                                    alt="image"
                                                                                    class="w-25 float-right rounded mr-2 mt-2">
                                                                            </div>
                                                                            <!-- /.direct-chat-text -->
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    <!-- /.direct-chat-msg -->
                                                </div>
                                                <!--/.direct-chat-messages-->


                                                <!-- /.direct-chat-pane -->
                                            </div>
                                            <!-- /.card-body -->

                                        </div>
                                        <!-- /.card-end -->
                                    @endforeach
                                @empty
                                    <div class="w-100 d-flex justify-content-center align-items-center data-not-found">
                                        <h3>No Data found</h3>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-8">
                        {{ $messages_all_users->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('css')
    <style>
        .chat-info {
            display: flex;
            align-items: center;
        }

        .chat-title-hight {
            height: 60px;
        }


        .direct-chat-body .direct-chat-messages {
            height: 400px !important;
        }

        .my-direct-chat-text {
            position: absolute;
            left: 55px;
            background-color: #d2d6de;
            height: auto;
            width: auto;
            padding: 10px;
            cursor: pointer;
        }

        .my-direct-chat-text::before {
            content: '';
            top: 10px;
            left: -14px;
            border: 7px solid #fff;
            border-right-color: #d2d6de;
            position: absolute;
        }

        .my-direct-chat-text-2 {
            position: absolute;
            right: 55px;
            background-color: #3490dc;
            height: auto;
            width: auto;
            padding: 10px;
            color: #fff;
            cursor: pointer;
        }

        .my-direct-chat-text-2::after {
            content: '';
            top: 10px;
            right: -14px;
            border: 7px solid #fff;
            border-left-color: #3490dc;
            position: absolute;

        }

        .time-font {
            font-size: 10px;
        }

        .data-not-found {
            height: 500px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $("#loader").hide();
        $(".direct-chat-body").hide();
        $(document).ready(function() {
            $(".shopdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });
            $(".shopactdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $(".my-chat-toggle").on("click", (e) => {
                $(e.currentTarget.offsetParent.parentElement.lastElementChild).toggle();
                $(e.currentTarget.lastElementChild).toggleClass('fas fa-plus fas fa-minus');
            });

            $("#search").on("keyup", function(e) {
                console.log($("#search").offsetParent());
                console.log($("#search").val());
            });


        });

        function navbarSearch(e) {
            $(e).hide();
            $(e.parentElement.parentElement.parentElement.firstElementChild).hide();
            $(e.parentElement.parentElement.lastElementChild).hide();
            $(e.parentElement.lastElementChild).fadeIn();
        }

        function navbarSearchClose(e) {
            $(e.offsetParent.offsetParent.parentElement.firstElementChild).fadeIn();
            $(".my-chat-toggle").fadeIn();
            $(".chat-title").fadeIn();
            $(e.offsetParent.offsetParent).hide();
        }
    </script>
@endpush
