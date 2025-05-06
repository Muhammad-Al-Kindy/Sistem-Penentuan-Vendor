<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SubKriteriaController;

Route::get('/', [KriteriaController::class, 'index'])->name('home');
Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
// Route::get('/kriteria/tambah', [KriteriaController::class, 'tambah_kriteria'])->name('kriteria.tambah_kriteria');
// Route::post('/kriteria/{id}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy');

Route::get('/subkriteria', [SubKriteriaController::class, 'index'])->name('subkriteria.index');
Route::get('/subkriteria/create/{kriteriaId}', [SubKriteriaController::class, 'create'])->name('subkriteria.create');
Route::post('/subkriteria/submit', [SubKriteriaController::class, 'store'])->name('subkriteria.submit');
// // student routes
// Route::get('/students', [StudentController::class, 'index'])->name('student.index');
// Route::get('/students/create', [StudentController::class, 'create'])->name('student.create');
// Route::post('/students/create', [StudentController::class, 'store'])->name('student.store');

// Route::get('/students/{id}', [StudentController::class, 'edit'])->name('student.edit');
// Route::put('/students/{id}', [StudentController::class, 'update'])->name('student.update');
// Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
// Route::get('/students/view/{id}', [StudentController::class, 'show'])->name('student.show');

// // product routes
// Route::resource('products', ProductController::class);

// //employe routes
// Route::resource('employes', EmployeController::class);
