<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Schema;
use App\Models\Company AS comp ;
use App\Models\Currency AS crny ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;


class Company extends Controller
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
        $company_lists = comp::all();
        $currency_lists = crny::all();
		$data = ['company_lists'=> $company_lists,'currency_lists'=> $currency_lists];
		return view('superadmin.company.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currency_lists = crny::all();
        $data = ['currency_lists'=> $currency_lists];
        $rowCount = DB::table('companies')->count();
         if($rowCount == 0 ){
            return view('superadmin.company.create',$data);
         }
         else{
            $result = DB::connection('mysql')->table('companies')->first();
            return view('superadmin.company.edit',compact('result','currency_lists'));
         }
		
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'address_line_one' => 'required',
            'currency_id' => 'required',
            'pincode' => 'required',
            'city' => 'required',
            'mobile_no' => 'required',
            'company_established_from' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create a new company in the first database connection
        $company = new comp;
        $company->company_name = $request->company_name;
        $company->currency_id = $request->currency_id;
        $company->leagal_name = $request->legal_name;
        $company->gst_in = $request->gst_in;
        $company->gst_applicable_from = $request->gst_applicable_from;
        $company->type_of_organization = $request->type_of_organization;
        $company->address_line_one = $request->address_line_one;
        $company->address_line_two = $request->address_line_two;
        $company->country_id = $request->currency_id;
        $company->pincode = $request->pincode;
        $company->state = $request->state;
        $company->city = $request->city;
        $company->phone_no = $request->phone_no;
        $company->mobile_no = $request->mobile_no;
        $company->fax_no = $request->fax_no;
        $company->website = $request->website;
        $company->email_id = $request->email_id;
        $company->company_established_from = $request->company_established_from;

        if ($request->file('logo')) {
            $logoPath = $request->file('logo')->store('company_logos', 'public');
            $company->company_logo = $logoPath;
        }

        if ($request->file('signature')) {
            $signaturePath = $request->file('signature')->store('company_signatures', 'public');
            $company->signature = $signaturePath;
        }

        $company->save();

        // Create a new company in the second database connection
        \DB::connection('mysql_second')->table('companies')->insert([
            'company_name' => $request->company_name,
            'currency_id' => $request->currency_id,
            'leagal_name' => $request->legal_name,
            'gst_in' => $request->gst_in,
            'gst_applicable_from' => $request->gst_applicable_from,
            'type_of_organization' => $request->type_of_organization,
            'address_line_one' => $request->address_line_one,
            'address_line_two' => $request->address_line_two,
            'country_id' => $request->currency_id,
            'pincode' => $request->pincode,
            'state' => $request->state,
            'city' => $request->city,
            'phone_no' => $request->phone_no,
            'mobile_no' => $request->mobile_no,
            'fax_no' => $request->fax_no,
            'website' => $request->website,
            'email_id' => $request->email_id,
            'company_established_from' => $request->company_established_from,
            'company_logo' => $logoPath ?? null,
            'signature' => $signaturePath ?? null,
            'created_at' => \DB::raw('NOW()'),
            'updated_at' => \DB::raw('NOW()'),
        ]);
   
   // Redirect or return a response indicating successful company creation

      return redirect(route('company_create'));
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
    public function edit(comp $id)
    {
        $result = $id;
        $currency_lists = crny::all();
        return view('superadmin.company.edit',compact('result','currency_lists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'company_name' => 'required',
            'address_line_one' => 'required',
            'currency_id' => 'required',
            'pincode' => 'required',
            'city' => 'required',
            'mobile_no' => 'required',
            'company_established_from' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the record to update in database1
        $company = comp::find($id);
        // Update the record with the new data
        $company->company_name = $request->company_name;
        $company->currency_id = $request->currency_id;
        $company->leagal_name = $request->legal_name;
        $company->gst_in = $request->gst_in;
        $company->gst_applicable_from = $request->gst_applicable_from;
        $company->type_of_organization = $request->type_of_organization;
        $company->address_line_one = $request->address_line_one;
        $company->address_line_two = $request->address_line_two;
        $company->country_id = $request->currency_id;
        $company->pincode = $request->pincode;
        $company->state = $request->state;
        $company->city = $request->city;
        $company->phone_no = $request->phone_no;
        $company->mobile_no = $request->mobile_no;
        $company->fax_no = $request->fax_no;
        $company->website = $request->website;
        $company->email_id = $request->email_id;
        $company->company_established_from = $request->company_established_from;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company_logos', 'public');
            $company->company_logo = $logoPath;
        }
        
        if ($request->hasFile('signature')) {
            $signaturePath = $request->file('signature')->store('company_signatures', 'public');
            $company->signature = $signaturePath;
        }

        $company->save();

        \DB::connection('mysql_second')->table('companies')->where('id', $id)->update([
            'company_name' => $request->company_name,
            'currency_id' => $request->currency_id,
            'leagal_name' => $request->legal_name,
            'gst_in' => $request->gst_in,
            'gst_applicable_from' => $request->gst_applicable_from,
            'type_of_organization' => $request->type_of_organization,
            'address_line_one' => $request->address_line_one,
            'address_line_two' => $request->address_line_two,
            'country_id' => $request->currency_id,
            'pincode' => $request->pincode,
            'state' => $request->state,
            'city' => $request->city,
            'phone_no' => $request->phone_no,
            'mobile_no' => $request->mobile_no,
            'fax_no' => $request->fax_no,
            'website' => $request->website,
            'email_id' => $request->email_id,
            'company_established_from' => $request->company_established_from,
            'signature' => $signaturePath ?? $company->signature, // Use the updated signature path or the existing one
            'company_logo' => $logoPath ?? $company->company_logo, // Use the updated logo path or the existing one
            'updated_at' => now(),
        ]);


        return redirect(route('company_create'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         // Delete record from table1 in db1
         \DB::connection('mysql')->table('companies')->where('id', $id)->delete();

         // Delete record from table2 in db2
         \DB::connection('mysql_second')->table('companies')->where('id', $id)->delete();

		return redirect(route('company_list'));
    }
}
