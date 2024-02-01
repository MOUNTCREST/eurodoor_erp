<?php

namespace App\Http\Controllers\Fitting;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Journal AS jrnl ;
use App\Models\AccountLedger AS agl ;
use App\Models\Currency AS crny ;
use App\Models\Account AS acnt ;
use App\Models\AccountTransaction AS acntrn ;
use App\Models\BlackOrWhite AS bow ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Journal extends Controller
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
		return view('fitting.accounts.journal.index');
    }
public function get_journal_list_fitting(){
  $draw = request()->input('draw');
      $start = request()->input('start');
      $length = request()->input('length');
  
  
  
      $result =   DB::table('journals')
      ->select('journals.*','from_ledger.ledger as from_ledger_name','to_ledger.ledger as to_ledger_name','currencies.code')
      ->join('account_ledgers as from_ledger', 'journals.from_ledger_id', '=', 'from_ledger.id')
      ->join('account_ledgers as to_ledger', 'journals.to_ledger_id', '=', 'to_ledger.id')
      ->join('currencies','journals.currency_id','=','currencies.id')
      ->where("journals.delete_status", "=", 0)
      ->where("journals.approved_or_not", "=", "no")
      ->where("journals.company_id", "=", Session::get('company_id'))
      ->where("journals.department", "=",'Fitting')
      ->get();
      
  $data = [];
  $slno = 1;
          
          
          
  foreach ($result as $r) {
    
  
      $editButton = '<a href="' . route('journal_fitting_edit',$r->id ) . '"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
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

  
  
  $btns = '<form method="post" action="'. route('journal_fitting_delete', $r->id) .'">'. csrf_field() . method_field('DELETE') .'<div class="flex gap-4 items-center">'.$editButton.$deleteButton.'</div></form>';

 $date = \Carbon\Carbon::parse($r->added_date)->format('d-m-Y') ;
 $ref_no =$r->reference_no;
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
        $lg_lists =  DB::table('account_ledgers')
        ->select('account_ledgers.id','account_ledgers.ledger')
        ->where("account_ledgers.account_group_name", "!=", "Bank")
        ->where("account_ledgers.account_group_name", "!=", "Cash")
        ->where("account_ledgers.ledger", "!=", "LOCAL PURCHASE")
        ->where("account_ledgers.ledger", "!=", "LOCAL SALES")
        ->where("account_ledgers.ledger", "!=", "Opening Stock")
        ->where("account_ledgers.ledger", "!=", "CURRENCY CONVERTER")
        ->where("account_ledgers.delete_status", "=", 0)
        ->where("account_ledgers.company_id", "=", Session::get('company_id'))
        ->get();

        $currency_lists = crny::all();
        $a_l_data = agl::where('ledger', 'Cash Account')->first();
        $ledger_id_of_cash_packing = $a_l_data->id;

        

           foreach($currency_lists as $c_list){
            $crsum = 0;
            $drsum = 0;
            $balance = 0;

            $query_c_a = DB::table('account_transactions')
            ->where("company_id", "=", Session::get('company_id'))
            ->where("ledger_id", "=", $ledger_id_of_cash_packing)
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


        $data_pymnt =  DB::table('journals')
        ->select('journals.id')
        ->where("journals.company_id", "=", Session::get('company_id'))
        ->get();
    

         if(empty($data_pymnt)){
            $num = 0;
         }
         else{
            $num = DB::table('journals')
                ->where('company_id', '=', Session::get('company_id'))
                ->count();
         }
         $rf_n = $num + 1;
         $ref_no = str_pad($rf_n, 4, '0', STR_PAD_LEFT);
         $r_no = "JL-".$ref_no;


        $data = ['lg_lists'=> $lg_lists,'currency_lists' => $currency_lists,'r_no' => $r_no,'c_balance' => $c_balance];
        return view('fitting.accounts.journal.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validatedData = $request->validate([
        'amount' => 'required|max:120',
        'type' => 'required',
        'dr_ledger_id' => 'required',
        'cr_ledger_id' => 'required',
        'currency_id' => 'required',
        't_date' => 'required',
        'fitting_or_packing' => 'required',
  ], [
      'amount.required' => 'The Amount field is required.',
      'type.required' => 'The Type field is required.',
      'dr_ledger_id.required' => 'The Dr Ledger field is required.',
      'cr_ledger_id.required' => 'The Cr Ledger field is required.',
      'currency_id.required' => 'The Currency field is required.',
      't_date.required' => 'The Type Date is required.',
      'fitting_or_packing.required' => 'The Fitting Or Packing field is required.',
  ]);
       
  $validatedData = $request->validate([
    'amount' => 'required|max:120',
    'type' => 'required',
    'dr_ledger_id' => 'required',
    'cr_ledger_id' => 'required',
    'currency_id' => 'required',
    't_date' => 'required',
    'fitting_or_packing' => 'required',
], [
  'amount.required' => 'The Amount field is required.',
  'type.required' => 'The Type field is required.',
  'dr_ledger_id.required' => 'The Dr Ledger field is required.',
  'cr_ledger_id.required' => 'The Cr Ledger field is required.',
  'currency_id.required' => 'The Currency field is required.',
  't_date.required' => 'The Type Date is required.',
  'fitting_or_packing.required' => 'The Fitting Or Packing field is required.',
]);
   
if( request('type') == 'black'){
DB::connection('mysql')->table('journals')->insert([
  'reference_no' =>  request('reference_no'),
  'fitting_or_packing' => request('fitting_or_packing'),
  'account_id' => 0,
  'type' =>  request('type'),
  'from_ledger_id' =>request('cr_ledger_id'),
  'to_ledger_id' =>  request('dr_ledger_id'),
  'amount' =>  request('amount'),
  'currency_id' =>  request('currency_id'),
  'narration' =>  request('narration'),
  'department' => 'Fitting',
  'approved_or_not' => 'no',
  'added_date' =>  request('t_date'),
  'created_by' =>  Auth::user()->id,
  'company_id' => Session::get('company_id'),
  'created_at' => DB::raw('NOW()'),
  'updated_at' => DB::raw('NOW()'),
]);


}
else{
DB::connection('mysql')->table('journals')->insert([
  'reference_no' =>  request('reference_no'),
  'fitting_or_packing' => request('fitting_or_packing'),
  'account_id' => 0,
  'type' =>  request('type'),
  'from_ledger_id' =>request('cr_ledger_id'),
  'to_ledger_id' =>  request('dr_ledger_id'),
  'amount' =>  request('amount'),
  'currency_id' =>  request('currency_id'),
  'narration' =>  request('narration'),
  'department' => 'Fitting',
  'approved_or_not' => 'no',
  'added_date' =>  request('t_date'),
  'created_by' =>  Auth::user()->id,
  'company_id' => Session::get('company_id'),
  'created_at' => DB::raw('NOW()'),
  'updated_at' => DB::raw('NOW()'),
]);

DB::connection('mysql_second')->table('journals')->insert([
 'reference_no' =>  request('reference_no'),
 'fitting_or_packing' => request('fitting_or_packing'),
 'account_id' => 0,
 'from_ledger_id' =>request('cr_ledger_id'),
 'to_ledger_id' =>  request('dr_ledger_id'),
 'amount' =>  request('amount'),
 'currency_id' =>  request('currency_id'),
 'narration' =>  request('narration'),
 'department' => 'Fitting',
 'approved_or_not' => 'no',
 'added_date' =>  request('t_date'),
 'created_by' =>  Auth::user()->id,
 'company_id' => Session::get('company_id'),
 'created_at' => DB::raw('NOW()'),
 'updated_at' => DB::raw('NOW()'),
]);
}
  

        return redirect(route('journal_fitting_list'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $result =  DB::table('journals')
      ->select('journals.*','accounts.t_no','accounts.t_date','accounts.narration')
      ->join('accounts','journals.account_id','=','accounts.id')
      ->where("journals.id", "=", $id)
      ->first();

      $account_id = DB::table('journals')
      ->where('id', $id)
      ->value('account_id');

      $t_details = DB::table('account_transactions')
      ->select('account_transactions.*','account_ledgers.ledger')
      ->join('account_ledgers','account_transactions.ledger_id','=','account_ledgers.id')
      ->where("account_transactions.account_id", "=", $account_id)
      ->get();


      return view('fitting.accounts.journal.view',compact('result','t_details'))->with('no', 1);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(jrnl $id)
    {
        $lg_lists =  DB::table('account_ledgers')
        ->select('account_ledgers.id','account_ledgers.ledger')
        ->where("account_ledgers.account_group_name", "!=", "Bank")
        ->where("account_ledgers.account_group_name", "!=", "Cash")
        ->where("account_ledgers.ledger", "!=", "LOCAL PURCHASE")
        ->where("account_ledgers.ledger", "!=", "LOCAL SALES")
        ->where("account_ledgers.ledger", "!=", "Opening Stock")
        ->where("account_ledgers.ledger", "!=", "CURRENCY CONVERTER")
        ->where("account_ledgers.delete_status", "=", 0)
        ->where("account_ledgers.company_id", "=", Session::get('company_id'))
        ->get();

        $currency_lists = crny::all();
        $result = $id;
        

        return view('fitting.accounts.journal.edit',compact('result','lg_lists','currency_lists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $validatedData = $request->validate([
        'amount' => 'required|max:120',
        'type' => 'required',
        'dr_ledger_id' => 'required',
        'cr_ledger_id' => 'required',
        'currency_id' => 'required',
        't_date' => 'required',
        'fitting_or_packing' => 'required',
  ], [
      'amount.required' => 'The Amount field is required.',
      'type.required' => 'The Type field is required.',
      'dr_ledger_id.required' => 'The Dr Ledger field is required.',
      'cr_ledger_id.required' => 'The Cr Ledger field is required.',
      'currency_id.required' => 'The Currency field is required.',
      't_date.required' => 'The Type Date is required.',
      'fitting_or_packing.required' => 'The Fitting Or Packing field is required.',
  ]);
      
  if( request('type') == 'black'){
    // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('journals')->where('id', $id)->first();
 
    // Update the record with the new data
    DB::connection('mysql')->table('journals')->where('id', $id)
        ->update([
          'reference_no' =>  request('reference_no'),
          'fitting_or_packing' => request('fitting_or_packing'),
          'type' =>  request('type'),
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
 
   }
 else{
      // Find the record to update in database1
      $record1 = DB::connection('mysql')->table('journals')->where('id', $id)->first();
 
      // Update the record with the new data
      DB::connection('mysql')->table('journals')->where('id', $id)
          ->update([
            'reference_no' =>  request('reference_no'),
            'fitting_or_packing' => request('fitting_or_packing'),
            'from_ledger_id' =>request('cr_ledger_id'),
            'to_ledger_id' =>  request('dr_ledger_id'),
            'amount' =>  request('amount'),
            'currency_id' =>  request('currency_id'),
            'type' =>  request('type'),
            'narration' =>  request('narration'),
            'added_date' =>  request('t_date'),
            'edited_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
          ]);
  
      // Find the record to update in database2
      $record2 = DB::connection('mysql_second')->table('journals')->where('id', $id)->first();
  
      // Update the record with the new data
      DB::connection('mysql_second')->table('journals')->where('id', $id)
          ->update([
            'reference_no' =>  request('reference_no'),
            'fitting_or_packing' => request('fitting_or_packing'),
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
 }

        return redirect(route('journal_fitting_list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
       // Find the record to update in database1
  $record5 = DB::connection('mysql')->table('journals')->where('id', $id)->first();

  // Update the record with the new data
  DB::connection('mysql')->table('journals')->where('id', $id)
      ->update([
          'delete_status' => 1,
          'deleted_by' =>  Auth::user()->id,
          'updated_at' => DB::raw('NOW()'),
      ]);

  // Find the record to update in database2
  $record6 = DB::connection('mysql_second')->table('journals')->where('id', $id)->first();

  // Update the record with the new data
  DB::connection('mysql_second')->table('journals')->where('id', $id)
      ->update([
          'delete_status' => 1,
          'deleted_by' =>  Auth::user()->id,
          'updated_at' => DB::raw('NOW()'),
      ]);



		return redirect(route('journal_fitting_list'));
    }
    public function journal_pending(){
      $journal_lists =  DB::table('journals')
        ->select('journals.*','from_ledger.ledger as from_ledger_name','to_ledger.ledger as to_ledger_name','currencies.code')
        ->join('account_ledgers as from_ledger', 'journals.from_ledger_id', '=', 'from_ledger.id')
        ->join('account_ledgers as to_ledger', 'journals.to_ledger_id', '=', 'to_ledger.id')
        ->join('currencies','journals.currency_id','=','currencies.id')
        ->where("journals.delete_status", "=", 0)
        ->where("journals.approved_or_not", "=", "no")
        ->where("journals.company_id", "=", Session::get('company_id'))
        ->get();
		
		$data = ['journal_lists'=> $journal_lists];
		return view('admin_approvel.journal_pending.index',$data)->with('no', 1);
    }
    public function journal_pending_view(string $id){
      $result =  DB::table('journals')
      ->select('journals.*','to_ledger.ledger as account_to','from_ledger.ledger as account_from')
      ->join('account_ledgers as to_ledger', 'journals.to_ledger_id', '=', 'to_ledger.id')
      ->join('account_ledgers as from_ledger', 'journals.from_ledger_id', '=', 'from_ledger.id')
      ->where("journals.id", "=", $id)
      ->first();

      
      return view('admin_approvel.journal_pending.view',compact('result'))->with('no', 1);
  }
  public function journal_approve(string $id){
    // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('journals')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('journals')->where('id', $id)
        ->update([
          'approved_or_not' =>  'yes',
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('journals')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('journals')->where('id', $id)
        ->update([
          'approved_or_not' =>  'yes',
        ]);



        $result = DB::connection('mysql')->table('journals')->where('id', $id)->first();


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
          'type' =>  'journal',
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
        'type' =>  'payment',
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

        if(request('type') == 'black'){
          $bowb = new bow();
          $bowb->ledger_id = $result->to_ledger_id;
          $bowb->black_amount = $result->amount;
          $bowb->type = 'dr';
          $bowb->account_id = $account_id;
          $bowb->added_date = $result->added_date;
          $bowb->company_id = Session::get('company_id');
          $bowb->save();

          $boww = new bow();
          $boww->ledger_id = $result->from_ledger_id;
          $boww->black_amount = $result->amount;
          $boww->type = 'cr';
          $boww->account_id = $account_id;
          $boww->added_date = $result->added_date;
          $boww->company_id = Session::get('company_id');
          $boww->save();

        }
        else{

          DB::transaction(function () use ($account_id,$result) {
            DB::connection('mysql')->table('black_or_whites')->insert([
               'ledger_id' =>  $result->to_ledger_id,
               'white_amount' =>$result->amount,
               'type' =>  'dr',
               'account_id' => $account_id,
               'added_date' =>$result->added_date,
               'company_id' => Session::get('company_id'),
               'created_at' => DB::raw('NOW()'),
               'updated_at' => DB::raw('NOW()'),
            ]);
    
            DB::connection('mysql')->table('black_or_whites')->insert([
              'ledger_id' =>  $result->from_ledger_id,
              'white_amount' =>$result->amount,
              'type' =>  'cr',
              'account_id' => $account_id,
              'added_date' =>$result->added_date,
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
            ]);
    
            DB::connection('mysql_second')->table('black_or_whites')->insert([
              'ledger_id' =>  $result->to_ledger_id,
               'white_amount' =>$result->amount,
               'type' =>  'dr',
               'account_id' => $account_id,
               'added_date' =>$result->added_date,
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
            ]);
    
            DB::connection('mysql_second')->table('black_or_whites')->insert([
              'ledger_id' =>  $result->from_ledger_id,
              'white_amount' =>$result->amount,
              'type' =>  'cr',
              'account_id' => $account_id,
              'added_date' =>$result->added_date,
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
            ]);
    
          
    
        });

        }

        return redirect(route('journal_packing_list'));
  }
  public function journal_pending_delete(string $id)
  {
  // Find the record to update in database2
$record6 = DB::connection('mysql')->table('journals')->where('id', $id)->first();

// Update the record with the new data
DB::connection('mysql')->table('journals')->where('id', $id)
    ->update([
        'delete_status' => 1,
        'updated_at' => DB::raw('NOW()'),
    ]);

// Find the record to update in database2
$record6 = DB::connection('mysql_second')->table('journals')->where('id', $id)->first();

// Update the record with the new data
DB::connection('mysql_second')->table('journals')->where('id', $id)
    ->update([
        'delete_status' => 1,
        'updated_at' => DB::raw('NOW()'),
    ]);




  return redirect(route('journal_packing_pending'));
  }

  public function journal_pending_edit(jrnl $id)
  {
      $lg_lists =  DB::table('account_ledgers')
      ->select('account_ledgers.id','account_ledgers.ledger')
      ->where("account_ledgers.account_group_name", "!=", "Bank")
      ->where("account_ledgers.account_group_name", "!=", "Cash")
      ->where("account_ledgers.ledger", "!=", "LOCAL PURCHASE")
      ->where("account_ledgers.ledger", "!=", "LOCAL SALES")
      ->where("account_ledgers.ledger", "!=", "Opening Stock")
      ->where("account_ledgers.ledger", "!=", "CURRENCY CONVERTER")
      ->where("account_ledgers.delete_status", "=", 0)
      ->where("account_ledgers.company_id", "=", Session::get('company_id'))
      ->get();

      $currency_lists = crny::all();
      $result = $id;
    
      $a_l_data = agl::where('ledger', 'Cash Account')->first();
      $ledger_id_of_cash_packing = $a_l_data->id;

      
         foreach($currency_lists as $c_list){
          $crsum = 0;
          $drsum = 0;
          $balance = 0;

          $query_c_a = DB::table('account_transactions')
          ->where("company_id", "=", Session::get('company_id'))
          ->where("ledger_id", "=", $ledger_id_of_cash_packing)
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


      return view('admin_approvel.journal_pending.edit',compact('result','lg_lists','currency_lists','c_balance'));
  }
  public function journal_pending_update(string $id){
    // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('journals')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('journals')->where('id', $id)
        ->update([
         'reference_no' =>  request('reference_no'),
         'fitting_or_packing' => request('fitting_or_packing'),
         'type' =>  request('type'),
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
    $record2 = DB::connection('mysql_second')->table('journals')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('journals')->where('id', $id)
        ->update([
         'reference_no' =>  request('reference_no'),
         'fitting_or_packing' => request('fitting_or_packing'),
         'type' =>  request('type'),
         'from_ledger_id' =>request('cr_ledger_id'),
         'to_ledger_id' =>  request('dr_ledger_id'),
         'amount' =>  request('amount'),
         'currency_id' =>  request('currency_id'),
         'narration' =>  request('narration'),
         'added_date' =>  request('t_date'),
         'company_id' => Session::get('company_id'),
         'updated_at' => DB::raw('NOW()'),
        ]);

        return redirect(route('journal_packing_pending'));
 }
}
