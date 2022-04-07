<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi\Cashbon;
use App\Models\Master\AkunBank;
use Auth;
use App\Models\Transaksi\PertanggungJawaban;
use DB;

class ReportKasbonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:report-lpj-list|report-lpj-create|report-lpj-edit|report-lpj-delete', ['only' => ['index','store']]);
         $this->middleware('permission:report-lpj-create', ['only' => ['create','store']]);
         $this->middleware('permission:report-lpj-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:report-lpj-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $akun_bank = $request->req2;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $auth = Auth::user()->id;
        // dd($akun_bank);

        // $reports = DB::table('pertanggungjawabans')
        //                 ->join('cashbons', 'pertanggungjawabans.kasbon_id', '=' , 'cashbons.id')
        //                 ->get();

        $type_user = Auth::user()->type_user == 1;
        if($type_user){
            if($akun_bank == ''){
                $akunBanks = AkunBank::all();
                $reports = DB::select("SELECT
                cashbons.nama, 
                cashbons.tanggal_pengajuan, 
                cashbons.no_transaksi, 
                cashbons.nominal AS nominal_cashbon, 
                cashbons.keterangan, 
                pertanggungjawabans.kasbon_id, 
                pertanggungjawabans.nominal, 
                pertanggungjawabans.refund, 
                pertanggungjawabans.selisih, 
                pertanggungjawabans.action, 
                pertanggungjawabans.`status`, 
                pertanggungjawabans.tanggal_lpj,
                akun_banks.akun,
                akun_banks.id
                FROM 
                pertanggungjawabans 
                INNER JOIN 
                cashbons 
                ON pertanggungjawabans.kasbon_id = cashbons.id 
                INNER JOIN akun_banks 
                ON 
                cashbons.akun_bank_id = akun_banks.id 
                WHERE 
                pertanggungjawabans.tanggal_lpj BETWEEN '$tgl1' AND '$tgl2'
            ");
                return view('report.kasbon-lpj.index', compact('akunBanks','reports'));
            }else{
                $akunBanks = AkunBank::all();
                $reports = DB::select("SELECT
                cashbons.nama, 
                cashbons.tanggal_pengajuan, 
                cashbons.no_transaksi, 
                cashbons.nominal AS nominal_cashbon, 
                cashbons.keterangan, 
                pertanggungjawabans.kasbon_id, 
                pertanggungjawabans.nominal, 
                pertanggungjawabans.refund, 
                pertanggungjawabans.selisih, 
                pertanggungjawabans.action, 
                pertanggungjawabans.`status`, 
                pertanggungjawabans.tanggal_lpj,
                akun_banks.akun,
                akun_banks.id
                FROM 
                pertanggungjawabans 
                INNER JOIN 
                cashbons 
                ON pertanggungjawabans.kasbon_id = cashbons.id 
                INNER JOIN akun_banks 
                ON 
                cashbons.akun_bank_id = akun_banks.id 
                WHERE 
                pertanggungjawabans.tanggal_lpj BETWEEN '$tgl1' AND '$tgl2'
                AND
                cashbons.akun_bank_id = $akun_bank
            ");
                return view('report.kasbon-lpj.index', compact('akunBanks','reports'));
            }
        }else{
            if($akun_bank == ''){
                $akunBanks = AkunBank::all();
                $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $auth");
                $reports = DB::select("SELECT
                cashbons.nama, 
                cashbons.tanggal_pengajuan, 
                cashbons.no_transaksi, 
                cashbons.nominal AS nominal_cashbon, 
                cashbons.keterangan, 
                pertanggungjawabans.kasbon_id, 
                pertanggungjawabans.nominal, 
                pertanggungjawabans.refund, 
                pertanggungjawabans.selisih, 
                pertanggungjawabans.action, 
                pertanggungjawabans.`status`, 
                pertanggungjawabans.tanggal_lpj,
                akun_banks.akun,
                akun_banks.id
                FROM 
                pertanggungjawabans 
                INNER JOIN 
                cashbons 
                ON pertanggungjawabans.kasbon_id = cashbons.id 
                INNER JOIN akun_banks 
                ON 
                cashbons.akun_bank_id = akun_banks.id 
                INNER JOIN
                users_akuns
                ON 
                    akun_banks.id = users_akuns.akun_bank_id
                INNER JOIN
                users
                ON 
                    users_akuns.user_id = users.id
                WHERE 
                users.id = $auth AND
                pertanggungjawabans.tanggal_lpj BETWEEN '$tgl1' AND '$tgl2'
            ");
                return view('report.kasbon-lpj.index', compact('akunBanks','reports'));
            }else{
                $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $auth");
                $reports = DB::select("SELECT
                cashbons.nama, 
                cashbons.tanggal_pengajuan, 
                cashbons.no_transaksi, 
                cashbons.nominal AS nominal_cashbon, 
                cashbons.keterangan, 
                pertanggungjawabans.kasbon_id, 
                pertanggungjawabans.nominal, 
                pertanggungjawabans.refund, 
                pertanggungjawabans.selisih, 
                pertanggungjawabans.action, 
                pertanggungjawabans.`status`, 
                pertanggungjawabans.tanggal_lpj,
                akun_banks.akun,
                akun_banks.id
                FROM 
                pertanggungjawabans 
                INNER JOIN 
                cashbons 
                ON pertanggungjawabans.kasbon_id = cashbons.id 
                INNER JOIN akun_banks 
                ON 
                cashbons.akun_bank_id = akun_banks.id 
                WHERE 
                pertanggungjawabans.tanggal_lpj BETWEEN '$tgl1' AND '$tgl2'
                AND
                cashbons.akun_bank_id = $akun_bank
            ");
                return view('report.kasbon-lpj.index', compact('akunBanks','reports'));
            }
        }
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
