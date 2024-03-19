<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee AS emply ;
use App\Models\Attendence AS atndnc ;
use App\Models\Employeepayment AS e_payment;
use App\Models\AttendenceMain AS atndncmn ;
use App\Models\Account AS acnt ;
use App\Models\AccountTransaction AS acntrn ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Employeepayment extends Controller
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
        $p_lists =  DB::table('employeepayments')
        ->select('employeepayments.*','employees.e_name')
        ->join('employees', 'employees.id', '=', 'employeepayments.employee_id')
        ->where("employeepayments.delete_status", "=", 0)
        ->where("employeepayments.company_id", "=", Session::get('company_id'))
        ->get();

        $data = ['p_lists'=> $p_lists];
        return view('admin.daily_wages.payment.index',$data)->with('no', 1);
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ey_lists = emply::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();

        $data_e_payment =  DB::table('employeepayments')
        ->select('employeepayments.id')
        ->where("employeepayments.company_id", "=", Session::get('company_id'))
        ->get();
    

         if(empty($data_e_payment)){
            $num = 0;
         }
         else{
            $num = DB::table('employeepayments')
                ->where('company_id', '=', Session::get('company_id'))
                ->count();
         }
         $rf_n = $num + 1;
         $ref_no = str_pad($rf_n, 4, '0', STR_PAD_LEFT);
         $r_no = "EPT-".$ref_no;

        $data = ['ey_lists'=> $ey_lists,'r_no' => $r_no];
        return view('admin.daily_wages.payment.create',$data)->with('no', 1);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);

        $data_ref =  DB::table('employee_accounts')
        ->where('company_id', '=', Session::get('company_id'))
        ->where("employee_accounts.type", "=", "payment")
        ->get();
        
        if(empty($data_ref)){
            $num = 0;
         }
         else{
            $num = DB::table('employee_accounts')
                ->where('company_id', '=', Session::get('company_id'))
                ->where("employee_accounts.type", "=", "payment")
                ->count();
         }
         $refe_a= $num + 1;
         $refe_a = str_pad($refe_a, 4, '0', STR_PAD_LEFT);
         $r_no = "PT".$refe_a;


      
            
     

            $acnts = new acnt();

            $data_acnts =  DB::table('accounts')
             ->select('accounts.id')
             ->where("accounts.company_id", "=", Session::get('company_id'))
             ->get();
         
     
              if(empty($data_acnts)){
                 $num = 0;
              }
              else{
                 $num = DB::table('accounts')
                     ->where('company_id', '=', Session::get('company_id'))
                     ->count();
              }
              $rf_n = $num + 1;
              $ref_no = str_pad($rf_n, 4, '0', STR_PAD_LEFT);
              $t_no = "TN-".$ref_no;


              $e_name = DB::table('employees')
              ->where('id', request('employee_id'))
              ->where('delete_status', 0)
              ->where('company_id', Session::get('company_id'))
              ->value('e_name');

              $cash_account_ledger_id = DB::table('account_ledgers')
              ->where('ledger', 'Cash Account')
              ->where('delete_status', 0)
 
              ->value('id');

              $dailywages_ledger_id = DB::table('account_ledgers')
              ->where('ledger', 'Daily Wages')
              ->where('delete_status', 0)
       
              ->value('id');
     
              $account_id = DB::connection('mysql')->table('accounts')->insertGetId([
               't_date' =>  request('date'),
               't_no' =>  $t_no,
               'type' =>  'payment',
               'currency_id' =>  1,
               'amount' =>  request('amount'),
               'narration' =>  $e_name,
               'created_by' =>  Auth::user()->id,
               'company_id' => Session::get('company_id'),
               'created_at' => DB::raw('NOW()'),
               'updated_at' => DB::raw('NOW()'),
           ]);
           DB::connection('mysql_second')->table('accounts')->insert([
                't_date' =>  request('date'),
                't_no' =>  $t_no,
                'type' =>  'payment',
                'currency_id' =>  1,
                'amount' =>  request('amount'),
                'narration' =>  $e_name,
                'created_by' =>  Auth::user()->id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
            

            $insert_id = DB::connection('mysql')->table('employeepayments')->insertGetId([
                'date' =>  request('date'),
                'ref_no' =>  request('ref_no'),
                'employee_id' =>  request('employee_id'),
                'amount' =>  request('amount'),
                'account_id' => $account_id,
                'created_by' =>  Auth::user()->id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);

            DB::connection('mysql')->table('employee_accounts')->insert([
                'payment_id' =>  $insert_id,
                'account_id' => $account_id,
                'added_date' => request('date'),
                'em_id' =>  request('employee_id'),
                'dr_amount' =>  request('amount'),
                'ref_no' =>  request('ref_no'),
                'type' =>  'payment',
                'created_by' =>  Auth::user()->id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);

        
            DB::connection('mysql_second')->table('employeepayments')->insert([
                'date' =>  request('date'),
                'ref_no' =>  request('ref_no'),
                'employee_id' =>  request('employee_id'),
                'amount' =>  request('amount'),
                'account_id' => $account_id,
                'created_by' =>  Auth::user()->id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);

            DB::connection('mysql_second')->table('employee_accounts')->insert([
                'payment_id' =>  $insert_id,
                'account_id' => $account_id,
                'added_date' => request('date'),
                'em_id' =>  request('employee_id'),
                'dr_amount' =>  request('amount'),
                'ref_no' =>  request('ref_no'),
                'type' =>  'payment',
                'created_by' =>  Auth::user()->id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
     
             DB::transaction(function () use ($account_id,$e_name,$cash_account_ledger_id,$dailywages_ledger_id) {
               DB::connection('mysql')->table('account_transactions')->insert([
                 'added_date' =>  request('date'),
                 'account_id' => $account_id,
                 'ledger_id' =>  $cash_account_ledger_id,
                 'type' =>  'cr',
                 'currency_id' =>1,
                 'amount' =>  request('amount'),
                 'narration' =>  $e_name,
                 'company_id' => Session::get('company_id'),
                 'created_at' => DB::raw('NOW()'),
                 'updated_at' => DB::raw('NOW()'),
              ]);
      
              DB::connection('mysql')->table('account_transactions')->insert([
                  'added_date' =>  request('date'),
                  'account_id' => $account_id,
                  'ledger_id' =>  $dailywages_ledger_id,
                  'type' =>  'dr',
                  'currency_id' =>1,
                  'amount' =>  request('amount'),
                  'narration' =>  $e_name,
                  'company_id' => Session::get('company_id'),
                  'created_at' => DB::raw('NOW()'),
                  'updated_at' => DB::raw('NOW()'),
              ]);
      
              DB::connection('mysql_second')->table('account_transactions')->insert([
                'added_date' =>  request('date'),
                 'account_id' => $account_id,
                 'ledger_id' =>  $cash_account_ledger_id,
                 'type' =>  'cr',
                 'currency_id' =>1,
                 'amount' =>  request('amount'),
                 'narration' =>  $e_name,
                 'company_id' => Session::get('company_id'),
                 'created_at' => DB::raw('NOW()'),
                 'updated_at' => DB::raw('NOW()'),
              ]);
      
              DB::connection('mysql_second')->table('account_transactions')->insert([
                'added_date' =>  request('date'),
                'account_id' => $account_id,
                'ledger_id' =>  $dailywages_ledger_id,
                'type' =>  'dr',
                'currency_id' =>1,
                'amount' =>  request('amount'),
                'narration' =>  $e_name,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
              ]);
            });   

        return redirect(route('employee_payment_list'));
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
    public function edit(e_payment $id)
    {
        $result = $id;
        $ey_lists = emply::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();

        return view('admin.daily_wages.payment.edit',compact('result','ey_lists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);

       // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('employeepayments')->where('id', $id)->first();
    $account_id = $record1->account_id;


    $e_name = DB::table('employees')
    ->where('id',$record1->employee_id)
    ->where('delete_status', 0)
    ->where('company_id', Session::get('company_id'))
    ->value('e_name');

    $cash_account_ledger_id = DB::table('account_ledgers')
    ->where('ledger', 'Cash Account')
    ->where('delete_status', 0)

    ->value('id');

    $dailywages_ledger_id = DB::table('account_ledgers')
    ->where('ledger', 'Daily Wages')
    ->where('delete_status', 0)

    ->value('id');


     // Delete record from table1 in db1
     \DB::connection('mysql')->table('account_transactions')->where('account_id', $account_id)->delete();

     // Delete record from table2 in db2
     \DB::connection('mysql_second')->table('account_transactions')->where('account_id', $account_id)->delete();


    // Update the record with the new data
    DB::connection('mysql')->table('employeepayments')->where('id', $id)
        ->update([
            'date' =>  request('date'),
            'ref_no' =>  request('ref_no'),
            'employee_id' =>  request('employee_id'),
            'amount' =>  request('amount'),
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);

        DB::connection('mysql')->table('employee_accounts')->where('payment_id', $id)
        ->update([
            'added_date' => request('date'),
            'em_id' =>  request('employee_id'),
            'dr_amount' =>  request('amount'),
            'ref_no' =>  request('ref_no'),
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);


        DB::connection('mysql')->table('accounts')->where('id', $account_id)
        ->update([
            't_date' =>  request('date'),
            'amount' =>  request('amount'),
            'updated_at' => DB::raw('NOW()'),
        ]);


       


    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('employeepayments')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('employeepayments')->where('id', $id)
        ->update([
            'date' =>  request('date'),
            'ref_no' =>  request('ref_no'),
            'employee_id' =>  request('employee_id'),
            'amount' =>  request('amount'),
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);
        DB::connection('mysql_second')->table('employee_accounts')->where('payment_id', $id)
        ->update([
            'added_date' => request('date'),
            'em_id' =>  request('employee_id'),
            'dr_amount' =>  request('amount'),
            'ref_no' =>  request('ref_no'),
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);
        DB::connection('mysql_second')->table('accounts')->where('id', $account_id)
        ->update([
            't_date' =>  request('date'),
            'amount' =>  request('amount'),
            'updated_at' => DB::raw('NOW()'),
        ]);




        DB::transaction(function () use ($account_id,$e_name,$cash_account_ledger_id,$dailywages_ledger_id) {
            DB::connection('mysql')->table('account_transactions')->insert([
              'added_date' =>  request('date'),
              'account_id' => $account_id,
              'ledger_id' =>  $cash_account_ledger_id,
              'type' =>  'cr',
              'currency_id' =>1,
              'amount' =>  request('amount'),
              'narration' =>  $e_name,
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql')->table('account_transactions')->insert([
               'added_date' =>  request('date'),
               'account_id' => $account_id,
               'ledger_id' =>  $dailywages_ledger_id,
               'type' =>  'dr',
               'currency_id' =>1,
               'amount' =>  request('amount'),
               'narration' =>  $e_name,
               'company_id' => Session::get('company_id'),
               'created_at' => DB::raw('NOW()'),
               'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql_second')->table('account_transactions')->insert([
             'added_date' =>  request('date'),
              'account_id' => $account_id,
              'ledger_id' =>  $cash_account_ledger_id,
              'type' =>  'cr',
              'currency_id' =>1,
              'amount' =>  request('amount'),
              'narration' =>  $e_name,
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql_second')->table('account_transactions')->insert([
             'added_date' =>  request('date'),
             'account_id' => $account_id,
             'ledger_id' =>  $dailywages_ledger_id,
             'type' =>  'dr',
             'currency_id' =>1,
             'amount' =>  request('amount'),
             'narration' =>  $e_name,
             'company_id' => Session::get('company_id'),
             'created_at' => DB::raw('NOW()'),
             'updated_at' => DB::raw('NOW()'),
           ]);
         });  

        return redirect(route('employee_payment_list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record1 = DB::connection('mysql')->table('employeepayments')->where('id', $id)->first();

        // Update the record with the new data
        DB::connection('mysql')->table('employeepayments')->where('id', $id)
            ->update([
                'delete_status' => 1,
                'updated_at' => DB::raw('NOW()'),
            ]);
    
        // Find the record to update in database2
        $record2 = DB::connection('mysql_second')->table('employeepayments')->where('id', $id)->first();
    
        // Update the record with the new data
        DB::connection('mysql_second')->table('employeepayments')->where('id', $id)
            ->update([
                'delete_status' => 1,
                'updated_at' => DB::raw('NOW()'),
            ]);




            $record3 = DB::connection('mysql')->table('employee_accounts')->where('payment_id', $id)->first();

            // Update the record with the new data
            DB::connection('mysql')->table('employee_accounts')->where('id', $id)
                ->update([
                    'delete_status' => 1,
                    'updated_at' => DB::raw('NOW()'),
                ]);
        
            // Find the record to update in database2
            $record4 = DB::connection('mysql_second')->table('employee_accounts')->where('payment_id', $id)->first();
        
            // Update the record with the new data
            DB::connection('mysql_second')->table('employee_accounts')->where('id', $id)
                ->update([
                    'delete_status' => 1,
                    'updated_at' => DB::raw('NOW()'),
                ]);


    
            return redirect(route('employee_payment_list'));
    }
    public function get_employee_balance(Request $request){
        $employee_id = $request->employee_id;

        $cr_amount_total = DB::table('employee_accounts')
            ->where('em_id', $employee_id)
            ->where('delete_status', 0)
            ->where('company_id', Session::get('company_id'))
            ->sum('cr_amount');
        

        $dr_amount_total = DB::table('employee_accounts')
            ->where('em_id', $employee_id)
            ->where('delete_status', 0)
            ->where('company_id', Session::get('company_id'))
            ->sum('dr_amount');

            $balance = $cr_amount_total - $dr_amount_total;

            return response()->json(['balance' =>$balance]);
    }
}
