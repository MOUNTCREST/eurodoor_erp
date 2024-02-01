<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockTransfer AS stfr ;
use App\Models\Product AS pct ;
use App\Models\Warehouse AS whs ;
use App\Models\Account AS acnt ;
use App\Models\AccountTransaction AS acntrn ;
use App\Models\Stock AS stk ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockTransfer extends Controller
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
        $st_data =  DB::table('stock_transfers')
        ->select('stock_transfers.id','stock_transfers.st_date','stock_transfers.ref_no','stock_transfers.qty','stock_transfers.remarks','products.product_name','warehouses.warehouse_name')
        ->join('products','stock_transfers.item_id','=','products.id')
        ->join('warehouses','stock_transfers.from_warehouse_id','=','warehouses.id')
        ->where("stock_transfers.delete_status", "=", 0)
        ->where("stock_transfers.company_id", "=", Session::get('company_id'))
        ->get();
		
		$data = ['st_data'=> $st_data];
		return view('admin.accounts.stocktransfer.index',$data)->with('no', 1);
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

        $data_stk =  DB::table('stock_transfers')
        ->select('stock_transfers.id')
        ->where("stock_transfers.company_id", "=", Session::get('company_id'))
        ->get();
    

         if(empty($data_stk)){
            $num = 0;
         }
         else{
            $num = DB::table('stock_transfers')
                ->where('company_id', '=', Session::get('company_id'))
                ->count();
         }
         $rf_n = $num + 1;
         $ref_no = str_pad($rf_n, 4, '0', STR_PAD_LEFT);
         $r_no = "ST-".$ref_no;


        $data = ['pt_lists'=> $pt_lists,'ws_lists' => $ws_lists,'r_no' => $r_no];
        return view('admin.accounts.stocktransfer.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $st_date=  date('Y-m-d', strtotime(request('st_date')));

        $stfrs = new stfr();
        $stfrs->st_date = request('st_date');
        $stfrs->ref_no = request('ref_no');
        $stfrs->item_id = request('item_id');
        $stfrs->from_warehouse_id =  request('from_warehouse_id');
        $stfrs->to_warehouse_id =  request('to_warehouse_id');
        $stfrs->qty =  request('qty');
        $stfrs->remarks =  request('remarks');
        $stfrs->created_by =  Auth::user()->id;
        $stfrs->company_id = Session::get('company_id');
        $stfrs->save();
        $st_id = $stfrs->id;

        $product_data = pct::where('id',request('item_id'))->first();

        $stks = new stk();
        $stks->date = request('st_date');
        $stks->ref_no = request('ref_no');
        $stks->item_id = request('item_id');
        $stks->item_category_id = $product_data->category_id;
        $stks->item_unit_id = $product_data->unit_id;
        $stks->qty =  request('qty');
        $stks->type =  'sales';
        $stks->st_id =  $st_id;
        $stks->warehouse_id =  request('from_warehouse_id');
        $stks->created_by =  Auth::user()->id;
        $stks->company_id = Session::get('company_id');
        $stks->save();

        $stkp = new stk();
        $stkp->date = request('st_date');
        $stkp->ref_no = request('ref_no');
        $stkp->item_id = request('item_id');
        $stkp->item_category_id = $product_data->category_id;
        $stkp->item_unit_id = $product_data->unit_id;
        $stkp->qty =  request('qty');
        $stkp->type =  'purchase';
        $stkp->st_id =  $st_id;
        $stkp->warehouse_id =  request('to_warehouse_id');
        $stkp->created_by =  Auth::user()->id;
        $stkp->company_id = Session::get('company_id');
        $stkp->save();

        return redirect(route('stock_transfer_list'));

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
    public function edit(stfr $id)
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

        $result =$id;
        return view('admin.accounts.stocktransfer.edit',compact('result','pt_lists','ws_lists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $stfrs = stfr::find($id);
        $stfrs->st_date = request('st_date');
        $stfrs->ref_no = request('ref_no');
        $stfrs->item_id = request('item_id');
        $stfrs->from_warehouse_id =  request('from_warehouse_id');
        $stfrs->to_warehouse_id =  request('to_warehouse_id');
        $stfrs->qty =  request('qty');
        $stfrs->remarks =  request('remarks');
        $stfrs->created_by =  Auth::user()->id;
        $stfrs->company_id = Session::get('company_id');
        $stfrs->save();
        $st_id = $id;


        $res=stk::where('st_id',$id)->delete();

        $product_data = pct::where('id',request('item_id'))->first();

        $stks = new stk();
        $stks->date = request('st_date');
        $stks->ref_no = request('ref_no');
        $stks->item_id = request('item_id');
        $stks->item_category_id = $product_data->category_id;
        $stks->item_unit_id = $product_data->unit_id;
        $stks->qty =  request('qty');
        $stks->type =  'sales';
        $stks->st_id =  $st_id;
        $stks->warehouse_id =  request('from_warehouse_id');
        $stks->created_by =  Auth::user()->id;
        $stks->company_id = Session::get('company_id');
        $stks->save();

        $stkp = new stk();
        $stkp->date = request('st_date');
        $stkp->ref_no = request('ref_no');
        $stkp->item_id = request('item_id');
        $stkp->item_category_id = $product_data->category_id;
        $stkp->item_unit_id = $product_data->unit_id;
        $stkp->qty =  request('qty');
        $stkp->type =  'purchase';
        $stkp->st_id =  $st_id;
        $stkp->warehouse_id =  request('to_warehouse_id');
        $stkp->created_by =  Auth::user()->id;
        $stkp->company_id = Session::get('company_id');
        $stkp->save();

        return redirect(route('stock_transfer_list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stock_transfer_data = stfr::find($id);

        $stock_transfer_data->delete_status = 1;
		$stock_transfer_data->save();

        DB::table('stocks')
        ->where('st_id', $id)
        ->update(['delete_status' => 1]);

		return redirect(route('stock_transfer_list'));

    }
    public function get_avilable_stock(Request $request){
        $item_id = $request->item_id;
        $w_id = $request->w_id;
        $total =0;

        $p_qty = DB::table('stocks')
        ->where("company_id", "=", Session::get('company_id'))
        ->where("warehouse_id", "=", $w_id)
        ->where("item_id", "=", $item_id)
        ->where("type", "=", 'purchase')
        ->sum('qty');

        $s_qty = DB::table('stocks')
        ->where("company_id", "=", Session::get('company_id'))
        ->where("warehouse_id", "=", $w_id)
        ->where("item_id", "=", $item_id)
        ->where("type", "=", 'sales')
        ->sum('qty');
            
        if($p_qty > $s_qty){
			$total = $p_qty - $s_qty;
		}
		else{
			$total = $s_qty - $p_qty;
		}

        return response()->json($total);

    }
}
