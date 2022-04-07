<?php
    
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
    
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return view('roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $permission = Permission::get();
        $roles = Role::get();
        $permissions = Permission::where('grub_permission','role')->get();
        $permissions1 = Permission::where('grub_permission','user')->get();
        $permissions2 = Permission::where('grub_permission','klasifikasi')->get();

        $permissions3 = Permission::where('grub_permission','jabatan')->get();
        $permissions4 = Permission::where('grub_permission','pemeriksa-kas')->get();
        $permissions5 = Permission::where('grub_permission','jkas')->get();

        $permissions6 = Permission::where('grub_permission','pemakaian')->get();
        $permissions7 = Permission::where('grub_permission','pengisian')->get();
        $permissions8 = Permission::where('grub_permission','posting')->get();
        $permissions9 = Permission::where('grub_permission','cashopname')->get();
        $permissions10 = Permission::where('grub_permission','efilling')->get();
        $permissions11 = Permission::where('grub_permission','report-operasional')->get();
        $permissions12 = Permission::where('grub_permission','akun-bank')->get();
        $permissions13 = Permission::where('grub_permission','cashbon')->get();
        $permissions14 = Permission::where('grub_permission','pertanggungjawaban')->get();
        $permissions15 = Permission::where('grub_permission','report-nasional')->get();
        $permissions16 = Permission::where('grub_permission','report-lpj')->get();
        $permissions17 = Permission::where('grub_permission','efilling')->get();
        return view('roles.create',compact('roles','permissions','permissions1','permissions2','permissions3','permissions4','permissions5','permissions6','permissions7','permissions8','permissions9','permissions10','permissions11','permissions12','permissions13','permissions14','permissions15','permissions16','permissions17'));
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
        $this->validate($request, [
            'name'          => 'required|unique:roles,name',
            'permission'    => 'required',
        ]);
    
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return view('roles.show',compact('role','rolePermissions'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::get();
        $permissions = Permission::where('grub_permission','role')->get();
        $permissions1 = Permission::where('grub_permission','user')->get();
        $permissions2 = Permission::where('grub_permission','klasifikasi')->get();

        $permissions3 = Permission::where('grub_permission','jabatan')->get();
        $permissions4 = Permission::where('grub_permission','pemeriksa-kas')->get();
        $permissions5 = Permission::where('grub_permission','jkas')->get();

        $permissions6 = Permission::where('grub_permission','pemakaian')->get();
        $permissions7 = Permission::where('grub_permission','pengisian')->get();
        $permissions8 = Permission::where('grub_permission','posting')->get();
        $permissions9 = Permission::where('grub_permission','cashopname')->get();
        $permissions10 = Permission::where('grub_permission','efilling')->get();
        $permissions11 = Permission::where('grub_permission','report-operasional')->get();
        $permissions12 = Permission::where('grub_permission','akun-bank')->get();
        $permissions13 = Permission::where('grub_permission','cashbon')->get();
        $permissions14 = Permission::where('grub_permission','pertanggungjawaban')->get();
        $permissions15 = Permission::where('grub_permission','report-nasional')->get();
        $permissions16 = Permission::where('grub_permission','report-lpj')->get();
        $permissions17 = Permission::where('grub_permission','efilling')->get();
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        return view('roles.edit',compact('role','permissions','rolePermissions','permissions1','permissions2','permissions3','permissions4','permissions5','permissions6','permissions7','permissions8','permissions9','permissions10','permissions11','permissions12','permissions13','permissions14','permissions15','permissions16','permissions17'));
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
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}