<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav sop-nav-link">
        <li class="nav-item">
            <a class=" nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-sm-inline-block">
            <a class="nav-link" href="{{url('backside/shop_owner/shop')}}">Welcome From Shweshops
                {{-- @if(isset(Auth::guard('shop_owner')->user()->id))
                    {{\Illuminate\Support\Str::limit(Auth::guard('shop_owner')->user()->name, 10, '..')}}<span>(Owner)</span>

                @elseif(Auth::guard('shop_role')->user()->role_id == 1)
                    {{\Illuminate\Support\Str::limit(Auth::guard('shop_role')->user()->name, 10, '..')}}<span>(Admin)</span></p>
                @elseif(Auth::guard('shop_role')->user()->role_id == 2)
                    {{\Illuminate\Support\Str::limit(Auth::guard('shop_role')->user()->name, 10, '..')}}<span>(Manager)</span></p>
                @elseif(Auth::guard('shop_role')->user()->role_id == 3)
                    {{\Illuminate\Support\Str::limit(Auth::guard('shop_role')->user()->name, 10, '..')}}<span>(Staff)</span></p>
                @endif --}}
                {{-- ! --}}
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        {{-- <li class="nav-item sop-back-button sop-nav-link">
            <a class="nav-link" href="/backside/shop_owner">
                <i class="fas fa-long-arrow-left"></i> Back
            </a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link">
                <i class="fa fa-bell icon-color"></i>
            </a>
        </li>
    </ul>
</nav>
@push('css')
    <style>
        .sop-nav-link {
            /* font-family: sans-serif!important;
             */
             font-family: 'Myanmar3', Sans-Serif !important;
            font-weight: 600;
            color: #404D61!important;
        }
        .sop-nav-link .nav-link{
            height: 100%;
        }
        .sop-back-button{
            border: solid 1px #2d5aff;
            border-radius: 5px;
            background-color: #4E73F8;
            margin-right: 20px!important;
        }
        .sop-back-button a{
            color: #e5e5e5!important;
        }
        @media only screen and (max-width: 576px) {
            .sop-back-button{
                display: none;
            }
        }
        .icon-color{
            color: #780116;
        }
    </style>
@endpush