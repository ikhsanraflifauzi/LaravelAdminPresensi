<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/Login/login', function () {
    return view('Auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('user');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'readUser'])->name('home')->middleware('user');

Route::get('/datapresensi', [App\Http\Controllers\PresensiController::class, 'dataPresensiEmp']);
Route::get('/datagetpass', [App\Http\Controllers\GetPassController::class, 'readGetPass']);
Route::get('/dataabsen', [App\Http\Controllers\AbsenController::class, 'readAbsen']);
Route::get('/datauser', [App\Http\Controllers\UserController::class, 'readUser']);
Route::get('/tambahuser', [App\Http\Controllers\UserController::class, 'addUserView']);
// Route::get('/home/customer', [App\Http\Controllers\HomeController::class, 'customer'])->middleware('user','fireauth');

Route::get('/email/verify', [App\Http\Controllers\Auth\ResetController::class, 'verify_email'])->name('verify')->middleware('fireauth');
Route::post('/add-employee', [App\Http\Controllers\UserController::class, 'processAddEmployee'])->name('adduser');


Route::post('login/{provider}/callback', 'Auth\LoginController@handleCallback');

Route::resource('/home/profile', App\Http\Controllers\Auth\ProfileController::class)->middleware('user','fireauth');

Route::resource('/password/reset', App\Http\Controllers\Auth\ResetController::class);

Route::resource('/img', App\Http\Controllers\ImageController::class);
