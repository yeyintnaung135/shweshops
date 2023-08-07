@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Shop Date Filter')

@section('content')
    @php
        use App\Shopowner;
    @endphp

    <div class="wrapper">
        @include('backend.super_admin.loading')
        @include('backend.super_admin.navbar')
        @include('backend.super_admin.sidebar')
        <section class="content-wrapper">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12 col-md-6  mt-4 mb-3">

                        @foreach ($shop_owner->ShopName as $s)
                            <h1 class="font-weight-bolder">{{ $s->shop_name }}</h1>
                        @endforeach
                        <span class="badge badge-primary">Total</span> -
                        <span class="font-weight-bolder">{{ $messages_all_users->count() }}</span>
                    </div>
                    <div class="col-12 col-md-6 d-flex justify-content-center">
                        <div class=" my-3">
                            <form class="d-flex align-items-center"
                                action="{{ route('shops.shopowner_using_chat_date_filter') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $shop_id->id }}">
                                <div class="form-group mr-md-2">
                                    <fieldset>
                                        <legend>From Date</legend>
                                        <input type="text" id='search_fromdate_shop' name="from"
                                            class="shopdatepicker form-control" placeholder='Choose date'
                                            autocomplete="off" />
                                    </fieldset>
                                </div>
                                <div class="form-group mr-md-2">
                                    <fieldset>
                                        <legend>To Date</legend>
                                        <input type="text" id='search_todate_shop' name="to"
                                            class="shopdatepicker form-control" placeholder='Choose date'
                                            autocomplete="off" />
                                    </fieldset>
                                </div>
                                <div class="pr-md-4">
                                    <input type='submit' id="message_search_button" value="Search" class="btn bg-info"
                                        style="margin-top: 25px;">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8  ">
                        <div class="p-1">

                            <div class="chart-lists">

                                @forelse ($messages_all_users as $m)
                                    @foreach ($m->UserName as $u)
                                        <div class="card direct-chat direct-chat-primary"
                                            style="position: relative; left: 0px; top: 0px;">
                                            <div class="card-header ui-sortable-handle" style="cursor: move;">
                                                <h3 class="card-title">{{ $u->username }}</h3>

                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-tool" title="Contacts"
                                                        data-widget="chat-pane-toggle">
                                                        <i class="fas fa-comments"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
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
                                                                        <h3 class="font-weight-bolder text-uppercase">Item !
                                                                        </h3>
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
        $(document).ready(function() {
            $(".shopdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });
            $(".shopactdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

        });
    </script>
@endpush
