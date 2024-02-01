<?php

namespace App\Http\Controllers\Fitting;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Color AS clr;
use App\Models\Currency AS crny ;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class Measurement extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
		return view('fitting.measurement.index');
    }
    public function get_pending_order_list_fitting(){
        $draw = request()->input('draw');
        $start = request()->input('start');
        $length = request()->input('length');
    
    
    
        $result =DB::table('measurements')
        ->select('measurements.*','customers.customer_name','doorbrands.brand_name')
        ->leftjoin('customers', 'measurements.customer_id', '=', 'customers.id')
        ->leftjoin('doorbrands', 'measurements.brand_id', '=', 'doorbrands.id')
        ->where("measurements.delete_status", "=", 0)
        ->where("measurements.company_id", "=", Session::get('company_id'))
        ->where("measurements.status", "=", 'Pending')
        ->where("measurements.department",'fitting')
        ->get();
        
    $data = [];
    $slno = 1;
            
            
            
    foreach ($result as $r) {
      
    
        $editButton = '<a href="' . route('measurement_form_edit_fitting',$r->id ) . '"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
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
    
    $viewButton = '<a href="' . route('measurment_form_view_fitting',$r->id ) . '">  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
    <path
        opacity="0.5"
        d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
        stroke="currentColor"
        stroke-width="1.5"
    ></path>
    <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="1.5"></path>
    </svg></a>';
    
    
    
    
    $btns = '<div class="flex gap-4 items-center">'.$editButton.$viewButton.'</div>';
    
    $date = \Carbon\Carbon::parse($r->order_date)->format('d-m-Y') ;
    
        $data[] = array(
            $slno,
            $r->order_no,
            $date,
            $r->customer_name,
            $r->brand_name,
            $r->delivery_date,
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
        $customer_lists =  DB::table('customers')
        ->select('customers.*')
        ->where("customers.delete_status", "=", 0)
        ->where("customers.company_id", "=", Session::get('company_id'))
        ->get();

        $executive_lists =  DB::table('users')
        ->select('users.*')
        ->where("users.department", "=", "executive")
        ->where("users.delete_status", "=", 0)
        ->where("users.company_id", "=", Session::get('company_id'))
        ->get();

        $model_lists =  DB::table('doormodels')
        ->select('doormodels.*')
        ->where("doormodels.delete_status", "=", 0)
        ->where("doormodels.company_id", "=", Session::get('company_id'))
        ->get();

        $door_thickness_lists =  DB::table('doorthicknesses')
        ->select('doorthicknesses.*')
        ->where("doorthicknesses.delete_status", "=", 0)
        ->where("doorthicknesses.company_id", "=", Session::get('company_id'))
        ->get();

    
        $color_lists =  DB::table('colors')
        ->select('colors.*', 'color_name_products.product_name as s_c_p_name', 'combo_color_products.product_name as c_c_p_name', 'triple_color_products.product_name as t_c_p_name')
        ->leftJoin('products as color_name_products', 'colors.color_name_product_id', '=', 'color_name_products.id')
        ->leftJoin('products as combo_color_products', 'colors.combo_color_name_product_id', '=', 'combo_color_products.id')
        ->leftJoin('products as triple_color_products', 'colors.triple_color_name_product_id', '=', 'triple_color_products.id')
        ->where("colors.delete_status", "=", 0)
        ->where("colors.company_id", "=", Session::get('company_id'))
        ->get();



        $single_color_list =  DB::table('colors')
        ->select('colors.*', 'color_name_products.product_name as s_c_p_name', 'combo_color_products.product_name as c_c_p_name', 'triple_color_products.product_name as t_c_p_name')
        ->leftJoin('products as color_name_products', 'colors.color_name_product_id', '=', 'color_name_products.id')
        ->leftJoin('products as combo_color_products', 'colors.combo_color_name_product_id', '=', 'combo_color_products.id')
        ->leftJoin('products as triple_color_products', 'colors.triple_color_name_product_id', '=', 'triple_color_products.id')
        ->where("colors.delete_status", "=", 0)
        ->where("colors.color_type", "=", "Single")
        ->where("colors.company_id", "=", Session::get('company_id'))
        ->get();


        $frame_sizes = DB::table('doorclearances')
        ->select('doorclearances.*')
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->where("created_by", "!=", "")
        ->get();

        $root_lists =  DB::table('doorroots')
        ->select('doorroots.*')
        ->where("doorroots.delete_status", "=", 0)
        ->where("doorroots.company_id", "=", Session::get('company_id'))
        ->get();

        $gt_lists = DB::table('glasstypes')
        ->select('glasstypes.*')
        ->where("glasstypes.delete_status", "=", 0)
        ->where("glasstypes.company_id", "=", Session::get('company_id'))
        ->get();

        $lk_lists = DB::table('doorlocks')
        ->select('doorlocks.*')
        ->where("doorlocks.delete_status", "=", 0)
        ->where("doorlocks.company_id", "=", Session::get('company_id'))
        ->get();

        
        $brnd_lists = DB::table('doorbrands')
        ->select('doorbrands.*')
        ->where("doorbrands.delete_status", "=", 0)
        ->where("doorbrands.company_id", "=", Session::get('company_id'))
        ->get();


        $currency_lists = crny::all();

        $data = ['currency_lists' => $currency_lists,'door_thickness_lists' => $door_thickness_lists,'frame_sizes' => $frame_sizes,'brnd_lists' => $brnd_lists,'customer_lists' => $customer_lists,'executive_lists' => $executive_lists,'model_lists' => $model_lists,'color_lists' => $color_lists,'root_lists' => $root_lists,'gt_lists' => $gt_lists,'lk_lists' => $lk_lists,'single_color_list' => $single_color_list];
        return view('fitting.measurement.create',$data)->with('no', 1);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required',
            'root_id' => 'required',
            'site_name' => 'required',
            'site_address' => 'required',
            'fitting_or_packing' => 'required',
            'order_date' => 'required',
            'delivery_date' => 'required',
            'brand' => 'required',
        ]);

        $m_id = DB::connection('mysql')->table('measurements')->insertGetId([
            'fitting_or_packing' =>  request('fitting_or_packing'),
            'order_date' =>  request('order_date'),
            'delivery_date' =>  request('delivery_date'),
            'order_no' =>  request('order_no'),
            'customer_id' =>  request('customer_id'),
            'brand_id' => request('brand'),
            'executive_id' =>  request('executive'),
            'root_id' =>  request('root_id'),
            'site_name' =>  request('site_name'),
            'site_address' =>  request('site_address'),
            'department' => 'fitting',
            'remarks' =>  request('remarks'),
            'created_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);
        DB::connection('mysql_second')->table('measurements')->insert([
            'fitting_or_packing' =>  request('fitting_or_packing'),
            'order_date' =>  request('order_date'),
            'delivery_date' =>  request('delivery_date'),
            'order_no' =>  request('order_no'),
            'customer_id' =>  request('customer_id'),
            'brand_id' => request('brand'),
            'executive_id' =>  request('executive'),
            'root_id' =>  request('root_id'),
            'site_name' =>  request('site_name'),
            'site_address' =>  request('site_address'),
            'department' => 'fitting',
            'remarks' =>  request('remarks'),
            'created_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
         ]);

         $mt_lists =  DB::table('measurement_items_temp')
         ->select('measurement_items_temp.*','doormodels.model_name')
         ->leftjoin('doormodels', 'measurement_items_temp.model_id', '=', 'doormodels.id')
         ->where("measurement_items_temp.order_no", "=", request('order_no'))
         ->where("measurement_items_temp.company_id", "=", Session::get('company_id'))
         ->get();

         $i = 1;
          
         foreach ($mt_lists as $item) {
            $batch_no = request('order_no')."-".$i;
            $i ++;
            DB::connection('mysql')->table('measurement_items')->insert([
                'm_id' => $m_id,
                'added_date' => request('order_date'),
                'batch_no' => $batch_no,
                'order_type' => $item->order_type,
                'model_id' =>  $item->model_id,
                'frame' =>  $item->frame,
                'tight_measurement_top_width' =>  $item->tight_measurement_top_width,
                'tight_measurement_bottom_width' =>  $item->tight_measurement_bottom_width,
                'tight_measurement_height' =>  $item->tight_measurement_height,
                'tight_measurement_square_feet' => $item->tight_measurement_square_feet,
                'measurement_with_clearance_top_width' =>  $item->measurement_with_clearance_top_width,
                'measurement_with_clearance_bottom_width' =>  $item->measurement_with_clearance_bottom_width,
                'measurement_with_clearance_height' => $item->measurement_with_clearance_height,
                'frame_size' =>  $item->frame_size,
                'color_type' =>  $item->color_type,
                'color_id' =>  $item->color_id,
                'frame_color_id' => $item->frame_color_id,
                'finish_work' =>  $item->finish_work,
                'finish_work_front' =>  $item->finish_work_front,
                'finish_work_back' => $item->finish_work_back,
                'steel_beeding' =>  $item->steel_beeding,
                'texture_finish' =>  $item->texture_finish,
                'glass_type' => $item->glass_type,
                'hinges' =>  $item->hinges,
                'hinges_measurement' =>  $item->hinges_measurement,
                'lock_id' => $item->lock_id,
                'lock_measurement' => $item->lock_measurement,
                'door_resin_qty' =>  $item->door_resin_qty,
                'frame_resin_qty' =>  $item->frame_resin_qty,
                'door_paint_qty_1' => $item->door_paint_qty_1,
                'door_paint_qty_2' => $item->door_paint_qty_2,
                'door_paint_qty_3' => $item->door_paint_qty_3,
                'frame_paint_qty' => $item->frame_paint_qty,
                'item_remarks' => $item->item_remarks,
                'door_thickness_id' => $item->door_thickness_id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
    
            DB::connection('mysql_second')->table('measurement_items')->insert([
                'm_id' => $m_id,
                'added_date' => request('order_date'),
                'batch_no' => $batch_no,
                'order_type' => $item->order_type,
                'model_id' =>  $item->model_id,
                'frame' =>  $item->frame,
                'tight_measurement_top_width' =>  $item->tight_measurement_top_width,
                'tight_measurement_bottom_width' =>  $item->tight_measurement_bottom_width,
                'tight_measurement_height' =>  $item->tight_measurement_height,
                'tight_measurement_square_feet' => $item->tight_measurement_square_feet,
                'measurement_with_clearance_top_width' =>  $item->measurement_with_clearance_top_width,
                'measurement_with_clearance_bottom_width' =>  $item->measurement_with_clearance_bottom_width,
                'measurement_with_clearance_height' => $item->measurement_with_clearance_height,
                'frame_size' =>  $item->frame_size,
                'color_type' =>  $item->color_type,
                'color_id' =>  $item->color_id,
                'frame_color_id' => $item->frame_color_id,
                'finish_work' =>  $item->finish_work,
                'finish_work_front' =>  $item->finish_work_front,
                'finish_work_back' => $item->finish_work_back,
                'steel_beeding' =>  $item->steel_beeding,
                'texture_finish' =>  $item->texture_finish,
                'glass_type' => $item->glass_type,
                'hinges' =>  $item->hinges,
                'hinges_measurement' =>  $item->hinges_measurement,
                'lock_id' => $item->lock_id,
                'lock_measurement' => $item->lock_measurement,
                'door_resin_qty' =>  $item->door_resin_qty,
                'frame_resin_qty' =>  $item->frame_resin_qty,
                'door_paint_qty_1' => $item->door_paint_qty_1,
                'door_paint_qty_2' => $item->door_paint_qty_2,
                'door_paint_qty_3' => $item->door_paint_qty_3,
                'frame_paint_qty' => $item->frame_paint_qty,
                'item_remarks' => $item->item_remarks,
                'door_thickness_id' => $item->door_thickness_id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
         }

         DB::table('measurement_items_temp')->where('order_no', request('order_no'))->delete();

         return redirect(route('pending_order_list_fitting'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $result = DB::table('measurements')
        ->select('measurements.*','customers.customer_name','customers.brand','customers.permenant_address','users.name','doorroots.root_name')
        ->leftJoin('customers','measurements.customer_id','=','customers.id')
        ->leftJoin('users', 'measurements.executive_id', '=', 'users.id')
        ->leftJoin('doorroots', 'measurements.root_id', '=', 'doorroots.id')
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
        

        return view('fitting.measurement.completed_order_view',compact('result','m_items'))->with('no', 1);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $result = DB::table('measurements')
        ->select('measurements.*','customers.permenant_address')
        ->leftjoin('customers','measurements.customer_id','=','customers.id')
        ->where("measurements.id", "=", $id)
        ->first();


        $m_items = DB::table('measurement_items')
        ->select('measurement_items.*','doormodels.model_name')
        ->leftjoin('doormodels','measurement_items.model_id','=','doormodels.id')

        ->where("measurement_items.m_id", "=", $id)
        ->where("measurement_items.delete_status", "=", "0")
        ->get();

        $customer_lists =  DB::table('customers')
        ->select('customers.*')
        ->where("customers.delete_status", "=", 0)
        ->where("customers.company_id", "=", Session::get('company_id'))
        ->get();

        $executive_lists =  DB::table('users')
        ->select('users.*')
        ->where("users.department", "=", "executive")
        ->where("users.delete_status", "=", 0)
        ->where("users.company_id", "=", Session::get('company_id'))
        ->get();

        $model_lists =  DB::table('doormodels')
        ->select('doormodels.*')
        ->where("doormodels.delete_status", "=", 0)
        ->where("doormodels.company_id", "=", Session::get('company_id'))
        ->get();

        $door_thickness_lists =  DB::table('doorthicknesses')
        ->select('doorthicknesses.*')
        ->where("doorthicknesses.delete_status", "=", 0)
        ->where("doorthicknesses.company_id", "=", Session::get('company_id'))
        ->get();

        $color_lists =  DB::table('colors')
        ->select('colors.*', 'color_name_products.product_name as s_c_p_name', 'combo_color_products.product_name as c_c_p_name', 'triple_color_products.product_name as t_c_p_name')
        ->leftJoin('products as color_name_products', 'colors.color_name_product_id', '=', 'color_name_products.id')
        ->leftJoin('products as combo_color_products', 'colors.combo_color_name_product_id', '=', 'combo_color_products.id')
        ->leftJoin('products as triple_color_products', 'colors.triple_color_name_product_id', '=', 'triple_color_products.id')
        ->where("colors.delete_status", "=", 0)
        ->where("colors.company_id", "=", Session::get('company_id'))
        ->get();

        $single_color_list =  DB::table('colors')
        ->select('colors.*', 'color_name_products.product_name as s_c_p_name', 'combo_color_products.product_name as c_c_p_name', 'triple_color_products.product_name as t_c_p_name')
        ->leftJoin('products as color_name_products', 'colors.color_name_product_id', '=', 'color_name_products.id')
        ->leftJoin('products as combo_color_products', 'colors.combo_color_name_product_id', '=', 'combo_color_products.id')
        ->leftJoin('products as triple_color_products', 'colors.triple_color_name_product_id', '=', 'triple_color_products.id')
        ->where("colors.delete_status", "=", 0)
        ->where("colors.color_type", "=", "Single")
        ->where("colors.company_id", "=", Session::get('company_id'))
        ->get();

        $root_lists =  DB::table('doorroots')
        ->select('doorroots.*')
        ->where("doorroots.delete_status", "=", 0)
        ->where("doorroots.company_id", "=", Session::get('company_id'))
        ->get();

        $gt_lists = DB::table('glasstypes')
        ->select('glasstypes.*')
        ->where("glasstypes.delete_status", "=", 0)
        ->where("glasstypes.company_id", "=", Session::get('company_id'))
        ->get();

        $lk_lists = DB::table('doorlocks')
        ->select('doorlocks.*')
        ->where("doorlocks.delete_status", "=", 0)
        ->where("doorlocks.company_id", "=", Session::get('company_id'))
        ->get();

        $fs_lists =  DB::table('doorclearances')
        ->select('doorclearances.*')
        ->where("doorclearances.delete_status", "=", 0)
        ->where("doorclearances.company_id", "=", Session::get('company_id'))
        ->get();

        $brnd_lists = DB::table('doorbrands')
        ->select('doorbrands.*')
        ->where("doorbrands.delete_status", "=", 0)
        ->where("doorbrands.company_id", "=", Session::get('company_id'))
        ->get();

        $currency_lists = crny::all();

        return view('fitting.measurement.edit',compact('result','door_thickness_lists','currency_lists','m_items','customer_lists','executive_lists','model_lists','color_lists','root_lists','gt_lists','lk_lists','fs_lists','single_color_list','brnd_lists'))->with('no', 0);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required',
            'root_id' => 'required',
            'site_name' => 'required',
            'site_address' => 'required',
            'fitting_or_packing' => 'required',
            'order_date' => 'required',
            'delivery_date' => 'required',
            'brand' => 'required',
        ]);
        $record1 = DB::connection('mysql')->table('measurements')->where('id', $id)->first();

        // Update the record with the new data
        DB::connection('mysql')->table('measurements')->where('id', $id)
            ->update([
                'fitting_or_packing' =>  request('fitting_or_packing'),
                'order_date' =>  request('order_date'),
                'delivery_date' =>  request('delivery_date'),
                'order_no' =>  request('order_no'),
                'customer_id' =>  request('customer_id'),
                'brand_id' => request('brand'),
                'executive_id' =>  request('executive'),
                'root_id' =>  request('root_id'),
                'site_name' =>  request('site_name'),
                'site_address' =>  request('site_address'),
                'remarks' =>  request('remarks'),
                'status' => 'Confirmed',
                'edited_by' =>  Auth::user()->id,
                'updated_at' => DB::raw('NOW()'),
            ]);
    
        // Find the record to update in database2
        $record2 = DB::connection('mysql_second')->table('measurements')->where('id', $id)->first();
    
        // Update the record with the new data
        DB::connection('mysql_second')->table('measurements')->where('id', $id)
            ->update([
                'fitting_or_packing' =>  request('fitting_or_packing'),
                'order_date' =>  request('order_date'),
                'delivery_date' =>  request('delivery_date'),
                'order_no' =>  request('order_no'),
                'customer_id' =>  request('customer_id'),
                'brand_id' => request('brand'),
                'executive_id' =>  request('executive'),
                'root_id' =>  request('root_id'),
                'site_name' =>  request('site_name'),
                'site_address' =>  request('site_address'),
                'remarks' =>  request('remarks'),
                'status' => 'Confirmed',
                'edited_by' =>  Auth::user()->id,
                'updated_at' => DB::raw('NOW()'),
            ]);
            return redirect(route('confirmed_order_list_fitting'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function get_customer_deatils(Request $request){
        $customer_id = $request->customer_id;
        $customer_address = DB::table('customers')
        ->where('id', $customer_id)
        ->value('permenant_address');

        $brand = DB::table('customers')
        ->join('doorbrands', 'customers.brand', '=', 'doorbrands.id')
        ->where('customers.id', $customer_id)
        ->value('brand_name');

        return response()->json(['customer_address' =>$customer_address,'brand' => $brand]);
    }
    public function generate_order_no(Request $request){
        $fitting_or_packing = $request->fitting_or_packing;

         if($fitting_or_packing == "Fitting"){
            $data_mi_fitting =  DB::table('measurements')
        ->select('measurements.id')
        ->where("measurements.company_id", "=", Session::get('company_id'))
        ->where("measurements.fitting_or_packing", "=", "Fitting")
        ->get();
    

         if(empty($data_mi_fitting)){
            $num = 0;
         }
         else{
            $num = DB::table('measurements')
                ->where('company_id', '=', Session::get('company_id'))
                ->where("measurements.fitting_or_packing", "=", "Fitting")
                ->count();
         }
         $refe_fitting = $num + 1;
         $ref_no_fitting = str_pad($refe_fitting, 4, '0', STR_PAD_LEFT);
         $r_no = "FI".$ref_no_fitting;
         }
         else{
            $data_mi_fitting =  DB::table('measurements')
        ->select('measurements.id')
        ->where("measurements.company_id", "=", Session::get('company_id'))
        ->where("measurements.fitting_or_packing", "=", "fitting")
        ->get();
    

         if(empty($data_mi_fitting)){
            $num_p = 0;
         }
         else{
            $num_p = DB::table('measurements')
                ->where('company_id', '=', Session::get('company_id'))
                ->where("measurements.fitting_or_packing", "=", "fitting")
                ->count();
         }
         $refe_fitting = $num_p + 1;
         $ref_no_fitting = str_pad($refe_fitting, 4, '0', STR_PAD_LEFT);
         $r_no = "PC".$ref_no_fitting;
         }

         return response()->json(['r_no' =>$r_no]);

    }
    public function get_frame_size_deatils(){
        $frame_sizes = DB::table('doorclearances')
        ->select('doorclearances.*')
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->where("created_by", "!=", "")
        ->get();

        return response()->json(['frame_sizes' =>$frame_sizes]);
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
    public function get_top_width_clearence(Request $request){
        $frame_pop_up = $request->frame_pop_up;
        $frame_size_pop_up = $request->frame_size_pop_up;

        if($frame_pop_up == 'Wood'){
            $details = DB::table('doorclearances')
            ->select('doorclearances.*')
            ->where("company_id", "=", Session::get('company_id'))
            ->where("delete_status", "=", 0)
            ->where("frame_size", "=", 'Wood')
            ->first();
        }
        else if($frame_pop_up == 'Stainless Steel'){
            $details = DB::table('doorclearances')
            ->select('doorclearances.*')
            ->where("company_id", "=", Session::get('company_id'))
            ->where("delete_status", "=", 0)
            ->where("frame_size", "=", 'Stainless Steel')
            ->first();
        }
        else if($frame_pop_up == 'Concrete'){
            $details = DB::table('doorclearances')
            ->select('doorclearances.*')
            ->where("company_id", "=", Session::get('company_id'))
            ->where("delete_status", "=", 0)
            ->where("frame_size", "=", 'Concrete')
            ->first();
        }
        else{
            $details = DB::table('doorclearances')
            ->select('doorclearances.*')
            ->where("company_id", "=", Session::get('company_id'))
            ->where("delete_status", "=", 0)
            ->where("id", "=", $frame_size_pop_up)
            ->first();
        }
        

        return response()->json(['details' =>$details]);
    }
    public function get_top_width_clearence_for_others(Request $request){
        $frame_pop_up = $request->frame_pop_up;

        $details = DB::table('doorclearances')
        ->select('doorclearances.*')
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->where("frame_size", "=", $frame_pop_up)
        ->first();

        return response()->json(['details' =>$details]);
    }
    public function remove_measurement_item(Request $request){
        $id = $request->mt_id;


        $details = DB::table('measurement_items')
        ->select('measurement_items.m_id')
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->where("id", "=", $id)
        ->first();

        $m_id = $details->m_id;


        
        $result = DB::table('measurement_items')
        ->select('measurement_items.*')
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->where("m_id", "=", $m_id)
        ->get();
        if ($result->count() > 1) {
            $record1 = DB::connection('mysql')->table('measurement_items')->where('id', $id)->first();

            // Update the record with the new data
            DB::connection('mysql')->table('measurement_items')->where('id', $id)
                ->update([
                    'delete_status' => 1,
                    'updated_at' => DB::raw('NOW()'),
                ]);
        
            // Find the record to update in database2
            $record2 = DB::connection('mysql_second')->table('measurement_items')->where('id', $id)->first();
        
            // Update the record with the new data
            DB::connection('mysql_second')->table('measurement_items')->where('id', $id)
                ->update([
                    'delete_status' => 1,
                    'updated_at' => DB::raw('NOW()'),
                ]);  
                return response()->json(['success' =>'success']);
        }
        else{
           

            $record_main_1 = DB::connection('mysql')->table('measurements')->where('id', $m_id)->first();

            // Update the record with the new data
            DB::connection('mysql')->table('measurements')->where('id', $m_id)
                ->update([
                    'delete_status' => 1,
                    'updated_at' => DB::raw('NOW()'),
                ]);
        
            // Find the record to update in database2
            $record_main_2 = DB::connection('mysql_second')->table('measurements')->where('id', $m_id)->first();
        
            // Update the record with the new data
            DB::connection('mysql_second')->table('measurements')->where('id', $m_id)
                ->update([
                    'delete_status' => 1,
                    'updated_at' => DB::raw('NOW()'),
                ]);



            $record1 = DB::connection('mysql')->table('measurement_items')->where('id', $id)->first();

            // Update the record with the new data
            DB::connection('mysql')->table('measurement_items')->where('id', $id)
                ->update([
                    'delete_status' => 1,
                    'updated_at' => DB::raw('NOW()'),
                ]);
        
            // Find the record to update in database2
            $record2 = DB::connection('mysql_second')->table('measurement_items')->where('id', $id)->first();
        
            // Update the record with the new data
            DB::connection('mysql_second')->table('measurement_items')->where('id', $id)
                ->update([
                    'delete_status' => 1,
                    'updated_at' => DB::raw('NOW()'),
                ]);
                return response()->json(['success' =>'full']);
        }

    }
    public function confirm_pending_order(Request $request){
        $id = $request->mt_id;
        $main_id = $request->main_id;


        $fitting_or_packing = $request->fitting_or_packing;
        $customer_id = $request->customer_id;
        $root_id = $request->root_id;
        $brand_id = $request->brand_id;
        $executive_id = $request->executive_id;
        $site_name = $request->site_name;
        $site_address = $request->site_address;
        $delivery_date = $request->delivery_date;
        $remarks = $request->remarks;
        $order_date = $request->order_date;
        







        $record1 = DB::connection('mysql')->table('measurements')->where('id', $main_id)->first();

        // Update the record with the new data
        DB::connection('mysql')->table('measurements')->where('id', $main_id)
            ->update([
                'fitting_or_packing' =>  $fitting_or_packing,
                'order_date' =>  $order_date,
                'delivery_date' => $delivery_date,
                'customer_id' =>  $customer_id,
                'brand_id' =>$brand_id,
                'executive_id' => $executive_id,
                'root_id' =>  $root_id,
                'site_name' =>  $site_name,
                'site_address' =>$site_address,
                'remarks' =>  $remarks,
                'edited_by' =>  Auth::user()->id,
                'updated_at' => DB::raw('NOW()'),
            ]);
    
        // Find the record to update in database2
        $record2 = DB::connection('mysql_second')->table('measurements')->where('id', $main_id)->first();
    
        // Update the record with the new data
        DB::connection('mysql_second')->table('measurements')->where('id', $main_id)
            ->update([
                'fitting_or_packing' =>  $fitting_or_packing,
                'order_date' =>  $order_date,
                'delivery_date' => $delivery_date,
                'customer_id' =>  $customer_id,
                'brand_id' =>$brand_id,
                'executive_id' => $executive_id,
                'root_id' =>  $root_id,
                'site_name' =>  $site_name,
                'site_address' =>$site_address,
                'remarks' =>  $remarks,
                'edited_by' =>  Auth::user()->id,
                'updated_at' => DB::raw('NOW()'),
            ]);


        $record1 = DB::connection('mysql')->table('measurement_items')->where('id', $id)->first();


        $type = $request->type;
        $model_id = $request->model_id;
        $frame_id = $request->frame_id;
        $t_m_w = $request->t_m_w;
        $t_m_b_w = $request->t_m_b_w;
        $t_m_h = $request->t_m_h;
        $tm_sqft = $request->tm_sqft;
        $m_w_c_w = $request->m_w_c_w;
        $m_w_c_b_w = $request->m_w_c_b_w;
        $m_w_c_h = $request->m_w_c_h;
        $frame_size_id = $request->frame_size_id;
        $color_id =$request->color_id;
        $finish_work = $request->finish_work;
        $steel_beeding = $request->steel_beeding;
        $texture_finish = $request->texture_finish;
        $glass_type_id = $request->glass_type_id;
        $hinges = $request->hinges;
        $lock_id = $request->lock_id;
        $finish_work_front = $request->finish_work_front;
        $finish_work_back = $request->finish_work_back;
        $lock_measurement = $request->lock_measurement;
        $hinges_m = $request->hinges_m;
        $color_type = $request->color_type;
        $frame_color_id = $request->frame_color_id;
        $item_remarks = $request->item_remarks;
        $door_thickness = $request->door_thickness_id;
       
       // $batch_no = $request->batch_no;



        if(($type == 'Door Only') || ($type == 'Door Only Without Clearence')){
            if($tm_sqft <= 16){
               $d_resin_qty = 4.5;
            }
            else if(($tm_sqft > 16) || ($tm_sqft <= 17)){
               $d_resin_qty = 5.5;
            }
            else if(($tm_sqft > 17) || ($tm_sqft <= 18)){
               $d_resin_qty = 6.5;
            }
            else if(($tm_sqft > 18) || ($tm_sqft <= 19)){
               $d_resin_qty = 7.5;
            }
            else if(($tm_sqft > 19) || ($tm_sqft <= 20)){
               $d_resin_qty = 8.5;
            }
            else if(($tm_sqft > 20) || ($tm_sqft <= 21)){
               $d_resin_qty = 9.5;
            }
            else if(($tm_sqft > 21) || ($tm_sqft <= 22)){
               $d_resin_qty = 10.5;
            }
            else if(($tm_sqft > 22) || ($tm_sqft <= 23)){
               $d_resin_qty = 11.5;
            }
            else if(($tm_sqft > 23) || ($tm_sqft <= 24)){
               $d_resin_qty = 12.5;
            }
            else if(($tm_sqft > 24) || ($tm_sqft <= 25)){
               $d_resin_qty = 13.5;
            }
            else if(($tm_sqft > 25) || ($tm_sqft <= 26)){
               $d_resin_qty = 14.5;
            }
            else if(($tm_sqft > 26) || ($tm_sqft <= 27)){
               $d_resin_qty = 15.5;
            }
            else if(($tm_sqft > 27) || ($tm_sqft <= 28)){
               $d_resin_qty = 16.5;
            }
            else if(($tm_sqft > 28) || ($tm_sqft <= 29)){
               $d_resin_qty = 17.5;
            }
            else if(($tm_sqft > 29) || ($tm_sqft <= 30)){
               $d_resin_qty = 18.5;
            }
            else{
               $d_resin_qty = 4.5;
            }

           


            $paint_qty_1 = DB::connection('mysql')->table('doormodels')
            ->where('id', $model_id)
            ->value('paint_qty_color_1');
            $paint_qty_2 = DB::connection('mysql')->table('doormodels')
            ->where('id', $model_id)
            ->value('paint_qty_color_2');
            $paint_qty_3 = DB::connection('mysql')->table('doormodels')
            ->where('id', $model_id)
            ->value('paint_qty_color_3');

            $f_resin_qty = 0;
            $f_paint_qty = 0;



       }
       else if($type == 'Frame Only'){


       $paint_qty_1 = 0;
       $paint_qty_2 = 0;
       $paint_qty_3 = 0;
       $d_resin_qty = 0;

       $f_resin_qty = DB::connection('mysql')->table('doorclearances')
       ->where('id', $frame_size_id)
       ->value('resin_qty');

       $f_paint_qty = DB::connection('mysql')->table('doorclearances')
       ->where('id', $frame_size_id)
       ->value('paint_qty');

       }
       else{
           if($tm_sqft <= 16){
               $d_resin_qty = 4.5;
            }
            else if(($tm_sqft > 16) || ($tm_sqft <= 17)){
               $d_resin_qty = 5.5;
            }
            else if(($tm_sqft > 17) || ($tm_sqft <= 18)){
               $d_resin_qty = 6.5;
            }
            else if(($tm_sqft > 18) || ($tm_sqft <= 19)){
               $d_resin_qty = 7.5;
            }
            else if(($tm_sqft > 19) || ($tm_sqft <= 20)){
               $d_resin_qty = 8.5;
            }
            else if(($tm_sqft > 20) || ($tm_sqft <= 21)){
               $d_resin_qty = 9.5;
            }
            else if(($tm_sqft > 21) || ($tm_sqft <= 22)){
               $d_resin_qty = 10.5;
            }
            else if(($tm_sqft > 22) || ($tm_sqft <= 23)){
               $d_resin_qty = 11.5;
            }
            else if(($tm_sqft > 23) || ($tm_sqft <= 24)){
               $d_resin_qty = 12.5;
            }
            else if(($tm_sqft > 24) || ($tm_sqft <= 25)){
               $d_resin_qty = 13.5;
            }
            else if(($tm_sqft > 25) || ($tm_sqft <= 26)){
               $d_resin_qty = 14.5;
            }
            else if(($tm_sqft > 26) || ($tm_sqft <= 27)){
               $d_resin_qty = 15.5;
            }
            else if(($tm_sqft > 27) || ($tm_sqft <= 28)){
               $d_resin_qty = 16.5;
            }
            else if(($tm_sqft > 28) || ($tm_sqft <= 29)){
               $d_resin_qty = 17.5;
            }
            else if(($tm_sqft > 29) || ($tm_sqft <= 30)){
               $d_resin_qty = 18.5;
            }
            else{
               $d_resin_qty = 4.5;
            }

            

            $paint_qty_1 = DB::connection('mysql')->table('doormodels')
            ->where('id', $model_id)
            ->value('paint_qty_color_1');
            $paint_qty_2 = DB::connection('mysql')->table('doormodels')
            ->where('id', $model_id)
            ->value('paint_qty_color_2');
            $paint_qty_3 = DB::connection('mysql')->table('doormodels')
            ->where('id', $model_id)
            ->value('paint_qty_color_3');


            $f_resin_qty = DB::connection('mysql')->table('doorclearances')
            ->where('id', $frame_size_id)
            ->value('resin_qty');

            $f_paint_qty = DB::connection('mysql')->table('doorclearances')
            ->where('id', $frame_size_id)
            ->value('paint_qty');
       }


       if(($frame_color_id == 'Select') || $frame_color_id == ''){
        $fm_clr_id = 0;
        }
        else{
        $fm_clr_id = $frame_color_id;
        }
        
        if(($frame_size_id == 'Select') || ($frame_size_id == '')){
        $fm_sz = 0;
        }
        else{
        $fm_sz = $frame_size_id;
        }
        if(($color_id == 'Select') || ($color_id == '')){
        $clr_id = 0;
        }
        else{
        $clr_id = $color_id;
        }
        if(($glass_type_id == 'Nill') || ($glass_type_id == '') || ($glass_type_id == 'Select')){
        $gt = 0;
        }
        else{
        $gt = $glass_type_id;
        }
        if(($model_id == 'Select') || ($model_id == '')){
        $mdl = 0;
        }
        else{
        $mdl = $model_id; 
        }
        if(($lock_id == 'Select') || ($lock_id == '')){
        $lk = 0;
        }
        else{
        $lk = $lock_id; 
        }
        if(($door_thickness == 'Select') || ($door_thickness == '')){
            $dtns = 0;
            }
            else{
            $dtns = $door_thickness; 
            }

        // Update the record with the new data
        DB::connection('mysql')->table('measurement_items')->where('id', $id)
            ->update([
            'added_date' =>$order_date,
        
            'order_type' => $type,
            'model_id' =>  $mdl,
            'frame' =>  $frame_id,
            'tight_measurement_top_width' =>  $t_m_w,
            'tight_measurement_bottom_width' =>  $t_m_b_w,
            'tight_measurement_height' =>  $t_m_h,
            'tight_measurement_square_feet' => $tm_sqft,
            'measurement_with_clearance_top_width' =>  $m_w_c_w,
            'measurement_with_clearance_bottom_width' =>  $m_w_c_b_w,
            'measurement_with_clearance_height' => $m_w_c_h,
            'frame_size' =>  $fm_sz,
            'color_type' =>  $color_type,
            'color_id' =>  $clr_id,
            'frame_color_id' => $fm_clr_id,
            'finish_work' =>  $finish_work,
            'finish_work_front' =>  $finish_work_front,
            'finish_work_back' => $finish_work_back,
            'steel_beeding' =>  $steel_beeding,
            'texture_finish' =>  $texture_finish,
            'glass_type' => $gt,
            'hinges' =>  $hinges,
            'hinges_measurement' =>  $hinges_m,
            'lock_id' => $lk,
            'lock_measurement' => $lock_measurement,
            'door_resin_qty' =>  $d_resin_qty,
            'frame_resin_qty' =>  $f_resin_qty,
            'door_paint_qty_1' => $paint_qty_1,
            'door_paint_qty_2' => $paint_qty_2,
            'door_paint_qty_3' => $paint_qty_3,
            'frame_paint_qty' => $f_paint_qty,
            'status' => 1,
            'item_remarks' => $item_remarks,
            'door_thickness_id' => $dtns,
            'confirmed_by' =>  Auth::user()->id,
            'updated_at' => DB::raw('NOW()'),
            ]);
    
        // Find the record to update in database2
        $record2 = DB::connection('mysql_second')->table('measurement_items')->where('id', $id)->first();
    
        // Update the record with the new data
        DB::connection('mysql_second')->table('measurement_items')->where('id', $id)
            ->update([
            'added_date' => $order_date,
           
            'order_type' => $type,
            'model_id' =>  $mdl,
            'frame' =>  $frame_id,
            'tight_measurement_top_width' =>  $t_m_w,
            'tight_measurement_bottom_width' =>  $t_m_b_w,
            'tight_measurement_height' =>  $t_m_h,
            'tight_measurement_square_feet' => $tm_sqft,
            'measurement_with_clearance_top_width' =>  $m_w_c_w,
            'measurement_with_clearance_bottom_width' =>  $m_w_c_b_w,
            'measurement_with_clearance_height' => $m_w_c_h,
            'frame_size' =>  $fm_sz,
            'color_type' =>  $color_type,
            'color_id' =>  $clr_id,
            'frame_color_id' => $fm_clr_id,
            'finish_work' =>  $finish_work,
            'finish_work_front' =>  $finish_work_front,
            'finish_work_back' => $finish_work_back,
            'steel_beeding' =>  $steel_beeding,
            'texture_finish' =>  $texture_finish,
            'glass_type' => $gt,
            'hinges' =>  $hinges,
            'hinges_measurement' =>  $hinges_m,
            'lock_id' => $lk,
            'lock_measurement' => $lock_measurement,
            'door_resin_qty' =>  $d_resin_qty,
            'frame_resin_qty' =>  $f_resin_qty,
            'door_paint_qty_1' => $paint_qty_1,
            'door_paint_qty_2' => $paint_qty_2,
            'door_paint_qty_3' => $paint_qty_3,
            'frame_paint_qty' => $f_paint_qty,
            'status' => 1,
            'item_remarks' => $item_remarks,
            'door_thickness_id' => $dtns,
            'confirmed_by' =>  Auth::user()->id,
            'updated_at' => DB::raw('NOW()'),
            ]);


        return response()->json(['success' =>'success']);
    }
    public function check_measurement_items_status(Request $request){
        $m_id = $request->m_id;
        $m_items = DB::table('measurement_items')
        ->select('measurement_items.*')
        ->where("m_id", "=", $m_id)
        ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->where("status", "=", 0)
        ->get();
        if ($m_items->isEmpty()) {
           $val = 0;
        } else {
            $val = 1;
        }
        return response()->json(['val' =>$val]);
    }
    public function confirmed_order_list(){

       
		return view('fitting.measurement.confirmed_order_list'); 
    
    }
    public function get_confirmed_order_list_fitting(){
        $draw = request()->input('draw');
        $start = request()->input('start');
        $length = request()->input('length');
    
    
    
        $result =DB::table('measurements')
        ->select('measurements.*','customers.customer_name','doorbrands.brand_name')
        ->leftjoin('customers', 'measurements.customer_id', '=', 'customers.id')
        ->leftjoin('doorbrands', 'measurements.brand_id', '=', 'doorbrands.id')
        ->where("measurements.delete_status", "=", 0)
        ->where("measurements.company_id", "=", Session::get('company_id'))
        ->where("measurements.status", "=", 'Confirmed')
        ->get();
        
    $data = [];
    $slno = 1;
            
            
            
    foreach ($result as $r) {
      
    
    $viewButton = '<a href="' . route('completed_order_view_fitting',$r->id ) . '">  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
    <path
        opacity="0.5"
        d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
        stroke="currentColor"
        stroke-width="1.5"
    ></path>
    <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="1.5"></path>
    </svg></a>';
    
  
    
    
    $btns = '<div class="flex gap-4 items-center">'.$viewButton.'</div>';
  
   $date = \Carbon\Carbon::parse($r->order_date)->format('d-m-Y') ;
  
        $data[] = array(
            $slno,
            $r->order_no,
            $date,
            $r->customer_name,
            $r->brand_name,
            $r->delivery_date,
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
    public function completed_order_edit(string $id){
        $result = DB::table('measurements')
        ->select('measurements.*')
        ->where("measurements.id", "=", $id)
        ->first();


        $m_items = DB::table('measurement_items')
        ->select('measurement_items.*','doormodels.model_name')
        ->join('doormodels','measurement_items.model_id','=','doormodels.id')
  
        ->where("measurement_items.m_id", "=", $id)
        ->where("measurement_items.delete_status", "=", "0")
        ->get();

        $customer_lists =  DB::table('customers')
        ->select('customers.*')
        ->where("customers.delete_status", "=", 0)
        ->where("customers.company_id", "=", Session::get('company_id'))
        ->get();

        $executive_lists =  DB::table('users')
        ->select('users.*')
        ->where("users.department", "=", "executive")
        ->where("users.delete_status", "=", 0)
        ->where("users.company_id", "=", Session::get('company_id'))
        ->get();

        $model_lists =  DB::table('doormodels')
        ->select('doormodels.*')
        ->where("doormodels.delete_status", "=", 0)
        ->where("doormodels.company_id", "=", Session::get('company_id'))
        ->get();

        $color_lists =  DB::table('colors')
        ->select('colors.*')
        ->where("colors.delete_status", "=", 0)
        ->where("colors.company_id", "=", Session::get('company_id'))
        ->get();

        $root_lists =  DB::table('doorroots')
        ->select('doorroots.*')
        ->where("doorroots.delete_status", "=", 0)
        ->where("doorroots.company_id", "=", Session::get('company_id'))
        ->get();

        $gt_lists = DB::table('glasstypes')
        ->select('glasstypes.*')
        ->where("glasstypes.delete_status", "=", 0)
        ->where("glasstypes.company_id", "=", Session::get('company_id'))
        ->get();

        $lk_lists = DB::table('doorlocks')
        ->select('doorlocks.*')
        ->where("doorlocks.delete_status", "=", 0)
        ->where("doorlocks.company_id", "=", Session::get('company_id'))
        ->get();

        $fs_lists =  DB::table('doorclearances')
        ->select('doorclearances.*')
        ->where("doorclearances.delete_status", "=", 0)
        ->where("doorclearances.company_id", "=", Session::get('company_id'))
        ->get();

        return view('fitting.measurement.completed_order_edit',compact('result','m_items','customer_lists','executive_lists','model_lists','color_lists','root_lists','gt_lists','lk_lists','fs_lists'))->with('no', 0);
    }
    public function completed_order_update(Request $request, string $id)
    {
        $record1 = DB::connection('mysql')->table('measurements')->where('id', $id)->first();

        // Update the record with the new data
        DB::connection('mysql')->table('measurements')->where('id', $id)
            ->update([
                'fitting_or_packing' =>  request('fitting_or_packing'),
                'order_date' =>  request('order_date'),
                'delivery_date' =>  request('delivery_date'),
                'order_no' =>  request('order_no'),
                'customer_id' =>  request('customer_id'),
                'executive_id' =>  request('executive'),
                'root_id' =>  request('root_id'),
                'site_name' =>  request('site_name'),
                'site_address' =>  request('site_address'),
                'remarks' =>  request('remarks'),
                'status' => 'Confirmed',
                'edited_by' =>  Auth::user()->id,
                'updated_at' => DB::raw('NOW()'),
            ]);
    
        // Find the record to update in database2
        $record2 = DB::connection('mysql_second')->table('measurements')->where('id', $id)->first();
    
        // Update the record with the new data
        DB::connection('mysql_second')->table('measurements')->where('id', $id)
            ->update([
                'fitting_or_packing' =>  request('fitting_or_packing'),
                'order_date' =>  request('order_date'),
                'delivery_date' =>  request('delivery_date'),
                'order_no' =>  request('order_no'),
                'customer_id' =>  request('customer_id'),
                'executive_id' =>  request('executive'),
                'root_id' =>  request('root_id'),
                'site_name' =>  request('site_name'),
                'site_address' =>  request('site_address'),
                'remarks' =>  request('remarks'),
                'status' => 'Confirmed',
                'edited_by' =>  Auth::user()->id,
                'updated_at' => DB::raw('NOW()'),
            ]);

     

            return redirect(route('confirmed_order_list_fitting'));
    }
    public function completed_order_items_update(Request $request){
        $id = $request->mt_id;


        $record1 = DB::connection('mysql')->table('measurement_items')->where('id', $id)->first();

        // Update the record with the new data
        DB::connection('mysql')->table('measurement_items')->where('id', $id)
            ->update([
                  'model_id' =>  $request->model_pop_up,
                  'frame' =>  $request->frame_pop_up,
                  'tight_measurement_top_width' => $request->t_m_w_pop_up,
                  'tight_measurement_bottom_width' =>  $request->t_m_b_w_pop_up,
                  'tight_measurement_height' => $request->t_m_h_pop_up,
                  'measurement_with_clearance_top_width' => $request->m_w_c_w_pop_up,
                  'measurement_with_clearance_bottom_width' => $request->m_w_c_b_w_pop_up,
                  'measurement_with_clearance_height' => $request->m_w_c_h_pop_up,
                  'frame_size' => $request->frame_size_pop_up,
                  'color_type' =>  $request->color_type_pop_up,
                  'color_id' => $request->color_pop_up,
                  'finish_work' => $request->finish_work_pop_up,
                  'finish_work_front' => $request->finish_work_front_pop_up,
                  'finish_work_back' => $request->finish_work_back_pop_up,
                  'steel_beeding' => $request->steel_beeding_pop_up,
                  'texture_finish' => $request->texture_finish_pop_up,
                  'glass_type' => $request->glass_type_pop_up,
                  'hinges' => $request->hinges_pop_up,
                  'hinges_measurement' =>$request->hinges_m_pop_up,
                  'lock_id' => $request->lock_pop_up,
                  'lock_measurement' => $request->lock_measurement_pop_up,
                  'updated_at' => DB::raw('NOW()'),
            ]);
    
        // Find the record to update in database2
        $record2 = DB::connection('mysql_second')->table('measurement_items')->where('id', $id)->first();
    
        // Update the record with the new data
        DB::connection('mysql_second')->table('measurement_items')->where('id', $id)
            ->update([
                'model_id' =>  $request->model_pop_up,
                'frame' =>  $request->frame_pop_up,
                'tight_measurement_top_width' => $request->t_m_w_pop_up,
                'tight_measurement_bottom_width' =>  $request->t_m_b_w_pop_up,
                'tight_measurement_height' => $request->t_m_h_pop_up,
                'measurement_with_clearance_top_width' => $request->m_w_c_w_pop_up,
                'measurement_with_clearance_bottom_width' => $request->m_w_c_b_w_pop_up,
                'measurement_with_clearance_height' => $request->m_w_c_h_pop_up,
                'frame_size' => $request->frame_size_pop_up,
                'color_type' =>  $request->color_type_pop_up,
                'color_id' => $request->color_pop_up,
                'finish_work' => $request->finish_work_pop_up,
                'finish_work_front' => $request->finish_work_front_pop_up,
                'finish_work_back' => $request->finish_work_back_pop_up,
                'steel_beeding' => $request->steel_beeding_pop_up,
                'texture_finish' => $request->texture_finish_pop_up,
                'glass_type' => $request->glass_type_pop_up,
                'hinges' => $request->hinges_pop_up,
                'hinges_measurement' =>$request->hinges_m_pop_up,
                'lock_id' => $request->lock_pop_up,
                'lock_measurement' => $request->lock_measurement_pop_up,
                'updated_at' => DB::raw('NOW()'),
            ]);


        return response()->json(['success' =>'success']);
    }
    public function measurment_form_view(string $id){
        $result = DB::table('measurements')
        ->select('measurements.*','customers.customer_name','customers.permenant_address','users.name','doorroots.root_name','doorbrands.brand_name')
        ->leftjoin('customers','measurements.customer_id','=','customers.id')
        ->leftjoin('doorbrands','measurements.brand_id','=','doorbrands.id')
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

            if($m_item->color_id == 0){
                $m_item->door_color_name = '-';
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
        

        

        return view('fitting.measurement.measurment_form_view',compact('result','m_items'))->with('no', 1);
    }
    public function get_color_type_and_color_name(Request $request){
        $model_id = $request->model_id;

        $details =  DB::table('doormodels')
        ->select('doormodels.*')
        ->where("doormodels.id", "=", $model_id)
        ->where("doormodels.delete_status", "=", 0)
        ->where("doormodels.company_id", "=", Session::get('company_id'))
        ->first();
        

        return response()->json(['details' =>$details]);
    }
    public function get_sub_models(Request $request){
        $model_id = $request->model_id;
        $sub_models =  DB::table('dooritems')
        ->select('dooritems.id','dooritems.item_name')
        ->where("dooritems.model_id", "=", $model_id)
        ->where("dooritems.delete_status", "=", 0)
        ->where("dooritems.company_id", "=", Session::get('company_id'))
        ->get();
        

        return response()->json(['sub_models' =>$sub_models]);

    }
    public function get_details_of_sub_model(Request $request){
        $sub_model_id = $request->sub_model_id;

        $details =  DB::table('dooritems')
        ->select('dooritems.*')
        ->where("dooritems.id", "=", $sub_model_id)
        ->where("dooritems.delete_status", "=", 0)
        ->where("dooritems.company_id", "=", Session::get('company_id'))
        ->first();

        return response()->json(['details' =>$details]);
    }
    public function get_color_type_details(Request $request){
        $model_id = $request->model_id;

        $details =  DB::table('doormodels')
        ->select('doormodels.*')
        ->where("doormodels.id", "=", $model_id)
        ->where("doormodels.delete_status", "=", 0)
        ->where("doormodels.company_id", "=", Session::get('company_id'))
        ->first();

        return response()->json(['details' =>$details]);  
    }
    public function save_as_tem_data_m_items(Request $request){
        $order_no = $request->order_no;
        $type = $request->type;
        $model_id = $request->model_id;
        $frame_id = $request->frame_id;
        $t_m_w = $request->t_m_w;
        $t_m_b_w = $request->t_m_b_w;
        $t_m_h = $request->t_m_h;
        $tm_sqft = $request->tm_sqft;
        $m_w_c_w = $request->m_w_c_w;
        $m_w_c_b_w = $request->m_w_c_b_w;
        $m_w_c_h = $request->m_w_c_h;
        $frame_size_id = $request->frame_size_id;
        $color_id =$request->color_id;
        $finish_work = $request->finish_work;
        $steel_beeding = $request->steel_beeding;
        $texture_finish = $request->texture_finish;
        $glass_type_id = $request->glass_type_id;
        $hinges = $request->hinges;
        $lock_id = $request->lock_id;
        $finish_work_front = $request->finish_work_front;
        $finish_work_back = $request->finish_work_back;
        $lock_measurement = $request->lock_measurement;
        $hinges_m = $request->hinges_m;
        $color_type = $request->color_type;
        $frame_color_id = $request->frame_color_id;
        $item_remarks = $request->item_remarks;
        $door_thickness = $request->door_thickness;
       // $batch_no = $request->batch_no;



        if(($type == 'Door Only') || ($type == 'Door Only Without Clearence')){
            if($tm_sqft <= 16){
               $d_resin_qty = 4.5;
            }
            else if(($tm_sqft > 16) || ($tm_sqft <= 17)){
               $d_resin_qty = 5.5;
            }
            else if(($tm_sqft > 17) || ($tm_sqft <= 18)){
               $d_resin_qty = 6.5;
            }
            else if(($tm_sqft > 18) || ($tm_sqft <= 19)){
               $d_resin_qty = 7.5;
            }
            else if(($tm_sqft > 19) || ($tm_sqft <= 20)){
               $d_resin_qty = 8.5;
            }
            else if(($tm_sqft > 20) || ($tm_sqft <= 21)){
               $d_resin_qty = 9.5;
            }
            else if(($tm_sqft > 21) || ($tm_sqft <= 22)){
               $d_resin_qty = 10.5;
            }
            else if(($tm_sqft > 22) || ($tm_sqft <= 23)){
               $d_resin_qty = 11.5;
            }
            else if(($tm_sqft > 23) || ($tm_sqft <= 24)){
               $d_resin_qty = 12.5;
            }
            else if(($tm_sqft > 24) || ($tm_sqft <= 25)){
               $d_resin_qty = 13.5;
            }
            else if(($tm_sqft > 25) || ($tm_sqft <= 26)){
               $d_resin_qty = 14.5;
            }
            else if(($tm_sqft > 26) || ($tm_sqft <= 27)){
               $d_resin_qty = 15.5;
            }
            else if(($tm_sqft > 27) || ($tm_sqft <= 28)){
               $d_resin_qty = 16.5;
            }
            else if(($tm_sqft > 28) || ($tm_sqft <= 29)){
               $d_resin_qty = 17.5;
            }
            else if(($tm_sqft > 29) || ($tm_sqft <= 30)){
               $d_resin_qty = 18.5;
            }
            else{
               $d_resin_qty = 4.5;
            }

           


            $paint_qty_1 = DB::connection('mysql')->table('doormodels')
            ->where('id', $model_id)
            ->value('paint_qty_color_1');
            $paint_qty_2 = DB::connection('mysql')->table('doormodels')
            ->where('id', $model_id)
            ->value('paint_qty_color_2');
            $paint_qty_3 = DB::connection('mysql')->table('doormodels')
            ->where('id', $model_id)
            ->value('paint_qty_color_3');

            $f_resin_qty = 0;
            $f_paint_qty = 0;



       }
       else if($type == 'Frame Only'){


       $paint_qty_1 = 0;
       $paint_qty_2 = 0;
       $paint_qty_3 = 0;
       $d_resin_qty = 0;

       $f_resin_qty = DB::connection('mysql')->table('doorclearances')
       ->where('id', $frame_size_id)
       ->value('resin_qty');

       $f_paint_qty = DB::connection('mysql')->table('doorclearances')
       ->where('id', $frame_size_id)
       ->value('paint_qty');

       }
       else{
           if($tm_sqft <= 16){
               $d_resin_qty = 4.5;
            }
            else if(($tm_sqft > 16) || ($tm_sqft <= 17)){
               $d_resin_qty = 5.5;
            }
            else if(($tm_sqft > 17) || ($tm_sqft <= 18)){
               $d_resin_qty = 6.5;
            }
            else if(($tm_sqft > 18) || ($tm_sqft <= 19)){
               $d_resin_qty = 7.5;
            }
            else if(($tm_sqft > 19) || ($tm_sqft <= 20)){
               $d_resin_qty = 8.5;
            }
            else if(($tm_sqft > 20) || ($tm_sqft <= 21)){
               $d_resin_qty = 9.5;
            }
            else if(($tm_sqft > 21) || ($tm_sqft <= 22)){
               $d_resin_qty = 10.5;
            }
            else if(($tm_sqft > 22) || ($tm_sqft <= 23)){
               $d_resin_qty = 11.5;
            }
            else if(($tm_sqft > 23) || ($tm_sqft <= 24)){
               $d_resin_qty = 12.5;
            }
            else if(($tm_sqft > 24) || ($tm_sqft <= 25)){
               $d_resin_qty = 13.5;
            }
            else if(($tm_sqft > 25) || ($tm_sqft <= 26)){
               $d_resin_qty = 14.5;
            }
            else if(($tm_sqft > 26) || ($tm_sqft <= 27)){
               $d_resin_qty = 15.5;
            }
            else if(($tm_sqft > 27) || ($tm_sqft <= 28)){
               $d_resin_qty = 16.5;
            }
            else if(($tm_sqft > 28) || ($tm_sqft <= 29)){
               $d_resin_qty = 17.5;
            }
            else if(($tm_sqft > 29) || ($tm_sqft <= 30)){
               $d_resin_qty = 18.5;
            }
            else{
               $d_resin_qty = 4.5;
            }

            

            $paint_qty_1 = DB::connection('mysql')->table('doormodels')
            ->where('id', $model_id)
            ->value('paint_qty_color_1');
            $paint_qty_2 = DB::connection('mysql')->table('doormodels')
            ->where('id', $model_id)
            ->value('paint_qty_color_2');
            $paint_qty_3 = DB::connection('mysql')->table('doormodels')
            ->where('id', $model_id)
            ->value('paint_qty_color_3');


            $f_resin_qty = DB::connection('mysql')->table('doorclearances')
            ->where('id', $frame_size_id)
            ->value('resin_qty');

            $f_paint_qty = DB::connection('mysql')->table('doorclearances')
            ->where('id', $frame_size_id)
            ->value('paint_qty');
       }


if(($frame_color_id == 'Select') || $frame_color_id == ''){
$fm_clr_id = 0;
}
else{
$fm_clr_id = $frame_color_id;
}

if(($frame_size_id == 'Select') || ($frame_size_id == '')){
$fm_sz = 0;
}
else{
$fm_sz = $frame_size_id;
}
if(($color_id == 'Select') || ($color_id == '')){
$clr_id = 0;
}
else{
$clr_id = $color_id;
}
if(($glass_type_id == 'Nill') || ($glass_type_id == '') || ($glass_type_id == 'Select')){
$gt = 0;
}
else{
$gt = $glass_type_id;
}
if(($model_id == 'Select') || ($model_id == '')){
$mdl = 0;
}
else{
$mdl = $model_id; 
}
if(($lock_id == 'Select') || ($lock_id == '')){
$lk = 0;
}
else{
$lk = $lock_id; 
}

if(($door_thickness == 'Select') || ($door_thickness == '')){
    $dtns = 0;
    }
    else{
    $dtns = $door_thickness; 
    }

$tableName = 'measurement_items_temp';
$order_no = request('order_no');

// Use the count method to get the row count
$rowCount = DB::table($tableName)
    ->where('order_no', $order_no)
    ->count();

// Increment the row count by 1
$rowCount += 1;



        DB::connection('mysql')->table('measurement_items_temp')->insert([
            'order_no' => $order_no,
          
            'order_type' => $type,
            'model_id' =>  $mdl,
            'frame' =>  $frame_id,
            'tight_measurement_top_width' =>  $t_m_w,
            'tight_measurement_bottom_width' =>  $t_m_b_w,
            'tight_measurement_height' =>  $t_m_h,
            'tight_measurement_square_feet' => $tm_sqft,
            'measurement_with_clearance_top_width' =>  $m_w_c_w,
            'measurement_with_clearance_bottom_width' =>  $m_w_c_b_w,
            'measurement_with_clearance_height' => $m_w_c_h,
            'frame_size' =>  $fm_sz,
            'color_type' =>  $color_type,
            'color_id' =>  $clr_id,
            'frame_color_id' => $fm_clr_id,
            'finish_work' =>  $finish_work,
            'finish_work_front' =>  $finish_work_front,
            'finish_work_back' => $finish_work_back,
            'steel_beeding' =>  $steel_beeding,
            'texture_finish' =>  $texture_finish,
            'glass_type' => $gt,
            'hinges' =>  $hinges,
            'hinges_measurement' =>  $hinges_m,
            'lock_id' => $lk,
            'lock_measurement' => $lock_measurement,
            'door_resin_qty' =>  $d_resin_qty,
            'frame_resin_qty' =>  $f_resin_qty,
            'door_paint_qty_1' => $paint_qty_1,
            'door_paint_qty_2' => $paint_qty_2,
            'door_paint_qty_3' => $paint_qty_3,
            'frame_paint_qty' => $f_paint_qty,
            'item_remarks' => $item_remarks,
            'door_thickness_id' => $dtns,
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);

        DB::connection('mysql_second')->table('measurement_items_temp')->insert([
            'order_no' => $order_no,
          
            'order_type' => $type,
            'model_id' =>  $mdl,
            'frame' =>  $frame_id,
            'tight_measurement_top_width' =>  $t_m_w,
            'tight_measurement_bottom_width' =>  $t_m_b_w,
            'tight_measurement_height' =>  $t_m_h,
            'tight_measurement_square_feet' => $tm_sqft,
            'measurement_with_clearance_top_width' =>  $m_w_c_w,
            'measurement_with_clearance_bottom_width' =>  $m_w_c_b_w,
            'measurement_with_clearance_height' => $m_w_c_h,
            'frame_size' =>  $fm_sz,
            'color_type' =>  $color_type,
            'color_id' =>  $clr_id,
            'frame_color_id' => $fm_clr_id,
            'finish_work' =>  $finish_work,
            'finish_work_front' =>  $finish_work_front,
            'finish_work_back' => $finish_work_back,
            'steel_beeding' =>  $steel_beeding,
            'texture_finish' =>  $texture_finish,
            'glass_type' => $gt,
            'hinges' =>  $hinges,
            'hinges_measurement' =>  $hinges_m,
            'lock_id' => $lk,
            'lock_measurement' => $lock_measurement,
            'door_resin_qty' =>  $d_resin_qty,
            'frame_resin_qty' =>  $f_resin_qty,
            'door_paint_qty_1' => $paint_qty_1,
            'door_paint_qty_2' => $paint_qty_2,
            'door_paint_qty_3' => $paint_qty_3,
            'frame_paint_qty' => $f_paint_qty,
            'item_remarks' => $item_remarks,
            'door_thickness_id' => $dtns,
            'company_id' => Session::get('company_id'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);



        $mt_lists =  DB::table('measurement_items_temp')
        ->select('measurement_items_temp.*','doormodels.model_name')
        ->leftjoin('doormodels', 'measurement_items_temp.model_id', '=', 'doormodels.id')
        ->where("measurement_items_temp.order_no", "=", $order_no)
        ->where("measurement_items_temp.company_id", "=", Session::get('company_id'))
        ->get();

      
        return response()->json(['mt_lists' => $mt_lists]);  
    }
    public function delete_m_temp_item(Request $request){
        $itemId = $request->itemId;
        DB::table('measurement_items_temp')->where('id', $itemId)->delete();
        return response()->json(['success' => true]);
    }
    public function get_list_of_m_items(Request $request){
        $order_no = $request->order_no;
        $mt_lists =  DB::table('measurement_items_temp')
        ->select('measurement_items_temp.*','doormodels.model_name')
        ->leftjoin('doormodels', 'measurement_items_temp.model_id', '=', 'doormodels.id')
        ->where("measurement_items_temp.order_no", "=", $order_no)
        ->where("measurement_items_temp.company_id", "=", Session::get('company_id'))
        ->get();

      
        return response()->json(['mt_lists' => $mt_lists]);  
    }
    public function check_in_measurement_items(Request $request){
        $order_no = $request->order_no;

            $details = DB::table('measurement_items_temp')
                ->select('measurement_items_temp.*')
                ->where('measurement_items_temp.order_no', '=', $order_no)
                ->where('measurement_items_temp.company_id', '=', Session::get('company_id'))
                ->first();

            if ($details) {
                // Order number exists
                DB::table('measurement_items_temp')
                ->where('measurement_items_temp.order_no', '=', $order_no)
                ->where('measurement_items_temp.company_id', '=', Session::get('company_id'))
                ->delete();

                return response()->json(['result' => 1]);
            } else {
                // Order number does not exist
                return response()->json(['result' => 0]);
            } 
    }
    public function fitting_change_password(){
        return view('fitting.change_password'); 
    }
   
    public function change_password_fitting(Request $request, string $id)
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
        return redirect()->route('fitting_change_password')->with('success', 'Password changed successfully.');
    
}
public function get_top_width_clearence_door_only_fitting(Request $request){
    $details = DB::table('doorclearances')
    ->select('doorclearances.*')
    ->where("company_id", "=", Session::get('company_id'))
    ->where("delete_status", "=", 0)
    ->where("frame_size", "=", 'DOOR ONLY')
    ->first();



return response()->json(['details' =>$details]);
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
}
