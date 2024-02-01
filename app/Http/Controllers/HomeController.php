<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use App\Models\PurchaseInvoice AS pi ;
use App\Models\SalesInvoice AS si ;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use NumberToWords\NumberToWords;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Illuminate\Session\Middleware\StartSession');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = Auth::user()->role;
        $currentDateTime = date('Y-m-d H:i:s');
        Session::put('login_date_time', $currentDateTime);
         if($role == 'superadmin'){
           
            return view('superadmin.home');
         }
         else if($role == 'admin'){
            $pi_lists =  DB::table('purchase_invoices')
            ->select('purchase_invoices.*','currencies.code','account_ledgers.ledger','suppliers.supplier_name')
            ->join('currencies', 'purchase_invoices.currency_id', '=', 'currencies.id')
            ->join('account_ledgers','purchase_invoices.purchase_account_id','=','account_ledgers.id')
            ->join('suppliers', 'purchase_invoices.supplier_id', '=', 'suppliers.ledger_id')
            ->where("purchase_invoices.delete_status", "=", 0)
            ->where("purchase_invoices.company_id", "=", Session::get('company_id'))
            ->orderBy("purchase_invoices.id","desc")
            ->take(6) 
            ->get();
            $si_lists =  DB::table('sales_invoices')
            ->select('sales_invoices.*','currencies.code','account_ledgers.ledger','customers.customer_name')
            ->join('currencies', 'sales_invoices.currency_id', '=', 'currencies.id')
            ->join('account_ledgers','sales_invoices.sales_account_id','=','account_ledgers.id')
            ->join('customers', 'sales_invoices.customer_id', '=', 'customers.ledger_id')
            ->where("sales_invoices.delete_status", "=", 0)
            ->orderBy("sales_invoices.id","desc")
            ->where("sales_invoices.company_id", "=", Session::get('company_id'))
            ->take(6) 
            ->get();

            $pending_order_count = DB::table('measurements')
            ->select('measurements.id')
            ->where("measurements.delete_status", "=", 0)
            ->where("measurements.company_id", "=", Session::get('company_id'))
            ->where("measurements.status", "=", 'Pending')
            ->count();

            $pening_order_dates = DB::table('measurements')
            ->select(DB::raw('MIN(order_date) as start_order_date'), DB::raw('MAX(order_date) as end_order_date'))
            ->where("delete_status", "=", 0)
            ->where("company_id", "=", Session::get('company_id'))
            ->first();

            $confirmed_order_count =  DB::table('measurements')
            ->select('measurements.id')
            ->where("measurements.delete_status", "=", 0)
            ->where("measurements.company_id", "=", Session::get('company_id'))
            ->where("measurements.status", "=", 'Confirmed')
            ->count();

            $assigned_order_count =  DB::table('measurements')
            ->select('measurements.*','measurement_items.id as mitems_id',)
            ->leftjoin('measurement_items', 'measurements.id', '=', 'measurement_items.m_id')
            ->where("measurements.delete_status", "=", 0)
            ->where("measurements.company_id", "=", Session::get('company_id'))
            ->where("measurements.status", "=", 'Confirmed')
            ->where("measurement_items.production_status", "=", 'Assigned')
            ->count();

            $completed_order_count =  DB::table('measurements')
            ->select('measurements.*','measurement_items.id as mitems_id',)
            ->leftjoin('measurement_items', 'measurements.id', '=', 'measurement_items.m_id')
            ->where("measurements.delete_status", "=", 0)
            ->where("measurements.company_id", "=", Session::get('company_id'))
            ->where("measurements.status", "=", 'Confirmed')
            ->where("measurement_items.production_status", "=", 'Production Completed')
            ->count();

    

            
          
            $data = [
               'pi_lists' => $pi_lists,
               'si_lists' => $si_lists,
               'pending_order_count' => $pending_order_count,
               'pening_order_dates' => $pening_order_dates,
               'confirmed_order_count' => $confirmed_order_count,
               'assigned_order_count' => $assigned_order_count,
               'completed_order_count' => $completed_order_count
           ];

           return view('admin.home', $data)->with(['no' => 1, 'slno' => 1]);
           
         }
         else if($role == 'Fitting'){
           
            return view('fitting.home');
         }
         else if($role == 'Packing'){
           
            return view('packing.home');
         }
         else if($role == 'Executive'){
           
            return view('executive.home');
         }
         else if($role == 'Account'){
           
            return view('accounts.home');
         }
         else if($role == 'Production'){
            return view('production.home');
         }
         else if($role == 'White'){
            return view('white.home');
         }
         else if($role == 'Confirmation'){
            return view('confirmation.home');
         }
    }
}
