<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Measurement AS msrmnt ;
use App\Models\Color AS clr ;
use App\Models\Doormodel AS dml ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Production extends Controller
{
    public function production_pending_list(){
        $root_lists =  DB::table('doorroots')
        ->select('doorroots.*')
        ->where("doorroots.delete_status", "=", 0)
        ->where("doorroots.company_id", "=", Session::get('company_id'))
        ->get();

        $mt_lists =  DB::table('measurements')
        ->select('measurements.*','measurement_items.id as mitems_id','measurement_items.order_type','measurement_items.batch_no','measurement_items.model_id','doormodels.id as door_model_id','doormodels.model_name','doorroots.root_name')
        ->leftjoin('measurement_items', 'measurements.id', '=', 'measurement_items.m_id')
        ->leftjoin('doormodels', 'measurement_items.model_id', '=', 'doormodels.id')
        ->leftjoin('doorroots', 'measurements.root_id', '=', 'doorroots.id')
        ->where("measurements.delete_status", "=", 0)
        ->where("measurements.company_id", "=", Session::get('company_id'))
        ->where("measurements.status", "=", 'Confirmed')
        ->where("measurement_items.production_status", "=", null)
        ->get();

        foreach ($mt_lists as $mt_list) {
            if($mt_list->model_id == 0 || $mt_list->model_id == null){
                $mt_list->status = "-";
            }
            else{
                $mt_list->status = msrmnt::find($mt_list->id)->check_status($mt_list->model_id);
            }
            
        }
		
		$data = ['mt_lists'=> $mt_lists,'root_lists' => $root_lists];
		return view('production.production_pending_list',$data)->with('no', 1); 
    
    }
    public function assigned_list(){
        $root_lists =  DB::table('doorroots')
        ->select('doorroots.*')
        ->where("doorroots.delete_status", "=", 0)
        ->where("doorroots.company_id", "=", Session::get('company_id'))
        ->get();

        $mt_lists =  DB::table('measurements')
        ->select('measurements.*','measurement_items.id as mitems_id','measurement_items.batch_no','measurement_items.model_id','doormodels.id as door_model_id','doormodels.model_name','doorroots.root_name')
        ->leftjoin('measurement_items', 'measurements.id', '=', 'measurement_items.m_id')
        ->leftjoin('doormodels', 'measurement_items.model_id', '=', 'doormodels.id')
        ->leftjoin('doorroots', 'measurements.root_id', '=', 'doorroots.id')
        ->where("measurements.delete_status", "=", 0)
        ->where("measurements.company_id", "=", Session::get('company_id'))
        ->where("measurements.status", "=", 'Confirmed')
        ->where("measurement_items.production_status", "=", 'Assigned')
        ->get();

        // foreach ($mt_lists as $mt_list) {
        //     $mt_list->status = msrmnt::find($mt_list->id)->check_status($mt_list->model_id);
        // }
		
		$data = ['mt_lists'=> $mt_lists,'root_lists' => $root_lists];
		return view('production.assigned_list',$data)->with('no', 1); 
    }
    public function get_assigned_list(Request $request){
        $f_date = trim($request->delivery_date);
        $t_date = trim($request->to_date);
        $start_date=  date('Y-m-d', strtotime($f_date));
        $end_date=  date('Y-m-d', strtotime($t_date));
        $root_id = $request->root_id;
        $fitting_or_packing = $request->fitting_or_packing;
        $mt_lists = DB::table('measurements')
    ->select('measurements.*', 'measurement_items.id as mitems_id', 'measurement_items.batch_no', 'measurement_items.model_id', 'doormodels.id as door_model_id', 'doormodels.model_name', 'doorroots.root_name')
    ->leftjoin('measurement_items', 'measurements.id', '=', 'measurement_items.m_id')
    ->leftjoin('doormodels', 'measurement_items.model_id', '=', 'doormodels.id')
    ->leftjoin('doorroots', 'measurements.root_id', '=', 'doorroots.id')
    ->where("measurements.delete_status", "=", 0)
    ->where("measurements.company_id", "=", Session::get('company_id'))
    ->where("measurements.status", "=", 'Confirmed')
    ->where("measurement_items.production_status", "=", 'Assigned')
    ->when($root_id !== null, function ($query) use ($root_id) {
        return $query->where("measurements.root_id", "=", $root_id);
    })
    ->when($fitting_or_packing !== null, function ($query) use ($fitting_or_packing) {
        return $query->where("measurements.fitting_or_packing", "=", $fitting_or_packing);
    })
    ->whereBetween("measurements.delivery_date", [$start_date, $end_date])
    ->get();
        


        
           $slno = 1;
           $user_arr = array();
           foreach($mt_lists as $value){
            $order_no = $value->order_no;
            $batch_no = $value->batch_no;
            $model_name = $value->model_name;
            $delivery_date = $value->delivery_date;
            $root_name = $value->root_name;
            $status = $value->status;
            $mitems_id = $value->mitems_id;
           

            $user_arr[] = array("$slno",$order_no,$batch_no,$model_name,$delivery_date,$root_name,$status,$mitems_id);
            $slno ++;
           }


          return response()->json($user_arr);

    }
    public function assigned_view( string $id ){
        $result =  DB::table('measurement_items')
        ->select('measurement_items.*')
        ->where("measurement_items.delete_status", "=", 0)
        ->where("measurement_items.id", "=", $id)
        ->where("measurement_items.company_id", "=", Session::get('company_id'))
        ->first();

        $model_id = $result->model_id;
        
        $door_model = dml::select("*")
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->where("id", "=", $model_id)
        ->first();

        $locations = DB::table('doordies')
        ->select('productionunits.id as p_id', 'productionunits.production_unit_name')
        ->join('productionunits', 'doordies.location_id', '=', 'productionunits.id')
        ->where("doordies.model_id", "=", $model_id)
        ->distinct()
        ->get(); // Get all columns
    
    


        return view('production.production_status_assignment',compact('result','door_model','locations'));
    }
    public function get_list_of_die_front_no(Request $request){
        $model_id = $request->model_id;
        $location_id = $request->location_id;

        $die_front_no = DB::table('doordies')
        ->select('doordies.*')
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->where("model_id", "=", $model_id)
        ->where("location_id", "=", $location_id)
        ->where("die_side", "=", 'Front')
        ->where("die_status", "=", 'Active')
        ->get();

        return response()->json(['die_front_no' =>$die_front_no]);
    }
    public function get_list_of_die_back_no(Request $request){
        $model_id = $request->model_id;
        $location_id = $request->location_id;



        $result_model = DB::table('doormodels')
        ->select('doormodels.*')
        ->where('doormodels.id', '=', $model_id)
        ->where('doormodels.delete_status', '=', 0)
        ->first();

        $die_type = $result_model->die_type;

          if($die_type == 'BACK SAME DIE'){

          }
          else{
            $die_back_no = DB::table('doordies')
            ->select('doordies.*')
            ->where("company_id", "=", Session::get('company_id'))
            ->where("delete_status", "=", 0)
            ->where("location_id", "=", $location_id)
            ->where("die_side", "=", 'Back')
            ->where("die_status", "=", 'Active')
            ->get();
    
            return response()->json(['die_back_no' =>$die_back_no]);
          }


        
       
    }
    public function measurement_items_update(Request $request, string $id){

        $validatedData = $request->validate([
            'location_id' => 'required',
            'die_no_front' => 'required',
        ], [
            'location_id.required' => 'The Production Unit field is required.',
            'die_no_front.required' => 'The Die No Front field is required.',
        ]);

        $model_id = request('model_id');
        $production_unit_id = request('location_id');
        $die_no_front_id = request('die_no_front');
    

        if(request('die_no_back') == null){
            $die_no_back_id =0;
        }
        else{
            $die_no_back_id = request('die_no_back');
        }
       
        $data_item_resin = DB::table('products')
        ->select('products.*')
        ->where('product_name', 'RESIN')
        ->first();



        $data_m = DB::table('measurement_items')
        ->select('measurement_items.*')
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->where("id", "=", $id)
        ->first();
      

         $data_clr = DB::table('colors')
        ->select('colors.*')
        ->where("id", "=", $data_m->color_id)
        ->first();
        

        if($data_m->frame_color_id == 0){
            $dm_cat_id = 0;
            $dm_unit_id = 0;
            $dm_id = 0;
        }
else{
    $data_f_clr = DB::table('colors')
    ->select('colors.*')
    ->where("id", "=", $data_m->frame_color_id)
    ->first();



   


    $data_frame_color = DB::table('products')
    ->select('products.*')
    ->where("id", "=", $data_f_clr->color_name_product_id)
    ->first(); 

    $dm_cat_id = $data_frame_color->category_id;
    $dm_unit_id = $data_frame_color->unit_id;
    $dm_id = $data_frame_color->id;
}

        if($data_m->frame_paint_qty == 0){
            $frame_paint_qty =0;
        }
        else{
            $frame_paint_qty = $data_m->frame_paint_qty;
        }

        if($data_m->frame_resin_qty == 0){
            $frame_resin_qty =0;
        }
        else{
            $frame_resin_qty = $data_m->frame_resin_qty;
        }



         $door_paint_qty_1 = $data_m->door_paint_qty_1;
          $door_paint_qty_2 = $data_m->door_paint_qty_2;
           $door_paint_qty_3 = $data_m->door_paint_qty_3;
            
         $door_resin_qty = $data_m->door_resin_qty;
        



         if($data_clr->color_type == 'Single'){
            $data_color_1 = DB::table('products')
            ->select('products.*')
            ->where("id", "=", $data_clr->color_name_product_id)
            ->first();
    
            DB::connection('mysql')->table('stocks')->insert([
                'm_items_id' =>  $id,
                'date' => date("Y-m-d"),
                'ref_no' => $data_m->batch_no,
                'item_category_id' =>  $data_color_1->category_id,
                'item_unit_id' =>  $data_color_1->unit_id,
                'item_id' =>  $data_color_1->id,
                'qty' =>  $door_paint_qty_1,
                'type' => 'PRODUCTION',
                'narration' => 'Door Paint Qty',
                'company_id' => Session::get('company_id'),
                'created_by' =>  Auth::user()->id,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
    
           
        }
        else if($data_clr->color_type== 'Combo'){
            $data_color_1 = DB::table('products')
            ->select('products.*')
            ->where("id", "=", $data_clr->color_name_product_id)
            ->first();
    
            $data_color_2 = DB::table('products')
            ->select('products.*')
            ->where("id", "=", $data_clr->combo_color_name_product_id)
            ->first();
    
            DB::connection('mysql')->table('stocks')->insert([
                'm_items_id' =>  $id,
                'date' => date("Y-m-d"),
                'ref_no' => $data_m->batch_no,
                'item_category_id' =>  $data_color_1->category_id,
                'item_unit_id' =>  $data_color_1->unit_id,
                'item_id' =>  $data_color_1->id,
                'qty' =>  $door_paint_qty_1,
                'type' => 'PRODUCTION',
                'narration' => 'Door Paint Qty',
                'company_id' => Session::get('company_id'),
                'created_by' =>  Auth::user()->id,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
    
            DB::connection('mysql')->table('stocks')->insert([
                'm_items_id' =>  $id,
                'date' => date("Y-m-d"),
                'ref_no' => $data_m->batch_no,
                'item_category_id' =>  $data_color_2->category_id,
                'item_unit_id' =>  $data_color_2->unit_id,
                'item_id' =>  $data_color_2->id,
                'qty' =>  $door_paint_qty_2,
                'type' => 'PRODUCTION',
                'narration' => 'Door Paint Qty',
                'company_id' => Session::get('company_id'),
                'created_by' =>  Auth::user()->id,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
    
          
        }
        else{
            $data_color_1 = DB::table('products')
            ->select('products.*')
            ->where("id", "=", $data_clr->color_name_product_id)
            ->first();
    
            $data_color_2 = DB::table('products')
            ->select('products.*')
            ->where("id", "=", $data_clr->combo_color_name_product_id)
            ->first();
    
            $data_color_3 = DB::table('products')
            ->select('products.*')
            ->where("id", "=", $data_clr->triple_color_name_product_id)
            ->first();


            DB::connection('mysql')->table('stocks')->insert([
                'm_items_id' =>  $id,
                'date' => date("Y-m-d"),
                'ref_no' => $data_m->batch_no,
                'item_category_id' =>  $data_color_1->category_id,
                'item_unit_id' =>  $data_color_1->unit_id,
                'item_id' =>  $data_color_1->id,
                'qty' =>  $door_paint_qty_1,
                'type' => 'PRODUCTION',
                'narration' => 'Door Paint Qty',
                'company_id' => Session::get('company_id'),
                'created_by' =>  Auth::user()->id,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
    
            DB::connection('mysql')->table('stocks')->insert([
                'm_items_id' =>  $id,
                'date' => date("Y-m-d"),
                'ref_no' => $data_m->batch_no,
                'item_category_id' =>  $data_color_2->category_id,
                'item_unit_id' =>  $data_color_2->unit_id,
                'item_id' =>  $data_color_2->id,
                'qty' =>  $door_paint_qty_2,
                'type' => 'PRODUCTION',
                'narration' => 'Door Paint Qty',
                'company_id' => Session::get('company_id'),
                'created_by' =>  Auth::user()->id,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
    
            DB::connection('mysql')->table('stocks')->insert([
                'm_items_id' =>  $id,
                'date' => date("Y-m-d"),
                'ref_no' => $data_m->batch_no,
                'item_category_id' =>  $data_color_3->category_id,
                'item_unit_id' =>  $data_color_3->unit_id,
                'item_id' =>  $data_color_3->id,
                'qty' =>  $door_paint_qty_3,
                'type' => 'PRODUCTION',
                'narration' => 'Door Paint Qty',
                'company_id' => Session::get('company_id'),
                'created_by' =>  Auth::user()->id,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        }



        DB::connection('mysql')->table('stocks')->insert([
            'm_items_id' =>  $id,
            'date' => date("Y-m-d"),
            'ref_no' => $data_m->batch_no,
            'item_category_id' =>  $data_item_resin->category_id,
            'item_unit_id' =>  $data_item_resin->unit_id,
            'item_id' =>  $data_item_resin->id,
            'qty' =>  $door_resin_qty,
            'type' => 'PRODUCTION',
            'narration' => 'Door Resin Qty',
            'company_id' => Session::get('company_id'),
            'created_by' =>  Auth::user()->id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);
        DB::connection('mysql')->table('stocks')->insert([
            'm_items_id' =>  $id,
            'date' => date("Y-m-d"),
            'ref_no' => $data_m->batch_no,
            'item_category_id' =>  $data_item_resin->category_id,
            'item_unit_id' =>  $data_item_resin->unit_id,
            'item_id' =>  $data_item_resin->id,
            'qty' =>  $frame_resin_qty,
            'type' => 'PRODUCTION',
            'narration' => 'Frame Resin Qty',
            'company_id' => Session::get('company_id'),
            'created_by' =>  Auth::user()->id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);
        

        DB::connection('mysql')->table('stocks')->insert([
            'm_items_id' =>  $id,
            'date' => date("Y-m-d"),
            'ref_no' => $data_m->batch_no,
            'item_category_id' =>  $dm_cat_id,
            'item_unit_id' =>  $dm_unit_id,
            'item_id' =>  $dm_id,
            'qty' =>  $frame_paint_qty,
            'type' => 'PRODUCTION',
            'narration' => 'Frame Paint Qty',
            'company_id' => Session::get('company_id'),
            'created_by' =>  Auth::user()->id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);




        DB::connection('mysql_second')->table('stocks')->insert([
            'm_items_id' =>  $id,
            'date' => date("Y-m-d"),
            'ref_no' => $data_m->batch_no,
            'item_category_id' =>  $data_item_resin->category_id,
            'item_unit_id' =>  $data_item_resin->unit_id,
            'item_id' =>  $data_item_resin->id,
            'qty' =>  $door_resin_qty,
            'type' => 'PRODUCTION',
            'narration' => 'Door Resin Qty',
            'company_id' => Session::get('company_id'),
            'created_by' =>  Auth::user()->id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);
        DB::connection('mysql_second')->table('stocks')->insert([
            'm_items_id' =>  $id,
            'date' => date("Y-m-d"),
            'ref_no' => $data_m->batch_no,
            'item_category_id' =>  $data_item_resin->category_id,
            'item_unit_id' =>  $data_item_resin->unit_id,
            'item_id' =>  $data_item_resin->id,
            'qty' =>  $frame_resin_qty,
            'type' => 'PRODUCTION',
            'narration' => 'Frame Resin Qty',
            'company_id' => Session::get('company_id'),
            'created_by' =>  Auth::user()->id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);
        if($data_clr->color_type == 'Single'){
            $data_color_1 = DB::table('products')
            ->select('products.*')
            ->where("id", "=", $data_clr->color_name_product_id)
            ->first();
    
            DB::connection('mysql_second')->table('stocks')->insert([
                'm_items_id' =>  $id,
                'date' => date("Y-m-d"),
                'ref_no' => $data_m->batch_no,
                'item_category_id' =>  $data_color_1->category_id,
                'item_unit_id' =>  $data_color_1->unit_id,
                'item_id' =>  $data_color_1->id,
                'qty' =>  $door_paint_qty_1,
                'type' => 'PRODUCTION',
                'narration' => 'Door Paint Qty',
                'company_id' => Session::get('company_id'),
                'created_by' =>  Auth::user()->id,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
    
           
        }
        else if($data_clr->color_type== 'Combo'){
            $data_color_1 = DB::table('products')
            ->select('products.*')
            ->where("id", "=", $data_clr->color_name_product_id)
            ->first();
    
            $data_color_2 = DB::table('products')
            ->select('products.*')
            ->where("id", "=", $data_clr->combo_color_name_product_id)
            ->first();
    
            DB::connection('mysql_second')->table('stocks')->insert([
                'm_items_id' =>  $id,
                'date' => date("Y-m-d"),
                'ref_no' => $data_m->batch_no,
                'item_category_id' =>  $data_color_1->category_id,
                'item_unit_id' =>  $data_color_1->unit_id,
                'item_id' =>  $data_color_1->id,
                'qty' =>  $door_paint_qty_1,
                'type' => 'PRODUCTION',
                'narration' => 'Door Paint Qty',
                'company_id' => Session::get('company_id'),
                'created_by' =>  Auth::user()->id,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
    
            DB::connection('mysql_second')->table('stocks')->insert([
                'm_items_id' =>  $id,
                'date' => date("Y-m-d"),
                'ref_no' => $data_m->batch_no,
                'item_category_id' =>  $data_color_2->category_id,
                'item_unit_id' =>  $data_color_2->unit_id,
                'item_id' =>  $data_color_2->id,
                'qty' =>  $door_paint_qty_2,
                'type' => 'PRODUCTION',
                'narration' => 'Door Paint Qty',
                'company_id' => Session::get('company_id'),
                'created_by' =>  Auth::user()->id,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
    
          
        }
        else{
            $data_color_1 = DB::table('products')
            ->select('products.*')
            ->where("id", "=", $data_clr->color_name_product_id)
            ->first();
    
            $data_color_2 = DB::table('products')
            ->select('products.*')
            ->where("id", "=", $data_clr->combo_color_name_product_id)
            ->first();
    
            $data_color_3 = DB::table('products')
            ->select('products.*')
            ->where("id", "=", $data_clr->triple_color_name_product_id)
            ->first();


            DB::connection('mysql_second')->table('stocks')->insert([
                'm_items_id' =>  $id,
                'date' => date("Y-m-d"),
                'ref_no' => $data_m->batch_no,
                'item_category_id' =>  $data_color_1->category_id,
                'item_unit_id' =>  $data_color_1->unit_id,
                'item_id' =>  $data_color_1->id,
                'qty' =>  $door_paint_qty_1,
                'type' => 'PRODUCTION',
                'narration' => 'Door Paint Qty',
                'company_id' => Session::get('company_id'),
                'created_by' =>  Auth::user()->id,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
    
            DB::connection('mysql_second')->table('stocks')->insert([
                'm_items_id' =>  $id,
                'date' => date("Y-m-d"),
                'ref_no' => $data_m->batch_no,
                'item_category_id' =>  $data_color_2->category_id,
                'item_unit_id' =>  $data_color_2->unit_id,
                'item_id' =>  $data_color_2->id,
                'qty' =>  $door_paint_qty_2,
                'type' => 'PRODUCTION',
                'narration' => 'Door Paint Qty',
                'company_id' => Session::get('company_id'),
                'created_by' =>  Auth::user()->id,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
    
            DB::connection('mysql_second')->table('stocks')->insert([
                'm_items_id' =>  $id,
                'date' => date("Y-m-d"),
                'ref_no' => $data_m->batch_no,
                'item_category_id' =>  $data_color_3->category_id,
                'item_unit_id' =>  $data_color_3->unit_id,
                'item_id' =>  $data_color_3->id,
                'qty' =>  $door_paint_qty_3,
                'type' => 'PRODUCTION',
                'narration' => 'Door Paint Qty',
                'company_id' => Session::get('company_id'),
                'created_by' =>  Auth::user()->id,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        }

        DB::connection('mysql_second')->table('stocks')->insert([
            'm_items_id' =>  $id,
            'date' => date("Y-m-d"),
            'ref_no' => $data_m->batch_no,
            'item_category_id' =>  $dm_cat_id,
            'item_unit_id' =>  $dm_unit_id,
            'item_id' =>  $dm_id,
            'qty' =>  $frame_paint_qty,
            'type' => 'PRODUCTION',
            'narration' => 'Frame Paint Qty',
            'company_id' => Session::get('company_id'),
            'created_by' =>  Auth::user()->id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);









        $record1 = DB::connection('mysql')->table('measurement_items')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('measurement_items')->where('id', $id)
        ->update([
            'assigned_date' => date("Y-m-d"),
            'production_unit_id' => $production_unit_id,
            'production_status' => 'Assigned',
            'die_no_front_id' =>  $die_no_front_id,
            'die_no_back_id' =>  $die_no_back_id,
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('measurement_items')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('measurement_items')->where('id', $id)
        ->update([
            'assigned_date' => date("Y-m-d"),
            'production_unit_id' => $production_unit_id,
            'production_status' => 'Assigned',
            'die_no_front_id' =>  $die_no_front_id,
            'die_no_back_id' =>  $die_no_back_id,
            'updated_at' => DB::raw('NOW()'),
        ]);

        DB::connection('mysql')->table('doordies')->where('location_id', $production_unit_id)->where('model_id', $model_id)->where('id', $die_no_front_id)
        ->update([
            'die_status' =>  'In Production',
            'updated_at' => DB::raw('NOW()'),
        ]);
        DB::connection('mysql')->table('doordies')->where('location_id', $production_unit_id)->where('model_id', $model_id)->where('id', $die_no_back_id)
        ->update([
            'die_status' =>  'In Production',
            'updated_at' => DB::raw('NOW()'),
        ]);

        DB::connection('mysql_second')->table('doordies')->where('location_id', $production_unit_id)->where('model_id', $model_id)->where('id', $die_no_front_id)
        ->update([
            'die_status' =>  'In Production',
            'updated_at' => DB::raw('NOW()'),
        ]);
        DB::connection('mysql_second')->table('doordies')->where('location_id', $production_unit_id)->where('model_id', $model_id)->where('id', $die_no_back_id)
        ->update([
            'die_status' =>  'In Production',
            'updated_at' => DB::raw('NOW()'),
        ]);

        return redirect(route('production_assigned_list'));
    }
    public function assign_frame_only(Request $request, string $id){

        $data_item_resin = DB::table('products')
        ->select('products.*')
        ->where('product_name', 'RESIN')
        ->first();



        $data_m = DB::table('measurement_items')
        ->select('measurement_items.*')
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->where("id", "=", $id)
        ->first();
      

        $data_f_clr = DB::table('colors')
        ->select('colors.*')
        ->where("id", "=", $data_m->frame_color_id)
        ->first();

        $data_frame_color = DB::table('products')
        ->select('products.*')
        ->where("id", "=", $data_f_clr->color_name_product_id)
        ->first(); 

        $dm_cat_id = $data_frame_color->category_id;
        $dm_unit_id = $data_frame_color->unit_id;
        $dm_id = $data_frame_color->id;
        $frame_paint_qty = $data_m->frame_paint_qty;
        $frame_resin_qty = $data_m->frame_resin_qty;


        DB::connection('mysql')->table('stocks')->insert([
                'm_items_id' =>  $id,
                'date' => date("Y-m-d"),
                'ref_no' => $data_m->batch_no,
                'item_category_id' =>  $dm_cat_id,
                'item_unit_id' =>  $dm_unit_id,
                'item_id' =>  $dm_id,
                'qty' =>  $frame_paint_qty,
                'type' => 'PRODUCTION',
                'narration' => 'Frame Paint Qty',
                'company_id' => Session::get('company_id'),
                'created_by' =>  Auth::user()->id,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);

            DB::connection('mysql')->table('stocks')->insert([
            'm_items_id' =>  $id,
            'date' => date("Y-m-d"),
            'ref_no' => $data_m->batch_no,
            'item_category_id' =>  $data_item_resin->category_id,
            'item_unit_id' =>  $data_item_resin->unit_id,
            'item_id' =>  $data_item_resin->id,
            'qty' =>  $frame_resin_qty,
            'type' => 'PRODUCTION',
            'narration' => 'Frame Resin Qty',
            'company_id' => Session::get('company_id'),
            'created_by' =>  Auth::user()->id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);

        DB::connection('mysql_second')->table('stocks')->insert([
                'm_items_id' =>  $id,
                'date' => date("Y-m-d"),
                'ref_no' => $data_m->batch_no,
                'item_category_id' =>  $dm_cat_id,
                'item_unit_id' =>  $dm_unit_id,
                'item_id' =>  $dm_id,
                'qty' =>  $frame_paint_qty,
                'type' => 'PRODUCTION',
                'narration' => 'Frame Paint Qty',
                'company_id' => Session::get('company_id'),
                'created_by' =>  Auth::user()->id,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);

            DB::connection('mysql_second')->table('stocks')->insert([
            'm_items_id' =>  $id,
            'date' => date("Y-m-d"),
            'ref_no' => $data_m->batch_no,
            'item_category_id' =>  $data_item_resin->category_id,
            'item_unit_id' =>  $data_item_resin->unit_id,
            'item_id' =>  $data_item_resin->id,
            'qty' =>  $frame_resin_qty,
            'type' => 'PRODUCTION',
            'narration' => 'Frame Resin Qty',
            'company_id' => Session::get('company_id'),
            'created_by' =>  Auth::user()->id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);

        
        $record1 = DB::connection('mysql')->table('measurement_items')->where('id', $id)->first();

        // Update the record with the new data
        DB::connection('mysql')->table('measurement_items')->where('id', $id)
            ->update([
                'assigned_date' => date("Y-m-d"),
                'production_status' => 'Assigned',
                'updated_at' => DB::raw('NOW()'),
            ]);
    
        // Find the record to update in database2
        $record2 = DB::connection('mysql_second')->table('measurement_items')->where('id', $id)->first();
    
        // Update the record with the new data
        DB::connection('mysql_second')->table('measurement_items')->where('id', $id)
            ->update([
                'assigned_date' => date("Y-m-d"),
                'production_status' => 'Assigned',
                'updated_at' => DB::raw('NOW()'),
            ]);
        return redirect(route('production_assigned_list'));
    }
    public function get_production_pending_list(Request $request){
          $start_date = trim($request->delivery_date);
          $end_date = trim($request->to_date);
    //   $start_date=  date('Y-m-d', strtotime($f_date));
    //   $end_date=  date('Y-m-d', strtotime($t_date));
       $root_id = $request->root_id;
       $fitting_or_packing = $request->fitting_or_packing;

       $mt_lists = DB::table('measurements')
        ->select('measurements.*', 'measurement_items.id as mitems_id','measurement_items.order_type' ,'measurement_items.batch_no', 'measurement_items.model_id', 'doormodels.id as door_model_id', 'doormodels.model_name', 'doorroots.root_name')
        ->leftjoin('measurement_items', 'measurements.id', '=', 'measurement_items.m_id')
        ->leftjoin('doormodels', 'measurement_items.model_id', '=', 'doormodels.id')
        ->leftjoin('doorroots', 'measurements.root_id', '=', 'doorroots.id')
        ->where("measurements.delete_status", "=", 0)
        ->where("measurements.company_id", "=", Session::get('company_id'))
        ->where("measurements.status", "=", 'Confirmed')
        ->where("measurement_items.production_status", "=", null)
        ->when($root_id, function ($query) use ($root_id) {
            return $query->where("measurements.root_id", "=", $root_id);
        })
        ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            return $query->whereBetween("measurements.delivery_date", [$start_date, $end_date]);
        })
        ->when($fitting_or_packing, function ($query) use ($fitting_or_packing) {
            return $query->where("measurements.fitting_or_packing", "=", $fitting_or_packing);
        })
        ->get();
        


        foreach ($mt_lists as $mt_list) {
            $mt_list->status = msrmnt::find($mt_list->id)->check_status($mt_list->model_id);
        }

        
           $slno = 1;
           $user_arr = array();
           foreach($mt_lists as $value){
            $order_no = $value->order_no;
            $batch_no = $value->batch_no;
            $model_name = $value->model_name;
            $delivery_date = $value->delivery_date;
            $root_name = $value->root_name;
            $status = $value->status;
            $mitems_id = $value->mitems_id;
            $order_type = $value->order_type;
           

            $user_arr[] = array("$slno",$order_no,$batch_no,$model_name,$delivery_date,$root_name,$status,$mitems_id,$order_type);
            $slno ++;
           }


          return response()->json($user_arr);
    }
    public function print_production_form(String $id){
        $result =  DB::table('measurement_items')
        ->select('measurement_items.*','doormodels.model_name','doorlocks.lock_name','glasstypes.glass_type_name','measurements.id as main_id','measurements.remarks','doorthicknesses.door_thickness')
        ->leftjoin('doormodels', 'measurement_items.model_id', '=', 'doormodels.id')
        ->leftjoin('doorlocks', 'measurement_items.lock_id', '=', 'doorlocks.id')
        ->leftjoin('glasstypes', 'measurement_items.glass_type', '=', 'glasstypes.id')
        ->leftJoin('doorthicknesses', 'measurement_items.door_thickness_id', '=', 'doorthicknesses.id')
        ->join('measurements', 'measurement_items.m_id', '=', 'measurements.id')
        ->where("measurement_items.id", "=", $id)
        ->first();






        if($result->color_id == null || $result->color_id == 0){
            $d_color_names = '-'; 
            $result->door_color_name = $d_color_names;

        }
        else{
            $color_names = clr::find($result->color_id)->get_color_name($result->color_id);
            if ($color_names->color_type == "Single")
            {

                $result->door_color_name = $color_names->s_product_name;
            }
        elseif ($color_names->color_type == "Combo")
            {
                $result->door_color_name = $color_names->s_product_name." & ".$color_names->c_product_name;
            }
        elseif ($color_names->color_type == "Triple")
            {
                $result->door_color_name = $color_names->s_product_name." & ".$color_names->c_product_name." & ".$color_names->t_product_name;
            }
        }
      
        if($result->frame_color_id == 0){
            $f_color_names = '-';
            $result->frame_color_name = $f_color_names;
        }
        else{
            $f_color_names = clr::find($result->frame_color_id)->get_frame_color_name($result->frame_color_id);
            $result->frame_color_name = $f_color_names->product_name;
        }



        
		
		$data = ['result'=> $result];
		return view('production.print_production_form',$data)->with('no', 1); 

    }
    public function print_production_form_sticker(String $id){
        $result =  DB::table('measurement_items')
        ->select('measurement_items.*','doormodels.model_name','doorlocks.lock_name','glasstypes.glass_type_name','measurements.id as main_id','measurements.remarks','doorthicknesses.door_thickness')
        ->leftjoin('doormodels', 'measurement_items.model_id', '=', 'doormodels.id')
        ->leftjoin('doorlocks', 'measurement_items.lock_id', '=', 'doorlocks.id')
        ->leftjoin('glasstypes', 'measurement_items.glass_type', '=', 'glasstypes.id')
        ->leftJoin('doorthicknesses', 'measurement_items.door_thickness_id', '=', 'doorthicknesses.id')
        ->join('measurements', 'measurement_items.m_id', '=', 'measurements.id')
        ->where("measurement_items.id", "=", $id)
        ->first();


        if(($result->color_id == 0) || ($result->color_id == null)){
            $d_color_names = '-'; 
            $result->door_color_name = $d_color_names;
        }
else{
    $color_names = clr::find($result->color_id)->get_color_name($result->color_id);
    if ($color_names->color_type == "Single")
                                        {

                                            $result->door_color_name = $color_names->s_product_name;
                                        }
                                    elseif ($color_names->color_type == "Combo")
                                        {
                                            $result->door_color_name = $color_names->s_product_name." & ".$color_names->c_product_name;
                                        }
                                    elseif ($color_names->color_type == "Triple")
                                        {
                                            $result->door_color_name = $color_names->s_product_name." & ".$color_names->c_product_name." & ".$color_names->t_product_name;
                                        }
}

if($result->frame_color_id == 0){
    $f_color_names = '-';
    $result->frame_color_name = $f_color_names;
}
else{
    $f_color_names = clr::find($result->frame_color_id)->get_frame_color_name($result->frame_color_id);
    $result->frame_color_name = $f_color_names->product_name;
}

        

        
        // foreach ($mt_lists as $mt_list) {
        //     $mt_list->status = msrmnt::find($mt_list->id)->check_status($mt_list->model_id);
        // }
		
		$data = ['result'=> $result];
		return view('production.print_production_form_sticker',$data)->with('no', 1); 
    }
    public function print_all(String $id){
        $mt_list =  DB::table('measurements')
        ->select('measurements.*','measurement_items.id as mitems_id','measurement_items.batch_no','measurement_items.model_id','doormodels.id as door_model_id','doormodels.model_name','doorroots.root_name')
        ->join('measurement_items', 'measurements.id', '=', 'measurement_items.m_id')
        ->leftjoin('doormodels', 'measurement_items.model_id', '=', 'doormodels.id')
        ->join('doorroots', 'measurements.root_id', '=', 'doorroots.id')
        ->where("measurements.delete_status", "=", 0)
        ->where("measurement_items.id", "=", $id)
        ->where("measurements.company_id", "=", Session::get('company_id'))
   
        ->first();
        

        // foreach ($mt_lists as $mt_list) {
        //     $mt_list->status = msrmnt::find($mt_list->id)->check_status($mt_list->model_id);
        // }
		
		$data = ['mt_list'=> $mt_list];
		return view('production.print_buttons_form',$data)->with('no', 1); 
    }
    public function print_production_frame_sticker(String $id){
       
        $result =  DB::table('measurement_items')
        ->select('measurement_items.*','doormodels.model_name','doorlocks.lock_name','glasstypes.glass_type_name','measurements.id as main_id','measurements.remarks','doorthicknesses.door_thickness')
        ->leftjoin('doormodels', 'measurement_items.model_id', '=', 'doormodels.id')
        ->leftjoin('doorlocks', 'measurement_items.lock_id', '=', 'doorlocks.id')
        ->leftjoin('glasstypes', 'measurement_items.glass_type', '=', 'glasstypes.id')
        ->leftJoin('doorthicknesses', 'measurement_items.door_thickness_id', '=', 'doorthicknesses.id')
        ->join('measurements', 'measurement_items.m_id', '=', 'measurements.id')
        ->where("measurement_items.id", "=", $id)
        ->first();



        if(($result->color_id == 0) || ($result->color_id == null)){
            $d_color_names = '-'; 
            $result->door_color_name = $d_color_names;
        }
else{
    $color_names = clr::find($result->color_id)->get_color_name($result->color_id);
    if ($color_names->color_type == "Single")
                                        {

                                            $result->door_color_name = $color_names->s_product_name;
                                        }
                                    elseif ($color_names->color_type == "Combo")
                                        {
                                            $result->door_color_name = $color_names->s_product_name." & ".$color_names->c_product_name;
                                        }
                                    elseif ($color_names->color_type == "Triple")
                                        {
                                            $result->door_color_name = $color_names->s_product_name." & ".$color_names->c_product_name." & ".$color_names->t_product_name;
                                        }
}

if($result->frame_color_id == 0){
    $f_color_names = '-';
    $result->frame_color_name = $f_color_names;
}
else{
    $f_color_names = clr::find($result->frame_color_id)->get_frame_color_name($result->frame_color_id);
    $result->frame_color_name = $f_color_names->product_name;
}
           
                                        

        
        // foreach ($mt_lists as $mt_list) {
        //     $mt_list->status = msrmnt::find($mt_list->id)->check_status($mt_list->model_id);
        // }
		
		$data = ['result'=> $result];
		return view('production.print_production_frame_sticker',$data)->with('no', 1); 
    }
    public function change_assigned_status(String $id){
        $record1 = DB::connection('mysql')->table('measurement_items')->where('id', $id)->first();

            // Update the record with the new data
            DB::connection('mysql')->table('measurement_items')->where('id', $id)
                ->update([
                    'production_status' => 'Production Pending',
                    'updated_at' => DB::raw('NOW()'),
                ]);

        // Find the record to update in database2
        $record2 = DB::connection('mysql_second')->table('measurement_items')->where('id', $id)->first();

            // Update the record with the new data
            DB::connection('mysql_second')->table('measurement_items')->where('id', $id)
                ->update([
                    'production_status' => 'Production Pending',
                    'updated_at' => DB::raw('NOW()'),
                ]);
        return redirect(route('production_assigned_list'));
    }
    public function pending_list(){
        $mt_lists =  DB::table('measurements')
        ->select('measurements.*','measurement_items.id as mitems_id','measurement_items.batch_no','measurement_items.model_id','doormodels.id as door_model_id','doormodels.model_name','doorroots.root_name')
        ->join('measurement_items', 'measurements.id', '=', 'measurement_items.m_id')
        ->leftjoin('doormodels', 'measurement_items.model_id', '=', 'doormodels.id')
        ->leftjoin('doorroots', 'measurements.root_id', '=', 'doorroots.id')
        ->where("measurements.delete_status", "=", 0)
        ->where("measurements.company_id", "=", Session::get('company_id'))
        ->where("measurements.status", "=", 'Confirmed')
        ->where("measurement_items.production_status", "=", 'Production Pending')
        ->get();

        // foreach ($mt_lists as $mt_list) {
        //     $mt_list->status = msrmnt::find($mt_list->id)->check_status($mt_list->model_id);
        // }
		
		$data = ['mt_lists'=> $mt_lists];
		return view('production.pending_list',$data)->with('no', 1);  
    }
    public function production_complete(String $id){
        $record1 = DB::connection('mysql')->table('measurement_items')->where('id', $id)->first();

        $die_no_front_id = $record1->die_no_front_id;
        $die_no_back_id = $record1->die_no_back_id;
        $production_unit_id = $record1->production_unit_id;
        $model_id = $record1->model_id;

        if($die_no_front_id == 0){

        }
        else{
            DB::connection('mysql')->table('doordies')->where('location_id', $production_unit_id)->where('model_id', $model_id)->where('id', $die_no_front_id)
            ->update([
                'die_status' =>  'Active',
                'updated_at' => DB::raw('NOW()'),
            ]);
        }

        if($die_no_back_id == 0){

        }
        else{
            DB::connection('mysql')->table('doordies')->where('location_id', $production_unit_id)->where('model_id', $model_id)->where('id', $die_no_back_id)
            ->update([
                'die_status' =>  'Active',
                'updated_at' => DB::raw('NOW()'),
            ]);
        }

        // Update the record with the new data
        DB::connection('mysql')->table('measurement_items')->where('id', $id)
            ->update([
                'production_status' => 'Production Completed',
                'updated_at' => DB::raw('NOW()'),
            ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('measurement_items')->where('id', $id)->first();

    $die_no_front_id_2 = $record2->die_no_front_id;
    $die_no_back_id_2 = $record2->die_no_back_id;
    $production_unit_id_2 = $record2->production_unit_id;
    $model_id_2 = $record2->model_id;

    if($die_no_front_id_2 == 0){

    }
    else{
        DB::connection('mysql_second')->table('doordies')->where('location_id', $production_unit_id_2)->where('model_id', $model_id_2)->where('id', $die_no_front_id_2)
        ->update([
            'die_status' =>  'Active',
            'updated_at' => DB::raw('NOW()'),
        ]);
    }

    if($die_no_back_id_2 == 0){

    }
    else{
        DB::connection('mysql_second')->table('doordies')->where('location_id', $production_unit_id_2)->where('model_id', $model_id_2)->where('id', $die_no_back_id_2)
        ->update([
            'die_status' =>  'Active',
            'updated_at' => DB::raw('NOW()'),
        ]);
    }

        // Update the record with the new data
        DB::connection('mysql_second')->table('measurement_items')->where('id', $id)
            ->update([
                'production_status' => 'Production Completed',
                'updated_at' => DB::raw('NOW()'),
            ]);
    return redirect(route('pending_list'));
    }
    public function completed_list(){
        $mt_lists =  DB::table('measurements')
        ->select('measurements.*','measurement_items.id as mitems_id','measurement_items.batch_no','measurement_items.model_id','doormodels.id as door_model_id','doormodels.model_name','doorroots.root_name')
        ->leftjoin('measurement_items', 'measurements.id', '=', 'measurement_items.m_id')
        ->leftjoin('doormodels', 'measurement_items.model_id', '=', 'doormodels.id')
        ->leftjoin('doorroots', 'measurements.root_id', '=', 'doorroots.id')
        ->where("measurements.delete_status", "=", 0)
        ->where("measurements.company_id", "=", Session::get('company_id'))
        ->where("measurements.status", "=", 'Confirmed')
        ->where("measurement_items.production_status", "=", 'Production Completed')
        ->get();

        // foreach ($mt_lists as $mt_list) {
        //     $mt_list->status = msrmnt::find($mt_list->id)->check_status($mt_list->model_id);
        // }
		
		$data = ['mt_lists'=> $mt_lists];
		return view('production.completed_list',$data)->with('no', 1);  
    }
    public function complete_production_pending_list(Request $request){
        $id = $request->mt_id;
        $record1 = DB::connection('mysql')->table('measurement_items')->where('id', $id)->first();

        $die_no_front_id = $record1->die_no_front_id;
        $die_no_back_id = $record1->die_no_back_id;
        $production_unit_id = $record1->production_unit_id;
        $model_id = $record1->model_id;

        if($die_no_front_id == 0){

        }
        else{
            DB::connection('mysql')->table('doordies')->where('location_id', $production_unit_id)->where('model_id', $model_id)->where('id', $die_no_front_id)
            ->update([
                'die_status' =>  'Active',
                'updated_at' => DB::raw('NOW()'),
            ]);
        }

        if($die_no_back_id == 0){

        }
        else{
            DB::connection('mysql')->table('doordies')->where('location_id', $production_unit_id)->where('model_id', $model_id)->where('id', $die_no_back_id)
            ->update([
                'die_status' =>  'Active',
                'updated_at' => DB::raw('NOW()'),
            ]);
        }

        // Update the record with the new data
        DB::connection('mysql')->table('measurement_items')->where('id', $id)
            ->update([
                'production_status' => 'Production Completed',
                'updated_at' => DB::raw('NOW()'),
            ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('measurement_items')->where('id', $id)->first();

    $die_no_front_id_2 = $record2->die_no_front_id;
    $die_no_back_id_2 = $record2->die_no_back_id;
    $production_unit_id_2 = $record2->production_unit_id;
    $model_id_2 = $record2->model_id;

    if($die_no_front_id_2 == 0){

    }
    else{
        DB::connection('mysql_second')->table('doordies')->where('location_id', $production_unit_id_2)->where('model_id', $model_id_2)->where('id', $die_no_front_id_2)
        ->update([
            'die_status' =>  'Active',
            'updated_at' => DB::raw('NOW()'),
        ]);
    }

    if($die_no_back_id_2 == 0){

    }
    else{
        DB::connection('mysql_second')->table('doordies')->where('location_id', $production_unit_id_2)->where('model_id', $model_id_2)->where('id', $die_no_back_id_2)
        ->update([
            'die_status' =>  'Active',
            'updated_at' => DB::raw('NOW()'),
        ]);
    }

        // Update the record with the new data
        DB::connection('mysql_second')->table('measurement_items')->where('id', $id)
            ->update([
                'production_status' => 'Production Completed',
                'updated_at' => DB::raw('NOW()'),
            ]);

            return response()->json(['success' =>'success']);
    }
    public function completed_production_view(String $id){
        $result = DB::table('measurements')
        ->select('measurements.*','customers.customer_name','customers.brand','customers.permenant_address','users.name','doorroots.root_name')
        ->leftjoin('customers','measurements.customer_id','=','customers.id')
        ->leftjoin('users', 'measurements.executive_id', '=', 'users.id')
        ->leftjoin('doorroots', 'measurements.root_id', '=', 'doorroots.id')
        ->where("measurements.id", "=", $id)
        ->first();


       
        $m_items = DB::table('measurement_items')
        ->select('measurement_items.*', 'doormodels.model_name', 'doorclearances.frame_size', 'doorlocks.lock_name','glasstypes.glass_type_name','doorthicknesses.door_thickness')
        ->leftJoin('doormodels', 'measurement_items.model_id', '=', 'doormodels.id')
        ->leftJoin('doorclearances', 'measurement_items.frame_size', '=', 'doorclearances.id')
        ->leftJoin('glasstypes', 'measurement_items.glass_type', '=', 'glasstypes.id')
        ->leftJoin('doorlocks', 'measurement_items.lock_id', '=', 'doorlocks.id')
        ->leftJoin('doorthicknesses', 'measurement_items.door_thickness_id', '=', 'doorthicknesses.id')
        ->where("measurement_items.m_id", "=", $id)
        ->where("measurement_items.delete_status", "=", "0")
        ->get();

        foreach($m_items as $m_item){
          
            if($m_item->color_id == null || $m_item->color_id == 0){
                $d_color_names = '-'; 
                $m_item->door_color_name = $d_color_names;

            }
            else{
                $color_names = clr::find($m_item->color_id)->get_color_name($m_item->color_id);
                if ($color_names->color_type == "Single")
                {

                    $m_item->door_color_name = $color_names->s_product_name;
                }
            elseif ($color_names->color_type == "Combo")
                {
                    $m_item->door_color_name = $color_names->s_product_name." & ".$color_names->c_product_name;
                }
            elseif ($color_names->color_type == "Triple")
                {
                    $m_item->door_color_name = $color_names->s_product_name." & ".$color_names->c_product_name." & ".$color_names->t_product_name;
                }
            }
          
            if($m_item->frame_color_id == 0){
                $f_color_names = '-';
                $m_item->frame_color_name = $f_color_names;
            }
            else{
                $f_color_names = clr::find($m_item->frame_color_id)->get_frame_color_name($m_item->frame_color_id);
                $m_item->frame_color_name = $f_color_names->product_name;
            }
                                      
        }
        

        return view('production.completed_production_view',compact('result','m_items'))->with('no', 1);
    }
    public function production_change_password(){
        return view('production.change_password'); 
    }
   
    public function change_password_production(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'password' => ['required', 'string', 'min:8'],
        ]);


             // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('users')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('users')->where('id', $id)
        ->update([
            'password' => Hash::make(request('password')),
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('users')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('users')->where('id', $id)
        ->update([
            'password' => Hash::make(request('password')),
            'updated_at' => DB::raw('NOW()'),
        ]);
        return redirect()->route('production_change_password')->with('success', 'Password changed successfully.');
    
    }
    
}
