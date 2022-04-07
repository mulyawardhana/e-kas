<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi\Cashbon;
use App\Models\Master\AkunBank;
use DataTables;
use Auth;
use DB;
class CashbonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:cashbon-list|cashbon-create|cashbon-edit|cashbon-delete', ['only' => ['index','store']]);
         $this->middleware('permission:cashbon-create', ['only' => ['create','store']]);
         $this->middleware('permission:cashbon-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cashbon-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $akuns = AkunBank::get();
        if($request->ajax()){
            // $data = Cashbon::latest()->get();
           $data = DB::table('akun_banks')
                    ->join('cashbons', 'akun_banks.id', '=' , 'cashbons.akun_bank_id')
                    ->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/kasbon/'. $row->id .'/edit" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn btn-dark btn-sm editProduct"><i class="fas fa-edit"></i> Edit</a>';
                        if(auth()->user()->can('cashbon-edit')){
                            return $btn;
                        }
                    })
                    ->addColumn('nominal', function($row){
                        return "Rp ".number_format($row->nominal,0,',','.');
                    })
                    ->addColumn('tanggal_pengajuan', function($row){
                        return  date("d/m/Y", strtotime($row->tanggal_pengajuan));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        // $klasifikasis = KlasifikasiAkun::get();
        return view('transaksi.kasbon.index',compact('akuns'));
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
        // dd($request->all());
        $akun_bank_id = $request->akun_bank_id;
        $nominal = str_replace(".","",$request->nominal);
        // $branch_id_request = DB::select("
        // SELECT
        // SUM(pertanggungjawabans.nominal) AS nominal
        // FROM pertanggungjawabans INNER JOIN cashbons
        // ON
        // pertanggungjawabans.kasbon_id = cashbons.id
        // INNER JOIN
        // akun_banks
        // ON
        // cashbons.akun_bank_id = akun_banks.id
        // WHERE
        // cashbons.akun_bank_id = $akun_bank_id
        // ")[0];
        $branch_id_request = DB::select("
        SELECT
        akun_banks.branch_id
        FROM
        akun_banks
        WHERE
        akun_banks.id = $akun_bank_id
        ")[0];
        // dd($branch_id_request);
        $branch_id_substr = $branch_id_request->branch_id;

        $branch_id = substr($branch_id_substr,-10,3);



        $this->validate($request,[
            'tanggal_pengajuan'     => 'required',
            'keterangan'            => 'required',
            'nominal'               => 'required',
            'nama'                  => 'required',
            'file'                  => 'required',
        ]);
        $file = $request->file;
        $new_file = $file->getClientOriginalName();

        Cashbon::Create(
            ['tanggal_pengajuan'    => $request->tanggal_pengajuan,
            'akun_bank_id'          => $request->akun_bank_id,
            'keterangan'            => $request->keterangan,
            'nominal'               => $nominal,
            'branch_id'             => $branch_id,
            'nama'                  => $request->nama,
            'file'                  => $new_file,
            'created_by'            => Auth::id()],
        );
       $file->move(public_path('file_kasbon'), $new_file);
        return redirect()->back();
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
        $akuns = AkunBank::get();
        $kasbons = Cashbon::findOrFail($id);
        return view('transaksi.kasbon.edit',compact('kasbons','akuns'));
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
        $akun_bank_id = $request->akun_bank_id;
        $branch_id_request = DB::select("
        SELECT
        akun_banks.branch_id
        FROM
        akun_banks
        WHERE
        akun_banks.id = $akun_bank_id
        ")[0];
        $branch_id_substr = $branch_id_request->branch_id;
        $branch_id = substr($branch_id_substr,-10,3);
        $this->validate($request,[
            'tanggal_pengajuan'     => 'required',
            'keterangan'            => 'required',
            'nominal'               => 'required',
            'nama'                  => 'required',
        ]);
        $file = $request->file;
        if($file !== null){
            $new_file = $file->getClientOriginalName();
            $cashbon=[
                'tanggal_pengajuan'    => $request->tanggal_pengajuan,
                'akun_bank_id'          => $request->akun_bank_id,
                'keterangan'            => $request->keterangan,
                'nominal'               => $request->nominal,
                'branch_id'             => $branch_id,
                'nama'                  => $request->nama,
                'file'                  => $new_file,
                // 'updated'            => Auth::id()
            ];
            Cashbon::whereId($id)->update($cashbon);
            $file->move(public_path('file_kasbon'), $new_file);
        }else{
            $cashbon =[
                'tanggal_pengajuan'    => $request->tanggal_pengajuan,
                'akun_bank_id'          => $request->akun_bank_id,
                'keterangan'            => $request->keterangan,
                'nominal'               => $request->nominal,
                'branch_id'             => $branch_id,
                'nama'                  => $request->nama,
                // 'updated'            => Auth::id()
            ];
            Cashbon::whereId($id)->update($cashbon);
       }
        return redirect('/kasbon');
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
