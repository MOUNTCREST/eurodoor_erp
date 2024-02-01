<?php

namespace App\Http\Controllers\White;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PurchaseInvoice AS pi ;
use App\Models\PurchaseInvoiceItems AS pi_items ;
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

class PurchaseInvoice extends Controller
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
    
		return view('white.purchase_invoice.index'); 
    }

    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = DB::table('purchase_invoices')
        ->select('purchase_invoices.*','suppliers.supplier_name','suppliers.permenant_address','account_ledgers.ledger')
        ->join('suppliers','purchase_invoices.supplier_id','=','suppliers.ledger_id')
        ->join('account_ledgers','purchase_invoices.purchase_account_id','=','account_ledgers.id')
        ->where("purchase_invoices.id", "=", $id)
        ->first();


        
        //$si_id = $result->id;

        $p_items = DB::table('purchase_invoice_items')
        ->select('purchase_invoice_items.*','units.unit_name','products.product_name')
        ->join('products','purchase_invoice_items.item_id','=','products.id')
        ->join('units','purchase_invoice_items.item_unit','=','units.id')
        ->where("purchase_invoice_items.pi_id", "=", $id)
        ->get();

        

        return view('white.purchase_invoice.view',compact('result','p_items'))->with('no', 1);
    }

    
    public function get_purchase_invoice_list_white(){
        $draw = request()->input('draw');
        $start = request()->input('start');
        $length = request()->input('length');
    
    



        $result =  DB::connection('mysql_second')
        ->table('purchase_invoices')
        ->select('purchase_invoices.*','currencies.code','account_ledgers.ledger','suppliers.supplier_name')
        ->join('currencies', 'purchase_invoices.currency_id', '=', 'currencies.id')
        ->join('account_ledgers','purchase_invoices.purchase_account_id','=','account_ledgers.id')
        ->join('suppliers', 'purchase_invoices.supplier_id', '=', 'suppliers.ledger_id')
        ->where("purchase_invoices.delete_status", "=", 0)
        ->where("purchase_invoices.company_id", "=", Session::get('company_id'))
        ->get();

  
        
        
    $data = [];
    $slno = 1;
            
            
            
    foreach ($result as $r) {
      

    $viewButton = '<a href="' . route('purchase_invoice_white_view',$r->id ) . '">  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
    <path
        opacity="0.5"
        d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
        stroke="currentColor"
        stroke-width="1.5"
    ></path>
    <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="1.5"></path>
    </svg></a>';
    
    
    
    $btns = '<div class="flex gap-4 items-center">'.$viewButton.'</div>';
    $date = \Carbon\Carbon::parse($r->p_date)->format('d-m-Y');
    $ref_no ='<a style="color:#1212c1;" href="'. route('purchase_invoice_white_view', $r->id) .'">'.$r->ref_no.'</a>';
    
        $data[] = array(
            $slno,
            $date,
            $ref_no,
            $r->p_i_no,
            $r->supplier_name,
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
}
