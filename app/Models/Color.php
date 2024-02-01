<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Color extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function get_color_name($color_id){
       return $result =  DB::table('colors')
        ->select('colors.*','s_product.product_name as s_product_name','c_product.product_name as c_product_name','t_product.product_name as t_product_name')
        ->leftjoin('products as s_product', 's_product.id', '=', 'colors.color_name_product_id')
        ->leftjoin('products as c_product', 'c_product.id', '=', 'colors.combo_color_name_product_id')
        ->leftjoin('products as t_product', 't_product.id', '=', 'colors.triple_color_name_product_id')
        ->where("colors.id", "=", $color_id)
        ->first();
    }
    public function get_frame_color_name($f_c_id){
        return $result_frame_color =  DB::table('colors')
        ->select('colors.*','products.product_name')
        ->join('products', 'products.id', '=', 'colors.color_name_product_id')
        ->where("colors.id", "=", $f_c_id)
        ->first();
    }
}
