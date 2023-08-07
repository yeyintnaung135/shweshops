@extends('backend.user.profile')
@push('profile-css')
<style>
    .cursor-help{
        cursor: help;
    }
    input[type="text"] {
          font-size: 0.9em;
          padding-top: 0.35rem;
          font-weight: border;
          border-top: 0px!important;
          border-left: 0px!important;
          border-right: 0px!important;
          border-bottom:1px solid #6c757d !important;
    }
    input[type="date"] {
          font-size: 0.9em;
          padding-top: 0.35rem;
          font-weight: border;
          border-top: 0px!important;
          border-left: 0px!important;
          border-right: 0px!important;
          border-bottom: 1px solid #6c757d !important;
    }
    
    .calendar-icon{
        position: absolute;
        top: 2px;
        right: 1px;
        color:rgb(155, 63, 79) !important;
        font-weight: bolder;
    }
    
    .close:hover {
        color: #000;
        background: transparent;
    }
    
    .switch {
      position: relative;
      display: inline-block;
      width: 45px;
      height: 25px;
    }
    
    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }
    
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }
    
    .slider:before {
      position: absolute;
      content: "";
      height: 19px;
      width: 19px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }
    
    input:checked + .slider {
      background-color: rgb(155, 63, 79) !important;
    }
    
    input:focus + .slider {
      box-shadow: 0 0 1px rgb(155, 63, 79) !important;
    }
    
    input:checked + .slider:before {
      -webkit-transform: translateX(19px);
      -ms-transform: translateX(19px);
      transform: translateX(19px);
    }
    
    /* Rounded sliders */
    .slider.round {
      border-radius: 30px;
    }
    
    .slider.round:before {
      border-radius: 50%;
    }


</style>
@endpush
@section('inner-content')
    <div class="card border-0 shadow-none">
          <div class="py-2 text-center text-lg-start">
           <span class="my-information-header "> Edit Profile </span>
          </div>
          <div class="card-body p-0">
              @if(Session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ Session('success')}}</strong> 
                  <button type="button" class="close my-close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif
            <form action="{{ route('backside.user.update',$user->id)}}" method="post" class="h-100" enctype="multipart/form-data">
                @csrf
                @method('PUT')
              <div class="form-group">
                <div class="d-flex justify-content-between">
                     <label for="userName">Username <i class="fas fa-exclamation-circle cursor-help" title=" Username ဖြည့်ပြီး  {{ $user_name->count }} points ရယူပါ"></i></label>
                     @if(count($point_name) != 0)
                        <span>Claimed</span>
                     @endif
                </div>
                <input type="text" class="my-form" value="{{ old('username',$user->username )}}" id="userName" name="username">
              </div>
              <div class="form-group">
                <label for="phone">Phone </label>
                <input type="text" name="phone" value="{{ old('phone',$user->phone)}}" class="form-control" id="phone">
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between">
                  <label for="birthDay">Birth Day <i class="fas fa-exclamation-circle cursor-help" title="Birth Day ဖြည့်ပြီး {{ $birth->count }} points ရယူပါ"></i></label>
                    @if(count($point_birth) != 0)
                        <span>Claimed</span>
                    @endif
                </div>
                <div class="position-relative">
                    <input type="date" name="birth" value="{{ old('birth',$user->birthday)}}" class="form-control" id="birthDay">
                    <!-- <i class="fas fa-calendar calendar-icon"></i> -->
                </div>
              </div>
               <div class="form-group">
                  <div class="d-flex justify-content-between">
                    <label for="inputAddress">Address <i class="fas fa-exclamation-circle cursor-help" title="Address ဖြည့်ပြီး {{ $address->count }} points ရယူပါ"></i></label>
                    @if(count($point_address) != 0)
                        <span>Claimed</span>
                    @endif
                  </div>
                <input type="text" name="address" value="{{ old('address',$user->address )}}" class="form-control" id="inputAddress">
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between">
                  <label for="exampleFormControlFile1">Photo <i class="fas fa-exclamation-circle cursor-help" title="Photo ဖြည့်ပြီး {{ $photo->count }} points ရယူပါ"></i></label>
                  @if(count($point_profile) != 0)
                        <span>Claimed</span>
                   @endif
                </div>
                <input type="file" name="photo" class="form-control-file" id="exampleFormControlFile1">
              </div>
              <div class="d-flex align-items-center mb-2">
                   <div class="icons">
                     <img src="{{ asset('images/user-profile/noti.png')}}" class="w-50" alt="account">
                   </div>
                   <span class="font-weight-bolder my-information-header">Notification</span>
               </div>
                <div class="d-flex justify-content-between align-items-center bg-transparent mb-4">
                    <div>Allow Notifications</div>
                    <label class="switch">
                      <input type="checkbox">
                      <span class="slider round"></span>
                    </label>
                </div>
               <div class="form-group w-100 d-flex justify-content-center">
                    <button type="submit" class="btn shwe-shop-secondary-bg-color btn-sm w-25">Save</button>
                    <a href="{{ route('backside.user.user_profile')}}" class="ml-2 btn btn-sm btn-outline-dark w-25">Cancel</a>
               </div>
            </form>
          </div>
       </div>
@endsection










