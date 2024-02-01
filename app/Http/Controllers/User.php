<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User AS usr ;
use App\Models\Currency AS crny ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class User extends Controller
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
        //$currency_lists = crny::all();
		//$data = ['currency_lists'=> $currency_lists];
        $user_lists = usr::all();
        $data = ['user_lists'=> $user_lists];
		return view('superadmin.user.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currency_lists = crny::all();
		$data = ['currency_lists'=> $currency_lists];
        return view('superadmin.user.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required | max:120',
            'email' => 'required | string | email | max:255',
            'phone_no' => 'required | max:120',
            'user_name' => 'required',
            'address' => 'required',
            'password' => 'required | min:8',
            
        ]);
        // usr::create($validatedData);
        // $usrs = new usr();
		// $usrs->name = request('name');
		// $usrs->email = request('email');
		// $usrs->phone_no = request('phone_no');
		// $usrs->user_name = request('user_name');
        // $usrs->ad_country_id = request('ad_currency_id');
		// $usrs->ad_currency_id = request('ad_currency_id');
		// $usrs->address = request('address');
		// $usrs->role = 'admin';
        // $usrs->op_edit = $e_status;
        // $usrs->op_delete = $d_status;
		// $usrs->password = Hash::make(request('password'));
		// $usrs->save();

        $e_status = $request->has('op_edit') ? 1 : 0;
        $d_status = $request->has('op_delete') ? 1 : 0;
        
        DB::transaction(function () use ($e_status, $d_status) {
            // Save to the first database
            DB::connection('mysql')->table('users')->insert([
                'name' => request('name'),
                'email' => request('email'),
                'phone_no' => request('phone_no'),
                'user_name' => request('user_name'),
                'address' => request('address'),
                'role' => 'admin',
                'op_edit' => $e_status,
                'op_delete' => $d_status,
                'password' => Hash::make(request('password')),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        
            // Save to the second database
            DB::connection('mysql_second')->table('users')->insert([
                'name' => request('name'),
                'email' => request('email'),
                'phone_no' => request('phone_no'),
                'user_name' => request('user_name'),
                'address' => request('address'),
                'role' => 'admin',
                'op_edit' => $e_status,
                'op_delete' => $d_status,
                'password' => Hash::make(request('password')),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        });

        
      return redirect(route('user_list'));
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
    public function edit(usr $id)
    {
        $result = $id;
        $currency_lists = crny::all();
        return view('superadmin.user.edit',compact('result','currency_lists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required | max:120',
            'email' => 'required | string | email | max:255 ',
            'phone_no' => 'required | max:120',
            'user_name' => 'required',
            'address' => 'required',
            'password' => 'required | min:8',
        ]);

        $e_status = $request->has('op_edit') ? 1 : 0;
        $d_status = $request->has('op_delete') ? 1 : 0;

             // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('users')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('users')->where('id', $id)
        ->update([
            'name' => request('name'),
            'email' => request('email'),
            'phone_no' => request('phone_no'),
            'user_name' => request('user_name'),
            'address' => request('address'),
            'role' => 'admin',
            'op_edit' => $e_status,
            'op_delete' => $d_status,
            'password' => Hash::make(request('password')),
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('users')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('users')->where('id', $id)
        ->update([
            'name' => request('name'),
                'email' => request('email'),
                'phone_no' => request('phone_no'),
                'user_name' => request('user_name'),
                'address' => request('address'),
                'role' => 'admin',
                'op_edit' => $e_status,
                'op_delete' => $d_status,
                'password' => Hash::make(request('password')),
                'updated_at' => DB::raw('NOW()'),
        ]);

            // $usrs = usr::find($id);
            // $usrs->name = request('name');
            // $usrs->email = request('email');
            // $usrs->phone_no = request('phone_no');
            // $usrs->user_name = request('user_name');
            // $usrs->ad_country_id = request('ad_currency_id');
            // $usrs->ad_currency_id = request('ad_currency_id');
            // $usrs->address = request('address');
            // $usrs->role = 'admin';
            // $usrs->op_edit = $e_status;
            // $usrs->op_delete = $d_status;
            // $usrs->password = Hash::make(request('password'));
            
            
            // $usrs->save();
        return redirect(route('user_list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       // Delete record from table1 in db1
       \DB::connection('mysql')->table('users')->where('id', $id)->delete();

       // Delete record from table2 in db2
       \DB::connection('mysql_second')->table('users')->where('id', $id)->delete();

		return redirect(route('user_list'));
    }
   
}
