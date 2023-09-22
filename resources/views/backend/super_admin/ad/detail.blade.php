@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Ads Detail')

@section('content')
    <div class="wrapper">
        @include('backend.super_admin.navbar')
        @include('backend.super_admin.sidebar')
        <section class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header p-0">
            </section>
            <div class="container p-lg-3 vh-100 ">
                <div class="row">
                    <div class="col-12 p-0 mt-1 p-lg-3">
                        <div class="mb-4">
                            <div class="cover-image">
                                @if ($ad->deleted_at)
                                    <img src="{{ asset('images/banner/' . $ad->image) }}" alt="cover"
                                        class="w-100 h-100 filter">
                                @else
                                    <img src="{{ asset('images/banner/' . $ad->image) }}" alt="cover" class="w-100 h-100">
                                @endif


                            </div>
                            <br>


                            @if ($ad->deleted_at)
                            <img src="{{ asset('images/banner/thumbs/' . $ad->image_for_mobile) }}" alt="cover"
                                class="w-50 filter">
                            @else
                            <img src="{{ asset('images/banner/thumbs/' . $ad->image_for_mobile) }}" alt="cover" class="w-50">
                            @endif
                            @if ($day && $day <= 1 && $day != 0)
                                <marquee class="bg-warning "><i class="fas fa-exclamation-triangle"></i> လူကြီးမင်း ၏
                                    ကြောငြာ သည် သက်တမ်းကုန်ဆုံးရန် ({{ $day }}) ရက်သာလိုပါတော့သည်။</marquee>
                            @elseif ($hour <= 24 && $hour != 0)
                                <marquee class="bg-warning "><i class="fas fa-exclamation-triangle"></i> လူကြီးမင်း ၏
                                    ကြောငြာ သည် သက်တမ်းကုန်ဆုံးရန် ({{ $hour }}) နာရီသာလိုပါတော့သည်။</marquee>
                            @elseif ($minutes && $minutes <= 1440)
                                <marquee class="bg-warning "><i class="fas fa-exclamation-triangle"></i> လူကြီးမင်း ၏
                                    ကြောငြာ သည် သက်တမ်းကုန်ဆုံးရန် ({{ $minutes }}) မိနစ်သာလိုပါတော့သည်။</marquee>
                            @elseif (empty($day))
                                <marquee class="bg-warning"><i class="fas fa-exclamation-triangle"></i> လူကြီးမင်း ၏ ကြောငြာ
                                    သည် သက်တမ်း ကုန်ဆုံးသွားပါသည်။</marquee>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <h3 class="font-weight-bold">{{ $ad->name }} <span
                                class="sop-font">({{ $shop_name_myan }})</span></h3>
                        <div class="time">
                            <p class="time-d mr-3">
                                @php
                                use Illuminate\Support\Carbon;
                            @endphp
                                @if ($ad->deleted_at)
                                    <span class="text-danger">Start Date</span> - <span
                                        class="line-through">{{ Carbon::createFromFormat('Y-m-d H:i:s', $ad->start)->format('d M Y (h:i A)') }}</span>
                                    </br>
                                    <span class="text-danger">End Date</span> - <span
                                        class="line-through">{{ Carbon::createFromFormat('Y-m-d H:i:s', $ad->end)->format('d M Y (h:i A)') }}</span>
                                    </br>
                                    <span class="text-danger">Expired</span> - <span
                                        class="font-weight-bolder">{{ $ad->deleted_at->diffForHumans() }}</span>
                                @else
                                    <span class="text-danger">Start Date</span> -
                                    <span>{{ Carbon::createFromFormat('Y-m-d H:i:s', $ad->start)->format('d M Y (h:i A)') }}</span>
                                    </br>
                                    <span class="text-danger">End Date</span> -
                                    <span>{{ Carbon::createFromFormat('Y-m-d H:i:s', $ad->end)->format('d M Y (h:i A)') }}</span>
                                    </br>
                                @endif
                            </p>
                            <div class="action mb-4">
                                <a href="{{ route('backside.super_admin.ads.edit', $ad->id) }}" role="button"
                                    class="btn btn-sm btn-success">Edit</a>
                                <button type="submit" class="btn btn-sm btn-danger" form="deleteAd"
                                    onclick="return confirm('Are you sure?')">Delete</button>

                                <a href="{{ route('backside.super_admin.ads.index') }}"
                                    class="btn btn-sm btn-outline-dark">Back</a>
                            </div>
                            <form action="{{ route('backside.super_admin.ads.destroy', $ad->id) }}" id="deleteAd"
                                method="post">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

@endsection

@push('css')
    <style>
        /* .my-container {
          position: relative;
          border:1px solid red;
        } */

        .icon {
            cursor: pointer;
            font-size: 20px;
        }

        .cover-image {
            height: 450px;
            cursor: pointer;
        }

        .time {

            height: 100px;
            /* display: flex; */
        }

        .time-d {
            width: 300px;
        }

        .editFormRow {
            padding: 0px;
            width: 100%;
        }

        .line-through {
            text-decoration: line-through;
        }

        .filter {
            filter: grayscale(100%);
        }

        @media screen and (max-width: 726px) {

            /* Ads Detail  */
            .cover-image {
                height: 200px;
                width: 100%;
            }

            .time {
                display: block;
            }

        }
    </style>
@endpush
