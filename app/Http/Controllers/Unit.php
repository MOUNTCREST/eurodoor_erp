<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit AS ut ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Unit extends Controller
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
        $ut_lists = ut::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();

		$data = ['ut_lists'=> $ut_lists];
		return view('admin.inventory.unit.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.inventory.unit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'unit_name' => 'required | max:120',
        ]);

        // $uts = new ut();
		// $uts->unit_name = request('unit_name');
		// $uts->company_id = Session::get('company_id');
        // $uts->save();


        DB::transaction(function () {
            DB::connection('mysql')->table('units')->insert([
                'unit_name' =>  request('unit_name'),
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        
            DB::connection('mysql_second')->table('units')->insert([
                'unit_name' =>  request('unit_name'),
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        });


        return redirect(route('unit_list'));
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
    public function edit(ut $id)
    {
        $result = $id;
        return view('admin.inventory.unit.edit',compact('result'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'unit_name' => 'required | max:120',
        ]);
       // $id->update($validatedData);


          // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('units')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('units')->where('id', $id)
        ->update([
            'unit_name' =>  request('unit_name'),
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('units')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('units')->where('id', $id)
        ->update([
            'unit_name' =>  request('unit_name'),
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);



        return redirect(route('unit_list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $unt = ut::find($id);

        // $unt->delete_status = 1;
		// $unt->save();
        // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('units')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('units')->where('id', $id)
        ->update([
            'delete_status' => 1,
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('units')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('units')->where('id', $id)
        ->update([
            'delete_status' => 1,
            'updated_at' => DB::raw('NOW()'),
        ]);

		return redirect(route('unit_list'));
    }

    public function chatlist(){
        return view('admin.chat.index');
    }
}
