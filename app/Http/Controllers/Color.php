<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color AS clr ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Color extends Controller
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
       
		return view('admin.door_masters.color.index');
    }
    public function get_door_color_list(){
        $draw = request()->input('draw');
        $start = request()->input('start');
        $length = request()->input('length');
    
    
    
        $result =  DB::table('colors')
        ->select('colors.*', 'color_name_products.product_name as s_c_p_name', 'combo_color_products.product_name as c_c_p_name', 'triple_color_products.product_name as t_c_p_name')
        ->leftJoin('products as color_name_products', 'colors.color_name_product_id', '=', 'color_name_products.id')
        ->leftJoin('products as combo_color_products', 'colors.combo_color_name_product_id', '=', 'combo_color_products.id')
        ->leftJoin('products as triple_color_products', 'colors.triple_color_name_product_id', '=', 'triple_color_products.id')
        ->where("colors.delete_status", "=", 0)
        ->where("colors.company_id", "=", Session::get('company_id'))
        ->get();
        
    $data = [];
    $slno = 1;
            
            
            
    foreach ($result as $r) {
      
    
        $editButton = '<a href="' . route('color_edit',$r->id ) . '"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
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
    
    
    $btns = '<form method="post" action="'. route('color_delete', $r->id) .'">'. csrf_field() . method_field('DELETE') .'<div class="flex gap-4 items-center">'.$editButton.$deleteButton.'</div></form>';
    
    if ($r->color_type == "Single")
{
    $color_name = $r->s_c_p_name;
}
elseif ($r->color_type == "Combo"){
    $color_name = $r->s_c_p_name."&".$r->c_c_p_name;
}
elseif ($r->color_type == "Triple"){
    $color_name = $r->s_c_p_name."&".$r->c_c_p_name."&".$r->t_c_p_name;
}

        $data[] = array(
            $slno,
            $r->color_type,
            $color_name,
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
        $color_list =  DB::table('products')
        ->select('products.*')
        ->where("products.category_id", "=", 1)
        ->where("products.delete_status", "=", 0)
        ->where("products.company_id", "=", Session::get('company_id'))
        ->get();
        $data = ['color_list'=> $color_list];
        return view('admin.door_masters.color.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'color_type' => 'required|in:Single,Combo,Triple',
        ]);
        $color_name =request('color_name');
        $combo_color_name =request('combo_color_name');
        $triple_color_name =request('triple_color_name');

           if($combo_color_name == 'Select'){
            $cm_nm = 0;
           }
           else{
            $cm_nm = $combo_color_name;
           }


           if($triple_color_name == 'Select'){
            $tp_nm = 0;
           }
           else{
            $tp_nm = $triple_color_name;
           }

        

        DB::transaction(function () use ($cm_nm,$tp_nm) {
            DB::connection('mysql')->table('colors')->insert([
                'color_type' => request('color_type'),
                'color_name_product_id' =>  request('color_name'),
                'combo_color_name_product_id' => $cm_nm,
                'triple_color_name_product_id' => $tp_nm,
                'created_by' =>  Auth::user()->id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        
            DB::connection('mysql_second')->table('colors')->insert([
                'color_type' => request('color_type'),
                'color_name_product_id' =>  request('color_name'),
                'combo_color_name_product_id' => $cm_nm,
                'triple_color_name_product_id' => $tp_nm,
                'created_by' =>  Auth::user()->id,
                'company_id' => Session::get('company_id'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        });


        return redirect(route('color_list'));
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
    public function edit(clr $id)
    {

        $result = $id;

        $color_list =  DB::table('products')
        ->select('products.*')
        ->where("products.category_id", "=", 1)
        ->where("products.delete_status", "=", 0)
        ->where("products.company_id", "=", Session::get('company_id'))
        ->get();

        return view('admin.door_masters.color.edit',compact('result','color_list'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'color_type' => 'required|in:Single,Combo,Triple',
        ]);
        $color_name =request('color_name');
        $combo_color_name =request('combo_color_name');
        $triple_color_name =request('triple_color_name');

           if($combo_color_name == 'Select'){
            $cm_nm = 0;
           }
           else{
            $cm_nm = $combo_color_name;
           }


           if($triple_color_name == 'Select'){
            $tp_nm = 0;
           }
           else{
            $tp_nm = $triple_color_name;
           }



          // Find the record to update in database1
    $record1 = DB::connection('mysql')->table('colors')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql')->table('colors')->where('id', $id)
        ->update([
            'color_type' => request('color_type'),
            'color_name_product_id' =>  request('color_name'),
            'combo_color_name_product_id' => $cm_nm,
            'triple_color_name_product_id' => $tp_nm,
            'edited_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);

    // Find the record to update in database2
    $record2 = DB::connection('mysql_second')->table('colors')->where('id', $id)->first();

    // Update the record with the new data
    DB::connection('mysql_second')->table('colors')->where('id', $id)
        ->update([
            'color_type' => request('color_type'),
            'color_name_product_id' =>  request('color_name'),
            'combo_color_name_product_id' => $cm_nm,
                'triple_color_name_product_id' => $tp_nm,
            'edited_by' =>  Auth::user()->id,
            'company_id' => Session::get('company_id'),
            'updated_at' => DB::raw('NOW()'),
        ]);



        return redirect(route('color_list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record1 = DB::connection('mysql')->table('colors')->where('id', $id)->first();

        // Update the record with the new data
        DB::connection('mysql')->table('colors')->where('id', $id)
            ->update([
                'delete_status' => 1,
                'deleted_by' =>  Auth::user()->id,
                'updated_at' => DB::raw('NOW()'),
            ]);
    
        // Find the record to update in database2
        $record2 = DB::connection('mysql_second')->table('colors')->where('id', $id)->first();
    
        // Update the record with the new data
        DB::connection('mysql_second')->table('colors')->where('id', $id)
            ->update([
                'delete_status' => 1,
                'deleted_by' =>  Auth::user()->id,
                'updated_at' => DB::raw('NOW()'),
            ]);
    
            return redirect(route('color_list'));
    }
}
