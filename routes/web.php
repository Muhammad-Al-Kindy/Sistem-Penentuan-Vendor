<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GoodsReceiptsController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\SmartController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NonConformanceController;
use App\Http\Controllers\VendorUpdateController;
use App\Models\VendorUpdate;

// --- Login ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/', fn() => redirect()->route('login'));

// --- Admin Only ---
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/subkriteria', [SubKriteriaController::class, 'index'])->name('subkriteria.index');
    Route::get('/subkriteria/create/{kriteriaId}', [SubKriteriaController::class, 'create'])->name('subkriteria.create');
    Route::get('/subkriteria/edit/{id}', [SubKriteriaController::class, 'edit'])->name('subkriteria.edit');
    Route::put('/subkriteria/update/{id}', [SubKriteriaController::class, 'update'])->name('subkriteria.update');
    Route::post('/subkriteria/submit', [SubKriteriaController::class, 'store'])->name('subkriteria.submit');
    Route::delete('/subkriteria/delete/{id}', [SubKriteriaController::class, 'destroy'])->name('subkriteria.destroy');

    Route::get('/vendor', [VendorController::class, 'index'])->name('vendor.index');
    Route::get('/vendor/create', [VendorController::class, 'create'])->name('vendor.create');
    Route::post('/vendor/submit', [VendorController::class, 'store'])->name('vendor.submit');
    Route::get('/vendor/edit/{vendor}', [VendorController::class, 'edit'])->name('vendor.edit');
    Route::put('/vendor/update/{vendor}', [VendorController::class, 'update'])->name('vendor.update');
    Route::delete('/vendor/{id}', [VendorController::class, 'destroy'])->name('vendor.destroy');

    Route::get('/purchase-order', [PurchaseOrderController::class, 'index'])->name('purchase.index');
    Route::get('/purchase-order/create', [PurchaseOrderController::class, 'create'])->name('purchase.create');
    Route::post('/purchase-order/submit', [PurchaseOrderController::class, 'store'])->name('purchase.submit');
    Route::get('/purchase-order/edit/{purchaseOrder}', [PurchaseOrderController::class, 'edit'])->name('purchase.edit');
    Route::put('/purchase-order/update/{purchaseOrder}', [PurchaseOrderController::class, 'update'])->name('purchase.update');
    Route::delete('/purchase-order/delete/{id}', [PurchaseOrderController::class, 'destroy'])->name('purchase.destroy');
    Route::get('/material-vendor-prices', [PurchaseOrderController::class, 'getMaterialVendorPrices'])->name('material.vendor.prices');
    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::get('/materials-by-vendor', [MaterialController::class, 'getByVendor'])->name('materials.by.vendor');

    Route::resource('goods-receipts', GoodsReceiptsController::class);
    Route::get('/kelola-kedatangan', [GoodsReceiptsController::class, 'kelolaKedatanganIndex'])->name('kedatangan.index');
    Route::get('/kelola-kedatangan/tambah', [GoodsReceiptsController::class, 'kelolaKedatanganAdd'])->name('kedatangan.add');
    Route::get('/kelola-kedatangan/edit/{id}', [GoodsReceiptsController::class, 'kelolaKedatanganEdit'])->name('kedatangan.edit');
    Route::put('/kelola-kedatangan/update/{id}', [GoodsReceiptsController::class, 'kelolaKedatanganUpdate'])->name('kedatangan.update');
    Route::delete('/kelola-kedatangan/{id}', [GoodsReceiptsController::class, 'destroy'])->name('kedatangan.destroy');
    Route::get('/purchase-orders/{purchaseOrderId}/items', [PurchaseOrderController::class, 'getItems'])->name('purchase-orders.items');

    // Chat admin
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/messages', [ChatController::class, 'fetchMessages'])->name('chat.messages.fetch');

    Route::post('/chat/message', [ChatController::class, 'store'])->name('chat.message.store');
    Route::get('/chat-messages/{vendorId}', [ChatController::class, 'fetchMessages'])->name('chat.messages.fetch');
});

// --- Vendor Only ---
Route::middleware(['auth', 'vendor'])->prefix('vendor')->group(function () {
    Route::get('/reports', [VendorUpdateController::class, 'reports'])->name('vendor.reports');
    Route::get('/purchase-order', [VendorUpdateController::class, 'purchaseOrder'])->name('vendor.purchase_order');
    Route::get('/purchase-order/edit/{purchaseOrder}', [VendorUpdateController::class, 'edit'])->name('vendor.purchase_order.edit');
    Route::put('/purchase-order/update/{id}', [VendorUpdateController::class, 'store'])->name('vendor.purchase_order.store');
    Route::get('/riwayat-evaluasi', [VendorController::class, 'riwayatEvaluasi'])->name('vendor.riwayat_evaluasi');

    // Chat vendor
    Route::get('/chat-vendor', [ChatController::class, 'index'])->name('chat.index.vendor');
    Route::post('/chat-vendor/message', [ChatController::class, 'store'])->name('chat.message.store.vendor');
    Route::get('/chat-vendor/messages', [ChatController::class, 'fetchMessages'])->name('chat.messages.fetch.vendor');
});

// --- Static Pages ---
Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard.index');
Route::get('/rating', fn() => view('rating.index'))->name('rating.index');
Route::get('/rating/tambah', fn() => view('rating.add'))->name('rating.add');
Route::get('/rating/edit', fn() => view('rating.edit'))->name('rating.edit');
Route::get('/rekomendasi', fn() => view('rekomendasi.index'))->name('rekomendasi.index');
Route::view('/users', 'users.index')->name('users.index');

// --- Smart Form ---
Route::get('/smart-form', [SmartController::class, 'form'])->name('smart.form');
Route::post('/smart-process', [SmartController::class, 'process'])->name('smart.process');
