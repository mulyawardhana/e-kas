<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi\CashOpname;
use App\Models\Transaksi\Kas;
use App\Models\Master\AkunBank;
use App\Models\User;
use Auth;
use DB;
class CashOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:cashopname-list|cashopname-create|cashopname-edit|cashopname-delete', ['only' => ['index','store']]);
         $this->middleware('permission:cashopname-create', ['only' => ['create','store']]);
         $this->middleware('permission:cashopname-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cashopname-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $cashOpname= CashOpname::get();
        return view('report.kas-opname.index',compact('cashOpname'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth_id = Auth::user()->id;
        $type_user = Auth::user()->type_user == 1;
        if($type_user){
            $jenis_kas = DB::table('jenis_kas')->get();
            $kepala_cabang = DB::table('pemeriksa_kas')->get();
            $gtkas_pengeluaran1 =Kas::where('nominal', '<', 0)->where('created_by',Auth::user()->id)->where('deskripsi','posting')->get('nominal')->sum('nominal');
            $gtkas_pengeluaran = substr($gtkas_pengeluaran1,1);
            $akunBanks = AkunBank::get();
            // $gtkas_pemasukkan =Kas::where('nominal', '>', 0)->where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
            // $gtkas_balances = $gtkas_pemasukkan + $gtkas_pengeluaran;
            $gtkas_pemasukkan = Kas::where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
            $saldo_awal =Kas::where('nominal', '>', 0)->where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
            return view('report.kas-opname.create',compact('akunBanks','gtkas_pengeluaran','gtkas_pemasukkan','saldo_awal','jenis_kas','kepala_cabang'));
        }else{
            $jenis_kas = DB::table('jenis_kas')->get();
            // $kepala_cabang = DB::select("SELECT
            // pemeriksa_kas.nama,
            // pemeriksa_kas.id
            // FROM
            // users
            // INNER JOIN
            // pemeriksa_kas
            // ON
            //     users.pemeriksa_kas_id = pemeriksa_kas.id
            // WHERE
            // users.id = $auth_id");
            $kepala_cabang = DB::table('pemeriksa_kas')
                            ->join('users', 'users.pemeriksa_kas_id', '=' , 'pemeriksa_kas.id')
                            ->where('users.id', '=' , $auth_id)
                            ->get();

            $gtkas_pengeluaran1 =Kas::where('nominal', '<', 0)->where('created_by',Auth::user()->id)->where('deskripsi','posting')->get('nominal')->sum('nominal');
            $gtkas_pengeluaran = substr($gtkas_pengeluaran1,1);
            $akunBanks = DB::select("SELECT akun_banks.akun,users.id FROM users INNER JOIN users_akuns ON users.id = users_akuns.user_id INNER JOIN akun_banks ON users_akuns.akun_bank_id = akun_banks.id WHERE users.id = $auth_id");

            // $gtkas_pemasukkan =Kas::where('nominal', '>', 0)->where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
            // $gtkas_balances = $gtkas_pemasukkan + $gtkas_pengeluaran;
            $gtkas_pemasukkan = Kas::where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
            $saldo_awal =Kas::where('nominal', '>', 0)->where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
            return view('report.kas-opname.create',compact('akunBanks','gtkas_pengeluaran','gtkas_pemasukkan','saldo_awal','jenis_kas','kepala_cabang'));
        }

    }

    public function getOut(Request $request)
    {
        $akun_bank = $request->akun_bank_id;
        $getOut = DB::select("SELECT
        SUM(kas.nominal) AS nominal
        FROM
        akun_banks
        INNER JOIN
        users_akuns
        ON
            akun_banks.id = users_akuns.akun_bank_id
        INNER JOIN
        users
        ON
            users_akuns.user_id = users.id
        INNER JOIN
        kas
        ON
            akun_banks.id = kas.akun_bank_id
        WHERE
        kas.deskripsi = 'pengeluaran' AND
        kas.akun_bank_id = $akun_bank")[0];

        return response()->json($getOut);
    }

    public function getCashBon(Request $request)
    {
        $akun_bank = $request->akun_bank_id;
        $getCashBons = DB::select("SELECT
        SUM(cashbons.nominal) AS nominal
        FROM
        cashbons
        INNER JOIN
        akun_banks
        ON
            cashbons.akun_bank_id = akun_banks.id
        WHERE
        cashbons.akun_bank_id = $akun_bank")[0];

        return response()->json($getCashBons);
    }
    public function getCash(Request $request)
    {
        $akun_bank = $request->akun_bank_id;
        $getCash = DB::select("SELECT
        saldo
        FROM
        akun_banks
        WHERE
        akun_banks.id = $akun_bank")[0];

        return response()->json($getCash);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        CashOpname::create([
            'akun_bank_id'      => $request->akun_bank_id,
            'jenis_kas_id'      => $request->jenis_kas_id,
            'pemeriksa_kas_id'  => $request->pemeriksa_kas_id,
            'month_year'        => $request->month_year,
            'cash_on_hand'      => $request->cash_on_hand,
            'pk_100k'           => $request->pk_100k,
            'pk_50k'            => $request->pk_50k,
            'pk_20k'            => $request->pk_20k,
            'pk_10k'            => $request->pk_10k,
            'pk_5k'             => $request->pk_5k,
            'pk_2k'             => $request->pk_2k,
            'pk_1k'             => $request->pk_1k,
            'pl_1000'           => $request->pl_1000,
            'pl_500'            => $request->pl_500,
            'pl_200'            => $request->pl_200,
            'pl_100'            => $request->pl_100,
            'bon_sementara'     => $request->bon_sementara,
            'total_kas_tunai'   => $request->total_kas_tunai,
            'belum_dibayarkan'  => $request->belum_dibayarkan,
            'grand_total'       => $request->grand_total,
            'saldo_awal'        => $request->saldo_awal,
            'start_jam'         => $request->start_jam,
            'tanggal_cashopname'=> $request->tanggal_cashopname,
            'nama_pemegang_kas' => $request->nama_pemegang_kas,
            'end_jam'           => $request->end_jam,
            'user_id'           => Auth::user()->id,
        ]);

        return redirect('/kas-opname');
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

    public function printCashOpname(Request $request,$id)
    {
        $cashopnames = CashOpname::find($id);
        return view('report.kas-opname.Rpdf',compact('cashopnames'));
    }
}
