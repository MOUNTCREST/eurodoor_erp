<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyAdminPrivillage AS cap ;
use App\Models\User AS usr ;
use App\Models\Company AS cay ;
use Illuminate\Support\Facades\DB;

class CompanyAdminPrivillages extends Controller
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
       // $lists = cap::all();
        $list_admin = usr::all();
        $list_company = cay::all();
       
        $lists = DB::table('company_admin_privillages')
        ->select('company_admin_privillages.id','users.name','companies.company_name')
        ->join('users','company_admin_privillages.admin_id','=','users.id')
        ->join('companies','company_admin_privillages.company_id','=','companies.id')
        ->get();

        $data = ['lists'=> $lists,'list_admin'=> $list_admin,'list_company'=> $list_company];
		return view('superadmin.company_admin_privillage.index',$data);
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
        $validatedData = $request->validate([
            'company_id' => 'required',
            'admin_id' => 'required',
        ]);
       // cap::create($validatedData);
      //  $request->session()->flash('alert-success', 'Data Saved Successfully..!');
      DB::transaction(function () {
        DB::connection('mysql')->table('company_admin_privillages')->insert([
            'company_id' =>  request('company_id'),
            'admin_id' => request('admin_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);
    
        DB::connection('mysql_second')->table('company_admin_privillages')->insert([
            'company_id' =>  request('company_id'),
            'admin_id' => request('admin_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);
    });


        return redirect(route('privillage_list'));
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
        // Delete record from table1 in db1
        \DB::connection('mysql')->table('company_admin_privillages')->where('id', $id)->delete();

        // Delete record from table2 in db2
        \DB::connection('mysql_second')->table('company_admin_privillages')->where('id', $id)->delete();
		return redirect(route('privillage_list'));
    }
    public function check_already_exists(Request $request){

        $admin_id = $request->admin_id;
        $company_id = $request->company_id;
        $query = DB::table('company_admin_privillages')
                ->where('admin_id', '=', $admin_id)
                ->where('company_id', '=', $company_id)
                ->count();
        return response()->json($query);
    }
}
