<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\PemeriksaKas;
use App\Models\Master\Jabatan;
use DB;
use DataTables;
class PemeriksaKasController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:pemeriksa-kas-list|pemeriksa-kas-create|pemeriksa-kas-edit|pemeriksa-kas-delete', ['only' => ['index','store']]);
         $this->middleware('permission:pemeriksa-kas-create', ['only' => ['create','store']]);
         $this->middleware('permission:pemeriksa-kas-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pemeriksa-kas-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = DB::table('pemeriksa_kas')
                        ->join('jabatans', 'jabatans.id', '=' , 'pemeriksa_kas.jabatan_id')
                        ->select('pemeriksa_kas.nama','pemeriksa_kas.id','jabatans.nama_jabatan')
                        ->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/pemeriksa-kas/'. $row->id .'/edit" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-dark btn-sm editProduct"><i class="fas fa-edit"></i> Edit</a>';
                        if(auth()->user()->can('pemeriksa-kas-edit')){
                            return $btn;
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $jabatans = Jabatan::all();
        return view('master.pemeriksa-kas.index',compact('jabatans'));
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
        $validator = \Validator::make($request->all(), [
            'nama'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        PemeriksaKas::updateOrCreate(
            ['id'                   => $request->PemeriksaKas_id],
            ['nama'                 => $request->nama,
            'jabatan_id'            => $request->jabatan_id
            ],
        );
        return response()->json(['success'=>'Product saved successfully.']);
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
        $jabatans = Jabatan::get();
        $pemeriksakas = PemeriksaKas::findOrFail($id);
        return view('master.pemeriksa-kas.edit',compact('pemeriksakas','jabatans'));
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
