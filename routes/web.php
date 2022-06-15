<?php

use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class,'index'])->name('home');


Route::prefix('admin')
        ->middleware(['auth','admin'])
        ->group(function(){{
            Route::get('/',[App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin-dashboard');
            Route::resource('user', UserController::class);

            // company
            Route::resource('company', CompanyController::class);
            Route::get('company-show', [CompanyController::class, 'index']);
            Route::post('store-company', [CompanyController::class, 'store']);
            Route::post('edit-company', [CompanyController::class, 'edit']);
            Route::post('delete-company', [CompanyController::class, 'destroy']);
            Route::get('/tambah-attachment/{id}', [CompanyController::class, 'tambah'])->name('company-detail');
            Route::get('/view-attachment/company/{id}', [CompanyController::class, 'viewattach'])->name('attachment-detail');
            Route::post('/tambah-attachment/{id}', [CompanyController::class, 'updateattach'])->name('company-update');

            // roles
            Route::resource('roles', RolesController::class);

            // karyawan
            Route::resource('karyawan', KaryawanController::class);
            Route::get('karyawan-show', [KaryawanController::class, 'index']);
            Route::post('store-karyawan', [KaryawanController::class, 'store']);
            Route::post('edit-karyawan', [KaryawanController::class, 'edit']);
            Route::post('delete-karyawan', [KaryawanController::class, 'destroy']);
            Route::get('/tambah-attachment-karyawan/{id}', [KaryawanController::class, 'tambah'])->name('karyawan-detail');
            Route::get('/view-attachment-karyawan/karyawan/{id}', [KaryawanController::class, 'viewattach'])->name('karyawan-attachment');
            Route::post('/tambah-attachment-karyawan/{id}', [KaryawanController::class, 'updateattach'])->name('karyawan-update');
         


               // Attachment
            Route::get('show-attachment', [AttachmentController::class, 'index']);
            Route::post('store-attachment', [AttachmentController::class, 'store']);
            Route::post('edit-attachment', [AttachmentController::class, 'edit']);
            Route::post('delete-attachment', [AttachmentController::class, 'destroy']);
         }});
         
Auth::routes();


