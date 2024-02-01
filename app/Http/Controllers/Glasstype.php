<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Glasstype AS gt ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Glasstype extends Controller
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
        $gt_lists = gt::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();

		$data = ['gt_lists'=> $gt_lists];
		return view('admin.door_masters.glass_type.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.door_masters.glass_type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'glass_type_name' => 'required | max:120',
        ]);

        // $uts = new ut();
		// $uts->unit_name = request('unit_name');
		// $uts->company_id = Session::get('company_id');
        // $uts->save();


        DB::transaction(function () {
            DB::connection('mysql')->table('glasstypes')->insert([
                'glass_type_name' =>  request('glass_type_name'),
                'created_by' =>  Auth::user()->id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        
            DB::connection('mysql_second')->table('glasstypes')->insert([
                'glass_type_name' =>  request('glass_type_name'),
                'created_by' =>  Auth::user()->id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        });


        return redirect(route('glass_type_list'));
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
    public function edit(gt $id)
    {
        $result = $id;
        return view('admin.door_masters.glass_type.edit',compact('result'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'glass_type_name' => 'required | max:120',
        ]);
       // $id->update($validatedData);


          // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('glasstypes')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('glasstypes')->where('id', $id)
        ->update([
            'glass_type_name' =>  request('glass_type_name'),
            'edited_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('glasstypes')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('glasstypes')->where('id', $id)
        ->update([
            'glass_type_name' =>  request('glass_type_name'),
            'edited_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);



        return redirect(route('glass_type_list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('glasstypes')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('glasstypes')->where('id', $id)
        ->update([
            'delete_status' => 1,
            'deleted_by' =>  Auth::user()->id,
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('glasstypes')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('glasstypes')->where('id', $id)
        ->update([
            'delete_status' => 1,
            'deleted_by' =>  Auth::user()->id,
            'updated_at' => DB::raw('NOW()'),
        ]);

		return redirect(route('glass_type_list'));
    }
}
