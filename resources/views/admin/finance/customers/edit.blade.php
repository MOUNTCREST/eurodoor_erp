
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->

						<!-- <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="{{ route('customer_list')}}" class="text-primary hover:underline">Suppliers</a>
                            </li>
                            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span><a href="{{ route('customer_create')}}" class="text-primary hover:underline">Create</a></span>
                            </li>
                        </ul> -->

                        <h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Customers</h5>
                        <div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="edit_customer" name="edit_customer" action="{{ route('customer_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
						    <label for="customer_name">Name<span style="color: #EB2D30">*</span> </label>
							<input type="text" id="customer_name" value="{{old('customer_name') ? old('customer_name') : $result->customer_name}}"  class="form-input" placeholder="" name="customer_name" autocomplete="off">
										@error('customer_name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
						</div>
                        <div>
							<label for="mobile_no">Phone No</label>
							<input type="number" id="mobile_no" value="{{old('mobile_no') ? old('mobile_no') : $result->mobile_no}}"  class="form-input" placeholder="" name="mobile_no" autocomplete="off">
						</div>
						
                       
					</div>


                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                    <div >
							<label for="Code">Email Id</label>
							<input type="email" id="email_id" value="{{old('email_id') ? old('email_id') : $result->email_id}}" class="form-input" placeholder="" name="email_id" autocomplete="off">
						</div>
                    <div>
							<label for="Code">Code</label>
							<input type="text" id="code" value="{{old('code') ? old('code') : $result->code}}" class="form-input" placeholder="" name="code" autocomplete="off">
						</div>
                        
                    
                </div>


                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label for="gst_no">Gst No</label>
                        <input type="number" id="gst_no" value="{{old('gst_no') ? old('gst_no') : $result->gst_no}}"  class="form-input" placeholder="" name="gst_no" autocomplete="off">
                    </div>
                    <div>
                    <label for="gst_no">Credit Limit</label>
                        <input type="number" id="credit_limit" value="{{old('credit_limit') ? old('credit_limit') : $result->credit_limit}}" class="form-input" placeholder="" name="credit_limit" autocomplete="off">
                    </div>
                    <div>
                    <label for="discount">Discount %</label>
                        <input type="number" id="discount" value="{{old('discount') ? old('discount') : $result->discount}}"  class="form-input" placeholder="" name="discount" autocomplete="off">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
						    <label for="permenant_address">Permanent Address </label>
                            <textarea
                                            id="permenant_address"
                                            name="permenant_address"
                                            class="form-textarea min-h-[130px]"
                                            placeholder=""
                                        
                                        >{{old('permenant_address') ? old('permenant_address') : $result->permenant_address}}</textarea>
						</div>
                        <div>
							<label for="contact_address">Contact Address</label>
                            <textarea
                                            id="contact_address"
                                            name="contact_address"
                                            class="form-textarea min-h-[130px]"
                                            placeholder=""
                                         
                                        >{{old('contact_address') ? old('contact_address') : $result->contact_address}}</textarea>
						</div>
						
                       
					</div>

					<div class="grid grid-cols-1 sm:grid-cols-6 gap-4">
                    <div>
							<label for="web_address">Web Address</label>
							<input type="text" id="web_address" value="{{old('web_address') ? old('web_address') : $result->web_address}}" class="form-input" placeholder="" name="web_address" autocomplete="off">
						</div>
                        <div style="display:none">
						<label for="country">Country</label>
						<select id='country' name='country' class='form-input'>
											<option val=''>Select</option>
                                            @foreach ($currency_lists as $row)
                                                <option value="{{ $row->id; }}" {{ $row->id == 1 ? 'selected' : '' }}>{{ $row->code; }}</option>
                                            @endforeach
										</select>
					</div>

                    <div>
							<label for="remarks">Remarks</label>
                            <textarea
                                            id="remarks"
                                            name="remarks"
                                            class="form-textarea min-h-[130px]"
                                            placeholder=""
                                          
                                        >{{old('remarks') ? old('remarks') : $result->remarks}}</textarea>
						</div>
					
					</div>
                   

   

					<button type="submit" name="sbt" class="btn btn-primary !mt-6">Update&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						
                </form> 
	
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')

@endsection