<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesInvoice AS si ;
use App\Models\SalesInvoiceItems AS si_items ;
use App\Models\Warehouse AS whs ;
use App\Models\AccountLedger AS agl ;
use App\Models\Currency AS crny ;
use App\Models\Account AS acnt ;
use App\Models\AccountTransaction AS acntrn ;
use App\Models\Product AS prdct ;
use App\Models\Stock AS st ;
use App\Models\BlackOrWhite AS bow ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use NumberToWords\NumberToWords;
use PDF;

class SalesInvoice extends Controller
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
       
		return view('admin.sales_invoice.index'); 
    }
    public function get_sales_invoice_list(){
        $draw = request()->input('draw');
        $start = request()->input('start');
        $length = request()->input('length');
    
    
    
        $result =  DB::table('sales_invoices')
        ->select('sales_invoices.*','currencies.code','account_ledgers.ledger','customers.customer_name')
        ->join('currencies', 'sales_invoices.currency_id', '=', 'currencies.id')
        ->join('account_ledgers','sales_invoices.sales_account_id','=','account_ledgers.id')
        ->join('customers', 'sales_invoices.customer_id', '=', 'customers.ledger_id')
        ->where("sales_invoices.delete_status", "=", 0)
        ->where("sales_invoices.company_id", "=", Session::get('company_id'))
        ->get();
        
    $data = [];
    $slno = 1;
            
            
            
    foreach ($result as $r) {
      
    
        $editButton = '<a href="' . route('sales_invoice_edit',$r->id ) . '"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
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
    $viewButton = '<a href="' . route('sales_invoice_view',$r->id ) . '">  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
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
    
    
    $btns = '<form method="post" action="'. route('sales_invoice_delete', $r->account_id) .'">'. csrf_field() . method_field('DELETE') .'<div class="flex gap-4 items-center">'.$editButton.$viewButton.$deleteButton.'</div></form>';
    $date = \Carbon\Carbon::parse($r->s_date)->format('d-m-Y');
    $ref_no ='<a style="color:#1212c1;" href="'. route('sales_invoice_view', $r->id) .'">'.$r->s_i_no.'</a>';
    
        $data[] = array(
            $slno,
            $date,
            $ref_no,
            $r->customer_name,
            $r->total,
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
        $pt_lists = DB::table('products')
        ->select('products.id','products.product_name')
        ->where("products.company_id", "=", Session::get('company_id'))
        ->where("products.delete_status", "=", 0)
        ->get();

        $ws_lists = whs::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();

        $currency_lists = crny::all();

        $lg_lists =  DB::table('account_ledgers')
        ->select('account_ledgers.id','account_ledgers.ledger')
        ->where("account_ledgers.delete_status", "=", 0)
        ->where("account_ledgers.company_id", "=", Session::get('company_id'))
        ->OrWhere("account_ledgers.company_id", "=", 0)
        ->get();


        $s_a_lists =  DB::table('account_ledgers')
        ->select('account_ledgers.id','account_ledgers.ledger')
        ->where("account_ledgers.account_group_name", "=", "DIRECT INCOME")
        ->get();


        $customer_lists =  DB::table('customers')
        ->select('customers.*')
        ->where("customers.delete_status", "=", 0)
        ->where("customers.company_id", "=", Session::get('company_id'))
        ->get();


        $data_si =  DB::table('sales_invoices')
        ->select('sales_invoices.id')
        ->where("sales_invoices.company_id", "=", Session::get('company_id'))
        ->get();
    

         if(empty($data_si)){
            $num = 0;
         }
         else{
            $num = DB::table('sales_invoices')
                ->where('company_id', '=', Session::get('company_id'))
                ->count();
         }
         $rf_n = $num + 1;
         $ref_no = str_pad($rf_n, 4, '0', STR_PAD_LEFT);
         $r_no = "SI-".$ref_no;


         $order_nos = DB::table('measurements')
    ->select('measurements.order_no')
    ->where('measurements.delete_status', '=', 0)
    ->where('measurements.company_id', '=', Session::get('company_id'))
    ->whereNotExists(function ($query) {
        $query->select(DB::raw(1))
            ->from('measurement_items')
            ->whereRaw('measurement_items.m_id = measurements.id')
            ->where('measurement_items.production_status', '<>', 'Production Completed');
    })
    ->whereExists(function ($query) {
        $query->select(DB::raw(1))
            ->from('measurement_items')
            ->whereRaw('measurement_items.m_id = measurements.id')
            ->where('measurement_items.production_status', '=', 'Production Completed');
    })
    ->get();

     



         $data = ['customer_lists' => $customer_lists,'pt_lists' => $pt_lists,'lg_lists'=> $lg_lists,'currency_lists' => $currency_lists,'r_no' => $r_no,'ws_lists' => $ws_lists,'s_a_lists' => $s_a_lists,'order_nos' => $order_nos];
        return view('admin.sales_invoice.create',$data); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'currency_id' => 'required',
            'customer_id' => 'required',
            's_date' => 'required',
            's_i_no' => 'required',
            'sale_type' => 'required',
            'due_date_no' => 'required',
        ], [
            'currency_id.required' => 'The Currency Field Is Required.',
            'customer_id.required' => 'The Customer Name Field Is Required.',
            's_date.required' => 'The Date Field Is Required.',
            's_i_no.required' => 'The Invoice Number  Field Is Required.',
            'sale_type.required' => 'The Sale Type Field Is Required.',
            'due_date_no.required' => 'The Due Date Field Is Required.',
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


         $total_w = request('w_amount_net_total');
         $total_g = request('gst_net_total');
         $total_b = request('b_amount_net_total');

         $account_id = DB::connection('mysql')->table('accounts')->insertGetId([
            't_date' =>  request('s_date'),
            't_no' =>  $t_no,
            'type' =>  'sales',
            'currency_id' =>  request('currency_id'),
            'amount' =>  request('g_amount_net_total'),
            'narration' =>  request('narration'),
            'created_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);
        DB::connection('mysql_second')->table('accounts')->insert([
            't_date' =>  request('s_date'),
            't_no' =>  $t_no,
            'type' =>  'sales',
            'currency_id' =>  request('currency_id'),
            'amount' =>  $total_w,
            'narration' =>  request('narration'),
            'created_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
         ]);

         DB::transaction(function () use ($account_id,$total_w) {
            DB::connection('mysql')->table('account_transactions')->insert([
              'added_date' =>  request('s_date'),
              'account_id' => $account_id,
              'ledger_id' =>  request('customer_id'),
              'type' =>  'dr',
              'currency_id' =>request('currency_id'),
              'amount' =>  request('g_amount_net_total'),
              'narration' =>  request('narration'),
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql')->table('account_transactions')->insert([
               'added_date' =>  request('s_date'),
               'account_id' => $account_id,
               'ledger_id' =>  request('sales_account_id'),
               'type' =>  'cr',
               'currency_id' =>request('currency_id'),
               'amount' =>  request('g_amount_net_total'),
               'narration' =>  request('narration'),
               'company_id' => Session::get('company_id'),
               'created_at' => DB::raw('NOW()'),
               'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql_second')->table('account_transactions')->insert([
              'added_date' =>  request('s_date'),
              'account_id' => $account_id,
              'ledger_id' =>  request('customer_id'),
              'type' =>  'dr',
              'currency_id' =>request('currency_id'),
              'amount' =>  $total_w,
              'narration' =>  request('narration'),
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql_second')->table('account_transactions')->insert([
              'added_date' =>  request('s_date'),
              'account_id' => $account_id,
              'ledger_id' =>  request('sales_account_id'),
              'type' =>  'cr',
              'currency_id' =>request('currency_id'),
              'amount' =>  $total_w,
              'narration' =>  request('narration'),
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
           ]);
          
    
    
        });
        
// Convert startDate to a DateTime object for easier manipulation
$startDate = request('s_date');
$due_date_no = request('due_date_no');

$endDate = date('Y-m-d', strtotime("$startDate +$due_date_no day"));

        $s_invoice_id = DB::connection('mysql')->table('sales_invoices')->insertGetId([
            's_i_no' =>  request('s_i_no'),
            's_date' => request('s_date'),
            'sale_type' => request('sale_type'),
            'order_no_id' => request('order_no'),
            'due_date_no' => $due_date_no,
            'due_date' => $endDate,
            'fitting_or_packing' => request('fitting_or_packing'),
            'account_id' => $account_id,
            'customer_id' =>request('customer_id'),
            'currency_id' =>  request('currency_id'),
            'sales_account_id' =>  request('sales_account_id'),
            'total' =>  request('g_amount_net_total'),
            'w_a_total' =>  $total_w,
            'b_a_total' =>  $total_b,
            'gst_total' => $total_g,
            'narration' =>  request('narration'),
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
      ]);
          DB::connection('mysql_second')->table('sales_invoices')->insert([
            's_i_no' =>  request('s_i_no'),
            's_date' => request('s_date'),
            'sale_type' => request('sale_type'),
            'order_no_id' => request('order_no'),
            'due_date_no' => $due_date_no,
            'due_date' => $endDate,
            'fitting_or_packing' => request('fitting_or_packing'),
            'account_id' => $account_id,
            'customer_id' =>request('customer_id'),
            'currency_id' =>  request('currency_id'),
            'sales_account_id' =>  request('sales_account_id'),
            'total' =>  $total_w + $total_g,
            'w_a_total' =>  $total_w,
            'gst_total' => $total_g,
            'narration' =>  request('narration'),
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
          ]);

          


       DB::transaction(function () use ($account_id,$total_w,$total_g,$total_b) {
        DB::connection('mysql')->table('black_or_whites')->insert([
          'ledger_id' =>  request('customer_id'),
          'white_amount' => $total_w,
          'gst_amount' => $total_g,
          'black_amount' =>  $total_b,
          'type' =>'dr',
          'account_id' =>  $account_id,
          'added_date' =>  request('s_date'),
          'company_id' => Session::get('company_id'),
          'created_at' => DB::raw('NOW()'),
          'updated_at' => DB::raw('NOW()'),
       ]);

       DB::connection('mysql')->table('black_or_whites')->insert([
        'ledger_id' =>  request('sales_account_id'),
        'white_amount' => $total_w,
        'gst_amount' => $total_g,
        'black_amount' =>  $total_b,
        'type' =>'cr',
        'account_id' =>  $account_id,
        'added_date' =>  request('s_date'),
        'company_id' => Session::get('company_id'),
        'created_at' => DB::raw('NOW()'),
        'updated_at' => DB::raw('NOW()'),
       ]);

       DB::connection('mysql_second')->table('black_or_whites')->insert([
        'ledger_id' =>  request('customer_id'),
        'white_amount' => $total_w,
        'gst_amount' => $total_g,
        'type' =>'dr',
        'account_id' =>  $account_id,
        'added_date' =>  request('s_date'),
        'company_id' => Session::get('company_id'),
        'created_at' => DB::raw('NOW()'),
        'updated_at' => DB::raw('NOW()'),
     ]);

     DB::connection('mysql_second')->table('black_or_whites')->insert([
      'ledger_id' =>  request('sales_account_id'),
      'white_amount' => $total_w,
      'gst_amount' => $total_g,
      'type' =>'cr',
      'account_id' =>  $account_id,
      'added_date' =>  request('s_date'),
      'company_id' => Session::get('company_id'),
      'created_at' => DB::raw('NOW()'),
      'updated_at' => DB::raw('NOW()'),
     ]);

    });

    $order_number = request('order_no'); 

    $measurementId = DB::table('measurements')
        ->where('order_no', $order_number)
        ->value('id');


    DB::connection('mysql')->table('measurement_items')->where('m_id', $measurementId)
    ->update([
        'production_status' => 'Billed',
        'updated_at' => DB::raw('NOW()'),
    ]);

    DB::connection('mysql_second')->table('measurement_items')->where('m_id', $measurementId)
    ->update([
        'production_status' => 'Billed',
        'updated_at' => DB::raw('NOW()'),
    ]);



       $item_id = request('item_id');
       $item_unit = request('item_unit');
       $qty = request('qty');
       $white_amount = request('white_amount');
       $gst = request('gst');
       $black_amount = request('black_amount');
       $amount = request('amount');



       for($i=0;$i<count($item_id);$i++)
          {
            if ($item_id[$i] != null) {
            DB::transaction(function () use ($s_invoice_id, $item_id, $item_unit, $qty, $white_amount,$gst,$black_amount,$amount,$i) {
                $item_details = prdct::where('id',$item_id[$i])->first();
                 
                $unit_price =  $white_amount[$i] + $gst[$i] + $black_amount[$i];

                DB::connection('mysql')->table('sales_invoice_items')->insert([
                    'si_id' =>  $s_invoice_id,
                    'added_date' => request('s_date'),
                    'item_category' =>  $item_details->category_id,
                    'item_unit' =>  $item_unit[$i],
                    'item_id' =>  $item_id[$i],
                    'qty' =>  $qty[$i],
                    'unit_price' => $unit_price,
                    'white_amount' =>  $white_amount[$i],
                    'gst' =>  $gst[$i],
                    'black_amount' =>  $black_amount[$i],
                    'amount' =>  $amount[$i],
                    'currency_id' => request('currency_id'),
                    'company_id' => Session::get('company_id'),
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
        
                DB::connection('mysql_second')->table('sales_invoice_items')->insert([
                    'si_id' =>  $s_invoice_id,
                    'added_date' => request('s_date'),
                    'item_category' => $item_details->category_id,
                    'item_unit' =>  $item_unit[$i],
                    'item_id' =>  $item_id[$i],
                    'unit_price' => $unit_price,
                    'qty' =>  $qty[$i],
                    'white_amount' =>  $white_amount[$i],
                    'gst' =>  $gst[$i],
                    'amount' =>  $amount[$i],
                    'currency_id' => request('currency_id'),
                    'company_id' => Session::get('company_id'),
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);

                DB::connection('mysql')->table('stocks')->insert([
                    's_id' =>  $s_invoice_id,
                    'date' => request('s_date'),
                    'ref_no' => request('s_i_no'),
                    'item_category_id' =>  $item_details->category_id,
                    'item_unit_id' =>  $item_unit[$i],
                    'item_id' =>  $item_id[$i],
                    'qty' =>  $qty[$i],
                    'type' => 'SALES',
                    'narration' => request('narration'),
                    'company_id' => Session::get('company_id'),
                    'created_by' =>  Auth::user()->id,
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
                DB::connection('mysql_second')->table('stocks')->insert([
                    's_id' =>  $s_invoice_id,
                    'date' => request('s_date'),
                    'ref_no' =>request('s_i_no'),
                    'item_category_id' =>  $item_details->category_id,
                    'item_unit_id' =>  $item_unit[$i],
                    'item_id' =>  $item_id[$i],
                    'qty' =>  $qty[$i],
                    'type' => 'SALES',
                    'narration' => request('narration'),
                    'company_id' => Session::get('company_id'),
                    'created_by' =>  Auth::user()->id,
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);


            });
        }
      }
      return redirect(route('sales_invoice_list'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       // $result = $id;


        $result = DB::table('sales_invoices')
        ->select('sales_invoices.*','customers.customer_name','customers.permenant_address','account_ledgers.ledger')
        ->join('customers','sales_invoices.customer_id','=','customers.ledger_id')
        ->join('account_ledgers','sales_invoices.sales_account_id','=','account_ledgers.id')
        ->where("sales_invoices.id", "=", $id)
        ->first();


        
        //$si_id = $result->id;

        $s_items = DB::table('sales_invoice_items')
        ->select('sales_invoice_items.*','units.unit_name','products.product_name')
        ->join('products','sales_invoice_items.item_id','=','products.id')
        ->join('units','sales_invoice_items.item_unit','=','units.id')
        ->where("sales_invoice_items.si_id", "=", $id)
        ->get();

        

        return view('admin.sales_invoice.view',compact('result','s_items'))->with('no', 1);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $result = $id;
        
        // $si_id = $result->id;

        $result = DB::table('sales_invoices')
        ->select('sales_invoices.*','customers.customer_name','customers.permenant_address','customers.ledger_id')
        ->join('customers','sales_invoices.customer_id','=','customers.ledger_id')
        ->where("sales_invoices.id", "=", $id)
        ->first();


        
        //$si_id = $result->id;

        $s_items = DB::table('sales_invoice_items')
        ->select('sales_invoice_items.*','units.unit_name','products.product_name')
        ->join('products','sales_invoice_items.item_id','=','products.id')
        ->join('units','sales_invoice_items.item_unit','=','units.id')
        ->where("sales_invoice_items.si_id", "=", $id)
        ->get();
        

        $pt_lists = DB::table('products')
        ->select('products.id','products.product_name')
        ->where("products.company_id", "=", Session::get('company_id'))
        ->where("products.delete_status", "=", 0)
        ->get();

        $ws_lists = whs::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();

        $currency_lists = crny::all();

        $lg_lists =  DB::table('account_ledgers')
        ->select('account_ledgers.id','account_ledgers.ledger')
        ->where("account_ledgers.delete_status", "=", 0)
        ->where("account_ledgers.company_id", "=", Session::get('company_id'))
        ->OrWhere("account_ledgers.company_id", "=", 0)
        ->get();

        $s_a_lists =  DB::table('account_ledgers')
        ->select('account_ledgers.id','account_ledgers.ledger')
        ->where("account_ledgers.account_group_name", "=", "DIRECT INCOME")
        ->get();

        $customer_lists =  DB::table('customers')
        ->select('customers.*')
        ->where("customers.delete_status", "=", 0)
        ->where("customers.company_id", "=", Session::get('company_id'))
        ->get();

       


        return view('admin.sales_invoice.edit',compact('result','lg_lists','s_a_lists','currency_lists','customer_lists','pt_lists','s_items'))->with('no', 0);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $validatedData = $request->validate([
            'currency_id' => 'required',
            'customer_id' => 'required',
            's_date' => 'required',
            's_i_no' => 'required',
            'sale_type' => 'required',
            'due_date_no' => 'required',
        ], [
            'currency_id.required' => 'The Currency Field Is Required.',
            'customer_id.required' => 'The Customer Name Field Is Required.',
            's_date.required' => 'The Date Field Is Required.',
            's_i_no.required' => 'The Invoice Number  Field Is Required.',
            'sale_type.required' => 'The Sale Type Field Is Required.',
            'due_date_no.required' => 'The Due Date Field Is Required.',
        ]);



         $total_w = request('w_amount_net_total');
         $total_g = request('gst_net_total');
         $total_b = request('b_amount_net_total');
        // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('accounts')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('accounts')->where('id', $id)
        ->update([
            't_date' =>  request('s_date'),
            'currency_id' =>  request('currency_id'),
            'amount' =>  request('g_amount_net_total'),
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
         't_date' =>  request('s_date'),
         'currency_id' =>  request('currency_id'),
         'amount' =>  $total_w,
         'narration' =>  request('narration'),
         'created_by' =>  Auth::user()->id,
         'company_id' => Session::get('company_id'),
         'updated_at' => DB::raw('NOW()'),
        ]);

        $account_id = $id;
        $startDate = request('s_date');
        $due_date_no = request('due_date_no');
        
        $endDate = date('Y-m-d', strtotime("$startDate +$due_date_no day"));
        // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('sales_invoices')->where('account_id', $account_id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('sales_invoices')->where('account_id', $account_id)
        ->update([
            's_i_no' =>  request('s_i_no'),
            's_date' =>  request('s_date'),
            'sale_type' => request('sale_type'),
            'due_date_no' => $due_date_no,
            'due_date' => $endDate,
            'currency_id' =>  request('currency_id'),
            'sales_account_id' =>  request('sales_account_id'),
            'total' =>  request('g_amount_net_total'),
            'w_a_total' =>  $total_w,
            'b_a_total' =>  $total_b,
            'gst_total' => $total_g,
            'narration' =>  request('narration'),
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('sales_invoices')->where('account_id', $account_id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('sales_invoices')->where('account_id', $account_id)
        ->update([
          's_i_no' =>  request('s_i_no'),
          's_date' =>  request('s_date'),
          'sale_type' => request('sale_type'),
          'due_date_no' => $due_date_no,
          'due_date' => $endDate,
          'currency_id' =>  request('currency_id'),
          'sales_account_id' =>  request('sales_account_id'),
          'total' =>  $total_w + $total_g,
          'w_a_total' =>  $total_w,
          'gst_total' => $total_g,
          'narration' =>  request('narration'),
          'company_id' => Session::get('company_id'),
          'updated_at' => DB::raw('NOW()'),
        ]);


        $s_invoice_id = DB::table('sales_invoices')
       ->where('account_id', $account_id)
       ->value('id');

          // Delete record from table1 in db1
       \DB::connection('mysql')->table('account_transactions')->where('account_id', $account_id)->delete();

       // Delete record from table2 in db2
       \DB::connection('mysql_second')->table('account_transactions')->where('account_id', $account_id)->delete();

          // Delete record from table1 in db1
          \DB::connection('mysql')->table('black_or_whites')->where('account_id', $account_id)->delete();

          // Delete record from table2 in db2
          \DB::connection('mysql_second')->table('black_or_whites')->where('account_id', $account_id)->delete();

           // Delete record from table1 in db1
       \DB::connection('mysql')->table('sales_invoice_items')->where('si_id', $s_invoice_id)->delete();


        // Delete record from table1 in db1
        \DB::connection('mysql_second')->table('sales_invoice_items')->where('si_id', $s_invoice_id)->delete();


         // Delete record from table1 in db1
         \DB::connection('mysql')->table('stocks')->where('s_id', $s_invoice_id)->delete();

         // Delete record from table1 in db2
       \DB::connection('mysql_second')->table('stocks')->where('s_id', $s_invoice_id)->delete();
       
          DB::transaction(function () use ($account_id,$total_w) {
            DB::connection('mysql')->table('account_transactions')->insert([
              'added_date' =>  request('s_date'),
              'account_id' => $account_id,
              'ledger_id' =>  request('customer_id'),
              'type' =>  'dr',
              'currency_id' =>request('currency_id'),
              'amount' =>  request('g_amount_net_total'),
              'narration' =>  request('narration'),
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql')->table('account_transactions')->insert([
               'added_date' =>  request('s_date'),
               'account_id' => $account_id,
               'ledger_id' =>  request('sales_account_id'),
               'type' =>  'cr',
               'currency_id' =>request('currency_id'),
               'amount' =>  request('g_amount_net_total'),
               'narration' =>  request('narration'),
               'company_id' => Session::get('company_id'),
               'created_at' => DB::raw('NOW()'),
               'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql_second')->table('account_transactions')->insert([
              'added_date' =>  request('s_date'),
              'account_id' => $account_id,
              'ledger_id' =>  request('customer_id'),
              'type' =>  'dr',
              'currency_id' =>request('currency_id'),
              'amount' =>  $total_w,
              'narration' =>  request('narration'),
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
           ]);
   
           DB::connection('mysql_second')->table('account_transactions')->insert([
              'added_date' =>  request('s_date'),
              'account_id' => $account_id,
              'ledger_id' =>  request('sales_account_id'),
              'type' =>  'cr',
              'currency_id' =>request('currency_id'),
              'amount' =>  $total_w,
              'narration' =>  request('narration'),
              'company_id' => Session::get('company_id'),
              'created_at' => DB::raw('NOW()'),
              'updated_at' => DB::raw('NOW()'),
           ]);
          
    
    
        });


     


       DB::transaction(function () use ($account_id,$total_w,$total_g,$total_b) {
        DB::connection('mysql')->table('black_or_whites')->insert([
          'ledger_id' =>  request('customer_id'),
          'white_amount' => $total_w,
          'gst_amount' => $total_g,
          'black_amount' =>  $total_b,
          'type' =>'dr',
          'account_id' =>  $account_id,
          'added_date' =>  request('s_date'),
          'company_id' => Session::get('company_id'),
          'created_at' => DB::raw('NOW()'),
          'updated_at' => DB::raw('NOW()'),
       ]);

       DB::connection('mysql')->table('black_or_whites')->insert([
        'ledger_id' =>  request('sales_account_id'),
        'white_amount' => $total_w,
        'gst_amount' => $total_g,
        'black_amount' =>  $total_b,
        'type' =>'cr',
        'account_id' =>  $account_id,
        'added_date' =>  request('s_date'),
        'company_id' => Session::get('company_id'),
        'created_at' => DB::raw('NOW()'),
        'updated_at' => DB::raw('NOW()'),
       ]);

       DB::connection('mysql_second')->table('black_or_whites')->insert([
        'ledger_id' =>  request('customer_id'),
        'white_amount' => $total_w,
        'gst_amount' => $total_g,
        'type' =>'dr',
        'account_id' =>  $account_id,
        'added_date' =>  request('s_date'),
        'company_id' => Session::get('company_id'),
        'created_at' => DB::raw('NOW()'),
        'updated_at' => DB::raw('NOW()'),
     ]);

     DB::connection('mysql_second')->table('black_or_whites')->insert([
      'ledger_id' =>  request('sales_account_id'),
      'white_amount' => $total_w,
      'gst_amount' => $total_g,
      'type' =>'cr',
      'account_id' =>  $account_id,
      'added_date' =>  request('s_date'),
      'company_id' => Session::get('company_id'),
      'created_at' => DB::raw('NOW()'),
      'updated_at' => DB::raw('NOW()'),
     ]);

    });



       $item_id = request('item_id');
       $item_unit = request('item_unit');
       $qty = request('qty');
       $white_amount = request('white_amount');
       $gst = request('gst');
       $black_amount = request('black_amount');
       $amount = request('amount');

       

       for($i=0;$i<count($item_id);$i++)
          {
            if ($item_id[$i] != null) {
            DB::transaction(function () use ($s_invoice_id, $item_id, $item_unit, $qty, $white_amount,$gst,$black_amount,$amount,$i) {
                $item_details = prdct::where('id',$item_id[$i])->first();

                $unit_price =  $white_amount[$i] + $gst[$i] + $black_amount[$i];

                DB::connection('mysql')->table('sales_invoice_items')->insert([
                    'si_id' =>  $s_invoice_id,
                    'added_date' => request('s_date'),
                    'item_category' =>  $item_details->category_id,
                    'item_unit' =>  $item_unit[$i],
                    'item_id' =>  $item_id[$i],
                    'qty' =>  $qty[$i],
                    'unit_price' => $unit_price,
                    'white_amount' =>  $white_amount[$i],
                    'gst' =>  $gst[$i],
                    'black_amount' =>  $black_amount[$i],
                    'amount' =>  $amount[$i],
                    'currency_id' => request('currency_id'),
                    'company_id' => Session::get('company_id'),
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
        
                DB::connection('mysql_second')->table('sales_invoice_items')->insert([
                    'si_id' =>  $s_invoice_id,
                    'added_date' => request('s_date'),
                    'item_category' => $item_details->category_id,
                    'item_unit' =>  $item_unit[$i],
                    'item_id' =>  $item_id[$i],
                    'qty' =>  $qty[$i],
                    'unit_price' => $unit_price,
                    'white_amount' =>  $white_amount[$i],
                    'gst' =>  $gst[$i],
                    'amount' =>  $amount[$i],
                    'currency_id' => request('currency_id'),
                    'company_id' => Session::get('company_id'),
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);

                DB::connection('mysql')->table('stocks')->insert([
                    's_id' =>  $s_invoice_id,
                    'date' => request('s_date'),
                    'ref_no' => request('s_i_no'),
                    'item_category_id' =>  $item_details->category_id,
                    'item_unit_id' =>  $item_unit[$i],
                    'item_id' =>  $item_id[$i],
                    'qty' =>  $qty[$i],
                    'type' => 'SALES',
                    'narration' => request('narration'),
                    'company_id' => Session::get('company_id'),
                    'created_by' =>  Auth::user()->id,
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
                DB::connection('mysql_second')->table('stocks')->insert([
                    's_id' =>  $s_invoice_id,
                    'date' => request('s_date'),
                    'ref_no' =>request('s_i_no'),
                    'item_category_id' =>  $item_details->category_id,
                    'item_unit_id' =>  $item_unit[$i],
                    'item_id' =>  $item_id[$i],
                    'qty' =>  $qty[$i],
                    'type' => 'SALES',
                    'narration' => request('narration'),
                    'company_id' => Session::get('company_id'),
                    'created_by' =>  Auth::user()->id,
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            });
        }
      }
      return redirect(route('sales_invoice_list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $account_id = $id;

        $s_invoice_id = DB::table('sales_invoices')
       ->where('account_id', $account_id)
       ->value('id');


        // Update the record with the new data
    DB::connection('mysql')->table('accounts')->where('id', $account_id)
    ->update([
        'delete_status' => 1,
        'updated_at' => DB::raw('NOW()'),
    ]);

    // Update the record with the new data
    DB::connection('mysql')->table('accounts')->where('id', $account_id)
        ->update([
            'delete_status' => 1,
            'updated_at' => DB::raw('NOW()'),
        ]);

        // Update the record with the new data
    DB::connection('mysql')->table('account_transactions')->where('account_id', $account_id)
    ->update([
        'delete_status' => 1,
        'updated_at' => DB::raw('NOW()'),
    ]);
    // Update the record with the new data
    DB::connection('mysql')->table('account_transactions')->where('account_id', $account_id)
        ->update([
            'delete_status' => 1,
            'updated_at' => DB::raw('NOW()'),
        ]);


 // Update the record with the new data
 DB::connection('mysql')->table('sales_invoices')->where('account_id', $account_id)
 ->update([
     'delete_status' => 1,
     'updated_at' => DB::raw('NOW()'),
 ]);
 // Update the record with the new data
 DB::connection('mysql')->table('sales_invoices')->where('account_id', $account_id)
     ->update([
         'delete_status' => 1,
         'updated_at' => DB::raw('NOW()'),
     ]);

      // Update the record with the new data
 DB::connection('mysql')->table('black_or_whites')->where('account_id', $account_id)
 ->update([
     'delete_status' => 1,
     'updated_at' => DB::raw('NOW()'),
 ]);
 // Update the record with the new data
 DB::connection('mysql')->table('black_or_whites')->where('account_id', $account_id)
     ->update([
         'delete_status' => 1,
         'updated_at' => DB::raw('NOW()'),
     ]);


      // Update the record with the new data
 DB::connection('mysql')->table('sales_invoice_items')->where('si_id', $s_invoice_id)
 ->update([
     'delete_status' => 1,
     'updated_at' => DB::raw('NOW()'),
 ]);
 // Update the record with the new data
 DB::connection('mysql')->table('sales_invoice_items')->where('si_id', $s_invoice_id)
     ->update([
         'delete_status' => 1,
         'updated_at' => DB::raw('NOW()'),
     ]);

     return redirect(route('sales_invoice_list'));


    }
    public function get_list_of_products(Request $request){
        $w_id = $request->w_id;
    
        $item_details = DB::table('stocks')
        ->select('stocks.item_id','products.id','products.product_name')
        ->join('products','stocks.item_id','=','products.id')
        ->distinct()
        ->where("stocks.warehouse_id", "=", $w_id)
        ->where("stocks.company_id", "=", Session::get('company_id'))
        ->where("stocks.delete_status", "=", 0)
        ->get();


        return response()->json($item_details);
    }
    public function get_avilable_stock(Request $request){
        $item_id = $request->item_id;
        $w_id = $request->w_id;
        $total = 0;

        $total_sales = DB::table('stocks')
        ->where('warehouse_id', $w_id)
        ->where('item_id', $item_id)
        ->where('type', 'sales')
        ->sum('qty');

        $total_purchase = DB::table('stocks')
        ->where('warehouse_id', $w_id)
        ->where('item_id', $item_id)
        ->where('type', 'purchase')
        ->sum('qty');

        if($total_purchase > $total_sales){
			$total = $total_purchase - $total_sales;
		}
		else{
			$total = $total_sales - $total_purchase;
		}

          return response()->json(['result' =>'success','total' =>$total]);
    }
    public function get_data_for_view(Request $request){
        $s_invoice_id = $request->s_invoice_id;

        $sales_invoice = DB::table('sales_invoices')
        ->select('sales_invoices.*','currencies.code','customer.ledger as customer_ledger','s_account_ledger.ledger as sales_account')
        ->join('currencies','sales_invoices.currency_id','=','currencies.id')
        ->join('account_ledgers as s_account_ledger', 'sales_invoices.sales_account_id', '=', 's_account_ledger.id')
        ->join('account_ledgers as customer', 'sales_invoices.customer_id', '=', 'customer.id')
        ->where("sales_invoices.id", "=", $s_invoice_id)
        ->first();




        $sales_invoice_items = DB::table('sales_invoice_items')
        ->select('sales_invoice_items.*','units.unit_name','products.product_name')
        ->join('units','sales_invoice_items.item_unit','=','units.id')
        ->join('products','sales_invoice_items.item_id','=','products.id')
        ->where("sales_invoice_items.si_id", "=", $s_invoice_id)
        ->get();

        return response()->json(['sales_invoice' =>$sales_invoice,'sales_invoice_items' =>$sales_invoice_items]);
    }
    public function get_address(Request $request){
        $customer_ledger_id = $request->customer_id;


        $customer_address = DB::table('customers')
        ->where('ledger_id', $customer_ledger_id)
        ->value('permenant_address');

        return response()->json(['customer_address' =>$customer_address]);

    }
    public function get_batch_nos_from_order_no(Request $request){
        $order_no = $request->order_no;

        $result =  DB::table('measurements')
        ->select('measurements.*')
        ->where("measurements.delete_status", "=", 0)
        ->where("measurements.order_no", "=", $order_no)
        ->where("measurements.company_id", "=", Session::get('company_id'))
        ->first();

        $m_id = $result->id;


        $batch_nos = DB::table('measurement_items')
        ->select('measurement_items.batch_no')
        ->where("measurement_items.m_id", "=", $m_id)
        ->get();

        return response()->json(['batch_nos' =>$batch_nos]);
    }
    public function get_order_no(Request $request){
        $sale_type = $request->sale_type;
        if($sale_type == 'B To B'){
            $data_si =  DB::table('sales_invoices')
        ->select('sales_invoices.id')
        ->where("sales_invoices.company_id", "=", Session::get('company_id'))
        ->where("sales_invoices.sale_type", "=", $sale_type)
        ->get();
    

         if(empty($data_si)){
            $num = 0;
         }
         else{
            $num = DB::table('sales_invoices')
                ->where('company_id', '=', Session::get('company_id'))
                ->where("sale_type", "=",$sale_type)
                ->count();
         }
         $rf_n = $num + 1;
         $ref_no = str_pad($rf_n, 4, '0', STR_PAD_LEFT);
         $r_no = "SIBB-".$ref_no;
        }
        else{
            $data_si =  DB::table('sales_invoices')
        ->select('sales_invoices.id')
        ->where("sales_invoices.company_id", "=", Session::get('company_id'))
        ->where("sales_invoices.sale_type", "=", $sale_type)
        ->get();
    

         if(empty($data_si)){
            $num = 0;
         }
         else{
            $num = DB::table('sales_invoices')
                ->where('company_id', '=', Session::get('company_id'))
                ->where("sale_type", "=",$sale_type)
                ->count();
         }
         $rf_n = $num + 1;
         $ref_no = str_pad($rf_n, 4, '0', STR_PAD_LEFT);
         $r_no = "SIBC-".$ref_no;
        }
        return response()->json(['r_no' =>$r_no]);
    }
    public function get_details_from_measurement_form(Request $request){
        $order_no = $request->order_no;

        $result = DB::table('measurements')
            ->select('measurements.*', 'customers.permenant_address', 'customers.ledger_id')
            ->join('customers', 'measurements.customer_id', '=', 'customers.id')
            ->where('measurements.delete_status', '=', 0)
            ->where('measurements.order_no', '=', $order_no)
            ->where('measurements.company_id', '=', Session::get('company_id'))
            ->first();
        
        return response()->json(['result' => $result]);
    }
    public function save_customer_details(Request $request){
        $customer_name = $request->customer_name;
        $mobile_no = $request->mobile_no;
        $code = $request->code;
        $email_id = $request->email_id;
        $gst_no = $request->gst_no;
        $credit_limit = $request->credit_limit;
        $discount = $request->discount;
        $permenant_address = $request->permenant_address;
        $contact_address = $request->contact_address;
        $web_address = $request->web_address;
        $remarks = $request->remarks;
        $country = $request->country;



        $ag_id = DB::table('account_groups')
        ->where('account_group_name', 'SUNDORY DEBITORS')
        ->value('id');

        $ledger_id_one = DB::connection('mysql')->table('account_ledgers')->insertGetId([
            'ledger' => $customer_name,
            'code' =>  "Customer",
            'account_group_id' =>  $ag_id,
            'account_group_name' =>  'SUNDORY DEBITORS',
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);

        $ledger_id_two = DB::connection('mysql_second')->table('account_ledgers')->insertGetId([
            'ledger' =>  $customer_name,
            'code' =>  "Customer",
            'account_group_id' =>  $ag_id,
            'account_group_name' =>  'SUNDORY DEBITORS',
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);

        DB::connection('mysql')->table('customers')->insert([
            'customer_name' =>  $customer_name,
            'mobile_no' => $mobile_no,
            'code' =>  $code,
            'email_id' =>  $email_id,
            'gst_no' =>$gst_no,
            'credit_limit' => $credit_limit,
            'permenant_address' =>  $permenant_address,
            'contact_address' =>  $contact_address,
            'web_address' =>  request('web_address'),
            'country' => $country,
            'currency' =>  $country,
            'remarks' =>  $remarks,
            'ledger_id' =>  $ledger_id_one,
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);

        DB::connection('mysql_second')->table('customers')->insert([
            'customer_name' =>  $customer_name,
            'mobile_no' => $mobile_no,
            'code' =>  $code,
            'email_id' =>  $email_id,
            'gst_no' =>$gst_no,
            'credit_limit' => $credit_limit,
            'permenant_address' =>  $permenant_address,
            'contact_address' =>  $contact_address,
            'web_address' =>  request('web_address'),
            'country' => $country,
            'currency' =>  $country,
            'remarks' =>  $remarks,
            'ledger_id' =>  $ledger_id_two,
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);

        return response()->json(['success' =>'success']);

    }
    public function get_customer_list(){
        $customer_lists =  DB::table('customers')
        ->select('customers.*')
        ->where("customers.delete_status", "=", 0)
        ->where("customers.company_id", "=", Session::get('company_id'))
        ->get();

        return response()->json(['customer_lists' =>$customer_lists]);
    }
    public function get_m_items_for_sales(Request $request){
     $order_no = $request->order_no;

     $query =  DB::table('measurements')
     ->select('measurements.*')
     ->where("measurements.order_no", "=", $order_no)
     ->where("measurements.company_id", "=", Session::get('company_id'))
     ->first();

     $m_id = $query->id;

     $m_items_lists =  DB::table('measurement_items')
     ->select('measurement_items.*')
     ->where("measurement_items.m_id", "=", $m_id)
     ->where("measurement_items.delete_status", "=", 0)
     ->where("measurement_items.company_id", "=", Session::get('company_id'))
     ->get();
     return response()->json(['m_items_lists' =>$m_items_lists]);
    }
    public function downloadInvoice(String $id)
    {
        $result = DB::table('sales_invoices')
        ->select('sales_invoices.*','customers.customer_name','customers.permenant_address','account_ledgers.ledger')
        ->join('customers','sales_invoices.customer_id','=','customers.ledger_id')
        ->join('account_ledgers','sales_invoices.sales_account_id','=','account_ledgers.id')
        ->where("sales_invoices.id", "=", $id)
        ->first();

        $s_items = DB::table('sales_invoice_items')
        ->select('sales_invoice_items.*','units.unit_name','products.product_name')
        ->join('products','sales_invoice_items.item_id','=','products.id')
        ->join('units','sales_invoice_items.item_unit','=','units.id')
        ->where("sales_invoice_items.si_id", "=", $id)
        ->get();

        $numberToWords = new NumberToWords();

        $numberTransformer = $numberToWords->getNumberTransformer('en');

        $wrds = $numberTransformer->toWords($result->total);



        $data = [
            'result' => $result,
            's_items' => $s_items,
            'no' => 1,
            'wrds' =>$wrds
        ];
        // $options = [
        //     'padding_right'  => 1,
        //     'padding_left'   => 1,
        // ];
//->setOptions($options)
     // Set the page size to A5 landscape
   $pdf = PDF::loadView('admin.sales_invoice.invoice', $data)->setPaper('a5');

    return $pdf->download($result->s_i_no . ".pdf");

        //return view('admin.sales_invoice.invoice',$data); 
    }
}
