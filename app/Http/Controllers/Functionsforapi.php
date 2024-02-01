<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit AS ut ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Functionsforapi extends Controller
{
    public function list_unit(Request $request)
    {
        $ut_lists = ut::select("*")
        // ->where("company_id", "=", Session::get('company_id'))
        ->where("delete_status", "=", 0)
        ->get();
       
        return response()->json(['ut_lists' => $ut_lists]);
    }
    public function login_api(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->accessToken;

            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

}
?>
