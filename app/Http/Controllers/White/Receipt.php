<?php

namespace App\Http\Controllers\White;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Receipt AS rcpt ;
use App\Models\AccountLedger AS agl ;
use App\Models\Currency AS crny ;
use App\Models\Account AS acnt ;
use App\Models\AccountTransaction AS acntrn ;
use App\Models\BlackOrWhite AS bow ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Receipt extends Controller
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
		return view('white.accounts.receipt.index');  
    }
    public function get_receipt_list_white(){
      $draw = request()->input('draw');
      $start = request()->input('start');
      $length = request()->input('length');
  

      $result =DB::connection('mysql_second')
      ->table('receipts')
      ->select('receipts.*','from_ledger.ledger as from_ledger_name','to_ledger.ledger as to_ledger_name','currencies.code')
      ->join('account_ledgers as from_ledger', 'receipts.from_ledger_id', '=', 'from_ledger.id')
      ->join('account_ledgers as to_ledger', 'receipts.to_ledger_id', '=', 'to_ledger.id')
      ->join('currencies','receipts.currency_id','=','currencies.id')
      ->where("receipts.delete_status", "=", 0)
      ->where("receipts.approved_or_not", "=", "yes")
      ->where("receipts.company_id", "=", Session::get('company_id'))
      ->get();
      
  $data = [];
  $slno = 1;
          
          
          
  foreach ($result as $r) {
    
  
    $viewButton = '<a href="' . route('receipt_white_view',$r->id ) . '">  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
    <path
        opacity="0.5"
        d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
        stroke="currentColor"
        stroke-width="1.5"
    ></path>
    <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="1.5"></path>
    </svg></a>';
  
  
  $btns = '<div class="flex gap-4 items-center">'.$viewButton.'</div></form>';

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
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $result =  DB::table('receipts')
      ->select('receipts.*','accounts.t_no','accounts.t_date','accounts.narration')
      ->join('accounts','receipts.account_id','=','accounts.id')
      ->where("receipts.id", "=", $id)
      ->first();

      $account_id = DB::table('receipts')
      ->where('id', $id)
      ->value('account_id');

      $t_details = DB::table('account_transactions')
      ->select('account_transactions.*','account_ledgers.ledger')
      ->join('account_ledgers','account_transactions.ledger_id','=','account_ledgers.id')
      ->where("account_transactions.account_id", "=", $account_id)
      ->get();


      return view('white.accounts.receipt.view',compact('result','t_details'))->with('no', 1);
    }

   
}
