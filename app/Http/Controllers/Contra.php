<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contra AS cnta ;
use App\Models\AccountLedger AS agl ;
use App\Models\Currency AS crny ;
use App\Models\Account AS acnt ;
use App\Models\AccountTransaction AS acntrn ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Contra extends Controller
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
		return view('admin.accounts.contra.index'); 
    }
    public function get_contra_list(){
      $draw = request()->input('draw');
      $start = request()->input('start');
      $length = request()->input('length');
  
  
  
      $result = DB::table('contras')
      ->select('contras.*','from_ledger.ledger as from_ledger_name','to_ledger.ledger as to_ledger_name','currencies.code')
      ->join('account_ledgers as from_ledger', 'contras.from_ledger_id', '=', 'from_ledger.id')
      ->join('account_ledgers as to_ledger', 'contras.to_ledger_id', '=', 'to_ledger.id')
      ->join('currencies','contras.currency_id','=','currencies.id')
      ->where("contras.delete_status", "=", 0)
      ->where("contras.approved_or_not", "=", "yes")
      ->where("contras.company_id", "=", Session::get('company_id'))
      ->get();
      
  $data = [];
  $slno = 1;
          
          
          
  foreach ($result as $r) {
    
  
      $editButton = '<a href="' . route('contra_edit',$r->id ) . '"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
      <path
          opacity="0.5"
          d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
          stroke="currentColor"
          stroke-width="1.5"
          stroke-linecap="round"
      ></path>
      <path
          d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
          stroke="currentColor"
          stroke-width="1.5"
      ></path>
      <path
          opacity="0.5"
          d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
          stroke="currentColor"
          stroke-width="1.5"
      ></path>
  </svg></a>';

  $viewButton = '<a href="' . route('contra_view',$r->id ) . '">  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
  <path
      opacity="0.5"
      d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
      stroke="currentColor"
      stroke-width="1.5"
  ></path>
  <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="1.5"></path>
  </svg></a>';
  $deleteButton = '<a href="#" class="delete" id="' . $r->id . '" >
  <button class="hover:text-danger"  onClick="return confirm(\'Are you sure?\');" type="submit">
  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
  <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
  <path
      d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
  ></path>
  <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
  <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
  <path
      opacity="0.5"
      d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
      stroke="currentColor"
      stroke-width="1.5"
  ></path>
</svg>
  </button>
</a>';

  
  
  $btns = '<form method="post" action="'. route('contra_delete', $r->account_id) .'">'. csrf_field() . method_field('DELETE') .'<div class="flex gap-4 items-center">'.$editButton.$viewButton.$deleteButton.'</div></form>';

 $date = \Carbon\Carbon::parse($r->added_date)->format('d-m-Y') ;
 $ref_no ='<a style="color:#1212c1;" href="'. route('contra_view', $r->id) .'">'.$r->reference_no.'</a>';
      $data[] = array(
          $slno,
          $date,
          $ref_no,
          $r->from_ledger_name,
          $r->to_ledger_name,
          $r->amount,
          $r->narration,
          $btns// Add buttons to the row
      );
      $slno++;
  }
  
  
      $result = array(
          "draw" => $draw,
          "recordsTotal" => $result->count(),
          "recordsFiltered" => $result->count(),
          "data" => $data
      );
  
      echo json_encode($result);
      exit();
  }
 
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $lg_lists_b_c =  DB::table('account_ledgers')
        ->select('account_ledgers.id','account_ledgers.ledger')
        ->where("account_ledgers.account_group_name", "=", "Bank")
        ->OrWhere("account_ledgers.account_group_name", "=", "Cash")
        ->get();

        $currency_lists = crny::all();
        $a_l_data = agl::where('ledger', 'Cash Account')->first();
        $ledger_id_of_cash_account = $a_l_data->id;

        

           foreach($currency_lists as $c_list){
            $crsum = 0;
            $drsum = 0;
            $balance = 0;

            $query_c_a = DB::table('account_transactions')
            ->where("company_id", "=", Session::get('company_id'))
            ->where("ledger_id", "=", $ledger_id_of_cash_account)
            ->where("currency_id", "=", $c_list->id)
            ->where("delete_status", "=", 0)
            ->get();

              if(empty($query_c_a)){
                $balance = 0;
              }
              else{
                foreach($query_c_a as $qca){
                    $type = $qca->type;
                    $amount = $qca->amount;
                     if($type == 'cr'){
                        $crsum = $crsum + $amount;
                     }
                     else{
                        $drsum = $drsum + $amount;
                     }
                     if($crsum > $drsum){
                        $bc = $crsum - $drsum;
                        $balance = $bc.' CR';
                     }
                     else{
                        $bc = $drsum - $crsum;
                        $balance = $bc.' DR';
                     }
                }
              }
              $c_balance[] = array($c_list->code,$balance);	
           }


        $data_contra =  DB::table('contras')
        ->select('contras.id')
        ->where("contras.company_id", "=", Session::get('company_id'))
        ->get();
    

         if(empty($data_contra)){
            $num = 0;
         }
         else{
            $num = DB::table('contras')
                ->where('company_id', '=', Session::get('company_id'))
                ->count();
         }
         $rf_n = $num + 1;
         $ref_no = str_pad($rf_n, 4, '0', STR_PAD_LEFT);
         $r_no = "CA-".$ref_no;


        $data = ['lg_lists_b_c'=> $lg_lists_b_c,'currency_lists' => $currency_lists,'r_no' => $r_no,'c_balance' => $c_balance];
        return view('admin.accounts.contra.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
          'amount' => 'required|max:120',
          'dr_ledger_id' => 'required',
          'cr_ledger_id' => 'required',
          't_date' => 'required',
          'fitting_or_packing' => 'required',
    ], [
        'amount.required' => 'The Amount field is required.',
        'dr_ledger_id.required' => 'The Dr Ledger field is required.',
        'cr_ledger_id.required' => 'The Cr Ledger field is required.',
        't_date.required' => 'The Type Date is required.',
        'fitting_or_packing.required' => 'The Fitting Or Packing field is required.',
    ]);
       
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

         

         $account_id = DB::connection('mysql')->table('accounts')->insertGetId([
            't_date' =>  request('t_date'),
            't_no' =>  $t_no,
            'type' =>  'contra',
            'currency_id' =>  request('currency_id'),
            'amount' =>  request('amount'),
            'narration' =>  request('narration'),
            'created_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);
        DB::connection('mysql_second')->table('accounts')->insert([
            't_date' =>  request('t_date'),
            't_no' =>  $t_no,
            'type' =>  'contra',
            'currency_id' =>  request('currency_id'),
            'amount' =>  request('amount'),
            'narration' =>  request('narration'),
            'created_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
         ]);
         
  
          DB::transaction(function () use ($account_id) {
            DB::connection('mysql')->table('account_transactions')->insert([
              'added_date' =>  request('t_date'),
              'account_id' => $account_id,
              'ledger_id' =>  request('cr_ledger_id'),
              'type' =>  'cr',
              'currency_id' =>request('currency_id'),
              'amount' =>  request('amount'),
              'narration' =>  request('narration'),
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql')->table('account_transactions')->insert([
               'added_date' =>  request('t_date'),
               'account_id' => $account_id,
               'ledger_id' =>  request('dr_ledger_id'),
               'type' =>  'dr',
               'currency_id' =>request('currency_id'),
               'amount' =>  request('amount'),
               'narration' =>  request('narration'),
               'company_id' => Session::get('company_id'),
               'created_at' => DB::raw('NOW()'),
               'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql_second')->table('account_transactions')->insert([
              'added_date' =>  request('t_date'),
              'account_id' => $account_id,
              'ledger_id' =>  request('cr_ledger_id'),
              'type' =>  'cr',
              'currency_id' =>request('currency_id'),
              'amount' =>  request('amount'),
              'narration' =>  request('narration'),
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql_second')->table('account_transactions')->insert([
              'added_date' =>  request('t_date'),
              'account_id' => $account_id,
              'ledger_id' =>  request('dr_ledger_id'),
              'type' =>  'dr',
              'currency_id' =>request('currency_id'),
              'amount' =>  request('amount'),
              'narration' =>  request('narration'),
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
           ]);
            DB::connection('mysql')->table('contras')->insert([
               'reference_no' =>  request('reference_no'),
               'fitting_or_packing' => request('fitting_or_packing'),
               'account_id' => $account_id,
               'from_ledger_id' =>request('cr_ledger_id'),
               'to_ledger_id' =>  request('dr_ledger_id'),
               'amount' =>  request('amount'),
               'currency_id' =>  request('currency_id'),
               'narration' =>  request('narration'),
               'added_date' =>  request('t_date'),
               'created_by' =>  Auth::user()->id,
               'company_id' => Session::get('company_id'),
               'created_at' => DB::raw('NOW()'),
               'updated_at' => DB::raw('NOW()'),
            ]);
    
            DB::connection('mysql_second')->table('contras')->insert([
              'reference_no' =>  request('reference_no'),
              'fitting_or_packing' => request('fitting_or_packing'),
              'account_id' => $account_id,
              'from_ledger_id' =>request('cr_ledger_id'),
              'to_ledger_id' =>  request('dr_ledger_id'),
              'amount' =>  request('amount'),
              'currency_id' =>  request('currency_id'),
              'narration' =>  request('narration'),
              'added_date' =>  request('t_date'),
              'created_by' =>  Auth::user()->id,
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
            ]);
    
    
        });

        return redirect(route('contra_list'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result =  DB::table('contras')
      ->select('contras.*','accounts.t_no','accounts.t_date','accounts.narration')
      ->join('accounts','contras.account_id','=','accounts.id')
      ->where("contras.id", "=", $id)
      ->first();

      $account_id = DB::table('contras')
      ->where('id', $id)
      ->value('account_id');

      $t_details = DB::table('account_transactions')
      ->select('account_transactions.*','account_ledgers.ledger')
      ->join('account_ledgers','account_transactions.ledger_id','=','account_ledgers.id')
      ->where("account_transactions.account_id", "=", $account_id)
      ->get();


      return view('admin.accounts.contra.view',compact('result','t_details'))->with('no', 1);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cnta $id)
    {

        $lg_lists_b_c =  DB::table('account_ledgers')
        ->select('account_ledgers.id','account_ledgers.ledger')
        ->where("account_ledgers.account_group_name", "=", "Bank")
        ->OrWhere("account_ledgers.account_group_name", "=", "Cash")
        ->get();

        $currency_lists = crny::all();
        $result = $id;
        $result_a =  DB::table('accounts')
        ->select('accounts.id','accounts.t_no','accounts.t_date','accounts.currency_id','accounts.amount','accounts.narration')
        ->where("accounts.id", "=", $result->account_id)
        ->first();
        
        $account_id = $result->account_id;

        $result_b =  DB::table('account_transactions')
        ->select('*')
        ->where("account_transactions.account_id", "=", $account_id)
        ->where("account_transactions.type", "=", 'cr')
        ->first();

        $result_c =  DB::table('account_transactions')
        ->select('*')
        ->where("account_transactions.account_id", "=", $account_id)
        ->where("account_transactions.type", "=", 'dr')
        ->first();

        $a_l_data = agl::where('ledger', 'Cash Account')->first();
        $ledger_id_of_cash_account = $a_l_data->id;

        

           foreach($currency_lists as $c_list){
            $crsum = 0;
            $drsum = 0;
            $balance = 0;

            $query_c_a = DB::table('account_transactions')
            ->where("company_id", "=", Session::get('company_id'))
            ->where("ledger_id", "=", $ledger_id_of_cash_account)
            ->where("currency_id", "=", $c_list->id)
            ->where("delete_status", "=", 0)
            ->get();

              if(empty($query_c_a)){
                $balance = 0;
              }
              else{
                foreach($query_c_a as $qca){
                    $type = $qca->type;
                    $amount = $qca->amount;
                     if($type == 'cr'){
                        $crsum = $crsum + $amount;
                     }
                     else{
                        $drsum = $drsum + $amount;
                     }
                     if($crsum > $drsum){
                        $bc = $crsum - $drsum;
                        $balance = $bc.' CR';
                     }
                     else{
                        $bc = $drsum - $crsum;
                        $balance = $bc.' DR';
                     }
                }
              }
              $c_balance[] = array($c_list->code,$balance);	
           }


        return view('admin.accounts.contra.edit',compact('result','lg_lists_b_c','currency_lists','result_a','result_b','result_c','c_balance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $validatedData = $request->validate([
        'amount' => 'required|max:120',
        'dr_ledger_id' => 'required',
        'cr_ledger_id' => 'required',
        't_date' => 'required',
        'fitting_or_packing' => 'required',
  ], [
      'amount.required' => 'The Amount field is required.',
      'dr_ledger_id.required' => 'The Dr Ledger field is required.',
      'cr_ledger_id.required' => 'The Cr Ledger field is required.',
      't_date.required' => 'The Type Date is required.',
      'fitting_or_packing.required' => 'The Fitting Or Packing field is required.',
  ]);

         // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('accounts')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('accounts')->where('id', $id)
        ->update([
            't_date' =>  request('t_date'),
            'currency_id' =>  request('currency_id'),
            'amount' =>  request('amount'),
            'narration' =>  request('narration'),
            'created_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('accounts')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('accounts')->where('id', $id)
        ->update([
         't_date' =>  request('t_date'),
         'currency_id' =>  request('currency_id'),
         'amount' =>  request('amount'),
         'narration' =>  request('narration'),
         'created_by' =>  Auth::user()->id,
         'company_id' => Session::get('company_id'),
         'updated_at' => DB::raw('NOW()'),
        ]);

        $account_id = $id;


        // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('contras')->where('account_id', $account_id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('contras')->where('account_id', $account_id)
        ->update([
          'fitting_or_packing' => request('fitting_or_packing'),
          'reference_no' =>  request('reference_no'),
          'account_id' => $account_id,
          'from_ledger_id' =>request('cr_ledger_id'),
          'to_ledger_id' =>  request('dr_ledger_id'),
          'amount' =>  request('amount'),
          'currency_id' =>  request('currency_id'),
          'narration' =>  request('narration'),
          'added_date' =>  request('t_date'),
         
          'edited_by' =>  Auth::user()->id,
          'company_id' => Session::get('company_id'),
          'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('contras')->where('account_id', $account_id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('contras')->where('account_id', $id)
        ->update([
          'reference_no' =>  request('reference_no'),
          'fitting_or_packing' => request('fitting_or_packing'),
          'account_id' => $account_id,
          'from_ledger_id' =>request('cr_ledger_id'),
          'to_ledger_id' =>  request('dr_ledger_id'),
          'amount' =>  request('amount'),
          'currency_id' =>  request('currency_id'),
          'narration' =>  request('narration'),
          'added_date' =>  request('t_date'),
         
          'edited_by' =>  Auth::user()->id,
          'company_id' => Session::get('company_id'),
          'updated_at' => DB::raw('NOW()'),
        ]);


         // Delete record from table1 in db1
       \DB::connection('mysql')->table('account_transactions')->where('account_id', $account_id)->delete();

       // Delete record from table2 in db2
       \DB::connection('mysql_second')->table('account_transactions')->where('account_id', $account_id)->delete();

          DB::transaction(function () use ($account_id) {
            DB::connection('mysql')->table('account_transactions')->insert([
              'added_date' =>  request('t_date'),
              'account_id' => $account_id,
              'ledger_id' =>  request('cr_ledger_id'),
              'type' =>  'cr',
              'currency_id' =>request('currency_id'),
              'amount' =>  request('amount'),
              'narration' =>  request('narration'),
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql')->table('account_transactions')->insert([
               'added_date' =>  request('t_date'),
               'account_id' => $account_id,
               'ledger_id' =>  request('dr_ledger_id'),
               'type' =>  'dr',
               'currency_id' =>request('currency_id'),
               'amount' =>  request('amount'),
               'narration' =>  request('narration'),
               'company_id' => Session::get('company_id'),
               'created_at' => DB::raw('NOW()'),
               'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql_second')->table('account_transactions')->insert([
              'added_date' =>  request('t_date'),
              'account_id' => $account_id,
              'ledger_id' =>  request('cr_ledger_id'),
              'type' =>  'cr',
              'currency_id' =>request('currency_id'),
              'amount' =>  request('amount'),
              'narration' =>  request('narration'),
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql_second')->table('account_transactions')->insert([
              'added_date' =>  request('t_date'),
              'account_id' => $account_id,
              'ledger_id' =>  request('dr_ledger_id'),
              'type' =>  'dr',
              'currency_id' =>request('currency_id'),
              'amount' =>  request('amount'),
              'narration' =>  request('narration'),
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
           ]);
        
    
    
        });

        return redirect(route('contra_list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('accounts')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('accounts')->where('id', $id)
        ->update([
            'delete_status' => 1,
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('accounts')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('accounts')->where('id', $id)
        ->update([
            'delete_status' => 1,
            'updated_at' => DB::raw('NOW()'),
        ]);
  // Find the record to update in database1
  $record3 = DB::connection('mysql')->table('account_transactions')->where('account_id', $id)->first();

  // Update the record with the new data
  DB::connection('mysql')->table('account_transactions')->where('account_id', $id)
      ->update([
          'delete_status' => 1,
          'updated_at' => DB::raw('NOW()'),
      ]);

  // Find the record to update in database2
  $record4 = DB::connection('mysql_second')->table('account_transactions')->where('account_id', $id)->first();

  // Update the record with the new data
  DB::connection('mysql_second')->table('account_transactions')->where('account_id', $id)
      ->update([
          'delete_status' => 1,
          'updated_at' => DB::raw('NOW()'),
      ]);

       // Find the record to update in database1
  $record5 = DB::connection('mysql')->table('contras')->where('account_id', $id)->first();

  // Update the record with the new data
  DB::connection('mysql')->table('contras')->where('account_id', $id)
      ->update([
          'delete_status' => 1,
          'deleted_by' =>  Auth::user()->id,
          'updated_at' => DB::raw('NOW()'),
      ]);

  // Find the record to update in database2
  $record6 = DB::connection('mysql_second')->table('contras')->where('account_id', $id)->first();

  // Update the record with the new data
  DB::connection('mysql_second')->table('contras')->where('account_id', $id)
      ->update([
          'delete_status' => 1,
          'deleted_by' =>  Auth::user()->id,
          'updated_at' => DB::raw('NOW()'),
      ]);

		return redirect(route('contra_list'));
    }
    public function contra_pending(){
		return view('admin.admin_approvel.contra_pending.index'); 
    } 
    public function get_contra_pending_list(){
      $draw = request()->input('draw');
      $start = request()->input('start');
      $length = request()->input('length');
  
  
  
      $result =  DB::table('contras')
      ->select('contras.*','from_ledger.ledger as from_ledger_name','to_ledger.ledger as to_ledger_name','currencies.code')
      ->join('account_ledgers as from_ledger', 'contras.from_ledger_id', '=', 'from_ledger.id')
      ->join('account_ledgers as to_ledger', 'contras.to_ledger_id', '=', 'to_ledger.id')
      ->join('currencies','contras.currency_id','=','currencies.id')
      ->where("contras.delete_status", "=", 0)
      ->where("contras.approved_or_not", "=", "no")
      ->where("contras.company_id", "=", Session::get('company_id'))
      ->get();
      
  $data = [];
  $slno = 1;
          
          
          
  foreach ($result as $r) {
    
  
      $editButton = '<a href="' . route('contra_pending_edit',$r->id ) . '"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
      <path
          opacity="0.5"
          d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
          stroke="currentColor"
          stroke-width="1.5"
          stroke-linecap="round"
      ></path>
      <path
          d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
          stroke="currentColor"
          stroke-width="1.5"
      ></path>
      <path
          opacity="0.5"
          d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
          stroke="currentColor"
          stroke-width="1.5"
      ></path>
  </svg></a>';

  $viewButton = '<a href="' . route('contra_pending_view',$r->id ) . '">  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
  <path
      opacity="0.5"
      d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
      stroke="currentColor"
      stroke-width="1.5"
  ></path>
  <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="1.5"></path>
  </svg></a>';
  $deleteButton = '<a href="#" class="delete" id="' . $r->id . '" >
  <button class="hover:text-danger"  onClick="return confirm(\'Are you sure?\');" type="submit">
  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
  <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
  <path
      d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
  ></path>
  <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
  <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
  <path
      opacity="0.5"
      d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
      stroke="currentColor"
      stroke-width="1.5"
  ></path>
</svg>
  </button>
</a>';

  
  
  $btns = '<form method="post" action="'. route('contra_pending_delete', $r->id) .'">'. csrf_field() . method_field('DELETE') .'<div class="flex gap-4 items-center">'.$editButton.$viewButton.$deleteButton.'</div></form>';

 $date = \Carbon\Carbon::parse($r->added_date)->format('d-m-Y') ;
 $ref_no ='<a style="color:#1212c1;" href="'. route('contra_pending_view', $r->id) .'">'.$r->reference_no.'</a>';
      $data[] = array(
          $slno,
          $date,
          $ref_no,
          $r->from_ledger_name,
          $r->to_ledger_name,
          $r->amount,
          $r->narration,
          $btns// Add buttons to the row
      );
      $slno++;
  }
  
  
      $result = array(
          "draw" => $draw,
          "recordsTotal" => $result->count(),
          "recordsFiltered" => $result->count(),
          "data" => $data
      );
  
      echo json_encode($result);
      exit();
    }
    public function contra_pending_view(string $id){
        $result =  DB::table('contras')
        ->select('contras.*','to_ledger.ledger as account_to','from_ledger.ledger as account_from')
        ->join('account_ledgers as to_ledger', 'contras.to_ledger_id', '=', 'to_ledger.id')
        ->join('account_ledgers as from_ledger', 'contras.from_ledger_id', '=', 'from_ledger.id')
        ->where("contras.id", "=", $id)
        ->first();
  
        
        return view('admin.admin_approvel.contra_pending.view',compact('result'))->with('no', 1);
    }
    public function contra_approve(string $id){
            $result = DB::connection('mysql')->table('contras')->where('id', $id)->first();
    
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
    
             $account_id = DB::connection('mysql')->table('accounts')->insertGetId([
              't_date' => $result->added_date,
              't_no' =>  $t_no,
              'type' =>  'contra',
              'currency_id' =>  $result->currency_id,
              'amount' =>  $result->amount,
              'narration' =>  $result->narration,
              'created_by' =>  Auth::user()->id,
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
          ]);
          DB::connection('mysql_second')->table('accounts')->insert([
            't_date' => $result->added_date,
            't_no' =>  $t_no,
            'type' =>  'contra',
            'currency_id' =>  $result->currency_id,
            'amount' =>  $result->amount,
            'narration' =>  $result->narration,
            'created_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
           ]);
           
    
            DB::transaction(function () use ($account_id,$result) {
              DB::connection('mysql')->table('account_transactions')->insert([
                'added_date' =>  $result->added_date,
                'account_id' => $account_id,
                'ledger_id' =>  $result->from_ledger_id,
                'type' =>  'cr',
                'currency_id' =>$result->currency_id,
                'amount' =>  $result->amount,
                'narration' =>  $result->narration,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
             ]);
     
             DB::connection('mysql')->table('account_transactions')->insert([
              'added_date' =>  $result->added_date,
              'account_id' => $account_id,
              'ledger_id' =>  $result->to_ledger_id,
              'type' =>  'dr',
              'currency_id' =>$result->currency_id,
              'amount' =>  $result->amount,
              'narration' =>  $result->narration,
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
             ]);
     
             DB::connection('mysql_second')->table('account_transactions')->insert([
              'added_date' =>  $result->added_date,
              'account_id' => $account_id,
              'ledger_id' =>  $result->from_ledger_id,
              'type' =>  'cr',
              'currency_id' =>$result->currency_id,
              'amount' =>  $result->amount,
              'narration' =>  $result->narration,
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
             ]);
     
             DB::connection('mysql_second')->table('account_transactions')->insert([
              'added_date' =>  $result->added_date,
              'account_id' => $account_id,
              'ledger_id' =>  $result->to_ledger_id,
              'type' =>  'dr',
              'currency_id' =>$result->currency_id,
              'amount' =>  $result->amount,
              'narration' =>  $result->narration,
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
             ]);
              
          });
    
          DB::connection('mysql')->table('contras')->where('id', $id)
          ->update([
            'account_id' => $account_id,
            'approved_or_not' =>  'yes',
            'edited_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
          ]);
          DB::connection('mysql_second')->table('contras')->where('id', $id)
          ->update([
            'account_id' => $account_id,
            'approved_or_not' =>  'yes',
            'edited_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
          ]);
    
    
            return redirect(route('contra_list'));
    
    
    
      }
    
    
      public function contra_pending_delete(string $id)
      {
      // Find the record to update in database2
    $record6 = DB::connection('mysql')->table('contras')->where('id', $id)->first();
    
    // Update the record with the new data
    DB::connection('mysql')->table('contras')->where('id', $id)
        ->update([
            'delete_status' => 1,
            'updated_at' => DB::raw('NOW()'),
        ]);
    
    // Find the record to update in database2
    $record6 = DB::connection('mysql_second')->table('contras')->where('id', $id)->first();
    
    // Update the record with the new data
    DB::connection('mysql_second')->table('contras')->where('id', $id)
        ->update([
            'delete_status' => 1,
            'updated_at' => DB::raw('NOW()'),
        ]);
    
    
    
    
      return redirect(route('contra_pending'));
      }
      public function contra_pending_edit(cnta $id)
    {

        $lg_lists_b_c =  DB::table('account_ledgers')
        ->select('account_ledgers.id','account_ledgers.ledger')
        ->where("account_ledgers.account_group_name", "=", "Bank")
        ->OrWhere("account_ledgers.account_group_name", "=", "Cash")
        ->get();

        $currency_lists = crny::all();
        $result = $id;

        $a_l_data = agl::where('ledger', 'Cash Account')->first();
        $ledger_id_of_cash_account = $a_l_data->id;

           foreach($currency_lists as $c_list){
            $crsum = 0;
            $drsum = 0;
            $balance = 0;

            $query_c_a = DB::table('account_transactions')
            ->where("company_id", "=", Session::get('company_id'))
            ->where("ledger_id", "=", $ledger_id_of_cash_account)
            ->where("currency_id", "=", $c_list->id)
            ->where("delete_status", "=", 0)
            ->get();

              if(empty($query_c_a)){
                $balance = 0;
              }
              else{
                foreach($query_c_a as $qca){
                    $type = $qca->type;
                    $amount = $qca->amount;
                     if($type == 'cr'){
                        $crsum = $crsum + $amount;
                     }
                     else{
                        $drsum = $drsum + $amount;
                     }
                     if($crsum > $drsum){
                        $bc = $crsum - $drsum;
                        $balance = $bc.' CR';
                     }
                     else{
                        $bc = $drsum - $crsum;
                        $balance = $bc.' DR';
                     }
                }
              }
              $c_balance[] = array($c_list->code,$balance);	
           }


        return view('admin.admin_approvel.contra_pending.edit',compact('result','lg_lists_b_c','currency_lists','c_balance'));
    }
    public function contra_pending_update(string $id){
        // Find the record to update in database1
        $record1 = DB::connection('mysql')->table('contras')->where('id', $id)->first();
   
        // Update the record with the new data
        DB::connection('mysql')->table('contras')->where('id', $id)
            ->update([
             'reference_no' =>  request('reference_no'),
             'fitting_or_packing' => request('fitting_or_packing'),
             'from_ledger_id' =>request('cr_ledger_id'),
             'to_ledger_id' =>  request('dr_ledger_id'),
             'amount' =>  request('amount'),
             'currency_id' =>  request('currency_id'),
             'narration' =>  request('narration'),
             'added_date' =>  request('t_date'),
             'company_id' => Session::get('company_id'),
             'updated_at' => DB::raw('NOW()'),
            ]);
    
        // Find the record to update in database2
        $record2 = DB::connection('mysql_second')->table('contras')->where('id', $id)->first();
    
        // Update the record with the new data
        DB::connection('mysql_second')->table('contras')->where('id', $id)
            ->update([
             'reference_no' =>  request('reference_no'),
             'fitting_or_packing' => request('fitting_or_packing'),
             'from_ledger_id' =>request('cr_ledger_id'),
             'to_ledger_id' =>  request('dr_ledger_id'),
             'amount' =>  request('amount'),
             'currency_id' =>  request('currency_id'),
             'narration' =>  request('narration'),
             'added_date' =>  request('t_date'),
             'company_id' => Session::get('company_id'),
             'updated_at' => DB::raw('NOW()'),
            ]);
   
            return redirect(route('contra_pending'));
     }
}
