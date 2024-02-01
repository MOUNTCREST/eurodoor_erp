<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory AS pct ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ProductCategory extends Controller
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

        $pc_lists = pct::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();

		$data = ['pc_lists'=> $pc_lists];
		return view('admin.inventory.product_category.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.inventory.product_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required | max:120',
        ]);

        // $pcts = new pct();
		// $pcts->category_name = request('category_name');
		// $pcts->company_id = Session::get('company_id');
        // $pcts->save();

        DB::transaction(function () {
            DB::connection('mysql')->table('product_categories')->insert([
                'category_name' =>  request('category_name'),
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        
            DB::connection('mysql_second')->table('product_categories')->insert([
                'category_name' =>  request('category_name'),
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        });

        return redirect(route('product_category_list'));
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
    public function edit(pct $id)
    {
        $result = $id;
        return view('admin.inventory.product_category.edit',compact('result'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'category_name' => 'required | max:120',
        ]);
       // $id->update($validatedData);
         // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('product_categories')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('product_categories')->where('id', $id)
        ->update([
            'category_name' =>  request('category_name'),
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('product_categories')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('product_categories')->where('id', $id)
        ->update([
            'category_name' =>  request('category_name'),
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);
        return redirect(route('product_category_list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $pct = pct::find($id);

        // $pct->delete_status = 1;
		// $pct->save();

        // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('product_categories')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('product_categories')->where('id', $id)
        ->update([
            'delete_status' => 1,
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('product_categories')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('product_categories')->where('id', $id)
        ->update([
            'delete_status' => 1,
            'updated_at' => DB::raw('NOW()'),
        ]);
		return redirect(route('product_category_list'));
    }
}
