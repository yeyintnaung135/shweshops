<!-- Button trigger modal -->
@if(isset(Auth::guard('web')->user()->id))
    @if($user_birth === "")
    <div id="myModal" class="baydin_modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">×</span>
            <form action="{{ route('backside.user.birthday_update',$user->id)}}" method="post" class="h-100" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- <div class="alert alert-success" role="alert"> -->
                <img class="gift_birth" src="{{'/images/baydin/popup/Birthdayicon.png'}}" alt="Card image cap">
                <h4 class="alert-heading">သင့်တစ်လစာဟောစတမ်းကိုသိဖို့အတွက် သင့်မွေးနေ့လိုအပ်ပါတယ်</h4>
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="birth-in input-group-text" id="inputGroup-sizing-sm">မွေးနေ့ထည့်ရန်</span>
                    </div>
                    <input type="text" name="username" value="{{ old('username',$user->username )}}" class="d-none form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    <input type="text" name="phone" value="{{ old('phone',$user->phone)}}" class="d-none form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    <input type="date" name="birth" value="{{ old('phone',$user->birthday)}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                </div>
                <button type="submit" class="birth-btn">Submit</button>
                
                
                <!-- </div> -->
            </form>
        </div>

    </div>

    @else
    <div id="myModal" class="baydin_modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">×</span>
        <img class="thank-icon" src="{{'/images/baydin/popup/Thankuicon.png'}}" alt="Card image cap">
        <h4 class="thank-h4">Thank you for interesting our program!</h4>
        <p class="first-thank">We already send <span class="result_link">the result link</span> directly to your phone</p>
        <p class="second-thank">message after a few minutes</p>
        <div class="gp-bicon d-flex">
            <img class="thank-bicon" src="{{'/images/baydin/popup/Frame 538.png'}}" alt="Card image cap">
            <img class="thank-bicon" src="{{'/images/baydin/popup/Frame 539.png'}}" alt="Card image cap">
            <img class="thank-bicon" src="{{'/images/baydin/popup/Frame 540.png'}}" alt="Card image cap">
            <img class="thank-bicon" src="{{'/images/baydin/popup/Frame 544.png'}}" alt="Card image cap">
            <img class="thank-bicon" src="{{'/images/baydin/popup/Frame 545.png'}}" alt="Card image cap">
        </div>
    </div>

    </div>
    @endif
@endif

