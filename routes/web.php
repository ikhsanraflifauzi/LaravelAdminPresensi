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
Route::get('/TimeDate', [App\Http\Controllers\TimeController::class, 'readTime']);

Route::get('/tambahuser', [App\Http\Controllers\UserController::class, 'addUserView']);


Route::get('/filterpresensi', [App\Http\Controllers\PresensiController::class, 'filterPresensi']);
Route::get('/prodifilter', [App\Http\Controllers\PresensiController::class, 'prodiFilter']);
Route::get('/filterGetPass', [App\Http\Controllers\GetPassController::class, 'filterGetPass']);
Route::get('/filterAbsen', [App\Http\Controllers\AbsenController::class, 'filterAbsen']);
Route::get('/prodiGetPass', [App\Http\Controllers\GetPassController::class, 'prodiFilterGetPass'])->name('GetPAssProdi');

Route::get('/exportExcel', [App\Http\Controllers\PresensiController::class, 'exportPresensi'])->name('presensiExcel');
Route::get('/exportGetPass',[App\Http\Controllers\GetPassController::class,'exportGetPass'])->name('exportExcel');
Route::get('/export-presensi-pdf',[App\Http\Controllers\PDFController::class,'presensiPDF'])->name('presensiPdf');
Route::get('/export-getPass-pdf',[App\Http\Controllers\PDFController::class,'getPassPDF'])->name('GetpassPdf');

Route::post('/add-employee', [App\Http\Controllers\UserController::class, 'processAddEmployee'])->name('adduser');
Route::post('/add-time', [App\Http\Controllers\TimeController::class, 'addWaktumasuk'])->name('addwaktumasuk');
Route::post('/add-time-pulang', [App\Http\Controllers\TimeController::class, 'addWaktupulang'])->name('addwaktupulang');

Route::get('/delete-employee/{id}', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('deleteuser');
Route::get('/edit-user/{e}', [App\Http\Controllers\UserController::class, 'editUser'])->name('editUser');

Route::put('/Update/{id}', [App\Http\Controllers\UserController::class, 'updateUser']);
Route::get('/del/{id}' , [App\Http\Controllers\UserController::class,'delUser']);

Route::post('login/{provider}/callback', 'Auth\LoginController@handleCallback');

/* Route::resource('/home/profile', App\Http\Controllers\Auth\ProfileController::class)->middleware('user','fireauth');

Route::resource('/password/reset', App\Http\Controllers\Auth\ResetController::class);

Route::resource('/img', App\Http\Controllers\ImageController::class); */
