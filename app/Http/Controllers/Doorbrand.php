<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doorbrand AS dbrnd ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Doorbrand extends Controller
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
        $db_lists = dbrnd::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();

		$data = ['db_lists'=> $db_lists];
		return view('admin.door_masters.brand.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.door_masters.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required | max:120',
        ]);

        // $uts = new ut();
		// $uts->unit_name = request('unit_name');
		// $uts->company_id = Session::get('company_id');
        // $uts->save();


        DB::transaction(function () {
            DB::connection('mysql')->table('doorbrands')->insert([
                'brand_name' =>  request('brand_name'),
                'created_by' =>  Auth::user()->id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        
            DB::connection('mysql_second')->table('doorbrands')->insert([
                'brand_name' =>  request('brand_name'),
                'created_by' =>  Auth::user()->id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        });


        return redirect(route('door_brand_list'));
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
    public function edit(dbrnd $id)
    {
        $result = $id;
        return view('admin.door_masters.brand.edit',compact('result'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required | max:120',
        ]);
       // $id->update($validatedData);


          // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('doorbrands')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('doorbrands')->where('id', $id)
        ->update([
            'brand_name' =>  request('brand_name'),
            'edited_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('doorbrands')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('doorbrands')->where('id', $id)
        ->update([
            'brand_name' =>  request('brand_name'),
            'edited_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);



        return redirect(route('door_brand_list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('doorbrands')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('doorbrands')->where('id', $id)
        ->update([
            'delete_status' => 1,
            'deleted_by' =>  Auth::user()->id,
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('doorbrands')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('doorbrands')->where('id', $id)
        ->update([
            'delete_status' => 1,
            'deleted_by' =>  Auth::user()->id,
            'updated_at' => DB::raw('NOW()'),
        ]);

		return redirect(route('door_brand_list'));
    }
}
