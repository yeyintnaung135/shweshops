<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav sop-nav-link">
        <li class="nav-item">
            <a class=" nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-sm-inline-block">
            <a class="nav-link" href="{{url('backside/shop_owner/detail')}}">Hello MOE Team!
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item sop-back-button sop-nav-link">
            <a class="nav-link" href="/">
                <i class="fas fa-long-arrow-left"></i> Shwe Shops
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link">
                <i class="fa fa-bell"></i>
            </a>
        </li>
    </ul>
</nav>
@push('css')
    <style>
        .sop-nav-link {
            font-family: sans-serif!important;
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
    </style>
@endpush