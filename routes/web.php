<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [StudentController::class, 'index'])->name('index');
Route::get('/student/show/{id}', [StudentController::class, 'show'])->name('showStudent');
Route::get('/student/create', [StudentController::class, 'create'])->name('createStudent'); // Components
Route::post('/student/store', [StudentController::class, 'store'])->name('storeStudent');
Route::get('/student/edit/{id}', [StudentController::class, 'edit'])->name('editStudent');
Route::post('/student/update/{id}', [StudentController::class, 'update'])->name('updateStudent');
Route::get('/student/delete/{id}', [StudentController::class, 'destroy'])->name('deleteStudent');
Route::get('/student/deleteall', [StudentController::class, 'truncate'])->name('deleteAll');
Route::post('get-cities-by-state', [StudentController::class, 'getCity']);
Route::get('/student/print/{id}', [StudentController::class, "pdf"])->name('print'); // Generate PDF
Route::get('/student/import', [StudentController::class, "importPage"])->name('importPage');
Route::post('/student/import', [StudentController::class, "import"])->name('importStudents'); // Excel Import
Route::get('/student/export', [StudentController::class, "export"])->name('exportStudents'); // Excel Export
