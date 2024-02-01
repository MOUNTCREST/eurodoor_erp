<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency AS crny ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Currency extends Controller
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
       $currency_lists = crny::all();
		
		$data = ['currency_lists'=> $currency_lists];
		return view('superadmin.currency.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.currency.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'country' => 'required | max:120',
            'currency' => 'required | max:120',
            'code' => 'required | max:120',
        ]);
        // crny::create($validatedData);
        // $request->session()->flash('alert-success', 'Data Saved Successfully..!');



        DB::transaction(function () {
            DB::connection('mysql')->table('currencies')->insert([
                'country' =>  request('country'),
                'currency' => request('currency'),
                'code' => request('code'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        
            DB::connection('mysql_second')->table('currencies')->insert([
                'country' =>  request('country'),
                'currency' => request('currency'),
                'code' => request('code'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        });



        return redirect(route('currency_list'));
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
    public function edit(crny $id)
    {
        $result = $id;
        return view('superadmin.currency.edit',compact('result'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
        $validatedData = $request->validate([
            'country' => 'required | max:120',
            'currency' => 'required | max:120',
            'code' => 'required | max:120',
        ]);
       // $id->update($validatedData);

         // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('currencies')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('currencies')->where('id', $id)
        ->update([
            'country' =>  request('country'),
            'currency' => request('currency'),
            'code' => request('code'),
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('currencies')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('currencies')->where('id', $id)
        ->update([
            'country' =>  request('country'),
            'currency' => request('currency'),
            'code' => request('code'),
            'updated_at' => DB::raw('NOW()'),
        ]);

        return redirect(route('currency_list'));
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete record from table1 in db1
            \DB::connection('mysql')->table('currencies')->where('id', $id)->delete();

            // Delete record from table2 in db2
            \DB::connection('mysql_second')->table('currencies')->where('id', $id)->delete();
		return redirect(route('currency_list'));
    }
}
