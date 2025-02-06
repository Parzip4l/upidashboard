<?php

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
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\HilirasasiInovasiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ProposalDataController;
use App\Http\Controllers\Proposal\PemenangController;
use App\Http\Controllers\Proposal\ReviewerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Exports\InovasiExport;
use Maatwebsite\Excel\Facades\Excel;


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::post('/proses-login', [LoginController::class, 'login'])->name('login.proses');
Route::post('/register', [LoginController::class, 'register'])->name('user.register');

Route::get('/', function () {
    if (!Auth::check()) {
        return view('pages.auth.login');
    }

    $role = Auth::user()->role;

    if ($role === 'admin') {
        return redirect()->route('dashboard.index');
    } elseif ($role === 'user') {
        return redirect()->route('proposals.index');
    }

    return redirect()->route('login');
})->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::group(['middleware' => ['role:admin|reviewer|superadmin']], function () {
    Route::post('hilirisasi/save-draft', [HilirasasiInovasiController::class, 'saveDraft'])->name('hilirisasi.save-draft');
    
    // Pemenang
    Route::resource('pemenang', PemenangController::class);
    Route::post('penetapan-pemenang', [PemenangController::class, 'setWinner'])->name('pemenang.set');
    Route::get('/generate-word/{id}', [PemenangController::class, 'generateWord'])->name('generate.word');

    // Reviewer
    Route::post('penetapan-reviewer', [ReviewerController::class, 'store'])->name('reviewer.set');

    Route::get('/hilirasasi-inovasi', [HilirasasiInovasiController::class, 'index'])->name('hilirasasi-inovasi.index');
    Route::get('/hilirasasi-inovasi/single/{id}', [HilirasasiInovasiController::class, 'show'])->name('hilirasasi-inovasi.show');
    Route::post('hilirasasi-inovasi/update-status', [HilirasasiInovasiController::class, 'updateStatus'])->name('hilirasasi-inovasi.update-status');
    Route::get('/hilirasasi-inovasi/download/{type}/{id}', [HilirasasiInovasiController::class, 'downloadFile'])->name('hilirasasi-inovasi.download');
    Route::post('/update-status-review/{id}', [ProposalDataController::class, 'updateStatusReview'])->name('proposal.updateStatusReview');
    Route::post('/update-status-revisi/{id}', [ProposalDataController::class, 'updateStatusRevisi'])->name('proposal.updateStatusRevisi');
    Route::get('hilirasasi-inovasi/export', function () {
        return Excel::download(new InovasiExport, 'data_registrasi_inovasi.xlsx');
    })->name('hilirasasi-inovasi.export');
});

Route::group(['middleware' => ['role:reviewer']], function () {
    Route::post('/submit-nilai', [ProposalDataController::class, 'penilaian'])->name('proposal.nilaidata');
});

Route::group(['middleware' => ['role:user']], function () {
    Route::get('/pages.sample', function () {
        return view('pages.sample');
    });
    Route::get('pengajuan-inovasi', [UserController::class, 'index'])->name('pengajuan.index');
    Route::resource('proposals', ProposalDataController::class);
    Route::post('proposals/save-draft', [ProposalDataController::class, 'saveDraft'])->name('proposals.saveDraft');
    Route::get('/hilirasasi-inovasi/edit', [HilirasasiInovasiController::class, 'edit'])->name('hilirasasi-inovasi.edit');
    Route::post('/hilirasasi-inovasi/store', [HilirasasiInovasiController::class, 'store'])->name('hilirasasi-inovasi.store');
});


Route::group(['middleware' => ['role:superadmin|admin']], function () {
    Route::get('/setting-user-data', [UserController::class, 'dataUser'])->name('usersetting.index');
    Route::put('/update-user/{id}', [UserController::class, 'updateUser'])->name('usersetting.update');
});

Route::group(['prefix' => 'email'], function(){
    Route::get('inbox', function () { return view('pages.email.inbox'); });
    Route::get('read', function () { return view('pages.email.read'); });
    Route::get('compose', function () { return view('pages.email.compose'); });
});

Route::group(['prefix' => 'auth'], function(){
    Route::get('/login', function () {
        return view('pages.auth.login');
    })->name('login');
    Route::get('register', function () { return view('pages.auth.register'); });
});

Route::get('/logout', [GoogleController::class, 'logout'])->name('logout');


Route::group(['prefix' => 'error'], function(){
    Route::get('404', function () { return view('pages.error.404'); });
    Route::get('500', function () { return view('pages.error.500'); });
});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

// 404 for undefined routes
Route::any('/{page?}',function(){
    return View::make('pages.error.404');
})->where('page','.*');
