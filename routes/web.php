<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\Master\KlasifikasiController;
use App\Http\Controllers\Master\MBranchController;
use App\Http\Controllers\Master\AkunBankController;
use App\Http\Controllers\Master\JabatanController;
use App\Http\Controllers\Master\PemeriksaKasController;
use App\Http\Controllers\Master\JenisKasController;
use App\Http\Controllers\Transaksi\PemakaianKasController;
use App\Http\Controllers\Transaksi\PemasukkanKasController;
use App\Http\Controllers\Transaksi\PostingController;
use App\Http\Controllers\Transaksi\CashbonController;
use App\Http\Controllers\Transaksi\PertanggungJawabanController;
use App\Http\Controllers\Report\ReportKasOperasionalController;
use App\Http\Controllers\Report\ReportKasbonController;
use App\Http\Controllers\Report\CashOpnameController;
use App\Http\Controllers\Report\EfillingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

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

Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/develops', function () {
    return view('404');
});
Route::group(['middleware' => ['auth']], function() {
Route::get('/home', function () {
    return view('home');
});
Route::get('getAkun/{id}', function ($id) {
    $branch_id = App\Models\Master\AkunBank::where('branch_id',$id)->get();
    return response()->json($branch_id);
});
Route::get('getKlasifikasi/{id}', [PemakaianKasController::class, 'ambil1']);

Route::resource('roles', RoleController::class);
Route::resource('permission', PermissionController::class);
Route::resource('/user', UserController::class);
Route::resource('/akun-bank', AkunBankController::class);
Route::resource('/klasifikasi', KlasifikasiController::class);
Route::get('/ambil',[PemakaianKasController::class , 'ambil']);
Route::post('/pemakaian-kas/index', [PemakaianKasController::class, 'index'])->name('pemakaian-kas.filter');
Route::resource('/pemakaian-kas', PemakaianKasController::class);
Route::post('/pemasukkan-kas/penyesuaian', [PemasukkanKasController::class, 'penyesuaian'])->name('pemasukkan-kas.penyesuaian');
Route::post('/pemasukkan-kas/index', [PemasukkanKasController::class, 'index'])->name('pemasukkan-kas.filter');
Route::resource('/pemasukkan-kas', PemasukkanKasController::class);
Route::post('/posting/index',[PostingController::class,'index'])->name('report.posting');
Route::resource('/kasbon', CashbonController::class);
Route::resource('/posting', PostingController::class);
Route::get('getMonth/{month_year}', [CashOpnameController::class, 'getMonth'])->name('getMonth');
Route::get('getCash/{akun_bank_id}', [CashOpnameController::class, 'getCash'])->name('getCash');
Route::get('getOut/{akun_bank_id}', [CashOpnameController::class, 'getOut'])->name('getOut');
Route::get('getCashBons/{akun_bank_id}', [CashOpnameController::class, 'getCashBon'])->name('getCashBons');
Route::post('/kas-opname/create',[CashOpnameController::class,'create'])->name('report.cashopname');
Route::resource('/kas-opname', CashOpnameController::class);
Route::get('/report-kas-opname/Rpdf/{id}', [CashOpnameController::class, 'printCashOpname'])->name('print.cashopname');
Route::post('/report-kas-operasional/index', [ReportKasOperasionalController::class, 'index'])->name('report.kas-operasional');
Route::get('/report-kas-operasional/nasional', [ReportKasOperasionalController::class, 'reportNasional'])->name('report.nasional.index');
Route::post('/report-kas-operasional/nasional', [ReportKasOperasionalController::class, 'reportNasional'])->name('report.nasional');
Route::resource('/report-kas-operasional', ReportKasOperasionalController::class);
Route::resource('/efilling-cashopname', EfillingController::class);
Route::resource('/mbranch', MBranchController::class);
Route::resource('/jabatan', JabatanController::class);
Route::resource('/pemeriksa-kas', PemeriksaKasController::class);
Route::resource('/jenis-kas', JenisKasController::class);
Route::get('/ambil-no-kas',[PertanggungJawabanController::class , 'ambil']);
Route::resource('/pertanggungjawaban', PertanggungJawabanController::class);
Route::post('/report-kasbon-lpj/index', [ReportKasbonController::class, 'index'])->name('report-lpj.report');
Route::resource('/report-kasbon-lpj', ReportKasbonController::class);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
