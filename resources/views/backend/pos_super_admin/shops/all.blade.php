@extends('layouts.backend.super_admin.datatable')
@section('content')
<div class="wrapper">
     {{-- @include('backend.super_admin.loading') --}}

        <!-- Navbar -->
        @include('backend.pos_super_admin.navbar')
    <!-- /.navbar -->
        <!-- Main Sidebar Container -->
      @include('backend.pos_super_admin.sidebar') 
      
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-alert> </x-alert>

            <!-- Content Header (Page header) -->
            {{-- <section class="content-header">
                <x-title>All Shops</x-title>
            </section> --}}

            <!-- Main content -->
            <section class="content pt-3">
            {{-- <div class="sn-tab-panel">
                  <ul>
                  <li id="item-tab-1" class="active-panel" onclick="shopTabSwitchOne()">Shop List</li>
                  <li id="item-tab-2" onclick="shopTabSwitchTwo()">Shop Activity</li>
                  </ul>
              </div> --}}
                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                          <div class="sn-table-list-wrapper">
                            <div class="card shadow-none border-0 rounded-5 pb-2 mt-5">
                              <div class="card-header">
                                <div class="">
                                  <h2>Shop Lists</h2>
                                  <p>Check your Shops</p>
                                </div>
                                <a href=" {{ route('pos_super_admin_shops.create') }} " class="btn btn-color">Add Shop</a>
                              </div>

                              <div class="d-flex justify-content-end my-3 align-items-center">
                                <div class="form-group mr-md-2">
                                  <fieldset>
                                    <legend>From Date</legend>
                                    <input type="date" id='search_fromdate_shop' class="shopdatepicker form-control" placeholder='Choose date' autocomplete="off"/>
                                  </fieldset>
                                </div>
                                <div class="form-group mr-md-2">
                                  <fieldset>
                                    <legend>To Date</legend>
                                    <input type="date" id='search_todate_shop' class="shopdatepicker form-control" placeholder='Choose date' autocomplete="off"/>
                                  </fieldset>
                                </div>
                                <div class="pr-md-4">
                                  <input type='button' id="shop_search_button" value="Search" class="btn btn-color"  onclick="dateSearch()">
                                </div>
                              </div>
                              <!-- /.card-header -->
                              <table id="superAdminTable" class="table table-borderless">
                                <thead>
                                  <tr>
                                    <td>Id</td>
                                    <td>Shop Name</td> 
                                     <td>Shop Logo</td>
                                     <td>Shop Banner</td>
                                     <td>Type</td>
                                     <td>Email</td>
                                     <td>Main Phone</td>
                                     <td>state</td>
                                     <td>Action</td>
                                  </tr>
                               </thead>
                                 
                                      <tbody id='filter'>
                                        <?php $i = 1; ?>
                                        @foreach ($shopowner as $shop)
                                            @foreach ($features as $feat)
                                                @if ($shop->id == $feat->shop_id)
                                                <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$shop->shop_name_myan}}</td> 
                                                 <td><img src="{{ url('/images/logo/'.$shop->shop_logo) }}"
                                                    class="rounded-circle" width="50"
                                                    height="45" alt="Logo" /></td>
                                                 <td><img src="{{ url('/images/banner/'.$shop->shop_banner) }}"
                                                    alt="cover" class="rounded-circle" width="50"
                                                    height="45"/></td>
                                                  <td>{{$shop->type == 'yes' ? 'Premium' : 'Normal'}}</td>
                                                 <td>{{$shop->email}}</td>
                                                 <td>{{$shop->main_phone}}</td>
                                                 <td>{{$shop->state}}</td>
                                                 <td class="d-flex">
                                                    <a href="{{route('pos_super_admin_shops.edit',$shop->id)}}" role="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Shop Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="{{route('pos_super_admin_shops.detail',$shop->id)}}" role="button" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Shop Detail">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <form action="{{ route('pos_super_admin_shops.trash',$shop->id)}}" method="post">
                                                        @csrf 
                                                        @method('DELETE')
                                                        <button type="button" onclick="deleteShop(this)" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Move To Trash">
                                                        <i class="fa fa-trash"></i>
                                                        </button>
                                  
                                                      </form>
                                                 </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                      </tbody>
                                  </table>
                              <!-- /.card-body -->
                            </div>
                          </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
@endsection
@push('scripts')
 <script>
  $('#superAdminTable').DataTable({
    dom: 'Blfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ],
    processing: true,
    "ordering": true,
    "info": true,
    "paging": true,
});
function dateSearch(){
    var start = $('#search_fromdate_shop').val();
    var end = $('#search_todate_shop').val();
    $.ajax({

    type:'POST',

    url: '{{route("pos_super_admin_shops.dateFilterShops")}}',

    data:{
    "_token":"{{csrf_token()}}",
    'start' : start,
    'end' : end,
    },

    success:function(data){
        var html1 = '';var count = 0;
        $.each(data.shopowner, function(i, v) {
            $.each(data.features, function(j, b) {
                if(v.id == b.shop_id){
                    count++;
            var shoplogo = '{{url('/images/logo/v.shop_logo')}}';
            var shopbanner = '{{url('/images/banner/v.shop_banner')}}';
            if(v.type == 'yes'){var type='Premium';}else{var type='Normal';}
            var url1 = '{{route('pos_super_admin_shops.edit',':shop_id')}}';
            var url2 = '{{route('pos_super_admin_shops.detail',':shop_id')}}';
            var url3 = '{{route('pos_super_admin_shops.trash',':shop_id')}}';
            url3 = url3.replace(':shop_id', v.id);
            url2 = url2.replace(':shop_id', v.id);
            url1 = url1.replace(':shop_id', v.id);
            html1+=`
            <tr>
            <td>${count}</td>
            <td>${v.shop_name_myan}</td> 
                <td><img src="${shoplogo}"
                class="rounded-circle" width="50"
                height="45" alt="Logo" /></td>
                <td><img src="${shopbanner}"
                alt="cover" class="rounded-circle" width="50"
                height="45"/></td>
                <td>${type}</td>
                <td>${v.email}</td>
                <td>${v.main_phone}</td>
                <td>${v.state}</td>
                <td class="d-flex">
                <a href="${url1}" role="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Shop Edit">
                    <i class="fa fa-edit"></i>
                </a>
                <a href="${url2}" role="button" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Shop Detail">
                    <i class="fa fa-eye"></i>
                </a>
                <form action="${url3}" method="post">
                    @csrf 
                    @method('DELETE')
                    <button type="button" onclick="deleteShop(this)" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Move To Trash">
                    <i class="fa fa-trash"></i>
                    </button>

                    </form>
                </td>
            </tr>
            `;
        }
        })
        })
        $('#filter').html(html1);
    }
    })
}
function deleteShop(e){
        if (window.confirm("Are you sure to delete?")) {
            $(e.form).submit();
            $("#loader").show();
        }   
    }
 </script>
@endpush
@push('css')
<style>
    .title {
        cursor: pointer;
    }
    .edit-section {
        display : none;
        cursor: pointer;
    }
    .btn-color{
        background-color: #780116;
        color: white;
    }
    .btn-color:hover{
            color: white;
        }

</style>
  
@endpush