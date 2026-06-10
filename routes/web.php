<?php


use App\Http\Controllers\AdminController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\AdminPenyakitController;
use App\Http\Controllers\AdminGejalaController;
use App\Http\Controllers\AdminRuleController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Redirect route untuk '/' ke halaman beranda
Route::get('/', function () {
    return redirect()->route('login');
});
// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/loginprocess', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes (protected)
Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    // penyakit
    Route::get('/penyakit', [AdminPenyakitController::class, 'index'])->name('penyakit');
    Route::get('/penyakit/create', [AdminPenyakitController::class, 'create'])->name('create');
    Route::post('/penyakit/store', [AdminPenyakitController::class, 'store'])->name('penyakit.store');
    Route::get('/penyakit/{penyakit}', [AdminPenyakitController::class, 'show'])->name('show');
    Route::get('/penyakit/{penyakit}/edit', [AdminPenyakitController::class, 'edit'])->name('edit');
    Route::put('/penyakit/update/{id}', [AdminPenyakitController::class, 'update'])->name('update');
    Route::delete('/penyakit/destroy/{id}', [AdminPenyakitController::class, 'destroy'])->name('penyakit.destroy');
    // Route::resource('penyakit', AdminPenyakitController::class)->names('admin.penyakit');
    // gejala
    // Route::get('/gejala/create', [AdminRuleController::class, 'create'])->name('gejala.create');
    // Route::get('/gejala/{rule}', [AdminRuleController::class, 'show'])->name('gejala.show');
    Route::get('/gejala', [AdminGejalaController::class, 'index'])->name('gejala');
    Route::post('/gejala', [AdminGejalaController::class, 'store'])->name('gejala.store');
    Route::get('/gejala/update/{id}', [AdminGejalaController::class, 'edit'])->name('gejala.edit');
    Route::put('/gejala/update/{id}', [AdminGejalaController::class, 'update'])->name('gejala.update');
    Route::delete('/gejala/destroy/{id}', [AdminGejalaController::class, 'destroy'])->name('gejala.destroy');

    // Route::resource('gejala', AdminGejalaController::class)->names('admin.gejala');
    // Route::resource('rules', AdminRuleController::class)->names('admin.rules');
    // rules
    Route::get('/rules', [AdminRuleController::class, 'index'])->name('rules');
    Route::get('/rules/create', [AdminRuleController::class, 'create'])->name('rules.create');
    Route::post('/rules/store', [AdminRuleController::class, 'store'])->name('rules.store');
    Route::get('/rules/{rule}', [AdminRuleController::class, 'show'])->name('rules.show');
    Route::get('/rules/{rule}/edit', [AdminRuleController::class, 'edit'])->name('rules.edit');
    Route::put('/rules/update/{id}', [AdminRuleController::class, 'update'])->name('rules.update');
    Route::delete('/rules/destroy/{id}', [AdminRuleController::class, 'destroy'])->name('rules.destroy');

    // diagnosa

    
    Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa.index');
    Route::post('/proses', [DiagnosaController::class, 'proses'])->name('diagnosa.proses');
    Route::get('/reset', [DiagnosaController::class, 'reset'])->name('diagnosa.reset');
    Route::get('/riwayat', [DiagnosaController::class, 'riwayat'])->name('diagnosa.riwayat');
    Route::get('/riwayat/{id}', [DiagnosaController::class, 'detail'])->name('diagnosa.detail');
    Route::get('/cetak/{id}', [DiagnosaController::class, 'cetak'])->name('diagnosa.cetak'); 
});

Route::middleware(['auth'])->group(function () {

    Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa.index');
    Route::post('/proses', [DiagnosaController::class, 'proses'])->name('diagnosa.proses');
    Route::get('/reset', [DiagnosaController::class, 'reset'])->name('diagnosa.reset');
    Route::get('/riwayat', [DiagnosaController::class, 'riwayat'])->name('diagnosa.riwayat');
    Route::get('/riwayat/{id}', [DiagnosaController::class, 'detail'])->name('diagnosa.detail');
    Route::get('/cetak/{id}', [DiagnosaController::class, 'cetak'])->name('diagnosa.cetak');    

});



// Route::middleware(['auth'])->prefix('user')->group(function(){
    


// });
