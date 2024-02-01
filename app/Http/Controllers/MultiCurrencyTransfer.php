<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MultiCurrencyTransfer AS mct ;
use App\Models\AccountLedger AS agl ;
use App\Models\Currency AS crny ;
use App\Models\Account AS acnt ;
use App\Models\AccountTransaction AS acntrn ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MultiCurrencyTransfer extends Controller
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
        $mct_lists =  DB::table('multi_currency_transfers')
        ->select('multi_currency_transfers.*','accounts.t_no','from_currency.code as from_currency_code','to_currency.code as to_currency_code','dr_account_ledger.ledger as account_dr','cr_account_ledger.ledger as account_cr')
        ->join('account_ledgers', function ($join) {
            $join->on('multi_currency_transfers.account_cr', '=', 'account_ledgers.id')
                 ->orWhere('multi_currency_transfers.account_dr', '=', 'account_ledgers.id');
        })
        ->join('account_ledgers as dr_account_ledger', 'multi_currency_transfers.account_dr', '=', 'dr_account_ledger.id')
        ->join('account_ledgers as cr_account_ledger', 'multi_currency_transfers.account_cr', '=', 'cr_account_ledger.id')
        ->join('currencies as from_currency', 'multi_currency_transfers.from_currency', '=', 'from_currency.id')
        ->join('currencies as to_currency', 'multi_currency_transfers.to_currency', '=', 'to_currency.id')
        ->join('accounts','multi_currency_transfers.account_id','=','accounts.id')
        ->where("multi_currency_transfers.delete_status", "=", 0)
        ->where("multi_currency_transfers.company_id", "=", Session::get('company_id'))
        ->get();

        
		
		$data = ['mct_lists'=> $mct_lists];
		return view('admin.mct.index',$data)->with('no', 1);  
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lg_lists =  DB::table('account_ledgers')
        ->select('account_ledgers.id','account_ledgers.ledger')
        ->where("account_ledgers.account_group_name", "!=", "Bank")
        ->where("account_ledgers.ledger", "!=", "LOCAL PURCHASE")
        ->where("account_ledgers.ledger", "!=", "LOCAL SALES")
        ->where("account_ledgers.ledger", "!=", "Opening Stock")
        ->where("account_ledgers.ledger", "!=", "CURRENCY CONVERTER")
        ->where("account_ledgers.delete_status", "=", 0)
        ->where("account_ledgers.company_id", "=", Session::get('company_id'))
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


        $data_mct =  DB::table('multi_currency_transfers')
        ->select('multi_currency_transfers.id')
        ->where("multi_currency_transfers.company_id", "=", Session::get('company_id'))
        ->get();
    

         if(empty($data_mct)){
            $num = 0;
         }
         else{
            $num = DB::table('multi_currency_transfers')
                ->where('company_id', '=', Session::get('company_id'))
                ->count();
         }
         $rf_n = $num + 1;
         $ref_no = str_pad($rf_n, 4, '0', STR_PAD_LEFT);
         $r_no = "MCT-".$ref_no;


        $data = ['lg_lists'=> $lg_lists,'currency_lists' => $currency_lists,'r_no' => $r_no,'c_balance' => $c_balance];
        return view('admin.mct.create',$data); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // $acnts = new acnt();

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
 
          
 
      //   $acnts->t_date = request('date');
      //   $acnts->t_no = $t_no;
      //   $acnts->type = 'mct';
      //   $acnts->currency_id =  request('to_currency');
      //   $acnts->amount =  request('to_amount');
      //   $acnts->narration =  request('narration');
      //   $acnts->created_by =  Auth::user()->id;
      //   $acnts->company_id = Session::get('company_id');
      //   $acnts->save();
      //   $account_id = $acnts->id;



        $account_id = DB::connection('mysql')->table('accounts')->insertGetId([
         't_date' =>  request('date'),
         't_no' =>  $t_no,
         'type' =>  'mct',
         'currency_id' =>  request('to_currency'),
         'amount' =>  request('to_amount'),
         'narration' =>  request('narration'),
         'created_by' =>  Auth::user()->id,
         'company_id' => Session::get('company_id'),
         'created_at' => DB::raw('NOW()'),
         'updated_at' => DB::raw('NOW()'),
     ]);
     
     DB::connection('mysql_second')->table('accounts')->insert([
         't_date' =>  request('date'),
         't_no' =>  $t_no,
         'type' =>  'mct',
         'currency_id' =>  request('to_currency'),
         'amount' =>  request('to_amount'),
         'narration' =>  request('narration'),
         'created_by' =>  Auth::user()->id,
         'company_id' => Session::get('company_id'),
         'created_at' => DB::raw('NOW()'),
         'updated_at' => DB::raw('NOW()'),
     ]);



        $a_l_data = agl::where('ledger', 'CURRENCY CONVERTER')->first();
        $ledger_id_of_mct = $a_l_data->id;

        DB::transaction(function () use ($account_id, $ledger_id_of_mct) {
         DB::connection('mysql')->table('account_transactions')->insert([
            'added_date' =>  request('date'),
            'account_id' => $account_id,
            'ledger_id' =>  request('account_dr'),
            'type' =>  'cr',
            'currency_id' =>request('from_currency'),
            'amount' =>  request('from_amount'),
            'narration' =>  request('narration'),
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
         ]);
 
         DB::connection('mysql')->table('account_transactions')->insert([
             'added_date' =>  request('date'),
             'account_id' => $account_id,
             'ledger_id' =>  request('account_cr'),
             'type' =>  'dr',
             'currency_id' =>request('to_currency'),
             'amount' =>  request('to_amount'),
             'narration' =>  request('narration'),
             'company_id' => Session::get('company_id'),
             'created_at' => DB::raw('NOW()'),
             'updated_at' => DB::raw('NOW()'),
         ]);

         DB::connection('mysql')->table('account_transactions')->insert([
            'added_date' =>  request('date'),
            'account_id' => $account_id,
            'ledger_id' =>  $ledger_id_of_mct,
            'type' =>  'cr',
            'currency_id' =>request('from_currency'),
            'amount' =>  request('from_amount'),
            'narration' =>  request('narration'),
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
         ]);
 
         DB::connection('mysql')->table('account_transactions')->insert([
             'added_date' =>  request('date'),
             'account_id' => $account_id,
             'ledger_id' =>  $ledger_id_of_mct,
             'type' =>  'dr',
             'currency_id' =>request('to_currency'),
             'amount' =>  request('to_amount'),
             'narration' =>  request('narration'),
             'company_id' => Session::get('company_id'),
             'created_at' => DB::raw('NOW()'),
             'updated_at' => DB::raw('NOW()'),
         ]);

         DB::connection('mysql_second')->table('account_transactions')->insert([
            'added_date' =>  request('date'),
            'account_id' => $account_id,
            'ledger_id' =>  request('account_dr'),
            'type' =>  'cr',
            'currency_id' =>request('from_currency'),
            'amount' =>  request('from_amount'),
            'narration' =>  request('narration'),
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
         ]);
 
         DB::connection('mysql_second')->table('account_transactions')->insert([
             'added_date' =>  request('date'),
             'account_id' => $account_id,
             'ledger_id' =>  request('account_cr'),
             'type' =>  'dr',
             'currency_id' =>request('to_currency'),
             'amount' =>  request('to_amount'),
             'narration' =>  request('narration'),
             'company_id' => Session::get('company_id'),
             'created_at' => DB::raw('NOW()'),
             'updated_at' => DB::raw('NOW()'),
         ]);

         DB::connection('mysql_second')->table('account_transactions')->insert([
            'added_date' =>  request('date'),
            'account_id' => $account_id,
            'ledger_id' =>  $ledger_id_of_mct,
            'type' =>  'cr',
            'currency_id' =>request('from_currency'),
            'amount' =>  request('from_amount'),
            'narration' =>  request('narration'),
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
         ]);
 
         DB::connection('mysql_second')->table('account_transactions')->insert([
             'added_date' =>  request('date'),
             'account_id' => $account_id,
             'ledger_id' =>  $ledger_id_of_mct,
             'type' =>  'dr',
             'currency_id' =>request('to_currency'),
             'amount' =>  request('to_amount'),
             'narration' =>  request('narration'),
             'company_id' => Session::get('company_id'),
             'created_at' => DB::raw('NOW()'),
             'updated_at' => DB::raw('NOW()'),
         ]);


         DB::connection('mysql')->table('multi_currency_transfers')->insert([
             'reference_no' =>  request('reference_no'),
             'date' => request('date'),
             'account_cr' =>  request('account_cr'),
             'account_dr' =>  request('account_dr'),
             'current_rate' =>request('current_rate'),
             'from_currency' =>  request('from_currency'),
             'from_amount' =>  request('from_amount'),
             'to_currency' =>  request('to_currency'),
             'to_amount' =>  request('to_amount'),
             'm_d_type' =>  request('m_d_type'),
             'narration' =>  request('narration'),
             'account_id' =>  $account_id,
             'company_id' => Session::get('company_id'),
             'created_at' => DB::raw('NOW()'),
             'updated_at' => DB::raw('NOW()'),
         ]);
 
         DB::connection('mysql_second')->table('multi_currency_transfers')->insert([
             'reference_no' =>  request('reference_no'),
             'date' => request('date'),
             'account_cr' =>  request('account_cr'),
             'account_dr' =>  request('account_dr'),
             'current_rate' =>request('current_rate'),
             'from_currency' =>  request('from_currency'),
             'from_amount' =>  request('from_amount'),
             'to_currency' =>  request('to_currency'),
             'to_amount' =>  request('to_amount'),
             'm_d_type' =>  request('m_d_type'),
             'narration' =>  request('narration'),
             'account_id' =>  $account_id,
             'company_id' => Session::get('company_id'),
             'created_at' => DB::raw('NOW()'),
             'updated_at' => DB::raw('NOW()'),
         ]);

     });

      //   $acntrnt1 = new acntrn();

      //   $acntrnt1->added_date = request('date');
      //   $acntrnt1->account_id = $account_id;
      //   $acntrnt1->ledger_id = request('account_dr');
      //   $acntrnt1->type = 'cr';
      //   $acntrnt1->currency_id =  request('from_currency');
      //   $acntrnt1->amount =  request('from_amount');
      //   $acntrnt1->narration =  request('narration');
      //   $acntrnt1->company_id = Session::get('company_id');
      //   $acntrnt1->save();

      //   $acntrnt2 = new acntrn();

      //   $acntrnt2->added_date = request('date');
      //   $acntrnt2->account_id = $account_id;
      //   $acntrnt2->ledger_id = request('account_cr');
      //   $acntrnt2->type = 'dr';
      //   $acntrnt2->currency_id =  request('to_currency');
      //   $acntrnt2->amount =  request('to_amount');
      //   $acntrnt2->narration =  request('narration');
      //   $acntrnt2->company_id = Session::get('company_id');
      //   $acntrnt2->save();

      //   $acntrnt3 = new acntrn();

      //   $acntrnt3->added_date = request('date');
      //   $acntrnt3->account_id = $account_id;
      //   $acntrnt3->ledger_id = $ledger_id_of_mct;
      //   $acntrnt3->type = 'cr';
      //   $acntrnt3->currency_id =  request('from_currency');
      //   $acntrnt3->amount =  request('from_amount');
      //   $acntrnt3->narration =  request('narration');
      //   $acntrnt3->company_id = Session::get('company_id');
      //   $acntrnt3->save();

      //   $acntrnt4 = new acntrn();

      //   $acntrnt4->added_date = request('date');
      //   $acntrnt4->account_id = $account_id;
      //   $acntrnt4->ledger_id = $ledger_id_of_mct;
      //   $acntrnt4->type = 'dr';
      //   $acntrnt4->currency_id =  request('to_currency');
      //   $acntrnt4->amount =  request('to_amount');
      //   $acntrnt4->narration =  request('narration');
      //   $acntrnt4->company_id = Session::get('company_id');
      //   $acntrnt4->save();

      //   $m_c_t = new mct();

      //   $m_c_t->reference_no = request('reference_no');
      //   $m_c_t->date = request('date');
      //   $m_c_t->account_cr = request('account_cr');
      //   $m_c_t->account_dr = request('account_dr');
      //   $m_c_t->current_rate = request('current_rate');
      //   $m_c_t->from_currency =  request('from_currency');
      //   $m_c_t->from_amount =  request('from_amount');
      //   $m_c_t->to_currency =  request('to_currency');
      //   $m_c_t->to_amount =  request('to_amount');
      //   $m_c_t->m_d_type = request('m_d_type');
      //   $m_c_t->narration =  request('narration');
      //   $m_c_t->account_id = $account_id;
      //   $m_c_t->company_id = Session::get('company_id');
      //   $m_c_t->save();

        return redirect(route('multi_currency_list'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = DB::table('multi_currency_transfers')
        ->select('multi_currency_transfers.*','accounts.t_no','accounts.t_date','accounts.narration','from_currency.code as from_currency_code','to_currency.code as to_currency_code','dr_account_ledger.ledger as account_dr','cr_account_ledger.ledger as account_cr')
        ->join('account_ledgers', function ($join) {
            $join->on('multi_currency_transfers.account_cr', '=', 'account_ledgers.id')
                 ->orWhere('multi_currency_transfers.account_dr', '=', 'account_ledgers.id');
        })
        ->join('account_ledgers as dr_account_ledger', 'multi_currency_transfers.account_dr', '=', 'dr_account_ledger.id')
        ->join('account_ledgers as cr_account_ledger', 'multi_currency_transfers.account_cr', '=', 'cr_account_ledger.id')
        ->join('currencies as from_currency', 'multi_currency_transfers.from_currency', '=', 'from_currency.id')
        ->join('currencies as to_currency', 'multi_currency_transfers.to_currency', '=', 'to_currency.id')
        ->join('accounts','multi_currency_transfers.account_id','=','accounts.id')
        ->where("multi_currency_transfers.delete_status", "=", 0)
        ->where("multi_currency_transfers.company_id", "=", Session::get('company_id'))
        ->where("multi_currency_transfers.id", "=", $id)
        ->first();

      $account_id = DB::table('multi_currency_transfers')
      ->where('id', $id)
      ->value('account_id');

      $t_details = DB::table('account_transactions')
      ->select('account_transactions.*','account_ledgers.ledger','currencies.code')
      ->join('account_ledgers','account_transactions.ledger_id','=','account_ledgers.id')
      ->join('currencies','account_transactions.currency_id','=','currencies.id')
      ->where("account_transactions.account_id", "=", $account_id)
      ->get();


      return view('admin.mct.view',compact('result','t_details'))->with('no', 1);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(mct $id)
    {
        $result = $id;
        $account_id = $result->account_id;
        $lg_lists =  DB::table('account_ledgers')
        ->select('account_ledgers.id','account_ledgers.ledger')
        ->where("account_ledgers.account_group_name", "!=", "Bank")
        ->where("account_ledgers.ledger", "!=", "LOCAL PURCHASE")
        ->where("account_ledgers.ledger", "!=", "LOCAL SALES")
        ->where("account_ledgers.ledger", "!=", "Opening Stock")
        ->where("account_ledgers.ledger", "!=", "CURRENCY CONVERTER")
        ->where("account_ledgers.delete_status", "=", 0)
        ->where("account_ledgers.company_id", "=", Session::get('company_id'))
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

        return view('admin.mct.edit',compact('result','lg_lists','currency_lists','c_balance'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

      // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('accounts')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('accounts')->where('id', $id)
        ->update([
         't_date' =>  request('date'),
         'type' =>  'mct',
         'currency_id' =>  request('to_currency'),
         'amount' =>  request('to_amount'),
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
         't_date' =>  request('date'),
         'type' =>  'mct',
         'currency_id' =>  request('to_currency'),
         'amount' =>  request('to_amount'),
         'narration' =>  request('narration'),
         'created_by' =>  Auth::user()->id,
         'company_id' => Session::get('company_id'),
         'updated_at' => DB::raw('NOW()'),
        ]);

        $account_id = $id;

         // Delete record from table1 in db1
       \DB::connection('mysql')->table('account_transactions')->where('account_id', $account_id)->delete();

       // Delete record from table2 in db2
       \DB::connection('mysql_second')->table('account_transactions')->where('account_id', $account_id)->delete();

       $a_l_data = agl::where('ledger', 'CURRENCY CONVERTER')->first();
        $ledger_id_of_mct = $a_l_data->id;

        DB::transaction(function () use ($account_id, $ledger_id_of_mct) {
         DB::connection('mysql')->table('account_transactions')->insert([
            'added_date' =>  request('date'),
            'account_id' => $account_id,
            'ledger_id' =>  request('account_dr'),
            'type' =>  'cr',
            'currency_id' =>request('from_currency'),
            'amount' =>  request('from_amount'),
            'narration' =>  request('narration'),
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
         ]);
 
         DB::connection('mysql')->table('account_transactions')->insert([
             'added_date' =>  request('date'),
             'account_id' => $account_id,
             'ledger_id' =>  request('account_cr'),
             'type' =>  'dr',
             'currency_id' =>request('to_currency'),
             'amount' =>  request('to_amount'),
             'narration' =>  request('narration'),
             'company_id' => Session::get('company_id'),
             'created_at' => DB::raw('NOW()'),
             'updated_at' => DB::raw('NOW()'),
         ]);

         DB::connection('mysql')->table('account_transactions')->insert([
            'added_date' =>  request('date'),
            'account_id' => $account_id,
            'ledger_id' =>  $ledger_id_of_mct,
            'type' =>  'cr',
            'currency_id' =>request('from_currency'),
            'amount' =>  request('from_amount'),
            'narration' =>  request('narration'),
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
         ]);
 
         DB::connection('mysql')->table('account_transactions')->insert([
             'added_date' =>  request('date'),
             'account_id' => $account_id,
             'ledger_id' =>  $ledger_id_of_mct,
             'type' =>  'dr',
             'currency_id' =>request('to_currency'),
             'amount' =>  request('to_amount'),
             'narration' =>  request('narration'),
             'company_id' => Session::get('company_id'),
             'created_at' => DB::raw('NOW()'),
             'updated_at' => DB::raw('NOW()'),
         ]);

         DB::connection('mysql_second')->table('account_transactions')->insert([
            'added_date' =>  request('date'),
            'account_id' => $account_id,
            'ledger_id' =>  request('account_dr'),
            'type' =>  'cr',
            'currency_id' =>request('from_currency'),
            'amount' =>  request('from_amount'),
            'narration' =>  request('narration'),
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
         ]);
 
         DB::connection('mysql_second')->table('account_transactions')->insert([
             'added_date' =>  request('date'),
             'account_id' => $account_id,
             'ledger_id' =>  request('account_cr'),
             'type' =>  'dr',
             'currency_id' =>request('to_currency'),
             'amount' =>  request('to_amount'),
             'narration' =>  request('narration'),
             'company_id' => Session::get('company_id'),
             'created_at' => DB::raw('NOW()'),
             'updated_at' => DB::raw('NOW()'),
         ]);

         DB::connection('mysql_second')->table('account_transactions')->insert([
            'added_date' =>  request('date'),
            'account_id' => $account_id,
            'ledger_id' =>  $ledger_id_of_mct,
            'type' =>  'cr',
            'currency_id' =>request('from_currency'),
            'amount' =>  request('from_amount'),
            'narration' =>  request('narration'),
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
         ]);
 
         DB::connection('mysql_second')->table('account_transactions')->insert([
             'added_date' =>  request('date'),
             'account_id' => $account_id,
             'ledger_id' =>  $ledger_id_of_mct,
             'type' =>  'dr',
             'currency_id' =>request('to_currency'),
             'amount' =>  request('to_amount'),
             'narration' =>  request('narration'),
             'company_id' => Session::get('company_id'),
             'created_at' => DB::raw('NOW()'),
             'updated_at' => DB::raw('NOW()'),
         ]);

     });

      // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('multi_currency_transfers')->where('account_id', $account_id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('multi_currency_transfers')->where('account_id', $account_id)
        ->update([
         'reference_no' =>  request('reference_no'),
         'date' => request('date'),
         'account_cr' =>  request('account_cr'),
         'account_dr' =>  request('account_dr'),
         'current_rate' =>request('current_rate'),
         'from_currency' =>  request('from_currency'),
         'from_amount' =>  request('from_amount'),
         'to_currency' =>  request('to_currency'),
         'to_amount' =>  request('to_amount'),
         'm_d_type' =>  request('m_d_type'),
         'narration' =>  request('narration'),
         'account_id' =>  $account_id,
         'company_id' => Session::get('company_id'),
         'created_at' => DB::raw('NOW()'),
         'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('multi_currency_transfers')->where('account_id', $account_id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('multi_currency_transfers')->where('account_id', $id)
        ->update([
         'reference_no' =>  request('reference_no'),
         'date' => request('date'),
         'account_cr' =>  request('account_cr'),
         'account_dr' =>  request('account_dr'),
         'current_rate' =>request('current_rate'),
         'from_currency' =>  request('from_currency'),
         'from_amount' =>  request('from_amount'),
         'to_currency' =>  request('to_currency'),
         'to_amount' =>  request('to_amount'),
         'm_d_type' =>  request('m_d_type'),
         'narration' =>  request('narration'),
         'account_id' =>  $account_id,
         'company_id' => Session::get('company_id'),
         'created_at' => DB::raw('NOW()'),
         'updated_at' => DB::raw('NOW()'),
        ]);


      //  $acnts = acnt::find($id);
      //  $acnts->t_date = request('date');
      //  $acnts->currency_id =  request('to_currency');
      //  $acnts->amount =  request('to_amount');
      //  $acnts->narration =  request('narration');
      //  $acnts->created_by =  Auth::user()->id;
      //  $acnts->save();
      //  $account_id = $id;
    
      //   $res=acntrn::where('account_id',$id)->delete();

      //   $a_l_data = agl::where('ledger', 'CURRENCY CONVERTER')->first();
      //   $ledger_id_of_mct = $a_l_data->id;

      //   $acntrnt1 = new acntrn();

      //   $acntrnt1->added_date = request('date');
      //   $acntrnt1->account_id = $account_id;
      //   $acntrnt1->ledger_id = request('account_dr');
      //   $acntrnt1->type = 'cr';
      //   $acntrnt1->currency_id =  request('from_currency');
      //   $acntrnt1->amount =  request('from_amount');
      //   $acntrnt1->narration =  request('narration');
      //   $acntrnt1->company_id = Session::get('company_id');
      //   $acntrnt1->save();

      //   $acntrnt2 = new acntrn();

      //   $acntrnt2->added_date = request('date');
      //   $acntrnt2->account_id = $account_id;
      //   $acntrnt2->ledger_id = request('account_cr');
      //   $acntrnt2->type = 'dr';
      //   $acntrnt2->currency_id =  request('to_currency');
      //   $acntrnt2->amount =  request('to_amount');
      //   $acntrnt2->narration =  request('narration');
      //   $acntrnt2->company_id = Session::get('company_id');
      //   $acntrnt2->save();

      //   $acntrnt3 = new acntrn();

      //   $acntrnt3->added_date = request('date');
      //   $acntrnt3->account_id = $account_id;
      //   $acntrnt3->ledger_id = $ledger_id_of_mct;
      //   $acntrnt3->type = 'cr';
      //   $acntrnt3->currency_id =  request('from_currency');
      //   $acntrnt3->amount =  request('from_amount');
      //   $acntrnt3->narration =  request('narration');
      //   $acntrnt3->company_id = Session::get('company_id');
      //   $acntrnt3->save();

      //   $acntrnt4 = new acntrn();

      //   $acntrnt4->added_date = request('date');
      //   $acntrnt4->account_id = $account_id;
      //   $acntrnt4->ledger_id = $ledger_id_of_mct;
      //   $acntrnt4->type = 'dr';
      //   $acntrnt4->currency_id =  request('to_currency');
      //   $acntrnt4->amount =  request('to_amount');
      //   $acntrnt4->narration =  request('narration');
      //   $acntrnt4->company_id = Session::get('company_id');
      //   $acntrnt4->save();

      //   $m_c_t = mct::where('account_id',$account_id)->first();

      //   $m_c_t->reference_no = request('reference_no');
      //   $m_c_t->date = request('date');
      //   $m_c_t->account_cr = request('account_cr');
      //   $m_c_t->account_dr = request('account_dr');
      //   $m_c_t->current_rate = request('current_rate');
      //   $m_c_t->from_currency =  request('from_currency');
      //   $m_c_t->from_amount =  request('from_amount');
      //   $m_c_t->to_currency =  request('to_currency');
      //   $m_c_t->to_amount =  request('to_amount');
      //   $m_c_t->m_d_type = request('m_d_type');
      //   $m_c_t->narration =  request('narration');
      //   $m_c_t->account_id = $account_id;
      //   $m_c_t->company_id = Session::get('company_id');
      //   $m_c_t->save();

        return redirect(route('multi_currency_list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      //   $m_c_t = mct::find($id);

      //   $mct_data = mct::where('id', $id)->first();


      //   $m_c_t->delete_status = 1;
		// $m_c_t->save();

      //   $a_c = acnt::find($mct_data->account_id);
      //   $a_c->delete_status = 1;
		// $a_c->save();

      //   DB::table('account_transactions')
      //   ->where('account_id', $mct_data->account_id)
      //   ->update(['delete_status' => 1]);


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
  $record5 = DB::connection('mysql')->table('multi_currency_transfers')->where('account_id', $id)->first();

  // Update the record with the new data
  DB::connection('mysql')->table('multi_currency_transfers')->where('account_id', $id)
      ->update([
          'delete_status' => 1,
          'updated_at' => DB::raw('NOW()'),
      ]);

  // Find the record to update in database2
  $record6 = DB::connection('mysql_second')->table('multi_currency_transfers')->where('account_id', $id)->first();

  // Update the record with the new data
  DB::connection('mysql_second')->table('multi_currency_transfers')->where('account_id', $id)
      ->update([
          'delete_status' => 1,
          'updated_at' => DB::raw('NOW()'),
      ]);





		return redirect(route('multi_currency_list'));
    }
}
