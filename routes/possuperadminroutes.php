<?php
//for superadmin

use App\Http\Controllers\POS\PosSuperAdminController;

Route::prefix('backside/pos_super_admin')->name('backside.pos_super_admin.')->group(function () {
    // Auth
    Route::get('login', [PosSuperAdminController::class, 'login_form'])->name('login');
    Route::post('login', [PosSuperAdminController::class, 'login'])->name('logined');
    Route::post('logout', [PosSuperAdminController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('dashboard', [PosSuperAdminController::class, 'get_dashboard'])->name('dashboard');
});

//for shweshops_pos & pos_only shops
Route::prefix('backside/pos_super_admin')->name('pos_super_admin_shops.')->group(function () {

    // All Shops
    Route::get('shops/all', [PosSuperAdminController::class, 'all'])->name('all');
    Route::post('shops/get_all_shops', [PosSuperAdminController::class, 'get_all_shops'])->name('date_filter_shops');

    // Create Shop
    Route::get('shops/create', [PosSuperAdminController::class, 'shop_create'])->name('create');
    Route::post('shops/register', [PosSuperAdminController::class, 'shop_store'])->name('store');

    // Edit Shop
    Route::get('shops/edit/{id}', [PosSuperAdminController::class, 'shop_edit'])->name('edit');
    Route::put('shops/edit/{id}', [PosSuperAdminController::class, 'shop_update'])->name('update');

    // Delete Shop
    Route::delete('shops/delete/{id}', [PosSuperAdminController::class, 'shop_trash'])->name('trash');

    // Shop Detail
    Route::get('shop_detail/{id}', [PosSuperAdminController::class, 'shop_show'])->name('detail');

    // Get Township
    Route::get('get_township', [PosSuperAdminController::class, 'get_township']);
});

//for pos_super_admin_role
Route::prefix('backside/pos_super_admin')->name('pos_super_admin_role.')->group(function () {

    // List Admins
    Route::get('admins/all', [PosSuperAdminController::class, 'list'])->name('list');

    // Create Admin
    Route::get('admins/create', [PosSuperAdminController::class, 'create'])->name('create');
    Route::post('admins/create', [PosSuperAdminController::class, 'store'])->name('store');

    // Edit Admin
    Route::get('admins/edit/{id}', [PosSuperAdminController::class, 'edit'])->name('edit');
    Route::put('admins/edit/{id}', [PosSuperAdminController::class, 'update'])->name('update');

    // Delete Admin
    Route::delete('admins/delete/{id}', [PosSuperAdminController::class, 'delete'])->name('delete');
});
