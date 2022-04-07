<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi\Kas;
use App\Models\Master\AkunBank;
use Auth;
use App\Models\Transaksi\CashOpname;
use App\Models\klasifikasiAkun;
use DB;

class ReportKasOperasionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:report-operasional-list|report-operasional-create|report-operasional-edit|report-operasional-delete', ['only' => ['index','store']]);
         $this->middleware('permission:report-nasional-list|report-nasional-create|report-nasional-edit|report-nasional-delete', ['only' => ['reportNasional','store']]);
         $this->middleware('permission:report-operasional-create', ['only' => ['create','store']]);
         $this->middleware('permission:report-operasional-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:report-operasional-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        $kas = Auth::user()->id;
        $req2 = $request->req2;
        $req1 = $request->req1;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $akun_bank = $req2 == 'all';
        $sub_akun_transaksi = $req1 == 'all';
        $posting = $req1 == 'posting';
        $pemasukkan = $req1 == 'pemasukkan';
        $pengeluaran = $req1 == 'pengeluaran';
        $type_user = Auth::user()->type_user == 1;
        if($type_user){
            if($akun_bank && $sub_akun_transaksi){

                $reports = DB::select("SELECT
                kas.tanggal_dikeluarkan,
                akun_banks.akun,
                akun_banks.saldo,
                klasifikasi_akuns.sub_akun_transaksi,
                kas.no_nota,
                kas.nama_penerima,
                kas.keterangan,
                kas.nominal,
                kas.deskripsi
                FROM
                kas
                INNER JOIN
                akun_banks
                ON
                    kas.akun_bank_id = akun_banks.id

                INNER JOIN
                klasifikasi_akuns
                ON
                    kas.klasifikasi_id = klasifikasi_akuns.id
                WHERE

                kas.tanggal_dikeluarkan BETWEEN '$tgl1' AND '$tgl2'");
                $akunBanks = DB::select("SELECT akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks ");
                return view('report.kas-operasional.index',compact('reports','akunBanks'));

            }if($sub_akun_transaksi){

                $reports = DB::select("SELECT
                kas.tanggal_dikeluarkan,
                akun_banks.akun,
                akun_banks.saldo,
                klasifikasi_akuns.sub_akun_transaksi,
                kas.no_nota,
                kas.nama_penerima,
                kas.keterangan,
                kas.nominal,
                kas.deskripsi
                FROM
                kas
                INNER JOIN
                akun_banks
                ON
                    kas.akun_bank_id = akun_banks.id

                INNER JOIN
                klasifikasi_akuns
                ON
                    kas.klasifikasi_id = klasifikasi_akuns.id
                WHERE

                kas.akun_bank_id='$req2' AND
                kas.tanggal_dikeluarkan BETWEEN '$tgl1' AND '$tgl2'");
                $akunBanks = DB::select("SELECT  akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks");
                return view('report.kas-operasional.index',compact('reports','akunBanks'));

            }elseif($akun_bank){

                $reports = DB::select("SELECT
                kas.tanggal_dikeluarkan,
                akun_banks.akun,
                akun_banks.saldo,

                kas.no_nota,
                kas.nama_penerima,
                kas.keterangan,
                kas.nominal,
                kas.deskripsi
                FROM
                kas
                INNER JOIN
                akun_banks
                ON
                    kas.akun_bank_id = akun_banks.id

                WHERE

                kas.deskripsi='$req1' AND
                kas.tanggal_dikeluarkan BETWEEN '$tgl1' AND '$tgl2'");


                $akunBanks = DB::select("SELECT  akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks");
                return view('report.kas-operasional.index',compact('reports','akunBanks'));

            }elseif(isset($pengeluaran,$pemasukkan,$posting)){


                $reports = DB::select("SELECT
                kas.tanggal_dikeluarkan,
                akun_banks.akun,
                akun_banks.saldo,
                klasifikasi_akuns.sub_akun_transaksi,
                kas.no_nota,
                kas.nama_penerima,
                kas.keterangan,
                kas.nominal,
                kas.deskripsi
                FROM
                kas
                INNER JOIN
                akun_banks
                ON
                    kas.akun_bank_id = akun_banks.id

                INNER JOIN
                klasifikasi_akuns
                ON
                    kas.klasifikasi_id = klasifikasi_akuns.id
                WHERE

                kas.akun_bank_id= '$req2' AND
                kas.deskripsi = '$req1' AND
                kas.tanggal_dikeluarkan BETWEEN '$tgl1' AND '$tgl2'");
                $akunBanks = DB::select("SELECT akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks ");
                return view('report.kas-operasional.index',compact('reports','akunBanks'));
            }
        }else{
            if($akun_bank && $sub_akun_transaksi){

                $reports = DB::select("SELECT
                kas.tanggal_dikeluarkan,
                akun_banks.akun,
                akun_banks.saldo,
                klasifikasi_akuns.sub_akun_transaksi,
                kas.no_nota,
                kas.nama_penerima,
                kas.keterangan,
                kas.nominal,
                kas.deskripsi
                FROM
                kas
                INNER JOIN
                akun_banks
                ON
                    kas.akun_bank_id = akun_banks.id
                INNER JOIN
                users_akuns
                ON
                    akun_banks.id = users_akuns.akun_bank_id
                INNER JOIN
                users
                ON
                    users_akuns.user_id = users.id
                INNER JOIN
                klasifikasi_akuns
                ON
                    kas.klasifikasi_id = klasifikasi_akuns.id
                WHERE
                users.id = $kas AND
                kas.tanggal_dikeluarkan BETWEEN '$tgl1' AND '$tgl2'");
                $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $kas");
                return view('report.kas-operasional.index',compact('reports','akunBanks'));

            }if($sub_akun_transaksi){

                $reports = DB::select("SELECT
                kas.tanggal_dikeluarkan,
                akun_banks.akun,
                akun_banks.saldo,
                klasifikasi_akuns.sub_akun_transaksi,
                kas.no_nota,
                kas.nama_penerima,
                kas.keterangan,
                kas.nominal,
                kas.deskripsi
                FROM
                kas
                INNER JOIN
                akun_banks
                ON
                    kas.akun_bank_id = akun_banks.id
                INNER JOIN
                users_akuns
                ON
                    akun_banks.id = users_akuns.akun_bank_id
                INNER JOIN
                users
                ON
                    users_akuns.user_id = users.id
                INNER JOIN
                klasifikasi_akuns
                ON
                    kas.klasifikasi_id = klasifikasi_akuns.id
                WHERE
                users.id = $kas AND
                kas.akun_bank_id='$req2' AND
                kas.tanggal_dikeluarkan BETWEEN '$tgl1' AND '$tgl2'");
                $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $kas");
                return view('report.kas-operasional.index',compact('reports','akunBanks'));

            }elseif($akun_bank){

                $reports = DB::select("SELECT
                kas.tanggal_dikeluarkan,
                akun_banks.akun,
                akun_banks.saldo,

                kas.no_nota,
                kas.nama_penerima,
                kas.keterangan,
                kas.nominal,
                kas.deskripsi
                FROM
                kas
                INNER JOIN
                akun_banks
                ON
                    kas.akun_bank_id = akun_banks.id
                INNER JOIN
                users_akuns
                ON
                    akun_banks.id = users_akuns.akun_bank_id
                INNER JOIN
                users
                ON
                    users_akuns.user_id = users.id
                WHERE
                users.id = $kas AND
                kas.deskripsi='$req1' AND
                kas.tanggal_dikeluarkan BETWEEN '$tgl1' AND '$tgl2'");


                $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $kas");
                return view('report.kas-operasional.index',compact('reports','akunBanks'));

            }elseif(isset($pengeluaran,$pemasukkan,$posting)){


                $reports = DB::select("SELECT
                kas.tanggal_dikeluarkan,
                akun_banks.akun,
                akun_banks.saldo,
                klasifikasi_akuns.sub_akun_transaksi,
                kas.no_nota,
                kas.nama_penerima,
                kas.keterangan,
                kas.nominal,
                kas.deskripsi
                FROM
                kas
                INNER JOIN
                akun_banks
                ON
                    kas.akun_bank_id = akun_banks.id
                INNER JOIN
                users_akuns
                ON
                    akun_banks.id = users_akuns.akun_bank_id
                INNER JOIN
                users
                ON
                    users_akuns.user_id = users.id
                INNER JOIN
                klasifikasi_akuns
                ON
                    kas.klasifikasi_id = klasifikasi_akuns.id
                WHERE
                users.id = $kas AND
                kas.akun_bank_id= '$req2' AND
                kas.deskripsi = '$req1' AND
                kas.tanggal_dikeluarkan BETWEEN '$tgl1' AND '$tgl2'");
                $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $kas");
                return view('report.kas-operasional.index',compact('reports','akunBanks'));

            }
        }

        // if($req1 == 'pemasukkan'){
        //     $reports = Kas::with('klasifikasi')->whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('created_by',Auth::user()->id)->where('deskripsi','pemasukkan')->get();
        //     $reports1 = Kas::with('klasifikasi')->whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('created_by',Auth::user()->id)->where('deskripsi','pemasukkan')->get('nominal')->sum('nominal');
        //     $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $kas");
        //     return view('report.kas-operasional.index',compact('reports','akunBanks'));
        // }if($req1 == 'pengeluaran'){
        //     $reports = Kas::with('klasifikasi')->whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('created_by',Auth::user()->id)->where('deskripsi','pengeluaran')->get();
        //     $reports1 = Kas::with('klasifikasi')->whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('created_by',Auth::user()->id)->where('deskripsi','pengeluaran')->get('nominal')->sum('nominal');
        //     $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $kas");
        //     return view('report.kas-operasional.index',compact('reports','akunBanks'));

    }
    public function reportNasional(Request $request)
    {
    //   dd($request->all());

        $req1 = $request->branch_id;
        // $tgl1 = $request->tgl1.'-31';

        // $tgl1 = $request->month;
        // $tgl2 = $request->year;
        // $start =\Carbon\Carbon::createFromFormat('Y-m-d','2022-01-01');



        // $reports = Kas::with('user')->where(function ($query) use ($req1, $tgl1 ,$tgl2) {
        //     $query->where('branch_id', $req1)->whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2]);
        // })->get();
        if($req1 == 'all'){
            $reports = AkunBank::all();
            // $reports = Kas::selectRaw("SUM(nominal) as nominal, branch_id as branch")
            // // ->whereMonth('tanggal_dikeluarkan',$tgl1)
            // // ->whereYear('tanggal_dikeluarkan',$tgl2)
            // ->whereBetween('tanggal_dikeluarkan',[$start,$tgl1])
            // ->groupBy('branch_id')
            // ->get();
            $reports1 = AkunBank::sum('saldo');
            // $reports = Kas::with('klasifikasi')->whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2,$req1])->where('created_by',Auth::user()->branch_id)->get();
            return view('report.kas-nasional.index',compact('reports','reports1'));
        }else{
            // $reports = Kas::selectRaw("SUM(nominal) as nominal, branch_id as branch")
            // ->where('branch_id',$req1)
            // // ->whereMonth('tanggal_dikeluarkan',$tgl1)
            // // ->whereYear('tanggal_dikeluarkan',$tgl2)
            // ->whereBetween('tanggal_dikeluarkan',[$start,$tgl1])
            // ->groupBy('branch_id')
            // ->get();
            $reports1 = AkunBank::where('branch_id',$req1)->sum('saldo');

            $reports = AkunBank::where('branch_id',$req1)->get();
            // $reports = Kas::with('klasifikasi')->whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2,$req1])->where('created_by',Auth::user()->branch_id)->get();
            return view('report.kas-nasional.index',compact('reports','reports1'));

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
