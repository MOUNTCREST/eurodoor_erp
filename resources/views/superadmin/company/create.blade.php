
@extends('superadmin.layouts.app')

@section('content')
<!-- start main content section -->
<div x-data="sales">
                        <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="javascript:;" class="text-primary hover:underline">Company</a>
                            </li>
                            <!-- <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span>Sales</span>
                            </li> -->
                        </ul>

                        <div class="pt-5">
                            

						<form class="form-horizontal"  id="add_company" name="add_company" action="{{ url('company') }}" method="POST" enctype="multipart/form-data">
					@csrf
						<div class="form-body">
				
							<div class="row">
								<div class="form-group col-sm-6">
									<label for="company_name">Company<span style="color: #EB2D30">*</span> </label>
										<input type="text" id="company_name" value="{{old('company_name')}}"  class="form-input" placeholder="" name="company_name" autocomplete="off">
										@error('company_name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
								<div class="form-group col-sm-6">
									<label for="legal_name">Legal Name<span style="color: #EB2D30"></span> </label>
										<input type="text" id="legal_name" value="{{old('legal_name')}}"  class="form-input" placeholder="" name="legal_name" autocomplete="off">
										
								</div> 
								<div class="form-group col-sm-6">
									<label for="gst_in">GST IN<span style="color: #EB2D30"></span> </label>
										<input type="text" id="gst_in" value="{{old('gst_in')}}"  class="form-input" placeholder="" name="gst_in" autocomplete="off">
										
								</div> 
								<div class="form-group col-sm-6">
									<label for="gst_applicable_from">GST Applicable From<span style="color: #EB2D30"></span> </label>
										<input type="date" id="gst_applicable_from" value="{{old('gst_applicable_from')}}"  class="form-input" placeholder="" name="gst_applicable_from" autocomplete="off">
										
								</div> 
								<div class="form-group col-sm-6">
									<label for="type_of_organization">Type Of Organization<span style="color: #EB2D30"></span> </label>
										<input type="text" id="type_of_organization" value="{{old('type_of_organization')}}"  class="form-input" placeholder="" name="type_of_organization" autocomplete="off">
										
								</div> 
								<div class="form-group col-sm-12">
									<h1><b>Primary Details</b></h1>
								</div>
								<div class="form-group col-sm-6">
									<label for="address_line_one">Address Line 1<span style="color: #EB2D30">*</span> </label>
										<input type="text" id="address_line_one" value="{{old('address_line_one')}}"  class="form-input" placeholder="" name="address_line_one" autocomplete="off">
										@error('address_line_one')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div>
								<div class="form-group col-sm-6">
									<label for="address_line_two">Address Line 2<span style="color: #EB2D30"></span> </label>
										<input type="text" id="address_line_two" value="{{old('address_line_two')}}"  class="form-input" placeholder="" name="address_line_two" autocomplete="off">
										
								</div>
								
								<div class="form-group col-sm-6">
									<label for="currency_id">Country <span style="color: #EB2D30">*</span> </label>
										<select id='currency_id' name='currency_id' class='form-input'>
										<option value="">Select</option>
											@foreach($currency_lists as $currency_list)
											  <option value='{{ $currency_list->id }}'>{{ $currency_list->country}}</option>
											@endforeach
										</select>
										@error('currency_id')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div>
								<div class="form-group col-sm-6">
									<label for="pincode">Pincode <span style="color: #EB2D30">*</span> </label>
										<input type="text" id="pincode" value="{{old('pincode')}}" class="form-input" placeholder="" name="pincode" autocomplete="off">
										@error('pincode')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div>
								<div class="form-group col-sm-6">
									<label for="state">State <span style="color: #EB2D30"></span> </label>
										<input type="text" id="state" value="{{old('state')}}" class="form-input" placeholder="" name="state" autocomplete="off">
										
								</div>
								<div class="form-group col-sm-6">
									<label for="city">City <span style="color: #EB2D30">*</span> </label>
										<input type="text" id="city" value="{{old('city')}}" class="form-input" placeholder="" name="city" autocomplete="off">
										@error('city')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div>
								<div class="form-group col-sm-12">
									<h1><b>Contact Details</b></h1>
								</div>
								<div class="form-group col-sm-6">
									<label for="phone_no">Phone <span style="color: #EB2D30"></span> </label>
										<input type="text" id="phone_no" value="{{old('phone_no')}}" class="form-input" placeholder="" name="phone_no" autocomplete="off">
										
								</div>
								<div class="form-group col-sm-6">
									<label for="mobile_no">Mobile No <span style="color: #EB2D30">*</span> </label>
										<input type="text" id="mobile_no" value="{{old('mobile_no')}}" class="form-input" placeholder="" name="mobile_no" autocomplete="off">
										@error('mobile_no')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div>
								<div class="form-group col-sm-6">
									<label for="fax_no">Fax No <span style="color: #EB2D30"></span> </label>
										<input type="text" id="fax_no" value="{{old('fax_no')}}" class="form-input" placeholder="" name="fax_no" autocomplete="off">
										
								</div>
								<div class="form-group col-sm-6">
									<label for="email_id">Email ID <span style="color: #EB2D30"></span> </label>
										<input type="email" id="email_id" value="{{old('email_id')}}" class="form-input" placeholder="" name="email_id" autocomplete="off">
										
								</div>
								<div class="form-group col-sm-6">
									<label for="website">Website <span style="color: #EB2D30"></span> </label>
										<input type="text" id="website" value="{{old('website')}}" class="form-input" placeholder="" name="website" autocomplete="off">
										
								</div>
								<div class="form-group col-sm-6">
									<label for="company_established_from">Company Established From <span style="color: #EB2D30">*</span> </label>
										<input type="date" id="company_established_from" value="{{old('company_established_from')}}" class="form-input" placeholder="" name="company_established_from" autocomplete="off">
										@error('company_established_from')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div>
								<div class="form-group col-sm-6 imgUp">


								<div class="imagePreview"></div>
									<label class="btn btn-primary">
									Company Logo<input type="file" name="logo" id="logo" class="uploadFile img" value="Company Logo" style="width: 0px;height: 0px;overflow: hidden;">
									</label>


									<!-- <label for="company_logo">Company Logo<span style="color: #EB2D30"></span> </label>
										<input type="file" id="logo"  class="form-input" placeholder="" name="logo" autocomplete="off"> -->
										
								</div>
								<div class="form-group col-sm-6">
									<label for="signature">Signature <span style="color: #EB2D30"></span> </label>
										<input type="file" id="signature" class="form-input" placeholder="" name="signature" autocomplete="off">
										
								</div>
							</div>
							
								<div class="row" style="margin-top: 1%;">
								<div class="form-group col-sm-2">
									<button type="reset" onclick="myFunction()" class="btn btn-danger mt-6"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp; Reset </button>
									
								</div>
								<div class="form-group col-sm-8"></div>
								<div class="form-group col-sm-2">
									
									<button type="submit" name="sbt"  class="btn btn-primary mt-6">Create &nbsp;<i class="fa fa-check-circle" aria-hidden="true"></i></button>
								</div>
								
							</div>

                        </div>
                </form> 

                      
                                

                                
                            

                        </div>
    </div>
                    <!-- end main content section -->


@endsection
