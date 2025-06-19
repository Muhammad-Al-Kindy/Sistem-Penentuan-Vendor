<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GoodsReceiptsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\SmartController;
use App\Http\Controllers\VendorsController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::get('/', [LoginController::class, 'showLoginForm']);
Route::post('/', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



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
Route::middleware(['auth'])->group(function () {
    Route::get('/vendor', [VendorsController::class, 'index'])->name('vendor.index');
    Route::get('/vendor/create', [VendorsController::class, 'create'])->name('vendor.create');
    Route::post('/vendor/submit', [VendorsController::class, 'store'])->name('vendor.submit');
    Route::get('/vendor/edit/{id}', [VendorsController::class, 'edit'])->name('vendor.edit');
    Route::put('/vendor/update/{id}', [VendorsController::class, 'update'])->name('vendor.update');
    Route::delete('/vendor/delete/{id}', [VendorsController::class, 'destroy'])->name('vendor.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('goods-receipts', GoodsReceiptsController::class);
});

Route::get('/smart-form', [SmartController::class, 'form'])->name('smart.form');
Route::post('/smart-process', [SmartController::class, 'process'])->name('smart.process');