
@extends('superadmin.layouts.app')

@section('content')
<!-- start main content section -->
<div x-data="sales">
                        <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="{{ url('user') }}" class="text-primary hover:underline">User</a>
                            </li>
                            <!-- <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span>Sales</span>
                            </li> -->
                        </ul>

                        <div class="pt-5">
                            

						<form class="form-horizontal"  id="add_user" name="add_user" action="{{ url('user') }}" method="POST" enctype="multipart/form-data">
					@csrf
						<div class="form-body">
				
							<div class="row">
								<div class="form-group col-sm-4">
									<label for="name">Name<span style="color: #EB2D30">*</span> </label>
										<input type="text" id="name" value="{{old('name')}}"  class="form-control form_element" placeholder="" name="name" autocomplete="off">
										@error('name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-4">
									<label for="email">Email <span style="color: #EB2D30">*</span> </label>
										<input type="email" id="email" value="{{old('email')}}" class="form-control form_element" placeholder="" name="email" autocomplete="off">
										@error('email')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div>
                                <div class="form-group col-sm-4">
									<label for="phone_no">Phone <span style="color: #EB2D30">*</span> </label>
										<input type="text" id="phone_no" value="{{old('phone_no')}}" class="form-control form_element" placeholder="" name="phone_no" autocomplete="off">
										@error('phone_no')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div>
								<!-- <div class="form-group col-sm-4">
									<label for="ad_currency_id">Currency <span style="color: #EB2D30">*</span> </label>
										<select id='ad_currency_id' name='ad_currency_id' class='form-control form-element'>
										<option value="">Select</option>
											@foreach($currency_lists as $currency_list)
											  <option value='{{ $currency_list->id }}'>{{ $currency_list->code}}</option>
											@endforeach
										</select>
										@error('ad_currency_id')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> -->
								<div class="form-group col-sm-4">
									<label for="user_name">Username <span style="color: #EB2D30">*</span> </label>
										<input type="text" id="user_name" value="{{old('user_name')}}" class="form-control form_element" placeholder="" name="user_name" autocomplete="off">
										@error('user_name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div>
								<div class="form-group col-sm-4">
									<label for="password">Password <span style="color: #EB2D30">*</span> </label>
										<input type="password" id="password" value="{{old('password')}}" class="form-control form_element" placeholder="" name="password" autocomplete="off">
										@error('password')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div>
								<div class="form-group col-sm-4">
									<label for="address">Address<span style="color: #EB2D30">*</span> </label>
										<textarea class='form-control form-element' name='address' id='address'>{{old('address')}}</textarea>
										@error('address')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div>
                                <div class="form-group col-4 mb-2">
                                                        <label for="userinput5"><b><u>Set Permissions</u></b></label>
                                                      <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="check1" name="op_edit"  checked>
                                                        <label class="form-check-label">Edit</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="check1" name="op_delete"  checked>
                                                        <label class="form-check-label">Delete</label>
                                                    </div>
                                                    </div>
								
							</div>
							
							<div class="row" style="margin-top: 1%;">
								<div class="form-group col-sm-2">
										<button type="reset" onclick="myFunction()" class="btn btn-danger mt-6"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp; Reset </button>
										
									</div>
									<div class="form-group col-sm-8"></div>
									<div class="form-group col-sm-2">
										
										<button type="submit" name="sbt"  class="btn btn-primary mt-6">Create&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
									</div>
								
								
							</div>

                        </div>
                </form> 

                        </div>
    </div>
                    <!-- end main content section -->


@endsection
