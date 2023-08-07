@extends('layouts.frontend.frontend')
@section('title','Profile')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .my-height-25{
            height: 90px;
        }

        .pointer{
            cursor: pointer;
        }
        .shweshops-secondary-text-color{
            color: rgb(155, 63, 79);
        }
        .shwe-shop-secondary-bg-color{
            background-color: rgb(155, 63, 79) !important;
            color: #fff !important;
        }
        .profile{
            width: 100px;
            height: 100px;
            overflow:hidden;
        }

        .shweshops-points-icon {
            width: 70px;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .gold-points-icon {
            width: 70px;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f7b538;
        }

        .icons{
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .shweshops-point h3{
            font-size: 19.5px;
            font-weight: bold;
            line-height: 15px;
        }


        .my-card{
            height: 500px;
            width: 400px;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 25px 50px -12px !important;
        }

        .my-card-header{
            height: 50px;
            border-bottom:1px solid #dee2e6 ;
            display: flex;
            align-items: center;
            height: 20px;
        }

        .card-header-font-size{
            font-size: 16px;
            font-weight: bold;
        }

        .card-header-inner-font-size{
            font-size: 15px;
        }

        .my-information-header{
            font-size: 20px;
            font-weight: bold;
        }

        .information-lists{
            display: flex;
            justify-content: space-around;
            padding: 20px 0px 20px 0px;
        }
        
        @media screen and (max-width: 997px) {
            .mobile-display-none{
                display: none !important;
            }
            
            .mobile-display-show{
                display: flex !important;
            }

            .sm-count-text{
                font-size: 12px;
            }
            .shweshops-point h3{
                font-size: 15px;
                /* font-weight: bold; */
                line-height: 10px;
            }

            .sm-line-height{
                line-height: 14px;
            }
            
            .shweshops-points-icon {
                width: 40px;
                height: 40px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .gold-points-icon {
                width: 40px;
                height: 40px;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #f7b538;
            }
           
        
             .my-card{
               height: 500px;
               width: 100%;
               box-shadow: rgba(0, 0, 0, 0.25) 0px 0px 0px 0px !important;
            }
   

            .card-header-title{
                font-size: 15px;
            }

            .my-card-body{
                /* border: 1px solid red; */
                padding-left: 5px;
            }
            
            .shweshops-point-title{
                font-size:13px !important;
            }
        }

        @media screen and (max-width: 1642px) {
            .sm-count-text{
                font-size: 12px;
            }
            .sm-line-height{
                line-height: 14px;
            }

            .shweshops-point h3{
                font-size: 15px;
                /* font-weight: bold; */
                line-height: 15px;
            }
            .shweshops-points-icon {
                width: 50px;
                height: 50px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .gold-points-icon {
                width: 50px;
                height: 50px;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #f7b538;
            }
              .my-card{
               height: 500px;
               width: 100%;
               box-shadow: rgba(0, 0, 0, 0.25) 0px 0px 0px 0px !important;
            }
            .card-container{
                width: 400px !important;
            }
        
        }

    </style>
@endpush
@stack('profile-css')
@php
use App\UserPoint;
use App\Point;
use App\ShopOwnerGoldPoint;

    $user = Auth::guard('web')->user();
    $user_id = Auth::guard('web')->id();
    $points = UserPoint::where('user_id',$user_id)
    ->join('points', 'points.id', '=', 'user_points.point_id')
    ->select('count')
    ->get();
    
    $gold_points = ShopOwnerGoldPoint::where('user_id',$user_id)
            ->select('point')
            ->get();
                
    $user_gold_points = 0;
    
    foreach ($gold_points as $item) {
       $user_gold_points += $item['point'];
    } 
           
    $sum = 0;

    foreach ($points as $item) {
        $sum += $item['count'];
    } 
    
    $shweshops_points = Point::all();
    $total = 0;
    foreach($shweshops_points as $item){
       $total += $item['count'];
    }
    
@endphp
@section('content')
@include('layouts.frontend.allpart.for_mobile')
@include('layouts.frontend.allpart.upper_menu')
@include('layouts.frontend.allpart.menu')
  <div class="site-content-container mt-5">
    <div class="container-fluid">
        <div class="row mb-3 mb-md-3">
            <div class="col-12 d-flex justify-content-center">
                <div class="w-100 w-md-25 d-flex justify-content-center">
                    <div class="text-center">
                        <div class="d-flex justify-content-center">
                            <div class="profile mb-2 rounded-circle">
                                @if($user->photo === Null)
                                   <img src="{{ asset('images/user-profile/default-profile.png')}}" alt="" class="w-100">
                                @else
                                <img src="{{ asset($user->photo)}}" alt="" class="w-100">
                                @endif
                            </div>
                        </div>
                        <h3>{{ $user->username }}</h3>
                        <span>Joined since {{ $user->created_at->format('M Y')}}</span>
                        <div class="mt-3 d-flex justify-content-center w-100">
                            <a href="{{ route('backside.user.edit',$user->id )}}" role="button" class="btn shwe-shop-secondary-bg-color btn-sm">
                                Edit Profile   <i class="fas fa-angle-right text-light"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center d-lg-none">
            <div class="col-8 col-md-5 d-flex align-items-center justify-content-center my-height-25">
               <div class="row align-items-center justify-content-center w-100">
                    <div class="col-4 d-block text-center p-1">
                        <span class="shweshops-secondary-text-color font-weight-bolder">0</span><br>
                        <p class="text-black-50 sm-count-text">Order</p>
                    </div>
                    <div class="col-4 d-block text-center p-1">
                        <span class="shweshops-secondary-text-color font-weight-bolder">0</span><br>
                        <p class="text-black-50 sm-count-text">Wishlist</p>
                    </div>
                    <div class="col-4 d-block text-center p-1">
                        <span class="shweshops-secondary-text-color font-weight-bolder">{{ $sum }}</span><br>
                        <p class="text-black-50 sm-count-text sm-line-height">Total Points</p>
                    </div>
              </div>
            </div>
        </div>
        <div class="row justify-content-center align-items-center mb-3">
            <div class="col-6 col-md-5 col-lg-2 d-flex justify-content-center align-items-center p-0">
                <div class="shweshops-points-icon my-2 rounded-circle">
                    <img src="{{ asset('images/user-profile/Shwe-shops-logo.jpg')}}" alt="" class="w-100 rounded-circle">
                </div>
                <div class="shweshops-point ml-1 ml-lg-3">
                   <h3 class="mb-0 shweshops-point-title">Shweshops Points</h3>
                   <span class="text-black-50 sm-count-text">{{ $sum }} Points</span>
                </div>
            </div>
             
             <div class="col-6 order-12 order-md-12 order-lg-0  col-lg-2 p-0  my-height-25 mobile-display-none">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="row align-items-center justify-content-center w-100 mt-1">
                <div class="col-4 d-block text-center p-0">
                    <span class="shweshops-secondary-text-color font-weight-bolder">0</span><br>
                    <p class="text-black-50 sm-count-text">Order</p>
                </div>
                <div class="col-4 d-block text-center p-0">
                    <span class="shweshops-secondary-text-color font-weight-bolder">0</span><br>
                    <p class="text-black-50 sm-count-text">Wishlist</p>
                </div>
                <div class="col-4 d-block text-center p-0">
                    <span class="shweshops-secondary-text-color font-weight-bolder">{{ $sum }}</span><br>
                    <p class="text-black-50 sm-count-text sm-line-height">Total Points</p>
                </div>
              </div>
              </div>
             </div>
          
            <div class="col-6 col-md-5 col-lg-2 d-flex justify-content-center align-items-center ">
                <div class="gold-points-icon my-2 rounded-circle">
                    <img src="{{ asset('images/user-profile/shweshops_points.png')}}" alt="" class="w-75">
                </div>
                <div class="shweshops-point ml-1 ml-lg-3">
                   <h3 class="mb-0 shweshops-point-title">Gold Points</h3>
                   <span class="text-black-50 sm-count-text">0</span>
                </div>
            </div>
        </div>
        <div class="row p-lg-3 p-0">
          <div class="col-12 px-lg-5 p-0">
            <div class="container-fluid">
                <div class="row p-0">
                    <div class="col-12 col-lg-5 p-0 p-lg-3 d-flex justify-content-lg-end  justify-content-center  ">
                        <div class="px-1 px-lg-5 card-container  d-flex justify-content-center">
                            <div class="my-card">
                                <div class="my-card-header card-header-font-size py-lg-4 p-4 mt-lg-3 ">
                                  <div class="icons">
                                      <img src="{{ asset('images/user-profile/account.png')}}" class="w-50" alt="account">
                                  </div>
                                    <span class="card-header-title">Account</span>
                                </div>
                                <div class="my-card-body p-4">
                                    <div class="d-flex justify-content-between pointer mb-4">
                                        <a href="{{ route('backside.user.user_profile')}}" class="text-black-50 card-header-inner-font-size ml-1 ml-lg-0">My Information</a>
                                        <i class="fas fa-angle-right text-black-50"></i>
                                    </div>
                                    <div class="d-flex justify-content-between pointer">
                                        <span class="text-black-50 card-header-inner-font-size ml-1 ml-lg-0">Change Password</span>
                                        <i class="fas fa-angle-right text-black-50"></i>
                                    </div>
                                </div>
                                <div class="my-card-header card-header-font-size py-lg-4 p-4 mt-lg-3">
                                <div class="icons">
                                      <img src="{{ asset('images/user-profile/noti.png')}}" class="w-50" alt="account">
                                  </div>
                                    <span class="card-header-title">Notification</span>
                                </div>
                                <div class="my-card-body p-4">
                                    <div class="d-flex justify-content-between pointer">
                                        <span class="text-black-50 card-header-inner-font-size ml-1 ml-lg-0">Promotion</span>
                                        <i class="fas fa-angle-right text-black-50"></i>
                                    </div>
                                </div>
                                <div class="my-card-header card-header-font-size py-lg-4 p-4 mt-lg-3">
                                    <div class="icons">
                                      <img src="{{ asset('images/user-profile/other.png')}}" class="w-50" alt="account">
                                    </div>
                                    <span class="card-header-title">Other</span>
                                </div>
                                <div class="my-card-body p-4">
                                    <div class="d-flex justify-content-between mb-lg-4 mb-5 pointer">
                                        <span class="text-black-50 card-header-inner-font-size ml-1 ml-lg-0">FAQ</span>
                                        <i class="fas fa-angle-right text-black-50"></i>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{route('backside.user.logout')}}" class="text-danger">Log Out</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7  p-3">
                       <div class="px-lg-5">
                           @yield('inner-content')
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection  
@push('scripts')

@endpush