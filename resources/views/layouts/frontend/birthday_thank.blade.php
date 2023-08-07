@if ($message = Session::get('success'))
<div id="myModal" class="baydin_modal">

<!-- Modal content -->
<div class="modal-content">
    <span class="close">×</span>
    <img class="thank-icon" src="{{'/images/baydin/popup/Thankuicon.png'}}" alt="Card image cap">
    <h4 class="thank-h4">Thank you for interesting our program!</h4>
    <p class="first-thank">We will send <span class="result_link">the result link</span> directly to your phone</p>
    <p class="second-thank">message within a few minutes</p>
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