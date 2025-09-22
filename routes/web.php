<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PenggunaController;

use App\Http\Controllers\DataTanamanController;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\ObatController;


Route::resource('obat', ObatController::class);
Route::delete('obat/destroyAll/obat', [App\Http\Controllers\ObatController::class, 'destroyAll'])->name('obat.destroyAll');
Route::post('obat/import', [ObatController::class, 'import'])->name('obat.import');
Route::post('/obat/klasifikasi', [ObatController::class, 'klasifikasi'])->name('obat.klasifikasi');
Route::get('/rules/obat', [ObatController::class, 'rules'])->name('obat.rules');
Route::get('/obat/akurasi/obat', [ObatController::class, 'ujiAkurasi'])->name('obat.akurasi');


























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







/// Menampilkan daftar user
Route::get('users', [UserController::class, 'index'])->name('user.index');

// Menampilkan form edit user
Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');

// Update user
Route::put('users/{id}', [UserController::class, 'update'])->name('user.update');

// Hapus user
Route::delete('users/{id}', [UserController::class, 'destroy'])->name('user.destroy');
Route::get('/users/create', [UserController::class, 'create'])->name('user.create'); // Form tambah user
Route::post('/users', [UserController::class, 'store'])->name('user.store');



Route::get('/', [UserController::class, 'login'])->name('login');
Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'register_action'])->name('register.action');
Route::post('login', [UserController::class, 'login_action'])->name('login.action');
Route::get('password', [UserController::class, 'password'])->name('password');
Route::post('password', [UserController::class, 'password_action'])->name('password.action');
Route::get('logout', [UserController::class, 'logout'])->name('logout');





// Routes untuk admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
// Routes untuk user
Route::get('/landing', [PenggunaController::class, 'index'])->name('pengguna.index');


use App\Http\Controllers\ProfilController;

Route::get('profile', [ProfilController::class, 'show'])->name('profile.show');

// Route untuk menampilkan form create profil
Route::get('/profil/create', [ProfilController::class, 'create'])->name('profil.create');



// Route untuk menyimpan data profil
Route::post('/profil', [ProfilController::class, 'store'])->name('profil.store');
// Route untuk menampilkan form edit profil
Route::get('/profil/edit/{id}', [ProfilController::class, 'edit'])->name('profil.edit');
// Route untuk mengupdate profil
Route::put('/profil/update/{id}', [ProfilController::class, 'update'])->name('profil.update');