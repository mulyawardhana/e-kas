<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KlasifikasiAkun;
use App\Models\Transaksi\Kas;
use App\Models\Master\AkunBank;
use App\Models\User;
use DataTables;
use Auth;
use DB;


class PemakaianKasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:pemakaian-list|pemakaian-create|pemakaian-edit|pemakaian-delete', ['only' => ['index','store']]);
         $this->middleware('permission:pemakaian-create', ['only' => ['create','store']]);
         $this->middleware('permission:pemakaian-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pemakaian-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $req1 = $request->req1;
        $kas = Auth::user()->id;
        // if($request->ajax()){
        //     $data = Kas::latest()->get();
        //     return Datatables::of($data)
        //             ->addIndexColumn()
        //             ->addColumn('action', function($row){
        //                 $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fas fa-edit"></i> Update</a>';
   
        //                     return $btn;
        //             })
        //             ->rawColumns(['action'])
        //             ->make(true);
        // }
        // $gtkas_pengeluaran =Kas::where('nominal', '<', 0)->where('created_by',Auth::user()->id)->where('deskripsi','pengeluaran')->get('nominal')->sum('nominal');
        $type_user = Auth::user()->type_user == 1;
        if($type_user){
            if($req1 == ''){
                // $gtkas_pemasukkan =Kas::where('nominal', '>', 0)->where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
                $gtkas_pengeluaran = DB::select("SELECT
                SUM(nominal) AS nominal_t
                FROM
                kas
               
                WHERE
               kas.deskripsi= 'pengeluaran'");
                $gtkas_pemasukkan = DB::select("SELECT
                SUM(nominal) AS nominal_p
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

                ");
                // $gtkas_balances = $gtkas_pemasukkan + $gtkas_pengeluaran;
                $gtkas =Kas::where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
        
                // $model = Kas::where('nominal', '<', 0)->where('branch_id',Auth::user()->branch_id)->with('klasifikasi');
                // $model = Kas::where('nominal', '<', 0)->where('created_by',Auth::user()->id)->where('deskripsi','pengeluaran')->with('klasifikasi');
                $pengeluarans = DB::select("SELECT
                klasifikasi_akuns.sub_akun_transaksi AS sub_akun_transaksi, 
                klasifikasi_akuns.no_akun_induk AS no_akun_induk, 
                klasifikasi_akuns.nama_akun_induk AS nama_akun_induk, 
                kas.tanggal_dikeluarkan AS tanggal_dikeluarkan, 
                kas.no_nota AS no_nota, 
                kas.nama_penerima AS nama_penerima, 
                kas.nominal AS nominal, 
                kas.tanggal_nota AS tanggal_nota, 
                akun_banks.akun AS akun,
                kas.keterangan AS keterangan,
                kas.deskripsi AS deskripsi,
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
                
                kas.deskripsi = 'pengeluaran'");
    
                $gtkas_saldo_minimum = DB::select("SELECT
                akun_banks.akun, 
                akun_banks.rek_akun,
                akun_banks.saldo_minimum,
                akun_banks.saldo
                FROM
                akun_banks

             ");
                $akunBanks = DB::select("SELECT akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks ");
                foreach($gtkas_pengeluaran as $g)
                {
                    $nominal_t = $g->nominal_t;
                }
                foreach($gtkas_pemasukkan as $g)
                {
                    $nominal_p = $g->nominal_p;
                }
                foreach($gtkas_saldo_minimum as $g)
                {
                    $saldo_min = $g->saldo_minimum;
                    $akun1 = $g->akun;
                }
    
                return view('transaksi.pemakaian.index', compact('gtkas','nominal_t','nominal_p','pengeluarans','akunBanks','gtkas_saldo_minimum'));
            }else{
                // $gtkas_pemasukkan =Kas::where('nominal', '>', 0)->where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
                $gtkas_pemasukkan = DB::select("SELECT
                SUM(nominal) AS nominal_p
                FROM
                kas
                INNER JOIN
                akun_banks
                ON 
                    kas.akun_bank_id = akun_banks.id
 
                WHERE
                 kas.akun_bank_id = $req1");
    
                $gtkas_pengeluaran = DB::select("SELECT
                SUM(nominal) AS nominal_t
                FROM
                kas
                INNER JOIN
                akun_banks
                ON 
                    kas.akun_bank_id = akun_banks.id
               
                WHERE
                 kas.deskripsi= 'pengeluaran' AND kas.akun_bank_id = $req1");
    
                $gtkas_saldo_minimum = DB::select("SELECT
                akun_banks.akun, 
                akun_banks.rek_akun,
                akun_banks.saldo_minimum,
                akun_banks.saldo
                FROM
                akun_banks");
                // $gtkas_balances = $gtkas_pemasukkan + $gtkas_pengeluaran;
                $gtkas =Kas::where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
                // $model = Kas::where('nominal', '<', 0)->where('branch_id',Auth::user()->branch_id)->with('klasifikasi');
                // $model = Kas::where('nominal', '<', 0)->where('created_by',Auth::user()->id)->where('deskripsi','pengeluaran')->with('klasifikasi');
                $pengeluarans = DB::select("SELECT
                klasifikasi_akuns.sub_akun_transaksi AS sub_akun_transaksi, 
                klasifikasi_akuns.no_akun_induk AS no_akun_induk, 
                klasifikasi_akuns.nama_akun_induk AS nama_akun_induk, 
                kas.tanggal_dikeluarkan AS tanggal_dikeluarkan, 
                kas.no_nota AS no_nota, 
                kas.nama_penerima AS nama_penerima, 
                kas.nominal AS nominal, 
                kas.tanggal_nota AS tanggal_nota, 
                akun_banks.akun AS akun,
                kas.keterangan AS keterangan,
                kas.deskripsi AS deskripsi,
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
                kas.akun_bank_id = $req1");
    
                $gtkas_saldo_minimum = DB::select("SELECT
                akun_banks.akun, 
                akun_banks.rek_akun,
                akun_banks.saldo_minimum,
                akun_banks.saldo
                FROM
                akun_banks
                WHERE
                     akun_banks.id = $req1");
                foreach($gtkas_pengeluaran as $g)
                {
                    $nominal_t = $g->nominal_t;
                }
                foreach($gtkas_pemasukkan as $g)
                {
                    $nominal_p = $g->nominal_p;
                }
                foreach($gtkas_saldo_minimum as $g)
                {
                    $saldo_min = $g->saldo_minimum;
                    $akun1 = $g->akun;
                }
            
                $akunBanks = DB::select("SELECT akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks ");
                return view('transaksi.pemakaian.index', compact('gtkas','nominal_t','pengeluarans','nominal_p','akunBanks','gtkas_saldo_minimum'));
            }
        }else{
            if($req1 == ''){
                // $gtkas_pemasukkan =Kas::where('nominal', '>', 0)->where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
                $gtkas_pengeluaran = DB::select("SELECT
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
                users.id = $kas AND kas.deskripsi= 'pengeluaran'");
                $gtkas_pemasukkan = DB::select("SELECT
                SUM(nominal) AS nominal_p
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
                users.id = $kas");
                // $gtkas_balances = $gtkas_pemasukkan + $gtkas_pengeluaran;
                $gtkas =Kas::where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
        
                // $model = Kas::where('nominal', '<', 0)->where('branch_id',Auth::user()->branch_id)->with('klasifikasi');
                // $model = Kas::where('nominal', '<', 0)->where('created_by',Auth::user()->id)->where('deskripsi','pengeluaran')->with('klasifikasi');
                $pengeluarans = DB::select("SELECT
                klasifikasi_akuns.sub_akun_transaksi AS sub_akun_transaksi, 
                klasifikasi_akuns.no_akun_induk AS no_akun_induk, 
                klasifikasi_akuns.nama_akun_induk AS nama_akun_induk, 
                kas.tanggal_dikeluarkan AS tanggal_dikeluarkan, 
                kas.no_nota AS no_nota, 
                kas.nama_penerima AS nama_penerima, 
                kas.nominal AS nominal, 
                kas.tanggal_nota AS tanggal_nota, 
                akun_banks.akun AS akun,
                kas.keterangan AS keterangan,
                kas.deskripsi AS deskripsi,
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
                users.id = $kas AND
                kas.deskripsi = 'pengeluaran'");
    
                $gtkas_saldo_minimum = DB::select("SELECT
                akun_banks.akun, 
                akun_banks.rek_akun,
                akun_banks.saldo_minimum,
                akun_banks.saldo
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
                WHERE
                users.id = $kas");
                $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $kas");
                foreach($gtkas_pengeluaran as $g)
                {
                    $nominal_t = $g->nominal_t;
                }
                foreach($gtkas_pemasukkan as $g)
                {
                    $nominal_p = $g->nominal_p;
                }
                foreach($gtkas_saldo_minimum as $g)
                {
                    $saldo_min = $g->saldo_minimum;
                    $akun1 = $g->akun;
                }
    
                return view('transaksi.pemakaian.index', compact('gtkas','nominal_t','nominal_p','pengeluarans','akunBanks','gtkas_saldo_minimum'));
            }else{
                // $gtkas_pemasukkan =Kas::where('nominal', '>', 0)->where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
                $gtkas_pemasukkan = DB::select("SELECT
                SUM(nominal) AS nominal_p
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
                users.id = $kas AND kas.akun_bank_id = $req1");
    
                $gtkas_pengeluaran = DB::select("SELECT
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
                users.id = $kas AND kas.deskripsi= 'pengeluaran' AND kas.akun_bank_id = $req1");
    
                $gtkas_saldo_minimum = DB::select("SELECT
                akun_banks.akun, 
                akun_banks.rek_akun,
                akun_banks.saldo_minimum,
                akun_banks.saldo
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
                WHERE
                users.id = $kas");
                // $gtkas_balances = $gtkas_pemasukkan + $gtkas_pengeluaran;
                $gtkas =Kas::where('created_by',Auth::user()->id)->get('nominal')->sum('nominal');
                // $model = Kas::where('nominal', '<', 0)->where('branch_id',Auth::user()->branch_id)->with('klasifikasi');
                // $model = Kas::where('nominal', '<', 0)->where('created_by',Auth::user()->id)->where('deskripsi','pengeluaran')->with('klasifikasi');
                $pengeluarans = DB::select("SELECT
                klasifikasi_akuns.sub_akun_transaksi AS sub_akun_transaksi, 
                klasifikasi_akuns.no_akun_induk AS no_akun_induk, 
                klasifikasi_akuns.nama_akun_induk AS nama_akun_induk, 
                kas.tanggal_dikeluarkan AS tanggal_dikeluarkan, 
                kas.no_nota AS no_nota, 
                kas.nama_penerima AS nama_penerima, 
                kas.nominal AS nominal, 
                kas.tanggal_nota AS tanggal_nota, 
                akun_banks.akun AS akun,
                kas.keterangan AS keterangan,
                kas.deskripsi AS deskripsi,
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
                users.id = $kas AND
                kas.deskripsi = 'pengeluaran' AND 
                kas.akun_bank_id = $req1");
    
                $gtkas_saldo_minimum = DB::select("SELECT
                akun_banks.akun, 
                akun_banks.rek_akun,
                akun_banks.saldo_minimum,
                akun_banks.saldo
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
                WHERE
                    users.id = $kas AND akun_banks.id = $req1");
                foreach($gtkas_pengeluaran as $g)
                {
                    $nominal_t = $g->nominal_t;
                }
                foreach($gtkas_pemasukkan as $g)
                {
                    $nominal_p = $g->nominal_p;
                }
                foreach($gtkas_saldo_minimum as $g)
                {
                    $saldo_min = $g->saldo_minimum;
                    $akun1 = $g->akun;
                }
            
                $akunBanks = DB::select("SELECT users.`name`, akun_banks.akun, akun_banks.saldo, akun_banks.id FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id = $kas");
                return view('transaksi.pemakaian.index', compact('gtkas','nominal_t','pengeluarans','nominal_p','akunBanks','gtkas_saldo_minimum'));
            }
        }
        
        
    }

    public function ambil(Request $request)
    {
    //     $klasifikasii = DB::select("SELECT
    //     klasifikasi_akuns.sub_akun_transaksi, 
    //     klasifikasi_akuns.no_akun_induk, 
    //     klasifikasi_akuns.nama_akun_induk, 
    //     klasifikasi_akuns.sub_akun_transaksi
    // FROM
    //     klasifikasi_akuns
    // WHERE
    //     klasifikasi_akuns.id = $request->id");
     
        // $klasifikasii = DB::table("klasifikasi_akuns")
        // ->where("id",$request->id)
        // ->pluck("no_akun_induk","nama_akun_induk");
        $klasifikasii = DB::select("SELECT
        klasifikasi_akuns.no_akun_induk , 
        klasifikasi_akuns.nama_akun_induk ,
        klasifikasi_akuns.sub_akun_induk 
    FROM
        klasifikasi_akuns
    WHERE
        klasifikasi_akuns.id = $request->id")[0];
        // foreach($klasifikasi as $klasifikasii)
        // {
            
        // }
        
        return response()->json($klasifikasii);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::user()->id;
        $kas = Auth::user()->branch_id;
        
         // $gtkas_pengeluaran =Kas::where('nominal', '<', 0)->where('created_by',Auth::user()->id)->where('deskripsi','pengeluaran')->get('nominal')->sum('nominal');
         $type_user = Auth::user()->type_user == 1;
         if($type_user){
            $akunBanks = AkunBank::get();
            $klasifikasi = KlasifikasiAkun::get();
            return view('transaksi.pemakaian.create',compact('klasifikasi','akunBanks'));
         }else{
            $akunBanks = User::with('akunBank')->where('id',$auth)->get();
            $klasifikasi = KlasifikasiAkun::get();
            return view('transaksi.pemakaian.create',compact('klasifikasi','akunBanks'));
         }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $kas_id = $request->akun_bank_id;
        $auth = DB::select("SELECT akun_banks.branch_alias FROM akun_banks INNER JOIN kas ON kas.akun_bank_id = akun_banks.id WHERE akun_banks.id = $kas_id")[0];
        $auth1 = $auth->branch_alias;

        $max = Kas::where('no_transaksi',\DB::raw("(select max(`no_transaksi`) from kas)"))->pluck('no_transaksi');
        $check_max=Kas::all()->count();
        if($check_max !== null){
            $no_nota = strtoupper($auth1.'00001');
            $no_nota++;
        }else{
            
            $no_nota = $max[0];
            $no_nota++;
        }
        // dd($no_nota);
        // dd($request->all());
        // $nominal = str_replace(".","",$request->nominal);
        // dd($nominal);
        $nominal_pengeluaran = str_replace(".","",$request->nominal);

    
        if($nominal_pengeluaran)
        {
            $nominal = "-$nominal_pengeluaran";
        }

        $this->validate($request,[
            'klasifikasi_id'        => 'required',
            'tanggal_dikeluarkan'   => 'required',
            'no_nota'               => 'required',
            'nama_penerima'         => 'required',
            'keterangan'            => 'required',
            'nominal'               => 'required',
            'tanggal_nota'          => 'required',
            'file'                  => 'required|mimes:jpg,png,pdf,jpeg|max:2048',
            'file1'                  => 'mimes:jpg,png,pdf,jpeg|max:2048',
            'file2'                  => 'mimes:jpg,png,pdf,jpeg|max:2048',
            'akun_bank_id'          => 'required',
        ]);
        if($nominal < -500000 )
        {
            return redirect('/pemakaian-kas/create')->with('danger','Nilai Melebihi Batas Maksimum, Silahkan buat PPD!');
        }
        
        // if($request->hasFile('file')){
        //     foreach($request->file('file') as $g){
        //         $new_gambar = $g->getClientOriginalName();
        //         $g->move(public_path('images'));
        //         $data[]=$new_gambar;
        //     }
        // }
        // $gambar = '';
        $new_gambar1 = Null;
        $new_gambar2 = Null;

        $gambar = $request->file;
        $gambar1 = $request->file1;
        $gambar2 = $request->file2;

        if($gambar){
            $new_gambar = $gambar->getClientOriginalName();
        }if($gambar1){
            $new_gambar1 = $gambar1->getClientOriginalName();
        }if($gambar2){
            $new_gambar2 = $gambar2->getClientOriginalName();
        }
    

        $akun_bank_id = $request->akun_bank_id;
        $gtkas =AkunBank::where('id',$akun_bank_id)->get('saldo')->sum('saldo');
        $total_saldo = $nominal + $gtkas;
        $total_saldo2 = $nominal - $gtkas;
        $upsaldo = AkunBank::where('id',$akun_bank_id)->update(['saldo' => $total_saldo]);
        $user_id = Auth::user()->id;
        $auth = DB::select("SELECT akun_banks.branch_alias FROM akun_banks WHERE akun_banks.id = $akun_bank_id")[0];
        // $auth = DB::select("SELECT akun_banks.branch_alias FROM users_akuns INNER JOIN akun_banks ON users_akuns.akun_bank_id = akun_banks.id INNER JOIN users ON users.id = users_akuns.user_id WHERE users_akuns.id = $user_id")[0];
        $auth1 = $auth->branch_alias;
        Kas::create([
            'klasifikasi_id'        => $request->klasifikasi_id,
            'tanggal_dikeluarkan'   => $request->tanggal_dikeluarkan,
            'no_nota'               => $request->no_nota,
            'nama_penerima'         => $request->nama_penerima,
            'keterangan'            => $request->keterangan,
            'deskripsi'             => $request->input('deskripsi','pengeluaran'),
            'nominal'               => $nominal,
            'saldo'                 => $nominal + $gtkas,
            'tanggal_nota'          => $request->tanggal_nota,
            'file'                  => $new_gambar,
            'file1'                 => $new_gambar1,
            'file2'                 => $new_gambar2,
            'created_by'            => Auth::id(),
            'branch_id'             => $auth1,
            'akun_bank_id'          => $akun_bank_id,
        ]);
        
        $gambar->move(public_path('images'), $new_gambar);
 
        return redirect('/pemakaian-kas')->with('message','Data Pemakaian Kas Operasional Berhasil di Tambahkan!');
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
        $auth = Auth::user()->id;
        $kas = Kas::findOrFail($id);
        $klasifikasi = KlasifikasiAkun::get();
        $type_user = Auth::user()->type_user == 1;
        if($type_user){
            $akunBanks = AkunBank::get();
            return view('transaksi.pemakaian.edit',compact('kas','klasifikasi','akunBanks'));
        }else{
            $akunBanks = User::with('akunBank')->where('id',$auth)->get();
        return view('transaksi.pemakaian.edit',compact('kas','klasifikasi','akunBanks'));
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
        // $this->validate($request,[
        //     'klasifikasi_id'        => 'required',
        //     'tanggal_dikeluarkan'   => 'required',
        //     'no_nota'               => 'required',
        //     'nama_penerima'         => 'required',
        //     'keterangan'            => 'required',
        //     'nominal'               => 'required|numeric',
        //     'tanggal_nota'          => 'required',
        //     'file'                  => 'required',
        // ]);
        // $gambar = $request->file;
        // $gtkas =Kas::where('created_by',Auth::user()->id)->get('saldo')->sum('saldo');
        // $new_gambar = $gambar->getClientOriginalName();
        // $kas = [
        //     'klasifikasi_id'        => $request->klasifikasi_id,
        //     'tanggal_dikeluarkan'   => $request->tanggal_dikeluarkan,
        //     'no_nota'               => $request->no_nota,
        //     'nama_penerima'         => $request->nama_penerima,
        //     'keterangan'            => $request->keterangan,
        //     'deskripsi'             => $request->input('deskripsi','pengeluaran'),
        //     'nominal'               => $request->nominal,
        //     'tanggal_nota'          => $request->tanggal_nota,
        //     'file'                  => $new_gambar,
        //     'updated_by'            => Auth::id(),
        //     'branch_id'             => Auth::user()->branch_id
        // ];
        // Kas::whereId($id)->update($kas);
        // $gambar->move(public_path('images'), $new_gambar);
        // dd($request->all());
        $nominal = "-".str_replace(".","",$request->nominal);
      
        // if($nominal_pengeluaran)
        // {
        //     $nominal = str_replace(".","","-$request->nominal");
        // }
  
        $this->validate($request,[
            'klasifikasi_id'        => 'required',
            'tanggal_dikeluarkan'   => 'required',
            'no_nota'               => 'required',
            'nama_penerima'         => 'required',
            'keterangan'            => 'required',
            'nominal'               => 'required|numeric',
            'tanggal_nota'          => 'required',
          
            'akun_bank_id'          => 'required',
        ]);
        if($nominal < -500000 )
        {
            return redirect('/pemakaian-kas/create')->with('danger','Nilai Melebihi Batas Maksimum, Silahkan buat PPD!');
        }

        $gambar = $request->file;
        if($gambar){
            $new_gambar = $gambar->getClientOriginalName();
        }
     
        
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
        if($gambar){
            $kas = [
                'klasifikasi_id'        => $request->klasifikasi_id,
                'tanggal_dikeluarkan'   => $request->tanggal_dikeluarkan,
                'no_nota'               => $request->no_nota,
                'nama_penerima'         => $request->nama_penerima,
                'keterangan'            => $request->keterangan,
                'deskripsi'             => $request->input('deskripsi','pengeluaran'),
                'nominal'               => $nominal,
                'tanggal_nota'          => $request->tanggal_nota,
                'file'                  => $new_gambar,
                'created_by'            => Auth::id(),
                'branch_id'             => Auth::user()->branch_id,
                'akun_bank_id'          => $akun_bank_id1,
            ];
            Kas::whereId($id)->update($kas);
            $gambar->move(public_path('images'), $new_gambar);
            return redirect('/pemakaian-kas')->with('info','Data Pemakaian Kas Operasional Berhasil di Update!');
        }else{
            $kas = [
                'klasifikasi_id'        => $request->klasifikasi_id,
                'tanggal_dikeluarkan'   => $request->tanggal_dikeluarkan,
                'no_nota'               => $request->no_nota,
                'nama_penerima'         => $request->nama_penerima,
                'keterangan'            => $request->keterangan,
                'deskripsi'             => $request->input('deskripsi','pengeluaran'),
                'nominal'               => $nominal,
                'tanggal_nota'          => $request->tanggal_nota,
                // 'file'                  => $new_gambar,
                // 'file1'                  => $new_gambar,
                // 'file2'                  => $new_gambar,
                'created_by'            => Auth::id(),
                'branch_id'             => Auth::user()->branch_id,
                'akun_bank_id'          => $akun_bank_id1,
            ];
            Kas::whereId($id)->update($kas);
            // $gambar->move(public_path('images'), $new_gambar);
            return redirect('/pemakaian-kas')->with('info','Data Pemakaian Kas Operasional Berhasil di Update!');
        }
       
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
