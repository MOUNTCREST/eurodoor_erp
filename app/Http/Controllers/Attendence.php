<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee AS emply ;
use App\Models\Attendence AS atndnc ;
use App\Models\AttendenceMain AS atndncmn ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Attendence extends Controller
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
        $at_lists =  DB::table('attendence_mains')
        ->select('attendence_mains.*')
        ->where("attendence_mains.delete_status", "=", 0)
        ->where("attendence_mains.company_id", "=", Session::get('company_id'))
        ->get();

        $data = ['at_lists'=> $at_lists];
		return view('admin.daily_wages.attendence.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ey_lists =  DB::table('employees')
        ->select('employees.id','employees.e_name')
        ->where("employees.delete_status", "=", 0)
        ->where("employees.status", "=", 0)
        ->where("employees.company_id", "=", Session::get('company_id'))
        ->get();
        $data = ['ey_lists'=> $ey_lists];
        return view('admin.daily_wages.attendence.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'added_date' => 'required',
        ]);

        $main_id = DB::connection('mysql')->table('attendence_mains')->insertGetId([
            'added_date' =>  request('added_date'),
            'total' =>  request('total_h_m'),
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);
        
        DB::connection('mysql_second')->table('attendence_mains')->insert([
            'added_date' =>  request('added_date'),
            'total' =>  request('total_h_m'),
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);
        
        $data_ref =  DB::table('employee_accounts')
       ->select('employee_accounts.id')
       ->where("employee_accounts.company_id", "=", Session::get('company_id'))
       ->where("employee_accounts.type", "=", "attendences")
       ->get();
   

        if(empty($data_ref)){
           $num = 0;
        }
        else{
           $num = DB::table('employee_accounts')
               ->where('company_id', '=', Session::get('company_id'))
               ->where("employee_accounts.type", "=", "attendences")
               ->count();
        }
        $refe_a= $num + 1;
        $refe_a = str_pad($refe_a, 4, '0', STR_PAD_LEFT);
        $r_no = "AT".$refe_a;

        
        $employee_id = request('employee_id');
        $m_s_in = request('m_s_in');
        $m_s_out = request('m_s_out');
        $a_s_in = request('a_s_in');
        $a_s_out = request('a_s_out');
        $total = request('total');
        $p_h_amnt = request('p_h_amnt');
        $net_total_salary = request('net_total_salary');
        
        for($i=0;$i<count($employee_id);$i++) {
            DB::transaction(function () use ($main_id, $employee_id, $m_s_in, $m_s_out, $a_s_in,$a_s_out,$total,$i,$p_h_amnt,$net_total_salary,$r_no) {
                DB::connection('mysql')->table('attendences')->insert([
                    'main_id' =>  $main_id,
                    'added_date' => request('added_date'),
                    'employee_id' =>  $employee_id[$i],
                    'moring_shift_in' =>  $m_s_in[$i],
                    'moring_shift_out' =>  $m_s_out[$i],
                    'after_shift_in' =>  $a_s_in[$i],
                    'after_shift_out' =>  $a_s_out[$i],
                    'total' =>  $total[$i],
                    'per_hour_amount' => $p_h_amnt[$i],
                    'total_salary' => $net_total_salary[$i],
                    'company_id' => Session::get('company_id'),
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);


                DB::connection('mysql')->table('employee_accounts')->insert([
                    'attendence_id' =>  $main_id,
                    'added_date' => request('added_date'),
                    'em_id' =>  $employee_id[$i],
                    'cr_amount' =>  $net_total_salary[$i],
                    'ref_no' =>  $r_no,
                    'type' =>  'attendance',
                    'total_hour' =>  $total[$i],
                    'created_by' =>  Auth::user()->id,
                    'company_id' => Session::get('company_id'),
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);


                DB::connection('mysql_second')->table('attendences')->insert([
                    'main_id' =>  $main_id,
                    'added_date' => request('added_date'),
                    'employee_id' =>  $employee_id[$i],
                    'moring_shift_in' =>  $m_s_in[$i],
                    'moring_shift_out' =>  $m_s_out[$i],
                    'after_shift_in' =>  $a_s_in[$i],
                    'after_shift_out' =>  $a_s_out[$i],
                    'total' =>  $total[$i],
                    'per_hour_amount' => $p_h_amnt[$i],
                    'total_salary' => $net_total_salary[$i],
                    'company_id' => Session::get('company_id'),
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);

                DB::connection('mysql_second')->table('employee_accounts')->insert([
                    'attendence_id' =>  $main_id,
                    'added_date' => request('added_date'),
                    'em_id' =>  $employee_id[$i],
                    'cr_amount' =>  $net_total_salary[$i],
                    'ref_no' =>  $r_no,
                    'type' =>  'attendance',
                    'total_hour' =>  $total[$i],
                    'created_by' =>  Auth::user()->id,
                    'company_id' => Session::get('company_id'),
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            });
        }
       return redirect(route('attencence_list'));
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
    public function edit(atndncmn $id)
    {
        $ey_lists =  DB::table('employees')
        ->select('employees.id','employees.e_name')
        ->where("employees.delete_status", "=", 0)
        ->where("employees.status", "=", 0)
        ->where("employees.company_id", "=", Session::get('company_id'))
        ->get();
        $result = $id;
        $al_items = DB::table('attendences')
                ->select('id', 'main_id', 'employee_id', DB::raw('TIME_FORMAT(moring_shift_in, "%H:%i") as moring_shift_in'), DB::raw('TIME_FORMAT(moring_shift_out, "%H:%i") as moring_shift_out'), DB::raw('TIME_FORMAT(after_shift_in, "%H:%i") as after_shift_in'), DB::raw('TIME_FORMAT(after_shift_out, "%H:%i") as after_shift_out'), 'total','per_hour_amount','total_salary')
                ->where('main_id', $result->id)
                ->get();
        return view('admin.daily_wages.attendence.edit',compact('result','ey_lists','al_items'))->with('no', 0);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    
        $validatedData = $request->validate([
            'added_date' => 'required',
        ]);

        // $atndncmns = atndncmn::find($id);

        // $atndncmns->added_date =  request('added_date');
        // $atndncmns->total =  request('total_h_m');
        // $atndncmns->company_id = Session::get('company_id');
        // $atndncmns->save();
        // $res=atndnc::where('main_id',$main_id)->delete();

        // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('attendence_mains')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('attendence_mains')->where('id', $id)
        ->update([
            'added_date' =>  request('added_date'),
            'total' =>  request('total_h_m'),
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('attendence_mains')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('attendence_mains')->where('id', $id)
        ->update([
            'added_date' =>  request('added_date'),
            'total' =>  request('total_h_m'),
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);

        $main_id = $id;

         // Delete record from table1 in db1
       \DB::connection('mysql')->table('attendences')->where('main_id', $main_id)->delete();

       // Delete record from table2 in db2
       \DB::connection('mysql_second')->table('attendences')->where('main_id', $main_id)->delete();

        // Delete record from table1 in db1
        \DB::connection('mysql')->table('employee_accounts')->where('attendence_id', $main_id)->delete();

       // Delete record from table2 in db2
       \DB::connection('mysql_second')->table('employee_accounts')->where('attendence_id', $main_id)->delete();

       $data_ref =  DB::table('employee_accounts')
       ->select('employee_accounts.id')
       ->where("employee_accounts.company_id", "=", Session::get('company_id'))
       ->where("employee_accounts.type", "=", "attendences")
       ->get();
   

        if(empty($data_ref)){
           $num = 0;
        }
        else{
           $num = DB::table('employee_accounts')
               ->where('company_id', '=', Session::get('company_id'))
               ->where("employee_accounts.type", "=", "attendences")
               ->count();
        }
        $refe_a= $num + 1;
        $refe_a = str_pad($refe_a, 4, '0', STR_PAD_LEFT);
        $r_no = "AT".$refe_a;

        
        $employee_id = request('employee_id');
        $m_s_in = request('m_s_in');
        $m_s_out = request('m_s_out');
        $a_s_in = request('a_s_in');
        $a_s_out = request('a_s_out');
        $total = request('total');
        $p_h_amnt = request('p_h_amnt');
        $net_total_salary = request('net_total_salary');
        
        for($i=0;$i<count($employee_id);$i++) {
            DB::transaction(function () use ($main_id, $employee_id, $m_s_in, $m_s_out, $a_s_in,$a_s_out,$total,$i,$p_h_amnt,$net_total_salary,$r_no) {
                DB::connection('mysql')->table('attendences')->insert([
                    'main_id' =>  $main_id,
                    'added_date' => request('added_date'),
                    'employee_id' =>  $employee_id[$i],
                    'moring_shift_in' =>  $m_s_in[$i],
                    'moring_shift_out' =>  $m_s_out[$i],
                    'after_shift_in' =>  $a_s_in[$i],
                    'after_shift_out' =>  $a_s_out[$i],
                    'total' =>  $total[$i],
                    'per_hour_amount' => $p_h_amnt[$i],
                    'total_salary' => $net_total_salary[$i],
                    'company_id' => Session::get('company_id'),
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);


                DB::connection('mysql')->table('employee_accounts')->insert([
                    'attendence_id' =>  $main_id,
                    'added_date' => request('added_date'),
                    'em_id' =>  $employee_id[$i],
                    'cr_amount' =>  $net_total_salary[$i],
                    'ref_no' =>  $r_no,
                    'type' =>  'attendance',
                    'total_hour' =>  $total[$i],
                   
                    'company_id' => Session::get('company_id'),
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);


                DB::connection('mysql_second')->table('attendences')->insert([
                    'main_id' =>  $main_id,
                    'added_date' => request('added_date'),
                    'employee_id' =>  $employee_id[$i],
                    'moring_shift_in' =>  $m_s_in[$i],
                    'moring_shift_out' =>  $m_s_out[$i],
                    'after_shift_in' =>  $a_s_in[$i],
                    'after_shift_out' =>  $a_s_out[$i],
                    'total' =>  $total[$i],
                    'per_hour_amount' => $p_h_amnt[$i],
                    'total_salary' => $net_total_salary[$i],
                    'company_id' => Session::get('company_id'),
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);

                DB::connection('mysql_second')->table('employee_accounts')->insert([
                    'attendence_id' =>  $main_id,
                    'added_date' => request('added_date'),
                    'em_id' =>  $employee_id[$i],
                    'cr_amount' =>  $net_total_salary[$i],
                    'ref_no' =>  $r_no,
                    'type' =>  'attendance',
                    'total_hour' =>  $total[$i],
                   
                    'company_id' => Session::get('company_id'),
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            });
        }
       return redirect(route('attencence_list'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $atndncmns = atndncmn::find($id);

        // $atndncmns->delete_status = 1;
		// $atndncmns->save();


        // DB::table('attendences')
        // ->where('main_id', $id)
        // ->update(['delete_status' => 1]);

        // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('attendence_mains')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('attendence_mains')->where('id', $id)
        ->update([
            'delete_status' => 1,
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('attendence_mains')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('attendence_mains')->where('id', $id)
        ->update([
            'delete_status' => 1,
            'updated_at' => DB::raw('NOW()'),
        ]);



          // Find the record to update in database1
    $record3 = DB::connection('mysql')->table('attendences')->where('main_id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('attendences')->where('main_id', $id)
        ->update([
            'delete_status' => 1,
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record4 = DB::connection('mysql_second')->table('attendences')->where('main_id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('attendences')->where('main_id', $id)
        ->update([
            'delete_status' => 1,
            'updated_at' => DB::raw('NOW()'),
        ]);



		return redirect(route('attencence_list'));
    }
    public function get_employee_details(Request $request){
        $em_id = $request->em_id;
        $per_hour_amount = DB::table('employees')
        ->where('id', $em_id)
        ->value('per_hour_amount');

        return response()->json(['per_hour_amount' =>$per_hour_amount]);
    }
}
