<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi\Cashbon;
use App\Models\Transaksi\PertanggungJawaban;
use DB;
use DataTables;
use Auth;

class PertanggungJawabanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:pertanggungjawaban-list|pertanggungjawaban-create|pertanggungjawaban-edit|pertanggungjawaban-delete', ['only' => ['index','store']]);
         $this->middleware('permission:pertanggungjawaban-create', ['only' => ['create','store']]);
         $this->middleware('permission:pertanggungjawaban-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pertanggungjawaban-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
          if($request->ajax()){
            $data = DB::table('pertanggungjawabans')
            ->join('cashbons', 'cashbons.id', '=', 'pertanggungjawabans.kasbon_id')
            ->select(
            'cashbons.no_transaksi', 
            'cashbons.nominal AS nominal_kasbon', 
            'pertanggungjawabans.tanggal_lpj',
            'pertanggungjawabans.action', 
            'pertanggungjawabans.nominal', 
            'pertanggungjawabans.refund', 
            'pertanggungjawabans.selisih',
            'pertanggungjawabans.status', )
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nominal_kasbon', function($row){
                        return "Rp ".number_format($row->nominal_kasbon,0,',','.');
                    })
                    ->addColumn('nominal', function($row){
                        return "Rp ".number_format($row->nominal,0,',','.');
                    })
                    ->addColumn('refund', function($row){
                        return "Rp ".number_format($row->refund,0,',','.');
                    })
                    ->addColumn('selisih', function($row){
                        return "Rp ".number_format($row->selisih,0,',','.');
                    })
                    ->addColumn('tanggal_lpj', function($row){
                        return  date("d/m/Y", strtotime($row->tanggal_lpj));
                    })
                    ->make(true);
          }         
        return view('transaksi.pertanggungjawaban.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cashbons = DB::select("
        SELECT
        cashbons.id,
        cashbons.no_transaksi
        FROM
        cashbons
        LEFT JOIN
        pertanggungjawabans
        ON 
            cashbons.id = pertanggungjawabans.kasbon_id
        WHERE
        pertanggungjawabans.`status` IS NULL 
        ");

        return view('transaksi.pertanggungjawaban.create',compact('cashbons'));
    }
    public function ambil(Request $request)
    {
        $cashbons = DB::select("SELECT
        cashbons.nominal AS nominal_kasbon
        FROM 
        cashbons
        WHERE
        cashbons.id = $request->id
        ")[0];
        // foreach($klasifikasi as $cashbons)
        // {
            
        // }
        
        return response()->json($cashbons);
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
        $this->validate($request,[
            'kasbon_id'     => 'required',
            'tanggal_lpj'   => 'required',
            'nominal'       => 'required',
            'refund'        => 'required',
            
        ]);
        PertanggungJawaban::create([
            'kasbon_id'     => $request->kasbon_id,
            'tanggal_lpj'   => $request->tanggal_lpj,
            'nominal'       => $request->nominal,
            'refund'        => $request->refund,
            'selisih'       => $request->selisih,
            'status'        => $request->input('status','Closed'),
            'created'       => Auth::id(),
        ]);
        return redirect('/pertanggungjawaban');
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
