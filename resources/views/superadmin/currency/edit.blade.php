@extends('superadmin.layouts.app')

@section('content')
<div class="container">
<div class='row'>
		<div class='col-sm-1'></div>
		<div class='col-sm-10'>
        <div class="row">
		<div class="col-sm-3"><button class='btn cmn_btn'>Currency</button></div>
		<div class="col-sm-2"></div>
		<div class="col-sm-5" style="text-align: right;"><a href="{{ url('currency') }}" ><button type="button" name="btn" class="btn btn_sbt">List</button></a></div>
		<div class="col-sm-2"></div>
	</div>
	<div class="row pt-4">
	
		<div class="col-sm-12 tbl_div div_form cmn_div">
		
			
        <form class="form-horizontal"  id="edit_currency" name="edit_currency" action="{{ route('currency_update',$result->id) }}" method="POST" enctype="multipart/form-data">

@csrf

                                            <div class="form-body">
                                   
                                                <div class="row">
                                                    <div class="form-group col-sm-4">
                                                        <label for="country">Country<span style="color: #EB2D30">*</span> </label>
                                                            <input type="text" id="country" value="{{ old('country') ? old('country') : $result->country }}" class="form-control form_element" placeholder="" name="country" autocomplete="off">
                                                            @error('country')
                                                             <small class='text-danger'>{{ $message }}</small>
                                                            @enderror
                                                    </div> 
                                                    <div class="form-group col-sm-4">
                                                        <label for="currency">Currency <span style="color: #EB2D30">*</span> </label>
                                                            <input type="text" id="currency" value="{{ old('currency') ? old('currency') :  $result->currency }}" class="form-control form_element" placeholder="" name="currency" autocomplete="off">
                                                            @error('currency')
                                                             <small class='text-danger'>{{ $message }}</small>
                                                            @enderror
                                                    </div>
                                                   <div class="form-group col-sm-4">
                                                        <label for="code">Code<span style="color: #EB2D30">*</span> </label>
                                                            <input type="text" id="code" value="{{ old('code') ? old('code') :  $result->code }}" class="form-control form_element" placeholder="" name="code" autocomplete="off">
                                                            @error('code')
                                                             <small class='text-danger'>{{ $message }}</small>
                                                            @enderror
                                                    </div>
                                                   
                                                </div>
                                                
                                                   <div class="row" style="margin-top: 1%;">
                                                   <div class="form-group col-sm-4">
                                                      <button type="reset" onclick="myFunction()" class="btn btn_reset"><i class="fa fa-refresh" aria-hidden="true"></i> Reset </button>
                                                      &nbsp;<button type="submit" name="sbt"  class="btn btn_sbt">Update <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                                    </div>
                                                    
                                                    
                                                </div>

                                             

                                           </div>


                                        </form> 
		
		</div>
	
	  
		
	</div>
        </div>
        <div class='col-sm-1'></div>
</div>
</div>
@endsection
