<?php
    use App\Models\Shops;
    use App\Models\Ads;
    $ads_deleted_count = Ads::withTrashed()->count();
    $all_shops_count = Shops::count();
    $admin_request = DB::table('super_admins')->where('role' , '==' , 2)->count();
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="z-index: 99999;">
    <!-- Brand Logo -->
    
    <div class="d-flex justify-content-between align-items-center">
        <a href="<?php echo e(url('/')); ?>" class="brand-link logo-switch">

            <span class=" logo-xl brand-text font-weight-light">ShweShops</span>
            <span class=" logo-xs brand-image-xs font-weight-light">ရွှေ</span>
        </a>
        <div class="hide-on-wide">
            <i id="sop-toggle" class="fas fa-times"></i>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <a href="<?php echo e(url('/backside/super_admin')); ?>">
                <div class="image">
                    <img src="<?php echo e(url('test/img/logo-m.png')); ?>" class="" alt="ShweShop Logo">
                </div>
                <div class="info text-capitalize">
                    <a href="<?php echo e(url('/backside/super_admin')); ?>" class="d-block">
                        <p class="d-flex justify-content-center" style="margin:0; flex-direction: column;">
                            MOE Team <span>(SuperAdmin)</span></p>
                    </a>
                </div>
            </a>
        </div>

        <!-- SidebarSearch Form -->
        

        <!-- Sidebar Menu -->
        <nav class="side-menu mt-2">
            <ul class="nav nav-pills nav-sidebar  flex-column nav-flat  " data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?php echo e(url('backside/super_admin')); ?>" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-chart-line"></i> -->
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Dashboard.svg'); ?>" alt=""/>
                        <img id="mobile" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Dashboard.svg'); ?>" alt=""/>
                        <p>Dashboard</p>
                    </a>
              
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('backside.super_admin.superAdmin.gold_price_get')); ?>" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-chart-line"></i> -->
                        <img id="logo" class="logo rounded-5 ml-1" src="<?php echo e('/images/logo/super_admin_logo/Gold Price.svg'); ?>" alt="" style="width: 22px"/>
                        <img id="mobile" class="logo rounded-5 ml-1 pb-1" src="<?php echo e('/images/logo/super_admin_mobile_logo/Gold Price.svg'); ?>" alt="" style="width: 22px;
                        filter: invert(44%) sepia(89%) saturate(3382%) hue-rotate(214deg) brightness(98%) contrast(99%);"/>
                        <p>Gold Price</p>
                    </a>
                </li>

                <!-- zh_super_admin_role -->
                <?php if(isset(Auth::guard('super_admin')->user()->id)): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('backside.super_admin.news.index')); ?>" class="mobile-nav nav-link">
                            <!-- <i class="nav-icon fas fa-address-card"></i> -->
                            <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Admins.svg'); ?>" alt=""/>
                            <img id="mobile" class="logo mobile d-none rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Admins.svg'); ?>" alt=""/>
                            <p>
                                Admins
                                <i class="right fas fa-angle-right"></i>
                                <?php if($admin_request): ?>
                                    <span class="badge badge-danger right"><?php echo e($admin_request); ?></span>
                                <?php endif; ?>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo e(route('backside.super_admin.super_admin_role.list')); ?>" class="nav-link border-0">
                                    
                                    <i class="fa fa-circle pl-5"></i>
                                    <p class="ml-3">Lists</p>
                                    <?php if($admin_request): ?>
                                        <span class="badge badge-danger right"><?php echo e($admin_request); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('backside.super_admin.super_admin_role.create')); ?>" class="nav-link border-0">
                                    
                                    <i class="fa fa-circle pl-5"></i>
                                    <p class="ml-3">Create Admin</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                <?php endif; ?>
                
                <li class="nav-item">
                    <a href="<?php echo e(route('backside.super_admin.customers.index')); ?>" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fa fa-user"></i> -->
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/All users.svg'); ?>" alt=""/>
                        <img id="mobile" class="logo mobile d-none rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/All users.svg'); ?>" alt=""/>
                        <p>All Users</p>
                    </a>
                </li>
                <!-- zh_ad -->
                <li class="nav-item">
                    <a href="<?php echo e(route('backside.super_admin.ads.index')); ?>" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-ad"></i> -->
                        <img id="mobile" class="logo mobile rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Ads.svg'); ?>" alt=""/>
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Ads.svg'); ?>" alt=""/>
                        <p>
                            Ads
                            <i class="right fas fa-angle-right"></i>
                            <?php if($ads_deleted_count): ?>
                                <span class="badge badge-danger right"><?php echo e($ads_deleted_count); ?></span>
                            <?php endif; ?>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('backside.super_admin.ads.index')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">All Ads </p>
                                <?php if($ads_deleted_count): ?>
                                    <span class="badge badge-danger right"><?php echo e($ads_deleted_count); ?></span>
                                <?php endif; ?>


                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('backside.super_admin.ads.create')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Create</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- zh_shos -->
                <li class="nav-item">
                    <a href="<?php echo e(url('backside/super_admin/shops/all')); ?>" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-store"></i> -->
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Shops.svg'); ?>" alt=""/>
                        <img id="mobile" class="logo mobile d-none rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Shops.svg'); ?>" alt=""/>
                        <p>
                            Shops
                            <i class="right fas fa-angle-right"></i>
                            <?php if($all_shops_count): ?>
                                <span class="badge badge-danger right"><?php echo e($all_shops_count); ?></span>
                            <?php endif; ?>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(url('backside/super_admin/shops/all')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">All Shops</p>
                                <?php if($all_shops_count): ?>
                                    <span class="badge badge-danger right"><?php echo e($all_shops_count); ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('backside.super_admin.shops.create')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Add Shop</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('backside.super_admin.shops.all_trash')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Trash</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(url('backside/super_admin/fbdata/messenger/list')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Fb Messengers</p>
                                <?php
                                $all_fb_msg_count=\App\Models\FacebookTable::count();
                                    ?>
                                <?php if($all_fb_msg_count): ?>
                                    <span class="badge badge-danger right"><?php echo e($all_fb_msg_count); ?></span>
                                <?php endif; ?>
                            </a>
                        </li>

                    </ul>
                </li>



                <li class="nav-item">
                    <a href="<?php echo e(url('backside/super_admin/items/all')); ?>" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-store"></i> -->
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Products.svg'); ?>" alt=""/>
                        <img id="mobile" class="logo mobile d-none rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Products.svg'); ?>" alt=""/>

                        <p>
                            Products
                            <i class="right fas fa-angle-right"></i>

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(url('backside/super_admin/items/all')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Daily Products Count By Shops</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="" class="mobile-nav nav-link">
                      <!-- <i class="fas fa-coins ml-3 coin-font-size "></i> -->
                      <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Points.svg'); ?>" alt=""/>
                      <img id="mobile" class="logo mobile d-none rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Points.svg'); ?>" alt=""/>
                        <p>
                            Points
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(url('backside/super_admin/point')); ?>" class="nav-link border-0">

                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Shweshops Point</p>

                            </a>
                        </li>
                    


                    </ul>
                </li>






                
                <li class="nav-item">
                    <a href="<?php echo e(route('backside.super_admin.news.index')); ?>" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-marker"></i> -->
                        <img id="mobile" class="logo d-none mobile  rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/News _ Events.svg'); ?>" alt=""/>
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/News _ Events.svg'); ?>" alt=""/>
                        <p>
                            News & Event
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('backside.super_admin.news.create')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">News</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="<?php echo e(route('backside.super_admin.events.create')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Events</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <?php if(isset(Auth::guard('super_admin')->user()->id)): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('backside.super_admin.superAdmin.contactus_get')); ?>" class="mobile-nav nav-link">
                            <!-- <i class="fas fa-edit  nav-icon"></i> -->
                            <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Contact.svg'); ?>" alt=""/>
                            <img id="mobile" class="logo mobile d-none rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Contact.svg'); ?>" alt=""/>
                            <p>
                                Contact Us
                                
                            </p>
                        </a>
                        
                    </li>
                <?php endif; ?>
                
                <li class="nav-item">
                    <a href="<?php echo e(url('backside/super_admin/messages/showexpire')); ?>" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-comment"></i> -->
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Message.svg'); ?>" alt=""/>
                        <img id="mobile" class="logo mobile d-none rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Message.svg'); ?>" alt=""/>
                        <p>Message</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?php echo e(url('backside/super_admin/shop_owner_using_chat')); ?>" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-comment"></i> -->
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Chat list.svg'); ?>" alt=""/>
                        <img id="mobile" class="logo mobile d-none rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Chat list.svg'); ?>" alt=""/>
                        <p>Using Chat Lists</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href= "" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-file"></i> -->
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Activity Logs.svg'); ?>" alt=""/>
                        <img id="mobile" class="logo mobile d-none rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Activity Logs.svg'); ?>" alt=""/>
                        <p>
                            Activity Logs
                            <i class="right fas fa-angle-right"></i>

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('backside.super_admin.activity.customer')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Viewers Activities</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('backside.super_admin.activity.ads')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Ads Activities</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('backside.super_admin.activity.shop')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Shop Activities</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('backside.super_admin.activity.admin')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Admin Activities</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('backside.super_admin.activity.messenger')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Fb Messenger                Activities</p>
                            </a>
                        </li>
                        <!--<li class="nav-item">-->
                        <!--    <a href="<?php echo e(url('backside/super_admin/daily_shop_create_log')); ?>" class="nav-link border-0">-->
                        <!--        -->
                        <!--        <i class="fa fa-circle pl-5"></i>-->
                        <!--        <p class="ml-3">Daily Product Activities</p>-->
                        <!--    </a>-->
                        <!--</li>-->
                    </ul>
                </li>



                <li class="nav-item">
                    <a href="<?php echo e(url('/backside/super_admin/directory/all')); ?>" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-store"></i> -->
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Shops directory.svg'); ?>" alt=""/>
                        <img id="mobile" class="logo mobile d-none rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Shops directory.svg'); ?>" alt=""/>
                        <p>
                            Shops Directory
                            <i class="right fas fa-angle-right"></i>

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(url('/backside/super_admin/directory/all')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <span class="sidebar-text ml-3">All Shops Directory</span>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(url('/backside/super_admin/directory/create')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <span class="sidebar-text ml-3">Add Shop Directory</span>
                            </a>
                        </li>


                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(url('/backside/super_admin/support/list')); ?>" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-info-circle"></i> -->
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Baydin.svg'); ?>" alt=""/>
                        <img id="mobile" class="logo mobile d-none rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Baydin.svg'); ?>" alt=""/>
                        <p>
                        Baydin
                            <i class="right fas fa-angle-right"></i>

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(url('/backside/super_admin/baydins')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">All Baydins</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(url('backside/super_admin/baydins/create')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Create Baydin</p>
                            </a>
                        </li>


                    </ul>
                </li>
                <li class="nav-item py-1 ml-3">
                    <a href="<?php echo e(route('backside.super_admin.app-files.index')); ?>" class="mobile-nav nav-link">
                        <i class="fi fi-rr-apps-add ml-2"></i>
                        <p>
                            App File
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(url('/backside/super_admin/support/list')); ?>" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-info-circle"></i> -->
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Help _ Support.svg'); ?>" alt=""/>
                        <img id="mobile" class="logo mobile d-none rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Help _ Support.svg'); ?>" alt=""/>
                        <p>
                        Help And Support
                            <i class="right fas fa-angle-right"></i>

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(url('/backside/super_admin/support/list')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Youtube Videos</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(url('/backside/super_admin/support/cat/list')); ?>" class="nav-link border-0">
                                
                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Categories</p>
                            </a>
                        </li>


                    </ul>
                </li>

                
                <li class="nav-item">
                    
                    
                    <a href="<?php echo e(route('backside.super_admin.superadmin.sitesetting')); ?>" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-cog"></i> -->
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Site setting.svg'); ?>" alt=""/>
                        <img id="mobile" class="logo mobile rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Site setting.svg'); ?>" alt=""/>
                        <p>Site Setting</p>
                    </a>
                </li>

                
                <li class="nav-item">
                    
                    
                    <a href="<?php echo e(url('/backside/super_admin/tooltips/list')); ?>" class="mobile-nav nav-link">
                        <!-- <i class="nav-icon fas fa-toolbox"></i> -->
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Tooltips.svg'); ?>" alt=""/>
                        <img id="mobile" class="logo mobile rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Tooltips.svg'); ?>" alt=""/>
                        <p>Tooltips</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="mobile-nav nav-link">
                      <!-- <i class="fas fa-coins ml-3 coin-font-size "></i> -->
                      <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Points.svg'); ?>" alt=""/>
                      <img id="mobile" class="logo mobile d-none rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Points.svg'); ?>" alt=""/>
                        <p>
                            Danger Zone
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(url('backside/super_admin/showdeletelogs')); ?>" class="nav-link border-0">

                                <i class="fa fa-circle pl-5"></i>
                                <p class="ml-3">Delete Logs</p>

                            </a>
                        </li>
                    


                    </ul>
                </li>

            </ul>

            <ul class="nav nav-pills nav-sidebar mt-3 flex-column nav-flat">
                <li class="nav-item">
                    <a class="mobile-nav nav-link" href="#" role="button"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <!-- <i class="nav-icon fas fa-sign-out-alt"></i> -->
                        <img id="logo" class="logo rounded-5" src="<?php echo e('/images/logo/super_admin_logo/Log out.svg'); ?>" alt=""/>
                        <img id="mobile" class="logo mobile rounded-5" src="<?php echo e('/images/logo/super_admin_mobile_logo/Log out.svg'); ?>" alt=""/>
                        <p>Log Out</p>
                    </a>
                    <form id="logout-form" action="<?php echo e(route('backside.super_admin.logout')); ?>" method="POST"
                          style="display: none;">

                        <?php echo csrf_field(); ?>
                    </form>
                </li>
            </ul>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php $__env->startPush('css'); ?>
    <style>
      .nav-sidebar .nav-link p {
        font-size: 16px !important;
      }
      .mobile-nav {
        margin: 5px 0;
      }
      .nav-item .login {
        margin-right: 10px !important;
      }
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #780116;
            border-radius: 3px;
            border: 4px solid transparent;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #780117cc;
        }

        .main-sidebar ::-webkit-scrollbar {
            display: none;
        }

        .sidebar-collapse .user-panel img {
            width: 2.3rem;
            height: 2.3rem;
        }

        .user-panel img {
            object-fit: cover;
        }

        .brand-link {
            border: none !important;
        }

        .brand-link span {
            font-size: 1.5rem;
        }


        .user-panel {
            border: none !important;
        }

        .sidebar-dark-primary {
            font-family: sans-serif;
        }

        .sop-btm-right {
            position: fixed;
            bottom: 10px;
            text-align: right;

        }

        .sidebar-collapse .sop-btm-right {

            text-align: left;
        }

        .sop-sidebar .disabled {
            opacity: 0.5;

        }

        .sop-btm-right li {
            opacity: 0.6;
        }

        .sop-btm-right li:hover {
            opacity: 1;
        }

        .main-sidebar {
            position: fixed !important;
            top: 0;
            bottom: 0;
            left: 0;
        }

        .hide-on-wide {
            text-align: right;
            cursor: pointer;
        }

        .hide-on-wide:hover {
            color: #3c56ff;
        }

        .fa-circle {
            font-size: 8px !important;
        }

        .nav-sidebar .menu-is-opening > .nav-link p >i {
            -webkit-transform: rotate(90deg) !important;
            transform: rotate(90deg) !important;
        }

        .coin-font-size{
            font-size: 20px;
        }

        @media only screen and (max-width: 992px) {
            .sidebar-dark-primary {
                background-color: #f0f7fa;
            }

            @supports ((-webkit-backdrop-filter: none) or (backdrop-filter: none)) {
                .sidebar-dark-primary {
                    background-color: #f0f7fab0;
                    color: #4E73F8;
                    -webkit-backdrop-filter: blur(20px);
                    backdrop-filter: blur(20px);
                }
            }
            .sidebar-dark-primary a {
                color: #2755fd !important;
            }

            svg{
                fill: #2755fd !important;
            }

            .sidebar-dark-primary a:hover {
                color: #3c56ff !important;
            }

            .info img {
                width: 70px;
            }

        }

        @media only screen and (min-width: 992px) {
            .sidebar-dark-primary {
                background-color: #4E73F8;
                color: #e5e5e5;
            }

            .sidebar-dark-primary a {
                color: #e5e5e5 !important;
            }

            .sidebar-dark-primary a {
                color: #e5e5e5 !important;
            }

            .sop-btm-right {
                background-color: #4E73F8;
            }
        }

        @media only screen and (max-width: 576px) {
            .sidebar-open .main-sidebar, .main-sidebar::before {
                width: 100%;
                font-size: 1.3rem !important;
                padding: 1rem;
            }

            .sidebar-mini .main-sidebar .nav-flat .nav-link, .sidebar-mini-md .main-sidebar .nav-flat .nav-link, .sidebar-mini-xs .main-sidebar .nav-flat .nav-link {
                width: 100%;
            }

            .sop-btm-right {
                text-align: right;
            }

            .hide-on-wide {
                display: block;
            }

            .sidebar-open .sop-btm-right {
                width: 90%;
            }

            .user-panel img {
                width: 186px !important;
                height: 80px !important;;
                width: 100%;
                height: auto;
            }

            .info p {
                color: #000;
                font-weight: 600;

            }

            .info span {
                font-weight: 500 !important;
            }
        }

        @media only screen and (min-width: 576px) {
            .hide-on-wide {
                display: none;
            }

            .user-panel img {
                width: 58px !important;
                /* height: 58px!important;; */
                width: 100%;
                height: auto;
            }

        }

        @media only screen and (max-width: 576px) {
            .user-panel img{
                width: 100% !important;
            }

            .logo{
                margin-top: 0% !important;
            }


            .side-menu{
                margin-top: 8% !important;
            }

        }

        @media only screen and (max-width:390px) {
            /* .info p{
                font-size: 100% !important;
            } */
            .user-panel img {
                width: 130px !important;
                height: 0%!important;
                /* width: 100%; */
                height: auto;
            }

        }

        /* zh */
        .logo{
            width: 30px;
            height: 30px;
            margin-top: -2%;
            margin-right: 10px;
        }

        .right{
            /* margin-top: 5%; */
        }

        .mobile-nav{
            display: flex;
        }

        #mobile{
            display: none;
        }

        @media only screen and (max-width:991px) {
            #logo{
                display: none;
            }
            #mobile{
                display: block !important;
            }
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function () {
            $("#sop-toggle").click(function () {
                $("body").removeClass("sidebar-open").addClass("sidebar-closed sidebar-collapse");
            });
        });
    </script>
    <script src="<?php echo e(url('plugins/bs-custom-file-input/bs-custom-file-input.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>


<?php /**PATH P:\xampp\htdocs\shweshops\resources\views/backend/super_admin/sidebar.blade.php ENDPATH**/ ?>