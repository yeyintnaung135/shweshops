<?php

use App\Http\Controllers\users\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->as('backside.user.')->group(function () {
    Route::get('profile', [UserController::class, 'index'])->name('user_profile');
    Route::get('profile/edit/{id}', [UserController::class, 'edit'])->name('edit');
    Route::put('profile/update/{id}', [UserController::class, 'update'])->name('update');
    Route::put('profile/birthday_update/{id}', [UserController::class, 'birthday_update'])->name('birthday_update');
    Route::post('user/whitelist_point', [UserController::class, 'whilist_point'])->name('whilist.point');
    Route::post('user/buy_now_point', [UserController::class, 'buy_now_point'])->name('buy_now.point');
    Route::post('user/add_to_cart_point', [UserController::class, 'add_to_cart_point'])->name('addtocart.point');

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});
