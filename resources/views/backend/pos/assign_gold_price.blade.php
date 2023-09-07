@extends('layouts.backend.posbackend')
@section('content')
    <div class="wrapper">
        <!-- Navbar -->
    @include('layouts.backend.pos_nav')
    <!-- /.navbar -->

        <!-- Main Sidebar Container -->
    @include('layouts.backend.pos_sidebar')

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sn-background-light-blue">
            @if(Session::has('message'))

                <x-alert>

                </x-alert>
        @endif
        <!-- Content Header (Page header) -->
        <section class="content-header sn-content-header">
            <div class="container-fluid">
            </div><!-- /.container-fluid -->
        </section>

        <section class="content-header">
            <div class="container-fluid">

                <div class="card">
                    @if (!empty($assign_gold_price))
                    <div class="card-body">

                        {{-- <form action="{{route('backside.shop_owner.pos.update_assign_gold_price',$assign_gold_price->id)}}" method="POST"> --}}
                            <form action="{{route('backside.shop_owner.pos.assign_gold_price',$assign_gold_price->id)}}" method="POST">
                           @csrf
                           <h4 class="text-color mt-2">​<i class="fa fa-chevron-left" aria-hidden="true" onclick="back()"></i> &nbsp;&nbsp;ရွှေ​စျေးသတ်မှတ်ခြင်း</h4>
                           <div class="col-3">
                            <label for="date" class="col-form-label">Choose Date</label>
                            <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                          </div>
                          <div class="row mt-5">
                            <div class="col-6">
                                <span style="font-size:19px;">ဆိုင်​ပေါက်​စျေး သတ်မှတ်ရန်</span>
                            </div>
                            <div class="offset-1 col-5">
                                <span style="font-size:19px;">အပြင်​ပေါက်​စျေး သတ်မှတ်ရန်</span>
                            </div>
                          </div>
                          <div class="row">
                               <div class="col-5">
                                <div class="row mt-5">
                                <!--{{-- <div class="form-group col-6">-->
                                <!--    <label for="open_price" class="col-form-label">​ရွှေ​စျေးအဖွင့်</label>-->
                                <!--    <input type="text" class="form-control" name="open_price" value="<?php echo explode('/',$assign_gold_price->open_price)[0]; ?>">-->
                                <!--</div> --}}-->
                                <div class="form-group col-6">
                                    <label for="shop_price" class="col-form-label">အ​ခေါက်​ရွှေ​စျေး</label>
                                    <input type="text" class="form-control" name="shop_price" onchange="calculate_price(this.value,1)" value="<?php echo explode('/',$assign_gold_price->shop_price)[0]; ?>">
                                </div>
                                <div class="col-6"></div>

                                <div class="form-group col-6">
                                <label for="outprice_15" class="col-form-label">အပြင်စပ် ၁၅ ပဲရည်​​စျေး</label>
                                <input type="text" class="form-control" name="outprice_15" id="outprice_15" value="<?php echo explode('/',$assign_gold_price->outprice_15)[0]; ?>" readonly >
                                </div>
                                <div class="form-group col-6">
                                    <label for="inprice_15" class="col-form-label">အတွင်းစပ် ၁၅ ပဲရည်​စျေး</label>
                                    <input type="text" class="form-control" name="inprice_15" id="inprice_15" value="<?php echo explode('/',$assign_gold_price->inprice_15)[0]; ?>" readonly>
                                </div>

                                <div class="col-6">
                                    <label for="outprice_14" class="col-form-label">အပြင်စပ် ၁၄ပဲရည်​စျေး</label>
                                    <input type="text" class="form-control" name="outprice_14" id="outprice_14" value="<?php echo explode('/',$assign_gold_price->outprice_14)[0]; ?>" readonly>
                                </div>
                                <div class="col-6">
                                    <label for="inprice_14" class="col-form-label">အတွင်းစပ် ၁၄ပဲရည်စျေး</label>
                                    <input type="text" class="form-control" name="inprice_14" id="inprice_14" value="<?php echo explode('/',$assign_gold_price->inprice_14)[0]; ?>" readonly>
                                </div>

                                <div class="col-6">
                                 <label for="outprice_14_2" class="col-form-label">အပြင်စပ် ၁၄ပဲ ၂ ပြားရည်စျေး</label>
                                 <input type="text" class="form-control" name="outprice_14_2" id="outprice_14_2" value="<?php echo explode('/',$assign_gold_price->outprice_14_2)[0]; ?>" readonly>
                                 </div>
                                 <div class="col-6">
                                 <label for="inprice_14_2" class="col-form-label">အတွင်းစပ် ၁၄ပဲ ၂ ပြားရည်စျေး</label>
                                 <input type="text" class="form-control" name="inprice_14_2" id="inprice_14_2" value="<?php echo explode('/',$assign_gold_price->inprice_14_2)[0]; ?>" readonly>
                                 </div>
                                <div class="col-6">
                                 <label for="outprice_13" class="col-form-label">အပြင်စပ် ၁၃ ပဲရည်စျေး</label>
                                 <input type="text" class="form-control" name="outprice_13" id="outprice_13" value="<?php echo explode('/',$assign_gold_price->outprice_13)[0]; ?>" readonly>
                                </div>
                                <div class="col-6">
                                 <label for="inprice_13" class="col-form-label">အတွင်းစပ် ၁၃ ပဲရည်စျေး</label>
                                 <input type="text" class="form-control" name="inprice_13" id="inprice_13" value="<?php echo explode('/',$assign_gold_price->inprice_13)[0]; ?>" readonly>
                                </div>

                             <div class="col-6">
                                 <label for="outprice_12" class="col-form-label">အပြင်စပ် ၁၂ ပဲရည်စျေး</label>
                                 <input type="text" class="form-control" name="outprice_12" id="outprice_12" value="<?php echo explode('/',$assign_gold_price->outprice_12)[0]; ?>" readonly>
                             </div>
                             <div class="col-6">
                                 <label for="inprice_12" class="col-form-label">အတွင်းစပ် ၁၂ ပဲရည်စျေး</label>
                                 <input type="text" class="form-control" name="inprice_12" id="inprice_12" value="<?php echo explode('/',$assign_gold_price->inprice_12)[0]; ?>" readonly>
                             </div>

                             <div class="col-6">
                                 <label for="outprice_12_2" class="col-form-label">အပြင်စပ် ၁၂ ပဲ ၂ ပြားရည်စျေး</label>
                                 <input type="text" class="form-control" name="outprice_12_2" id="outprice_12_2" value="<?php echo explode('/',$assign_gold_price->outprice_12_2)[0]; ?>" readonly>
                             </div><div class="col-6">
                                 <label for="inprice_12_2" class="col-form-label">အတွင်းစပ် ၁၂ ပဲ ၂ ပြားရည်စျေး</label>
                                 <input type="text" class="form-control" name="inprice_12_2" id="inprice_12_2" value="<?php echo explode('/',$assign_gold_price->inprice_12_2)[0]; ?>" readonly>
                             </div>
                            </div>
                            </div>

                               <div class="offset-2 col-5">
                                <div class="row mt-5">
                                <!--{{-- <div class="form-group col-6">-->
                                <!--    <label for="open_price" class="col-form-label">​ရွှေ​စျေးအဖွင့်</label>-->
                                <!--    <input type="text" class="form-control" name="out_open_price" value="<?php echo explode('/',$assign_gold_price->open_price)[1]; ?>">-->
                                <!--    </div> --}}-->
                                    <div class="form-group col-6">
                                        <label for="shop_price" class="col-form-label">အ​ခေါက်​ရွှေ​စျေး</label>
                                        <input type="text" class="form-control" name="out_shop_price" onchange="calculate_price(this.value,2)" value="<?php echo explode('/',$assign_gold_price->shop_price)[1]; ?>">
                                    </div>
                                    <div class="col-6"></div>
                                    <div class="form-group col-6">
                                    <label for="outprice_15" class="col-form-label">အပြင်စပ် ၁၅ ပဲရည်​​စျေး</label>
                                    <input type="text" class="form-control" name="out_outprice_15" id="out_outprice_15" value="<?php echo explode('/',$assign_gold_price->outprice_15)[1]; ?>" readonly >
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="inprice_15" class="col-form-label">အတွင်းစပ် ၁၅ ပဲရည်​စျေး</label>
                                        <input type="text" class="form-control" name="out_inprice_15" id="out_inprice_15" value="<?php echo explode('/',$assign_gold_price->inprice_15)[1]; ?>" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label for="outprice_14" class="col-form-label">အပြင်စပ် ၁၄ပဲရည်​စျေး</label>
                                        <input type="text" class="form-control" name="out_outprice_14" id="out_outprice_14" value="<?php echo explode('/',$assign_gold_price->outprice_14)[1]; ?>" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label for="inprice_14" class="col-form-label">အတွင်းစပ် ၁၄ပဲရည်စျေး</label>
                                            <input type="text" class="form-control" name="out_inprice_14" id="out_inprice_14" value="<?php echo explode('/',$assign_gold_price->inprice_14)[1]; ?>" readonly>
                                        </div>
                                    <div class="col-6">
                                        <label for="outprice_14_2" class="col-form-label">အပြင်စပ် ၁၄ပဲ ၂ ပြားရည်စျေး</label>
                                        <input type="text" class="form-control" name="out_outprice_14_2" id="out_outprice_14_2" value="<?php echo explode('/',$assign_gold_price->outprice_14_2)[1]; ?>" readonly>
                                    </div>
                                    <div class="col-6">
                                     <label for="inprice_14_2" class="col-form-label">အတွင်းစပ် ၁၄ပဲ ၂ ပြားရည်စျေး</label>
                                     <input type="text" class="form-control" name="out_inprice_14_2" id="out_inprice_14_2" value="<?php echo explode('/',$assign_gold_price->inprice_14_2)[1]; ?>" readonly>
                                    </div>
                                    <div class="col-6">
                                    <label for="outprice_13" class="col-form-label">အပြင်စပ် ၁၃ ပဲရည်စျေး</label>
                                    <input type="text" class="form-control" name="out_outprice_13" id="out_outprice_13" value="<?php echo explode('/',$assign_gold_price->outprice_13)[1]; ?>" readonly>
                                    </div>
                                    <div class="col-6">
                                    <label for="inprice_13" class="col-form-label">အတွင်းစပ် ၁၃ ပဲရည်စျေး</label>
                                    <input type="text" class="form-control" name="out_inprice_13" id="out_inprice_13" value="<?php echo explode('/',$assign_gold_price->inprice_13)[1]; ?>" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label for="outprice_12" class="col-form-label">အပြင်စပ် ၁၂ ပဲရည်စျေး</label>
                                        <input type="text" class="form-control" name="out_outprice_12" id="out_outprice_12" value="<?php echo explode('/',$assign_gold_price->outprice_12)[1]; ?>" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label for="inprice_12" class="col-form-label">အတွင်းစပ် ၁၂ ပဲရည်စျေး</label>
                                        <input type="text" class="form-control" name="out_inprice_12" id="out_inprice_12" value="<?php echo explode('/',$assign_gold_price->inprice_12)[1]; ?>" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label for="outprice_12_2" class="col-form-label">အပြင်စပ် ၁၂ ပဲ ၂ ပြားရည်စျေး</label>
                                        <input type="text" class="form-control" name="out_outprice_12_2" id="out_outprice_12_2" value="<?php echo explode('/',$assign_gold_price->outprice_12_2)[1]; ?>" readonly>
                                    </div><div class="col-6">
                                        <label for="inprice_12_2" class="col-form-label">အတွင်းစပ် ၁၂ ပဲ ၂ ပြားရည်စျေး</label>
                                        <input type="text" class="form-control" name="out_inprice_12_2" id="out_inprice_12_2" value="<?php echo explode('/',$assign_gold_price->inprice_12_2)[1]; ?>" readonly>
                                    </div>
                                </div>
                               </div>
                          </div>
                               <input type="hidden" name="price_16" id="price_16" value="{{$assign_gold_price->price_16}}">
                               <div class="row mt-4 offset-10">
                                   <button type="submit" class="btn btn-sm btn-color text-center px-5"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>Save</button>
                               </div>

                       </form>

                   </div>
                   @else
                   <div class="card-body">
                    <form action="{{route('backside.shop_owner.pos.assign_gold_price')}}" method="POST">
                       @csrf
                       <h4 class=" mt-2">​ရွှေ​စျေးသတ်မှတ်ခြင်း</h4>
                           <div class="col-3">
                            <label for="date" class="col-form-label">Choose Date</label>
                            <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                          </div>
                          <div class="row mt-5">
                            <div class="col-6">
                                <span style="font-size:19px;">ဆိုင်​ပေါက်​စျေး သတ်မှတ်ရန်</span>
                            </div>
                            <div class="offset-1 col-5">
                                <span style="font-size:19px;">အပြင်​ပေါက်​စျေး သတ်မှတ်ရန်</span>
                            </div>
                          </div>
                       <div class="row mt-5">
                        <div class="col-5">
                            <div class="row">
                                <!--<div class="form-group col-6">-->
                                <!--    <label for="open_price" class="col-form-label">​ရွှေ​စျေးအဖွင့်</label>-->
                                <!--    <input type="text" class="form-control" name="open_price">-->
                                <!--</div>-->
                                <div class="form-group col-6">
                                    <label for="shop_price" class="col-form-label">အ​ခေါက်​ရွှေ​စျေး</label>
                                    <input type="text" class="form-control" name="shop_price" onchange="calculate_price(this.value,1)">
                                </div>
                                 <div class="col-6"></div>

                                <div class="form-group col-6">
                                <label for="outprice_15" class="col-form-label">အပြင်စပ် ၁၅ ပဲရည်​​စျေး</label>
                                <input type="text" class="form-control" name="outprice_15" id="outprice_15"  readonly >
                                </div>
                                <div class="form-group col-6">
                                    <label for="inprice_15" class="col-form-label">အတွင်းစပ် ၁၅ ပဲရည်​စျေး</label>
                                    <input type="text" class="form-control" name="inprice_15" id="inprice_15"  readonly>
                                </div>

                                <div class="form-group col-6">
                                    <label for="outprice_14" class="col-form-label">အပြင်စပ် ၁၄ပဲရည်​စျေး</label>
                                    <input type="text" class="form-control" name="outprice_14" id="outprice_14"  readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label for="inprice_14" class="col-form-label">အတွင်းစပ် ၁၄ပဲရည်စျေး</label>
                                    <input type="text" class="form-control" name="inprice_14" id="inprice_14"  readonly>
                                </div>

                                <div class="form-group col-6">
                                    <label for="outprice_14_2" class="col-form-label">အပြင်စပ် ၁၄ပဲ ၂ ပြားရည်စျေး</label>
                                    <input type="text" class="form-control" name="outprice_14_2" id="outprice_14_2"  readonly>
                                </div>
                                <div class="form-group col-6">
                                 <label for="inprice_14_2" class="col-form-label">အတွင်းစပ် ၁၄ပဲ ၂ ပြားရည်စျေး</label>
                                 <input type="text" class="form-control" name="inprice_14_2" id="inprice_14_2"  readonly>
                                </div>

                                <div class="form-group col-6">
                                 <label for="outprice_13" class="col-form-label">အပြင်စပ် ၁၃ ပဲရည်စျေး</label>
                                 <input type="text" class="form-control" name="outprice_13" id="outprice_13"  readonly>
                                </div>
                                <div class="form-group col-6">
                                 <label for="inprice_13" class="col-form-label">အတွင်းစပ် ၁၃ ပဲရည်စျေး</label>
                                 <input type="text" class="form-control" name="inprice_13" id="inprice_13"  readonly>
                             </div>

                             <div class="form-group col-6">
                                 <label for="outprice_12" class="col-form-label">အပြင်စပ် ၁၂ ပဲရည်စျေး</label>
                                 <input type="text" class="form-control" name="outprice_12" id="outprice_12"  readonly>
                             </div>
                             <div class="form-group col-6">
                                 <label for="inprice_12" class="col-form-label">အတွင်းစပ် ၁၂ ပဲရည်စျေး</label>
                                 <input type="text" class="form-control" name="inprice_12" id="inprice_12" readonly>
                             </div>

                             <div class="form-group col-6">
                                 <label for="outprice_12_2" class="col-form-label">အပြင်စပ် ၁၂ ပဲ ၂ ပြားရည်စျေး</label>
                                 <input type="text" class="form-control" name="outprice_12_2" id="outprice_12_2"  readonly>
                             </div><div class="form-group col-6">
                                 <label for="inprice_12_2" class="col-form-label">အတွင်းစပ် ၁၂ ပဲ ၂ ပြားရည်စျေး</label>
                                 <input type="text" class="form-control" name="inprice_12_2" id="inprice_12_2"  readonly>
                             </div>
                            </div>
                        </div>
                        <div class="offset-2 col-5">
                            <div class="row">
                                <!--<div class="form-group col-6">-->
                                <!--    <label for="open_price" class="col-form-label">​ရွှေ​စျေးအဖွင့်</label>-->
                                <!--    <input type="text" class="form-control" name="out_open_price">-->
                                <!--</div>-->
                                <div class="form-group col-6">
                                    <label for="shop_price" class="col-form-label">အ​ခေါက်​ရွှေ​စျေး</label>
                                    <input type="text" class="form-control" name="out_shop_price" onchange="calculate_price(this.value,2)">
                                </div>
                                 <div class="col-6"></div>
                                <div class="form-group col-6">
                                <label for="outprice_15" class="col-form-label">အပြင်စပ် ၁၅ ပဲရည်​​စျေး</label>
                                <input type="text" class="form-control" name="out_outprice_15" id="out_outprice_15"  readonly >
                                </div>
                                <div class="form-group col-6">
                                <label for="inprice_15" class="col-form-label">အတွင်းစပ် ၁၅ ပဲရည်​စျေး</label>
                                <input type="text" class="form-control" name="out_inprice_15" id="out_inprice_15"  readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label for="outprice_14" class="col-form-label">အပြင်စပ် ၁၄ပဲရည်​စျေး</label>
                                    <input type="text" class="form-control" name="out_outprice_14" id="out_outprice_14"  readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label for="inprice_14" class="col-form-label">အတွင်းစပ် ၁၄ပဲရည်စျေး</label>
                                    <input type="text" class="form-control" name="out_inprice_14" id="out_inprice_14"  readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label for="outprice_14_2" class="col-form-label">အပြင်စပ် ၁၄ပဲ ၂ ပြားရည်စျေး</label>
                                    <input type="text" class="form-control" name="out_outprice_14_2" id="out_outprice_14_2"  readonly>
                                </div>
                                <div class="form-group col-6">
                                 <label for="inprice_14_2" class="col-form-label">အတွင်းစပ် ၁၄ပဲ ၂ ပြားရည်စျေး</label>
                                 <input type="text" class="form-control" name="out_inprice_14_2" id="out_inprice_14_2"  readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label for="outprice_13" class="col-form-label">အပြင်စပ် ၁၃ ပဲရည်စျေး</label>
                                    <input type="text" class="form-control" name="out_outprice_13" id="out_outprice_13"  readonly>
                                   </div>
                                   <div class="form-group col-6">
                                    <label for="inprice_13" class="col-form-label">အတွင်းစပ် ၁၃ ပဲရည်စျေး</label>
                                    <input type="text" class="form-control" name="out_inprice_13" id="out_inprice_13"  readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label for="outprice_12" class="col-form-label">အပြင်စပ် ၁၂ ပဲရည်စျေး</label>
                                    <input type="text" class="form-control" name="out_outprice_12" id="out_outprice_12"  readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label for="inprice_12" class="col-form-label">အတွင်းစပ် ၁၂ ပဲရည်စျေး</label>
                                    <input type="text" class="form-control" name="out_inprice_12" id="out_inprice_12" readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label for="outprice_12_2" class="col-form-label">အပြင်စပ် ၁၂ ပဲ ၂ ပြားရည်စျေး</label>
                                    <input type="text" class="form-control" name="out_outprice_12_2" id="out_outprice_12_2"  readonly>
                                </div><div class="form-group col-6">
                                    <label for="inprice_12_2" class="col-form-label">အတွင်းစပ် ၁၂ ပဲ ၂ ပြားရည်စျေး</label>
                                    <input type="text" class="form-control" name="out_inprice_12_2" id="out_inprice_12_2"  readonly>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="price_16" id="price_16">
                        <div class="row mt-4 offset-10">
                            <button type="submit" class="btn btn-sm btn-color text-center px-5"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>Save</button>
                        </div>
                    </div>

                   </form>
               </div>
                    @endif

                </div>
            </div>
        </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{-- @include('layouts.backend.footer') --}}


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>

@endsection
@push('css')
<style>
    .btn-color{
        background: #780116;
        color:white;
    }
    .btn-color:hover{
            color: white;
        }
    .text-color{
        color: #780116;
    }
</style>
@endpush
@push('scripts')

    <script>
        function calculate_price(val,i){
            // alert(i);
            let price_16 = val;
            let outprice_15 = parseInt((val)/17*16);
            let inprice_15 = parseInt((val)/16*15);
            let outprice_14 = parseInt((val)/18*16);
            let inprice_14 = parseInt((val)/16*14);
            let outprice_14_2 = parseInt((val)/17.5*16);
            let inprice_14_2 = parseInt((val)/16*14.5);
            let outprice_13 = parseInt((val)/19*16);
            let inprice_13 = parseInt((val)/16*13);
            let outprice_12 = parseInt((val)/20*16);
            let inprice_12 = parseInt((val)/16*12);
            let outprice_12_2 = parseInt((val)/19.5*16);
            let inprice_12_2 = parseInt((val)/16*12.5);

            if(i == 1){
                $('#price_16').val(price_16);
                $('#outprice_15').val(outprice_15);
                $('#inprice_15').val(inprice_15);
                $('#outprice_14').val(outprice_14);
                $('#inprice_14').val(inprice_14);
                $('#outprice_14_2').val(outprice_14_2);
                $('#inprice_14_2').val(inprice_14_2);
                $('#outprice_13').val(outprice_13);
                $('#inprice_13').val(inprice_13);
                $('#outprice_12').val(outprice_12);
                $('#inprice_12').val(inprice_12);
                $('#outprice_12_2').val(outprice_12_2);
                $('#inprice_12_2').val(inprice_12_2);
            }
            if(i == 2){
                $('#price_16').val(price_16);
                $('#out_outprice_15').val(outprice_15);
                $('#out_inprice_15').val(inprice_15);
                $('#out_outprice_14').val(outprice_14);
                $('#out_inprice_14').val(inprice_14);
                $('#out_outprice_14_2').val(outprice_14_2);
                $('#out_inprice_14_2').val(inprice_14_2);
                $('#out_outprice_13').val(outprice_13);
                $('#out_inprice_13').val(inprice_13);
                $('#out_outprice_12').val(outprice_12);
                $('#out_inprice_12').val(inprice_12);
                $('#out_outprice_12_2').val(outprice_12_2);
                $('#out_inprice_12_2').val(inprice_12_2);
            }

        }
        function back(){
        history.go(-1);
      }
    </script>
@endpush
@push('css')
    <style>
        body {
            background: #F0F7FA;
            font-family: 'Myanmar3', Sans-Serif !important;
        }


    </style>
@endpush

