<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Measurement extends Model
{
    use HasFactory;



    public function check_status($model_id){
       if( $model_id == 0){
        return '-';
       }
       else{
        $result_model = DB::table('doormodels')
        ->select('doormodels.*')
        ->where('doormodels.id', '=', $model_id)
        ->where('doormodels.delete_status', '=', 0)
        ->first();

        $die_type = $result_model->die_type;
          if($die_type == 'BACK SAME DIE'){

            $result = DB::table('doordies')
            ->select('doordies.*')
            ->where('doordies.model_id', '=', $model_id)
            ->where('doordies.die_status', '=', 'Active')
            ->get();
            if(empty($result)){
                return 'Not Available';
            }
            else {
                return 'Available';
            }

          }
          else{

            $result_f = DB::table('doordies')
            ->select('doordies.*')
            ->where('doordies.model_id', '=', $model_id)
            ->where('doordies.die_side', '=', 'Front')
            ->where('doordies.die_status', '=', 'Active')
            ->get();

            $result_b = DB::table('doordies')
            ->select('doordies.*')
            ->where('doordies.die_side', '=', 'Back')
            ->where('doordies.die_status', '=', 'Active')
            ->get();

            if ($result_f->isEmpty() && $result_b->isEmpty()) {
                return  'Not Available';
            }
           else if ($result_f->isEmpty() || $result_b->isEmpty()) {
                return  'Not Available';
            }
            else{
                return 'Available';
            }



          }
       }

        


           
    }
}
