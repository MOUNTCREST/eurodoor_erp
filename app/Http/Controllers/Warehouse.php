<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse AS wh ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Warehouse extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Illuminate\Session\Middleware\StartSession');
    }
    public function index()
    {
        $ws_lists = wh::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();

		$data = ['ws_lists'=> $ws_lists];
		return view('admin.inventory.warehouse.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.inventory.warehouse.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'warehouse_name' => 'required | max:120',
            'location'  => 'required'
        ]);

        $whs = new wh();
		$whs->warehouse_name = request('warehouse_name');
        $whs->location = request('location');
		$whs->company_id = Session::get('company_id');
        $whs->save();

        return redirect(route('warehouse_list'));
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
    public function edit(wh $id)
    {
        $result = $id;
        return view('admin.inventory.warehouse.edit',compact('result'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, wh $id)
    {
        $validatedData = $request->validate([
            'warehouse_name' => 'required | max:120',
            'location'       => 'required'
        ]);
        $id->update($validatedData);
        return redirect(route('warehouse_list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $whs = wh::find($id);

        $whs->delete_status = 1;
		$whs->save();
		return redirect(route('warehouse_list'));
    }
}
