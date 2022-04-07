<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\AkunBank;
use Auth;
use DataTables;
class AkunBankController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:akun-bank-list|akun-bank-create|akun-bank-edit|akun-bank-delete', ['only' => ['index','store']]);
         $this->middleware('permission:akun-bank-create', ['only' => ['create','store']]);
         $this->middleware('permission:akun-bank-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:akun-bank-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = AkunBank::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn btn-dark btn-sm editProduct"><i class="fas fa-edit"></i> Edit</a>';
                        if(auth()->user()->can('akun-bank-edit')){
                            return $btn;
                        }
                    })
                    ->addColumn('saldo_minimum', function($row){
                                        return "Rp ".number_format($row->saldo_minimum,0,',','.');
                    })
                    ->addColumn('saldo', function($row){
                        return "Rp ".number_format($row->saldo,0,',','.');
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        // $klasifikasis = KlasifikasiAkun::get();
        return view('master.akun-bank.index');
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
            'akun'          => 'required',
            'saldo_minimum' => 'required',
            'branch_alias'  => 'required',
            'rek_akun'      => 'required'
            // 'saldo'   => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }if($request->akun_id == null){
        AkunBank::updateOrCreate(
            ['id'               => $request->akun_id],
            ['akun'             => $request->akun,
            'rek_akun'          => $request->rek_akun,
            'saldo_minimum'     => $request->saldo_minimum,
            'saldo'             => $request->input('saldo',0),
            'branch_id'         => $request->branch_id,
            'branch_alias'      => $request->branch_alias,
            'no_coa'            => $request->no_coa,
            'created_by'        => Auth::id()],
        );
        }else{
            AkunBank::updateOrCreate(
                ['id'               => $request->akun_id],
                ['akun'             => $request->akun,
                'rek_akun'          => $request->rek_akun,
                'saldo_minimum'     => $request->saldo_minimum,
                'branch_id'         => $request->branch_id,
                'branch_alias'      => $request->branch_alias,
                'no_coa'            => $request->no_coa,
                'created_by'        => Auth::id()],
            );
        }
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
        $akuns = AkunBank::findOrFail($id);
        return response()->json($akuns);
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
        AkunBank::find($id)->delete();

        return response()->json(['success'=>'Data Klasifikasi Akun deleted successfully']);
    }
}
