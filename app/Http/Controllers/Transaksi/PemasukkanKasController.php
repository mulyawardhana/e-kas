<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi\Kas;
use Auth;
use App\Models\Master\AkunBank;
use DB;

class PemasukkanKasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:pengisian-list|pengisian-create|pengisian-edit|pengisian-delete', ['only' => ['index','store']]);
         $this->middleware('permission:pengisian-create', ['only' => ['create','store']]);
         $this->middleware('permission:pengisian-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pengisian-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // dd($request->all());
        $req1 = $request->req1;
        $kas = Auth::user()->id;
        $kas_nota = substr($kas,-10, 3);
        $type_user = Auth::user()->type_user == 1;
        if($type_user){
            if($req1 == ''){
                $pemasukkan = DB::select("SELECT
                kas.no_transaksi,
                kas.tanggal_dikeluarkan,
                kas.nominal,
                kas.keterangan,
                akun_banks.akun,
                kas.id
                FROM
                kas
                INNER JOIN
                akun_banks
                ON
                    kas.akun_bank_id = akun_banks.id
                WHERE
                kas.deskripsi='pemasukkan'");
                $gtkas = DB::select("SELECT
                SUM(nominal) AS nominal_t
                FROM
                    kas
                    INNER JOIN
                    akun_banks
                    ON
                        kas.akun_bank_id = akun_banks.id
                WHERE
                    kas.deskripsi= 'pemasukkan'");
                    foreach($gtkas as $g)
                    {
                        $nominal_t = $g->nominal_t;
                    }
               $akunBanks = AkunBank::all();
               return view('transaksi.pemasukkan.index', compact('pemasukkan','nominal_t','akunBanks'));
            }else{
                $pemasukkan = DB::select("SELECT
                 kas.no_transaksi,
                kas.tanggal_dikeluarkan,
                kas.nominal,
                kas.keterangan,
                akun_banks.akun,
                kas.id
                FROM
                kas
                INNER JOIN
                akun_banks
                ON
                    kas.akun_bank_id = akun_banks.id
                WHERE
                kas.akun_bank_id = '$req1' AND
                kas.deskripsi='pemasukkan'");
                $gtkas = DB::select("SELECT
                SUM(nominal) AS nominal_t
                FROM
                    kas
                    INNER JOIN
                    akun_banks
                    ON
                        kas.akun_bank_id = akun_banks.id
                WHERE
                    kas.akun_bank_id = '$req1' AND
                    kas.deskripsi= 'pemasukkan'");
                    foreach($gtkas as $g)
                    {
                        $nominal_t = $g->nominal_t;
                    }
               $akunBanks = AkunBank::all();
               return view('transaksi.pemasukkan.index', compact('pemasukkan','nominal_t','akunBanks'));
            }

        }else{
                if($req1 == ''){
                        // $max = Kas::where('no_nota',\DB::raw("(select max(`no_nota`) from Kas)"))->pluck('no_nota');
            // $check_max=Kas::all()->count();
            // if($check_max == null){
            //     $no_nota = strtoupper($kas_nota.'00001');
            // }else{
            //     $no_nota = $max[0];
            //     $no_nota++;
            // }
            // $pemasukkan = Kas::where('nominal', '>', 0)->where('branch_id',Auth::user()->branch_id)->get();
            $akuns = AkunBank::get();
            // $pemasukkan = Kas::where('nominal', '>', 0)->where('created_by',Auth::user()->id)->get();
            // $pemasukkan = DB::table('kas')
            //                 ->join('akun_banks', 'kas.akun_bank_id', '=', 'akun_banks_id.id')
            //                 ->join('users', 'users.id' , '=' , 'users_akuns.id')
            //                 ->join('users_akuns','akun_banks.id', '=', 'users_akuns.akun_bank_id')
            //                 ->where('users.id', $kas);
        //     $pemasukkan = DB::select("SELECT
        //     *
        // FROM
        //     kas
        //     INNER JOIN
        //     akun_banks
        //     ON
        //         kas.akun_bank_id = akun_banks.id
        //     INNER JOIN
        //     users
        //     INNER JOIN
        //     users_akuns
        //     ON
        //         users.id = users_akuns.user_id AND
        //         akun_banks.id = users_akuns.akun_bank_id
        // WHERE

        //     users.id = $kas");

            // $gtkas =Kas::where('nominal', '>', 0)->where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
            $pemasukkan = DB::select("SELECT
             kas.no_transaksi,
            users.`name`,
            kas.tanggal_dikeluarkan,
            kas.nominal,
            kas.keterangan,
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
            WHERE
            users.id = $kas AND kas.deskripsi='pemasukkan'");
            $gtkas = DB::select("SELECT
            SUM(nominal) AS nominal_t
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
                users.id = $kas AND kas.deskripsi= 'pemasukkan'");
                foreach($gtkas as $g)
                {
                    $nominal_t = $g->nominal_t;
                }
                $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $kas");
            return view('transaksi.pemasukkan.index', compact('pemasukkan','nominal_t','akunBanks'));

            }else{
                $pemasukkan = DB::select("SELECT
                 kas.no_transaksi,
                users.`name`,
                kas.tanggal_dikeluarkan,
                kas.nominal,
                kas.keterangan,
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
                WHERE
                users.id = $kas AND kas.deskripsi='pemasukkan' AND kas.akun_bank_id = $req1");
                $gtkas = DB::select("SELECT
                SUM(nominal) AS nominal_t
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
                    users.id = $kas AND kas.deskripsi= 'pemasukkan' AND kas.akun_bank_id = $req1");
                    foreach($gtkas as $g)
                    {
                        $nominal_t = $g->nominal_t;
                    }
                    $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $kas");
                    return view('transaksi.pemasukkan.index', compact('pemasukkan','nominal_t','akunBanks'));

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
        $tgl = $request->tanggal_dikeluarkan;
        $format_tgl = date('dmY',strtotime($tgl));
        // dd($format_tgl);
        $kas_id = $request->akun_bank_id;

        $auth = DB::select("SELECT akun_banks.branch_alias FROM akun_banks WHERE akun_banks.id = $kas_id")[0];
        // dd($auth);
        $branch = $auth->branch_alias;
        // dd($branch);
        // dd($format_tgl);
        $max = DB::select("SELECT MAX(RIGHT(no_transaksi,3)) AS no_transaksi FROM kas WHERE no_transaksi LIKE '%$branch$format_tgl%'");
        //  $max = Kas::where('no_transaksi',\DB::raw("(select max(`no_transaksi`) from kas where = no_transaksi LIKE '$branch.$format_tgl%')"))->pluck('no_transaksi');

        // $check_max=Kas::all()->count();
        $no="0";
		foreach ($max as $a){
			$no=$a->no_transaksi;
		}
        // dd($max);
		$no_nota = "001";
        if($no>0){
			$no_nota = $no+1;
			$no_nota = sprintf("%04s", $no_nota);
		}


        $no_transaksi = "BKU-$branch$format_tgl$no_nota";
        // dd($no_transaksi);
        // dd($request->all());
        $nominal = str_replace(".","",$request->nominal);
        // dd($nominal);
        $akun_bank_id1 = $request->akun_bank_id;
        $gtkas =AkunBank::where('id',$akun_bank_id1)->get('saldo')->sum('saldo');
        $total_saldo = $nominal + $gtkas;

        // $total_saldo2 = $nominal - $gtkas;
        $upsaldo = AkunBank::where('id',$akun_bank_id1)->update(['saldo' => $total_saldo]);
        $this->validate($request,[
            'akun_bank_id'          => 'required',
            'tanggal_dikeluarkan'   => 'required',
            'nominal'               => 'required|numeric'
        ]);
        // $gtkas =Kas::where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
        Kas::create([
            'akun_bank_id'          => $request->akun_bank_id,
            'tanggal_dikeluarkan'   => $request->tanggal_dikeluarkan,
            'nominal'               => $nominal,
            // 'saldo'                 => $request->nominal + $gtkas,
            'no_transaksi'          => $no_transaksi,
            'klasifikasi_id'        => $request->input('klasifikasi_id',178),
            'deskripsi'             => $request->input('deskripsi','pemasukkan'),
            'keterangan'            => $request->keterangan,
            'created_by'            => Auth::id(),
            'branch_id'             => Auth::user()->branch_id
        ]);
        return redirect('/pemasukkan-kas')->with('message','Pemasukkan Kas Operasional Berhasil di Tambahkan!');
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
        $type_user = Auth::user()->type_user == 1;
        if($type_user){

            $pemasukkan = Kas::findOrFail($id);
            $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id");
            return view('transaksi.pemasukkan.edit', compact('pemasukkan','akunBanks'));
        }else{
            $kas = Auth::user()->id;
            $pemasukkan = Kas::findOrFail($id);
            $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $kas");
            return view('transaksi.pemasukkan.edit', compact('pemasukkan','akunBanks'));
        }

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
        // dd($request->all());


        // $nominal = str_replace(".","",$request->nominal);
        $nominal = $request->nominal;
        $akun_bank_id1 = $request->akun_bank_id;
        $gtkas =AkunBank::where('id',$akun_bank_id1)->get('saldo')->sum('saldo');
        $gtkas2 = DB::select("SELECT
        kas.nominal
        FROM
            kas
        WHERE
        kas.id = $id AND
        kas.akun_bank_id = $akun_bank_id1");
        foreach($gtkas2 as $g)
        {
            $nominal1 = $g->nominal;
        }
        $total_saldo = $nominal + $gtkas - $nominal1  ;
        // $total_saldo2 = $nominal - $gtkas;
        $upsaldo = AkunBank::where('id',$akun_bank_id1)->update(['saldo' => $total_saldo]);
        $this->validate($request,[
            'akun_bank_id'          => 'required',
            'tanggal_dikeluarkan'   => 'required',
            'nominal'               => 'required'
        ]);
        // $gtkas =Kas::where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
       $kas = [
            'akun_bank_id'          => $request->akun_bank_id,
            'tanggal_dikeluarkan'   => $request->tanggal_dikeluarkan,
            'nominal'               => $request->nominal,
            // 'saldo'                 => $request->nominal + $gtkas,
            // 'no_nota'               => $request->no_nota,
            'deskripsi'             => $request->input('deskripsi','pemasukkan'),
            'keterangan'            => $request->input('keterangan','Pengisian kas'),
            'created_by'            => Auth::id(),
            'branch_id'             => Auth::user()->branch_id
        ];
        Kas::whereId($id)->update($kas);
        return redirect('/pemasukkan-kas')->with('message','Pemasukkan Kas Operasional Berhasil di Tambahkan!');
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

    public function penyesuaian(Request $request)
    {
        $type_p = $request->type_p;

        if($type_p == 'tambah')
        {
            $nominal = $request->nominal;
            $akun_bank_id1 = $request->akun_bank_id;
            $gtkas =AkunBank::where('id',$akun_bank_id1)->get('saldo')->sum('saldo');
            $total_saldo = $nominal + $gtkas;

            // $total_saldo2 = $nominal - $gtkas;
            $upsaldo = AkunBank::where('id',$akun_bank_id1)->update(['saldo' => $total_saldo]);
            // dd($upsaldo);
            $this->validate($request,[
                'akun_bank_id'          => 'required',
                'tanggal_dikeluarkan'   => 'required',
                'nominal'               => 'required'
            ]);
            // $gtkas =Kas::where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
            Kas::create([
                'akun_bank_id'          => $request->akun_bank_id,
                'tanggal_dikeluarkan'   => $request->tanggal_dikeluarkan,
                'nominal'               => $request->nominal,
                // 'saldo'                 => $request->nominal + $gtkas,
                // 'no_nota'               => $request->no_nota,
                'klasifikasi_id'        => $request->input('klasifikasi_id',178),
                'deskripsi'             => $request->input('deskripsi','pemasukkan'),
                'keterangan'            => $request->keterangan,
                'created_by'            => Auth::id(),
                'branch_id'             => Auth::user()->branch_id
            ]);
            return redirect('/pemasukkan-kas')->with('message','Penyesuaian Kas Operasional Berhasil di Tambahkan!');
        }else{
            $nominal1 = $request->nominal;
            if($nominal1){
                $nominal = "-$nominal1";
            }

            $akun_bank_id1 = $request->akun_bank_id;
            $gtkas =AkunBank::where('id',$akun_bank_id1)->get('saldo')->sum('saldo');
            $total_saldo = $nominal + $gtkas;
            // dd($total_saldo);
            // $total_saldo2 = $nominal - $gtkas;
            $upsaldo = AkunBank::where('id',$akun_bank_id1)->update(['saldo' => $total_saldo]);
            // dd($upsaldo);
            $this->validate($request,[
                'akun_bank_id'          => 'required',
                'tanggal_dikeluarkan'   => 'required',
                'nominal'               => 'required'
            ]);
            // $gtkas =Kas::where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
            Kas::create([
                'akun_bank_id'          => $request->akun_bank_id,
                'tanggal_dikeluarkan'   => $request->tanggal_dikeluarkan,
                'nominal'               => $request->nominal,
                // 'saldo'                 => $request->nominal + $gtkas,
                // 'no_nota'               => $request->no_nota,
                'klasifikasi_id'        => $request->input('klasifikasi_id',178),
                'deskripsi'             => $request->input('deskripsi','pemasukkan'),
                'keterangan'            => $request->keterangan,
                'created_by'            => Auth::id(),
                'branch_id'             => Auth::user()->branch_id
            ]);
            return redirect('/pemasukkan-kas')->with('message','Penyesuaian Kas Operasional Berhasil di Tambahkan!');
        }
    }
}
