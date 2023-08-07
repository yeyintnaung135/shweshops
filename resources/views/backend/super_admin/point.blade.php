@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Point Create')

@section('content')
    <div class="wrapper">
        @include('backend.super_admin.navbar')
        @include('backend.super_admin.sidebar')
        @include('backend.super_admin.loading')
        <section class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title></x-title>
            </section>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-6">
                        <div class="card card-outline card-primary p-0">
                            <div class="card-header ">
                                <h3 class="font-weight-bold">Point</h3>
                            </div>

                            <div class="card-body p-lg-3 p-2 d-flex justify-content-center">
                                <form action="{{ url('backside/super_admin/point/update') }}" method="POST">
                                    @csrf

                                    <div class="form-inline">
                                        <div class="form-group mb-2">
                                            <label for="staticEmail2" class="sr-only">Register Point</label>
                                            <input type="text" readonly name="register" class="form-control-plaintext"
                                                id="staticEmail2" value="{{ $register->status }}">
                                        </div>
                                        <div class="form-group mx-sm-3 mb-2">
                                            <label for="count" class="sr-only">count</label>
                                            <div class="">
                                                <input type="text"
                                                    class="form-control @error('count1')
                                            is-invalid
                                        @enderror"
                                                    name="count1" id="count"
                                                    value="{{ old('count1', $register->count) }}">
                                                @error('count1')
                                                    <span class="text-danger font-weight-bolder">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group mb-2">
                                            <label for="staticEmail2" class="sr-only">Daily Login</label>
                                            <input type="text" readonly name="daily" class="form-control-plaintext"
                                                id="staticEmail2" value="{{ $daily->status }}">
                                        </div>
                                        <div class="form-group mx-sm-3 mb-2">
                                            <label for="inputPassword2" class="sr-only">count</label>
                                            <div class="">
                                                <input type="text"
                                                    class="form-control @error('count2')
                                          is-invalid
                                      @enderror"
                                                    id="inputPassword2" name="count2"
                                                    value="{{ old('count2', $daily->count) }}">
                                                @error('count2')
                                                    <span class="text-danger font-weight-bolder">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group mb-2">
                                            <label for="staticEmail2" class="sr-only">Whislist</label>
                                            <input type="text" readonly name="whislist" class="form-control-plaintext"
                                                id="staticEmail2" value="{{ $whislist->status }}">
                                        </div>
                                        <div class="form-group mx-sm-3 mb-2">
                                            <label for="inputPassword2" class="sr-only">count</label>
                                            <div class="">
                                                <input type="text"
                                                    class="form-control @error('count3')
                                          is-invalid
                                      @enderror"
                                                    id="inputPassword2" name="count3"
                                                    value="{{ old('count3', $whislist->count) }}">
                                                @error('count3')
                                                    <span class="text-danger font-weight-bolder">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group mb-2">
                                            <label for="addToCart" class="sr-only">Add To Cart</label>
                                            <input type="text" readonly name="addtocart" class="form-control-plaintext"
                                                id="addToCart" value="{{ $addtocart->status }}">
                                        </div>
                                        <div class="form-group mx-sm-3 mb-2">
                                            <label for="inputPassword2" class="sr-only">count</label>
                                            <div class="">
                                                <input type="text"
                                                    class="form-control @error('count5')
                                          is-invalid
                                      @enderror"
                                                    id="inputPassword2" name="count5"
                                                    value="{{ old('count5', $addtocart->count) }}">
                                                @error('count5')
                                                    <span class="text-danger font-weight-bolder">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-inline mb-3">
                                        <div class="form-group mb-2">
                                            <label for="staticEmail2" class="sr-only">Buynow</label>
                                            <input type="text" readonly name="buynow" class="form-control-plaintext"
                                                id="staticEmail2" value="{{ $buynow->status }}">
                                        </div>
                                        <div class="form-group mx-sm-3 mb-2">
                                            <label for="inputPassword2" class="sr-only">count</label>
                                            <div class="">
                                                <input type="text"
                                                    class="form-control @error('count4')
                                         is-invalid
                                       @enderror"
                                                    id="inputPassword2" name="count4"
                                                    value="{{ old('count4', $buynow->count) }}">
                                                @error('count4')
                                                    <span class="text-danger font-weight-bolder">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-inline mb-3">
                                        <div class="form-group mb-2">
                                            <label for="staticEmail2" class="sr-only">Profile Edit</label>
                                            <input type="text" readonly name="profile" class="form-control-plaintext"
                                                id="staticEmail2" value="{{ $profile->status }}">
                                        </div>
                                        <div class="form-group mx-sm-3 mb-2">
                                            <label for="profile" class="sr-only">count</label>
                                            <div class="">
                                                <input type="text"
                                                    class="form-control @error('count10')
                                         is-invalid
                                       @enderror"
                                                    id="profile" name="count10"
                                                    value="{{ old('count10', $profile->count) }}">
                                                @error('count10')
                                                    <span class="text-danger font-weight-bolder">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-inline mb-3">
                                        <div class="form-group mb-2">
                                            <label for="staticEmail2" class="sr-only">Username Edit</label>
                                            <input type="text" readonly name="username" class="form-control-plaintext"
                                                id="staticEmail2" value="{{ $username->status }}">
                                        </div>
                                        <div class="form-group mx-sm-3 mb-2">
                                            <label for="profile" class="sr-only">count</label>
                                            <div class="">
                                                <input type="text"
                                                    class="form-control @error('count9')
                                         is-invalid
                                       @enderror"
                                                    id="profile" name="count9"
                                                    value="{{ old('count9', $username->count) }}">
                                                @error('count9')
                                                    <span class="text-danger font-weight-bolder">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-inline mb-3">
                                        <div class="form-group mb-2">
                                            <label for="staticEmail2" class="sr-only">Phone Edit</label>
                                            <input type="text" readonly name="phone" class="form-control-plaintext"
                                                id="staticEmail2" value="{{ $phone->status }}">
                                        </div>
                                        <div class="form-group mx-sm-3 mb-2">
                                            <label for="phoneNuberPoint" class="sr-only">count</label>
                                            <div class="">
                                                <input type="text"
                                                    class="form-control @error('count6')
                                         is-invalid
                                       @enderror"
                                                    id="phoneNuberPoint" name="count6"
                                                    value="{{ old('count6', $phone->count) }}">
                                                @error('count6')
                                                    <span class="text-danger font-weight-bolder">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-inline mb-3">
                                        <div class="form-group mb-2">
                                            <label for="staticEmail2" class="sr-only">Birth Date Edit</label>
                                            <input type="text" readonly name="birthdate"
                                                class="form-control-plaintext" id="staticEmail2"
                                                value="{{ $birthdate->status }}">
                                        </div>
                                        <div class="form-group mx-sm-3 mb-2">
                                            <label for="inputPassword2" class="sr-only">count</label>
                                            <div class="">
                                                <input type="text"
                                                    class="form-control @error('count7')
                                         is-invalid
                                       @enderror"
                                                    id="inputPassword2" name="count7"
                                                    value="{{ old('count7', $birthdate->count) }}">
                                                @error('count7')
                                                    <span class="text-danger font-weight-bolder">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-inline mb-3">
                                        <div class="form-group mb-2">
                                            <label for="staticEmail2" class="sr-only">Address Edit</label>
                                            <input type="text" readonly name="address" class="form-control-plaintext"
                                                id="staticEmail2" value="{{ $address->status }}">
                                        </div>
                                        <div class="form-group mx-sm-3 mb-2">
                                            <label for="inputPassword2" class="sr-only">count</label>
                                            <div class="">
                                                <input type="text"
                                                    class="form-control @error('count8')
                                         is-invalid
                                       @enderror"
                                                    id="inputPassword2" name="count8"
                                                    value="{{ old('count8', $address->count) }}">
                                                @error('count8')
                                                    <span class="text-danger font-weight-bolder">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary mb-2 w-100">Add</button>
                                    </div>
                                </form>
                            </div>
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

@push('scripts')
    <script>
        $("#loader").hide();
    </script>
@endpush
