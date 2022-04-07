<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Efilling;
use Auth;

class EfillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:efilling-list|efilling-create|efilling-edit|efilling-delete', ['only' => ['index','store']]);
         $this->middleware('permission:efilling-create', ['only' => ['create','store']]);
         $this->middleware('permission:efilling-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:efilling-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $efillings = Efilling::with('user')->get();
        return view('report.efilling.index',compact('efillings'));
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
        $this->validate($request,[
            'efilling_pdf' => 'required'
        ]);

        $file = $request->file('efilling_pdf');

        $new_file = $file->getClientOriginalName();

        Efilling::create([
            'efilling_pdf'  => $new_file,
            'created_by'    => Auth::id(),
        ]);

        $file->move(public_path('file_efilling'), $new_file);
        return redirect('/efilling-cashopname');
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
