@extends('layouts.backend.datatable')
@section('content')
    <div class="wrapper">
        @include('layouts.backend.navbar')
        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sn-background-light-blue">
            <!-- Main content -->
            <section class="content pt-3">

                <div id="item-panel-1" class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <span class="card-title">
                                        Add Customer Point
                                    </span>
                                </div>
                                <div class="card-body">
                                    @error('error')
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>{{ $message }}</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @enderror
                                    <form action="{{ route('backside.shop_owner.add_price.create') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="price">Customer Name</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name')
                                                is-invalid
                                            @enderror"
                                                id="price">
                                            @error('name')
                                                <span class="text-danger text-weight-bolder">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Customer Phone</label>
                                            <input type="text" name="phone"
                                                class="form-control @error('phone')
                                                is-invalid
                                            @enderror"
                                                id="price">
                                            @error('phone')
                                                <span class="text-danger text-weight-bolder">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="number" name="amount"
                                                class="form-control @error('amount')
                                                is-invalid
                                            @enderror"
                                                id="amount">
                                            @error('amount')
                                                <span class="text-danger text-weight-bolder">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="point">Point</label>
                                            <input type="text" readonly name="point" class="form-control-plaintext"
                                                id="point" value="0">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>

                <!-- /.container-fluid -->
            </section>
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
        let goldPoint = {!! json_encode($goldPoint) !!};
        $('#amount').bind('change paste keyup', () => {
            var amount = $('#amount').val();
            if (parseInt(goldPoint.status) <= parseInt(amount)) {
                var calculatePoint = parseInt(amount) / parseInt(goldPoint.status);
                $("#point").val(parseInt(calculatePoint * goldPoint.counts))
            } else {
                $("#point").val(0)
            }
        });
    </script>
@endpush
