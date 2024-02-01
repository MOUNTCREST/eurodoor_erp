<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doormodel AS dml ;
use App\Models\Dooritem AS dri;
use App\Models\Color AS clr ;
use App\Models\Unit AS ut ;
use App\Models\ProductCategory AS pct ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Dooritem extends Controller
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
        $di_lists =  DB::table('dooritems')
        ->select('dooritems.*','doormodels.model_name')
        ->join('doormodels','doormodels.id','=','dooritems.model_id')
        ->where("dooritems.delete_status", "=", 0)
        ->where("dooritems.company_id", "=", Session::get('company_id'))
        ->get();

		$data = ['di_lists'=> $di_lists];
		return view('admin.door_masters.door_item.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_dm =  DB::table('dooritems')
        ->select('dooritems.id')
        ->where("dooritems.company_id", "=", Session::get('company_id'))
        ->get();
    

         if(empty($data_dm)){
            $num = 0;
         }
         else{
            $num = DB::table('dooritems')
                ->where('company_id', '=', Session::get('company_id'))
                ->count();
         }
         $rf_n = $num + 1;
         $ref_no = str_pad($rf_n, 4, '0', STR_PAD_LEFT);
         $r_no = "DI-".$ref_no;
         $model_list =  DB::table('doormodels')
         ->select('doormodels.*')
         ->where("doormodels.company_id", "=", Session::get('company_id'))
         ->where("doormodels.delete_status", "=", 0)
         ->get();


         $data = ['r_no' => $r_no,'model_list' => $model_list];
        return view('admin.door_masters.door_item.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       

        $unit_id = ut::where('unit_name', 'Nos')->first()->id;
        $category_id = pct::where('category_name', 'DOOR')->first()->id;


        DB::transaction(function () use ($unit_id,$category_id) {
            $lastInsertedId = DB::connection('mysql')->table('dooritems')->insertGetId([
                'model_id' => request('model_id'),
                'item_name' => request('item_name'),
                'ref_no' => request('ref_no'),
                'color_type' => request('color_type'),
                'color_id' => request('color_id'),
                'paint_qty_color_1' => request('paint_qty_color_1'),
                'paint_qty_color_2' => request('paint_qty_color_2'),
                'paint_qty_color_3' => request('paint_qty_color_3'),
                'created_by' => Auth::user()->id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        
            DB::connection('mysql_second')->table('dooritems')->insert([
                'model_id' =>  request('model_id'),
                'item_name' =>  request('item_name'),
                'ref_no' =>  request('ref_no'),
                'color_type' =>  request('color_type'),
                'color_id' =>  request('color_id'),
                
                'paint_qty_color_1' =>  request('paint_qty_color_1'),
                'paint_qty_color_2' =>  request('paint_qty_color_2'),
                'paint_qty_color_3' =>  request('paint_qty_color_3'),
                'created_by' =>  Auth::user()->id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);

            DB::connection('mysql')->table('products')->insert([
                'product_name' =>  request('item_name'),
                'unit_id' =>  $unit_id,
                'category_id' =>  $category_id,
                'barcode' =>  request('ref_no'),
                'qty' =>  0,
                'door_item_id'=> $lastInsertedId,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);

            DB::connection('mysql_second')->table('products')->insert([
                'product_name' =>  request('item_name'),
                'unit_id' =>  $unit_id,
                'category_id' =>  $category_id,
                'barcode' =>  request('ref_no'),
                'qty' =>  0,
                'door_item_id'=> $lastInsertedId,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        });


        return redirect(route('door_item_list'));
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
    public function edit(dri $id)
    {
       
        $color_lists =  DB::table('colors')
        ->select('colors.*', 'color_name_products.product_name as s_c_p_name', 'combo_color_products.product_name as c_c_p_name', 'triple_color_products.product_name as t_c_p_name')
        ->leftJoin('products as color_name_products', 'colors.color_name_product_id', '=', 'color_name_products.id')
        ->leftJoin('products as combo_color_products', 'colors.combo_color_name_product_id', '=', 'combo_color_products.id')
        ->leftJoin('products as triple_color_products', 'colors.triple_color_name_product_id', '=', 'triple_color_products.id')
        ->where("colors.delete_status", "=", 0)
        ->where("colors.company_id", "=", Session::get('company_id'))
        ->get();
        $result = $id;
        $model_list =  DB::table('doormodels')
        ->select('doormodels.*')
        ->where("doormodels.company_id", "=", Session::get('company_id'))
        ->where("doormodels.delete_status", "=", 0)
        ->get();
        return view('admin.door_masters.door_item.edit',compact('result','color_lists','model_list'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
      

          // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('dooritems')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('dooritems')->where('id', $id)
        ->update([
            'model_id' =>  request('model_id'),
            'item_name' =>  request('item_name'),
            'ref_no' =>  request('ref_no'),
            'color_type' =>  request('color_type'),
            'color_id' =>  request('color_id'),
            
            'paint_qty_color_1' =>  request('paint_qty_color_1'),
            'paint_qty_color_2' =>  request('paint_qty_color_2'),
            'paint_qty_color_3' =>  request('paint_qty_color_3'),
            'edited_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('dooritems')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('dooritems')->where('id', $id)
        ->update([
            'model_id' =>  request('model_id'),
            'item_name' =>  request('item_name'),
            'ref_no' =>  request('ref_no'),
            'color_type' =>  request('color_type'),
            'color_id' =>  request('color_id'),
            
            'paint_qty_color_1' =>  request('paint_qty_color_1'),
            'paint_qty_color_2' =>  request('paint_qty_color_2'),
            'paint_qty_color_3' =>  request('paint_qty_color_3'),
            'edited_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);

        DB::connection('mysql')->table('products')->where('door_item_id', $id)
        ->update([
                'product_name' =>  request('item_name'),
              
                'barcode' =>  request('ref_no'),
                'company_id' => Session::get('company_id'),
                'updated_at' => DB::raw('NOW()'),
        ]);

        DB::connection('mysql_second')->table('products')->where('door_item_id', $id)
        ->update([
                'product_name' =>  request('item_name'),
                
                'barcode' =>  request('ref_no'),
                'company_id' => Session::get('company_id'),
                'updated_at' => DB::raw('NOW()'),
        ]);

        return redirect(route('door_item_list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record1 = DB::connection('mysql')->table('dooritems')->where('id', $id)->first();

        // Update the record with the new data
        DB::connection('mysql')->table('dooritems')->where('id', $id)
            ->update([
                'delete_status' => 1,
                'deleted_by' =>  Auth::user()->id,
                'updated_at' => DB::raw('NOW()'),
            ]);
    
        // Find the record to update in database2
        $record2 = DB::connection('mysql_second')->table('dooritems')->where('id', $id)->first();
    
        // Update the record with the new data
        DB::connection('mysql_second')->table('dooritems')->where('id', $id)
            ->update([
                'delete_status' => 1,
                'deleted_by' =>  Auth::user()->id,
                'updated_at' => DB::raw('NOW()'),
            ]);
    
            return redirect(route('door_item_list'));
    }
    public function get_color_list(Request $request){
        $color_type = $request->color_type;

        $color_list =  DB::table('colors')
        ->select('colors.*', 'color_name_products.product_name as color_name', 'combo_color_products.product_name as combo_color_name', 'triple_color_products.product_name as triple_color_name')
        ->leftJoin('products as color_name_products', 'colors.color_name_product_id', '=', 'color_name_products.id')
        ->leftJoin('products as combo_color_products', 'colors.combo_color_name_product_id', '=', 'combo_color_products.id')
        ->leftJoin('products as triple_color_products', 'colors.triple_color_name_product_id', '=', 'triple_color_products.id')
        ->where("colors.delete_status", "=", 0)
        ->where("colors.company_id", "=", Session::get('company_id'))
        ->where("colors.color_type", "=", $color_type)
        ->get();



        return response()->json(['color_list' =>$color_list]);
    }
}
