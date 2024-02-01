<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseInvoice AS pi ;
use App\Models\PurchaseInvoiceItems AS pi_items ;
use App\Models\SalesInvoice AS si ;
use App\Models\SalesInvoiceItems AS si_items ;
use App\Models\Warehouse AS whs ;
use App\Models\AccountLedger AS agl ;
use App\Models\Currency AS crny ;
use App\Models\Account AS acnt ;
use App\Models\AccountTransaction AS acntrn ;
use App\Models\Product AS prdct ;
use App\Models\ProductCategory AS pct ;
use App\Models\Stock AS st ;
use App\Models\Employee AS emply ;
use App\Models\Productionunit AS pu ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Reports extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Illuminate\Session\Middleware\StartSession');
    }
    public function index()
    {
    }
    public function currency_balance(){
        $lg_lists =  DB::table('account_ledgers')
        ->select('account_ledgers.id','account_ledgers.ledger','account_ledgers.code','account_ledgers.company_id','account_groups.account_group_name')
        ->join('account_groups','account_ledgers.account_group_id','=','account_groups.id')
        ->where("account_ledgers.delete_status", "=", 0)
        ->where("account_ledgers.company_id", "=", Session::get('company_id'))
        ->get();
		
		$data = ['lg_lists'=> $lg_lists];
        return view('admin.reports.currency_balance',$data); 
    }
    public function get_currency_balance(Request $request){
        $ledger_id = $request->ledger_id;

        $currency_lists = crny::all();
          $slno = 1;
          foreach($currency_lists as $c_list){
            $currency_id = $c_list->id;
            $currency_code = $c_list->code;

            $crsum = 0;
            $drsum = 0;
            $balance = 0;


            $cr_sum = DB::table('account_transactions')
            ->where("company_id", "=", Session::get('company_id'))
            ->where("ledger_id", "=", $ledger_id)
            ->where("currency_id", "=", $currency_id)
            ->where("type", "=", 'cr')
            ->where("delete_status", "=", 0)
            ->sum('amount');

            $dr_sum = DB::table('account_transactions')
            ->where("company_id", "=", Session::get('company_id'))
            ->where("ledger_id", "=", $ledger_id)
            ->where("currency_id", "=", $currency_id)
            ->where("type", "=", 'dr')
            ->where("delete_status", "=", 0)
            ->sum('amount');

              if($cr_sum > $dr_sum){
                $balance = $cr_sum - $dr_sum;
                $tp = 'CR';
              }
              else{
                $balance = $dr_sum - $cr_sum;
                $tp = 'DR';
              }
              $bl = number_format((float)$balance, 3, '.', '').' '.$tp; 
              $user_arr[] = array("$slno",$currency_code,$bl);
              $slno ++;
          }


          return response()->json($user_arr);
    }
    public function ledger_group_summery(){
      $lg_lists =  DB::table('account_groups')
        ->select('account_groups.id','account_groups.account_group_name')
        ->where("account_groups.delete_status", "=", 0)
        ->where("account_groups.company_id", "=", Session::get('company_id'))
        ->OrWhere("account_groups.company_id", "=", 0)
        ->get();
        $currency_lists = crny::all();
		
		  $data = ['lg_lists'=> $lg_lists,'currency_lists' => $currency_lists];
        return view('admin.reports.ledger_group_summery',$data); 
    }
    public function get_ledger_group_summery(Request $request){
      $account_group_id = $request->account_group_id;
      $currency_id = 1;

      $f_date = trim($request->from_date);
      $first_date=  date('Y-m-d', strtotime($f_date));

      $l_date = trim($request->to_date);
      $second_date=  date('Y-m-d', strtotime($l_date));
      $user_arr = DB::table('account_ledgers')
      ->select(
          'account_ledgers.ledger',
          DB::raw('SUM(CASE WHEN at.type = "dr" THEN at.amount ELSE 0 END) AS dr_sum'),
          DB::raw('SUM(CASE WHEN at.type = "cr" THEN at.amount ELSE 0 END) AS cr_sum')
      )
      ->join('account_groups', 'account_ledgers.account_group_id', '=', 'account_groups.id')
      ->leftJoin('account_transactions as at', function ($join) use ($currency_id, $first_date, $second_date) {
          $join->on('at.ledger_id', '=', 'account_ledgers.id')
              ->where('at.company_id', '=', Session::get('company_id'))
              ->where('at.currency_id', '=', $currency_id)
              ->where('at.delete_status', '=', 0)
              ->whereBetween('at.added_date', [$first_date, $second_date]);
      })
      ->where('account_ledgers.account_group_id', '=', $account_group_id)
      ->where('account_ledgers.delete_status', '=', 0)
      ->where('account_ledgers.company_id', '=', Session::get('company_id'))
      ->groupBy('account_ledgers.ledger')
      ->get();

  $user_arr = $user_arr->map(function ($item) {
      $balance = $item->dr_sum - $item->cr_sum;
      return [
          'ledger' => $item->ledger,
          'dr_sum' => $item->dr_sum,
          'cr_sum' => $item->cr_sum,
          'balance' => $balance,
      ];
  });

  return response()->json($user_arr);
    }
    public function ledger_report(){
      $lg_lists =  DB::table('account_ledgers')
      ->select('account_ledgers.id','account_ledgers.ledger','account_ledgers.code','account_ledgers.company_id')
      ->where("account_ledgers.delete_status", "=", 0)
      ->get();
      $currency_lists = crny::all();
		
		  $data = ['lg_lists'=> $lg_lists,'currency_lists' => $currency_lists];
      return view('admin.reports.ledger_report',$data); 
  }
  public function get_ledger_report(Request $request){
      $ledger_id = $request->ledger_id;
      $currency_id = 1;

      $f_date = trim($request->from_date);
      $first_date=  date('Y-m-d', strtotime($f_date));

      $l_date = trim($request->to_date);
      $second_date=  date('Y-m-d', strtotime($l_date));

      $data_result = DB::table('account_transactions')
        ->select('account_transactions.*')
        ->where("account_transactions.company_id", "=", Session::get('company_id'))
        ->where("account_transactions.ledger_id", "=", $ledger_id)
       
        ->where("account_transactions.delete_status", "=", 0)
        ->whereBetween('account_transactions.added_date', [$first_date, $second_date])
        ->get();
        $sl_no =1;
       
        if($data_result->isEmpty()){
          $user_arr = [''];
        }
        else{
          foreach($data_result as $value){


            $data_result_for_accounts = DB::table('accounts')
            ->select('*')
            ->where("id", "=", $value->account_id)
            ->first();


            $v_type = $data_result_for_accounts->type;
            $orgDate = $data_result_for_accounts->t_date;
            $t_date = date("d-m-Y", strtotime($orgDate));
            $type = $value->type;
            $amount = $value->amount;

            $data_for_ledger_id = DB::table('account_transactions')
            ->where("company_id", "=", Session::get('company_id'))
            ->where("ledger_id", "!=", $value->ledger_id)
            ->where("account_id", "=", $value->account_id)
            ->first();

            $ledger = $data_for_ledger_id->ledger_id;

            $data_for_ledger_name = DB::table('account_ledgers')
            ->where("id", "=", $ledger)
            ->first();
            $ledger_name = $data_for_ledger_name->ledger;

            if($v_type == 'sales'){
                $data_for_sales_invoice = DB::table('sales_invoices')
                ->select('*')
                ->where("account_id", "=", $value->account_id)
                ->first();
                $t_no = $data_for_sales_invoice->s_i_no;
                $narration = $ledger_name."<br>-".$data_result_for_accounts->narration;
            }
            else if($v_type == 'purchase')
            {
              $data_for_purchase_invoice = DB::table('purchase_invoices')
              ->select('*')
              ->where("account_id", "=", $value->account_id)
              ->first();

              $t_no = $data_for_purchase_invoice->p_i_no;
              $narration = $ledger_name."<br>-".$data_result_for_accounts->narration;
              
            }
            else if($v_type == 'mct'){
              $data_for_mct = DB::table('multi_currency_transfers')
              ->select('*')
              ->where("account_id", "=", $value->account_id)
              ->first();
                $t_no =  $data_for_mct->reference_no;
               $narration = $ledger_name."<br>-".$data_result_for_accounts->narration;
            }
            else if($v_type == 'payment'){
              $data_for_payment= DB::table('payments')
              ->select('*')
              ->where("account_id", "=", $value->account_id)
              ->first();
                $t_no =  $data_for_payment->reference_no;
                $narration = $ledger_name."<br>-".$data_result_for_accounts->narration;
              
            }
            else if($v_type == 'receipt'){
              $data_for_receipt= DB::table('receipts')
              ->select('*')
              ->where("account_id", "=", $value->account_id)
              ->first();
                $t_no =  $data_for_receipt->reference_no;
              $narration = $ledger_name."<br>-".$data_result_for_accounts->narration;
              
            }
            else if($v_type == 'journal'){
              $data_for_journal= DB::table('journals')
              ->select('*')
              ->where("account_id", "=", $value->account_id)
              ->first();
                $t_no =  $data_for_journal->reference_no;
               $narration = $ledger_name."<br>-".$data_result_for_accounts->narration;
            }
            else if($v_type == 'contra'){
              $data_for_contra= DB::table('contras')
              ->select('*')
              ->where("account_id", "=", $value->account_id)
              ->first();
                $t_no =  $data_for_contra->reference_no;
              $narration = $ledger_name."<br>-".$data_result_for_accounts->narration;
            }
            else{
              $t_no = $data_result_for_accounts->t_no;	
              $narration = $data_result_for_accounts->narration;
            }
          
            $user_arr[] = array($t_no,$t_date,$ledger_name,$amount,$type,$narration,"$sl_no");
            $sl_no ++;
           }
        }
           
           
           $opening_balance_cr = DB::table('account_transactions')
           ->where("company_id", "=", Session::get('company_id'))
           ->where("ledger_id", "=", $ledger_id)
          
           ->where("type", "=", 'cr')
           ->where("delete_status", "=", 0)
           ->where("added_date", "<", $first_date)
           ->sum('amount');

           $opening_balance_dr = DB::table('account_transactions')
           ->where("company_id", "=", Session::get('company_id'))
           ->where("ledger_id", "=", $ledger_id)
     
           ->where("type", "=", 'dr')
           ->where("delete_status", "=", 0)
           ->where("added_date", "<", $first_date)
           ->sum('amount');

           $balance = $opening_balance_dr - $opening_balance_cr;

           return response()->json(['result' =>'success','balance' =>$balance,'user_arr' => $user_arr]);

  }
  public function stock_report(){
    $pc_lists = pct::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();
    $ws_lists = whs::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();
  
    $data = ['pc_lists'=> $pc_lists,'ws_lists' => $ws_lists];
    return view('admin.reports.stock_report',$data); 
  }
  public function get_item_list(Request $request){
    $category_id = $request->product_category_id;
    $pt_lists = DB::table('products')
    ->select('products.id','products.product_name','products.barcode','products.qty','units.unit_name','product_categories.category_name')
    ->join('units','products.unit_id','=','units.id')
    ->join('product_categories','products.category_id','=','product_categories.id')
    ->where("products.company_id", "=", Session::get('company_id'))
    ->where("products.category_id", "=", $category_id)
    ->where("products.delete_status", "=", 0)
    ->get();
    return response()->json($pt_lists);
  }
  public function get_stock_report(Request $request){
      $product_category_id = $request->product_category_id;
      $item_id = $request->item_id;
      $warehouse_id = 0;

      $f_date = trim($request->from_date);
      $first_date=  date('Y-m-d', strtotime($f_date));

      $l_date = trim($request->to_date);
      $second_date=  date('Y-m-d', strtotime($l_date));

      $s_qty = 0;
      $p_qty = 0;

      if(("" == trim($item_id)) && ("" == trim($warehouse_id))){
        $result_data = DB::table('stocks')
        ->select('stocks.*','products.product_name','product_categories.category_name')
        ->join('products','stocks.item_id','=','products.id')
        ->join('product_categories','stocks.item_category_id','=','product_categories.id')
        ->where("stocks.company_id", "=", Session::get('company_id'))
        ->where("stocks.item_category_id", "=", $product_category_id)
        ->where("stocks.delete_status", "=", 0)
        ->whereBetween('stocks.date', [$first_date, $second_date])
        ->get();
      }
      else if("" == trim($item_id)){
        $result_data = DB::table('stocks')
        ->select('stocks.*','products.product_name','product_categories.category_name')
        ->join('products','stocks.item_id','=','products.id')
        ->join('product_categories','stocks.item_category_id','=','product_categories.id')
       
        ->where("stocks.company_id", "=", Session::get('company_id'))
        ->where("stocks.item_category_id", "=", $product_category_id)

        ->where("stocks.delete_status", "=", 0)
        ->whereBetween('stocks.date', [$first_date, $second_date])
        ->get();
      }
    
      else{
        $result_data = DB::table('stocks')
        ->select('stocks.*','products.product_name','product_categories.category_name')
        ->join('products','stocks.item_id','=','products.id')
        ->join('product_categories','stocks.item_category_id','=','product_categories.id')
       
        ->where("stocks.company_id", "=", Session::get('company_id'))
        ->where("stocks.item_category_id", "=", $product_category_id)
        ->where("stocks.item_id", "=", $item_id)
        ->where("stocks.delete_status", "=", 0)
        ->whereBetween('stocks.date', [$first_date, $second_date])
        ->get();
      }

      if($result_data->isEmpty()){
        $user_arr = [''];
      }
      else{
        $slno =1;
        foreach($result_data as $value){
          $item_name = $value->product_name;
          $orgDate = $value->date;
          $date = date("d-m-Y", strtotime($orgDate));
          $qty = $value->qty;
          $type = $value->type;
          $ref_no= $value->ref_no;
  
          if(($type == 'SALES') || ($type == 'PRODUCTION')){
            $s_qty = $value->qty;
            $p_qty = 0;
          }
          else{
            $p_qty = $value->qty;
            $s_qty = 0;
          }
          $w_name = '';
          $p_id  = $value->p_id; 
          $s_id  = $value->s_id;
          $st_id  = $value->st_id;
          $m_items_id = $value->m_items_id;
          $narration = $value->narration;
       
         $user_arr[] = array($date,$ref_no,$item_name,"$s_qty","$p_qty",$narration,"$slno");
         $slno ++;
        }
      }

     
      return response()->json($user_arr); 
  }
  public function sales_report(){
    $pc_lists = pct::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();
    $currency_lists = crny::all();
    $lg_lists =  DB::table('customers')
        ->select('customers.ledger_id','customers.customer_name')
        ->where("customers.delete_status", "=", 0)
        ->where("customers.company_id", "=", Session::get('company_id'))
        ->get();

  
    $data = ['pc_lists'=> $pc_lists,'currency_lists' => $currency_lists,'lg_lists' =>$lg_lists];
    return view('admin.reports.sales_report',$data); 
  }
  public function get_sales_report(Request $request){
    $product_category_id = $request->product_category_id;
    $item_id = $request->item_id;
    $customer_id = $request->customer_id;


    $f_date = trim($request->from_date);
    $first_date=  date('Y-m-d', strtotime($f_date));

    $l_date = trim($request->to_date);
    $second_date=  date('Y-m-d', strtotime($l_date));

    if("" == trim($product_category_id)){
      $result_data = DB::table('sales_invoice_items')
      ->select('sales_invoice_items.*','sales_invoices.*','products.product_name','account_ledgers.ledger')
      ->leftjoin('products','sales_invoice_items.item_id','=','products.id')
      ->leftjoin('product_categories','sales_invoice_items.item_category','=','product_categories.id')
      ->leftjoin('sales_invoices','sales_invoice_items.si_id','=','sales_invoices.id')
      ->leftjoin('account_ledgers','sales_invoices.customer_id','=','account_ledgers.id')
      ->where("sales_invoice_items.company_id", "=", Session::get('company_id'))
      ->where("sales_invoice_items.delete_status", "=", 0)
      ->where("sales_invoices.customer_id", "=", $customer_id)
      ->whereBetween('sales_invoice_items.added_date', [$first_date, $second_date])
      ->get();
    }
    else if(("" == trim($item_id)) && ("" == trim($product_category_id))){
      $result_data = DB::table('sales_invoice_items')
    ->select('sales_invoice_items.*','sales_invoices.*','products.product_name','account_ledgers.ledger')
    ->join('products','sales_invoice_items.item_id','=','products.id')
    ->join('product_categories','sales_invoice_items.item_category','=','product_categories.id')
    ->join('sales_invoices','sales_invoice_items.si_id','=','sales_invoices.id')
    ->join('account_ledgers','sales_invoices.customer_id','=','account_ledgers.id')
    ->where("sales_invoice_items.company_id", "=", Session::get('company_id'))
    ->where("sales_invoices.customer_id", "=", $customer_id)
    ->where("sales_invoice_items.delete_status", "=", 0)
    ->whereBetween('sales_invoice_items.added_date', [$first_date, $second_date])
    ->get();
}
    else if(("" == trim($item_id)) && ("" == trim($customer_id))){
      $result_data = DB::table('sales_invoice_items')
    ->select('sales_invoice_items.*','sales_invoices.*','products.product_name','account_ledgers.ledger')
    ->join('products','sales_invoice_items.item_id','=','products.id')
    ->join('product_categories','sales_invoice_items.item_category','=','product_categories.id')
    ->join('sales_invoices','sales_invoice_items.si_id','=','sales_invoices.id')
    ->join('account_ledgers','sales_invoices.customer_id','=','account_ledgers.id')
    ->where("sales_invoice_items.company_id", "=", Session::get('company_id'))
    ->where("sales_invoice_items.item_category", "=", $product_category_id)
    ->where("sales_invoice_items.delete_status", "=", 0)
    ->whereBetween('sales_invoice_items.added_date', [$first_date, $second_date])
    ->get();
}
    else if("" == trim($item_id)){
      $result_data = DB::table('sales_invoice_items')
      ->select('sales_invoice_items.*','sales_invoices.*','products.product_name','account_ledgers.ledger')
      ->leftjoin('products','sales_invoice_items.item_id','=','products.id')
      ->leftjoin('product_categories','sales_invoice_items.item_category','=','product_categories.id')
      ->leftjoin('sales_invoices','sales_invoice_items.si_id','=','sales_invoices.id')
      ->leftjoin('account_ledgers','sales_invoices.customer_id','=','account_ledgers.id')
      ->where("sales_invoice_items.company_id", "=", Session::get('company_id'))
      ->where("sales_invoice_items.item_category", "=", $product_category_id)
      ->where("sales_invoice_items.delete_status", "=", 0)
      ->where("sales_invoices.customer_id", "=", $customer_id)
      ->whereBetween('sales_invoice_items.added_date', [$first_date, $second_date])
      ->get();
    }
        else if("" == trim($customer_id)){
          $result_data = DB::table('sales_invoice_items')
        ->select('sales_invoice_items.*','sales_invoices.*','products.product_name','account_ledgers.ledger')
        ->join('products','sales_invoice_items.item_id','=','products.id')
        ->join('product_categories','sales_invoice_items.item_category','=','product_categories.id')
        ->join('sales_invoices','sales_invoice_items.si_id','=','sales_invoices.id')
        ->join('account_ledgers','sales_invoices.customer_id','=','account_ledgers.id')
        ->where("sales_invoice_items.company_id", "=", Session::get('company_id'))
        ->where("sales_invoice_items.item_id", "=", $item_id)
        ->where("sales_invoice_items.item_category", "=", $product_category_id)
        ->where("sales_invoice_items.delete_status", "=", 0)
        ->whereBetween('sales_invoice_items.added_date', [$first_date, $second_date])
        ->get();
    }
      else{
        $result_data = DB::table('sales_invoice_items')
        ->select('sales_invoice_items.*','sales_invoices.*','products.product_name','account_ledgers.ledger')
        ->join('products','sales_invoice_items.item_id','=','products.id')
        ->join('product_categories','sales_invoice_items.item_category','=','product_categories.id')
        ->join('sales_invoices','sales_invoice_items.si_id','=','sales_invoices.id')
        ->join('account_ledgers','sales_invoices.customer_id','=','account_ledgers.id')
        ->where("sales_invoice_items.company_id", "=", Session::get('company_id'))
        ->where("sales_invoice_items.item_id", "=", $item_id)
        ->where("sales_invoice_items.item_category", "=", $product_category_id)
        ->where("sales_invoice_items.delete_status", "=", 0)
        ->where("sales_invoices.customer_id", "=", $customer_id)
        ->whereBetween('sales_invoice_items.added_date', [$first_date, $second_date])
        ->get();
      }
      $sl_no = 1;
      if($result_data->isEmpty()){
        $user_arr = [''];
      }
      else{
      foreach($result_data as $value){
        $orgDate = $value->added_date;
        $added_date = date("d-m-Y", strtotime($orgDate));
        $ref_no= $value->s_i_no;
        $customer_name = $value->ledger;
        $item_name = $value->product_name;
        $qty = $value->qty;
        $unit_price=$value->unit_price;
        $amount =$value->amount;
        $narration = $value->narration;
        $user_arr[] = array($added_date,$ref_no,$customer_name,$item_name,$qty,$unit_price,$amount,$narration,"$sl_no");
        $sl_no++;
      }
    }
      return response()->json($user_arr); 
  }
  public function purchase_report(){
    $pc_lists = pct::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();
    $currency_lists = crny::all();
    $lg_lists =  DB::table('suppliers')
        ->select('suppliers.ledger_id','suppliers.supplier_name')
        ->where("suppliers.delete_status", "=", 0)
        ->where("suppliers.company_id", "=", Session::get('company_id'))
        ->get();

  
    $data = ['pc_lists'=> $pc_lists,'currency_lists' => $currency_lists,'lg_lists' =>$lg_lists];
    return view('admin.reports.purchase_report',$data); 
  }
  public function get_purchase_report(Request $request){
    $product_category_id = $request->product_category_id;
    $item_id = $request->item_id;
    $supplier_id = $request->supplier_id;
    //$currency_id = $request->currency_id;


    $f_date = trim($request->from_date);
    $first_date=  date('Y-m-d', strtotime($f_date));

    $l_date = trim($request->to_date);
    $second_date=  date('Y-m-d', strtotime($l_date));

    if("" == trim($product_category_id)){
   
      $result_data = DB::table('purchase_invoice_items')
      ->select('purchase_invoice_items.*','purchase_invoices.*','products.product_name','account_ledgers.ledger')
      ->leftjoin('products','purchase_invoice_items.item_id','=','products.id')
      ->leftjoin('product_categories','purchase_invoice_items.item_category','=','product_categories.id')
      ->leftjoin('purchase_invoices','purchase_invoice_items.pi_id','=','purchase_invoices.id')
      ->leftjoin('account_ledgers','purchase_invoices.supplier_id','=','account_ledgers.id')
      ->where("purchase_invoice_items.company_id", "=", Session::get('company_id'))
      
      ->where("purchase_invoice_items.delete_status", "=", 0)
      ->where("purchase_invoices.supplier_id", "=", $supplier_id)
      ->whereBetween('purchase_invoice_items.added_date', [$first_date, $second_date])
      ->get();
    }
    else if(("" == trim($item_id)) && ("" == trim($supplier_id))){
     
      $result_data = DB::table('purchase_invoice_items')
      ->select('purchase_invoice_items.*','purchase_invoices.*','products.product_name','account_ledgers.ledger')
      ->leftjoin('products','purchase_invoice_items.item_id','=','products.id')
      ->leftjoin('product_categories','purchase_invoice_items.item_category','=','product_categories.id')
      ->leftjoin('purchase_invoices','purchase_invoice_items.pi_id','=','purchase_invoices.id')
      ->leftjoin('account_ledgers','purchase_invoices.supplier_id','=','account_ledgers.id')
      ->where("purchase_invoice_items.company_id", "=", Session::get('company_id'))
      ->where("purchase_invoice_items.item_category", "=", $product_category_id)
      ->where("purchase_invoice_items.delete_status", "=", 0)
      ->whereBetween('purchase_invoice_items.added_date', [$first_date, $second_date])
      ->get();
    }
    else if("" == trim($item_id)){
      
      $result_data = DB::table('purchase_invoice_items')
      ->select('purchase_invoice_items.*','purchase_invoices.*','products.product_name','account_ledgers.ledger')
      ->leftjoin('products','purchase_invoice_items.item_id','=','products.id')
      ->leftjoin('product_categories','purchase_invoice_items.item_category','=','product_categories.id')
      ->leftjoin('purchase_invoices','purchase_invoice_items.pi_id','=','purchase_invoices.id')
      ->leftjoin('account_ledgers','purchase_invoices.supplier_id','=','account_ledgers.id')
      ->where("purchase_invoice_items.company_id", "=", Session::get('company_id'))
      ->where("purchase_invoice_items.item_category", "=", $product_category_id)
      ->where("purchase_invoice_items.delete_status", "=", 0)
      ->where("purchase_invoices.supplier_id", "=", $supplier_id)
      ->whereBetween('purchase_invoice_items.added_date', [$first_date, $second_date])
      ->get();
    }
       
        else if("" == trim($supplier_id)){
      
          $result_data = DB::table('purchase_invoice_items')
        ->select('purchase_invoice_items.*','purchase_invoices.*','products.product_name','account_ledgers.ledger')
        ->leftjoin('products','purchase_invoice_items.item_id','=','products.id')
        ->leftjoin('product_categories','purchase_invoice_items.item_category','=','product_categories.id')
        ->leftjoin('purchase_invoices','purchase_invoice_items.pi_id','=','purchase_invoices.id')
        ->leftjoin('account_ledgers','purchase_invoices.supplier_id','=','account_ledgers.id')
        ->where("purchase_invoice_items.company_id", "=", Session::get('company_id'))
        ->where("purchase_invoice_items.item_id", "=", $item_id)
        ->where("purchase_invoice_items.item_category", "=", $product_category_id)
        ->where("purchase_invoice_items.delete_status", "=", 0)
        ->whereBetween('purchase_invoice_items.added_date', [$first_date, $second_date])
        ->get();
    }
   
      else{
       
        $result_data = DB::table('purchase_invoice_items')
        ->select('purchase_invoice_items.*','purchase_invoices.*','products.product_name','account_ledgers.ledger')
        ->leftjoin('products','purchase_invoice_items.item_id','=','products.id')
        ->leftjoin('product_categories','purchase_invoice_items.item_category','=','product_categories.id')
        ->leftjoin('purchase_invoices','purchase_invoice_items.pi_id','=','purchase_invoices.id')
        ->leftjoin('account_ledgers','purchase_invoices.supplier_id','=','account_ledgers.id')
        ->where("purchase_invoice_items.company_id", "=", Session::get('company_id'))
        ->where("purchase_invoice_items.item_id", "=", $item_id)
        ->where("purchase_invoice_items.item_category", "=", $product_category_id)
        ->where("purchase_invoice_items.delete_status", "=", 0)
        ->where("purchase_invoices.supplier_id", "=", $supplier_id)
        ->whereBetween('purchase_invoice_items.added_date', [$first_date, $second_date])
        ->get();
      }
$sl_no = 1;
if($result_data->isEmpty()){
  $user_arr = [''];
}
else{
      foreach($result_data as $value){
        $orgDate = $value->added_date;
        $added_date = date("d-m-Y", strtotime($orgDate));
        $ref_no= $value->p_i_no;
        $supplier_name = $value->ledger;
        $item_name = $value->product_name;
        $qty = $value->qty;
        $unit_price=$value->unit_price;
        $amount =$value->amount;
        $narration = $value->narration;
       
      
        $user_arr[] = array($added_date,$ref_no,$supplier_name,$item_name,$qty,$unit_price,$amount,$narration,"$sl_no");
        $sl_no ++;
      }
    }
      return response()->json($user_arr); 
  }
  public function pending_sales_invoices(){
    $currentDate = date('Y-m-d');
    $si_lists =  DB::table('sales_invoices')
    ->select('sales_invoices.*','currencies.code','account_ledgers.ledger','customers.customer_name')
    ->leftjoin('currencies', 'sales_invoices.currency_id', '=', 'currencies.id')
    ->leftjoin('account_ledgers','sales_invoices.sales_account_id','=','account_ledgers.id')
    ->leftjoin('customers', 'sales_invoices.customer_id', '=', 'customers.ledger_id')
    ->where("sales_invoices.delete_status", "=", 0)
    ->where("sales_invoices.due_date", "=", $currentDate)
    ->where("sales_invoices.payment_status", "=" , null)
    ->where("sales_invoices.company_id", "=", Session::get('company_id'))
    ->get();

    

$data = ['si_lists'=> $si_lists];
return view('admin.reports.pending_sales_invoices',$data)->with('no', 1); 
  }
  public function change_status(string $id){
    DB::connection('mysql')->table('sales_invoices')->where('id', $id)
    ->update([
        'payment_status' => 'Amount Received',
        'updated_at' => DB::raw('NOW()'),
    ]);



// Update the record with the new data
DB::connection('mysql_second')->table('sales_invoices')->where('id', $id)
    ->update([
      'payment_status' => 'Amount Received',
      'updated_at' => DB::raw('NOW()'),
    ]);

    return redirect(route('pending_sales_invoices'));
  }
  public function employee_report(){
    $ey_lists = emply::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();

$data = ['ey_lists'=> $ey_lists];
    return view('admin.reports.employee_report',$data); 
  }
  public function get_employee_report(Request $request){
    $e_id = $request->e_id;
  

    $data_result = DB::table('employee_accounts')
      ->select('employee_accounts.*','employees.e_name')
      ->join('employees','employee_accounts.em_id','=','employees.id')
      ->where("employee_accounts.company_id", "=", Session::get('company_id'))
      ->where("employee_accounts.em_id", "=", $e_id)
      ->where("employee_accounts.delete_status", "=", 0)
      ->get();
      $sl_no =1;
      if($data_result->isEmpty()){
        $user_arr = [''];
      }
      else{
        
         foreach($data_result as $value){

          $user_arr[] = array("$sl_no",$value->added_date,$value->total_hour,$value->cr_amount,$value->dr_amount);
          $sl_no ++;
         }
        }
        return response()->json($user_arr); 

}
public function packing_list_report(){
  return view('admin.reports.packing_list'); 
}
public function get_report_of_packing_list(Request $request){
  $d_date = $request->d_date;
  $porf = $request->porf;


    $f_date = trim($d_date);
    $delivery_date=  date('Y-m-d', strtotime($f_date));
  


      $data_result =  DB::table('measurements')
      ->select('measurements.*','measurement_items.id as mitems_id','measurement_items.batch_no','measurement_items.model_id','measurement_items.order_type','measurement_items.finish_work_front','measurement_items.finish_work_back','customers.customer_name','doorroots.root_name','doorlocks.lock_name')
      ->leftjoin('measurement_items', 'measurements.id', '=', 'measurement_items.m_id')
      ->leftjoin('customers', 'measurements.customer_id', '=', 'customers.id')
      ->leftjoin('doorroots', 'measurements.root_id', '=', 'doorroots.id')
      ->leftjoin('doorlocks', 'measurement_items.lock_id', '=', 'doorlocks.id')
      ->where("measurements.delete_status", "=", 0)
      ->where("measurements.company_id", "=", Session::get('company_id'))
      ->where("measurements.status", "=", 'Confirmed')
      ->where("measurements.fitting_or_packing", "=",$porf)
      ->where("measurements.delivery_date", "=", $delivery_date)
      ->where("measurement_items.production_status", "=", 'Assigned')
      ->get();


      $sl_no =1;
      if($data_result->isEmpty()){
        $user_arr = [''];
      }
      else{
        
         foreach($data_result as $value){


          $order_type = $value->order_type;
            if($order_type == 'Door Only'){
              $dr_no = 1;
              $fm_no = 0;
            }
            else if($order_type == 'Frame Only'){
              $dr_no = 0;
              $fm_no = 1;
            }
            else{
              $dr_no = 1;
              $fm_no = 1;
            }

          $user_arr[] = array("$sl_no",$value->customer_name,$value->root_name,$value->batch_no,"$dr_no","$fm_no",$value->finish_work_front,$value->finish_work_back,$value->lock_name,$value->delivery_date);
          $sl_no ++;
         }
        }
        return response()->json($user_arr); 
}
public function print_packing_list($d_date, $porf) {
  $f_date = trim($d_date);
  $delivery_date=  date('Y-m-d', strtotime($f_date));



    $result =  DB::table('measurements')
    ->select('measurements.*','measurement_items.id as mitems_id','measurement_items.batch_no','measurement_items.model_id','measurement_items.order_type','measurement_items.finish_work_front','measurement_items.finish_work_back','customers.customer_name','doorroots.root_name','doorlocks.lock_name')
    ->join('measurement_items', 'measurements.id', '=', 'measurement_items.m_id')
    ->join('customers', 'measurements.customer_id', '=', 'customers.id')
    ->join('doorroots', 'measurements.root_id', '=', 'doorroots.id')
    ->join('doorlocks', 'measurement_items.lock_id', '=', 'doorlocks.id')
    ->where("measurements.delete_status", "=", 0)
    ->where("measurements.company_id", "=", Session::get('company_id'))
    ->where("measurements.status", "=", 'Confirmed')
    ->where("measurements.fitting_or_packing", "=",$porf)
    ->where("measurements.delivery_date", "=", $delivery_date)
    ->where("measurement_items.production_status", "=", 'Assigned')
    ->get();
    $data = [
      'result' => $result,
      'porf' => $porf, // Pass $porf to the view
      'd_date' => $d_date, // Pass $d_date to the view
  ];
  return view('admin.reports.print_packing_list',$data); 
}
public function production_list_report(){
  $ut_lists = pu::select("*")
  ->where("company_id", "=", Session::get('company_id'))
  ->where("delete_status", "=", 0)
  ->get();

$data = ['ut_lists'=> $ut_lists];
  return view('admin.reports.production_list',$data);
}
public function get_report_of_production_list(Request $request){
  $d_date = $request->d_date;
  $p_unit_id = $request->p_unit_id;


    $f_date = trim($d_date);
    $delivery_date=  date('Y-m-d', strtotime($f_date));
  


      // $data_result =  DB::table('measurements')
      // ->select('measurements.*','measurement_items.id as mitems_id','measurement_items.batch_no','measurement_items.model_id','measurement_items.order_type','measurement_items.finish_work_front','measurement_items.finish_work_back','customers.customer_name','doorroots.root_name','doorlocks.lock_name','doormodels.model_name')
      // ->join('measurement_items', 'measurements.id', '=', 'measurement_items.m_id')
      // ->join('customers', 'measurements.customer_id', '=', 'customers.id')
      // ->join('doorroots', 'measurements.root_id', '=', 'doorroots.id')
      // ->join('doorlocks', 'measurement_items.lock_id', '=', 'doorlocks.id')
      // ->join('doormodels', 'measurement_items.model_id', '=', 'doormodels.id')
      // ->where("measurements.delete_status", "=", 0)
      // ->where("measurements.company_id", "=", Session::get('company_id'))
      // ->where("measurements.status", "=", 'Confirmed')
      // ->where("measurement_items.production_unit_id", "=",$p_unit_id)
      // ->where("measurements.delivery_date", "=", $delivery_date)
      // ->where("measurement_items.production_status", "=", 'Assigned')
      // ->get();
      $data_result =  DB::table('measurements')
      ->selectRaw('doormodels.model_name, COUNT(doormodels.model_name) as model_count')
      ->join('measurement_items', 'measurements.id', '=', 'measurement_items.m_id')
      ->join('customers', 'measurements.customer_id', '=', 'customers.id')
      ->join('doorroots', 'measurements.root_id', '=', 'doorroots.id')
      ->join('doorlocks', 'measurement_items.lock_id', '=', 'doorlocks.id')
      ->join('doormodels', 'measurement_items.model_id', '=', 'doormodels.id')
      ->where("measurements.delete_status", "=", 0)
      ->where("measurements.company_id", "=", Session::get('company_id'))
      ->where("measurements.status", "=", 'Confirmed')
      ->where("measurement_items.production_unit_id", "=", $p_unit_id)
      ->where("measurements.delivery_date", "=", $delivery_date)
      ->where("measurement_items.production_status", "=", 'Assigned')
      ->groupBy('doormodels.model_name')
      ->get();
  

      $sl_no =1;
      if($data_result->isEmpty()){
        $user_arr = [''];
      }
      else{
        
         foreach($data_result as $value){



          $user_arr[] = array("$sl_no",$value->model_name,"$value->model_count");
          $sl_no ++;
         }
        }
        return response()->json($user_arr); 
}
}
