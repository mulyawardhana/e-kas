<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Master\PemeriksaKas;
use Spatie\Permission\Models\Role;
use App\Models\Master\Jabatan;
use DataTables;
use DB;
use Auth;
use App\Models\Master\AkunBank;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // if($request->ajax()){
        //     $data = User::latest()->with('akunBank');
        //     return Datatables::eloquent($data)
        //             ->addIndexColumn()
        //             ->addColumn('action', function($row){
        //                 $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fas fa-edit"></i> Update</a>';
        //                     return $btn;
        //             })
        //             ->addColumn('minimum_saldo', function($row){
        //                 return "Rp ".number_format($row->minimum_saldo,0,',','.');
        //             })
        //             ->rawColumns(['action'])
        //             ->make(true);
        // }
        $roles = Role::get();
        $akuns = AkunBank::all();
        $pemeriksa = PemeriksaKas::all();
        $users = User::with('pemeriksa')->get();
        $jabatans = Jabatan::all();
        return view('master.user.index', compact('akuns','users','pemeriksa','jabatans','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('master.user.create');
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
        // $b = explode("|",$request->branch);
        // $branch_id = $b[0];
		// $branch_name = $b[1];
        // $b1 = explode("|",$request->office);
		// $office_id = $b1[0];
		// $office_name = $b1[1];
       $akun_id = $request->akun_bank_id;

        $validator = \Validator::make($request->all(), [
            'name'          => 'required',
            'username'      => 'required',
            'password'      => 'required',
            'roles'         => 'required'

            ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $users = User::create(
            [
                'name'              => $request->name,
                'jabatan_id'        => $request->jabatan_id,
                'username'          => $request->username,
                'password'          => bcrypt($request->password),
                'pemeriksa_kas_id'  => $request->pemeriksa_kas_id,
                'jabatan_id'        => $request->jabatan_id,
                // 'email'          => $request->email,
                'is_active'         => $request->input('is_active',1),
                'type_user'           => $request->input('type_user',2),
                // 'office_name'    => $office_name,
                'created_by'        => Auth::id()
            ],
        );
        $users->akunBank()->attach($akun_id);
        $users->assignRole($request->input('roles'));
        return redirect('/user')->with('message','Data user berhasil di tambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::findOrFail($id);
        return view('master.user.show',compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::findOrFail($id);
        // return response()->json($users);
        $akunss = AkunBank::get();
        $jabatans = Jabatan::get();
        $pemeriksa = PemeriksaKas::all();
        $roles = Role::pluck('name','name')->all();
        $userRole = $users->roles->pluck('name','name')->all();
        // $akuns = DB::select("SELECT akun_banks.akun FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users.id = users_akuns.user_id WHERE users.id = $id");

        return view('master.user.edit',compact('users','akunss','jabatans','pemeriksa','roles','userRole'));
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
        $id_akun_bank = $request->akun_bank_id;
        $users = User::findOrFail($id);
       $user = [
                'name'                => $request->name,
                'username'            => $request->username,
                // 'password'            => bcrypt($request->password),
                'jabatan_id'          => $request->jabatan_id,
                'pemeriksa_kas_id'    => $request->pemeriksa_kas_id,
                // 'jabatan_id'          => $request->jabatan_id,
                // 'email'            => $request->email,
                // 'branch_name'      => $request->branch_name,
                'is_active'           => $request->input('is_active',1),
                // 'office_id'        => $office_id,
                // 'office_name'      => $office_name,
                'type_user'           => $request->type_user,
                'created_by'          => Auth::id()
       ];
       $users->akunBank()->sync($id_akun_bank);
       User::whereId($id)->update($user);
       DB::table('model_has_roles')->where('model_id',$id)->delete();
       $users->assignRole($request->input('roles'));
       return redirect('/user')->with('message','Data user berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/user')->with('pesan','Data user berhasil di Hapus');
    }
}
