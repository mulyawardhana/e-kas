<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi\Kas;
use App\Models\Transaksi\Posting;
use App\Models\Master\AkunBank;
use DB;
use Auth;

class PostingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:posting-list|posting-create|posting-edit|posting-delete', ['only' => ['index','store']]);
         $this->middleware('permission:posting-create', ['only' => ['create','store']]);
         $this->middleware('permission:posting-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:posting-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
         // dd($request->all());
        $auth = Auth::user()->id;
        $id = $request->id;
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;
        $req1 = $request->req1;
        // $max = Kas::where('no_transaksi',\DB::raw("(select max(`no_transaksi`) from kas)"))->pluck('no_transaksi');
        // $check_max=Kas::all()->count();
        // $auth = DB::select("SELECT akun_banks.branch_alias FROM users_akuns INNER JOIN akun_banks ON users_akuns.akun_bank_id = akun_banks.id INNER JOIN users ON users.id = users_akuns.user_id WHERE users_akuns.id = $auth")[0];
        // $auth1 = $auth->branch_alias;
        // if($check_max !== null){
        //     $no_nota = $max[0];
        //     $no_nota++;
        // }else{
        //     $no_nota = strtoupper($auth1.'/'.'MWD00001');
        //     $no_nota++;

        // }

        $type_user = Auth::user()->type_user == 1;
        if($type_user){
            if($id){
                Kas::whereIn('id',$id)->where('nominal', '<', 0)->update([
                    'deskripsi'     => 'posting',
                    // 'no_transaksi'  => $no_nota
                ]);
                return redirect('/posting')->with('message','Data Berhasil di Posting!');
            }
            if($req1){
                $postings = DB::select("SELECT
                klasifikasi_akuns.sub_akun_transaksi,
                kas.tanggal_dikeluarkan,
                kas.tanggal_nota,
                kas.no_nota,
                kas.nama_penerima,
                kas.keterangan,
                kas.nominal,
                kas.deskripsi,
                akun_banks.akun,
                kas.id
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
                kas.akun_bank_id = $req1 AND

                kas.deskripsi = 'pengeluaran' AND
                kas.tanggal_dikeluarkan BETWEEN '$tgl1' AND '$tgl2'
                ");
                 $akunBanks = AkunBank::all();
                return view('transaksi.posting.index',compact('postings', 'akunBanks'));
            }else{
                $postings = DB::select("SELECT
                klasifikasi_akuns.sub_akun_transaksi,
                kas.tanggal_dikeluarkan,
                kas.tanggal_nota,
                kas.no_nota,
                kas.nama_penerima,
                kas.keterangan,
                kas.nominal,
                kas.deskripsi,
                akun_banks.akun,
                kas.id
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
                kas.deskripsi = 'pengeluaran' AND
                kas.tanggal_dikeluarkan BETWEEN '$tgl1' AND '$tgl2'
                ");
                 $akunBanks = $akunBanks = AkunBank::all();
                return view('transaksi.posting.index',compact('postings', 'akunBanks'));
            }
            // if($id){
            //     Kas::whereIn('id',$id)->where('created_by',Auth::user()->id)->where('nominal', '<', 0)->update(['deskripsi' => 'posting']);
            //     $postings= Kas::whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('created_by',Auth::user()->id)->where('nominal', '<', 0)->where('deskripsi','pengeluaran')->get();
            //     // $postings1= Kas::where('created_by',Auth::user()->id)->where('nominal', '<', 0)->where('deskripsi','pengeluaran')->get();
            //      // Kas::where('created_by',Auth::id())->where('deskripsi','pengeluaran')->delete();
            //     //  $kas = Kas::where('deskripsi','posting')->get();
            // }if($req1 == ''){
            //     Kas::whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('created_by',Auth::user()->id)->where('nominal', '<', 0)->update(['deskripsi' => 'posting']);
            //     $postings= Kas::whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('nominal', '<', 0)->where('deskripsi','pengeluaran')->get();
            //     // $postings1= Kas::where('created_by',Auth::user()->id)->where('nominal', '<', 0)->where('deskripsi','pengeluaran')->get();
            // }
            // else{
            //     Kas::whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('created_by',Auth::user()->id)->where('nominal', '<', 0)->update(['deskripsi' => 'posting']);
            //     $postings= Kas::whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('akun_bank_id',$req1)->where('nominal', '<', 0)->where('deskripsi','pengeluaran')->get();
            //     // $postings1= Kas::where('created_by',Auth::user()->id)->where('nominal', '<', 0)->where('deskripsi','pengeluaran')->get();
            //      // Kas::where('created_by',Auth::id())->where('deskripsi','pengeluaran')->delete();
            //     //  $kas = Kas::where('deskripsi','posting')->get();
            // }

        }else{
            if($id){
                Kas::whereIn('id',$id)->where('nominal', '<', 0)->update(['deskripsi' => 'posting']);
                return redirect('/posting')->with('message','Data Berhasil di Posting!');
            }
            if($req1){
                $postings = DB::select("SELECT
                klasifikasi_akuns.sub_akun_transaksi,
                kas.tanggal_dikeluarkan,
                kas.tanggal_nota,
                kas.no_nota,
                kas.nama_penerima,
                kas.keterangan,
                kas.nominal,
                kas.deskripsi,
                akun_banks.akun,
                kas.id
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
                kas.akun_bank_id = $req1 AND
                users.id = $auth AND
                kas.deskripsi = 'pengeluaran' AND
                kas.tanggal_dikeluarkan BETWEEN '$tgl1' AND '$tgl2'
                ");
                 $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $auth");
                return view('transaksi.posting.index',compact('postings', 'akunBanks'));
            }else{
                $postings = DB::select("SELECT
                klasifikasi_akuns.sub_akun_transaksi,
                kas.tanggal_dikeluarkan,
                kas.tanggal_nota,
                kas.no_nota,
                kas.nama_penerima,
                kas.keterangan,
                kas.nominal,
                kas.deskripsi,
                akun_banks.akun,
                kas.id
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

                users.id = $auth AND
                kas.deskripsi = 'pengeluaran' AND
                kas.tanggal_dikeluarkan BETWEEN '$tgl1' AND '$tgl2'
                ");
                 $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $auth");
                return view('transaksi.posting.index',compact('postings', 'akunBanks'));
            }
            // if($id){
            //     Kas::whereIn('id',$id)->where('created_by',Auth::user()->id)->where('nominal', '<', 0)->update(['deskripsi' => 'posting']);
            //     $postings= Kas::whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('created_by',Auth::user()->id)->where('nominal', '<', 0)->where('deskripsi','pengeluaran')->get();
            //     // $postings1= Kas::where('created_by',Auth::user()->id)->where('nominal', '<', 0)->where('deskripsi','pengeluaran')->get();
            //      // Kas::where('created_by',Auth::id())->where('deskripsi','pengeluaran')->delete();
            //     //  $kas = Kas::where('deskripsi','posting')->get();
            // }if($req1 == ''){
            //     Kas::whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('created_by',Auth::user()->id)->where('nominal', '<', 0)->update(['deskripsi' => 'posting']);
            //     $postings= Kas::whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('nominal', '<', 0)->where('deskripsi','pengeluaran')->get();
            //     // $postings1= Kas::where('created_by',Auth::user()->id)->where('nominal', '<', 0)->where('deskripsi','pengeluaran')->get();
            // }
            // else{
            //     Kas::whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('created_by',Auth::user()->id)->where('nominal', '<', 0)->update(['deskripsi' => 'posting']);
            //     $postings= Kas::whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('akun_bank_id',$req1)->where('nominal', '<', 0)->where('deskripsi','pengeluaran')->get();
            //     // $postings1= Kas::where('created_by',Auth::user()->id)->where('nominal', '<', 0)->where('deskripsi','pengeluaran')->get();
            //      // Kas::where('created_by',Auth::id())->where('deskripsi','pengeluaran')->delete();
            //     //  $kas = Kas::where('deskripsi','posting')->get();
            // }
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
    //     $tgl1 = $request->tgl1;
    //     $tgl2 = $request->tgl2;

    //     // Kas::whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('created_by',Auth::user()->id)->where('nominal', '<', 0)->update(['deskripsi' => 'posting']);
    //    $postings= Kas::whereBetween('tanggal_dikeluarkan',[$tgl1,$tgl2])->where('created_by',Auth::user()->id)->where('nominal', '<', 0)->get('deskripsi','posting');
    //     // Kas::where('created_by',Auth::id())->where('deskripsi','pengeluaran')->delete();
    //     return view('',compact('postings'))->with('message','Data Pemakaian Berhasil di Posting!');
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
