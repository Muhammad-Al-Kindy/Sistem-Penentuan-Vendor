<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GoodsReceiptsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\SmartController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\MaterialController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/subkriteria', [SubKriteriaController::class, 'index'])->name('subkriteria.index');
    Route::get('/subkriteria/create/{kriteriaId}', [SubKriteriaController::class, 'create'])->name('subkriteria.create');
    Route::get('/subkriteria/edit/{id}', [SubKriteriaController::class, 'edit'])->name('subkriteria.edit');
    Route::put('/subkriteria/update/{id}', [SubKriteriaController::class, 'update'])->name('subkriteria.update');
    Route::post('/subkriteria/submit', [SubKriteriaController::class, 'store'])->name('subkriteria.submit');
    Route::delete('/subkriteria/delete/{id}', [SubKriteriaController::class, 'destroy'])->name('subkriteria.destroy');
});
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/vendor', [VendorController::class, 'index'])->name('vendor.index');
    Route::get('/vendor/create', [VendorController::class, 'create'])->name('vendor.create');
    Route::post('/vendor/submit', [VendorController::class, 'store'])->name('vendor.submit');
    Route::get('/vendor/edit/{vendor}', [VendorController::class, 'edit'])->name('vendor.edit');
    Route::put('/vendor/update/{vendor}', [VendorController::class, 'update'])->name('vendor.update');
    Route::delete('/vendor/{id}', [VendorController::class, 'destroy'])->name('vendor.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('goods-receipts', GoodsReceiptsController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/purchase-order', [PurchaseOrderController::class, 'index'])->name('purchase.index');
    Route::get('/purchase-order/create', [PurchaseOrderController::class, 'create'])->name('purchase.create');
    Route::post('/purchase-order/submit', [PurchaseOrderController::class, 'store'])->name('purchase.submit');
    Route::get('/purchase-order/edit/{purchaseOrder}', [PurchaseOrderController::class, 'edit'])->name('purchase.edit');
    Route::put('/purchase-order/update/{purchaseOrder}', [PurchaseOrderController::class, 'update'])->name('purchase.update');
    Route::delete('/purchase-order/delete/{id}', [PurchaseOrderController::class, 'destroy'])->name('purchase.destroy');

    // Add route for material vendor prices API
    Route::get('/material-vendor-prices', [PurchaseOrderController::class, 'getMaterialVendorPrices'])->name('material.vendor.prices');

    // Add route for creating new material
    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');

    // Add route for getting materials filtered by vendor
    Route::get('/materials-by-vendor', [MaterialController::class, 'getByVendor'])->name('materials.by.vendor');
});

Route::get('/smart-form', [SmartController::class, 'form'])->name('smart.form');
Route::post('/smart-process', [SmartController::class, 'process'])->name('smart.process');


// Route::get('/purchase-order', function () {
//     return view('purchase_order.index');
// })->name('purchase_order.index');

// Route::get('/purchase-order/add', function () {
//     return view('purchase_order.add');
// })->name('purchase_order.add');


// Route::get('/purchase-order/edit', function () {
//     return view('purchase_order.edit');
// })->name('purchase_order.edit');



Route::get('/kelola-kedatangan', function () {
    return view('kelola_kedatangan.index');
})->name('kedatangan.index');

Route::get('/kelola-kedatangan/tambah', function () {
    return view('kelola_kedatangan.add');
})->name('kedatangan.add');

Route::get('/kelola-kedatangan/edit', function () {
    return view('kelola_kedatangan.edit');
})->name('kedatangan.edit');

Route::get('/rekomendasi', function () {
    return view('rekomendasi.index');
})->name('rekomendasi.index');




Route::get('/rating', function () {
    return view('rating.index');
})->name('rating.index');

Route::get('/rating/tambah', function () {
    return view('rating.add');
})->name('rating.add');

Route::get('/rating/edit', function () {
    return view('rating.edit');
})->name('rating.edit');




Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard.index');
