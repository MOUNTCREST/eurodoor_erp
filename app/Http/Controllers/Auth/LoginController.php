<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use App\Models\Loginfo AS linfo ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User AS usr ;
use App\Models\Company AS comp ;
use App\Models\PurchaseInvoice AS pi ;
use App\Models\SalesInvoice AS si ;
use Stevebauman\Location\Facades\Location;

use NumberToWords\NumberToWords;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function logout(){
        $login_date_time = Session::get('login_date_time');
        $logout_date_time = date('Y-m-d H:i:s');
        $role = Auth::user()->role;
        $user_id = Auth::user()->id;
        $clientIP = \Request::ip(); 

         // Get location information based on IP address
         $locationData = Location::get($clientIP);
         $location = ($locationData && $locationData->city) ? $locationData->city : '-';

        $linfo = new linfo();
            $linfo->login_date_time = $login_date_time;
            $linfo->logout_date_time = $logout_date_time;
            $linfo->role = $role;
            $linfo->user_id = $user_id;
            $linfo->location = $location;
            $linfo->ipaddress = $clientIP;
            
            
            $linfo->save();
            Session::flush();
            Auth::logout();

            return redirect('/login');;

    }
    public function check_values(Request $request){
        $email = $request->email;
        $password = $request->password;

        $user = usr::where('email', '=', $email)->first();
        if(Hash::check($password, $user->password))
        {
            $role = $user->role;
             if($role == 'admin'){
                $lists = DB::table('company_admin_privillages')
                ->select('companies.id','companies.company_name')
                ->join('companies','company_admin_privillages.company_id','=','companies.id')
                ->where('company_admin_privillages.admin_id', '=', $user->id)
                ->get();
                return response()->json($lists);
             }
             else{
                $lists =array('superadmin');
                return response()->json($lists);
             }
        }
        else{
            $lists = array('Invalid');
            return response()->json($lists);
        }

      
    }
    public function authenticated(Request $request, $user)
    {
        // Save the company ID to the session
     //   session(['company_id' => $request->input('company_id')]);



     $record1 = DB::connection('mysql')->table('companies')->first();
     session(['company_id' => $record1->id]);
    
        // Redirect the user to the home page
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

