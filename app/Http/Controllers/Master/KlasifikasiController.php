<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KlasifikasiAkun;
use Auth;
use DataTables;

class KlasifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:klasifikasi-list|klasifikasi-create|klasifikasi-edit|klasifikasi-delete', ['only' => ['index','store']]);
         $this->middleware('permission:klasifikasi-create', ['only' => ['create','store']]);
         $this->middleware('permission:klasifikasi-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:klasifikasi-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = KlasifikasiAkun::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-dark btn-sm editProduct"><i class="fas fa-edit"></i> Edit</a>';
                        if(auth()->user()->can('klasifikasi-edit')){
                            return $btn;
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        // $klasifikasis = KlasifikasiAkun::get();
        return view('master.klasifikasi.index');
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
            'no_akun_induk'     => 'required',
            'nama_akun_induk'    => 'required',
            'sub_akun_induk'     => 'required',
            'sub_akun_transaksi'       => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        KlasifikasiAkun::updateOrCreate(
            ['id'                => $request->klasifikasi_id],
            ['sub_akun_transaksi'       => $request->sub_akun_transaksi,
            'no_akun_induk'         => $request->no_akun_induk,
            'nama_akun_induk'         => $request->nama_akun_induk,
            'sub_akun_induk'         => $request->sub_akun_induk,
            'created_by'        => Auth::id()],
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
        $klasifikasis = KlasifikasiAkun::findOrFail($id);
        return response()->json($klasifikasis);
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
        KlasifikasiAkun::find($id)->delete();

        return response()->json(['success'=>'Data Klasifikasi Akun deleted successfully']);
    }
}
