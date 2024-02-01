<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loginfo AS linfo ;
use Illuminate\Support\Facades\DB;

class Loginfo extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Illuminate\Session\Middleware\StartSession');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $info_lists = linfo::all();
        $info_lists = DB::table('loginfos')
        ->select('loginfos.id','loginfos.role','loginfos.login_date_time','loginfos.logout_date_time','loginfos.ipaddress','loginfos.location','users.name')
        ->join('users','loginfos.user_id','=','users.id')
        ->get();

        $data = ['info_lists'=> $info_lists];
		return view('superadmin.loginfo.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
