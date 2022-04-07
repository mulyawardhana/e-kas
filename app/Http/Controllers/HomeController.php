<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\AkunBank;
use App\Models\Transaksi\Kas;
use DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $date = Carbon::today()->addDays(30);

        $expired_posting_count = Kas::where('tanggal_dikeluarkan', '>=', $date)->where('deskripsi','pengeluaran')->count();
        $expired_posting = Kas::where('tanggal_dikeluarkan', '>=', $date)->where('deskripsi','pengeluaran')->get();
        $sisa_saldo = AkunBank::get('saldo')->sum('saldo');
        $jumlah_pengeluaran = Kas::where('deskripsi','pengeluaran')->count();
        $saldo_minimum_sum = AkunBank::where('saldo' ,'<=', 'saldo_minimum')->count();
        $saldo_minimum = AkunBank::where('saldo' ,'<=', 'saldo_minimum')->get();
        return view('home',compact('sisa_saldo','saldo_minimum','saldo_minimum_sum','jumlah_pengeluaran','expired_posting','expired_posting_count'));
    }
}
