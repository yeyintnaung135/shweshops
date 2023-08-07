@extends('layouts.backend.datatable')

@section('content')
   <div class="wrapper">

      @include('layouts.backend.navbar')

      <!-- Main Sidebar Container -->
      @include('layouts.backend.sidebar')

      <div class="content-wrapper sn-background-light-blue">
         <!-- Content Header (Page header) -->
         @if (Session::has('message'))
               <x-alert>

               </x-alert>
         @endif

         @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
               <button type="button" class="close" data-dismiss="alert">×</button>
               <strong>{{ $message }}</strong>
            </div>
         @endif

         @if (count($errors) > 0)
            <div class="alert alert-danger">
               <strong>Whoops!</strong> There were some problems with your input.
               <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
               </ul>
            </div>
         @endif

         <section class="content pt-3">
            <div class="sn-tab-panel">
               <ul>
                  <a class="active-panel" href="{{ route('backside.shop_owner.opening_times') }}">
                     Opening Times
                  </a>
               </ul>
            </div>
            <div class="container-fluid">
               <div class="card shadow-none border-0 rounded-5 pb-2">

                  <form action="{{ route('backside.shop_owner.opening_times_upload') }}" method="post" class="mx-3">
                  @csrf
                     <div class="row">
                        <div class="form-group">
                           <label for="opening_time" class="form-label card-header">Enter Opening Time:</label>
                           <textarea class="form-control sop-form-control" id="summernoteOpeningTimes" rows="5" name="opening_time">
                              {{ $opening_time->opening_time ?? '' }}
                           </textarea>
                           <input type="hidden" id="shopId" name="shopId" value="{{$shop_id}}"/>
                        </div>
                        {{-- <div class="form-group">
                           <label for="adTitle" class="form-label card-header">Title</label>
                           <textarea class="form-control sop-form-control" id="summernoteAdTitle" rows="5" name="adTitle">{{ old('adTitle', $popup->ad_title) }}</textarea>
                        </div> --}}
                     </div>
                     <div class="form-group">
                           <button type="submit" class="btn btn-success">Save</button>
                     </div>
                  </form>
                  
                  <div class="container-fluid card-body">
                     <table class="table">
                        <thead>
                           <tr>
                              <th scope="col">Opening Time</th>
                              <th scope="col">Created At</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              @if ($opening_time != null)
                                 <td>{!! $opening_time->opening_time !!}</td>
                                 <td>{{ $opening_time->created_at }}</td>
                                 <td>
                                    <a href="{{ route('backside.shop_owner.opening_times_delete') }}" class="btn btn-danger">Delete</button>
                                 </td>
                              @endif
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </section>

         <!-- Control Sidebar -->
         <aside class="control-sidebar control-sidebar-dark">
               <!-- Control sidebar content goes here -->
         </aside>
         <!-- /.control-sidebar -->
      </div>
   </div>
@endsection

@push('css')
   <style>
      .sn-tab-panel ul li {
         width: 100% !important;
         background: transparent !important;
         padding: 6px;
      }
   </style>
@endpush

@push('scripts')
   <script>
      $(function() {
         bsCustomFileInput.init();
      });
      $('#summernoteOpeningTimes').summernote({
         height: 200
      });
   </script>
@endpush